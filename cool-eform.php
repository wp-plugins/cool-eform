<?php
/**
 * Plugin Name: Cool eForm
 * Plugin URI: https://bitbucket.org/coolpages/cool-eform
 * Description: Easy-to-use contact form sending data to email.
 * Version: 0.2.1
 * Author: CoolPages
 * Author URI: http://www.coolpages.cz
 * Text Domain: cef
 * Domain Path: /languages/
 * License: GPL2
 */

// Block direct access to the plugin file
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WPCEF_PLUGIN_VERSION', '0.2.1' );

define( 'WPCEF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'WPCEF_SETTINGS_GENERAL', 'cef_general' );

define( 'WPCEF_SETTINGS_FIELDS', 'cef_fields' );

require_once WPCEF_PLUGIN_DIR . '/helpers.php';

if ( !class_exists( 'WP_Cool_EForm' ) ) {

    class WP_Cool_EForm {

        private $errors = array();

        /**
         * Construct the plugin object.
         */
        public function __construct() {
            add_action( 'init', array( &$this, 'load_textdomain' ) );
            add_action( 'init', array( &$this, 'process_form' ) );
            add_action( 'wp_enqueue_scripts', array( &$this, 'add_styles_and_js' ) );
            add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
            add_action( 'admin_init', array( &$this, 'init_admin' ) );
        }

        /**
         * Activate the plugin.
         */
        public static function activate() {
            if ( !current_user_can( 'activate_plugins' ) ) {
                return;
            }

            $defaults = array(
                'message' => array(
                    'used' => 1,
                    'mandatory' => 1,
                ),
                'antispam' => array(
                    'mandatory' => 1,
                )
            );
            add_option( WPCEF_SETTINGS_FIELDS, $defaults );
        }

        /**
         * Deactivate the plugin.
         */
        public static function deactivate() {
            if ( !current_user_can( 'activate_plugins' ) ) {
                return;
            }
            delete_option( WPCEF_SETTINGS_GENERAL );
            delete_option( WPCEF_SETTINGS_FIELDS );
        }

        /**
         * Load plugin textdomain.
         */
        public function load_textdomain() {
            $locale = get_locale();

            $locale = apply_filters( 'plugin_locale', $locale, 'cef' );

            // Look in the WordPress languages directory for translations first
            // No need for the user to attach to any hooks in the code, and no problems during a plugin update
            load_textdomain( 'cef', WP_LANG_DIR . '/cool-eform/cef-' . $locale . '.mo' );

            load_plugin_textdomain( 'cef', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        }

        /**
         * Add required CSS styles and JavaScript files.
         */
        public function add_styles_and_js() {
            wp_enqueue_style( 'cool-eform', plugins_url( 'css/cool-eform.css', __FILE__ ), array(), WPCEF_PLUGIN_VERSION );
            wp_enqueue_script( 'jquery-validation', plugins_url( 'js/jquery.validate.min.js', __FILE__ ), array( 'jquery' ), '1.13.1' );
        }

        /**
         * Hook into WP's admin_init action hook.
         */
        public function init_admin() {
            $this->init_settings();
        }

        /**
         * Initialize the settings.
         */
        private function init_settings() {
            register_setting( 'cool_eform', WPCEF_SETTINGS_GENERAL, array( &$this, 'sanitize_general_settings' ) );
            register_setting( 'cool_eform', WPCEF_SETTINGS_FIELDS, array( &$this, 'sanitize_fields_settings' ) );
        }

        /**
         * Sanitize general settings.
         */
        public function sanitize_general_settings( $settings ) {
            $valid = get_option( WPCEF_SETTINGS_GENERAL );

            $valid['from_name'] = trim( $settings['from_name'] );

            $from_address = trim( $settings['from_address'] );
            if ( is_email( $from_address ) ) {
                $valid['from_address'] = $from_address;
            } else {
                add_settings_error(
                    'general-settings-error',
                    'invalid-from-address',
                    __( 'The "From" Address value did not appear to be a valid email address. Please enter a valid email address.', 'cef' )
                );
            }

            $to_address = trim( $settings['to_address'] );
            if ( is_email( $to_address ) ) {
                $valid['to_address'] = $to_address;
            } else {
                add_settings_error(
                    'general-settings-error',
                    'invalid-to-address',
                    __( 'The "To" Address value did not appear to be a valid email address. Please enter a valid email address.', 'cef' )
                );
            }

            $subject = sanitize_text_field( $settings['subject'] );
            if ( !empty( $subject ) ) {
                $valid['subject'] = $subject;
            } else {
                add_settings_error(
                    'general-settings-error',
                    'invalid-subject',
                    __( 'The Subject value is required.', 'cef' )
                );
            }

            return $valid;
        }

        /**
         * Sanitize fields settings.
         */
        public function sanitize_fields_settings( $settings ) {
            return $settings;
        }

        /**
         * Add admin menu.
         */
        public function add_admin_menu() {
            add_options_page(
                __( 'eForm', 'cef' ),
                __( 'eForm', 'cef' ),
                'manage_options',
                'cool-eform-settings',
                array( &$this, 'render_settings_page' )
            );
        }

        /**
         * Render settings admin page.
         */
        public function render_settings_page() {
            if ( !current_user_can( 'manage_options' ) ) {
                wp_die( __( 'You do not have sufficient permissions to access this page.', 'cef' ) );
            }

            include( WPCEF_PLUGIN_DIR . '/templates/settings.php' );
        }

        /**
         * Render the contact form based on the plugin settings.
         */
        public function render_form() {
            include( WPCEF_PLUGIN_DIR . '/templates/form.php' );
        }

        /**
         * Process submitted form and send email.
         */
        public function process_form() {
            $submitted = cef_get_param_value( 'cef-sent' );
            if ( !empty( $submitted ) ) {

                $nonce = cef_get_param_value( 'cef-nonce' );
                if ( !wp_verify_nonce( $nonce, 'sent' ) ) {
                    $this->errors['form'] = __( 'The form is invalid. Please try again.', 'cef' );
                    return;
                }

                $this->validate( $_POST );
                if ( !empty( $this->errors ) ) {
                    return;
                }

                $general_settings = get_option( WPCEF_SETTINGS_GENERAL );

                $from_name = $this->get_from_name( $general_settings['from_name'] );
                $from_address = $general_settings['from_address'];
                $to_address = $general_settings['to_address'];
                $subject = $this->get_subject( $_POST, $general_settings['subject'] );
                $content = $this->get_content( $_POST );

                $headers[] = "From: {$from_name} <{$from_address}>";
                $headers[] = 'Content-Type: text/html; charset=UTF-8';

                $sent = wp_mail( $to_address, $subject, $content, $headers );
                if ( !$sent ) {
                    $message1 = __( 'An error has occured while sending the form.', 'cef' );
                    $message2 = __( 'Please try it later or send the message directly to %s.', 'cef' );
                    $this->errors['form'] = $message1 . ' ' . sprintf( $message2, $to_address );
                    return;
                }

                wp_safe_redirect( cef_get_param_value( 'cef-referrer' ) );
                exit();
            }
        }

        private function validate( $values ) {
            $this->errors = array();

            $fields = get_option( WPCEF_SETTINGS_FIELDS );
            foreach ( $fields as $name => $meta ) {
                if ( isset( $meta['used'] ) && $meta['used'] ) {

                    $field_value = trim( $values[ 'cef-' . $name] );

                    if ( isset( $meta['mandatory'] ) && $meta['mandatory'] ) {

                        if ( empty( $field_value ) ) {
                            $this->errors[$name] = __( 'This field is required.', 'cef' );
                            continue;
                        }
                    }

                    if ( $name == 'email') {
                        if ( !is_email( $field_value ) ) {
                            $this->errors[$name] = __( 'Please enter a valid email address.', 'cef' );
                            continue;
                        }
                    }

                    if ( $name == 'antispam') {
                        $expected = trim( $values['cef-antispam-expected'] );
                        if ( $field_value <> $expected) {
                            $this->errors[$name] = __( 'Please enter the correct value.', 'cef' );
                            continue;
                        }
                    }
                }
            }
        }

        private function get_from_name( $from_name ) {
            return empty( $from_name ) ? 'eForm' : $from_name;
        }

        private function get_subject( $values, $default_subject ) {
            $subject = isset( $values['cef-subject'] ) ? trim( $values['cef-subject'] ) : '';
            if ( empty( $subject ) ) {
                return $default_subject;
            }
            return $subject;
        }

        private function get_content( $values ) {
            $content = '';
            if ( isset( $values['cef-name'] ) ) {
                $content .= $this->format_line( __( 'Name', 'cef' ), $values['cef-name'] );
            }
            if ( isset( $values['cef-email'] ) ) {
                $content .= $this->format_line( __( 'Email', 'cef' ), $values['cef-email'] );
            }
            if ( isset( $values['cef-phone'] ) ) {
                $content .= $this->format_line( __( 'Phone', 'cef' ), $values['cef-phone'] );
            }
            if ( isset( $values['cef-message'] ) ) {
                $content .= $this->format_line( __( 'Message', 'cef' ), $values['cef-message'] );
            }
            return $content;
        }

        private function format_line( $label, $value ) {
            return PHP_EOL . "<br><br><strong>{$label}:</strong> {$value}";
        }
    }

    register_activation_hook( __FILE__, array( 'WP_Cool_EForm', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WP_Cool_EForm', 'deactivate' ) );

    $wp_cool_eform = new WP_Cool_EForm();
}

?>

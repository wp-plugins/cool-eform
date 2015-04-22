<?php

// Block direct access to the plugin file
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return the request parameter value with the specified name.
 *
 * @param string $param_name The request parameter name.
 * @return string The request parameter name or empty string if not available.
 */
function cef_get_param_value( $param_name ) {
    return isset( $_REQUEST[$param_name] ) ? $_REQUEST[$param_name] : '';
}

/**
 * Return the relative URL of the current WordPress page including query parameters.
 *
 * @return string The relative URL of the current WordPress page including query parameters.
 */
function cef_get_current_url() {
    return $_SERVER['REQUEST_URI'];
}

/**
 * Return if the field with the specified name is used.
 *
 * @param array $fields The fields data.
 * @param string $field_name The field name.
 * @return bool TRUE if the field is used, FALSE otherwise.
 */
function cef_is_field_used( $fields, $field_name ) {
    return isset( $fields[$field_name]['used'] ) && $fields[$field_name]['used'];
}

/**
 * Return the given symbol if the field is required.
 *
 * @param array $fields The fields data.
 * @param string $field_name The field name.
 * @param string $required_symbol Optional. The required symbol to return.
 * @return string The respective symbol if the field is required, empty string otherwise.
 */
function cef_required( $fields, $field_name, $required_symbol = '*' ) {
    echo isset( $fields[$field_name]['mandatory'] ) && $fields[$field_name]['mandatory'] ? $required_symbol : '';
}

?>

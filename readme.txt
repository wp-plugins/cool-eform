=== Cool eForm ===
Contributors: coolpages
Tags: contact, form, contact form, web form, email, send email
Author URI: http://wwww.coolpages.cz
Plugin URI: https://bitbucket.org/coolpages/cool-eform
Requires at least: 3.0
Tested up to: 4.1.1
Stable tag: 0.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy-to-use contact form sending data to an email. Use fields of your choice and let your visitors be in touch with you.

== Description ==

The Cool eForm is a simple plugin that enables you to create a contact form to stay in touch with your visitors. You do not have to bother with form validation or deal with internals of sending form data to an email, the Cool eForm handles all for you.

This is the first official release and we know that there is still a lot of work to do. Please be patient since our roadmap contains many additional features.

You can also follow the project on our BitBucket -  [CoolPages](https://bitbucket.org/coolpages/).

= Features =
* 6 basic fields
    * Name
    * Email
    * Phone
    * Subject
    * Message
    * Anti-spam
* Enable to select fields to use
* Enable to make fields mandatory/optional
* Client side validation
* Server side validation
* Anti-spam protection
* Translation ready
* Provide template tag to display the form anywhere in a theme
* Prevent from multiple submissions when the page is reloaded
* Responsive

= Translations =
* English (en_US)
* Czech (cs_CZ)

== Installation ==

Follow the below steps to install the Cool eForm plugin and get it working.

1. Download and unzip the plugin
1. Upload `cool-eform` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to 'Settings' menu in Wordpress and select 'eForm' to setup the plugin
1. Place `<?php if ( isset( $wp_cool_eform ) ) $wp_cool_eform->render_form(); ?>` in templates of your choice

== Screenshots ==

1. Plugin settings in WordPress admin panel.

2. The contact form.

== Changelog ==

= 0.1.1 =
* Fixed issue with loading the plugin text domain
* Added more specific CSS classes to the form fields

= 0.1.0 =
* Initial official release

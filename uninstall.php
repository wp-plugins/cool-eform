<?php
// If not called from WordPress admin, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'cef_general' );
delete_option( 'cef_fields' );

?>

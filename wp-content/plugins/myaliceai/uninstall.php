<?php
/**
 * MyAlice Uninstall
 */

// Direct file access is disallowed
defined( 'WP_UNINSTALL_PLUGIN' ) || die;

delete_option( 'myaliceai_api_data' );
delete_option( 'myaliceai_plugin_status' );

do_action( 'myalice_plugin_deleted' );
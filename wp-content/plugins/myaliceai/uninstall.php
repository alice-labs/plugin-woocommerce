<?php
/**
 * MyAlice Uninstall
 */

// Direct file access is disallowed
defined( 'WP_UNINSTALL_PLUGIN' ) || die;

delete_option( 'myaliceai_api_data' );
delete_option( 'myaliceai_plugin_status' );
delete_option( 'myaliceai_review_notice_time' );

do_action( 'myalice_plugin_deleted' );
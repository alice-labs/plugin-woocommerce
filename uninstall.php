<?php
/**
 * MyAlice Uninstall
 */

// Direct file access is disallowed
defined( 'WP_UNINSTALL_PLUGIN' ) || die;

delete_option( 'myaliceai_api_data' );
delete_option( 'myaliceai_settings' );
delete_option( 'myaliceai_plugin_status' );
delete_option( 'myaliceai_review_notice_time' );

// Plugin remove API
$alice_api_url = MYALICE_API_URL . 'remove-ecommerce-plugin?api_token=' . MYALICE_API_TOKEN;
wp_remote_post( $alice_api_url, array(
		'method'  => 'POST',
		'timeout' => 45,
		'cookies' => array()
	)
);

do_action( 'myalice_plugin_deleted' );
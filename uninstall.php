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
delete_option( 'myaliceai_wc_auth' );

$api_data = get_option( 'myaliceai_api_data' );
$api_data = wp_parse_args( $api_data, [ 'api_token' => '' ] );

// Plugin remove API
$alice_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/remove-ecommerce-plugin?api_token=' . $api_data['api_token'];
wp_remote_post( $alice_api_url, array(
		'method'  => 'POST',
		'timeout' => 45,
		'cookies' => array()
	)
);

do_action( 'myalice_plugin_deleted' );
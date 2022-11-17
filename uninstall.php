<?php
/**
 * MyAlice Uninstall
 */

// Direct file access is disallowed
defined( 'WP_UNINSTALL_PLUGIN' ) || die;

$api_data = get_option( 'myaliceai_api_data' );
$api_data = wp_parse_args( $api_data, [ 'api_token' => '' ] );

delete_option( 'myaliceai_api_data' );
delete_option( 'myaliceai_settings' );
delete_option( 'myaliceai_plugin_status' );
delete_option( 'myaliceai_review_notice_time' );
delete_option( 'myaliceai_wc_auth' );
delete_option( 'myaliceai_is_needed_migration' );
delete_option( 'myaliceai_customization_notice_dismiss' );

// Plugin remove API
$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/remove-woocommerce-integration?api_token=' . $api_data['api_token'];
wp_remote_post( $alice_api_url, array(
		'method'  => 'POST',
		'timeout' => 45,
		'cookies' => array()
	)
);

do_action( 'myalice_plugin_deleted' );
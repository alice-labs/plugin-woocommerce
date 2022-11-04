<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

function myalice_get_woocommerce_projects() {
	$wc_data = get_option( 'myaliceai_wc_auth' );
	if ( empty( $wc_data['consumer_key'] ) || empty( $wc_data['consumer_secret'] ) || empty( $wc_data['key_permissions'] ) ) {
		return [];
	}

	$myalice_api_data = get_option( 'myaliceai_api_data' );
	if ( empty( $myalice_api_data['email'] ) ) {
		return [];
	}

	if ( ! empty( $myalice_api_data['api_token'] ) ) {
		return [];
	}

	$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/available-woocommerce-projects';
	$body          = wp_json_encode( array(
		'store_url'       => home_url(),
		'consumer_key'    => $wc_data['consumer_key'],
		'consumer_secret' => $wc_data['consumer_secret'],
		'key_permissions' => $wc_data['key_permissions'],
		'email'           => $myalice_api_data['email'],
	) );

	$response = wp_remote_post( $alice_api_url, array(
		'method'  => 'POST',
		'timeout' => 45,
		'body'    => $body,
		'cookies' => array()
	) );

	if ( is_wp_error( $response ) ) {
		return [];
	} else {
		$alice_project_data = json_decode( $response['body'], true );

		if ( ! empty( $alice_project_data ) && $alice_project_data['success'] === true && ! empty( $alice_project_data['available_projects'] ) ) {
			return $alice_project_data['available_projects'];
		}

		return [];
	}
}

function myalice_get_dashboard_class() {
	$wc_auth = get_option( 'myaliceai_wc_auth' );
	if ( empty( $wc_auth ) ) {
		return '--needs-your-permission';
	}

	$api_data = get_option( 'myaliceai_api_data' );
	if ( empty( $api_data ) ) {
		return '--connect-with-myalice';
	}

	if ( empty( $api_data['api_token'] ) ) {
		return '--select-the-team';
	}

	return '--explore-myalice';
}

function myalice_is_email_registered() {
	$alice_api_data = get_option( 'myaliceai_api_data' );
	if ( empty( $alice_api_data['email'] ) ) {
		$current_user = wp_get_current_user();
		$body         = wp_json_encode( array(
			'email' => $current_user->user_email
		) );

		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/is-email-registered';
		$response      = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$alice_is_register_data = json_decode( $response['body'], true );

			return isset( $alice_is_register_data['is_registered'] ) ? $alice_is_register_data['is_registered'] : false;
		}
	}

	return false;
}

function myalice_get_current_user_email() {
	$current_user = wp_get_current_user();

	return $current_user->user_email;
}

function myalice_is_needed_migration() {
	if ( myalice_get_dashboard_class() === '--explore-myalice' ) {
		$body = wp_json_encode( array(
			'store_url' => site_url()
		) );

		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/is-using-new-live-chat';
		$response      = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( ! is_wp_error( $response ) ) {
			$response_body = json_decode( $response['body'], true );

			return isset( $response_body['is_using_new_live_chat'] ) && $response_body['is_using_new_live_chat'] === false;
		}
	}

	return false;
}
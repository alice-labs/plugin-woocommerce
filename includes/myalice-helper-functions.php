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
	$wc_auth   = get_option( 'myaliceai_wc_auth' );
	$wc_status = myalice_is_working_wcapi();
	if ( empty( $wc_auth ) || $wc_status['error'] === true ) {
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
	$body = wp_json_encode( array(
		'store_url' => site_url( '/' )
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
		$return        = isset( $response_body['is_using_new_live_chat'] ) && $response_body['is_using_new_live_chat'] === false;
		update_option( 'myaliceai_is_needed_migration', $return );

		return $return;
	}

	return false;
}

function myalice_is_working_wcapi( $force = false ) {
	$wc_api_status = get_transient( 'myaliceai_wc_api_status' );
	if ( ! empty( $wc_api_status ) && ! $force ) {
		return $wc_api_status;
	} else {
		$wc_auth         = get_option( 'myaliceai_wc_auth' );
		$consumer_key    = empty( $wc_auth['consumer_key'] ) ? '' : $wc_auth['consumer_key'];
		$consumer_secret = empty( $wc_auth['consumer_secret'] ) ? '' : $wc_auth['consumer_secret'];;
		$request_url     = site_url() . '/wp-json/wc/v3/settings';
		$result          = [ 'error' => false, 'message' => '', 'success' => false ];

		$request_url = add_query_arg( array(
			'consumer_key'    => $consumer_key,
			'consumer_secret' => $consumer_secret
		), $request_url );

		$response = wp_remote_get( $request_url );

		if ( is_wp_error( $response ) ) {
			$result['error']   = true;
			$result['message'] = $response->get_error_message();
		} else {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( $response['response']['code'] === 200 ) {
				$result['success'] = true;
			} else {
				$result['error']   = true;
				$result['message'] = $body['message'];
			}
		}

		set_transient( 'myaliceai_wc_api_status', $result, HOUR_IN_SECONDS );

		return $result;
	}
}
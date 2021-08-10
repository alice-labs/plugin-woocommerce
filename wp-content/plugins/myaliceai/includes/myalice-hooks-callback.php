<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

//Alice API form ajax callback
function alice_api_form_process() {
	if ( check_ajax_referer( 'alice-api-form', 'alice-api-form' ) ) {
		$api_key = empty( $_POST['alice_plugin_key'] ) ? '' : $_POST['alice_plugin_key'];
		if ( empty( $api_key ) ) {
			delete_option( 'myaliceai_api_data' );

			wp_send_json_error( [ 'message' => 'Your API data was removed because of provided empty field.' ] );
		}

		$alice_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/connect-ecommerce-plugin?api_token=' . $api_key;
		$response      = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			wp_send_json_error( [ 'message' => "Something went wrong: {$error_message}" ] );
		} else {
			$alice_api_data = json_decode( $response['body'], true );

			if ( $alice_api_data['success'] === true ) {
				update_option( 'myaliceai_api_data', [
					'api_token'   => $alice_api_data['api_token'],
					'platform_id' => $alice_api_data['platform_id'],
					'primary_id'  => $alice_api_data['primary_id']
				] );

				wp_send_json_success( [
					'message'     => __( 'Your API token is valid and successfully updated.', 'myaliceai' ),
					'platform_id' => $alice_api_data['platform_id'],
					'primary_id'  => $alice_api_data['primary_id']
				] );
			} else {
				wp_send_json_error( [ 'message' => $alice_api_data['error'] ] );
			}

		}
	}
}

// Link Logged In Customer API to the alice customer ID
function alice_customer_link_handler() {
	$alice_customer_id = $_COOKIE["aliceCustomerId"];
	$current_user_id   = get_current_user_id();

	// API Calling
	$alice_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/link-customer?api_token=' . MYALICE_API_TOKEN;

	$body = array(
		'alice_customer_id'    => (int) $alice_customer_id,
		'ecommerce_account_id' => (string) $current_user_id,
	);

	wp_remote_post( $alice_api_url, array(
			'method'  => 'POST',
			'timeout' => 45,
			'body'    => $body,
			'cookies' => array()
		)
	);
}

// Store Customer Product API
function alice_user_product_view_handler() {
	global $product;

	//User Data
	$alice_customer_id = $_COOKIE["aliceCustomerId"];

	// API URL
	$alice_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/store-product-view?api_token=' . MYALICE_API_TOKEN;

	$body = wp_json_encode( array(
		'alice_customer_id' => $alice_customer_id,
		'product'           => array(
			'product_id'     => $product->get_id(),
			'product_name'   => $product->get_name(),
			'product_link'   => get_permalink( $product->get_id() ),
			'product_images' => array( get_the_post_thumbnail_url() ),
			'unit_price'     => floatval( $product->get_price() ),
		),
	) );

	// API Calling
	wp_remote_post( $alice_api_url, array(
			'method'  => 'POST',
			'timeout' => 45,
			'body'    => $body,
			'cookies' => array()
		)
	);
}

// Store Customer Cart API (Done)
function alice_user_cart_api_handler( $updated ) {
	//User Data
	$alice_customer_id = $_COOKIE["aliceCustomerId"];

	// initializing the array:
	$items = array();
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		$productImage = wp_get_attachment_image_url( $cart_item['data']->image_id, 'full' );
		$items[]      = array(
			'product_id'     => $cart_item['product_id'],
			'variant_id'     => $cart_item['variation_id'],
			'product_name'   => $cart_item['data']->name,
			'product_link'   => get_permalink( $cart_item['product_id'] ),
			'product_images' => [ $productImage ],
			'quantity'       => absint( $cart_item['quantity'] ),
			'unit_price'     => floatval( $cart_item['data']->price ),
			'total_cost'     => floatval( ( $cart_item['quantity'] ) * ( $cart_item['data']->price ) ),
			'timestamp'      => current_time( 'U' ),
		);
	}

	// API URL
	$alice_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/update-cart?api_token=' . MYALICE_API_TOKEN;
	$body       = wp_json_encode( array(
		'alice_customer_id' => $alice_customer_id,
		'cart_products'     => $items,
	) );

	// API Calling
	wp_remote_post( $alice_api_url, array(
			'method'  => 'POST',
			'timeout' => 45,
			'body'    => $body,
			'cookies' => array()
		)
	);

	//we use this callback for a filter (woocommerce_update_cart_action_cart_updated) so we have to return
	return $updated;
}
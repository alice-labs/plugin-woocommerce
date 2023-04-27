<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

//Alice Settings form ajax callback
function alice_settings_form_process() {
	if ( check_ajax_referer( 'alice-settings-form', 'alice-settings-form' ) ) {
		$POST = array_map( 'sanitize_text_field', $_POST );
		$args = wp_parse_args( $POST, [
			'allow_chat_user_only'   => false,
			'allow_product_view_api' => false,
			'allow_cart_api'         => false,
			'hide_chatbox'           => false
		] );

		$settings = [
			'allow_chat_user_only'   => $args['allow_chat_user_only'] === false ? 0 : 1,
			'allow_product_view_api' => $args['allow_product_view_api'] === false ? 0 : 1,
			'allow_cart_api'         => $args['allow_cart_api'] === false ? 0 : 1,
			'hide_chatbox'           => $args['hide_chatbox'] === false ? 0 : 1
		];

		if ( update_option( 'myaliceai_settings', $settings, false ) ) {
			wp_send_json_success( [ 'message' => __( 'Settings successfully updated.', 'myaliceai' ) ] );
		} else {
			wp_send_json_error( [ 'message' => __( 'Settings update failed.', 'myaliceai' ) ] );
		}
	}
}

//Alice's deactivation feedback form ajax callback
function alice_feedback_form_process() {
	if ( check_ajax_referer( 'alice_deactivation_feedback', 'alice_deactivation_feedback' ) ) {
		$feedback = empty( $_POST['feedback'] ) ? '' : sanitize_text_field( $_POST['feedback'] );

		if ( $feedback === 'Other' ) {
			$feedback = empty( $_POST['feedback_other'] ) ? $feedback : sanitize_text_field( $_POST['feedback_other'] );
		}

		if ( ! empty( $feedback ) ) {
			$alice_api_url = MYALICE_API_URL . 'deactivate-ecommerce-plugin?api_token=' . MYALICE_API_TOKEN;
			wp_remote_post( $alice_api_url, array(
					'method'  => 'POST',
					'timeout' => 45,
					'body'    => [
						'feedback' => $feedback,
					],
					'cookies' => array()
				)
			);
		}

		wp_send_json_success();
	}
}

// Link Logged In Customer API to the alice customer ID
function alice_customer_link_handler() {
	if ( empty( $_COOKIE["aliceCustomerId"] ) ) {
		return;
	}

	$alice_customer_id   = sanitize_text_field( $_COOKIE["aliceCustomerId"] );
	$current_user_id     = get_current_user_id();
	$customer_api_cookie = "C{$alice_customer_id}U{$current_user_id}";

	if ( isset( $_COOKIE[ $customer_api_cookie ] ) && $_COOKIE[ $customer_api_cookie ] == 1 ) {
		return;
	}

	// API Calling
	$alice_api_url = MYALICE_API_URL . 'link-customer?api_token=' . MYALICE_API_TOKEN;

	$body = array(
		'alice_customer_id'    => (int) $alice_customer_id,
		'ecommerce_account_id' => (string) $current_user_id,
	);

	$response = wp_remote_post( $alice_api_url, array(
			'method'  => 'POST',
			'timeout' => 45,
			'body'    => $body,
			'cookies' => array()
		)
	);

	if ( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && $response['response']['code'] == 200 ) {
		setcookie( $customer_api_cookie, true, time() + HOUR_IN_SECONDS, '/' );
	}
}

// Store Customer Product API
function alice_user_product_view_handler() {
	global $product;

	if ( empty( $_COOKIE["aliceCustomerId"] ) ) {
		return;
	}

	//User Data
	$alice_customer_id = sanitize_text_field( $_COOKIE["aliceCustomerId"] );

	// API URL
	$alice_api_url = MYALICE_API_URL . 'store-product-view?api_token=' . MYALICE_API_TOKEN;

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
	if ( empty( $_COOKIE["aliceCustomerId"] ) ) {
		return;
	}

	//User Data
	$alice_customer_id = sanitize_text_field( $_COOKIE["aliceCustomerId"] );

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
	$alice_api_url = MYALICE_API_URL . 'update-cart?api_token=' . MYALICE_API_TOKEN;
	$body          = wp_json_encode( array(
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

function alice_review_admin_notice() { ?>
    <div class="notice notice-info">
        <p><?php esc_html_e( "We hope you're enjoying MyAlice! Could you please do us a BIG favor and give it a 5-star rating on WordPress to help us spread the word and boost our motivation?", 'myaliceai' ); ?></p>
        <p>
            <a href="https://wordpress.org/support/plugin/myaliceai/reviews/?filter=5#new-post" target="_blank"><?php esc_html_e( 'Ok, you deserve it', 'myaliceai' ); ?></a>
            <br>
            <a href="#" class="myalice-notice-dismiss"><?php esc_html_e( 'Nope, maybe later', 'myaliceai' ); ?></a>
            <br>
            <a href="#" class="myalice-notice-dismiss"><?php esc_html_e( 'I already did', 'myaliceai' ); ?></a>
        </p>
    </div>
	<?php
}

function myalice_review_notice_dismiss() {
	update_option( 'myaliceai_review_notice_time', current_time( 'U' ) + YEAR_IN_SECONDS * 100 );
	wp_send_json_success();
}

// Customization notice dismiss action
function myalice_customization_notice_dismiss() {
	update_option( 'myaliceai_customization_notice_dismiss', true );
	wp_send_json_success();
}

function alice_login_form_process() {
	if ( check_ajax_referer( 'myalice-form-process', 'myalice-nonce' ) ) {
		$user_email = empty( $_POST['user_email'] ) ? '' : sanitize_text_field( $_POST['user_email'] );
		$password   = empty( $_POST['password'] ) ? '' : sanitize_text_field( $_POST['password'] );

		if ( empty( $user_email ) || empty( $password ) ) {
			wp_send_json_error( [ 'message' => __( 'Please fill up all required field', 'myaliceai' ) ] );
		}

		$wc_data = get_option( 'myaliceai_wc_auth' );
		if ( empty( $wc_data['consumer_key'] ) || empty( $wc_data['consumer_secret'] ) || empty( $wc_data['key_permissions'] ) ) {
			wp_send_json_error( [ 'message' => __( 'MyAlice needs your permission to work. Please Grant Permission First.', 'myaliceai' ) ] );

		}

		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/login-and-connect-woocommerce';
		$body          = wp_json_encode( array(
			'store_url'       => site_url( '/' ),
			'consumer_key'    => $wc_data['consumer_key'],
			'consumer_secret' => $wc_data['consumer_secret'],
			'key_permissions' => $wc_data['key_permissions'],
			'email'           => $user_email,
			'password'        => $password,
		) );

		$response = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			wp_send_json_error( [ 'message' => "Something went wrong: {$error_message}" ] );
		} else {
			$alice_api_data = json_decode( $response['body'], true );

			if ( ! empty( $alice_api_data ) && $alice_api_data['success'] === true ) {
				if ( $alice_api_data['is_auto_connected'] === true && ! empty( $alice_api_data['ecommerce_data'] ) ) {
					update_option( 'myaliceai_api_data', [
						'api_token'   => $alice_api_data['ecommerce_data']['api_token'],
						'platform_id' => absint( $alice_api_data['ecommerce_data']['webchat_channel_id'] ),
						'primary_id'  => $alice_api_data['ecommerce_data']['webchat_channel_primary_id'],
						'project_id'  => $alice_api_data['ecommerce_data']['project_id'],
						'email'       => $user_email,
					] );
				} elseif ( $alice_api_data['is_auto_connected'] === false ) {
					update_option( 'myaliceai_api_data', [
						'email' => $user_email,
					] );
				}

				wp_send_json_success( [ 'is_auto_connected' => $alice_api_data['is_auto_connected'], 'message' => __( 'You are logged in successfully', 'myaliceai' ) ] );
			} else {
				wp_send_json_error( [ 'message' => empty( $alice_api_data['error'] ) ? ( empty( $alice_api_data['detail'] ) ? '' : $alice_api_data['detail'] ) : $alice_api_data['error'] ] );
			}

		}
	}
}

function alice_signup_form_process() {
	if ( check_ajax_referer( 'myalice-form-process', 'myalice-nonce' ) ) {
		$full_name  = empty( $_POST['full_name'] ) ? '' : sanitize_text_field( $_POST['full_name'] );
		$user_email = empty( $_POST['user_email'] ) ? '' : sanitize_text_field( $_POST['user_email'] );
		$password   = empty( $_POST['password'] ) ? '' : sanitize_text_field( $_POST['password'] );

		if ( empty( $full_name ) || empty( $user_email ) || empty( $password ) ) {
			wp_send_json_error( [ 'message' => __( 'Please fill up all required field', 'myaliceai' ) ] );
		}

		$wc_data = get_option( 'myaliceai_wc_auth' );
		if ( empty( $wc_data['consumer_key'] ) || empty( $wc_data['consumer_secret'] ) || empty( $wc_data['key_permissions'] ) ) {
			wp_send_json_error( [ 'message' => __( 'MyAlice needs your permission to work. Please Grant Permission First.', 'myaliceai' ) ] );

		}

		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/register-and-connect-woocommerce';
		$body          = wp_json_encode( array(
			'store_url'       => site_url( '/' ),
			'consumer_key'    => $wc_data['consumer_key'],
			'consumer_secret' => $wc_data['consumer_secret'],
			'key_permissions' => $wc_data['key_permissions'],
			'full_name'       => $full_name,
			'email'           => $user_email,
			'password'        => $password,
		) );

		$response = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			wp_send_json_error( [ 'message' => "Something went wrong: {$error_message}" ] );
		} else {
			$alice_api_data = json_decode( $response['body'], true );

			if ( ! empty( $alice_api_data ) && $alice_api_data['success'] === true ) {
				if ( $alice_api_data['is_auto_connected'] === true && ! empty( $alice_api_data['ecommerce_data'] ) ) {
					update_option( 'myaliceai_api_data', [
						'api_token'   => $alice_api_data['ecommerce_data']['api_token'],
						'platform_id' => absint( $alice_api_data['ecommerce_data']['webchat_channel_id'] ),
						'primary_id'  => $alice_api_data['ecommerce_data']['webchat_channel_primary_id'],
						'project_id'  => $alice_api_data['ecommerce_data']['project_id'],
						'email'       => $user_email,
					] );
				} elseif ( $alice_api_data['is_auto_connected'] === false ) {
					update_option( 'myaliceai_api_data', [
						'email' => $user_email,
					] );
				}

				wp_send_json_success( [ 'is_auto_connected' => $alice_api_data['is_auto_connected'], 'message' => __( 'You are logged in successfully', 'myaliceai' ) ] );
			} else {
				wp_send_json_error( [ 'message' => empty( $alice_api_data['error'] ) ? ( empty( $alice_api_data['detail'] ) ? '' : $alice_api_data['detail'] ) : $alice_api_data['error'] ] );
			}

		}
	}
}

function myalice_select_team_form_process() {
	if ( check_ajax_referer( 'myalice-form-process', 'myalice-nonce' ) ) {
		$project_id = empty( $_POST['team'] ) ? '' : sanitize_text_field( $_POST['team'] );

		if ( empty( $project_id ) ) {
			wp_send_json_error( [ 'message' => __( 'Please fill up all required field', 'myaliceai' ) ] );
		}

		$wc_data = get_option( 'myaliceai_wc_auth' );
		if ( empty( $wc_data['consumer_key'] ) || empty( $wc_data['consumer_secret'] ) || empty( $wc_data['key_permissions'] ) ) {
			wp_send_json_error( [ 'message' => __( 'MyAlice needs your permission to work. Please Grant Permission First.', 'myaliceai' ) ] );
		}

		$myalice_api_data = get_option( 'myaliceai_api_data' );
		if ( empty( $myalice_api_data['email'] ) ) {
			wp_send_json_error( [ 'message' => __( 'Email Address Missing, Please login again.', 'myaliceai' ) ] );
		}

		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/connect-woocommerce-with-project';
		$body          = wp_json_encode( array(
			'store_url'       => site_url( '/' ),
			'consumer_key'    => $wc_data['consumer_key'],
			'consumer_secret' => $wc_data['consumer_secret'],
			'key_permissions' => $wc_data['key_permissions'],
			'email'           => $myalice_api_data['email'],
			'project_id'      => $project_id,
		) );

		$response = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			wp_send_json_error( [ 'message' => "Something went wrong: {$error_message}" ] );
		} else {
			$alice_api_data = json_decode( $response['body'], true );

			if ( ! empty( $alice_api_data ) && $alice_api_data['success'] === true ) {
				if ( ! empty( $alice_api_data['ecommerce_data'] ) ) {
					update_option( 'myaliceai_api_data', [
						'api_token'   => $alice_api_data['ecommerce_data']['api_token'],
						'platform_id' => absint( $alice_api_data['ecommerce_data']['webchat_channel_id'] ),
						'primary_id'  => $alice_api_data['ecommerce_data']['webchat_channel_primary_id'],
						'project_id'  => $alice_api_data['ecommerce_data']['project_id'],
						'email'       => $myalice_api_data['email'],
					] );
				} else {
					wp_send_json_error( [ 'message' => __( 'Something went wrong: ecommerce_data is empty', 'myaliceai' ) ] );
				}

				wp_send_json_success( [ 'is_connected' => true, 'message' => __( 'You selected team is connected', 'myaliceai' ) ] );
			} else {
				wp_send_json_error( [ 'message' => empty( $alice_api_data['error'] ) ? ( empty( $alice_api_data['detail'] ) ? '' : $alice_api_data['detail'] ) : $alice_api_data['error'] ] );
			}

		}
	}
	wp_send_json_error( [ 'message' => __( 'Something went wrong: nonce not match', 'myaliceai' ) ] );
}

function myalice_migration_livechat() {
	if ( check_ajax_referer( 'myaliceai', 'nonce' ) ) {
		$alice_api_url = 'https://api.myalice.ai/stable/ecommerce/migrate-to-new-live-chat';
		$body          = wp_json_encode( array(
			'store_url' => site_url( '/' )
		) );

		$response = wp_remote_post( $alice_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();

			wp_send_json_error( [ 'message' => "Something went wrong: {$error_message}" ] );
		} else {
			$alice_api_data = json_decode( $response['body'], true );

			if ( ! empty( $alice_api_data ) && $alice_api_data['success'] === true ) {
                update_option( 'myaliceai_is_needed_migration', false );

				wp_send_json_success( $alice_api_data );
			} else {
				wp_send_json_error( $alice_api_data );
			}

		}
	}
}

function myalice_migration_admin_notice() {
	if ( ! get_option( 'myaliceai_is_needed_migration' ) ) {
		return;
	}
	?>
    <div class="wpnotice-wrapper notice is-dismissible myalice-migration-admin-notice">
        <div class="wpnotice-content-wrapper">
            <div class="alice-migration-warning">
                <div class="alice-migration-warning-content">
                    <h3><?php esc_html_e( 'Switch to New Live Chat for a better way to communicate with your customers.', 'myaliceai' ) ?></h3>
                    <p><?php esc_html_e( 'Your Webchat will be automatically transitioned over to the New Live Chat. Switch your existing Webchat now and get early access to new features. We will automatically transition your account roughly after 30 days.', 'myaliceai' ); ?>
                        <a href="https://docs.myalice.ai/connect-social-channels/connect-web-app/connect-live-chat"><?php esc_html_e( 'Learn More', 'myaliceai' ); ?></a>
                    </p>
                    <button class="alice-btn" type="button"><?php esc_html_e( 'Switch to New Live Chat', 'myaliceai' ); ?></button>
                    <span class="spinner"></span>
                    <div class="myalice-notice-area"><?php esc_html_e( 'Something went wrong,', 'myaliceai' ); ?> <a
                                href="https://www.myalice.ai/support"><?php esc_html_e( 'contact support', 'myaliceai' ); ?></a></div>
                </div>
                <div class="alice-migration-warning-thumb">
                    <img src="<?php echo esc_url( ALICE_IMG_PATH . 'migration-notice-bg.jpg' ); ?>" alt="">
                </div>
            </div>
        </div>
    </div>
	<?php
}

function myalice_chat_customization_admin_notice() {
	if ( get_option( 'myaliceai_is_needed_migration' ) || get_option( 'myaliceai_customization_notice_dismiss' ) ) {
		return;
	}
	?>
    <div class="wpnotice-wrapper notice is-dismissible myalice-migration-admin-notice myalice-customization-admin-notice">
        <div class="wpnotice-content-wrapper">
            <div class="alice-migration-warning">
                <div class="alice-migration-warning-content">
                    <h3><?php esc_html_e( 'Livechat has been migrated. Time to customize!', 'myaliceai' ) ?></h3>
                    <p><?php esc_html_e( 'Your livechat has been migrated to the latest one. Now you can customize the livechat the way you want! Set up how you want to greet your customers, set up livechat styles, add pre-chat survey and many more.', 'myaliceai' ); ?></p>
                    <a class="alice-btn"
                       href="<?php echo esc_url( 'https://app.myalice.ai/integrations/integrated' ); ?>"><?php esc_html_e( 'Customize Livechat', 'myaliceai' ); ?></a>
                </div>
                <div class="alice-migration-warning-thumb">
                    <img src="<?php echo esc_url( ALICE_IMG_PATH . 'migration-notice-bg-2.png' ); ?>" alt="">
                </div>
            </div>
        </div>
    </div>
	<?php
}

function myalice_remove_admin_notice(){
	$current_screen = get_current_screen();
	if ( $current_screen->id == 'toplevel_page_myalice_dashboard' ) {

		remove_all_actions( 'user_admin_notices' );
		remove_all_actions( 'admin_notices' );

		// To showing notice in EA settings page we have to use 'eael_admin_notices' action hook
		add_action( 'admin_notices', function () {
			do_action( 'myalice_admin_notices' );
		} );
	}
}

function myalice_wc_not_activate_notice() {
	_e( '<div class="notice notice-error"><p><strong>WooCommerce</strong> is not installed/activated in your site. Please install and activate <a href="plugin-install.php?s=woocommerce&tab=search&type=term" target="_blank">WooCommerce</a> to use MyAlice Plugin. If you want to use MyAlice without WooCommerce, <a href="https://docs.myalice.ai/connect-social-channels/connect-web-app/connect-live-chat" target="_blank">follow this</a>.</p></div>', 'myaliceai' );
}

function myalice_is_working_wcapi() {
	$consumer_key    = 'ck_01c91d7d789803c684c74045b62f6c3fdde700ee';
	$consumer_secret = 'cs_1aa8886a5e8ede1fbab019b5ff328266b35bf600';
	$request_url     = site_url() . '/wp-json/wc/v3/products';
	$result          = [ 'error' => false, 'message' => '', 'success' => false ];

	$args = array(
		'headers' => array(
			'Authorization' => 'Basic ' . base64_encode( $consumer_key . ':' . $consumer_secret )
		)
	);

	$response = wp_remote_get( $request_url, $args );

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

	return $result;
}
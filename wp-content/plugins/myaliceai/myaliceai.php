<?php
/**
 * Plugin Name:       MyAlice
 * Plugin URI:        https://app.getalice.ai/
 * Description:       Alice is a Multi-Channel customer service platform for your e-commerce store or online business that centralises all customer interactions and helps to manage and automate customer support.
 * Version:           1.2
 * Author:            Alice Labs
 * Author URI:        https://myalice.ai/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       myaliceai
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'ALICE_BASE_PATH' ) ) {
	define( 'ALICE_BASE_PATH', __FILE__ );
}

if ( ! defined( 'ALICE_URL' ) ) {
	define( 'ALICE_URL', untrailingslashit( plugins_url( '', ALICE_BASE_PATH ) ) );
}

if ( ! defined( 'ALICE_JS_PATH' ) ) {
	define( 'ALICE_JS_PATH', ALICE_URL . '/js/' );
}

$api_data = get_option( 'myaliceai_api_data' );
$api_data = wp_parse_args( $api_data, [
	'api_token'   => '',
	'platform_id' => '',
	'primary_id'  => ''
] );

if ( ! defined( 'MYALICE_API_TOKEN' ) ) {
	define( 'MYALICE_API_TOKEN', $api_data['api_token'] );
}

if ( ! defined( 'MYALICE_PLATFORM_ID' ) ) {
	define( 'MYALICE_PLATFORM_ID', $api_data['platform_id'] );
}

if ( ! defined( 'MYALICE_PRIMARY_ID' ) ) {
	define( 'MYALICE_PRIMARY_ID', $api_data['primary_id'] );
}

// Redirect after activation the plugin
if ( get_option( 'myaliceai_plugin_status' ) === 'active' ) {
	update_option( 'myaliceai_plugin_status', 'activated', false );

	add_action( 'admin_init', function () {
		wp_safe_redirect( admin_url( 'admin.php?page=myalice_dashboard' ) );
		exit;
	} );
}

// Register activation hook
register_activation_hook( ALICE_BASE_PATH, function () {
	update_option( 'myaliceai_plugin_status', 'active', false );
} );

// Register deactivation hook
register_deactivation_hook( ALICE_BASE_PATH, function () {
	update_option( 'myaliceai_plugin_status', 'deactivated', false );
} );

// Admin Internal Style
add_action( 'admin_head', function () { ?>
    <style>
        #adminmenu .toplevel_page_myalice_dashboard > .wp-menu-image > img {
            padding: 5px 0 0 0;
            opacity: 1;
            filter: grayscale(1);
        }

        #adminmenu .toplevel_page_myalice_dashboard:hover > .wp-menu-image > img {
            filter: grayscale(0);
        }

        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard {
            background: linear-gradient(to left, #2271b1 50%, transparent 90%);
        }

        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard > .wp-menu-image > img {
            filter: grayscale(0);
        }

        #alice-feedback-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
        }

        #alice-feedback-modal * {
            box-sizing: border-box;
        }

        #alice-feedback-modal .alice-modal-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .7);
            z-index: 1;
            cursor: pointer;
        }

        #alice-feedback-modal .alice-modal-body {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            top: 20%;
            z-index: 2;
            width: 500px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .5);
            border-radius: 5px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header {
            background: linear-gradient(45deg, #04B35F 50%, #FFD82F);
            padding: 20px;
            border-radius: 5px 5px 0 0;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #f5d631;
            position: absolute;
            right: -12px;
            top: -12px;
            cursor: pointer;
            transition: .3s;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close:hover {
            transform: scale(1.3);
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close svg {
            width: 15px;
            margin: 4px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close svg path {
            stroke: red;
            stroke-width: 2;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header h3 {
            color: #fff;
            font-size: 18px;
            margin: 0;
            line-height: 1.4;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.4;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field {
            padding: 5px 0;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label {
            font-size: 16px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label input[type="text"] {
            width: 60%;
            margin-left: 10px;
            display: none;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label input[type="radio"]:checked ~ input[type="text"] {
            display: inline-block;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field {
            padding-top: 20px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button {
            background: #04B35F;
            border: 0;
            padding: 0 15px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            line-height: 40px;
            height: 40px;
            cursor: pointer;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button:hover {
            background: #028948;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button svg {
            margin-right: 5px;
        }

        .alice-dashboard-tab-content th.disabled {
            opacity: .6;
        }
    </style>
	<?php
} );

// Admin Internal Script & Template
add_action( 'admin_footer', function () { ?>
    <div id="alice-feedback-modal" style="display: none;">
        <div class="alice-modal-bg"></div>
        <div class="alice-modal-body">
            <div class="alice-modal-header">
                <h3><?php esc_html_e( "We're sorry to see you go. If you have a moment, please let us know why you’re deactivating the plugin.", 'myaliceai' ); ?></h3>
                <div class="alice-modal-close">
                    <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.5,1.5l-13,13m0-13,13,13" transform="translate(0 0)"></path>
                    </svg>
                </div>
            </div>
            <div class="alice-modal-content">
                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( "I'm unable to get the plugin to work", 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'I no longer need the plugin', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'I found a better solution', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'The plugin is impacting website performance', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'This is a temporary deactivation. I’ll be back!', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'Other', 'myaliceai' ); ?> <input type="text" name="" value="">
                        </label>
                    </div>
                    <div class="submission-button-field">
                        <button type="submit">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.540335 0.384995L11.7433 6.72599C11.7912 6.75489 11.8307 6.79517 11.8582 6.84303C11.8856 6.89089 11.9 6.94474 11.9 6.99949C11.9 7.05425 11.8856 7.1081 11.8582 7.15595C11.8307 7.20381 11.7912 7.24409 11.7433 7.27299L0.540335 13.615C0.49504 13.6419 0.442987 13.6561 0.389904 13.6561C0.336822 13.6561 0.284769 13.6419 0.239474 13.615C0.192756 13.5856 0.154586 13.5451 0.12861 13.4973C0.102635 13.4495 0.0897211 13.396 0.0911039 13.342V0.657995C0.0905368 0.604554 0.103944 0.551846 0.130072 0.504802C0.156201 0.457757 0.194196 0.417913 0.240504 0.388995C0.285303 0.361721 0.336964 0.346923 0.389842 0.346218C0.44272 0.345512 0.494781 0.358927 0.540335 0.384995ZM1.30382 7.62499V11.758L9.70939 6.99999L1.30485 2.24299V6.37499H4.33922V7.62499H1.30382Z" fill="#ffffff"/>
                            </svg>
	                        <?php esc_html_e( 'Submit & Deactivate', 'myaliceai' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        (function ($) {
            var alice_feedback_modal = $('#alice-feedback-modal');

            $(document).on('click', '#deactivate-myaliceai', function (e) {
                e.preventDefault();
                alice_feedback_modal.fadeIn();
                $('.submission-button-field button').attr('href', deactivate_url);
            }).on('click', '.alice-modal-close, .alice-modal-bg', function (e) {
                e.preventDefault();
                alice_feedback_modal.fadeOut();
            }).on('submit', '#alice-feedback-modal form', function (e) {
                e.preventDefault();
                var deactivate_url = $('#deactivate-myaliceai').attr('href');
                location.href = '<?php echo admin_url(); ?>' + deactivate_url;
            }).on('submit', '.alice-api-connect-tab form', function (e) {
                e.preventDefault();
                var $form = $(this),
                    url = $form.attr('action'),
                    data = $form.serialize(),
                    spinner = $form.find('.spinner');

                spinner.addClass('is-active');
                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');
                    var notice_area = $('.myalice-notice-area'),
                        platform_id = $('#alice-platform-id'),
                        primary_id = $('#alice-primary-id');
                    if (response.success) {
                        notice_area.prepend(`<div class="updated"><p>${response.data.message}</p></div>`);
                        platform_id.val(response.data.platform_id);
                        primary_id.val(response.data.primary_id);
                    } else {
                        notice_area.prepend(`<div class="error"><p>${response.data.message}</p></div>`);
                        platform_id.val('');
                        primary_id.val('');
                    }
                    setTimeout(function () {
                        notice_area.html('');
                    }, 5000);
                });
            });
        })(jQuery);
    </script>
	<?php
} );

// Add Alice Dashboard Menu
add_action( 'admin_menu', function () {
	add_menu_page(
		__('MyAlice Dashboard', 'myaliceai'),
		__('MyAlice', 'myaliceai'),
		'edit_plugins',
		'myalice_dashboard',
		'myalice_dashboard_callback',
		"data:image/svg+xml,%3Csvg height='24' viewBox='0 0 28 43' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M22.1921 42.2387C25.135 39.4333 26.7883 35.6284 26.7883 31.661C26.7883 27.6936 25.135 23.8887 22.1921 21.0833C19.2493 18.2779 15.2579 16.7019 11.0961 16.7019C6.93423 16.7019 2.94286 18.2779 0 21.0833L22.1921 42.2387Z' fill='%2301906D'%3E%3C/path%3E%3Cpath d='M0 21.1554C2.94344 23.9597 6.93459 25.535 11.0961 25.535C15.2575 25.535 19.2487 23.9597 22.1921 21.1554C23.8223 19.6014 32.8218 10.1331 22.1921 0L0 21.1554Z' fill='%23FFD82F'%3E%3C/path%3E%3Cpath d='M22.1921 21.1555V21.1155C19.3755 18.4338 15.5948 16.8731 11.6161 16.7496C7.6374 16.6262 3.75825 17.9492 0.764666 20.4506L0 21.1155L0.731054 21.8204C3.72662 24.3311 7.61294 25.6599 11.5996 25.5363C15.5863 25.4128 19.3739 23.8464 22.1921 21.1555Z' fill='%23000'%3E%3C/path%3E%3Cpath d='M21.7806 7.77047C22.9501 7.77047 23.8983 6.86663 23.8983 5.75169C23.8983 4.63675 22.9501 3.73291 21.7806 3.73291C20.611 3.73291 19.6628 4.63675 19.6628 5.75169C19.6628 6.86663 20.611 7.77047 21.7806 7.77047Z' fill='%23000'%3E%3C/path%3E%3C/svg%3E",
		2
	);
} );

add_action( 'wp_ajax_alice_api_form', 'alice_api_form_process' );

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

// Alice Dashboard Menu Callback
function myalice_dashboard_callback () { ?>
    <div class="wrap alice-dashboard-wrap">
        <div id="alice-dashboard">
            <div class="alice-dashboard-tab-nav">
                <nav class="nav-tab-wrapper alice-nav-tab-wrapper">
                    <a href="#" class="nav-tab"><?php esc_html_e( 'User Guide', 'myaliceai' ); ?></a>
                    <a href="<?php echo admin_url( 'admin.php?page=myalice_dashboard' ); ?>" class="nav-tab nav-tab-active"><?php esc_html_e( 'API Connect', 'myaliceai' ); ?></a>
                </nav>
            </div>
            <div class="alice-dashboard-tab-content alice-api-connect-tab">
                <div class="myalice-notice-area"></div>
                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
	                <?php wp_nonce_field( 'alice-api-form', 'alice-api-form' ); ?>
                    <input type="hidden" name="action" value="alice_api_form">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th><label for="alice-plugin-key"><?php esc_html_e( 'Plugin Key', 'myaliceai' ); ?></label></th>
                            <td>
                                <input name="alice_plugin_key" type="text" id="alice-plugin-key" value="<?php echo esc_attr( MYALICE_API_TOKEN ); ?>" class="regular-text">
                                <p class="description"><?php esc_html_e( 'Please enter the plugin key to verify the plugin and your website.', 'myaliceai' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th class="disabled"><label><?php esc_html_e( 'Plugin Platform ID', 'myaliceai' ); ?></label></th>
                            <td>
                                <input type="text" value="<?php echo esc_attr( MYALICE_PLATFORM_ID ); ?>" id="alice-platform-id" class="regular-text" disabled>
                            </td>
                        </tr>
                        <tr>
                            <th class="disabled"><label><?php esc_html_e( 'Plugin Primary ID', 'myaliceai' ); ?></label></th>
                            <td>
                                <input type="text" value="<?php echo esc_attr( MYALICE_PRIMARY_ID ); ?>" id="alice-primary-id" class="regular-text" disabled>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="submit" style="display: inline-block;">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'myaliceai' ); ?>">
                        <span class="spinner"></span>
                    </p>
                </form>
            </div>
        </div>
    </div>
<?php
}

// Left side links in plugin list page
add_filter( "plugin_action_links_myaliceai/myaliceai.php", function ( $actions ) {
	$actions['alice_settings'] = '<a href="admin.php?page=myalice_dashboard" aria-label="MyAlice Settings">' . esc_html__( 'Settings', 'myaliceai' ) . '</a>';

	return $actions;
}, 10 );

// Right side links in plugin list page
add_filter( "plugin_row_meta", function ( $links, $file ) {
	if ( 'myaliceai/myaliceai.php' === $file ) {
		$links['alice_docs']    = '<a href="https://docs.myalice.ai" target="_blank" aria-label="MyAlice Documents">' . esc_html__( 'Docs', 'myaliceai' ) . '</a>';
		$links['alice_support'] = '<a href="https://airtable.com/shrvMCwEUGQU7TvRR" target="_blank" aria-label="MyAlice Support">' . esc_html__( 'Support', 'myaliceai' ) . '</a>';
	}

	return $links;
}, 10, 2 );

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    function alice_script() {
        wp_enqueue_script('alice-script', plugins_url('/js/script.js', __FILE__), 'jquery', time(), false);
    }
    add_action( 'wp_footer', 'alice_script' );


    //    Insert JS code in Footer
    function xl_alice_javascript_footer() { ?>
        <script type="text/javascript">
            (function () {
                var div = document.createElement('div');
                div.id = 'icWebChat';
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.async = true;
                script.src = 'https://webchat.getalice.ai/index.js';
                var lel = document.body.getElementsByTagName('script');
                var el = lel[lel.length - 1];
                el.parentNode.insertBefore(script, el);
                el.parentNode.insertBefore(div, el);
                script.addEventListener('load', function () {
                    ICWebChat.init({
                        selector: '#icWebChat',
                        platformId: '<?php echo esc_js( MYALICE_PLATFORM_ID ); ?>',
                        primaryId: '<?php echo esc_js( MYALICE_PRIMARY_ID ); ?>',
                        token: '<?php echo esc_js( MYALICE_API_TOKEN ); ?>'
                    });
                });
            })();
        </script>
        <?php
    }
    add_action('wp_footer', 'xl_alice_javascript_footer');



    // Link Logged In Customer API to the alice customer ID
    function xl_alice_send_user_data_to_alice() {
        $alice_customer_id = $_COOKIE["aliceCustomerId"];
        $current_user_id = get_current_user_id();

        // API Calling
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/link-customer?api_token=' . MYALICE_API_TOKEN;

        $body = array(
            'alice_customer_id'    => (int) $alice_customer_id,
            'ecommerce_account_id' => (string) $current_user_id,
        );

	    $response = wp_remote_post( $xl_api_url, array(
			    'method'  => 'POST',
			    'timeout' => 45,
			    'body'    => $body,
			    'cookies' => array()
		    )
	    );

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            $alice_admin_data = json_decode($response['body'], true);
        }
    }
    add_action('wp_footer', 'xl_alice_send_user_data_to_alice');


	// Store Customer Product API
	function xl_store_customer_product_api() {
		global $product;

		//User Data
		$alice_customer_id = $_COOKIE["aliceCustomerId"];

		// API Calling
		$xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/store-product-view?api_token=' . MYALICE_API_TOKEN;

		$body = json_encode( array(
			'alice_customer_id' => $alice_customer_id,
			'product'           => array(
				'product_id'     => $product->get_id(),
				'product_name'   => $product->get_name(),
				'product_link'   => get_permalink( $product->get_id() ),
				'product_images' => array( get_the_post_thumbnail_url() ),
				'unit_price'     => $product->get_price(),
			),
		) );

		$response = wp_remote_post( $xl_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		var_dump($body, $response);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: $error_message";
		} else {
			$alice_admin_data = json_decode( $response['body'], true );
		}
	}
	add_action( 'woocommerce_after_single_product', 'xl_store_customer_product_api' );


	// Store Customer Cart API (Done)
	function xl_store_customer_cart_api( $updated ) {
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
				'quantity'       => $cart_item['quantity'],
				'unit_price'     => $cart_item['data']->price,
				'total_cost'     => ( ( $cart_item['quantity'] ) * ( $cart_item['data']->price ) ),
			);
		}

		// API Calling
		$xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/update-cart?api_token=' . MYALICE_API_TOKEN;
		$body       = json_encode( array(
			'alice_customer_id' => $alice_customer_id,
			'cart_products'     => $items,
		) );

		$response = wp_remote_post( $xl_api_url, array(
				'method'  => 'POST',
				'timeout' => 45,
				'body'    => $body,
				'cookies' => array()
			)
		);

		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			echo "Something went wrong: $error_message";
		} else {
			$alice_admin_data = json_decode( $response['body'], true );
		}

		return $updated;
	}

	add_action( 'woocommerce_add_to_cart', 'xl_store_customer_cart_api' );
	add_action( 'woocommerce_cart_item_removed', 'xl_store_customer_cart_api' );
	add_action( 'woocommerce_cart_item_restored', 'xl_store_customer_cart_api' );
	add_filter( 'woocommerce_update_cart_action_cart_updated', 'xl_store_customer_cart_api' );

} else {
    echo '<div id="message" class="error woocommerce-message"><p>To active Alice Chatbot, Please install and active Woocommerce.</p></div>';
}
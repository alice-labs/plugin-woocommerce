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
        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard {
            background: linear-gradient(to left, #2271b1 50%, transparent 90%);
        }

        #adminmenu .toplevel_page_myalice_dashboard > .wp-menu-image > img {
            padding: 5px 0 0 0;
            opacity: 1;
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
            });
        })(jQuery);
    </script>
	<?php
} );

// Add Alice Dashboard Menu
add_action( 'admin_menu', function () {
	add_menu_page(
		'Alice',
		'Alice Dashboard',
		'edit_plugins',
		'myalice_dashboard',
		'myalice_dashboard_callback',
		"data:image/svg+xml,%3Csvg height='24' viewBox='0 0 28 43' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M22.1921 42.2387C25.135 39.4333 26.7883 35.6284 26.7883 31.661C26.7883 27.6936 25.135 23.8887 22.1921 21.0833C19.2493 18.2779 15.2579 16.7019 11.0961 16.7019C6.93423 16.7019 2.94286 18.2779 0 21.0833L22.1921 42.2387Z' fill='%2301906D'%3E%3C/path%3E%3Cpath d='M0 21.1554C2.94344 23.9597 6.93459 25.535 11.0961 25.535C15.2575 25.535 19.2487 23.9597 22.1921 21.1554C23.8223 19.6014 32.8218 10.1331 22.1921 0L0 21.1554Z' fill='%23FFD82F'%3E%3C/path%3E%3Cpath d='M22.1921 21.1555V21.1155C19.3755 18.4338 15.5948 16.8731 11.6161 16.7496C7.6374 16.6262 3.75825 17.9492 0.764666 20.4506L0 21.1155L0.731054 21.8204C3.72662 24.3311 7.61294 25.6599 11.5996 25.5363C15.5863 25.4128 19.3739 23.8464 22.1921 21.1555Z' fill='%23000'%3E%3C/path%3E%3Cpath d='M21.7806 7.77047C22.9501 7.77047 23.8983 6.86663 23.8983 5.75169C23.8983 4.63675 22.9501 3.73291 21.7806 3.73291C20.611 3.73291 19.6628 4.63675 19.6628 5.75169C19.6628 6.86663 20.611 7.77047 21.7806 7.77047Z' fill='%23000'%3E%3C/path%3E%3C/svg%3E",
		2
	);
} );

// Alice Dashboard Menu Callback
function myalice_dashboard_callback () { ?>
    <div class="wrap alice-dashboard-wrap">

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

    class WC_Settings_Tab_Alice {

        /**
         * Bootstraps the class and hooks required actions & filters.
         *
         */
        public static function init() {
            add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
            add_action( 'woocommerce_settings_tabs_settings_tab_alice', __CLASS__ . '::settings_tab' );
            add_action( 'woocommerce_update_options_settings_tab_alice', __CLASS__ . '::update_settings' );
        }


        /**
         * Add a new settings tab to the WooCommerce settings tabs array.
         *
         * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
         * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
         */
        public static function add_settings_tab( $settings_tabs ) {
            $settings_tabs['settings_tab_alice'] = __( 'Alice Chatbot', 'myaliceai' );
            return $settings_tabs;
        }


        /**
         * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
         *
         * @uses woocommerce_admin_fields()
         * @uses self::get_settings()
         */
        public static function settings_tab() {
            woocommerce_admin_fields( self::get_settings() );
        }


        /**
         * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
         *
         * @uses woocommerce_update_options()
         * @uses self::get_settings()
         */
        public static function update_settings() {
            woocommerce_update_options( self::get_settings() );
        }

        /**
         * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
         *
         * @return array Array of settings for @see woocommerce_admin_fields() function.
         */
        public static function get_settings() {

            $settings = array(
                'section_title' => array(
                    'name'     => __( 'Alice Chatbot Key', 'myaliceai' ),
                    'type'     => 'title',
                    'desc'     => '',
                    'id'       => 'xl_settings_tab_alice_section_title'
                ),
                'title' => array(
                    'name' => __( 'Plugin Key', 'myaliceai' ),
                    'type' => 'text',
                    'desc' => __( 'Please enter the plugin key to verify the plugin and your website.', 'myaliceai' ),
                    'id'   => 'xl_settings_tab_alice_plugin_key'
                ),
                'platform_id' => array(
                    'name' => __( 'Plugin Platform ID', 'myaliceai' ),
                    'type' => 'text',
                    'id'   => 'xl_settings_tab_alice_plugin_platform_id',
//                    'default' => 'ss',
//                    'value' => 'ss00',
                    'value' => 'aatt',
                    'custom_attributes' => array('readonly' => 'readonly'),
                ),
                'primary_id' => array(
                    'name' => __( 'Plugin Primary ID', 'myaliceai' ),
                    'type' => 'text',
//                    'desc' => __( 'Please enter the plugin key to verify the plugin and your website.', 'myaliceai' ),
                    'id'   => 'xl_settings_tab_alice_plugin_primary_id',
                    'custom_attributes' => array('readonly' => 'readonly'),
                ),
                'section_end' => array(
                    'type' => 'sectionend',
                    'id' => 'xl_settings_tab_alice_section_end'
                )
            );

            return apply_filters( 'wc_settings_tab_alice_settings', $settings );
        }

    }

    WC_Settings_Tab_Alice::init();



    /**
     * Hook into options page after save.
     */
    function xl_hook_into_options_page_after_save( $old_value, $new_value ) {

        $platform_id = get_option( 'xl_settings_tab_alice_plugin_platform_id' );
        $primary_id = get_option( 'xl_settings_tab_alice_plugin_primary_id' );

//        var_dump($platform_id);die();

        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/connect-ecommerce-plugin?api_token='.$xl_settings_tab_alice_plugin_key.'';

        $response = wp_remote_post( $xl_api_url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'cookies'     => array()
            )
        );

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            $alice_admin_data = json_decode($response['body'], true);

            //var_dump($alice_admin_data);
            //var_dump($alice_admin_data['platform_id']);
//            var_dump($alice_admin_data['primary_id']);
//            var_dump($alice_admin_data['api_token']);

            //update_option( 'xl_settings_tab_alice_plugin_platform_id', $alice_admin_data['platform_id'] );


            var_dump(get_option( 'xl_settings_tab_alice_plugin_key' ));

            $settings['xl_settings_tab_alice_plugin_platform_id'] = $alice_admin_data['platform_id'];


//            die;
        }




    }
    add_action( 'update_option', 'xl_hook_into_options_page_after_save', 10, 2 );




    function alice_script() {
        wp_enqueue_script('alice-script', plugins_url('/js/script.js', __FILE__), 'jquery', time(), false);
    }
    add_action( 'wp_footer', 'alice_script' );







    //    Insert JS code in Footer
    function xl_alice_javascript_footer() {

//        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
//        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/connect-ecommerce-plugin?api_token='.$xl_settings_tab_alice_plugin_key.'';
//
//        $response = wp_remote_post( $xl_api_url, array(
//                'method'      => 'POST',
//                'timeout'     => 45,
//                'cookies'     => array()
//            )
//        );
//
//        if ( is_wp_error( $response ) ) {
//            $error_message = $response->get_error_message();
//            echo "Something went wrong: $error_message";
//        } else {
//            $alice_admin_data = json_decode($response['body'], true);
//
//        }

        ?>
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
                    ICWebChat.init({ selector: '#icWebChat',
                        platformId: '<?php echo $alice_admin_data['platform_id']; ?>',
                        primaryId: '<?php echo $alice_admin_data['primary_id']; ?>',
                        token: '<?php echo $xl_settings_tab_alice_plugin_key; ?>' });
                });
            })();

        </script>

        <?php
    }
    add_action('wp_footer', 'xl_alice_javascript_footer');



// Link Logged In Customer API to the alice customer ID
    function xl_alice_send_user_data_to_alice() {

        //$customer_id = $_COOKIE["aliceCustomerId"];
        //var_dump($customer_id);

        //User Data
        $alice_customer_id = $_COOKIE["aliceCustomerId"];

        $current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;

//        var_dump($current_user);


//        $ecommerce_type = 'woocommerce';
//        $first_name = 'Test Fname';
//        $last_name = 'L name';
//        $avatar = '';
//        $email = 'test@tt.com';
//        $phone = '000';
//        $shipping_address = '';
//        $billing_address = '';


//        var_dump($current_user);
//        var_dump($current_user_id);

        // API Calling
        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/link-customer?api_token='.$xl_settings_tab_alice_plugin_key.'';

        $body = array(
            'alice_customer_id' => $alice_customer_id,
            'ecommerce_account_id' => $current_user_id,
//            'ecommerce_type' => $ecommerce_type,
//            'first_name' => $first_name,
//            'last_name' => $last_name,
//            'avatar' => $avatar,
//            'email' => $email,
//            'phone' => $phone,
//            'shipping_address' => $shipping_address,
//            'billing_address' => $billing_address,
        );

        $response = wp_remote_post( $xl_api_url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'body'        => $body,
                'cookies'     => array()
            )
        );

        //var_dump($response);

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            $alice_admin_data = json_decode($response['body'], true);

//            var_dump($alice_admin_data);
//            var_dump($alice_admin_data['platform_id']);
//            var_dump($alice_admin_data['primary_id']);
//            var_dump($alice_admin_data['api_token']);

        }


    }
    add_action('wp_footer', 'xl_alice_send_user_data_to_alice');





// Store Customer Product API
    function xl_store_customer_product_api() {

        if ( is_product() ) {

            global $product;

//            echo 4; die;

            //User Data
            $alice_customer_id = $_COOKIE["aliceCustomerId"];

//            $current_user = wp_get_current_user();
//            $current_user_id = $current_user->ID;

            // API Calling
            $xl_settings_tab_alice_plugin_key = get_option('xl_settings_tab_alice_plugin_key');
            $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/store-product-view?api_token=' . $xl_settings_tab_alice_plugin_key . '';

            $body = json_encode(array(
                'alice_customer_id' => $alice_customer_id,
                'product' => array(
                    'product_id' => $product->get_id(),
                    'product_name' => $product->get_name(),
                    'product_link' => $product->get_slug(),
                    'product_images' => array(get_the_post_thumbnail_url()),
                    'unit_price' => $product->get_price(),
                ),


            ));

            //var_dump($body);

            $response = wp_remote_post($xl_api_url, array(
                    'method' => 'POST',
                    'timeout' => 45,
                    'body' => $body,
                    'cookies' => array()
                )
            );

            //var_dump($response);

            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "Something went wrong: $error_message";
            } else {
                $alice_admin_data = json_decode($response['body'], true);

                //var_dump($alice_admin_data);

            }


        }


    }
    add_action('wp_footer', 'xl_store_customer_product_api');






// Store Customer Cart API (Done)
    function xl_store_customer_cart_api() {

        global $woocommerce;

        //User Data
        $alice_customer_id = $_COOKIE["aliceCustomerId"];
//        $current_user = wp_get_current_user();
//        $current_user_id = $current_user->ID;


        // initializing the array:
        $items = array();

        //var_dump(WC()->cart->get_cart());

        foreach(WC()->cart->get_cart() as $cart_item) {
//            $items_names[] = $cart_item['data']->product_id;
            $imgs = $cart_item['data']->downloads;
            $productImages = [];

            foreach ($imgs as $img) {
                $productImages[] = $img->get_file();
            }
            $items[] = array(
                'product_id' => $cart_item['product_id'],
                'variant_id' => $cart_item['variation_id'],
                'product_name' => $cart_item['data']->name,
//                'product_link' => $cart_item['data']->slug,
                'product_link' => get_permalink(),
                'product_images' => $productImages,
                'quantity' => $cart_item['quantity'],
                'unit_price' =>  $cart_item['data']->price,
                'total_cost' => (($cart_item['quantity']) * ($cart_item['data']->price)),
            );
        }
//        var_dump($cart_items);
//        var_dump($items);

//        die();

        // API Calling
        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/update-cart?api_token='.$xl_settings_tab_alice_plugin_key.'';


        $body = json_encode(array(
            'alice_customer_id' => $alice_customer_id,
            'cart_products' => $items,
//            'cart_products' => WC()->cart->get_cart()
        ));

        //var_dump($body);

        $response = wp_remote_post( $xl_api_url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'body'        => $body,
                'cookies'     => array()
            )
        );

//        var_dump($response);

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            $alice_admin_data = json_decode($response['body'], true);

            //var_dump($alice_admin_data);

        }


    }
    add_action('wp_footer', 'xl_store_customer_cart_api');



} else {
    echo '<div id="message" class="error woocommerce-message"><p>To active Alice Chatbot, Please install and active Woocommerce.</p></div>';
}
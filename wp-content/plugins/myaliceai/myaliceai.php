<?php
/**
 * Plugin Name:       MyAlice
 * Plugin URI:        https://app.getalice.ai/
 * Description:       Alice is a Multi-Channel customer service platform for your e-commerce store or online business that centralises all customer interactions and helps to manage and automate customer support.
 * Version:           1.1.2
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
                'section_end' => array(
                    'type' => 'sectionend',
                    'id' => 'xl_settings_tab_alice_section_end'
                )
            );

            return apply_filters( 'wc_settings_tab_alice_settings', $settings );
        }

    }

    WC_Settings_Tab_Alice::init();


    function alice_script() {
        wp_enqueue_script('alice-script', plugins_url('/js/script.js', __FILE__), 'jquery', time(), false);
    }
    add_action( 'wp_footer', 'alice_script' );

    //    Insert JS code in Footer
    function xl_alice_javascript_footer() {

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

        }

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

        //User Data
        $alice_customer_id = $_COOKIE["aliceCustomerId"];
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;

        // API Calling
        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/link-customer?api_token='.$xl_settings_tab_alice_plugin_key.'';

        $body = array(
            'alice_customer_id' => $alice_customer_id,
            'ecommerce_account_id' => $current_user_id,
        );

        $response = wp_remote_post( $xl_api_url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'body'        => $body,
                'cookies'     => array()
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

        if ( is_product() ) {

            global $product;

            //User Data
            $alice_customer_id = $_COOKIE["aliceCustomerId"];

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

            $response = wp_remote_post($xl_api_url, array(
                    'method' => 'POST',
                    'timeout' => 45,
                    'body' => $body,
                    'cookies' => array()
                )
            );

            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "Something went wrong: $error_message";
            } else {
                $alice_admin_data = json_decode($response['body'], true);
            }
        }
    }
    add_action('wp_footer', 'xl_store_customer_product_api');

// Store Customer Cart API (Done)
    function xl_store_customer_cart_api() {

        global $woocommerce;

        //User Data
        $alice_customer_id = $_COOKIE["aliceCustomerId"];

        // initializing the array:
        $items = array();

        foreach(WC()->cart->get_cart() as $cart_item) {

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

        // API Calling
        $xl_settings_tab_alice_plugin_key = get_option( 'xl_settings_tab_alice_plugin_key' );
        $xl_api_url = 'https://live-v3.getalice.ai/api/ecommerce/plugins/update-cart?api_token='.$xl_settings_tab_alice_plugin_key.'';

        $body = json_encode(array(
            'alice_customer_id' => $alice_customer_id,
            'cart_products' => $items,
        ));

        $response = wp_remote_post( $xl_api_url, array(
                'method'      => 'POST',
                'timeout'     => 45,
                'body'        => $body,
                'cookies'     => array()
            )
        );

        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Something went wrong: $error_message";
        } else {
            $alice_admin_data = json_decode($response['body'], true);
        }
    }
    add_action('wp_footer', 'xl_store_customer_cart_api');

} else {
    echo '<div id="message" class="error woocommerce-message"><p>To active Alice Chatbot, Please install and active Woocommerce.</p></div>';
}
<?php
/**
 * Plugin Name:       MyAlice
 * Plugin URI:        https://app.getalice.ai/
 * Description:       Alice is a Multi-Channel customer service platform for your e-commerce store or online business that centralises all customer interactions and helps to manage and automate customer support.
 * Version:           2.5.0
 * WC tested up to:   9.0
 * Author:            Alice Labs
 * Author URI:        https://myalice.ai/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       myaliceai
 */

// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

global $myalice_settings;

if ( ! defined( 'ALICE_BASE_PATH' ) ) {
	define( 'ALICE_BASE_PATH', __FILE__ );
}

if ( ! defined( 'ALICE_PLUGIN_BASENAME' ) ) {
	define( 'ALICE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'ALICE_PATH' ) ) {
	define( 'ALICE_PATH', untrailingslashit( dirname( ALICE_BASE_PATH ) ) );
}

if ( ! defined( 'ALICE_INC_PATH' ) ) {
	define( 'ALICE_INC_PATH', ALICE_PATH . '/includes' );
}

if ( ! defined( 'ALICE_URL' ) ) {
	define( 'ALICE_URL', untrailingslashit( plugins_url( '', ALICE_BASE_PATH ) ) );
}

if ( ! defined( 'ALICE_JS_PATH' ) ) {
	define( 'ALICE_JS_PATH', ALICE_URL . '/js/' );
}

if ( ! defined( 'ALICE_SVG_PATH' ) ) {
	define( 'ALICE_SVG_PATH', ALICE_URL . '/svg/' );
}

if ( ! defined( 'ALICE_IMG_PATH' ) ) {
	define( 'ALICE_IMG_PATH', ALICE_URL . '/images/' );
}

if ( ! defined( 'ALICE_VERSION' ) ) {
	define( 'ALICE_VERSION', '2.5.0' );
}

$api_data = get_option( 'myaliceai_api_data' );
$api_data = wp_parse_args( $api_data, [
	'api_token'   => '',
	'platform_id' => '',
	'primary_id'  => '',
	'project_id'  => ''
] );

$myalice_settings = get_option( 'myaliceai_settings', [] );
$myalice_settings = wp_parse_args( $myalice_settings, [
	'allow_chat_user_only'   => 0,
	'allow_product_view_api' => 1,
	'allow_cart_api'         => 1,
	'show_chatbox'           => 'all',
	'shows_on'               => []
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

if ( ! defined( 'MYALICE_PROJECT_ID' ) ) {
	define( 'MYALICE_PROJECT_ID', $api_data['project_id'] );
}

if ( ! defined( 'MYALICE_API_URL' ) ) {
	define( 'MYALICE_API_URL', 'https://api.myalice.ai/stable/ecommerce/plugins/' );
}

if ( ! defined( 'MYALICE_API_OK' ) ) {
	if ( ! empty( MYALICE_API_TOKEN ) && ! empty( MYALICE_PLATFORM_ID ) && ! empty( MYALICE_PRIMARY_ID ) ) {
		define( 'MYALICE_API_OK', true );
	} else {
		define( 'MYALICE_API_OK', false );
	}
}

//Include required files
require ALICE_INC_PATH . '/myalice-activation-deactivation-register.php';

add_action( 'plugins_loaded', function () {
	if ( ! defined( 'ALICE_WC_OK' ) ) {
		if ( class_exists( 'WooCommerce' ) ) {
			define( 'ALICE_WC_OK', true );
		} else {
			define( 'ALICE_WC_OK', false );
		}
	}

	//Include required files
	require ALICE_INC_PATH . '/myalice-helper-functions.php';
	require ALICE_INC_PATH . '/myalice-dashboard-inline-styles.php';
	require ALICE_INC_PATH . '/myaliceai-dashboard.php';
	require ALICE_INC_PATH . '/myalice-dashboard-templates-and-scripts.php';
	require ALICE_INC_PATH . '/myalice-enqueue-scripts.php';
	require ALICE_INC_PATH . '/myalice-hooks.php';
	require ALICE_INC_PATH . '/myalice-hooks-callback.php';
} );

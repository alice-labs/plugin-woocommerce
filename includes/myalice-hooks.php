<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

global $myalice_settings;

// WooCommerce's installation notice
if ( ! ALICE_WC_OK ) {
	add_action( 'admin_notices', function () {
		_e( '<div class="notice notice-error"><p><strong>WooCommerce</strong> is not installed/activated in your site. Please install and activate <a href="plugin-install.php?s=woocommerce&tab=search&type=term" target="_blank">WooCommerce</a> to use MyAlice Plugin. If you want to use MyAlice without WooCommerce, <a href="https://docs.myalice.ai/connect-social-channels/connect-web-app/connect-live-chat" target="_blank">follow this</a>.</p></div>', 'myaliceai' );
	} );
}

// WordPress review notice
if ( $notice_time = get_option( 'myaliceai_review_notice_time' ) ) {
	$current_time = current_time( 'U' );
	if ( $notice_time < $current_time ) {
		add_action( 'admin_notices', 'alice_review_admin_notice' );
	}
}

// Review notice dismiss action
add_action( 'wp_ajax_myalice_notice_dismiss', 'myalice_review_notice_dismiss' );

// Left side links in plugin list page
add_filter( "plugin_action_links_myaliceai/myaliceai.php", function ( $actions ) {
	$actions['alice_settings'] = '<a href="admin.php?page=myalice_dashboard" aria-label="' . esc_html__( 'MyAlice Settings', 'myaliceai' ) . '">' . esc_html__( 'Settings', 'myaliceai' ) . '</a>';

	return $actions;
}, 10 );

// Right side links in plugin list page
add_filter( "plugin_row_meta", function ( $links, $file ) {
	if ( 'myaliceai/myaliceai.php' === $file ) {
		$links['alice_docs']    = '<a href="https://docs.myalice.ai" target="_blank" aria-label="' . esc_html__( 'MyAlice Documents', 'myaliceai' ) . '">' . esc_html__( 'Docs', 'myaliceai' ) . '</a>';
		$links['alice_support'] = '<a href="https://airtable.com/shrvMCwEUGQU7TvRR" target="_blank" aria-label="' . esc_html__( 'MyAlice Support', 'myaliceai' ) . '">' . esc_html__( 'Support', 'myaliceai' ) . '</a>';
	}

	return $links;
}, 10, 2 );

// Alice Settings form ajax handler
add_action( 'wp_ajax_alice_settings_form', 'alice_settings_form_process' );

// Alice's deactivation feedback form handler
add_action( 'wp_ajax_alice_deactivation_feedback', 'alice_feedback_form_process' );

if ( ALICE_WC_OK && MYALICE_API_OK ) {
	add_action( 'init', function () {
		if ( is_user_logged_in() ) {
			alice_customer_link_handler();
		}
	} );

	add_action( 'wp_footer', function () {
		global $myalice_settings;

		if ( $myalice_settings['allow_product_view_api'] === 1 && is_product() ) {
			alice_user_product_view_handler();
		}
	} );

	if ( $myalice_settings['allow_cart_api'] === 1 ) {
		add_action( 'woocommerce_add_to_cart', 'alice_user_cart_api_handler' );
		add_action( 'woocommerce_cart_item_removed', 'alice_user_cart_api_handler' );
		add_action( 'woocommerce_cart_item_restored', 'alice_user_cart_api_handler' );
		add_filter( 'woocommerce_update_cart_action_cart_updated', 'alice_user_cart_api_handler' );
	}
}

// Alice Login and Signup form handler
add_action( 'wp_ajax_myalice_login', 'alice_login_form_process' );
add_action( 'wp_ajax_myalice_signup', 'alice_signup_form_process' );

// Alice Team Select
add_action( 'wp_ajax_myalice_select_team', 'myalice_select_team_form_process' );

// Alice Migration
add_action( 'admin_notices', 'myalice_migration_admin_notice' );
add_action( 'wp_ajax_myalice_migration', 'myalice_migration_livechat' );
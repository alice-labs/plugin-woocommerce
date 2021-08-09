<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

if ( ! ALICE_WC_OK ) {
	add_action( 'admin_notices', function () {
		_e( '<div class="notice notice-error"><p><strong>WooCommerce</strong> is not installed/activated on your site. Please install and activate <a href="plugin-install.php?s=woocommerce&tab=search&type=term" target="_blank">WooCommerce</a> first to use MyAlice Chatbot.</p></div>', 'myaliceai' );
	} );
}

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

//Alice API form ajax handler
add_action( 'wp_ajax_alice_api_form', 'alice_api_form_process' );

if ( ALICE_WC_OK ) {
	if ( is_user_logged_in() ) {
		add_action( 'wp_footer', 'alice_customer_link_handler' );
	}
	add_action( 'woocommerce_single_product_summary', 'alice_user_product_view_handler' );
	add_action( 'woocommerce_add_to_cart', 'alice_user_cart_api_handler' );
	add_action( 'woocommerce_cart_item_removed', 'alice_user_cart_api_handler' );
	add_action( 'woocommerce_cart_item_restored', 'alice_user_cart_api_handler' );
	add_filter( 'woocommerce_update_cart_action_cart_updated', 'alice_user_cart_api_handler' );
}
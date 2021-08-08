<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

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
	do_action( 'myalice_plugin_activate' );
} );

// Register deactivation hook
register_deactivation_hook( ALICE_BASE_PATH, function () {
	update_option( 'myaliceai_plugin_status', 'deactivated', false );
	do_action( 'myalice_plugin_deactivate' );
} );
<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

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
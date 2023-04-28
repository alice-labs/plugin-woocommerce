<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Add Alice Dashboard Menu
add_action( 'admin_menu', function () {
	add_menu_page(
		__( 'MyAlice Dashboard', 'myaliceai' ),
		__( 'MyAlice', 'myaliceai' ),
		'install_plugins',
		'myalice_dashboard',
		'myalice_dashboard_callback',
		ALICE_SVG_PATH . 'MyAlice-icon.svg',
		2
	);
} );

// Store wcauth data
if ( isset( $_GET['myalice_action'], $_GET['wcauth'] ) && $_GET['myalice_action'] === 'wcauth' && $_GET['wcauth'] == 1 ) {
	$wc_auth_data = file_get_contents( 'php://input' );
	$wc_auth_data = json_decode( $wc_auth_data, true );
	$auth_data    = [
		'consumer_key'    => $wc_auth_data['consumer_key'],
		'consumer_secret' => $wc_auth_data['consumer_secret'],
		'key_permissions' => $wc_auth_data['key_permissions'],
	];
	update_option( 'myaliceai_wc_auth', $auth_data, false );
}

// Alice Dashboard Menu Callback
function myalice_dashboard_callback() {
	global $myalice_settings;
	?>
    <div class="alice-dashboard-wrap">
        <div id="alice-dashboard" class="<?php echo myalice_get_dashboard_class(); ?>">

            <section class="alice-dashboard-header">
                <div class="alice-container">
                    <div class="alice-logo">
                        <img src="<?php echo esc_url( ALICE_SVG_PATH . 'MyAlice-Logo.svg' ); ?>" alt="<?php esc_attr_e( 'MyAlice Logo', 'myaliceai' ); ?>">
                    </div>
                    <nav class="alice-main-menu">
                        <ul>
                            <li><a class="--myalice-dashboard-menu-link"
                                   href="<?php echo esc_url( admin_url( '/admin.php?page=myalice_dashboard' ) ); ?>"><?php esc_html_e( 'Dashboard', 'myaliceai' ); ?></a></li>
                            <li><a href="#" data-link-section="--plugin-settings"><?php esc_html_e( 'Settings', 'myaliceai' ); ?></a></li>
                            <li><a href="https://wordpress.org/support/plugin/myaliceai/reviews/?filter=5#new-post"
                                   target="_blank"><?php esc_html_e( 'Review MyAlice', 'myaliceai' ); ?></a></li>
                            <li class="alice-has-sub-menu">
                                <a href="#"><?php esc_html_e( 'Help & Support', 'myaliceai' ); ?></a>
                                <ul class="alice-sub-menu">
                                    <li><a href="https://docs.myalice.ai/myalice-ecommerce/woocommerce"
                                           target="_blank"><?php esc_html_e( 'Read Documentation', 'myaliceai' ); ?></a></li>
                                    <li>
                                        <a href="https://www.youtube.com/watch?v=ktSGc6zNsF8&list=PL_EdxcvIGFEacr3fV8McbglwYhhTAi2pO"
                                           target="_blank"><?php esc_html_e( 'Watch Tutorials', 'myaliceai' ); ?></a>
                                    </li>
                                    <li><a href="https://www.myalice.ai/support" target="_blank"><?php esc_html_e( 'Contact Support', 'myaliceai' ); ?></a></li>
                                </ul>
                            </li>
                            <li class="--wcapi-status">
                                <?php
                                $status_class = '--wcapi-operational';
                                $status_text  = __( 'Operational', 'myaliceai' );
                                ?>
                                <button class="<?php echo esc_attr( $status_class ); ?>"><?php echo esc_html( $status_text ); ?></button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>

			<?php $is_email_registered = myalice_is_email_registered(); ?>
            <section class="alice-connect-with-myalice <?php echo $is_email_registered ? 'alice-login-active' : ''; ?>">
                <div class="alice-container">
                    <div class="alice-title">
                        <h2><?php esc_html_e( 'Connect with MyAlice', 'myaliceai' ); ?></h2>
                        <p class="--signup-component"><?php esc_html_e( 'Already have an account?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>" data-form="login"><?php esc_html_e( 'login here', 'myaliceai' ); ?></a></p>
                        <p class="--login-component"><?php esc_html_e( 'Don’t have an account?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>" data-form="signup"><?php esc_html_e( 'signup here', 'myaliceai' ); ?></a></p>
                    </div>
                </div>
                <div class="alice-container">
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
						<?php wp_nonce_field( 'myalice-form-process', 'myalice-nonce' ); ?>
                        <input type="hidden" name="action" value="<?php echo $is_email_registered ? 'myalice_login' : 'myalice_signup'; ?>">
                        <label class="--full-name">
							<?php esc_html_e( 'Full Name', 'myaliceai' ); ?>
                            <input type="text" name="full_name" <?php echo $is_email_registered ? 'disabled' : ''; ?>>
                        </label>
                        <label>
							<?php esc_html_e( 'Email Address', 'myaliceai' ); ?>
                            <input type="email" name="user_email" value="<?php echo esc_attr( myalice_get_current_user_email() ); ?>" required>
                        </label>
                        <label>
							<?php esc_html_e( 'Password', 'myaliceai' ); ?>
                            <input type="password" name="password" required>
                            <span class="dashicons dashicons-visibility myalice-pass-show" aria-hidden="true"></span>
                        </label>
                        <span class="spinner"></span>
                        <button type="submit" class="alice-btn">
                            <span class="--signup-component"><?php esc_html_e( 'Signup & Connect', 'myaliceai' ); ?></span>
                            <span class="--login-component"><?php esc_html_e( 'Login & Connect', 'myaliceai' ); ?></span>
                        </button>
                        <div class="myalice-notice-area"></div>
                        <p class="--signup-component"><?php esc_html_e( 'By proceeding, you agree to the', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( 'https://www.myalice.ai/terms' ); ?>" target="_blank"><?php esc_html_e( 'Terms & Conditions', 'myaliceai' ); ?></a></p>
                        <p class="--login-component"><?php esc_html_e( 'Forgot your credentials?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( 'https://app.myalice.ai/reset' ); ?>" target="_blank"><?php esc_html_e( 'Reset Password', 'myaliceai' ); ?></a></p>
                    </form>
                </div>
            </section>

            <section class="alice-select-the-team">
                <div class="alice-container">
                    <div class="alice-title">
                        <h2><?php esc_html_e( 'Select the team to connect your store with', 'myaliceai' ); ?></h2>
                        <p><?php esc_html_e( 'You can connect one store with one team only.', 'myaliceai' ); ?></p>
                    </div>
                </div>
                <div class="alice-container">
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
						<?php wp_nonce_field( 'myalice-form-process', 'myalice-nonce' ); ?>
                        <input type="hidden" name="action" value="myalice_select_team">
						<?php
						foreach ( myalice_get_woocommerce_projects() as $single_project ) {
							?>
                            <input type="radio" name="team" value="<?php echo esc_attr( $single_project['id'] ); ?>" id="team-<?php echo esc_attr( $single_project['id'] ); ?>">
                            <label for="team-<?php echo esc_attr( $single_project['id'] ); ?>">
                            <span class="alice-team-info">
                                <?php $img_src = empty( $single_project['image'] ) ? ALICE_IMG_PATH . 'team-placeholder.png' : $single_project['image']; ?>
                                <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php esc_attr_e( 'team avatar', 'myaliceai' ); ?>">
                                <span><?php echo esc_html( $single_project['name'] ); ?></span>
                            </span>
                                <span class="alice-icon"></span>
                            </label>
							<?php
						}
						?>
                        <button type="submit" class="alice-btn"><?php esc_html_e( 'Continue', 'myaliceai' ); ?></button>
                        <p><?php esc_html_e( "If you see any missing teams, it might be because it's already connected. If that isn't the case,", 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( 'https://www.myalice.ai/support' ); ?>" target="_blank"><?php esc_html_e( 'contact support.', 'myaliceai' ); ?></a></p>
                    </form>
                </div>
            </section>

            <section class="alice-needs-your-permission">
                <div class="alice-container">
                    <div class="alice-title">
                        <h2><?php esc_html_e( 'MyAlice needs your permission to work', 'myaliceai' ); ?></h2>
                        <p><?php esc_html_e( 'Once you grant permission, your website visitors will be able to communicate with you.', 'myaliceai' ); ?></p>
                    </div>
                </div>
                <div class="alice-container">
					<?php
					$store_url   = site_url( '/' );
					$endpoint    = '/wc-auth/v1/authorize';
					$params      = array(
						'app_name'     => 'MyAlice',
						'scope'        => 'read_write',
						'user_id'      => wp_rand(),
						'return_url'   => admin_url( 'admin.php?page=myalice_dashboard' ),
						'callback_url' => site_url( '?myalice_action=wcauth&wcauth=1' )
					);
					$wc_auth_url = $store_url . $endpoint . '?' . http_build_query( $params );
					?>
                    <a class="alice-btn" href="<?php echo esc_url( $wc_auth_url ); ?>"><?php esc_html_e( 'Grant Permission', 'myaliceai' ); ?></a>
                </div>
				<?php if ( ! is_ssl() ) { ?>
                    <div class="alice-container">
                        <div class="alice-ssl-warning">
                            <p><?php esc_html_e( 'Your store doesn’t appear to be using a secure connection. We highly recommend serving your entire website over an HTTPS connection to help keep customer data secure.', 'myaliceai' ); ?></p>
                        </div>
                    </div>
				<?php } ?>
            </section>

            <section class="alice-explore-myalice">
                <div class="alice-container">
                    <img src="<?php echo esc_url( ALICE_SVG_PATH . 'Explore-MyAlice.svg' ); ?>" alt="<?php esc_attr_e( 'MyAlice Explore Map', 'myaliceai' ); ?>">
                </div>
                <div class="alice-container">
                    <div class="alice-title">
                        <h2><?php esc_html_e( 'Explore MyAlice', 'myaliceai' ); ?></h2>
                        <p><?php esc_html_e( 'Check your inbox for pending conversations, customise the livechat to update brand or automate responses with chatbot.', 'myaliceai' ); ?></p>
                    </div>
                </div>
                <div class="alice-container">
                    <a class="alice-btn alice-btn-lite" href="<?php echo esc_url( 'https://app.myalice.ai/dashboard' ); ?>"><?php esc_html_e( 'Open MyAlice', 'myaliceai' ); ?></a>
                    <a class="alice-btn alice-btn-lite"
                       href="<?php echo esc_url( 'https://app.myalice.ai/projects/' . MYALICE_PROJECT_ID . '/chat' ); ?>"><?php esc_html_e( 'Open Inbox', 'myaliceai' ); ?></a>
                </div>
            </section>

            <section class="alice-plugin-settings">
                <div class="alice-container">
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
						<?php wp_nonce_field( 'alice-settings-form', 'alice-settings-form' ); ?>
                        <input type="hidden" name="action" value="alice_settings_form">
                        <h3><?php esc_html_e( 'Plugin Settings', 'myaliceai' ); ?></h3>
                        <hr>
                        <label>
                            <input type="checkbox" name="allow_chat_user_only" value="true" <?php checked( 1, $myalice_settings['allow_chat_user_only'] ); ?>>
                            <span class="custom-checkbox"></span>
                            <span class="checkbox-title"><?php esc_html_e( 'Allow chat for logged-in user only', 'myaliceai' ); ?></span>
                            <span><?php esc_html_e( 'This will show the livechat in your WooCommerce Store for logged in users only.', 'myaliceai' ); ?></span>
                        </label>
                        <label>
                            <input type="checkbox" name="allow_product_view_api" value="true" <?php checked( 1, $myalice_settings['allow_product_view_api'] ); ?>>
                            <span class="custom-checkbox"></span>
                            <span class="checkbox-title"><?php esc_html_e( 'Send product view data', 'myaliceai' ); ?></span>
                            <span><?php esc_html_e( 'If anyone views a product in your store, this will send the data to MyAlice for your team to view.', 'myaliceai' ); ?></span>
                        </label>
                        <label>
                            <input type="checkbox" name="allow_cart_api" value="true" <?php checked( 1, $myalice_settings['allow_cart_api'] ); ?>>
                            <span class="custom-checkbox"></span>
                            <span class="checkbox-title"><?php esc_html_e( 'Send cart data', 'myaliceai' ); ?></span>
                            <span><?php esc_html_e( 'If anyone adds a product in their cart from your store, this will send the data to MyAlice for your team to view.', 'myaliceai' ); ?></span>
                        </label>
                        <label>
                            <input type="checkbox" name="hide_chatbox" value="true" <?php checked( 1, $myalice_settings['hide_chatbox'] ); ?>>
                            <span class="custom-checkbox"></span>
                            <span class="checkbox-title"><?php esc_html_e( 'Hide chat widget', 'myaliceai' ); ?></span>
                            <span><?php esc_html_e( 'This will hide the live chat widget from your store. Your visitors will not see the live chat option.', 'myaliceai' ); ?></span>
                        </label>
                        <hr>
                        <div class="submit-btn-section">
                            <span class="spinner"></span>
                            <button type="submit" class="alice-btn" disabled><?php esc_html_e( 'Save Changes', 'myaliceai' ); ?></button>
                            <button type="button" class="alice-btn alice-btn-lite myalice-back-to-home" data-link-section="<?php echo myalice_get_dashboard_class(); ?>"><?php esc_html_e( 'Back', 'myaliceai' ); ?></button>
                        </div>
                        <div class="myalice-notice-area"></div>
                    </form>
                </div>
            </section>

        </div>
    </div>
	<?php
}
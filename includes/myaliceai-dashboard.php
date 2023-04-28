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
                                $status = myalice_is_working_wcapi();
                                if ( $status['error'] === false && $status['success'] === true ) {
                                    $status_class = '--wcapi-operational';
                                    $status_text  = __( 'Operational', 'myaliceai' );
                                } else {
                                    $status_class = '--wcapi-disconnected';
                                    $status_text  = __( 'Disconnected', 'myaliceai' );
                                }

                                ?>
                                <button class="<?php echo esc_attr( $status_class ); ?>" title="<?php echo esc_attr( $status['message'] ); ?>"><?php echo esc_html( $status_text ); ?></button>
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
                    <a class="alice-btn alice-btn-lite"
                    href="<?php echo esc_url( 'https://app.myalice.ai/projects/' . MYALICE_PROJECT_ID . '/chat' ); ?>"><?php esc_html_e( 'Open Inbox', 'myaliceai' ); ?></a>
                    <a class="alice-btn alice-btn-lite --wc-api-sync-btn" href="<?php echo esc_url( 'https://app.myalice.ai/dashboard' ); ?>">
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.0915 12.9251H13.3165C13.0955 12.9251 12.8835 13.0129 12.7272 13.1692C12.571 13.3254 12.4832 13.5374 12.4832 13.7584C12.4832 13.9794 12.571 14.1914 12.7272 14.3477C12.8835 14.5039 13.0955 14.5917 13.3165 14.5917H15.3165C14.3973 15.5524 13.2118 16.2162 11.9125 16.4979C10.6131 16.7796 9.25918 16.6664 8.02465 16.1728C6.79012 15.6792 5.73139 14.8277 4.9845 13.7277C4.2376 12.6278 3.83665 11.3296 3.83317 10.0001C3.83317 9.77907 3.74537 9.56711 3.58909 9.41083C3.43281 9.25455 3.22085 9.16675 2.99984 9.16675C2.77882 9.16675 2.56686 9.25455 2.41058 9.41083C2.2543 9.56711 2.1665 9.77907 2.1665 10.0001C2.17091 11.6274 2.65169 13.2178 3.54951 14.5751C4.44733 15.9324 5.72289 16.997 7.21879 17.6378C8.71469 18.2785 10.3654 18.4672 11.9674 18.1806C13.5693 17.894 15.0522 17.1447 16.2332 16.0251V17.5001C16.2332 17.7211 16.321 17.9331 16.4772 18.0893C16.6335 18.2456 16.8455 18.3334 17.0665 18.3334C17.2875 18.3334 17.4995 18.2456 17.6558 18.0893C17.812 17.9331 17.8998 17.7211 17.8998 17.5001V13.7501C17.8978 13.5348 17.8125 13.3286 17.6618 13.1748C17.5111 13.021 17.3067 12.9315 17.0915 12.9251ZM10.4998 1.66675C8.36349 1.67284 6.31108 2.49918 4.7665 3.97508V2.50008C4.7665 2.27907 4.67871 2.06711 4.52243 1.91083C4.36615 1.75455 4.15418 1.66675 3.93317 1.66675C3.71216 1.66675 3.5002 1.75455 3.34391 1.91083C3.18763 2.06711 3.09984 2.27907 3.09984 2.50008V6.25008C3.09984 6.4711 3.18763 6.68306 3.34391 6.83934C3.5002 6.99562 3.71216 7.08341 3.93317 7.08341H7.68317C7.90418 7.08341 8.11615 6.99562 8.27243 6.83934C8.42871 6.68306 8.5165 6.4711 8.5165 6.25008C8.5165 6.02907 8.42871 5.81711 8.27243 5.66083C8.11615 5.50455 7.90418 5.41675 7.68317 5.41675H5.68317C6.60189 4.45664 7.78658 3.793 9.08517 3.511C10.3838 3.22901 11.737 3.34154 12.9712 3.83413C14.2054 4.32673 15.2642 5.17692 16.0117 6.27558C16.7592 7.37424 17.1614 8.67124 17.1665 10.0001C17.1665 10.2211 17.2543 10.4331 17.4106 10.5893C17.5669 10.7456 17.7788 10.8334 17.9998 10.8334C18.2208 10.8334 18.4328 10.7456 18.5891 10.5893C18.7454 10.4331 18.8332 10.2211 18.8332 10.0001C18.8332 8.90573 18.6176 7.8221 18.1988 6.81105C17.78 5.80001 17.1662 4.88135 16.3924 4.10752C15.6186 3.3337 14.6999 2.71987 13.6889 2.30109C12.6778 1.8823 11.5942 1.66675 10.4998 1.66675Z" fill="black"/>
                        </svg>
                        <?php esc_html_e( 'Sync Changes', 'myaliceai' ); ?>
                    </a>
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
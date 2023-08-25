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

// Update the WC API Status
if ( isset( $_GET['page'], $_GET['success'], $_GET['user_id'] ) && $_GET['page'] === 'myalice_dashboard' && $_GET['success'] == 1 && ! empty( $_GET['user_id'] ) ) {
	myalice_is_working_wcapi( true );
	wp_safe_redirect( admin_url( '?page=myalice_dashboard' ) );
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
                    <a class="alice-btn alice-btn-lite --wc-api-sync-btn">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5915 12.9251H12.8165C12.5955 12.9251 12.3835 13.0129 12.2272 13.1692C12.071 13.3254 11.9832 13.5374 11.9832 13.7584C11.9832 13.9794 12.071 14.1914 12.2272 14.3477C12.3835 14.5039 12.5955 14.5917 12.8165 14.5917H14.8165C13.8973 15.5524 12.7118 16.2162 11.4125 16.4979C10.1131 16.7796 8.75918 16.6664 7.52465 16.1728C6.29012 15.6792 5.23139 14.8277 4.4845 13.7277C3.7376 12.6278 3.33665 11.3296 3.33317 10.0001C3.33317 9.77907 3.24537 9.56711 3.08909 9.41083C2.93281 9.25455 2.72085 9.16675 2.49984 9.16675C2.27882 9.16675 2.06686 9.25455 1.91058 9.41083C1.7543 9.56711 1.6665 9.77907 1.6665 10.0001C1.67091 11.6274 2.15169 13.2178 3.04951 14.5751C3.94733 15.9324 5.22289 16.997 6.71879 17.6378C8.21469 18.2785 9.86545 18.4672 11.4674 18.1806C13.0693 17.894 14.5522 17.1447 15.7332 16.0251V17.5001C15.7332 17.7211 15.821 17.9331 15.9772 18.0893C16.1335 18.2456 16.3455 18.3334 16.5665 18.3334C16.7875 18.3334 16.9995 18.2456 17.1558 18.0893C17.312 17.9331 17.3998 17.7211 17.3998 17.5001V13.7501C17.3978 13.5348 17.3125 13.3286 17.1618 13.1748C17.0111 13.021 16.8067 12.9315 16.5915 12.9251ZM9.99984 1.66675C7.86349 1.67284 5.81108 2.49918 4.2665 3.97508V2.50008C4.2665 2.27907 4.17871 2.06711 4.02243 1.91083C3.86615 1.75455 3.65418 1.66675 3.43317 1.66675C3.21216 1.66675 3.0002 1.75455 2.84391 1.91083C2.68763 2.06711 2.59984 2.27907 2.59984 2.50008V6.25008C2.59984 6.4711 2.68763 6.68306 2.84391 6.83934C3.0002 6.99562 3.21216 7.08341 3.43317 7.08341H7.18317C7.40418 7.08341 7.61615 6.99562 7.77243 6.83934C7.92871 6.68306 8.0165 6.4711 8.0165 6.25008C8.0165 6.02907 7.92871 5.81711 7.77243 5.66083C7.61615 5.50455 7.40418 5.41675 7.18317 5.41675H5.18317C6.10189 4.45664 7.28658 3.793 8.58517 3.511C9.88376 3.22901 11.237 3.34154 12.4712 3.83413C13.7054 4.32673 14.7642 5.17692 15.5117 6.27558C16.2592 7.37424 16.6614 8.67124 16.6665 10.0001C16.6665 10.2211 16.7543 10.4331 16.9106 10.5893C17.0669 10.7456 17.2788 10.8334 17.4998 10.8334C17.7208 10.8334 17.9328 10.7456 18.0891 10.5893C18.2454 10.4331 18.3332 10.2211 18.3332 10.0001C18.3332 8.90573 18.1176 7.8221 17.6988 6.81105C17.28 5.80001 16.6662 4.88135 15.8924 4.10752C15.1186 3.3337 14.1999 2.71987 13.1889 2.30109C12.1778 1.8823 11.0942 1.66675 9.99984 1.66675Z" fill="black"/>
                        </svg>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 18C14.4183 18 18 14.4183 18 10C18 5.58172 14.4183 2 10 2C5.58172 2 2 5.58172 2 10C2 14.4183 5.58172 18 10 18ZM13.7071 8.70711C14.0976 8.31658 14.0976 7.68342 13.7071 7.29289C13.3166 6.90237 12.6834 6.90237 12.2929 7.29289L9 10.5858L7.70711 9.29289C7.31658 8.90237 6.68342 8.90237 6.29289 9.29289C5.90237 9.68342 5.90237 10.3166 6.29289 10.7071L8.29289 12.7071C8.68342 13.0976 9.31658 13.0976 9.70711 12.7071L13.7071 8.70711Z" fill="#04B25F"/>
                        </svg>
                        <span><?php esc_html_e( 'Sync Changes', 'myaliceai' ); ?></span>
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
                        <h3><?php esc_html_e( 'Display Chat Widget', 'myaliceai' ); ?></h3>
                        <hr>
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
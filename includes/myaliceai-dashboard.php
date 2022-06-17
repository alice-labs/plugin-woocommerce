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

// Alice Dashboard Menu Callback
function myalice_dashboard_callback() {
	global $myalice_settings;
	?>
    <div class="wrap alice-dashboard-wrap">
        <div id="alice-dashboard" class="<?php echo MYALICE_API_OK ? 'myalice-api-activated' : ''; ?>">

            <section class="alice-dashboard-header">
                <div class="alice-container">
                    <div class="alice-logo">
                        <img src="<?php echo esc_url( ALICE_SVG_PATH . 'MyAlice-Logo.svg' ); ?>" alt="<?php esc_attr_e( 'MyAlice Logo', 'myaliceai' ); ?>">
                    </div>
                    <nav class="alice-main-menu">
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Dashboard', 'myaliceai' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Review MyAlice', 'myaliceai' ); ?></a></li>
                            <li class="alice-has-sub-menu">
                                <a href="#"><?php esc_html_e( 'Help & Support', 'myaliceai' ); ?></a>
                                <ul class="alice-sub-menu">
                                    <li><a href="#"><?php esc_html_e( 'Read Documentation', 'myaliceai' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Watch Tutorials', 'myaliceai' ); ?></a></li>
                                    <li><a href="#"><?php esc_html_e( 'Contact Support', 'myaliceai' ); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </section>

            <section class="alice-connect-with-myalice alice-login-active">
                <div class="alice-container">
                    <div class="alice-title">
                        <h2><?php esc_html_e( 'Connect with MyAlice', 'myaliceai' ); ?></h2>
                        <p class="--signup-component"><?php esc_html_e( 'Already have an account?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e( 'login here', 'myaliceai' ); ?></a></p>
                        <p class="--login-component"><?php esc_html_e( 'Don’t have an account?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e( 'signup here', 'myaliceai' ); ?></a></p>
                    </div>
                </div>
                <div class="alice-container">
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
						<?php wp_nonce_field( '', 'alice-api-form' ); ?>
                        <input type="hidden" name="action" value="">
                        <label>
							<?php esc_html_e( 'Email Address', 'myaliceai' ); ?>
                            <input type="email" name="user_name">
                        </label>
                        <label>
							<?php esc_html_e( 'Password', 'myaliceai' ); ?>
                            <input type="password" name="password">
                        </label>
                        <button type="submit" class="alice-btn">
                            <span class="--signup-component"><?php esc_html_e( 'Signup & Connect', 'myaliceai' ); ?></span>
                            <span class="--login-component"><?php esc_html_e( 'Login & Connect', 'myaliceai' ); ?></span>
                        </button>
                        <p class="--signup-component"><?php esc_html_e( 'By proceeding, you agree to the', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e( 'Terms & Conditions', 'myaliceai' ); ?></a></p>
                        <p class="--login-component"><?php esc_html_e( 'Forgot your credentials?', 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e( 'Reset Password', 'myaliceai' ); ?></a></p>
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
						<?php wp_nonce_field( '', 'alice-api-form' ); ?>
                        <input type="hidden" name="action" value="">
                        <input type="radio" name="team" id="team-1" checked>
                        <label for="team-1">
                            <span class="alice-team-info">
                                <img src="https://via.placeholder.com/40x40" alt="<?php esc_attr_e( 'team avatar', 'myaliceai' ); ?>">
                                <span><?php esc_html_e( 'Online Clothing Store', 'myaliceai' ); ?></span>
                            </span>
                            <span class="alice-icon"></span>
                        </label>
                        <input type="radio" name="team" id="team-2">
                        <label for="team-2">
                            <span class="alice-team-info">
                                <img src="https://via.placeholder.com/40x40" alt="<?php esc_attr_e( 'team avatar', 'myaliceai' ); ?>">
                                <span><?php esc_html_e( 'Panda Shop', 'myaliceai' ); ?></span>
                            </span>
                            <span class="alice-icon"></span>
                        </label>
                        <button type="submit" class="alice-btn"><?php esc_html_e( 'Continue', 'myaliceai' ); ?></button>
                        <p><?php esc_html_e( "If you don't see any team, that might be already connected to a store. If that isn't the case,", 'myaliceai' ); ?>
                            <a href="<?php echo esc_url( '#' ); ?>"><?php esc_html_e( 'Contact Support', 'myaliceai' ); ?></a></p>
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
                    <a class="alice-btn" href="#"><?php esc_html_e( 'Grant Permission', 'myaliceai' ); ?></a>
                </div>
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
                    <a class="alice-btn alice-btn-lite" href="#"><?php esc_html_e( 'Open MyAlice', 'myaliceai' ); ?></a>
                    <a class="alice-btn alice-btn-lite" href="#"><?php esc_html_e( 'Open Inbox', 'myaliceai' ); ?></a>
                </div>
            </section>

            <section class="alice-plugin-settings">
                <div class="alice-container">
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
				        <?php wp_nonce_field( 'alice-settings-form', 'alice-api-form' ); ?>
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
                        </div>
                    </form>
                </div>
            </section>

            <section class="alice-settings-section">
                <div class="alice-container">
                    <div style="width: 100%;">
                        <div class="alice-text-content">
                            <h4><?php esc_html_e( 'MyAlice Settings', 'myaliceai' ); ?></h4>
                        </div>
                        <div class="alice-settings">
                            <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
								<?php wp_nonce_field( 'alice-settings-form', 'alice-settings-form' ); ?>
                                <input type="hidden" name="action" value="alice_settings_form">
                                <label>
                                    <input type="checkbox" name="allow_chat_user_only" value="true" <?php checked( 1, $myalice_settings['allow_chat_user_only'] ); ?>>
                                    <span class="checkbox-title"><?php esc_html_e( 'Allow Chat for Logged-in User Only', 'myaliceai' ); ?></span>
                                </label>
                                <br class="clear">
                                <label>
                                    <input type="checkbox" name="allow_product_view_api" value="true" <?php checked( 1, $myalice_settings['allow_product_view_api'] ); ?>>
                                    <span class="checkbox-title"><?php esc_html_e( 'Send product view data', 'myaliceai' ); ?></span>
                                </label>
                                <br class="clear">
                                <label>
                                    <input type="checkbox" name="allow_cart_api" value="true" <?php checked( 1, $myalice_settings['allow_cart_api'] ); ?>>
                                    <span class="checkbox-title"><?php esc_html_e( 'Send cart data', 'myaliceai' ); ?></span>
                                </label>
                                <br class="clear">
                                <label>
                                    <input type="checkbox" name="hide_chatbox" value="true" <?php checked( 1, $myalice_settings['hide_chatbox'] ); ?>>
                                    <span class="checkbox-title"><?php esc_html_e( 'Hide chat widget', 'myaliceai' ); ?></span>
                                </label>
                                <br class="clear">
                                <span class="spinner"></span>
                                <button type="submit" class="alice-btn" style="margin-top: 20px;"><?php esc_html_e( 'Save Changes', 'myaliceai' ); ?></button>
                            </form>
                            <div class="myalice-notice-area"></div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
	<?php
}
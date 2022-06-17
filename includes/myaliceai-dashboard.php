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

            <section class="alice-welcome-section">
                <div class="alice-container">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                    <path d="M10.3343 6.65602C10.2347 6.75557 10.1592 6.87557 10.0961 7.00713L10.089 7.00002L0.119194 29.4587L0.128971 29.4685C-0.0559175 29.8267 0.253416 30.5556 0.887194 31.1902C1.52097 31.824 2.24986 32.1334 2.60808 31.9485L2.61697 31.9574L25.0756 21.9867L25.0685 21.9787C25.1992 21.9165 25.3192 21.8409 25.4196 21.7396C26.8081 20.3511 24.5565 15.8489 20.3921 11.6836C16.2259 7.51824 11.7236 5.26757 10.3343 6.65602Z" fill="#DD2E44"/>
                    <path d="M11.5556 10.6666L0.36986 28.8942L0.119194 29.4586L0.128971 29.4684C-0.0559175 29.8266 0.253416 30.5555 0.887194 31.1902C1.09342 31.3964 1.30764 31.5528 1.51742 31.6853L15.1112 15.1111L11.5556 10.6666Z" fill="#EA596E"/>
                    <path d="M20.455 11.6143C24.6061 15.7672 26.911 20.1938 25.6008 21.5023C24.2915 22.8125 19.8648 20.5085 15.711 16.3574C11.559 12.2045 9.25504 7.77604 10.5644 6.46671C11.8746 5.15737 16.3013 7.46137 20.455 11.6143Z" fill="#A0041E"/>
                    <path d="M16.5245 12.0969C16.3476 12.24 16.1165 12.3147 15.872 12.288C15.1005 12.2045 14.4516 11.936 13.9974 11.512C13.5165 11.0631 13.2791 10.4605 13.344 9.85692C13.4578 8.79737 14.5209 7.82492 16.3334 8.02048C17.0382 8.09603 17.3529 7.86937 17.3636 7.76092C17.376 7.65337 17.1174 7.36448 16.4125 7.28803C15.6409 7.20448 14.992 6.93603 14.5369 6.51203C14.056 6.06314 13.8178 5.46048 13.8836 4.85692C13.9991 3.79737 15.0614 2.82492 16.872 3.02137C17.3858 3.07648 17.6569 2.9707 17.7716 2.90225C17.8631 2.84625 17.8996 2.79292 17.9031 2.76181C17.9138 2.65425 17.6587 2.36537 16.952 2.28892C16.464 2.23559 16.1102 1.79825 16.1645 1.30937C16.2169 0.821366 16.6534 0.468477 17.1431 0.52181C18.9538 0.716477 19.7858 1.89248 19.6711 2.95292C19.5556 4.01425 18.4934 4.98492 16.6809 4.79025C16.1671 4.73425 15.8987 4.84092 15.7831 4.90937C15.6916 4.96448 15.6542 5.0187 15.6507 5.04892C15.6391 5.15737 15.896 5.44537 16.6027 5.52181C18.4134 5.71737 19.2454 6.89248 19.1307 7.95292C19.016 9.01248 17.9538 9.98492 16.1422 9.78848C15.6285 9.73337 15.3582 9.84003 15.2427 9.90759C15.1502 9.96448 15.1147 10.0178 15.1111 10.048C15.0996 10.1556 15.3565 10.4445 16.0622 10.5209C16.5494 10.5743 16.904 11.0125 16.8498 11.5005C16.8249 11.744 16.7014 11.9547 16.5245 12.0969Z" fill="#AA8DD8"/>
                    <path d="M27.2543 20.3173C29.0081 19.8222 30.2179 20.6044 30.5059 21.6311C30.7939 22.6569 30.1699 23.9555 28.417 24.4489C27.7325 24.6409 27.5272 24.968 27.5547 25.072C27.585 25.1769 27.9325 25.3493 28.6152 25.1564C30.3681 24.6631 31.5779 25.4453 31.8659 26.4711C32.1556 27.4977 31.5299 28.7946 29.7761 29.2889C29.0925 29.4809 28.8863 29.8089 28.9165 29.9129C28.9459 30.0169 29.2925 30.1893 29.9761 29.9973C30.4472 29.8649 30.9396 30.1395 31.0721 30.6115C31.2036 31.0844 30.929 31.5751 30.4561 31.7084C28.7041 32.2017 27.4934 31.4213 27.2036 30.3937C26.9156 29.368 27.5405 28.0711 29.2952 27.5769C29.9796 27.384 30.185 27.0577 30.1547 26.9529C30.1263 26.8489 29.7796 26.6755 29.097 26.8675C27.3423 27.3617 26.1334 26.5813 25.8445 25.5529C25.5556 24.5271 26.1805 23.2302 27.9343 22.7351C28.617 22.544 28.8223 22.2151 28.7939 22.112C28.7636 22.0071 28.4179 21.8346 27.7343 22.0266C27.2614 22.16 26.7716 21.8844 26.6383 21.4124C26.5059 20.9413 26.7814 20.4506 27.2543 20.3173Z" fill="#77B255"/>
                    <path d="M20.4453 17.92C20.184 17.92 19.9262 17.8054 19.7502 17.5867C19.4435 17.2027 19.5066 16.6436 19.8889 16.3369C20.0826 16.1814 24.7049 12.5511 31.2373 13.4854C31.7235 13.5547 32.0613 14.0045 31.992 14.4907C31.9226 14.976 31.4764 15.3174 30.9857 15.2445C25.2142 14.4249 21.0417 17.6925 21.0009 17.7254C20.8355 17.8569 20.64 17.92 20.4453 17.92Z" fill="#AA8DD8"/>
                    <path d="M5.11475 14.2222C5.03031 14.2222 4.94408 14.2097 4.85875 14.1848C4.38853 14.0435 4.12186 13.5484 4.26319 13.0782C5.27031 9.7244 6.18319 4.3724 5.06142 2.97685C4.93608 2.81862 4.74675 2.66307 4.31297 2.69596C3.47919 2.75996 3.55831 4.51907 3.55919 4.53685C3.59653 5.02662 3.22853 5.45329 2.73964 5.48974C2.24275 5.51996 1.82319 5.15907 1.78675 4.66929C1.69519 3.44351 2.07653 1.08262 4.17964 0.923514C5.11831 0.852403 5.89786 1.17862 6.44808 1.86307C8.55564 4.48618 6.41608 12.0906 5.96631 13.5893C5.85075 13.9742 5.49697 14.2222 5.11475 14.2222Z" fill="#77B255"/>
                    <path d="M22.6666 9.77775C23.403 9.77775 23.9999 9.1808 23.9999 8.44442C23.9999 7.70804 23.403 7.11108 22.6666 7.11108C21.9302 7.11108 21.3333 7.70804 21.3333 8.44442C21.3333 9.1808 21.9302 9.77775 22.6666 9.77775Z" fill="#5C913B"/>
                    <path d="M1.77778 17.7777C2.75962 17.7777 3.55556 16.9818 3.55556 15.9999C3.55556 15.0181 2.75962 14.2222 1.77778 14.2222C0.795938 14.2222 0 15.0181 0 15.9999C0 16.9818 0.795938 17.7777 1.77778 17.7777Z" fill="#9266CC"/>
                    <path d="M28.889 18.6667C29.6254 18.6667 30.2223 18.0697 30.2223 17.3333C30.2223 16.597 29.6254 16 28.889 16C28.1526 16 27.5557 16.597 27.5557 17.3333C27.5557 18.0697 28.1526 18.6667 28.889 18.6667Z" fill="#5C913B"/>
                    <path d="M20.889 29.3333C21.6254 29.3333 22.2223 28.7363 22.2223 28C22.2223 27.2636 21.6254 26.6666 20.889 26.6666C20.1526 26.6666 19.5557 27.2636 19.5557 28C19.5557 28.7363 20.1526 29.3333 20.889 29.3333Z" fill="#5C913B"/>
                    <path d="M24.8889 5.33339C25.8707 5.33339 26.6666 4.53745 26.6666 3.55561C26.6666 2.57377 25.8707 1.77783 24.8889 1.77783C23.907 1.77783 23.1111 2.57377 23.1111 3.55561C23.1111 4.53745 23.907 5.33339 24.8889 5.33339Z" fill="#FFCC4D"/>
                    <path d="M28.889 8.88883C29.6254 8.88883 30.2223 8.29188 30.2223 7.5555C30.2223 6.81912 29.6254 6.22217 28.889 6.22217C28.1526 6.22217 27.5557 6.81912 27.5557 7.5555C27.5557 8.29188 28.1526 8.88883 28.889 8.88883Z" fill="#FFCC4D"/>
                    <path d="M26.2222 12.4445C26.9586 12.4445 27.5556 11.8475 27.5556 11.1112C27.5556 10.3748 26.9586 9.77783 26.2222 9.77783C25.4859 9.77783 24.8889 10.3748 24.8889 11.1112C24.8889 11.8475 25.4859 12.4445 26.2222 12.4445Z" fill="#FFCC4D"/>
                    <path d="M6.66659 22.2222C7.40296 22.2222 7.99992 21.6253 7.99992 20.8889C7.99992 20.1525 7.40296 19.5555 6.66659 19.5555C5.93021 19.5555 5.33325 20.1525 5.33325 20.8889C5.33325 21.6253 5.93021 22.2222 6.66659 22.2222Z" fill="#FFCC4D"/>
                    </g>
                    <defs>
                    <clipPath id="clip0">
                    <rect width="32" height="32" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>

                    <h3>
						<?php
						global $current_user;
						printf( __( 'Welcome Onboard, %s!', 'myaliceai' ), $current_user->display_name );
						?>
                    </h3>
                </div>
            </section>

            <section class="alice-registration-guide">
                <div class="alice-container">
                    <div class="alice-text-content">
                        <h4><?php esc_html_e( 'Complete Your Registration', 'myaliceai' ); ?></h4>
                        <p><?php _e( 'Please visit <a href="https://app.myalice.ai/" target="_blank">https://app.myalice.ai/</a> to complete your registration or log into your account', 'myaliceai' ); ?></p>
                    </div>
                    <div class="alice-btn-content">
                        <a href="https://docs.myalice.ai/getting-started/create-an-account#video-tutorial-for-signing-up-to-myalice" target="_blank"
                           class="alice-btn white-btn"><?php esc_html_e( 'Watch Video', 'myaliceai' ); ?></a>
                        <a href="https://docs.myalice.ai/getting-started/create-an-account" target="_blank"
                           class="alice-btn white-btn"><?php esc_html_e( 'Read Documentation', 'myaliceai' ); ?></a>
                    </div>
                </div>
            </section>

            <section class="alice-marketplace-connect-section">
                <div class="alice-container">
                    <div style="width: 100%;">
                        <div class="alice-container">
                            <div class="alice-text-content">
                                <h4><?php esc_html_e( 'Connect Marketplace in MyAlice', 'myaliceai' ); ?></h4>
                                <p><?php esc_html_e( 'Please complete the steps to connect your store with MyAlice', 'myaliceai' ); ?></p>
                            </div>
                            <div class="alice-btn-content">
                                <a href="https://docs.myalice.ai/getting-started/connect-your-marketplace#video-tutorial-for-connecting-your-woocommerce-marketplace"
                                   target="_blank" class="alice-btn white-btn"><?php esc_html_e( 'Watch Video', 'myaliceai' ); ?></a>
                                <a href="https://docs.myalice.ai/getting-started/connect-your-marketplace" target="_blank"
                                   class="alice-btn white-btn"><?php esc_html_e( 'Read Documentation', 'myaliceai' ); ?></a>
                            </div>
                        </div>
                        <ol>
                            <li><?php _e( 'Please log into your MyAlice account, then go to <b>Settings.</b>', 'myaliceai' ); ?></li>
                            <li><?php _e( 'From <b>Settings,</b> go to the <b>Marketplace Settings.</b> Here, you will be able to connect your WooCommerce Store.', 'myaliceai' ); ?></li>
                            <li><?php esc_html_e( 'Click on the Install button to connect your WooCommerce Store', 'myaliceai' ); ?></li>
                            <li><?php esc_html_e( 'Enter your store URL. For example: https://wc.mystore.com/', 'myaliceai' ); ?></li>
                            <li><?php esc_html_e( 'Install the webchat plugin so that your customers can interact with you!', 'myaliceai' ); ?></li>
                            <li><?php esc_html_e( 'Now, you can connect your store with an existing channel or connect to a new channel', 'myaliceai' ); ?></li>
                            <li><?php esc_html_e( 'After you are done connecting to your channel, you will receive a plugin key which you have to enter below.', 'myaliceai' ); ?></li>
                        </ol>
                    </div>
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
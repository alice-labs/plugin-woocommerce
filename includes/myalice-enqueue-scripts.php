<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

global $myalice_settings;

// Insert JS code in Footer
function alice_chatbot_script_callback() { ?>
    <script>
        !function () {
            var e = document.createElement("div");
            e.id = "myAliceWebChat";
            var t = document.createElement("script");
            t.type = "text/javascript",
            t.async = !0,
            t.src = "https://livechat.myalice.ai/index.js";
            var a = document.body.getElementsByTagName("script");
            (a = a[a.length - 1]).parentNode.insertBefore(t, a),
                a.parentNode.insertBefore(e, a),
                t.addEventListener("load", function () {
                MyAliceWebChat.init({
                    selector: '#myAliceWebChat',
                    platformId: '<?php echo esc_js( MYALICE_PLATFORM_ID ); ?>',
                    primaryId: '<?php echo esc_js( MYALICE_PRIMARY_ID ); ?>',
                    token: '<?php echo esc_js( MYALICE_API_TOKEN ); ?>'
                })
            })
        }();
    </script>
	<?php
}

//JS File will be enqueued if valid API are given.
if ( MYALICE_API_OK ) {
	add_action( 'wp_enqueue_scripts', function () {
		wp_enqueue_script( 'alice-script', ALICE_JS_PATH . 'script.js', [ 'jquery' ], ALICE_VERSION, false );
	} );

	if ( $myalice_settings['hide_chatbox'] === 0 && ( $myalice_settings['allow_chat_user_only'] === 0 || ( $myalice_settings['allow_chat_user_only'] === 1 && is_user_logged_in() ) ) ) {
		add_action( 'wp_footer', 'alice_chatbot_script_callback' );
	}
}
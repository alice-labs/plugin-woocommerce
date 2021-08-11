<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Admin Internal Script & Template
add_action( 'admin_footer', function () { ?>
    <div id="alice-feedback-modal" style="display: none;">
        <div class="alice-modal-bg"></div>
        <div class="alice-modal-body">
            <div class="alice-modal-header">
                <h3><?php esc_html_e( "We're sorry to see you go. If you have a moment, please let us know why you’re deactivating the plugin.", 'myaliceai' ); ?></h3>
                <div class="alice-modal-close">
                    <svg viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.5,1.5l-13,13m0-13,13,13" transform="translate(0 0)"></path>
                    </svg>
                </div>
            </div>
            <div class="alice-modal-content">
                <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( "I'm unable to get the plugin to work", 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'I no longer need the plugin', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'I found a better solution', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'The plugin is impacting website performance', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'This is a temporary deactivation. I’ll be back!', 'myaliceai' ); ?>
                        </label>
                    </div>
                    <div class="single-field">
                        <label>
                            <input type="radio" name="feedback" value=""> <?php esc_html_e( 'Other', 'myaliceai' ); ?> <input type="text" name=""
                                                                                                                              value="">
                        </label>
                    </div>
                    <div class="submission-button-field">
                        <button type="submit">
                            <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.540335 0.384995L11.7433 6.72599C11.7912 6.75489 11.8307 6.79517 11.8582 6.84303C11.8856 6.89089 11.9 6.94474 11.9 6.99949C11.9 7.05425 11.8856 7.1081 11.8582 7.15595C11.8307 7.20381 11.7912 7.24409 11.7433 7.27299L0.540335 13.615C0.49504 13.6419 0.442987 13.6561 0.389904 13.6561C0.336822 13.6561 0.284769 13.6419 0.239474 13.615C0.192756 13.5856 0.154586 13.5451 0.12861 13.4973C0.102635 13.4495 0.0897211 13.396 0.0911039 13.342V0.657995C0.0905368 0.604554 0.103944 0.551846 0.130072 0.504802C0.156201 0.457757 0.194196 0.417913 0.240504 0.388995C0.285303 0.361721 0.336964 0.346923 0.389842 0.346218C0.44272 0.345512 0.494781 0.358927 0.540335 0.384995ZM1.30382 7.62499V11.758L9.70939 6.99999L1.30485 2.24299V6.37499H4.33922V7.62499H1.30382Z" fill="#ffffff"/>
                            </svg>
							<?php esc_html_e( 'Submit & Deactivate', 'myaliceai' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function ($) {
            var alice_feedback_modal = $('#alice-feedback-modal');

            $(document).on('click', '#deactivate-myaliceai', function (e) {
                e.preventDefault();

                alice_feedback_modal.fadeIn();
                $('.submission-button-field button').attr('href', deactivate_url);
            }).on('click', '.alice-modal-close, .alice-modal-bg', function (e) {
                e.preventDefault();

                alice_feedback_modal.fadeOut();
            }).on('submit', '#alice-feedback-modal form', function (e) {
                e.preventDefault();

                var deactivate_url = $('#deactivate-myaliceai').attr('href');
                location.href = '<?php echo admin_url(); ?>' + deactivate_url;
            }).on('submit', '.alice-plugin-key form', function (e) {
                e.preventDefault();

                var $form = $(this),
                    url = $form.attr('action'),
                    data = $form.serialize(),
                    spinner = $form.find('.spinner');

                spinner.addClass('is-active');

                $.post(url, data, function (response) {
                    spinner.removeClass('is-active');

                    var notice_area = $('.myalice-notice-area'),
                        input_group = $('.alice-input-group'),
                        input_field = $('#alice-plugin-key');

                    if (response.success) {
                        notice_area.prepend(`<div class="updated"><p>${response.data.message}</p></div>`);
                        input_group.removeClass('alice-active-editing');
                        input_field.attr('readonly', 'readonly');
                    } else {
                        notice_area.prepend(`<div class="error"><p>${response.data.message}</p></div>`);
                    }

                    setTimeout(function () {
                        notice_area.html('');
                    }, 5000);
                });
            }).on('click', '.myalice-notice-dismiss', function(e) {
                e.preventDefault();
                var notice_wrap = $(this).closest('.notice.notice-info');

                $.post(ajaxurl, {action: 'myalice_notice_dismiss'}, function (response) {
                    if (response.success) {
                        notice_wrap.remove();
                    }
                });
            }).on('click', '.alice-edit-btn, .alice-cancel-btn', function (e) {
                e.preventDefault();

                var $this = $(this),
                    input_group = $('.alice-input-group'),
                    input_field = $('#alice-plugin-key');

                input_group.toggleClass('alice-active-editing');
                if ($this.hasClass('alice-cancel-btn')) {
                    input_field.attr('readonly', 'readonly');
                } else {
                    input_field.removeAttr('readonly');
                }
            });
        })(jQuery);
    </script>
	<?php
} );
<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Admin Internal Style
add_action( 'admin_head', function () { ?>
    <style>
        #adminmenu .toplevel_page_myalice_dashboard > .wp-menu-image > img {
            padding: 5px 0 0 0;
            opacity: 1;
            filter: grayscale(1);
        }

        #adminmenu .toplevel_page_myalice_dashboard:hover > .wp-menu-image > img {
            filter: grayscale(0);
        }

        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard {
            background: linear-gradient(to left, #2271b1 50%, transparent 90%);
        }

        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard > .wp-menu-image > img {
            filter: grayscale(0);
        }

        #alice-feedback-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
        }

        #alice-feedback-modal * {
            box-sizing: border-box;
        }

        #alice-feedback-modal .alice-modal-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .7);
            z-index: 1;
            cursor: pointer;
        }

        #alice-feedback-modal .alice-modal-body {
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            top: 20%;
            z-index: 2;
            width: 500px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .5);
            border-radius: 5px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header {
            background: linear-gradient(45deg, #04B35F 50%, #FFD82F);
            padding: 20px;
            border-radius: 5px 5px 0 0;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #f5d631;
            position: absolute;
            right: -12px;
            top: -12px;
            cursor: pointer;
            transition: .3s;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close:hover {
            transform: scale(1.3);
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close svg {
            width: 15px;
            margin: 4px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header .alice-modal-close svg path {
            stroke: red;
            stroke-width: 2;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-header h3 {
            color: #fff;
            font-size: 18px;
            margin: 0;
            line-height: 1.4;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content {
            padding: 20px;
            font-size: 16px;
            line-height: 1.4;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field {
            padding: 5px 0;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label {
            font-size: 16px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label input[type="text"] {
            width: 60%;
            margin-left: 10px;
            display: none;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .single-field label input[type="radio"]:checked ~ input[type="text"] {
            display: inline-block;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field {
            padding-top: 20px;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button {
            background: #04B35F;
            border: 0;
            padding: 0 15px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            line-height: 40px;
            height: 40px;
            cursor: pointer;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button:hover {
            background: #028948;
        }

        #alice-feedback-modal .alice-modal-body .alice-modal-content .submission-button-field button svg {
            margin-right: 5px;
        }

        .alice-dashboard-tab-content th.disabled {
            opacity: .6;
        }
    </style>
	<?php
} );
<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Admin Internal Style
add_action( 'admin_head', function () { ?>
    <style>
        /* Alice Admin Menu */
        #adminmenu #toplevel_page_myalice_dashboard div.wp-menu-image.svg {
            background-size: 16px auto;
            filter: grayscale(1);
        }

        #adminmenu #toplevel_page_myalice_dashboard:hover div.wp-menu-image.svg {
            filter: grayscale(0);
        }

        #adminmenu li.current a.menu-top.toplevel_page_myalice_dashboard {
            background: linear-gradient(to left, #2271b1 50%, transparent 90%);
        }

        #adminmenu li#toplevel_page_myalice_dashboard.current a.menu-top.toplevel_page_myalice_dashboard div.wp-menu-image.svg {
            filter: grayscale(0);
        }

        /* Alice Deactivation Feedback Modal */
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

        /* Alice Dashboard */
        #alice-dashboard * {
            box-sizing: border-box;
        }

        #alice-dashboard h1,
        #alice-dashboard h2,
        #alice-dashboard h3,
        #alice-dashboard h4,
        #alice-dashboard h5,
        #alice-dashboard h6,
        #alice-dashboard p,
        #alice-dashboard ul,
        #alice-dashboard ol,
        #alice-dashboard li,
        #alice-dashboard a,
        #alice-dashboard button {
            margin: 0;
            padding: 0;
        }

        #alice-dashboard .alice-container {
            max-width: 956px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #alice-dashboard .alice-btn {
            background: #04B25F;
            color: #fff;
            border-radius: 6px;
            font-size: 16px;
            line-height: 40px;
            border: 1px solid transparent;
            padding: 0 17px;
            text-decoration: none;
            transition: .3s;
            display: inline-block;
            cursor: pointer;
        }

        #alice-dashboard .alice-btn:hover {
            background: #039952;
            color: #fff;
        }

        #alice-dashboard .alice-btn.white-btn {
            background: #fff;
            border: 1px solid #D1D5DB;
            color: #374151;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        #alice-dashboard .alice-btn.white-btn:hover {
            box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.2);
            color: #000;
        }

        #alice-dashboard .alice-input-field {
            line-height: 40px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            font-size: 14px;
            width: 400px;
            padding: 0 12px;
            color: #6B7280;
        }

        #alice-dashboard .alice-dashboard-header {
            background: #fff;
            padding: 20px 0;
        }

        #alice-dashboard  .alice-welcome-section {
            margin-top: 24px;
            padding: 12px 0;
        }

        #alice-dashboard  .alice-welcome-section h3 {
            font-size: 24px;
            line-height: 32px;
            color: #111827;
            margin-left: 12px;
            font-weight: 700;
        }

        #alice-dashboard .alice-welcome-section .alice-container {
            justify-content: initial;
        }

        #alice-dashboard .alice-registration-guide {
            margin-top: 12px;
        }

        #alice-dashboard .alice-registration-guide .alice-container {
            background: #fff;
            border-radius: 8px;
            padding: 38px 24px;
        }

        #alice-dashboard .alice-text-content {
            border-left: 4px solid #04B25F;
            padding-left: 12px;
            width: 50%;
        }

        #alice-dashboard .alice-text-content h4 {
            font-size: 18px;
            color: #111827;
            margin-bottom: 10px;
        }

        #alice-dashboard .alice-text-content p {
            font-size: 14px;
            color: #6B7280;
        }

        #alice-dashboard .alice-btn-content .alice-btn + .alice-btn {
            margin-left: 12px;
        }

        #alice-dashboard .alice-marketplace-connect-section > .alice-container,
        #alice-dashboard .alice-plugin-key-section > .alice-container,
        #alice-dashboard .alice-settings-section > .alice-container {
            background: #fff;
            border-radius: 8px;
            padding: 24px;
            margin-top: 24px;
        }

        #alice-dashboard .alice-marketplace-connect-section > .alice-container .alice-container {
            padding-bottom: 8px;
        }

        #alice-dashboard .alice-marketplace-connect-section .alice-text-content,
        #alice-dashboard .alice-plugin-key-section .alice-text-content,
        #alice-dashboard .alice-settings-section .alice-text-content {
            border: none;
            padding: 0
        }

        #alice-dashboard .alice-marketplace-connect-section ol {
            border-top: 1px solid #D1D5DB;
            padding: 15px 0 0 15px;
        }

        #alice-dashboard .alice-marketplace-connect-section ol li {
            font-size: 14px;
            line-height: 22px;
            color: #111827;
        }

        #alice-dashboard .alice-plugin-key-section .alice-text-content {
            width: 70%;
        }

        #alice-dashboard .alice-plugin-key {
            margin-top: 20px;
        }

        #alice-dashboard .alice-plugin-key-section .alice-input-group > * + * {
            margin-left: 12px;
        }

        #alice-dashboard .alice-plugin-key input.alice-input-field {
            background: #E5E7EB;
        }

        #alice-dashboard .alice-plugin-key [type="submit"] {
            display: none;
        }

        #alice-dashboard .alice-plugin-key .alice-edit-btn {
            display: inline-block;
        }

        #alice-dashboard .alice-plugin-key .alice-cancel-btn {
            display: none;
        }

        #alice-dashboard .alice-plugin-key .alice-active-editing input.alice-input-field {
            background: #FFFFFF;
        }

        #alice-dashboard .alice-plugin-key-section .alice-active-editing [type="submit"] {
            display: inline-block;
        }

        #alice-dashboard .alice-plugin-key .alice-active-editing .alice-edit-btn {
            display: none;
        }

        #alice-dashboard .alice-plugin-key .alice-active-editing .alice-cancel-btn {
            display: inline-block;
        }

        #alice-dashboard.myalice-api-activated .alice-registration-guide,
        #alice-dashboard.myalice-api-activated .alice-marketplace-connect-section {
            display: none;
        }

        #alice-dashboard .spinner {
            display: none;
            margin: 0;
        }

        #alice-dashboard .spinner.is-active {
            display: inline-block;
            float: none;
        }
    </style>
	<?php
} );
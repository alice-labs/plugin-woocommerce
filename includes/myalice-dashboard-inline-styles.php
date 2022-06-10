<?php
// Direct file access is disallowed
defined( 'ABSPATH' ) || die;

// Admin Internal Style
add_action( 'admin_head', function () { ?>
    <style>
        /* === Alice Admin Menu === */
        #adminmenu #toplevel_page_myalice_dashboard div.wp-menu-image > img {
            padding-top: 8px;
        }

        #adminmenu li#toplevel_page_myalice_dashboard.current a.menu-top.toplevel_page_myalice_dashboard div.wp-menu-image > img {
            opacity: 1;
        }

        /* === Alice Deactivation Feedback Modal === */
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

        /* === Alice Dashboard === */
        #alice-dashboard {
            background: #FFFFFF;
            border: 1px solid #CCCCCC;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
            border-radius: 6px;
            overflow: hidden;
        }

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
            text-decoration: none;
        }

        #alice-dashboard p {
            color: #4B5563;
        }

        #alice-dashboard p a {
            color: #0078CF;
            font-weight: 500;
        }

        #alice-dashboard p a:hover {
            text-decoration: underline;
        }

        #alice-dashboard,
        #alice-dashboard span,
        #alice-dashboard label,
        #alice-dashboard p {
            font-size: 14px;
            line-height: 20px;
            font-weight: 400;
        }

        #alice-dashboard .alice-container {
            max-width: 956px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #alice-dashboard .alice-btn {
            background: #04B25F;
            color: #fff;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            line-height: 42px;
            border: 1px solid transparent;
            padding: 0 17px;
            text-decoration: none;
            transition: .3s;
            display: inline-block;
            cursor: pointer;
        }

        #alice-dashboard .alice-btn > span {
            display: block;
            line-height: inherit;
            font-size: inherit;
            font-weight: inherit;
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

        #alice-dashboard form label {
            display: block;
            font-weight: 500;
        }

        #alice-dashboard form label + label {
            margin-top: 12px;
        }

        #alice-dashboard label input {
            display: block;
            line-height: 36px;
            border: 1px solid #D1D5DB;
            border-radius: 6px;
            width: 350px;
            padding: 0 12px;
            color: #111827;
            font-weight: 400;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        #alice-dashboard .alice-title {
            text-align: center;
        }

        #alice-dashboard .alice-title h2 {
            font-size: 24px;
            line-height: 32px;
            font-weight: 800;
            color: #111827;
        }

        #alice-dashboard .alice-title h2 ~ p {
            margin-top: 4px;
        }

        /* dashboard header section */
        #alice-dashboard .alice-dashboard-header {
            background: #fff;
            padding: 20px 0;
        }

        #alice-dashboard .alice-dashboard-header .alice-container {
            justify-content: space-between;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul {
            display: flex;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li {
            display: flex;
            align-content: center;
            align-items: center;
            margin: 0 12px;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li.alice-has-sub-menu {
            position: relative;
            perspective: 390px;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li.alice-has-sub-menu::after {
            position: relative;
            content: "";
            border-top: 5px solid #5C5F62;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            margin-left: 12px;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li a {
            display: block;
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            color: #202223;
            transition: .3s;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li.alice-active > a,
        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li:hover > a {
            color: #039952;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li.alice-has-sub-menu.alice-active::after,
        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li.alice-has-sub-menu:hover::after {
            border-top-color: #039952;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li ul.alice-sub-menu {
            display: block;
            position: absolute;
            top: 100%;
            right: 0;
            width: 170px;
            padding-top: 8px;
            box-shadow: 0 4px 6px -2px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            text-align: right;
            transform-origin: top center;
            transform: rotateX(-90deg);
            transition: .3s;
            opacity: 0;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li ul.alice-sub-menu li {
            display: block;
            margin: 0;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li ul.alice-sub-menu li + li {
            border-top: 1px solid #eee;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li ul.alice-sub-menu li a {
            margin: 0;
            padding: 8px 16px 8px 0;
        }

        #alice-dashboard .alice-dashboard-header .alice-main-menu ul li:hover .alice-sub-menu {
            transform: rotateX(0deg);
            opacity: 1;
        }

        /* dashboard connect-with-myalice section */
        #alice-dashboard .alice-connect-with-myalice {
            padding: 100px 0 200px;
            background-position: bottom center;
            background-repeat: no-repeat;
            background-size: 100%;
            background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIxNiIgaGVpZ2h0PSI1MjciIHZpZXdCb3g9IjAgMCAxMjE2IDUyNyIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEuMzMxMjIgNDY3Ljg3NkMtMC43NjM5NTYgNDI2LjI5MSAyMi45NDc0IDMzNi4xODIgMTM0LjU1NSAzMDguNDExQzI3NC4wNjMgMjczLjY5NyA1OTQuNzYxIDQwMi4xMzEgNTQ4LjA1MiA1MDQuNzU5QzUxNS4zODcgNTc2LjUzMiAzODcuMDgzIDQ1Mi4xNTQgNjA3LjEyNCAzNzEuMzI5Qzc3My4xNDMgMzEwLjM0NiA4ODYuMzA3IDMyMy43MTUgOTcxLjQ3OCAzMDguNDExQzEwOTkuMjkgMjg1LjQ0NSAxMTczLjcgMTcyLjQwMSAxMTczLjY4IDEzNy43NDEiIHN0cm9rZT0iI0I5RjBFOSIvPgo8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTExMzguODMgMTI3Ljg5NEwxMTY3LjEgNzguMTE5NEwxMTk1LjIgMTE4LjkwMUwxMTM4LjgzIDEyNy44OTRaIiBzdHJva2U9IiNCOUYwRTkiIHN0cm9rZS13aWR0aD0iMS4yMTg2MSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0xMTY3LjIgNzguMjA1MkwxMTYxLjY0IDEyNC4zMTUiIHN0cm9rZT0iI0I5RjBFOSIgc3Ryb2tlLXdpZHRoPSIxLjIxODYxIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPHBhdGggZD0iTTExNjEuNTUgMTI0LjM3NEwxMTczLjY3IDEzNy41ODNMMTE3NC43NCAxMjIuNTIyIiBzdHJva2U9IiNCOUYwRTkiIHN0cm9rZS13aWR0aD0iMS4yMTg2MSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+CjxwYXRoIGQ9Ik0yMzMuOTM5IDIwMi41MTVMMjYxLjQxMiAxOTYuNTRMMjY4LjY5IDIyMS40N0wyNTEuMTYgMjI1LjI4MkwyMzMuOTM5IDIwMi41MTVaIiBmaWxsPSIjRkZFNEM5Ii8+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgY2xpcC1ydWxlPSJldmVub2RkIiBkPSJNMjg5LjYwOCAxNzguNjkzTDI3Ni41MjQgMTgxLjUzOUwyNzQuMTU5IDE5MC4zNTVMMjQyLjk4NSAxOTcuMTM0TDI1MS4xOTkgMjI1LjI3NEwzMDAuMTA0IDIxNC42MzhMMjkxLjg4OCAxODYuNDk4SDI5MS44ODdMMjg5LjYwOCAxNzguNjkzWiIgZmlsbD0iI0ZGRjJFNSIvPgo8cGF0aCBkPSJNMTQ4LjM1MiAzMjYuNTg0SDQ3LjY3MTlWMzQ4LjQ3NUgxNDguMzUyVjMyNi41ODRaIiBmaWxsPSIjQ0RGMERGIi8+CjxwYXRoIGQ9Ik02MS45MDYzIDM0My42NzhDNjUuODQwNiAzNDMuNjc4IDY5LjAzIDM0MC45MjUgNjkuMDMgMzM3LjUzQzY5LjAzIDMzNC4xMzQgNjUuODQwNiAzMzEuMzgxIDYxLjkwNjMgMzMxLjM4MUM1Ny45NzIxIDMzMS4zODEgNTQuNzgyNyAzMzQuMTM0IDU0Ljc4MjcgMzM3LjUzQzU0Ljc4MjcgMzQwLjkyNSA1Ny45NzIxIDM0My42NzggNjEuOTA2MyAzNDMuNjc4WiIgZmlsbD0iI0VBRkFGMyIvPgo8cGF0aCBkPSJNMTMzLjMzNSAzMzMuOTA3SDc5LjA0MTVWMzM3LjAwNEgxMzMuMzM1VjMzMy45MDdaIiBmaWxsPSIjRUFGQUYzIi8+CjxwYXRoIGQ9Ik0xMDkuNzk5IDMzOS42NzFINzkuMDQxNVYzNDEuMTUySDEwOS43OTlWMzM5LjY3MVoiIGZpbGw9IiNFQUZBRjMiLz4KPHBhdGggZD0iTTEwOTYuNzEgMjczLjk1N0gxMDI1LjY2VjI5OS43MDRIMTA3OS43MkwxMDkyLjIgMzEwLjQ3NlYyOTkuNzA0SDEwOTYuNzFWMjczLjk1N1oiIGZpbGw9IiNFMkY0RjUiLz4KPHBhdGggZD0iTTEwODYuODMgMjgwLjgzMUgxMDMzLjgzVjI4Mi40NjVIMTA4Ni44M1YyODAuODMxWiIgZmlsbD0iI0FFRUVGMSIvPgo8cGF0aCBkPSJNMTA3NC40IDI4NS4xNzdIMTAzMy44M1YyODYuODExSDEwNzQuNFYyODUuMTc3WiIgZmlsbD0iI0FFRUVGMSIvPgo8cGF0aCBkPSJNMTA2MS41NSAyODkuNTIzSDEwMzMuODNWMjkxLjE1N0gxMDYxLjU1VjI4OS41MjNaIiBmaWxsPSIjQUVFRUYxIi8+CjxwYXRoIGQ9Ik05ODUuNTE2IDIzNy40MzlIMTA1Ni41N1YyNjMuMTg1SDEwMDIuNUw5OTAuMDI1IDI3My45NTdWMjYzLjE4NUg5ODUuNTE2VjIzNy40MzlaIiBmaWxsPSIjRTJGNEY1Ii8+CjxwYXRoIGQ9Ik05OTUuMzk1IDI0NC4zMTJIMTA0OC40VjI0NS45NDZIOTk1LjM5NVYyNDQuMzEyWiIgZmlsbD0iI0FFRUVGMSIvPgo8cGF0aCBkPSJNOTk1LjM5NyAyNDguNjU5SDEwMzUuOTdWMjUwLjI5M0g5OTUuMzk3VjI0OC42NTlaIiBmaWxsPSIjQUVFRUYxIi8+CjxwYXRoIGQ9Ik05OTUuMzk1IDI1My4wMDVIMTAyMy4xMlYyNTQuNjM5SDk5NS4zOTVWMjUzLjAwNVoiIGZpbGw9IiNBRUVFRjEiLz4KPHBhdGggZD0iTTExNDAuMjUgNi4yMDg4N0gxMTY4LjY4TDExNjkuOTggMzIuMjAwOUgxMTM4Ljk2TDExNDAuMjUgNi4yMDg4N1oiIGZpbGw9IiNGRkYyRTUiLz4KPHBhdGggZD0iTTExNTkuOTUgNi4yMDkwOUMxMTU5Ljk1IDMuNTk4OTMgMTE1Ny40OSAxLjQ4Mjk4IDExNTQuNDcgMS40ODI5OEMxMTUxLjQ0IDEuNDgyOTggMTE0OC45OSAzLjU5ODkzIDExNDguOTkgNi4yMDkwOSIgc3Ryb2tlPSIjRkZFNEM5IiBzdHJva2Utd2lkdGg9IjEuNjY2NzciLz4KPHBhdGggZD0iTTExNTQuOTkgMTQyLjkwOEMxMTUzLjcyIDE0NC43NTggMTE1MC41NCAxNTAuNzggMTE1MC41OCAxNTIuNzc5QzExNTAuNjYgMTU3LjIyNiAxMTU0Ljk1IDE2MS43NzggMTE1Ny43NyAxNjAuMTE0QzExNjIuOSAxNTcuMDk5IDExNTMuNzkgMTQ5LjA3NiAxMTQ1LjE4IDE1NS4xNTVDMTEzNi41NyAxNjEuMjMzIDExMzYuOTggMTY4Ljc3MyAxMTQwLjY4IDE2OC41MTdDMTE0NC40IDE2OC4yNjIgMTE0NS45MyAxNTkuMDMxIDExMjcuOTQgMTYyLjU1MiIgc3Ryb2tlPSIjQjlGMEU5Ii8+CjxwYXRoIGQ9Ik0xMTgzIDE0MS4wODNDMTE4NS40OCAxNDEuNjAzIDExOTEuNzggMTQ0LjMzNSAxMTk3LjEgMTUxLjEwOUMxMjAzLjc0IDE1OS41NzQgMTE5Mi4zMiAxNjYuMTk4IDExODguODIgMTYxLjYyNUMxMTg1LjMyIDE1Ny4wNTMgMTIwMi40NSAxNTMuOTA1IDEyMDQuNjkgMTY2LjYzOEMxMjA1LjM3IDE2OC44NiAxMjA1LjM4IDE3NS4wMzggMTE5OS45NSAxODEuOTg2IiBzdHJva2U9IiNCOUYwRTkiLz4KPHBhdGggZD0iTTQ0LjAwNTQgMzIyLjEzOEwzNy4yODU2IDMxNy43OTQiIHN0cm9rZT0iI0NERjBERiIgc3Ryb2tlLXdpZHRoPSIwLjQzMDcyMyIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjxwYXRoIGQ9Ik00Ny40MjA1IDMxOS43ODNMNDYuNjI2NSAzMTUuMzI4IiBzdHJva2U9IiNDREYwREYiIHN0cm9rZS13aWR0aD0iMC40MzA3MjMiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8cGF0aCBkPSJNNDEuODI3NSAzMjYuMzQ2TDM2LjI2MDcgMzI2Ljc1OSIgc3Ryb2tlPSIjQ0RGMERGIiBzdHJva2Utd2lkdGg9IjAuNDMwNzIzIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPHBhdGggZD0iTTExMDAuMzcgMjcwLjE3M0wxMTA3LjA5IDI2NS44MjkiIHN0cm9rZT0iI0NERjBERiIgc3Ryb2tlLXdpZHRoPSIwLjQzMDcyMyIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjxwYXRoIGQ9Ik0xMDk2Ljk2IDI2Ny44MTdMMTA5Ny43NSAyNjMuMzYyIiBzdHJva2U9IiNDREYwREYiIHN0cm9rZS13aWR0aD0iMC40MzA3MjMiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8cGF0aCBkPSJNMTEwMi41NSAyNzQuMzhMMTEwOC4xMiAyNzQuNzkzIiBzdHJva2U9IiNDREYwREYiIHN0cm9rZS13aWR0aD0iMC40MzA3MjMiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L3N2Zz4K")
        }
        #alice-dashboard .alice-connect-with-myalice form {
            margin-top: 24px;
        }
        #alice-dashboard .alice-connect-with-myalice form button.alice-btn {
            margin-top: 24px;
            width: 100%;
        }

        #alice-dashboard .alice-connect-with-myalice form button.alice-btn ~ p {
            margin-top: 16px;
        }

        #alice-dashboard .alice-connect-with-myalice.alice-login-active .--signup-component,
        #alice-dashboard .alice-connect-with-myalice .--login-component {
            display: none;
        }

        #alice-dashboard .alice-connect-with-myalice .--signup-component,
        #alice-dashboard .alice-connect-with-myalice.alice-login-active .--login-component {
            display: block;
        }

        /* dashboard welcome section */
        #alice-dashboard .alice-welcome-section {
            margin-top: 24px;
            padding: 12px 0;
        }

        #alice-dashboard .alice-welcome-section h3 {
            font-size: 24px;
            line-height: 32px;
            color: #111827;
            margin-left: 12px;
            font-weight: 700;
        }

        #alice-dashboard .alice-welcome-section .alice-container {
            justify-content: initial;
        }

        /* dashboard registration guide section */
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

        /* dashboard marketplace, plugin key, settings section */
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
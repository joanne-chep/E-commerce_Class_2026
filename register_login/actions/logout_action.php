<?php
require_once "../core/core.php";

// Reset all session data
$_SESSION = array();

// Clear the session cookie from the browser
if (ini_get("session.use_cookies")) {
    $settings = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 3600,
        $settings['path'],
        $settings['domain'],
        $settings['secure'],
        $settings['httponly']
    );
}

// End the session
session_destroy();

// Redirect back to login
redirect("../view/login.php");
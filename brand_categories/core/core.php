<?php
// Start output buffering so headers/redirects can be sent anywhere without errors
ob_start();

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Check if the current user is authenticated.
function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}

//Check if the logged-in user is an administrator.

function is_admin()
{
    return isset($_SESSION['user_role']) && (int)$_SESSION['user_role'] === 1;
}

// Ensure that only authenticated users can access certain pages. If not logged in, redirect to the login page.
function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['error'] = "You must log in to access this page.";
        redirect("../view/login.php");
    }

}

// Ensure that only administrators can access certain pages.
function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = "Access Denied!";
        redirect("../index.php");
    }
}

// Get the active customer's unique ID.
function get_user_id()
{
    return $_SESSION['customer_id'] ?? null;
}

// Get the active customer's role.
function get_user_role()
{
    return $_SESSION['user_role'] ?? null;
}

// Redirect utility helper.
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

// TODO: session timeout
// Track the time of the last request. If too much time has passed
// since then, log the user out automatically.

// TODO: detect session hijacking
// Store the user's IP address and browser (User-Agent) at login.
// On every page load, compare them to the current request - if
// they don't match, something is wrong, so log the user out.

// TODO: secure logout
// A function that clears all session data, deletes the session
// cookie, destroys the session, and starts a fresh one - used by
// both a manual "log out" click and the automatic checks above.

// TODO: actually run the session check(s) above
// Whatever function ties this all together (e.g. sessionSecurity())
// should be called here, so simply including this file is enough
// to protect a page - no extra function calls needed on every page.

?>

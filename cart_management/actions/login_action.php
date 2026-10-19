<?php
// Handles authentication requests, coordinates with CustomerController, and manages session state.

require_once "../core/core.php";
require_once "../controller/CustomerController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Restrict access strictly to POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/login.php");
    exit();
}

// Retrieve and sanitise form input
$email = isset($_POST['customer_email']) ? trim(strip_tags($_POST['customer_email'])) : '';
$pass  = isset($_POST['customer_pass'])  ? trim($_POST['customer_pass']) : '';

// Validate that required fields are populated
if (empty($email) || empty($pass)) {
    $_SESSION['error'] = "Please provide both your email address and password.";
    redirect("../view/login.php");
    exit();
}

// Delegate credential authentication to the controller
$controller = new CustomerController();
$result = $controller->login($email, $pass);

if (isset($result['success']) && $result['success'] === true) {
    // Populate session with authenticated customer details
    $_SESSION['customer_id']    = $result['customer']['customer_id'];
    $_SESSION['customer_name']  = $result['customer']['customer_name'];
    $_SESSION['customer_email'] = $result['customer']['customer_email'];
    $_SESSION['user_role']      = $result['customer']['user_role'];

    redirect("../index.php");
    exit();
} else {
    // Store failure message and redirect back to login
    $_SESSION['error'] = isset($result['error']) ? $result['error'] : "Invalid email or password.";
    redirect("../view/login.php");
    exit();
}
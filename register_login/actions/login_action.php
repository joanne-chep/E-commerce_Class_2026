<?php
//This file handles the login process for customers. It validates the input,
// checks credentials against the database, and manages session variables upon successful authentication.

require_once "../core/core.php";
require_once "../controller/CustomerController.php";

// Ensure that POST requests are used for login attempts to prevent sensitive data from being exposed in URLs.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/login.php");
}

// Sanitize and validate incoming form data to ensure data integrity.
$email = isset($_POST['customer_email']) ? trim(strip_tags($_POST['customer_email'])) : '';
$pass  = isset($_POST['customer_pass'])  ? trim($_POST['customer_pass'])               : '';

// Reject empty submissions before running database operations.
if (empty($email) || empty($pass)) {
    $_SESSION['error'] = "Please provide both your email address and password.";
    redirect("../view/login.php");
}

// Delegate credential authentication to the controller.
$controller = new CustomerController();
$result = $controller->login($email, $pass);

if ($result['success']) {
    // If login is successful, store essential customer information in session variables for use across the application.
    $_SESSION['customer_id']   = $result['customer']['customer_id'];
    $_SESSION['customer_name'] = $result['customer']['customer_name'];
    $_SESSION['customer_email']= $result['customer']['customer_email'];
    $_SESSION['user_role']     = $result['customer']['user_role'];

    // Redirect the user to the homepage after successful login.
    redirect("../index.php");
} else {
    // If login fails, store the error message in the session and redirect back to the login form.
    $_SESSION['error'] = $result['error'];
    redirect("../view/login.php");
}
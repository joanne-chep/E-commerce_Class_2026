<?php
// This file is the backend processing endpoint for customer
// registration form submissions.

require_once "../core/core.php";
require_once "../controller/CustomerController.php";

// If the request method is not POST, redirect the user back to the registration form.
// This prevents direct access to this script via GET requests, which could lead to security issues.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/register.php");
}

// Sanitize and validate incoming form data to ensure data integrity.
// Passwords are not stripped of HTML tags to preserve their intended characters.
$name    = isset($_POST['customer_name'])    ? trim(strip_tags($_POST['customer_name']))    : '';
$email   = isset($_POST['customer_email'])   ? trim(strip_tags($_POST['customer_email']))   : '';
$pass    = isset($_POST['customer_pass'])    ? trim($_POST['customer_pass'])                 : '';
$country = isset($_POST['customer_country']) ? trim(strip_tags($_POST['customer_country'])) : '';
$city    = isset($_POST['customer_city'])    ? trim(strip_tags($_POST['customer_city']))    : '';
$contact = isset($_POST['customer_contact']) ? trim(strip_tags($_POST['customer_contact'])) : '';

// Ensure that all required fields are filled out before proceeding.
if (empty($name) || empty($email) || empty($pass) || empty($country) || empty($city) || empty($contact)) {
    $_SESSION['error'] = "All required fields must be filled!";
    redirect("../view/register.php");
}

// Ensure that the email provided is valid.
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Please provide a valid email address.";
    redirect("../view/register.php");
}

// Ensure that the details provided are within reasonable length limits to prevent database issues.
// Check for emails.
if (strlen($email) > 50) {
    $_SESSION['error'] = "Email address cannot exceed 50 characters.";
    redirect("../view/register.php");
}

// Check for names.
if (strlen($name) > 100) {
    $_SESSION['error'] = "Full name cannot exceed 100 characters.";
    redirect("../view/register.php");
}

// Check for country and city.
if (strlen($country) > 30 || strlen($city) > 30) {
    $_SESSION['error'] = "Country and city cannot exceed 30 characters each.";
    redirect("../view/register.php");
}

// Check for contact number length.
if (strlen($contact) > 15) {
    $_SESSION['error'] = "Contact number cannot exceed 15 digits.";
    redirect("../view/register.php");
}

// Prepare the data payload to send to the controller for processing.
$payload = [
    'name'    => $name,
    'email'   => $email,
    'pass'    => $pass,
    'country' => $country,
    'city'    => $city,
    'contact' => $contact,
    'image'   => null
];

// Hand over the data to the controller layer to manage business logic and database persistence.
$controller = new CustomerController();
$result = $controller->register($payload);

if ($result['success']) {
    // If registration is successful, automatically log the user in by setting session variables.
    $authCheck = $controller->login($email, $pass);

    if ($authCheck['success']) {
        $_SESSION['customer_id']   = $authCheck['customer']['customer_id'];
        $_SESSION['customer_name'] = $authCheck['customer']['customer_name'];
        $_SESSION['customer_email']= $authCheck['customer']['customer_email'];
        $_SESSION['user_role']     = $authCheck['customer']['user_role'];
    }

    // Redirect the user to the homepage after successful registration and login.
    redirect("../index.php");
} else {
    // If registration fails, store the error message in the session and redirect back to the registration form.
    $_SESSION['error'] = $result['error'];
    redirect("../view/register.php");
}
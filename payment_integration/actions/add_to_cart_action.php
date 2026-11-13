<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Action script processing incoming GET requests to append products to the cart table
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

// Safeguard against missing session context
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validate incoming product identifier parameter from GET string
$productId = isset($_GET['add_cart']) ? filter_var($_GET['add_cart'], FILTER_VALIDATE_INT) : null;

// Determine redirection fallback if referring URL is not present
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../view/home.php';

if (!$productId || $productId <= 0) {
    header("Location: " . $referer);
    exit();
}

// Obtain client IP address using the core helper function
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$cartController = new CartController();

// Verify whether product already resides in cart to prevent duplicates
if ($cartController->isInCart($productId, $ip)) {
    $_SESSION['error'] = "This item is already in your cart. Go to cart to update quantity.";
    header("Location: " . $referer);
    exit();
}

// Insert into cart with a default quantity of 1
$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$cartController->addToCart($productId, 1, $ip, $customer_id);

$_SESSION['success'] = "Product added to cart successfully.";
header("Location: " . $referer);
exit();
<?php
// Handles server-side Paystack verification and invokes atomic order persistence
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$reference = isset($_GET['ref']) ? trim($_GET['ref']) : null;

if (!$reference) {
    $_SESSION['error'] = "Missing payment reference identifier.";
    header("Location: ../view/payment_failed.php");
    exit();
}

// Paystack server-to-server transaction verification endpoint
$url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);
$secretKey = "sk_test_5b8fbd6f3fa47e34e6b1f1910234a24477a0669b";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $secretKey,
    "Cache-Control: no-cache",
]);

$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    $_SESSION['error'] = "Payment verification service could not be reached: " . $curlError;
    header("Location: ../view/payment_failed.php");
    exit();
}

$result = json_decode($response, true);

// Confirm payment status returned directly by Paystack API
if ($result && isset($result['status']) && $result['status'] === true && isset($result['data']['status']) && $result['data']['status'] === 'success') {
    $amountPaid = $result['data']['amount'] / 100;
    $customer_id = get_user_id();
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    if (!$customer_id) {
        $_SESSION['error'] = "Your session has expired. Please log in again.";
        header("Location: ../view/login.php");
        exit();
    }

    $cartController = new CartController();
    $order_id = $cartController->processPayment($customer_id, $ip, $reference, $amountPaid);

    if ($order_id) {
        header("Location: ../view/payment_success.php?order_id=" . (int)$order_id);
        exit();
    } else {
        $_SESSION['error'] = "Payment was successful, but your order could not be registered.";
        header("Location: ../view/payment_failed.php");
        exit();
    }
} else {
    $_SESSION['error'] = $result['message'] ?? "Transaction verification failed.";
    header("Location: ../view/payment_failed.php");
    exit();
}
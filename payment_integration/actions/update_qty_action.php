<?php
// Action script processing POST form submissions to update line-item quantities
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

// Safeguard against missing session context
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enforce POST method restriction
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/cart.php");
    exit();
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$cartController = new CartController();

// Loop through submitted product update array and corresponding quantity inputs
if (isset($_POST['update']) && is_array($_POST['update']) && isset($_POST['qty']) && is_array($_POST['qty'])) {
    $product_ids = $_POST['update'];
    $quantities = $_POST['qty'];

    for ($i = 0; $i < count($product_ids); $i++) {
        $productId = filter_var($product_ids[$i], FILTER_VALIDATE_INT);
        $newQty = filter_var($quantities[$i], FILTER_VALIDATE_INT);

        // Apply update only if quantity is a valid integer equal to or greater than 1
        if ($productId && $productId > 0 && $newQty && $newQty >= 1) {
            $cartController->updateQty($productId, $newQty, $ip);
        }
    }

    $_SESSION['success'] = "Cart quantities updated successfully.";
}

header("Location: ../view/cart.php");
exit();
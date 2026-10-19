<?php
// Action script processing POST form submissions to delete selected items from the cart
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

// Check if any checkboxes were selected for deletion
if (isset($_POST['remove']) && is_array($_POST['remove'])) {
    foreach ($_POST['remove'] as $product_id) {
        $validatedId = filter_var($product_id, FILTER_VALIDATE_INT);
        if ($validatedId && $validatedId > 0) {
            $cartController->removeFromCart($validatedId, $ip);
        }
    }
    $_SESSION['success'] = "Selected items removed from cart.";
} else {
    $_SESSION['error'] = "Please select at least one item to remove.";
}

header("Location: ../view/cart.php");
exit();
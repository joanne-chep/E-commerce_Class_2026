<?php
// Store navigation header containing brand identity, search form, cart summary bar, and session links
require_once __DIR__ . "/../../core/core.php";
require_once __DIR__ . "/../../controller/CartController.php";

// Safeguard session initialization across views
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialise cart controller and compute current totals for the client IP address
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$cartController = new CartController();
$cartCount = $cartController->getCartCount($ip);
$cartTotal = $cartController->getCartTotal($ip);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shoppn - Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="display: block; padding: 0; min-height: 100vh; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">

<div class="site-wrapper">
    <!-- Task 11 Cart Summary Bar: Displays real-time item count, total price, and cart link -->
    <div style="background: #1e293b; color: #f8fafc; padding: 8px 24px; font-size: 0.85rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <span>Shopping Cart &mdash; Total Items: <strong><?php echo (int)$cartCount; ?></strong> | Total Price: <strong>$<?php echo number_format((float)$cartTotal, 2); ?></strong></span>
        </div>
        <div>
            <a href="cart.php" style="color: #38bdf8; text-decoration: none; font-weight: 600;">Go to Cart &rarr;</a>
        </div>
    </div>

    <header class="store-header" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 14px 24px;">
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 1200px; margin: 0 auto;">
            <a href="home.php" class="store-logo" style="font-size: 1.5rem; font-weight: 800; color: #0f172a; text-decoration: none;">Shoppn<span style="color: #4f46e5;">.</span></a>

            <!-- Search form forwarding keyword submissions to search_results.php via GET -->
            <form action="search_results.php" method="GET" style="display: flex; gap: 8px; flex: 0.6; max-width: 480px; margin: 0 20px;">
                <input type="text" 
                    name="user_query" 
                    placeholder="Search products by title or keyword..." 
                    required 
                    value="<?php echo isset($_GET['user_query']) ? htmlspecialchars($_GET['user_query']) : ''; ?>"
                    style="flex: 1; padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
                <button type="submit" class="btn-primary" style="padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; background: #4f46e5; color: white;">Search</button>
            </form>

            <nav class="store-nav" style="display: flex; gap: 14px; align-items: center;">
                <a href="home.php" class="nav-link" style="color: #4f46e5; font-weight: bold; text-decoration: none;">Shop</a>

                <?php if (is_logged_in()): ?>
                    <!-- Visible to both Customers and Admins -->
                    <a href="../index.php" class="nav-link" style="font-weight: 600; color: #1e293b; text-decoration: none;">Dashboard</a>

                    <!-- Administrative links visible exclusively to Administrators -->
                    <?php if (is_admin()): ?>
                        <a href="admin/product.php" class="nav-link" style="color: #475569; text-decoration: none;">Products</a>
                        <a href="admin/brand.php" class="nav-link" style="color: #475569; text-decoration: none;">Brands</a>
                        <a href="admin/category.php" class="nav-link" style="color: #475569; text-decoration: none;">Categories</a>
                    <?php endif; ?>

                    <a href="../actions/logout_action.php" class="btn-nav-outline" style="text-decoration: none; padding: 6px 12px; border: 1px solid #cbd5e1; border-radius: 6px; color: #dc2626;">Log Out</a>
                <?php else: ?>
                    <!-- Guest authentication links -->
                    <a href="login.php" class="nav-link" style="color: #475569; text-decoration: none;">Log In</a>
                    <a href="register.php" class="btn-primary" style="padding: 6px 14px; text-decoration: none; border-radius: 6px; background: #4f46e5; color: white;">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Session Feedback Banner Display for cart actions and errors -->
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 20px; font-size: 0.9rem; margin: 10px auto; max-width: 1200px;">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div style="background: #dcfce7; border-left: 4px solid #22c55e; color: #166534; padding: 12px 20px; font-size: 0.9rem; margin: 10px auto; max-width: 1200px;">
            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
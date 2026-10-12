<?php
// Central application gateway rendering administration dashboard metrics or customer welcoming overviews
require_once "core/core.php";

// Ensure active session context is initialised without raising duplicate session notices
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shoppn</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="display: block; padding: 0; min-height: 100vh;">

<div class="site-wrapper">
    <header class="store-header">
        <div class="header-container">
            <a href="index.php" class="store-logo">
                Shoppn<span>.</span>
            </a>

            <nav class="store-nav">
                <a href="index.php" class="nav-link" style="color: #4f46e5; font-weight: bold;">Dashboard</a>
                <a href="view/home.php" class="nav-link">Store Front</a>

                <?php if (is_logged_in()): ?>
                    <?php if (is_admin()): ?>
                        <!-- Administrative management pathways available exclusively to admin users -->
                        <a href="view/admin/brand.php" class="nav-link">Brands</a>
                        <a href="view/admin/category.php" class="nav-link">Categories</a>
                        <a href="view/admin/product.php" class="nav-link">Products</a>
                    <?php endif; ?>

                    <!-- Identity badge reflecting authenticated user profile state -->
                    <span class="user-badge">
                        Welcome, <strong><?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?></strong>
                    </span>
                    <!-- Single-level path executing session termination script -->
                    <a href="actions/logout_action.php" class="btn-nav-outline">Log Out</a>
                <?php else: ?>
                    <!-- Guest authentication shortcuts -->
                    <a href="view/login.php" class="btn-nav-outline">Sign In</a>
                    <a href="view/register.php" class="btn-nav-primary">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <section class="hero-banner">
            <?php if (is_logged_in()): ?>
                <?php if (is_admin()): ?>
                    <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Admin'); ?></h1>
                    <p>Manage product inventories, configure store categories, and oversee brand records.</p>
                <?php else: ?>
                    <h1>Welcome Back, <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?></h1>
                    <p>Browse our catalogue of products and discover personalised recommendations for your cart.</p>
                <?php endif; ?>
            <?php else: ?>
                <h1>Discover Quality Products Online</h1>
                <p>Create an account today to access exclusive promotions, swift checkouts, and order tracking.</p>
                <a href="view/register.php" class="btn-nav-primary" style="display: inline-block; padding: 12px 24px; font-size: 1rem;">Get Started</a>
            <?php endif; ?>
        </section>

        <section class="info-grid">
            <?php if (is_logged_in()): ?>
                <div class="info-card">
                    <h3>Your Profile Details</h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email'] ?? ''); ?></p>
                    <p style="margin-top: 6px;">
                        <strong>Role Tier:</strong> 
                        <span style="display: inline-block; padding: 2px 8px; font-size: 0.8rem; font-weight: 600; border-radius: 999px; background: #e0e7ff; color: #3730a3;">
                            <?php echo is_admin() ? 'Administrator (Tier 1)' : 'Customer (Tier 2)'; ?>
                        </span>
                    </p>
                </div>

                <div class="info-card">
                    <h3>Account Security</h3>
                    <p>Your session is active. Your password adheres to standard encryption and complexity policies.</p>
                </div>

                <div class="info-card">
                    <?php if (is_admin()): ?>
                        <h3>Quick Administration</h3>
                        <p>Configure product metadata directly using the management panels.</p>
                        <div style="margin-top: 12px; display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="view/admin/product.php" class="btn-nav-outline" style="font-size: 0.85rem; padding: 6px 12px;">Products</a>
                            <a href="view/admin/brand.php" class="btn-nav-outline" style="font-size: 0.85rem; padding: 6px 12px;">Brands</a>
                            <a href="view/admin/category.php" class="btn-nav-outline" style="font-size: 0.85rem; padding: 6px 12px;">Categories</a>
                        </div>
                    <?php else: ?>
                        <h3>Explore Catalogue</h3>
                        <p>Start browsing items by category or check back for seasonal store deals.</p>
                        <div style="margin-top: 12px;">
                            <a href="view/home.php" class="btn-primary" style="display: inline-block; font-size: 0.85rem; padding: 6px 14px; text-decoration: none; border-radius: 6px;">Browse Store</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="info-card">
                    <h3>Fast & Secure Registration</h3>
                    <p>Set up your account in under a minute with real-time validation and encrypted security.</p>
                </div>
                <div class="info-card">
                    <h3>Verified Deliveries</h3>
                    <p>Worldwide distribution networks bringing selected goods straight to your doorstep.</p>
                </div>
                <div class="info-card">
                    <h3>Customer Support</h3>
                    <p>Dedicated assistance whenever you need help managing orders or updating preferences.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>

</body>
</html>
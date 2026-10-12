<?php
// Store navigation header containing brand identity, search form, and session links
require_once __DIR__ . "/../../core/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shoppn - Store</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body style="display: block; padding: 0; min-height: 100vh;">

<div class="site-wrapper">
    <header class="store-header">
        <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <a href="home.php" class="store-logo">Shoppn<span>.</span></a>

            <!-- Search form forwarding keyword submissions to search_results.php via GET -->
            <form action="search_results.php" method="GET" style="display: flex; gap: 8px; flex: 0.6; max-width: 480px; margin: 0 20px;">
                <input type="text" 
                    name="user_query" 
                    placeholder="Search products by title or keyword..." 
                    required 
                    value="<?php echo isset($_GET['user_query']) ? htmlspecialchars($_GET['user_query']) : ''; ?>"
                    style="flex: 1; padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.9rem;">
                <button type="submit" class="btn-primary" style="padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer;">Search</button>
            </form>

            <nav class="store-nav" style="display: flex; gap: 14px; align-items: center;">
                <a href="home.php" class="nav-link" style="color: #4f46e5; font-weight: bold;">Shop</a>

                <?php if (is_logged_in()): ?>
                    <!-- Visible to both Customers and Admins -->
                    <a href="../index.php" class="nav-link" style="font-weight: 600; color: #1e293b;">Dashboard</a>

                    <!-- Administrative links visible exclusively to Administrators -->
                    <?php if (is_admin()): ?>
                        <a href="admin/product.php" class="nav-link">Products</a>
                        <a href="admin/brand.php" class="nav-link">Brands</a>
                        <a href="admin/category.php" class="nav-link">Categories</a>
                    <?php endif; ?>

                    <a href="../actions/logout_action.php" class="btn-nav-outline">Log Out</a>
                <?php else: ?>
                    <!-- Guest authentication links -->
                    <a href="login.php" class="nav-link">Log In</a>
                    <a href="register.php" class="btn-primary" style="padding: 6px 14px; text-decoration: none; border-radius: 6px;">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
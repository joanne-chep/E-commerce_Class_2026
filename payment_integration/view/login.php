<?php
// This file handles the view for customer login form submissions
require_once "../core/core.php";

// Check if the user is already logged in to prevent duplicate login sessions.
if (is_logged_in()) {
    redirect("../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Login | Shoppn</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <span class="brand-badge">Shoppn</span>
        <h2>Welcome Back</h2>
        <p>Please enter your credentials to access your account.</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error">
            <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success">
            <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <form id="loginForm" action="../actions/login_action.php" method="POST">
        <div class="form-group">
            <label for="customer_email">Email Address</label>
            <input
                type="email"
                name="customer_email"
                id="customer_email"
                required
                maxlength="50"
                placeholder="joanne@gmail.com"
                autocomplete="email"
            >
        </div>

        <div class="form-group">
            <label for="customer_pass">Password</label>
            <input
                type="password"
                name="customer_pass"
                id="customer_pass"
                required
                placeholder="Enter your password"
                autocomplete="current-password"
            >
        </div>

        <button type="submit" id="loginBtn" name="login_btn" class="btn-primary">Log In</button>
    </form>

    <div class="auth-footer">
        Don't have an account yet? <a href="register.php">Click here to register</a>
        <br><br>
        <a href="../index.php" style="color: #64748b; font-size: 0.85rem;">← Return to Homepage</a>
    </div>
</div>

</body>
</html>
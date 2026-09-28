<?php
// This file is the front-end view for customer login form submissions.
require_once "../core/core.php";

//Check if the user is already logged in. If they are, redirect them to the homepage to prevent unnecessary login attempts.
if (is_logged_in()) {
    redirect("../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Login | Shoppn</title>
</head>
<body>
    <h1>Customer Login</h1>
    <nav>
        <a href="../index.php">Home</a> |
        <a href="register.php">Need an account? Register here</a>
    </nav>

    <?php
    // Ensure that any error messages from previous login attempts are displayed to the user.
    if (isset($_SESSION['error'])) {
        echo '<div style="color: #b30000; padding: 10px; margin: 15px 0; background-color: #ffe6e6; border: 1px solid #ffcccc;">' 
            . htmlspecialchars($_SESSION['error'])
            . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <form id="loginForm" action="../actions/login_action.php" method="POST">
        <div>
            <label for="customer_email">Email Address:</label><br>
            <input type="email" name="customer_email" id="customer_email" required maxlength="50">
        </div>
        <br>

        <div>
            <label for="customer_pass">Password:</label><br>
            <input type="password" name="customer_pass" id="customer_pass" required>
        </div>
        <br>

        <div>
            <button type="submit" id="loginBtn">Log In</button>
        </div>
    </form>

    <p style="margin-top: 20px;">
        Don't have an account yet? <a href="register.php">Click here to register</a>.
    </p>
</body>
</html>
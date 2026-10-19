<?php
require_once "../core/core.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-header">
        <span class="brand-badge">Welcome</span>
        <h2>Create an Account</h2>
        <p>Join us today by completing the form below.</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-error">
            <?php
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form id="registration-form" action="../actions/register_action.php" method="POST">
        <div class="form-group">
            <label for="customer_name">Full Name</label>
            <input type="text" id="customer_name" name="customer_name" required placeholder="e.g. Joanne Chepkoech">
        </div>

        <div class="form-group">
            <label for="customer_email">Email Address</label>
            <input type="email" id="customer_email" name="customer_email" required placeholder="joanne@gmail.com">
        </div>

        <div class="form-group">
            <label for="customer_pass">Password</label>
            <input type="password" id="customer_pass" name="customer_pass" required autocomplete="new-password">
            
            <ul id="password-criteria" class="password-rules">
                <li id="rule-length" class="invalid">At least 8 characters</li>
                <li id="rule-upper" class="invalid">At least one uppercase letter (A-Z)</li>
                <li id="rule-lower" class="invalid">At least one lowercase letter (a-z)</li>
                <li id="rule-number" class="invalid">At least one number (0-9)</li>
                <li id="rule-special" class="invalid">At least one special character (@$!%*?&#)</li>
            </ul>
        </div>

        <div class="form-group">
            <label for="customer_contact">Contact Number</label>
            <input type="text" id="customer_contact" name="customer_contact" required placeholder="e.g. +233 50 000 0000">
        </div>

        <div class="form-group">
            <label for="customer_city">City</label>
            <input type="text" id="customer_city" name="customer_city" required placeholder="e.g. Accra">
        </div>

        <div class="form-group">
            <label for="customer_country">Country</label>
            <select id="customer_country" name="customer_country" required>
                <option value="" disabled selected>Select your country</option>
                <option value="Ghana">Ghana</option>
                <option value="Kenya">Kenya</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Uganda">Uganda</option>
                <option value="Zimbabwe">Zimbabwe</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Egypt">Egypt</option>
                <option value="Morocco">Morocco</option>
                <option value="Algeria">Algeria</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Sudan">Sudan</option>
                <option value="Libya">Libya</option>
                <option value="Angola">Angola</option>
                <option value="Botswana">Botswana</option>
                <option value="Namibia">Namibia</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Senegal">Senegal</option>
                <option value="Ivory Coast">Ivory Coast</option>
                <option value="Mali">Mali</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Niger">Niger</option>
                <option value="Chad">Chad</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="South Sudan">South Sudan</option>
                <option value="Somalia">Somalia</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Nigeria">Nigeria</option>
                <option value="South Africa">South Africa</option>
                <option value="Rwanda">Rwanda</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <button type="submit" name="register_btn" class="btn-primary">Register</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="login.php">Log in here</a>
    </div>
</div>

<script src="../js/register.js"></script>
</body>
</html>
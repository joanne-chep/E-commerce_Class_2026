<?php
// This file is the front-end view for customer registration form submissions.
// It is responsible for rendering the HTML form and displaying any validation errors.
require_once "../core/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Registration | Shoppn</title>
</head>
<body>
    <h1>Create an Account</h1>

    <nav>
        <a href="../index.php">Home</a> |
        <a href="login.php">Already registered? Log In</a>
    </nav>

    <?php
    // Display any error messages stored in the session from previous form submissions.
    if (isset($_SESSION['error'])) {
        echo '<div style="color: #b30000; padding: 10px; margin: 15px 0; background-color: #ffe6e6; border: 1px solid #ffcccc;">'
            . htmlspecialchars($_SESSION['error'])
            . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <!--
	The registration form below is designed to collect essential customer information.
	All form fields are required and validated to ensure data integrity.
    -->
    <form id="registerForm" action="../actions/register_action.php" method="POST">
        <div>
            <label for="customer_name">Full Name:</label><br>
            <input type="text" name="customer_name" id="customer_name" required maxlength="100">
            <span class="field-error" id="nameError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <label for="customer_email">Email Address:</label><br>
            <input type="email" name="customer_email" id="customer_email" required maxlength="50">
            <span class="field-error" id="emailError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <label for="customer_pass">Password:</label><br>
            <input type="password" name="customer_pass" id="customer_pass" required minlength="6">
            <span class="field-error" id="passError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <label for="customer_country">Country:</label><br>
            <select name="customer_country" id="customer_country" required>
                <option value="">-- Select Country --</option>
                <option value="Ghana">Ghana</option>
                <option value="Kenya">Kenya</option>
                <option value="Nigeria">Nigeria</option>
                <option value="South Africa">South Africa</option>
                <option value="Togo">Togo</option>
                <option value="Niger">Niger</option>
				<option value="South Sudan">South Sudan</option>
				<option value="Rwanda">Rwanda</option>
				<option value="Tanzania">Tanzania</option>
				<option value="Uganda">Uganda</option>
				<option value="Zambia">Zambia</option>
				<option value="Zimbabwe">Zimbabwe</option>
				<option value="Other">Other</option>
            </select>
            <span class="field-error" id="countryError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <label for="customer_city">City:</label><br>
            <input type="text" name="customer_city" id="customer_city" required maxlength="30">
            <span class="field-error" id="cityError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <label for="customer_contact">Contact Phone Number:</label><br>
            <input type="tel" name="customer_contact" id="customer_contact" required maxlength="15" placeholder="+233...">
            <span class="field-error" id="contactError" style="color: red;"></span>
        </div>
        <br>

        <div>
            <button type="submit" id="submitBtn">Register Account</button>
        </div>
    </form>
    <script src="../js/validate.js"></script>
</body>
</html>
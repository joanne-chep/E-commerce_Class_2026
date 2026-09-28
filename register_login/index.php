<?php
require_once "core/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecom LAB</title>
</head>
<body>
    <h1>This is ecom lab started</h1>
    <nav>
        <a href="index.php">Home</a> |

        <?php if (is_logged_in()): ?>
            <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?></strong></span> |
            <a href="actions/logout_action.php">Logout</a>
        <?php else: ?>
            <a href="view/register.php">Register Customer</a> |
            <a href="view/login.php">Login</a>
        <?php endif; ?>
    </nav>
    <hr>

    <main>
        <?php if (is_logged_in()): ?>
            <p>You are logged in as: <strong><?php echo htmlspecialchars($_SESSION['customer_email'] ?? ''); ?></strong></p>
            <p>Your user role ID is: <strong><?php echo htmlspecialchars((string)get_user_role()); ?></strong></p>
        <?php else: ?>
            <p>You are currently browsing as a guest. Please register or log in.</p>
        <?php endif; ?>
    </main>
</body>
</html>
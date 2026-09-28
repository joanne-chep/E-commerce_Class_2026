<?php
// This file is the header template included at the top of every page. It contains the navigation bar and session management logic.
require_once __DIR__ . "/../../core/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shoppn E-Commerce</title>
</head>
<body>
    <header>
        <nav>
            <a href="../../index.php">Home</a> |

            <?php if (is_logged_in()): ?>
                <!-- This section is rendered conditionally for authenticated users -->
                <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Customer'); ?></strong></span> |
                <a href="../../view/account/my_account.php">My Account</a> |

                <?php if (is_admin()): ?>
                    <!-- Extra management link displayed exclusively for administrative roles -->
                    <a href="../../admin/index.php">Admin Panel</a> |
                <?php endif; ?>

                <a href="../../actions/logout_action.php">Logout</a>
            <?php else: ?>
                <!-- This section is rendered conditionally for unauthenticated public visitors -->
                <a href="../../view/register.php">Register</a> |
                <a href="../../view/login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
    <hr>
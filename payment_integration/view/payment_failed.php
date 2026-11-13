<?php
// Customer notification view for aborted or rejected payment gateway attempts
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/layout/header.php";

$errorMessage = $_SESSION['error'] ?? "Your payment could not be processed.";
unset($_SESSION['error']);
?>

<main class="main-content" style="padding: 40px 20px;">
    <div style="max-width: 600px; margin: 0 auto; text-align: center;">
        <div class="info-card" style="padding: 30px; border: 1px solid #fee2e2; border-radius: 8px; background: #fff5f5;">
            <h2 style="color: #dc2626; margin-bottom: 12px;">Payment Failed</h2>
            <p style="color: #4b5563; margin-bottom: 24px; font-size: 1rem;">
                <?php echo htmlspecialchars($errorMessage); ?>
            </p>
            <div style="display: flex; justify-content: center; gap: 14px;">
                <a href="payment.php" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 6px; background: #4f46e5; color: #fff;">
                    Try Again
                </a>
                <a href="cart.php" class="btn-nav-outline" style="text-decoration: none; padding: 10px 20px; border-radius: 6px;">
                    Return to Cart
                </a>
            </div>
        </div>
    </div>
</main>

</body>
</html>
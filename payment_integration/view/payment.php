<?php
// Customer checkout view showing order summary and triggering Paystack inline payment
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

require_login();

$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$cartController = new CartController();
$cartItems = $cartController->getCartItems($ip);
$cartTotal = $cartController->getCartTotal($ip);

if (empty($cartItems)) {
    header("Location: cart.php");
    exit();
}

$customerEmail = $_SESSION['customer_email'] ?? '';

require_once __DIR__ . "/layout/header.php";
?>

<main class="main-content" style="padding: 30px 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h2 style="font-size: 1.5rem; margin-bottom: 20px; color: #0f172a;">Payment & Checkout</h2>

        <div class="info-card" style="padding: 24px; margin-bottom: 24px; border: 1px solid #e2e8f0; border-radius: 8px;">
            <h3 style="font-size: 1.15rem; margin-top: 0; margin-bottom: 16px;">Order Summary</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 8px;">Product</th>
                        <th style="padding: 8px;">Qty</th>
                        <th style="padding: 8px;">Price</th>
                        <th style="padding: 8px; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 8px;"><?php echo htmlspecialchars($item['product_title']); ?></td>
                            <td style="padding: 10px 8px;"><?php echo (int)$item['qty']; ?></td>
                            <td style="padding: 10px 8px;">$<?php echo number_format((float)$item['product_price'], 2); ?></td>
                            <td style="padding: 10px 8px; text-align: right;">
                                $<?php echo number_format((float)$item['product_price'] * (int)$item['qty'], 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; margin-bottom: 24px;">
                <span style="font-size: 1.2rem; font-weight: 700; color: #0f172a;">
                    Total: $<?php echo number_format((float)$cartTotal, 2); ?>
                </span>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
                <a href="cart.php" class="btn-nav-outline" style="text-decoration: none; padding: 10px 18px; border-radius: 6px; font-size: 0.9rem;">
                    &larr; Return to Cart
                </a>
                <button type="button" onclick="payWithPaystack()" class="btn-primary" style="padding: 12px 24px; border-radius: 6px; font-size: 1rem; cursor: pointer; border: none; background: #4f46e5; color: #fff;">
                    Pay Now with Paystack
                </button>
            </div>
        </div>
    </div>
</main>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
function payWithPaystack() {
    var handler = PaystackPop.setup({
        key: 'pk_test_37fbe8827a2af0d6319228efc76d6323bcd265a9',
        email: '<?php echo htmlspecialchars($customerEmail); ?>',
        amount: <?php echo (int)round($cartTotal * 100); ?>,
        currency: 'GHS',
        callback: function(response) {
            window.location.href = '../actions/process_payment_action.php?ref=' + encodeURIComponent(response.reference);
        },
        onClose: function() {
            alert('Payment cancelled.');
        }
    });
    handler.openIframe();
}
</script>

</body>
</html>
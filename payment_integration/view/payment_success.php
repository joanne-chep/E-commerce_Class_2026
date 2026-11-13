<?php
// Customer invoice view displaying order confirmation details and purchased line items
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

require_login();

$order_id = isset($_GET['order_id']) ? filter_var($_GET['order_id'], FILTER_VALIDATE_INT) : null;

if (!$order_id) {
    header("Location: home.php");
    exit();
}

$cartController = new CartController();
$order = $cartController->getOrderById($order_id);

if (!$order) {
    header("Location: home.php");
    exit();
}

require_once __DIR__ . "/layout/header.php";
?>

<main class="main-content" style="padding: 30px 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="info-card" style="padding: 30px; border: 1px solid #e2e8f0; border-radius: 8px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <h2 style="color: #166534; margin-bottom: 8px;">Payment Successful!</h2>
                <p style="color: #64748b;">Thank you for your purchase. Your order has been placed.</p>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 0.95rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <div>
                    <strong>Order Number:</strong> #<?php echo htmlspecialchars($order['order_id']); ?><br>
                    <strong>Invoice Number:</strong> <?php echo htmlspecialchars($order['invoice_no']); ?>
                </div>
                <div style="text-align: right;">
                    <strong>Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?><br>
                    <strong>Status:</strong> <span style="color: #166534; font-weight: bold;"><?php echo ucfirst(htmlspecialchars($order['order_status'])); ?></span>
                </div>
            </div>

            <h3 style="font-size: 1.1rem; margin-bottom: 12px;">Items Ordered</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 8px;">Product</th>
                        <th style="padding: 8px;">Qty</th>
                        <th style="padding: 8px;">Unit Price</th>
                        <th style="padding: 8px; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandTotal = 0.0;
                    foreach ($order['items'] as $item): 
                        $subtotal = (float)$item['product_price'] * (int)$item['qty'];
                        $grandTotal += $subtotal;
                    ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 8px;"><?php echo htmlspecialchars($item['product_title']); ?></td>
                            <td style="padding: 8px;"><?php echo (int)$item['qty']; ?></td>
                            <td style="padding: 8px;">$<?php echo number_format((float)$item['product_price'], 2); ?></td>
                            <td style="padding: 8px; text-align: right;">$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; margin-bottom: 24px;">
                <span style="font-size: 1.25rem; font-weight: 700; color: #0f172a;">
                    Amount Paid: $<?php echo number_format($grandTotal, 2); ?>
                </span>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <a href="home.php" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 6px;">
                    Continue Shopping
                </a>
                <a href="../index.php" class="btn-nav-outline" style="text-decoration: none; padding: 10px 20px; border-radius: 6px;">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</main>

</body>
</html>
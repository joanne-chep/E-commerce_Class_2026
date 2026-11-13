<?php
// view/cart.php
// Shopping cart management interface displaying items, update fields, removal controls, and subtotal calculation
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CartController.php";

$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$cartController = new CartController();
$cartItems = $cartController->getCartItems($ip);
$cartTotal = $cartController->getCartTotal($ip);

require_once __DIR__ . "/layout/header.php";
?>

    <main class="main-content" style="padding: 30px 20px;">
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <h2 style="color: #0f172a; margin-bottom: 24px; font-size: 1.5rem;">Shopping Cart</h2>

            <?php if (!empty($cartItems)): ?>
                <!-- Update quantities form -->
                <form action="../actions/update_qty_action.php" method="POST" id="updateCartForm">
                    <table style="width: 100%; border-collapse: collapse; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; color: #475569; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 14px 16px; width: 60px; text-align: center;">Remove</th>
                                <th style="padding: 14px 16px;">Product</th>
                                <th style="padding: 14px 16px; width: 140px; text-align: center;">Quantity</th>
                                <th style="padding: 14px 16px; width: 120px; text-align: right;">Unit Price</th>
                                <th style="padding: 14px 16px; width: 120px; text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 0.95rem;">
                                    <td style="padding: 14px 16px; text-align: center;">
                                        <!-- Checkbox targeting the standalone removal action -->
                                        <input type="checkbox" name="remove[]" value="<?php echo (int)$item['p_id']; ?>" form="removeCartForm">
                                    </td>
                                    <td style="padding: 14px 16px; display: flex; align-items: center; gap: 14px;">
                                        <img src="../images/products/<?php echo htmlspecialchars($item['product_image']); ?>" 
                                            alt="<?php echo htmlspecialchars($item['product_title']); ?>"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; background: #f8fafc;">
                                        <span style="font-weight: 500; color: #1e293b;"><?php echo htmlspecialchars($item['product_title']); ?></span>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: center;">
                                        <input type="hidden" name="update[]" value="<?php echo (int)$item['p_id']; ?>">
                                        <input type="number" name="qty[]" value="<?php echo (int)$item['qty']; ?>" min="1" 
                                            style="width: 60px; padding: 6px 8px; border: 1px solid #cbd5e1; border-radius: 4px; text-align: center; font-size: 0.9rem;">
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right;">
                                        $<?php echo number_format((float)$item['product_price'], 2); ?>
                                    </td>
                                    <td style="padding: 14px 16px; text-align: right; font-weight: 600; color: #0f172a;">
                                        $<?php echo number_format((float)($item['qty'] * $item['product_price']), 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8fafc; font-weight: 700; color: #0f172a; font-size: 1.05rem;">
                                <td colspan="4" style="padding: 16px; text-align: right;">Total Amount:</td>
                                <td style="padding: 16px; text-align: right; color: #2563eb;">$<?php echo number_format($cartTotal, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>

                <!-- Standalone removal form referenced via the form attribute on removal checkboxes -->
                <form action="../actions/remove_from_cart_action.php" method="POST" id="removeCartForm"></form>

                <!-- Action Controls Section -->
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" form="removeCartForm" class="btn-nav-outline" style="cursor: pointer; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem;">
                            Remove Selected
                        </button>
                        <button type="submit" form="updateCartForm" class="btn-nav-outline" style="cursor: pointer; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem;">
                            Update Quantities
                        </button>
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <a href="home.php" class="btn-nav-outline" style="text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9rem;">
                            Continue Shopping
                        </a>
                        <a href="payment.php" class="btn-primary" style="text-decoration: none; padding: 8px 20px; border-radius: 6px; font-size: 0.9rem;">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>

            <?php else: ?>
                <div class="info-card" style="text-align: center; padding: 48px 20px; color: #64748b;">
                    <p style="font-size: 1.1rem; color: #334155; font-weight: 600; margin-bottom: 8px;">Your cart is currently empty.</p>
                    <p style="margin-bottom: 24px; font-size: 0.95rem;">Explore our catalogue and add items to your basket.</p>
                    <a href="home.php" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 6px;">Browse Catalogue</a>
                </div>
            <?php endif; ?>

        </div>
    </main>
</div>

</body>
</html>
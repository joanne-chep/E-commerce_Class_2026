<?php
// Single product detail view showing detailed attributes and purchase option
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/ProductController.php";

// Validates the presence of the product identifier parameter
$pro_id = isset($_GET['pro_id']) ? filter_var($_GET['pro_id'], FILTER_VALIDATE_INT) : null;

// Redirects home if product ID is absent or invalid
if (!$pro_id || $pro_id <= 0) {
    redirect("home.php");
    exit();
}

// Instantiates controller and retrieves product details
$productController = new ProductController();
$product = $productController->getProductById($pro_id);

// Redirects home if no matching record exists
if (!$product) {
    redirect("home.php");
    exit();
}

// Includes top layout header
require_once __DIR__ . "/layout/header.php";
?>

<div class="store-layout" style="display: flex; gap: 24px; max-width: 1200px; margin: 30px auto; padding: 0 20px;">
    
    <?php require_once __DIR__ . "/layout/sidebar.php"; ?>

    <main class="store-main" style="flex: 1; background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #e5e7eb;">
        <div style="display: flex; flex-wrap: wrap; gap: 30px;">
            
            <div style="flex: 1; min-width: 280px;">
                <img src="../images/products/<?php echo htmlspecialchars($product['product_image']); ?>" 
                    alt="<?php echo htmlspecialchars($product['product_title']); ?>" 
                    style="width: 100%; max-height: 400px; object-fit: contain; border-radius: 8px; border: 1px solid #f3f4f6;">
            </div>

            <div style="flex: 1.2; min-width: 280px;">
                <h1 style="margin-top: 0; font-size: 1.8rem;"><?php echo htmlspecialchars($product['product_title']); ?></h1>
                
                <p style="color: #6b7280; margin: 4px 0;">
                    <strong>Category:</strong> <?php echo htmlspecialchars($product['cat_name'] ?? 'Uncategorised'); ?> | 
                    <strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name'] ?? 'Generic'); ?>
                </p>

                <p style="font-size: 1.5rem; font-weight: 700; color: #2563eb; margin: 16px 0;">
                    $<?php echo number_format((float)$product['product_price'], 2); ?>
                </p>

                <div style="margin: 20px 0;">
                    <h3>Description</h3>
                    <p style="line-height: 1.6; color: #374151;">
                        <?php echo nl2br(htmlspecialchars($product['product_desc'])); ?>
                    </p>
                </div>

                <?php if (!empty($product['product_keywords'])): ?>
                    <p style="font-size: 0.9rem; color: #9ca3af;">
                        <strong>Keywords:</strong> <?php echo htmlspecialchars($product['product_keywords']); ?>
                    </p>
                <?php endif; ?>

                <div style="margin-top: 30px;">
                    <a href="home.php?add_cart=<?php echo (int)$product['product_id']; ?>" 
                    class="btn-nav-primary" 
                    style="display: inline-block; padding: 12px 24px; text-decoration: none; font-size: 1rem;">
                        Add to Cart
                    </a>
                    <a href="home.php" 
                    class="btn-nav-outline" 
                    style="display: inline-block; padding: 12px 20px; text-decoration: none; font-size: 1rem; margin-left: 10px;">
                        Back to Shop
                    </a>
                </div>
            </div>

        </div>
    </main>

</div>

</body>
</html>
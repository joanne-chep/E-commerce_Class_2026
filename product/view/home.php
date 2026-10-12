<?php
// Main customer-facing catalogue view displaying featured items or filtered results
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/ProductController.php";

// Instantiate the controller to handle data operations
$productController = new ProductController();

// Check for incoming category or brand filter identifiers from the query string
$cat_id   = isset($_GET['cat']) ? filter_var($_GET['cat'], FILTER_VALIDATE_INT) : null;
$brand_id = isset($_GET['brand']) ? filter_var($_GET['brand'], FILTER_VALIDATE_INT) : null;

// Determine whether to fetch category records, brand records, or standard featured products
if ($cat_id) {
    $products = $productController->getProductsByCategory($cat_id);
    $pageTitle = "Category Filter";
} elseif ($brand_id) {
    $products = $productController->getProductsByBrand($brand_id);
    $pageTitle = "Brand Filter";
} else {
    $products = $productController->getFeaturedProducts(6);
    $pageTitle = "Featured Products";
}

// Load common header component
require_once __DIR__ . "/layout/header.php";
?>

    <main class="main-content" style="padding: 30px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; gap: 30px; align-items: flex-start;">
            
            <!-- Include navigation sidebar component -->
            <?php require_once __DIR__ . "/layout/sidebar.php"; ?>

            <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="margin: 0; color: #0f172a; font-size: 1.4rem;"><?php echo htmlspecialchars($pageTitle); ?></h2>
                    <?php if ($cat_id || $brand_id): ?>
                        <a href="home.php" class="btn-nav-outline" style="font-size: 0.85rem; padding: 4px 10px;">Clear Filter</a>
                    <?php endif; ?>
                </div>

                <?php if (!empty($products)): ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px;">
                        <?php foreach ($products as $row): ?>
                            <div class="info-card" style="display: flex; flex-direction: column; padding: 16px;">
                                <img src="../images/products/<?php echo htmlspecialchars($row['product_image']); ?>" 
                                    alt="<?php echo htmlspecialchars($row['product_title']); ?>" 
                                    style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 12px; background: #f8fafc;">

                                <h3 style="font-size: 1.05rem; margin: 0 0 6px 0; color: #1e293b;">
                                    <?php echo htmlspecialchars($row['product_title']); ?>
                                </h3>

                                <p style="font-weight: 700; color: #2563eb; font-size: 1.1rem; margin: 0 0 16px 0;">
                                    $<?php echo number_format((float)$row['product_price'], 2); ?>
                                </p>

                                <div style="display: flex; gap: 8px; margin-top: auto;">
                                    <a href="single_product.php?pro_id=<?php echo (int)$row['product_id']; ?>" 
                                    class="btn-nav-outline" 
                                    style="flex: 1; text-align: center; text-decoration: none; padding: 8px 0; font-size: 0.85rem;">
                                        Details
                                    </a>
                                    <a href="home.php?add_cart=<?php echo (int)$row['product_id']; ?>" 
                                    class="btn-primary" 
                                    style="flex: 1; text-align: center; text-decoration: none; padding: 8px 0; font-size: 0.85rem; border-radius: 6px;">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="info-card" style="text-align: center; padding: 40px; color: #64748b;">
                        <p>No products found matching this filter.</p>
                        <a href="home.php" class="btn-primary" style="display: inline-block; margin-top: 10px; text-decoration: none; padding: 8px 16px; border-radius: 6px;">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>
</div>

</body>
</html>
<?php
// Customer search results view matching the home layout format
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/ProductController.php";

// Reads and cleans the search term submitted via GET
$searchQuery = isset($_GET['user_query']) ? trim(strip_tags($_GET['user_query'])) : '';

// Instantiates controller to execute the search
$productController = new ProductController();
$results = [];

if (!empty($searchQuery)) {
    $results = $productController->searchProducts($searchQuery);
}

// Includes top layout header
require_once __DIR__ . "/layout/header.php";
?>

<div class="store-layout" style="display: flex; gap: 24px; max-width: 1200px; margin: 30px auto; padding: 0 20px;">
    
    <?php require_once __DIR__ . "/layout/sidebar.php"; ?>

    <main class="store-main" style="flex: 1;">
        <h2>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>

        <?php if (!empty($results)): ?>
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; margin-top: 20px;">
                <?php foreach ($results as $row): ?>
                    <div class="product-card" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; background: #fff; display: flex; flex-direction: column;">
                        <img src="../images/products/<?php echo htmlspecialchars($row['product_image']); ?>" 
                            alt="<?php echo htmlspecialchars($row['product_title']); ?>" 
                            style="width: 100%; height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 12px;">

                        <h3 style="font-size: 1.1rem; margin: 0 0 8px; flex: 1;">
                            <?php echo htmlspecialchars($row['product_title']); ?>
                        </h3>

                        <p style="font-weight: 700; color: #2563eb; margin: 0 0 12px;">
                            $<?php echo number_format((float)$row['product_price'], 2); ?>
                        </p>

                        <div style="display: flex; gap: 8px; margin-top: auto;">
                            <a href="single_product.php?pro_id=<?php echo (int)$row['product_id']; ?>" 
                            class="btn-nav-outline" 
                            style="flex: 1; text-align: center; text-decoration: none; padding: 8px 0; font-size: 0.9rem;">
                                Details
                            </a>
                            <a href="home.php?add_cart=<?php echo (int)$row['product_id']; ?>" 
                            class="btn-nav-primary" 
                            style="flex: 1; text-align: center; text-decoration: none; padding: 8px 0; font-size: 0.9rem;">
                                Add to Cart
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="margin-top: 20px; color: #6b7280; font-style: italic;">No products found matching your search query.</p>
        <?php endif; ?>
    </main>

</div>

</body>
</html>
<?php
// Sidebar component rendering category and brand navigation links
require_once __DIR__ . "/../../controller/ProductController.php";

// Initialise the controller instance
$productController = new ProductController();

// Retrieve categories and brands lists from the controller
$sidebarCategories = $productController->getAllCategories();
$sidebarBrands     = $productController->getAllBrands();
?>
<aside style="width: 240px; flex-shrink: 0;">
    <div class="info-card" style="margin-bottom: 20px;">
        <h3 style="margin-top: 0; font-size: 1.1rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Categories</h3>
        <ul style="list-style: none; padding: 0; margin: 10px 0 0 0;">
            <?php if (!empty($sidebarCategories)): ?>
                <?php foreach ($sidebarCategories as $cat): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="home.php?cat=<?php echo (int)$cat['cat_id']; ?>" style="text-decoration: none; color: #4b5563; font-size: 0.95rem; font-weight: 500;">
                            <?php echo htmlspecialchars($cat['cat_name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li style="color: #94a3b8; font-size: 0.9rem;">No categories available</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="info-card">
        <h3 style="margin-top: 0; font-size: 1.1rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Brands</h3>
        <ul style="list-style: none; padding: 0; margin: 10px 0 0 0;">
            <?php if (!empty($sidebarBrands)): ?>
                <?php foreach ($sidebarBrands as $brand): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="home.php?brand=<?php echo (int)$brand['brand_id']; ?>" style="text-decoration: none; color: #4b5563; font-size: 0.95rem; font-weight: 500;">
                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li style="color: #94a3b8; font-size: 0.9rem;">No brands available</li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
<?php
// This file displays the management view for product items
require_once __DIR__ . "/../../core/core.php";
require_once __DIR__ . "/../../controller/ProductController.php";

// Restrict view strictly to admins
require_admin();

$controller = new ProductController();

// Determine whether a product is currently being edited
$edit_mode = false;
$edit_product = null;

if (isset($_GET['edit_id'])) {
    $edit_id = filter_var($_GET['edit_id'], FILTER_VALIDATE_INT);
    if ($edit_id && $edit_id > 0) {
        $edit_product = $controller->getProductById($edit_id);
        if ($edit_product) {
            $edit_mode = true;
        }
    }
}

// Retrieve supporting data for select dropdown menus
$categories = $controller->getAllCategories();
$brands     = $controller->getAllBrands();

// Retrieve all existing products to populate the management table
$products = $controller->getFeaturedProducts(100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Management | Admin</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body style="display: block; padding: 0; min-height: 100vh;">

<div class="site-wrapper">
    <header class="store-header">
        <div class="header-container">
            <a href="../../index.php" class="store-logo">Shoppn<span>.Admin</span></a>
            <nav class="store-nav">
                <a href="../../index.php" class="nav-link">Dashboard</a>
                <a href="../home.php" class="nav-link">Store Front</a>
                <a href="brand.php" class="nav-link">Brands</a>
                <a href="category.php" class="nav-link">Categories</a>
                <a href="product.php" class="nav-link" style="color: #4f46e5; font-weight: bold;">Products</a>
                <a href="../../actions/logout_action.php" class="btn-nav-outline">Log Out</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div style="max-width: 800px; margin: 0 auto;">
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert-error" style="margin-bottom: 20px;">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert-success" style="margin-bottom: 20px;">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="info-card" style="margin-bottom: 30px;">
                <h3><?php echo $edit_mode ? "Edit Product" : "Add New Product"; ?></h3>
                
                <form id="productForm" action="<?php echo $edit_mode ? '../../actions/update_product_action.php' : '../../actions/add_product_action.php'; ?>" method="POST" enctype="multipart/form-data" style="margin-top: 15px;">
                    
                    <?php if ($edit_mode): ?>
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars((string)$edit_product['product_id']); ?>">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($edit_product['product_image']); ?>">
                    <?php endif; ?>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="product_title">Product Title</label>
                        <input
                            type="text"
                            id="product_title"
                            name="product_title"
                            required
                            placeholder="e.g. Puma Deviate Nitro 2"
                            value="<?php echo $edit_mode ? htmlspecialchars($edit_product['product_title']) : ''; ?>"
                        >
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div class="form-group" style="flex: 1;">
                            <label for="product_cat">Category</label>
                            <select id="product_cat" name="product_cat" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                <option value="">-- Select Category --</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo (int)$cat['cat_id']; ?>" <?php echo ($edit_mode && (int)$edit_product['product_cat'] === (int)$cat['cat_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['cat_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label for="product_brand">Brand</label>
                            <select id="product_brand" name="product_brand" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
                                <option value="">-- Select Brand --</option>
                                <?php if (!empty($brands)): ?>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?php echo (int)$brand['brand_id']; ?>" <?php echo ($edit_mode && (int)$edit_product['product_brand'] === (int)$brand['brand_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="product_price">Price (USD)</label>
                        <input
                            type="number"
                            id="product_price"
                            name="product_price"
                            step="0.01"
                            min="0.01"
                            required
                            placeholder="0.00"
                            value="<?php echo $edit_mode ? htmlspecialchars((string)$edit_product['product_price']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="product_desc">Description</label>
                        <textarea
                            id="product_desc"
                            name="product_desc"
                            rows="3"
                            placeholder="Enter a brief product overview..."
                            style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-family: inherit;"
                        ><?php echo $edit_mode ? htmlspecialchars($edit_product['product_desc']) : ''; ?></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="product_keywords">Keywords</label>
                        <input
                            type="text"
                            id="product_keywords"
                            name="product_keywords"
                            placeholder="e.g. shoes, running, athletic"
                            value="<?php echo $edit_mode ? htmlspecialchars($edit_product['product_keywords']) : ''; ?>"
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="product_image">Product Image</label>
                        <input
                            type="file"
                            id="product_image"
                            name="product_image"
                            accept="image/jpeg,image/png,image/gif,image/webp"
                            <?php echo $edit_mode ? '' : 'required'; ?>
                            style="display: block; margin-top: 5px;"
                        >
                        <?php if ($edit_mode && !empty($edit_product['product_image'])): ?>
                            <div style="margin-top: 8px;">
                                <span style="font-size: 0.85rem; color: #64748b;">Current image:</span><br>
                                <img src="../../images/products/<?php echo htmlspecialchars($edit_product['product_image']); ?>" alt="Current Product Image" style="max-width: 100px; height: auto; border-radius: 4px; margin-top: 4px; border: 1px solid #e2e8f0;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn-primary" style="width: auto; padding: 10px 24px;">
                            <?php echo $edit_mode ? "Update Product" : "Add Product"; ?>
                        </button>
                        
                        <?php if ($edit_mode): ?>
                            <a href="product.php" class="btn-nav-outline" style="line-height: 24px;">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="info-card">
                <h3>Existing Products</h3>
                <div style="overflow-x: auto; margin-top: 15px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0; background: #f8fafc;">
                                <th style="padding: 12px;">Image</th>
                                <th style="padding: 12px;">Title</th>
                                <th style="padding: 12px;">Price</th>
                                <th style="padding: 12px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $row): ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 12px;">
                                            <img src="../../images/products/<?php echo htmlspecialchars($row['product_image']); ?>" alt="" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td style="padding: 12px; font-weight: 500;"><?php echo htmlspecialchars($row['product_title']); ?></td>
                                        <td style="padding: 12px; color: #2563eb; font-weight: 600;">$<?php echo number_format((float)$row['product_price'], 2); ?></td>
                                        <td style="padding: 12px; text-align: right;">
                                            <a href="product.php?edit_id=<?php echo urlencode((string)$row['product_id']); ?>" class="btn-nav-outline" style="padding: 4px 10px; font-size: 0.85rem;">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="padding: 16px; text-align: center; color: #64748b;">No products found. Create one using the form above.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
// Client-side file validation for format and file size
document.getElementById('productForm').addEventListener('submit', function (event) {
    const fileInput = document.getElementById('product_image');
    const file = fileInput.files[0];

    if (file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image format (JPEG, PNG, GIF, or WEBP).');
            event.preventDefault();
            return;
        }

        const maxSizeBytes = 5 * 1024 * 1024;
        if (file.size > maxSizeBytes) {
            alert('The chosen image exceeds the 5 MB size limit.');
            event.preventDefault();
            return;
        }
    }
});
</script>

</body>
</html>
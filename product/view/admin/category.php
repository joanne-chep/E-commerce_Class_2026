<?php
// This file displays the management view for product categories
require_once __DIR__ . "/../../core/core.php";
require_once "../../controller/ProductController.php";

//Restrict view strictly to authenticated admins
require_admin();

$controller = new ProductController();

//Ensure that category is not being edited
$edit_mode = false;
$edit_category = null;

if (isset($_GET['edit_id'])) {
    $edit_id = filter_var($_GET['edit_id'], FILTER_VALIDATE_INT);
    if ($edit_id && $edit_id > 0) {
        $edit_category = $controller->getCategoryById($edit_id);
        if ($edit_category) {
            $edit_mode = true;
        }
    }
}

//Get all categories to populate the table
$categories = $controller->getAllCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Category Management | Admin</title>
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
                <a href="category.php" class="nav-link" style="color: #4f46e5; font-weight: bold;">Categories</a>
                <a href="product.php" class="nav-link">Products</a>
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
                <h3><?php echo $edit_mode ? "Edit Category" : "Add New Category"; ?></h3>
                
                <form action="<?php echo $edit_mode ? '../../actions/update_category_action.php' : '../../actions/add_category_action.php'; ?>" method="POST" style="margin-top: 15px;">
                    
                    <?php if ($edit_mode): ?>
                        <input type="hidden" name="cat_id" value="<?php echo htmlspecialchars((string)$edit_category['cat_id']); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="cat_name">Category Name</label>
                        <input
                            type="text"
                            id="cat_name"
                            name="cat_name"
                            required
                            placeholder="e.g. Electronics, Footwear, Home & Kitchen"
                            value="<?php echo $edit_mode ? htmlspecialchars($edit_category['cat_name']) : ''; ?>"
                        >
                    </div>

                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button type="submit" class="btn-primary" style="width: auto; padding: 10px 24px;">
                            <?php echo $edit_mode ? "Update Category" : "Add Category"; ?>
                        </button>
                        
                        <?php if ($edit_mode): ?>
                            <a href="category.php" class="btn-nav-outline" style="line-height: 24px;">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="info-card">
                <h3>Existing Categories</h3>
                <div style="overflow-x: auto; margin-top: 15px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e2e8f0; background: #f8fafc;">
                                <th style="padding: 12px;">ID</th>
                                <th style="padding: 12px;">Category Name</th>
                                <th style="padding: 12px; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $row): ?>
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 12px;"><?php echo htmlspecialchars((string)$row['cat_id']); ?></td>
                                        <td style="padding: 12px; font-weight: 500;"><?php echo htmlspecialchars($row['cat_name']); ?></td>
                                        <td style="padding: 12px; text-align: right;">
                                            <a href="category.php?edit_id=<?php echo urlencode((string)$row['cat_id']); ?>" class="btn-nav-outline" style="padding: 4px 10px; font-size: 0.85rem;">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="padding: 16px; text-align: center; color: #64748b;">No categories found. Create one using the form above.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

</body>
</html>
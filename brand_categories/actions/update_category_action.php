<?php
// This file handles updating an existing category
require_once "../core/core.php";
require_once "../controller/ProductController.php";

// Restrict access strictly to admins
require_admin();

// Accept POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/admin/category.php");
    exit();
}

// Validate ID as a positive integer and sanitise name
$cat_id   = isset($_POST['cat_id']) ? filter_var($_POST['cat_id'], FILTER_VALIDATE_INT) : 0;
$cat_name = isset($_POST['cat_name']) ? trim(strip_tags($_POST['cat_name'])) : '';

if (!$cat_id || $cat_id <= 0 || empty($cat_name)) {
    $_SESSION['error'] = "Invalid category ID or name.";
    redirect("../view/admin/category.php");
    exit();
}

$controller = new ProductController();
$status = $controller->updateCategory($cat_id, $cat_name);

if ($status) {
    $_SESSION['success'] = "Category updated successfully.";
} else {
    $_SESSION['error'] = "Failed to update category.";
}

redirect("../view/admin/category.php");
exit();
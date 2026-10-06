<?php
// This file handles creating a new category
require_once "../core/core.php";
require_once "../controller/ProductController.php";

// Restrict access strictly to admins
require_admin();

// Accept POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/admin/category.php");
    exit();
}

// Sanitise input
$cat_name = isset($_POST['cat_name']) ? trim(strip_tags($_POST['cat_name'])) : '';

if (empty($cat_name)) {
    $_SESSION['error'] = "Category name cannot be empty.";
    redirect("../view/admin/category.php");
    exit();
}

$controller = new ProductController();
$status = $controller->addCategory($cat_name);

if ($status) {
    $_SESSION['success'] = "Category added.";
} else {
    $_SESSION['error'] = "Failed to add category. Please try again.";
}

redirect("../view/admin/category.php");
exit();
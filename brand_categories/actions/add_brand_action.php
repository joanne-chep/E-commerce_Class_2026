<?php
// This file handles creating a new brand
require_once "../core/core.php";
require_once "../controller/ProductController.php";

// Restrict access strictly to admins
require_admin();

// Accept POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/admin/brand.php");
    exit();
}

// Sanitise input
$brand_name = isset($_POST['brand_name']) ? trim(strip_tags($_POST['brand_name'])) : '';

if (empty($brand_name)) {
    $_SESSION['error'] = "Brand name cannot be empty.";
    redirect("../view/admin/brand.php");
    exit();
}

$controller = new ProductController();
$status = $controller->addBrand($brand_name);

if ($status) {
    $_SESSION['success'] = "Brand added.";
} else {
    $_SESSION['error'] = "Failed to add brand. Please try again.";
}

redirect("../view/admin/brand.php");
exit();
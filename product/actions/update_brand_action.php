<?php
// This file handles updating an existing brand
require_once "../core/core.php";
require_once "../controller/ProductController.php";

// Restrict access strictly to admins
require_admin();

// Accept POST requests only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect("../view/admin/brand.php");
    exit();
}

// Validate ID as a positive integer and sanitise name
$brand_id   = isset($_POST['brand_id']) ? filter_var($_POST['brand_id'], FILTER_VALIDATE_INT) : 0;
$brand_name = isset($_POST['brand_name']) ? trim(strip_tags($_POST['brand_name'])) : '';

if (!$brand_id || $brand_id <= 0 || empty($brand_name)) {
    $_SESSION['error'] = "Invalid brand ID or name.";
    redirect("../view/admin/brand.php");
    exit();
}

$controller = new ProductController();
$status = $controller->updateBrand($brand_id, $brand_name);

if ($status) {
    $_SESSION['success'] = "Brand updated successfully.";
} else {
    $_SESSION['error'] = "Failed to update brand.";
}

redirect("../view/admin/brand.php");
exit();
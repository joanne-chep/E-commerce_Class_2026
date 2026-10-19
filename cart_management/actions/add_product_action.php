<?php
// Handles creating a new product and saving its uploaded image
require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/ProductController.php";

// Restricts access to administrator accounts only
require_admin();

// Ensures request was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] !== "POST") { 
    redirect("../view/admin/product.php");
    exit();
}

// Retrieves and cleans submitted text form inputs
$cat_id   = isset($_POST["product_cat"]) ? $_POST["product_cat"] : "";
$brand_id = isset($_POST["product_brand"]) ? $_POST["product_brand"] : "";
$title    = isset($_POST["product_title"]) ? $_POST["product_title"] : "";
$price    = isset($_POST["product_price"]) ? $_POST["product_price"] : "";
$desc     = isset($_POST["product_desc"]) ? $_POST["product_desc"] : "";
$keywords = isset($_POST["product_keywords"]) ? $_POST["product_keywords"] : "";

// Validates that an image file was uploaded without errors
if (!isset($_FILES["product_image"]) || $_FILES["product_image"]["error"] !== UPLOAD_ERR_OK) {
    $_SESSION["error"] = "Please select a valid image file to upload.";
    redirect("../view/admin/product.php");
    exit();
}

// Allowed MIME types for image uploads
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Checks the actual MIME type of the uploaded temporary file
$file_type = mime_content_type($_FILES["product_image"]["tmp_name"]);
if (!in_array($file_type, $allowed)) {
    $_SESSION["error"] = "Invalid image type. Only JPG, PNG, GIF, and WEBP formats are allowed.";
    redirect("../view/admin/product.php");
    exit();
}

// Generates a unique filename to prevent overwriting existing files
$filename = uniqid() . "_" . basename($_FILES["product_image"]["name"]);

// Moves the uploaded file from temporary storage to the products image directory
$destination = "../images/products/" . $filename;
if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $destination)) {
    $_SESSION["error"] = "Failed to upload image file to the server.";
    redirect("../view/admin/product.php");
    exit();
}

// Calls the controller to add the product record to the database
$productController = new ProductController();
$result = $productController->addProduct($cat_id, $brand_id, $title, $price, $desc, $filename, $keywords);

// Redirects back to the product admin view with a feedback message
if ($result) {
    $_SESSION["success"] = "Product added successfully.";
} else {
    $_SESSION["error"] = "Failed to add product record.";
}

redirect("../view/admin/product.php");
exit();
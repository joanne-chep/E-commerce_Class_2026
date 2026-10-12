<?php
// Handles updating an existing product record and replacing its image if a new one is supplied
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
$id       = isset($_POST["product_id"]) ? $_POST["product_id"] : "";
$cat_id   = isset($_POST["product_cat"]) ? $_POST["product_cat"] : "";
$brand_id = isset($_POST["product_brand"]) ? $_POST["product_brand"] : "";
$title    = isset($_POST["product_title"]) ? $_POST["product_title"] : "";
$price    = isset($_POST["product_price"]) ? $_POST["product_price"] : "";
$desc     = isset($_POST["product_desc"]) ? $_POST["product_desc"] : "";
$keywords = isset($_POST["product_keywords"]) ? $_POST["product_keywords"] : "";

// Default to retaining the existing filename passed from the hidden form field
$filename = isset($_POST["old_image"]) ? $_POST["old_image"] : "";

// Checks if a new image file was uploaded by the user
if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] === UPLOAD_ERR_OK) {
    // Allowed MIME types for image uploads
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    // Checks the actual MIME type of the newly uploaded file
    $file_type = mime_content_type($_FILES["product_image"]["tmp_name"]);
    if (in_array($file_type, $allowed)) {
        // Generates a unique filename for the replacement image
        $new_filename = uniqid() . "_" . basename($_FILES["product_image"]["name"]);
        $destination  = "../images/products/" . $new_filename;

        // Moves the new file to the product images directory and updates filename reference
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $destination)) {
            $filename = $new_filename;
        }
    }
}

// Calls the controller to update the product record in the database
$productController = new ProductController();
$result = $productController->updateProduct($id, $cat_id, $brand_id, $title, $price, $desc, $filename, $keywords);

// Redirects back to the product admin view with a feedback message
if ($result) {
    $_SESSION["success"] = "Product updated successfully.";
} else {
    $_SESSION["error"] = "Failed to update product record.";
}

redirect("../view/admin/product.php");
exit();
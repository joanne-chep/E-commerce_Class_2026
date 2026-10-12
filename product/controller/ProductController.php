<?php
// this file handles brand and category business logic
require_once __DIR__ . "/../classes/ProductClass.php";

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductClass();
    }

    // Adds a new brand record
    public function addBrand($name)
    {
        $cleanName = trim(strip_tags($name));
        if (empty($cleanName)) {
            return false;
        }
        return $this->productModel->addBrand($cleanName);
    }

    // Gets all brands sorted alphabetically
    public function getAllBrands()
    {
        return $this->productModel->getAllBrands();
    }

    // Gets a single brand record by its ID
    public function getBrandById($id)
    {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$cleanId || $cleanId <= 0) {
            return false;
        }
        return $this->productModel->getBrandById($cleanId);
    }

    // Updates an existing brand record name
    public function updateBrand($id, $name)
    {
        $cleanId   = filter_var($id, FILTER_VALIDATE_INT);
        $cleanName = trim(strip_tags($name));

        if (!$cleanId || $cleanId <= 0 || empty($cleanName)) {
            return false;
        }
        return $this->productModel->updateBrand($cleanId, $cleanName);
    }

    // Adds a new product category record
    public function addCategory($name)
    {
        $cleanName = trim(strip_tags($name));
        if (empty($cleanName)) {
            return false;
        }
        return $this->productModel->addCategory($cleanName);
    }

    // Gets all categories sorted alphabetically
    public function getAllCategories()
    {
        return $this->productModel->getAllCategories();
    }

    // Gets a single category record by its ID
    public function getCategoryById($id)
    {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$cleanId || $cleanId <= 0) {
            return false;
        }
        return $this->productModel->getCategoryById($cleanId);
    }

    // Updates an existing category record name
    public function updateCategory($id, $name)
    {
        $cleanId   = filter_var($id, FILTER_VALIDATE_INT);
        $cleanName = trim(strip_tags($name));

        if (!$cleanId || $cleanId <= 0 || empty($cleanName)) {
            return false;
        }
        return $this->productModel->updateCategory($cleanId, $cleanName);
    }

    // Adds a new product record
    public function addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $cleanCat      = filter_var($cat, FILTER_VALIDATE_INT);
        $cleanBrand    = filter_var($brand, FILTER_VALIDATE_INT);
        $cleanTitle    = trim(strip_tags($title));
        $cleanPrice    = filter_var($price, FILTER_VALIDATE_FLOAT);
        $cleanDesc     = trim(strip_tags($desc));
        $cleanFilename = trim(strip_tags($image_filename));
        $cleanKeywords = trim(strip_tags($keywords));

        if (!$cleanCat || !$cleanBrand || empty($cleanTitle) || $cleanPrice === false || $cleanPrice <= 0 || empty($cleanFilename)) {
            return false;
        }

        return $this->productModel->addProduct($cleanCat, $cleanBrand, $cleanTitle, $cleanPrice, $cleanDesc, $cleanFilename, $cleanKeywords);
    }

    // Updates an existing product record
    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $cleanId       = filter_var($id, FILTER_VALIDATE_INT);
        $cleanCat      = filter_var($cat, FILTER_VALIDATE_INT);
        $cleanBrand    = filter_var($brand, FILTER_VALIDATE_INT);
        $cleanTitle    = trim(strip_tags($title));
        $cleanPrice    = filter_var($price, FILTER_VALIDATE_FLOAT);
        $cleanDesc     = trim(strip_tags($desc));
        $cleanFilename = trim(strip_tags($image_filename));
        $cleanKeywords = trim(strip_tags($keywords));

        if (!$cleanId || !$cleanCat || !$cleanBrand || empty($cleanTitle) || $cleanPrice === false || $cleanPrice <= 0 || empty($cleanFilename)) {
            return false;
        }

        return $this->productModel->updateProduct($cleanId, $cleanCat, $cleanBrand, $cleanTitle, $cleanPrice, $cleanDesc, $cleanFilename, $cleanKeywords);
    }

    // Gets a single product record by its ID
    public function getProductById($id)
    {
        $cleanId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$cleanId || $cleanId <= 0) {
            return false;
        }
        return $this->productModel->getProductById($cleanId);
    }

    // Gets a random selection of featured products
    public function getFeaturedProducts($limit = 6)
    {
        $cleanLimit = filter_var($limit, FILTER_VALIDATE_INT);
        if (!$cleanLimit || $cleanLimit <= 0) {
            $cleanLimit = 6;
        }
        return $this->productModel->getFeaturedProducts($cleanLimit);
    }

    // Gets products filtered by category ID
    public function getProductsByCategory($cat_id)
    {
        $cleanCatId = filter_var($cat_id, FILTER_VALIDATE_INT);
        if (!$cleanCatId || $cleanCatId <= 0) {
            return [];
        }
        return $this->productModel->getProductsByCategory($cleanCatId);
    }

    // Gets products filtered by brand ID
    public function getProductsByBrand($brand_id)
    {
        $cleanBrandId = filter_var($brand_id, FILTER_VALIDATE_INT);
        if (!$cleanBrandId || $cleanBrandId <= 0) {
            return [];
        }
        return $this->productModel->getProductsByBrand($cleanBrandId);
    }

    // Searches products by title or keywords
    public function searchProducts($query)
    {
        $cleanQuery = trim(strip_tags($query));
        if (empty($cleanQuery)) {
            return [];
        }
        return $this->productModel->searchProducts($cleanQuery);
    }
}
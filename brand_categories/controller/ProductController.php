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
}
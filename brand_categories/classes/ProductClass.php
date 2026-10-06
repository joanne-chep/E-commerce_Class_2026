<?php
// Model layer handling database operations for brands and categories
require_once __DIR__ . "/../core/db_class.php";

class ProductClass extends Database
{
    // Adds a new brand record
    public function addBrand($name)
    {
        $sql = "INSERT INTO brands (brand_name) VALUES (?)";
        return $this->execute($sql, [$name]);
    }

    // Gets all brands sorted alphabetically
    public function getAllBrands()
    {
        $sql = "SELECT * FROM brands ORDER BY brand_name ASC";
        return $this->fetchAll($sql);
    }

    //Gets a single brand record by its ID
    public function getBrandById($id)
    {
        $sql = "SELECT * FROM brands WHERE brand_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    //Updates an existing brand record name
    public function updateBrand($id, $name)
    {
        $sql = "UPDATE brands SET brand_name = ? WHERE brand_id = ?";
        return $this->execute($sql, [$name, $id]);
    }

    // Adds a new product category record
    public function addCategory($name)
    {
        $sql = "INSERT INTO categories (cat_name) VALUES (?)";
        return $this->execute($sql, [$name]);
    }

    // Gets all categories sorted alphabetically
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY cat_name ASC";
        return $this->fetchAll($sql);
    }

    // Gets a single category record by its ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE cat_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Updates an existing category record name
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories SET cat_name = ? WHERE cat_id = ?";
        return $this->execute($sql, [$name, $id]);
    }
}
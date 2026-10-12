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

    // Gets a single brand record by its ID
    public function getBrandById($id)
    {
        $sql = "SELECT * FROM brands WHERE brand_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Updates an existing brand record name
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

    // Adds a new product record
    public function addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $sql = "INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->execute($sql, [
            $cat,
            $brand,
            $title,
            $price,
            $desc,
            $image_filename,
            $keywords
        ]);
    }

    // Updates an existing product record
    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $sql = "UPDATE products 
                SET product_cat = ?, 
                    product_brand = ?, 
                    product_title = ?, 
                    product_price = ?, 
                    product_desc = ?, 
                    product_image = ?, 
                    product_keywords = ? 
                WHERE product_id = ?";
        return $this->execute($sql, [
            $cat,
            $brand,
            $title,
            $price,
            $desc,
            $image_filename,
            $keywords,
            $id
        ]);
    }

    // Gets a single product record by its ID with category and brand names
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Gets a random selection of featured products
    public function getFeaturedProducts($limit = 6)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                ORDER BY RAND() 
                LIMIT " . (int)$limit;
        $result = $this->fetchAll($sql);
        return is_array($result) ? $result : [];
    }

    // Gets products filtered by category ID
    public function getProductsByCategory($cat_id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_cat = ?";
        $result = $this->fetchAll($sql, [$cat_id]);
        return is_array($result) ? $result : [];
    }

    // Gets products filtered by brand ID
    public function getProductsByBrand($brand_id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_brand = ?";
        $result = $this->fetchAll($sql, [$brand_id]);
        return is_array($result) ? $result : [];
    }

    // Searches products by title or keywords
    public function searchProducts($query)
    {
        $searchTerm = '%' . $query . '%';
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_title LIKE ? OR p.product_keywords LIKE ?";
        $result = $this->fetchAll($sql, [$searchTerm, $searchTerm]);
        return is_array($result) ? $result : [];
    }
}
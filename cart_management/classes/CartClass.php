<?php
// Model layer managing database persistence for cart operations, IP-based cart tracking, and item updates
require_once __DIR__ . "/../core/db_class.php";

class CartClass extends Database
{
    // Verifies whether a given product identifier is already linked to the client IP address
    public function isInCart($product_id, $ip)
    {
        $sql = "SELECT p_id FROM cart WHERE p_id = ? AND ip_add = ?";
        $result = $this->fetchOne($sql, [$product_id, $ip]);
        return !empty($result);
    }

    // Inserts a new cart entry binding the product, quantity, and IP address
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        $sql = "INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)";
        return $this->execute($sql, [$product_id, $ip, $qty]);
    }

    // Retrieves all cart records joined with product table specifications for the given IP address
    public function getCartItems($ip)
    {
        $sql = "SELECT cart.*, products.product_title, products.product_price, products.product_image 
                FROM cart 
                JOIN products ON cart.p_id = products.product_id 
                WHERE cart.ip_add = ?";
        return $this->fetchAll($sql, [$ip]);
    }

    // Calculates the total number of distinct product lines registered to the client IP address
    public function getCartCount($ip)
    {
        $sql = "SELECT COUNT(*) AS total_count FROM cart WHERE ip_add = ?";
        $result = $this->fetchOne($sql, [$ip]);
        return (int)($result['total_count'] ?? 0);
    }

    // Iterates through stored cart items to compute the aggregate financial total
    public function getCartTotal($ip)
    {
        $items = $this->getCartItems($ip);
        $total = 0.0;
        foreach ($items as $item) {
            $total += ((int)$item['qty'] * (float)$item['product_price']);
        }
        return (float)$total;
    }

    // Removes an existing item from the cart table using its product ID and client IP address
    public function removeFromCart($product_id, $ip)
    {
        $sql = "DELETE FROM cart WHERE p_id = ? AND ip_add = ?";
        return $this->execute($sql, [$product_id, $ip]);
    }

    // Updates the ordered quantity of an item ensuring the new count meets the minimum threshold of 1
    public function updateQty($product_id, $new_qty, $ip)
    {
        if ($new_qty < 1) {
            return false;
        }

        $sql = "UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?";
        return $this->execute($sql, [$new_qty, $product_id, $ip]);
    }
}
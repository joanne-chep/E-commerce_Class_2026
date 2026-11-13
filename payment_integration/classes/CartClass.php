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

    // Executes atomic order creation, details copying, and cart clearance inside a database transaction
    public function processPayment($customer_id, $ip, $reference, $amount)
    {
        $pdo = $this->getConnection();

        try {
            $pdo->beginTransaction();

            // 1. Fetch current cart items for client IP address
            $items = $this->getCartItems($ip);
            if (empty($items)) {
                $pdo->rollBack();
                return false;
            }

            // 2. Generate six-digit random invoice number
            $invoice_no = mt_rand(100000, 999999);
            $order_date = date("Y-m-d");

            // 3. Insert record into orders table
            $orderSql = "INSERT INTO orders (customer_id, invoice_no, order_date, order_status) 
                        VALUES (?, ?, ?, 'paid')";
            $orderStmt = $pdo->prepare($orderSql);
            $orderStmt->execute([$customer_id, $invoice_no, $order_date]);
            $order_id = $pdo->lastInsertId();

            // 4. Copy each cart line item into the orderdetails table
            $detailSql = "INSERT INTO orderdetails (order_id, product_id, qty) VALUES (?, ?, ?)";
            $detailStmt = $pdo->prepare($detailSql);

            foreach ($items as $item) {
                $detailStmt->execute([$order_id, $item['p_id'], $item['qty']]);
            }

            // 5. Clear cart entries associated with client IP address
            $deleteSql = "DELETE FROM cart WHERE ip_add = ?";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->execute([$ip]);

            $pdo->commit();
            return $order_id;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return false;
        }
    }

    // Retrieves order summary joined with line item specifications and product details
    public function getOrderById($order_id)
    {
        $orderSql = "SELECT * FROM orders WHERE order_id = ?";
        $order = $this->fetchOne($orderSql, [$order_id]);

        if (!$order) {
            return null;
        }

        $itemsSql = "SELECT od.*, p.product_title, p.product_price, p.product_image 
                    FROM orderdetails od 
                    JOIN products p ON od.product_id = p.product_id 
                    WHERE od.order_id = ?";
        $order['items'] = $this->fetchAll($itemsSql, [$order_id]);

        return $order;
    }
}
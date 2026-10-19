<?php
// Controller intermediary coordinating cart business logic between models and views
require_once __DIR__ . "/../classes/CartClass.php";

class CartController
{
    private $cartModel;

    // Instantiates the model layer upon controller creation
    public function __construct()
    {
        $this->cartModel = new CartClass();
    }

    // Checks if the item already exists in the client's current cart session
    public function isInCart($product_id, $ip)
    {
        return $this->cartModel->isInCart((int)$product_id, $ip);
    }

    // Forwards insertion request to add an item to the cart
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        return $this->cartModel->addToCart((int)$product_id, (int)$qty, $ip, $customer_id);
    }

    // Fetches the detailed item array belonging to the given IP address
    public function getCartItems($ip)
    {
        return $this->cartModel->getCartItems($ip);
    }

    // Returns the total count of items in the cart
    public function getCartCount($ip)
    {
        return $this->cartModel->getCartCount($ip);
    }

    // Returns the total monetary sum of items in the cart
    public function getCartTotal($ip)
    {
        return $this->cartModel->getCartTotal($ip);
    }

    // Removes a single product line from the cart
    public function removeFromCart($product_id, $ip)
    {
        return $this->cartModel->removeFromCart((int)$product_id, $ip);
    }

    // Updates quantity value for a designated product line
    public function updateQty($product_id, $new_qty, $ip)
    {
        return $this->cartModel->updateQty((int)$product_id, (int)$new_qty, $ip);
    }
}
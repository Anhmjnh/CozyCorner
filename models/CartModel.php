<?php
// models/CartModel.php
require_once __DIR__ . '/../core/Model.php';

class CartModel extends Model {

    public function getCartId($user_id, $session_id) {
        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT id FROM carts WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM carts WHERE session_id = ? AND user_id IS NULL");
            $stmt->bind_param("s", $session_id);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }
        return null;
    }

    public function createCart($user_id, $session_id) {
        if ($user_id) {
            $stmt = $this->conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
            $stmt->bind_param("i", $user_id);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO carts (session_id) VALUES (?)");
            $stmt->bind_param("s", $session_id);
        }
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function getCartItems($cart_id) {
        $stmt = $this->conn->prepare("
            SELECT ci.id as cart_item_id, ci.quantity, p.id as product_id, p.ten_sp as name, p.gia as price, p.gia_cu as old_price, p.anh as image, p.weight 
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?
        ");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function addToCart($cart_id, $product_id, $quantity) {
        $stmt = $this->conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $cart_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $new_quantity = $row['quantity'] + $quantity;
            $update_stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $update_stmt->bind_param("ii", $new_quantity, $row['id']);
            return $update_stmt->execute();
        } else {
            $insert_stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("iii", $cart_id, $product_id, $quantity);
            return $insert_stmt->execute();
        }
    }

    public function updateQuantity($cart_item_id, $quantity) {
        $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $cart_item_id);
        return $stmt->execute();
    }

    public function removeItem($cart_item_id) {
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param("i", $cart_item_id);
        return $stmt->execute();
    }

    public function mergeCart($session_id, $user_id) {
        $session_cart_id = $this->getCartId(null, $session_id);
        if ($session_cart_id) {
            $user_cart_id = $this->getCartId($user_id, null);
            if (!$user_cart_id) {
                $stmt = $this->conn->prepare("UPDATE carts SET user_id = ?, session_id = NULL WHERE id = ?");
                $stmt->bind_param("ii", $user_id, $session_cart_id);
                $stmt->execute();
            } else {
                $items = $this->getCartItems($session_cart_id);
                foreach ($items as $item) {
                    $this->addToCart($user_cart_id, $item['product_id'], $item['quantity']);
                }
                $stmt = $this->conn->prepare("DELETE FROM carts WHERE id = ?");
                $stmt->bind_param("i", $session_cart_id);
                $stmt->execute();
            }
        }
    }
}
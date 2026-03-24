<?php
// controllers/CartController.php

require_once __DIR__ . '/../models/CartModel.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function getCurrentCartId() {
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();

        $cart_id = $this->cartModel->getCartId($user_id, $session_id);
        if (!$cart_id) {
            $cart_id = $this->cartModel->createCart($user_id, $session_id);
        }
        return $cart_id;
    }

    public function get() {
        $cart_id = $this->getCurrentCartId();
        $items = $this->cartModel->getCartItems($cart_id);
        
        $total_price = 0;
        $total_quantity = 0;
        foreach ($items as $item) {
            $total_price += $item['price'] * $item['quantity'];
            $total_quantity += $item['quantity'];
        }

        echo json_encode([
            'status' => 'success',
            'items' => $items,
            'total_price' => $total_price,
            'total_quantity' => $total_quantity
        ]);
        exit;
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = intval($_POST['product_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 1);

            if ($product_id > 0 && $quantity > 0) {
                $cart_id = $this->getCurrentCartId();
                $this->cartModel->addToCart($cart_id, $product_id, $quantity);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = intval($_POST['cart_item_id'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);

            if ($cart_item_id > 0 && $quantity > 0) {
                $this->cartModel->updateQuantity($cart_item_id, $quantity);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
        exit;
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart_item_id = intval($_POST['cart_item_id'] ?? 0);

            if ($cart_item_id > 0) {
                $this->cartModel->removeItem($cart_item_id);
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ']);
        exit;
    }
}
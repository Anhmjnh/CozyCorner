<?php
// models/OrderModel.php
require_once __DIR__ . '/../config.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function createOrder($user_id, $tong_tien, $dia_chi_giao, $ghi_chu, $cartItems) {
        // Bắt đầu Transaction (Đảm bảo nếu lỗi ở bước nào thì sẽ hoàn tác toàn bộ)
        $this->conn->begin_transaction();
        try {
            // 1. Lưu thông tin Đơn hàng chung
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, tong_tien, dia_chi_giao, ghi_chu) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idss", $user_id, $tong_tien, $dia_chi_giao, $ghi_chu);
            $stmt->execute();
            $order_id = $this->conn->insert_id;
            $stmt->close();

            // 2. Lưu Chi tiết Đơn hàng & Trừ Tồn Kho
            $stmt_detail = $this->conn->prepare("INSERT INTO order_details (order_id, product_id, so_luong, gia) VALUES (?, ?, ?, ?)");
            $stmt_stock = $this->conn->prepare("UPDATE products SET so_luong_ton = GREATEST(0, so_luong_ton - ?), luot_ban = luot_ban + ? WHERE id = ?");

            foreach ($cartItems as $item) {
                // Lưu sản phẩm
                $stmt_detail->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
                $stmt_detail->execute();

                // Cập nhật kho và lượt bán
                $stmt_stock->bind_param("iii", $item['quantity'], $item['quantity'], $item['product_id']);
                $stmt_stock->execute();
            }
            $stmt_detail->close();
            $stmt_stock->close();

            // 3. Xóa các sản phẩm đã mua khỏi Giỏ hàng
            $stmt_clear = $this->conn->prepare("DELETE ci FROM cart_items ci JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = ?");
            $stmt_clear->bind_param("i", $user_id);
            $stmt_clear->execute();
            $stmt_clear->close();

            $this->conn->commit();
            return $order_id; // Trả về ID đơn hàng để tạo QR
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getOrderById($order_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $order;
    }
    
    public function getOrderDetails($order_id) {
        $stmt = $this->conn->prepare("SELECT od.*, p.ten_sp, p.anh FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $details;
    }
}
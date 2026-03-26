<?php
// models/OrderModel.php
require_once __DIR__ . '/../config.php';

class OrderModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function createOrder($user_id, $tong_tien_cuoi, $dia_chi_giao, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen) {
        // Bắt đầu Transaction (Đảm bảo nếu lỗi ở bước nào thì sẽ hoàn tác toàn bộ)
        $this->conn->begin_transaction();
        try {
            // 1. Lưu thông tin Đơn hàng chung
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, ghn_order_code, tong_tien, phi_van_chuyen, dia_chi_giao, phuong_thuc_thanh_toan, ghi_chu) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isddsss", $user_id, $ghn_order_code, $tong_tien_cuoi, $phi_van_chuyen, $dia_chi_giao, $phuong_thuc, $ghi_chu);
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

    public function cancelOrder($order_id, $user_id)
    {
        // BẢO MẬT LOGIC: Chỉ cho phép hủy nếu:
        // 1. Đang ở 'ChoXacNhan'
        // 2. Hoặc đang ở 'DangGiao' NHƯNG phương thức phải là 'COD'
        $stmt = $this->conn->prepare("
            UPDATE orders 
            SET trang_thai = 'Huy' 
            WHERE id = ? 
            AND user_id = ? 
            AND (trang_thai = 'ChoXacNhan' 
                 OR (trang_thai = 'DangGiao' AND phuong_thuc_thanh_toan = 'COD'))
        ");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();

        // execute() trả về true/false, nhưng affected_rows là cách chắc chắn nhất để biết có dòng nào được cập nhật không
        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        return $affected_rows > 0;
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

    public function getOrderForWebhook($order_id) {
        $stmt = $this->conn->prepare("SELECT tong_tien, trang_thai FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function updateOrderStatus($order_id, $trang_thai) {
        $stmt = $this->conn->prepare("UPDATE orders SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $order_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getUserIdByOrderId($order_id) {
        $stmt = $this->conn->prepare("SELECT user_id FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ? $result['user_id'] : null;
    }
}
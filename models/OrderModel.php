<?php
// models/OrderModel.php
require_once __DIR__ . '/../core/Model.php';

class OrderModel extends Model
{

    public function createOrder($user_id, $cart_id, $tong_tien_cuoi, $ten_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_giao, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen, $giam_gia_thanh_vien = 0, $ma_voucher = null, $giam_gia_voucher = 0, $email_nguoi_nhan = null)
    {

        $this->conn->begin_transaction();
        try {
            // 1. Lưu thông tin Đơn hàng chung
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, ghn_order_code, tong_tien, phi_van_chuyen, ten_nguoi_nhan, sdt_nguoi_nhan, dia_chi_giao, phuong_thuc_thanh_toan, ghi_chu, giam_gia_thanh_vien, ma_voucher, giam_gia_voucher, email_nguoi_nhan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isddsssssisis", $user_id, $ghn_order_code, $tong_tien_cuoi, $phi_van_chuyen, $ten_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_giao, $phuong_thuc, $ghi_chu, $giam_gia_thanh_vien, $ma_voucher, $giam_gia_voucher, $email_nguoi_nhan);
            $stmt->execute();
            $order_id = $this->conn->insert_id;
            $stmt->close();

            // 2. Lưu Chi tiết Đơn hàng & Trừ Tồn Kho
            $stmt_detail = $this->conn->prepare("INSERT INTO order_details (order_id, product_id, ten_sp_snapshot, anh_sp_snapshot, so_luong, gia) VALUES (?, ?, ?, ?, ?, ?)");

            foreach ($cartItems as $item) {
                $ten_sp = $item['name'] ?? 'Sản phẩm';
                $anh_sp = $item['anh'] ?? null;
                // Lưu chi tiết đơn hàng. Trigger `trg_tru_ton_kho_khi_dat_hang` trong database sẽ tự động trừ tồn kho.
                $stmt_detail->bind_param("iissid", $order_id, $item['product_id'], $ten_sp, $anh_sp, $item['quantity'], $item['price']);
                $stmt_detail->execute();
            }
            $stmt_detail->close();

            // 3. Xóa các sản phẩm đã mua khỏi Giỏ hàng và xóa luôn giỏ hàng
            if ($cart_id) {
                $stmt_clear_items = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
                $stmt_clear_items->bind_param("i", $cart_id);
                $stmt_clear_items->execute();
                $stmt_clear_items->close();

                $stmt_clear_cart = $this->conn->prepare("DELETE FROM carts WHERE id = ?");
                $stmt_clear_cart->bind_param("i", $cart_id);
                $stmt_clear_cart->execute();
                $stmt_clear_cart->close();
            }

            $this->conn->commit();
            return $order_id; // Trả về ID đơn hàng để tạo QR
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function cancelOrder($order_id, $user_id)
    {

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


        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        return $affected_rows > 0;
    }
    // Hủy các đơn hàng QR quá 10 phút
    public function cancelExpiredQROrders()
    {
        $sql = "UPDATE orders 
                SET trang_thai = 'Huy' 
                WHERE trang_thai = 'ChoXacNhan' 
                AND phuong_thuc_thanh_toan = 'ChuyenKhoan' 
                AND created_at <= (NOW() - INTERVAL 10 MINUTE)";

        $this->conn->query($sql);
        return $this->conn->affected_rows;
    }


    public function getOrderByIdAndUser($order_id, $user_id)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT o.*, IFNULL(u.email, o.email_nguoi_nhan) as user_email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ? AND o.user_id = ?");
            $stmt->bind_param("ii", $order_id, $user_id);
        } else {
            // Dành cho khách, chỉ kiểm tra id đơn hàng và user_id phải là NULL
            $stmt = $this->conn->prepare("SELECT o.*, o.email_nguoi_nhan as user_email FROM orders o WHERE o.id = ? AND o.user_id IS NULL");
            $stmt->bind_param("i", $order_id);
        }
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function getOrderById($order_id)
    {
        $stmt = $this->conn->prepare("SELECT o.*, IFNULL(u.email, o.email_nguoi_nhan) as user_email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function getOrderDetails($order_id)
    {
        // Đổi sang LEFT JOIN và lấy dữ liệu Snapshot nếu sản phẩm đã bị xóa
        $stmt = $this->conn->prepare("SELECT od.*, IFNULL(p.ten_sp, od.ten_sp_snapshot) as ten_sp, IFNULL(p.anh, od.anh_sp_snapshot) as anh FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $details = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $details;
    }

    public function getOrderForWebhook($order_id)
    {
        $stmt = $this->conn->prepare("SELECT tong_tien, trang_thai FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $order;
    }

    public function updateOrderStatus($order_id, $trang_thai)
    {
        $stmt = $this->conn->prepare("UPDATE orders SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $order_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getOrderIdByGhnCode($ghn_order_code)
    {
        $stmt = $this->conn->prepare("SELECT id FROM orders WHERE ghn_order_code = ?");
        $stmt->bind_param("s", $ghn_order_code);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ? $result['id'] : null;
    }

    public function getUserIdByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("SELECT user_id FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ? $result['user_id'] : null;
    }

    public function getOrdersByUserId($user_id)
    {
        $stmt = $this->conn->prepare("SELECT o.*, IFNULL(u.email, o.email_nguoi_nhan) as user_email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.user_id = ? ORDER BY o.created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }
}
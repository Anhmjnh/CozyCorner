<?php
// models/OrderModel.php
require_once __DIR__ . '/../core/Model.php';

class OrderModel extends Model
{

    public function createOrder($user_id, $cart_id, $tong_tien_cuoi, $ten_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_giao, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen, $giam_gia_thanh_vien = 0, $ma_voucher = null, $giam_gia_voucher = 0, $email_nguoi_nhan = null, $xuat_hoa_don_cong_ty = 0, $ten_cong_ty = null, $ma_so_thue = null, $dia_chi_cong_ty = null, $email_nhan_hoa_don = null)
    {

        $this->conn->begin_transaction();
        try {
            // 1. Lưu thông tin Đơn hàng chung
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, ghn_order_code, tong_tien, phi_van_chuyen, ten_nguoi_nhan, sdt_nguoi_nhan, dia_chi_giao, phuong_thuc_thanh_toan, ghi_chu, giam_gia_thanh_vien, ma_voucher, giam_gia_voucher, email_nguoi_nhan, xuat_hoa_don_cong_ty, ten_cong_ty, ma_so_thue, dia_chi_cong_ty, email_nhan_hoa_don) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isddsssssisisissss", $user_id, $ghn_order_code, $tong_tien_cuoi, $phi_van_chuyen, $ten_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_giao, $phuong_thuc, $ghi_chu, $giam_gia_thanh_vien, $ma_voucher, $giam_gia_voucher, $email_nguoi_nhan, $xuat_hoa_don_cong_ty, $ten_cong_ty, $ma_so_thue, $dia_chi_cong_ty, $email_nhan_hoa_don);
            $stmt->execute();
            $order_id = $this->conn->insert_id;
            $stmt->close();

            // 2. Lưu Chi tiết Đơn hàng & Trừ Tồn Kho
            $stmt_detail = $this->conn->prepare("INSERT INTO order_details (order_id, product_id, ten_sp_snapshot, anh_sp_snapshot, so_luong, gia) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_stock = $this->conn->prepare("UPDATE products SET so_luong_ton = CASE WHEN so_luong_ton <= 0 THEN so_luong_ton WHEN so_luong_ton >= ? THEN so_luong_ton - ? ELSE 0 END, luot_ban = luot_ban + ? WHERE id = ?");

            foreach ($cartItems as $item) {
                $ten_sp = $item['name'] ?? 'Sản phẩm';
                $anh_sp = $item['anh'] ?? null;
                $so_luong = $item['quantity'];
                $product_id = $item['product_id'];
                
                $stmt_detail->bind_param("iissid", $order_id, $product_id, $ten_sp, $anh_sp, $so_luong, $item['price']);
                $stmt_detail->execute();
                
                // Trừ tồn kho bằng PHP (thay thế Trigger trg_tru_ton_kho_khi_dat_hang)
                $stmt_stock->bind_param("iiii", $so_luong, $so_luong, $so_luong, $product_id);
                $stmt_stock->execute();
            }
            $stmt_detail->close();
            $stmt_stock->close();

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

        if ($affected_rows > 0) {
            // Hoàn tồn kho bằng PHP (thay thế Trigger trg_hoan_ton_kho_khi_huy_don)
            $this->restoreStockForOrder($order_id);
        }

        return $affected_rows > 0;
    }

    public function cancelExpiredQROrders()
    {
        $stmt_get = $this->conn->query("SELECT id FROM orders WHERE trang_thai = 'ChoXacNhan' AND phuong_thuc_thanh_toan = 'ChuyenKhoan' AND created_at <= (NOW() - INTERVAL 10 MINUTE)");
        $expired_orders = $stmt_get->fetch_all(MYSQLI_ASSOC);

        if (count($expired_orders) > 0) {
            $sql = "UPDATE orders 
                    SET trang_thai = 'Huy' 
                    WHERE trang_thai = 'ChoXacNhan' 
                    AND phuong_thuc_thanh_toan = 'ChuyenKhoan' 
                    AND created_at <= (NOW() - INTERVAL 10 MINUTE)";
            $this->conn->query($sql);
            
            foreach ($expired_orders as $order) {
                $this->restoreStockForOrder($order['id']);
            }
        }
        return count($expired_orders);
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
        // Lấy trạng thái cũ để so sánh
        $stmt_old = $this->conn->prepare("SELECT trang_thai FROM orders WHERE id = ?");
        $stmt_old->bind_param("i", $order_id);
        $stmt_old->execute();
        $old_status = $stmt_old->get_result()->fetch_assoc()['trang_thai'] ?? '';
        $stmt_old->close();

        $stmt = $this->conn->prepare("UPDATE orders SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $order_id);
        $result = $stmt->execute();
        $stmt->close();

        // Nếu trạng thái mới là 'Huy', chạy logic hoàn trả
        if ($result && $trang_thai === 'Huy' && $old_status !== 'Huy') {
            $this->restoreStockForOrder($order_id);
        }

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
        $stmt = $this->conn->prepare("SELECT o.*, IFNULL(u.email, o.email_nguoi_nhan) as user_email, (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.user_id = ? ORDER BY o.created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $orders;
    }

    public function restoreStockForOrder($order_id)
    {
        $stmt_details = $this->conn->prepare("SELECT product_id, so_luong FROM order_details WHERE order_id = ?");
        $stmt_details->bind_param("i", $order_id);
        $stmt_details->execute();
        $details = $stmt_details->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_details->close();

        if (!empty($details)) {
            $stmt_restore = $this->conn->prepare("
                UPDATE products 
                SET so_luong_ton = CASE WHEN so_luong_ton <= 0 THEN so_luong_ton ELSE so_luong_ton + ? END,
                    luot_ban = IF(luot_ban >= ?, luot_ban - ?, 0)
                WHERE id = ?");
            foreach ($details as $item) {
                $stmt_restore->bind_param("iiii", $item['so_luong'], $item['so_luong'], $item['so_luong'], $item['product_id']);
                $stmt_restore->execute();
            }
            $stmt_restore->close();
        }
    }
}
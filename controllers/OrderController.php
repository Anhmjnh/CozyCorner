<?php
// controllers/OrderController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class OrderController
{
    public function process()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $ghi_chu_form = trim($_POST['ghi_chu'] ?? '');
            $phuong_thuc = $_POST['phuong_thuc_thanh_toan'] ?? 'COD';
            $phi_ship_nhap = floatval($_POST['phi_ship'] ?? 0); // Phí ship gửi từ form

            if (empty($ho_ten) || empty($so_dien_thoai) || empty($dia_chi)) {
                $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin giao hàng!';
                header('Location: ' . BASE_URL . 'view/order/ThanhToan.php');
                exit;
            }

            // Gộp thông tin liên hệ vào địa chỉ giao để dễ hiển thị
            $dia_chi_giao = "Người nhận: $ho_ten | SĐT: $so_dien_thoai | Địa chỉ: $dia_chi";

            // Gắn phương thức thanh toán vào Ghi chú (vì bảng orders của bạn không có cột phương thức)
            $ghi_chu = "Phương thức: $phuong_thuc" . (!empty($ghi_chu_form) ? " | Ghi chú khách: $ghi_chu_form" : "");

            // Lấy sản phẩm từ Giỏ hàng
            $cartModel = new CartModel();
            $cart_id = $cartModel->getCartId($user_id, session_id());
            $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];

            if (empty($cartItems)) {
                $_SESSION['error_message'] = 'Giỏ hàng trống!';
                header('Location: ' . BASE_URL . 'view/cart/ChiTietGioHang.php');
                exit;
            }

            // Tính tổng tiền & Phí vận chuyển
            $tong_tien = 0;
            foreach ($cartItems as $item) {
                $tong_tien += $item['price'] * $item['quantity'];
            }
            $phivanchuyen = $phi_ship_nhap;
            $tong_tien_cuoi = $tong_tien + $phivanchuyen;

            // Lưu đơn hàng
            $orderModel = new OrderModel();
            $order_id = $orderModel->createOrder($user_id, $tong_tien_cuoi, $dia_chi_giao, $ghi_chu, $cartItems);

            if ($order_id) {
                // Dù là QR Code hay COD đều chuyển sang trang Thành công
                header('Location: ' . BASE_URL . 'index.php?url=order/success&id=' . $order_id);
            } else {
                $_SESSION['error_message'] = 'Lỗi hệ thống khi đặt hàng. Vui lòng thử lại sau!';
                header('Location: ' . BASE_URL . 'view/order/ThanhToan.php');
            }
            exit;
        }
    }

    // Chức năng hiển thị Hóa Đơn / Mã QR
    public function success()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderById($order_id, $_SESSION['user_id']);

        if (!$order) {
            die("Đơn hàng không tồn tại hoặc không thuộc về bạn.");
        }
        $order['items'] = $orderModel->getOrderDetails($order_id);

        require_once __DIR__ . '/../view/order/ThanhToanThanhCong.php';
    }

    // API kiểm tra trạng thái đơn hàng (Dành cho chức năng tự động load QR Code)
    public function check_status()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error']);
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderById($order_id, $_SESSION['user_id']);

        if ($order) {
            echo json_encode(['status' => 'success', 'trang_thai' => $order['trang_thai']]);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    // API lấy chi tiết đơn hàng cho User (Dành cho trang Tài khoản)
    public function api_get_order()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Unauthorized']);
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderById($order_id, $_SESSION['user_id']);

        if ($order) {
            $order['items'] = $orderModel->getOrderDetails($order_id);
            echo json_encode(['status' => 'success', 'data' => $order]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy đơn hàng.']);
        }
        exit;
    }
}
<?php
// controllers/OrderController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

class OrderController extends Controller
{
    // Trang Thanh Toán (Checkout)
    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Kiểm tra trạng thái đăng nhập
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "view/user/DangNhap.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }

        $userId = $_SESSION['user_id'];
        $userModel = $this->model('UserModel');
        $user = $userModel->getUserById($userId);

        $cartModel = $this->model('CartModel');
        $cart_id = $cartModel->getCartId($userId, session_id());
        $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];
        
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        $this->view('order/ThanhToan', [
            'user' => $user,
            'defaultName' => $user['ho_ten'] ?? '',
            'defaultPhone' => $user['so_dien_thoai'] ?? '',
            'defaultAddress' => $user['dia_chi'] ?? '',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'shippingFee' => 0,
            'finalTotal' => $totalPrice, // Phí ship = 0 ban đầu, JS sẽ tự cộng
            'page_css' => ['assets/css/ThanhToan.css']
        ]);
    }

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
            $dia_chi_chi_tiet = trim($_POST['dia_chi_chi_tiet'] ?? ''); // Số nhà, tên đường
            $to_district_id = intval($_POST['to_district_id'] ?? 0);
            $to_ward_code = trim($_POST['to_ward_code'] ?? '');
            $ghi_chu = trim($_POST['ghi_chu'] ?? '');
            $phuong_thuc = $_POST['phuong_thuc_thanh_toan'] ?? 'COD';

            if (empty($ho_ten) || empty($so_dien_thoai) || empty($dia_chi) || empty($to_district_id) || empty($to_ward_code)) {
                $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin giao hàng!';
                header('Location: ' . BASE_URL . 'view/order/ThanhToan.php');
                exit;
            }

            // Gộp thông tin liên hệ vào địa chỉ giao để dễ hiển thị
            $dia_chi_giao_day_du = "Người nhận: $ho_ten | SĐT: $so_dien_thoai | Địa chỉ: $dia_chi";

            // --- BẮT ĐẦU TÍCH HỢP GHN ---

            // Lấy sản phẩm từ Giỏ hàng
            $cartModel = $this->model('CartModel');
            $cart_id = $cartModel->getCartId($user_id, session_id());
            $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];

            if (empty($cartItems)) {
                $_SESSION['error_message'] = 'Giỏ hàng trống!';
                header('Location: ' . BASE_URL . 'view/cart/ChiTietGioHang.php');
                exit;
            }

            // Tính tổng tiền hàng và tổng cân nặng
            $tong_tien = 0;
            $tong_can_nang = 0;
            $ghn_items = [];
            foreach ($cartItems as $item) {
                $tong_tien += $item['price'] * $item['quantity'];
                $tong_can_nang += ($item['weight'] ?? 200) * $item['quantity'];
                $ghn_items[] = [
                    "name" => $item['name'],
                    "quantity" => $item['quantity'],
                    "price" => intval($item['price']),
                    "weight" => intval($item['weight'] ?? 200)
                ];
            }

            // Xác định số tiền cần thu hộ (COD)
            $cod_amount = ($phuong_thuc === 'COD') ? intval($tong_tien) : 0;

            // Chuẩn bị dữ liệu gửi lên GHN
            $ghnOrderData = [
                "payment_type_id" => 2, // 2: Shop trả phí ship
                "note" => $ghi_chu,
                "required_note" => "KHONGCHOXEMHANG", // Ví dụ: Không cho xem hàng
                "to_name" => $ho_ten,
                "to_phone" => $so_dien_thoai,
                "to_address" => $dia_chi_chi_tiet,
                "to_ward_code" => $to_ward_code,
                "to_district_id" => $to_district_id,
                "cod_amount" => $cod_amount,
                "weight" => $tong_can_nang,
                "service_type_id" => 2, // 2: Dịch vụ chuẩn
                "items" => $ghn_items
            ];

            // Gọi API tạo đơn hàng của GHN
            $ghnModel = $this->model('GHNModel');
            $ghnResponse = $ghnModel->createOrder($ghnOrderData);

            // Xử lý kết quả từ GHN
            if (isset($ghnResponse['code']) && $ghnResponse['code'] == 200) {
                $ghn_order_code = $ghnResponse['data']['order_code'];
                $phi_van_chuyen_thuc_te = $ghnResponse['data']['total_fee'];
                // Tổng tiền cuối cùng khách phải trả (luôn là tiền hàng + phí ship)
                $tong_tien_cuoi = $tong_tien + $phi_van_chuyen_thuc_te;

                // Lưu đơn hàng vào CSDL của bạn
                $orderModel = $this->model('OrderModel');
                $order_id = $orderModel->createOrder($user_id, $tong_tien_cuoi, $dia_chi_giao_day_du, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen_thuc_te);

                if ($order_id) {
                    header('Location: ' . BASE_URL . 'index.php?url=order/success&id=' . $order_id);
                } else {
                    // Lỗi nghiêm trọng: Đã tạo đơn trên GHN nhưng không lưu được vào DB
                    $_SESSION['error_message'] = 'Lỗi hệ thống! Đã tạo đơn trên GHN (' . $ghn_order_code . ') nhưng không thể lưu vào website. Vui lòng liên hệ admin.';
                    header('Location: ' . BASE_URL . 'view/order/ThanhToan.php');
                }
            } else {
                // Lỗi từ API của GHN
                $ghn_error_message = $ghnResponse['message'] ?? 'Lỗi không xác định từ Giao Hàng Nhanh.';
                $_SESSION['error_message'] = 'Lỗi tạo đơn hàng: ' . $ghn_error_message;
                header('Location: ' . BASE_URL . 'view/order/ThanhToan.php');
            }
            exit;
        }
    }

    public function cancel()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $user_id = $_SESSION['user_id'];

        if ($order_id > 0) {
            $orderModel = $this->model('OrderModel');
            if ($orderModel->cancelOrder($order_id, $user_id)) {
                $_SESSION['success_message'] = "Đã hủy đơn hàng #ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . " thành công.";
            } else {
                $_SESSION['error_message'] = "Không thể hủy đơn hàng này hoặc bạn không có quyền.";
            }
        } else {
            $_SESSION['error_message'] = "Mã đơn hàng không hợp lệ.";
        }

        header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php?tab=orders');
        exit;
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
        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderById($order_id, $_SESSION['user_id']);

        if (!$order) {
            die("Đơn hàng không tồn tại hoặc không thuộc về bạn.");
        }
        $order['items'] = $orderModel->getOrderDetails($order_id);

        $this->view('order/ThanhToanThanhCong', [
            'order' => $order
        ]);
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
        $orderModel = $this->model('OrderModel');
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
        $orderModel = $this->model('OrderModel');
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
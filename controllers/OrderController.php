<?php
// controllers/OrderController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

// Load thư viện PHPMailer
require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        // Tính giảm giá hạng thành viên
        $hang = $user['hang'] ?? 'Đồng';
        $phanTramGiam = 0;
        if ($hang === 'Kim Cương') $phanTramGiam = 10;
        elseif ($hang === 'Vàng') $phanTramGiam = 5;
        elseif ($hang === 'Bạc') $phanTramGiam = 2;
        $giamGiaThanhVien = ($totalPrice * $phanTramGiam) / 100;

        // Lấy danh sách Voucher đang hoạt động
        $voucherModel = $this->model('VoucherModel');
        $activeVouchers = $voucherModel->getActiveVouchers();

        $this->view('order/ThanhToan', [
            'user' => $user,
            'defaultName' => $user['ho_ten'] ?? '',
            'defaultPhone' => $user['so_dien_thoai'] ?? '',
            'defaultAddress' => $user['dia_chi'] ?? '',
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'phanTramGiam' => $phanTramGiam,
            'giamGiaThanhVien' => $giamGiaThanhVien,
            'activeVouchers' => $activeVouchers,
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

            $ghnModel = $this->model('GHNModel');
            
            // 1. Tính phí ship trước bằng API Fee của GHN
            $feeResponse = $ghnModel->calculateFee($to_district_id, $to_ward_code, $tong_can_nang);
            $phi_van_chuyen_thuc_te = 0;
            if (isset($feeResponse['code']) && $feeResponse['code'] == 200) {
                $phi_van_chuyen_thuc_te = $feeResponse['data']['total'];
            }

            // 2. Tính giảm giá thành viên
            $userModel = $this->model('UserModel');
            $user = $userModel->getUserById($user_id);
            $hang = $user['hang'] ?? 'Đồng';
            $phanTramGiam = 0;
            if ($hang === 'Kim Cương') $phanTramGiam = 10;
            elseif ($hang === 'Vàng') $phanTramGiam = 5;
            elseif ($hang === 'Bạc') $phanTramGiam = 2;
            $giam_gia_thanh_vien = ($tong_tien * $phanTramGiam) / 100;

            // 3. Tính toán Voucher
            $ma_voucher = trim($_POST['ma_voucher'] ?? '');
            $giam_gia_voucher = 0;
            $giam_gia_freeship = 0;
            $loai_voucher = '';
            $tien_giam_ghi_db = 0;

            if (!empty($ma_voucher)) {
                $voucherModel = $this->model('VoucherModel');
                $checkVoucher = $voucherModel->checkVoucher($ma_voucher);
                if ($checkVoucher['status'] && $tong_tien >= $checkVoucher['data']['don_toi_thieu']) {
                    $vData = $checkVoucher['data'];
                    $loai_voucher = $vData['loai_voucher'];
                    
                    if ($loai_voucher == 'TienMat') {
                        $giam_gia_voucher = $vData['gia_tri'];
                    } elseif ($loai_voucher == 'PhanTram') {
                        $giam_gia_voucher = ($tong_tien * $vData['gia_tri']) / 100;
                        if ($vData['giam_toi_da'] > 0 && $giam_gia_voucher > $vData['giam_toi_da']) {
                            $giam_gia_voucher = $vData['giam_toi_da'];
                        }
                    } elseif ($loai_voucher == 'FreeShip') {
                        $giam_gia_freeship = min($phi_van_chuyen_thuc_te, $vData['gia_tri']);
                    }
                    
                    $tien_giam_ghi_db = ($loai_voucher == 'FreeShip') ? $giam_gia_freeship : $giam_gia_voucher;
                } else {
                    $ma_voucher = null; // Hủy mã nếu không hợp lệ
                }
            }

            // 4. Chốt số tiền cuối cùng khách phải trả
            $tien_hang_sau_giam = $tong_tien - $giam_gia_thanh_vien - $giam_gia_voucher;
            if ($tien_hang_sau_giam < 0) $tien_hang_sau_giam = 0;

            $phi_ship_sau_giam = $phi_van_chuyen_thuc_te - $giam_gia_freeship;
            if ($phi_ship_sau_giam < 0) $phi_ship_sau_giam = 0;

            $tong_tien_cuoi = $tien_hang_sau_giam + $phi_ship_sau_giam;

            // Xác định số tiền cần thu hộ (COD) trên tổng tiền ĐÃ GIẢM
            $cod_amount = ($phuong_thuc === 'COD') ? intval($tong_tien_cuoi) : 0;

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
            $ghnResponse = $ghnModel->createOrder($ghnOrderData);

            // Xử lý kết quả từ GHN
            if (isset($ghnResponse['code']) && $ghnResponse['code'] == 200) {
                $ghn_order_code = $ghnResponse['data']['order_code'];

                // Lưu đơn hàng vào CSDL của bạn
                $orderModel = $this->model('OrderModel');
                $order_id = $orderModel->createOrder($user_id, $tong_tien_cuoi, $dia_chi_giao_day_du, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen_thuc_te, $giam_gia_thanh_vien, $ma_voucher, $tien_giam_ghi_db);

                if ($order_id) {
                    if (!empty($ma_voucher)) {
                        $voucherModel->incrementVoucherUsage($ma_voucher); // Tăng lượt dùng voucher
                    }
                    
                    // Chỉ gửi email ngay lập tức cho đơn COD
                    if ($phuong_thuc === 'COD') {
                        $this->sendOrderConfirmationEmail($user, $order_id, $tong_tien_cuoi, $cartItems);
                    }

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

    // API Ajax cho chức năng chọn/nhập Voucher ở frontend màn hình Thanh Toán
    public function api_apply_voucher()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ma_voucher = trim($_POST['ma_voucher'] ?? '');
            $tong_tien = intval($_POST['tong_tien'] ?? 0); // Tiền hàng ban đầu
            $phi_ship = intval($_POST['phi_ship'] ?? 0);   // Phí ship hiện tại

            if (empty($ma_voucher)) {
                echo json_encode(['status' => false, 'msg' => 'Vui lòng nhập mã giảm giá.']);
                exit;
            }

            $voucherModel = $this->model('VoucherModel');
            $check = $voucherModel->checkVoucher($ma_voucher);

            if (!$check['status']) {
                echo json_encode($check);
                exit;
            }

            $vData = $check['data'];
            if ($tong_tien < $vData['don_toi_thieu']) {
                echo json_encode(['status' => false, 'msg' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($vData['don_toi_thieu'], 0, ',', '.') . 'đ']);
                exit;
            }

            $giam_gia = 0;
            if ($vData['loai_voucher'] == 'TienMat') {
                $giam_gia = $vData['gia_tri'];
            } elseif ($vData['loai_voucher'] == 'PhanTram') {
                $giam_gia = ($tong_tien * $vData['gia_tri']) / 100;
                if ($vData['giam_toi_da'] > 0 && $giam_gia > $vData['giam_toi_da']) {
                    $giam_gia = $vData['giam_toi_da'];
                }
            } elseif ($vData['loai_voucher'] == 'FreeShip') {
                $giam_gia = min($phi_ship, $vData['gia_tri']);
            }

            echo json_encode([
                'status' => true,
                'msg' => 'Áp dụng mã thành công!',
                'giam_gia' => $giam_gia,
                'loai_voucher' => $vData['loai_voucher']
            ]);
        }
        exit;
    }

    // --- HÀM GỬI EMAIL XÁC NHẬN ĐƠN HÀNG ---
    private function sendOrderConfirmationEmail($user, $order_id, $tong_tien_cuoi, $cartItems) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_USERNAME, 'COZY CORNER');
            $mail->addAddress($user['email'], $user['ho_ten']);

            $mail->isHTML(true);
            $mail->Subject = "Xác nhận đơn hàng #ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . " từ COZY CORNER";
            
            // Tạo bảng HTML chứa danh sách sản phẩm
            $itemsHtml = '';
            foreach ($cartItems as $item) {
                $subtotal = number_format($item['price'] * $item['quantity'], 0, ',', '.');
                $price = number_format($item['price'], 0, ',', '.');
                $itemsHtml .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$item['name']}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$item['quantity']}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$price}đ</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$subtotal}đ</td>
                    </tr>
                ";
            }

            $totalFormatted = number_format($tong_tien_cuoi, 0, ',', '.');

            // Nắp ráp toàn bộ khung Email
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                    <div style='background-color: #2e5932; color: #fff; padding: 25px; text-align: center;'>
                        <h2 style='margin: 0; font-size: 24px;'>Cảm ơn bạn đã đặt hàng!</h2>
                    </div>
                    <div style='padding: 30px; color: #444; line-height: 1.6;'>
                        <p style='font-size: 16px;'>Xin chào <strong>{$user['ho_ten']}</strong>,</p>
                        <p style='font-size: 15px;'>COZY CORNER đã nhận được đơn hàng <strong>#ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . "</strong> của bạn và đang tiến hành xử lý.</p>
                        
                        <h3 style='border-bottom: 2px solid #eee; padding-bottom: 10px; color: #2e5932; margin-top: 30px;'>Chi tiết đơn hàng</h3>
                        <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;'>
                            <thead>
                                <tr style='background-color: #f8fbf9;'>
                                    <th style='padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; color: #2e5932;'>Sản phẩm</th>
                                    <th style='padding: 12px 10px; text-align: center; border-bottom: 2px solid #ddd; color: #2e5932;'>SL</th>
                                    <th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd; color: #2e5932;'>Đơn giá</th>
                                    <th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd; color: #2e5932;'>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                {$itemsHtml}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='3' style='padding: 20px 10px; text-align: right;'>Tổng thanh toán:</td>
                                    <td style='padding: 20px 10px; text-align: right;'>{$totalFormatted}đ</td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <p style='text-align: center; margin-top: 35px;'>
                            <a href='" . BASE_URL . "index.php?url=user/account&tab=orders' style='background-color: #2e5932; color: #fff; padding: 14px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;'>Xem Lịch Sử Đơn Hàng</a>
                        </p>
                    </div>
                    <div style='background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 13px; color: #888; border-top: 1px solid #eee;'>
                        <p style='margin: 0 0 5px 0;'>Đây là email tự động từ hệ thống, vui lòng không trả lời email này.</p>
                        <p style='margin: 0; font-weight: bold;'>© " . date('Y') . " COZY CORNER.</p>
                    </div>
                </div>
            ";
            
            $mail->send();
        } catch (Exception $e) {
            // Chỉ ghi log lỗi ra file để debug, không làm gián đoạn luồng đặt hàng của khách
            error_log("Lỗi gửi mail xác nhận đơn hàng: " . $mail->ErrorInfo);
        }
    }
}
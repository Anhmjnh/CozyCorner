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
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $is_guest = !isset($_SESSION['user_id']) || empty($_SESSION['user_id']);
        $userId = $_SESSION['user_id'] ?? null;
        $user = null;
        $giamGiaThanhVien = 0;
        $phanTramGiam = 0;
        $userAddresses = [];

        $cartModel = $this->model('CartModel');
        $cart_id = $cartModel->getCartId($userId, session_id());
        $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];

        // Nếu giỏ hàng trống, chuyển hướng về trang giỏ hàng, không cho vào thanh toán
        if (empty($cartItems)) {
            header("Location: " . BASE_URL . "index.php?url=cart");
            exit;
        }

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        if (!$is_guest) {
            $userModel = $this->model('UserModel');
            $user = $userModel->getUserById($userId);

            // Tính giảm giá hạng thành viên
            $hang = $user['hang'] ?? 'Đồng';
            if ($hang === 'Kim Cương')
                $phanTramGiam = 10;
            elseif ($hang === 'Vàng')
                $phanTramGiam = 5;
            elseif ($hang === 'Bạc')
                $phanTramGiam = 2;
            $giamGiaThanhVien = ($totalPrice * $phanTramGiam) / 100;

            // Lấy sổ địa chỉ của User
            require_once __DIR__ . '/../models/AddressModel.php';
            $addressModel = new AddressModel();
            $userAddresses = $addressModel->getUserAddresses($userId);
        }

        // Khách không được thấy voucher
        $activeVouchers = !$is_guest ? $this->model('VoucherModel')->getActiveVouchers() : [];

        $this->view('order/ThanhToan', [
            'user' => $user,
            'userAddresses' => $userAddresses,
            'is_guest' => $is_guest,
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

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?url=order/checkout');
            exit;
        }

        $is_guest = !isset($_SESSION['user_id']) || empty($_SESSION['user_id']);

        if ($is_guest) {
            $this->processGuestCheckoutStep1();
        } else {
            $this->processLoggedInUserCheckout();
        }
    }

    private function processGuestCheckoutStep1()
    {
        try {
            $email = trim($_POST['email'] ?? '');
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $dia_chi_chi_tiet = trim($_POST['dia_chi_chi_tiet'] ?? '');
            $to_district_id = intval($_POST['to_district_id'] ?? 0);
            $to_ward_code = trim($_POST['to_ward_code'] ?? '');

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Vui lòng nhập địa chỉ email hợp lệ.');
            }
            if (empty($ho_ten) || empty($so_dien_thoai) || empty($dia_chi) || empty($to_district_id) || empty($to_ward_code)) {
                throw new Exception('Vui lòng điền đầy đủ thông tin giao hàng.');
            }

            $cartModel = $this->model('CartModel');
            $cart_id = $cartModel->getCartId(null, session_id());
            $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];

            if (empty($cartItems)) {
                throw new Exception('Giỏ hàng của bạn đang trống!');
            }

            $otp = rand(100000, 999999);

            // Lưu tất cả dữ liệu thanh toán vào session
            $_SESSION['guest_checkout_data'] = [
                'post_data' => $_POST,
                'cart_items' => $cartItems,
                'cart_id' => $cart_id,
                'otp' => $otp,
                'otp_expire' => time() + 300 // 5 phút
            ];

            // Gửi email OTP
            $this->sendCheckoutOtpEmail($email, $otp);

            header("Location: " . BASE_URL . "index.php?url=order/showVerifyCheckoutOtp");
            exit;

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Lỗi: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=order/checkout');
            exit;
        }
    }

    public function showVerifyCheckoutOtp()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if (!isset($_SESSION['guest_checkout_data'])) {
            header('Location: ' . BASE_URL . 'index.php?url=order/checkout');
            exit;
        }

        $email = $_SESSION['guest_checkout_data']['post_data']['email'] ?? '';
        $this->view('order/XacThucThanhToan', [
            'email' => $email
        ]);
    }

    public function verifyGuestOrder()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['guest_checkout_data'])) {
            header('Location: ' . BASE_URL . 'index.php?url=order/checkout');
            exit;
        }

        $orderModel = $this->model('OrderModel');
        $db = $orderModel->getDbConnection(); 
        $ghn_order_code = null;

        $db->begin_transaction();

        try {
            $otp_input = trim($_POST['otp'] ?? '');
            $checkout_data = $_SESSION['guest_checkout_data'];

            if (empty($otp_input) || $otp_input != $checkout_data['otp']) {
                throw new Exception('Mã OTP không đúng!');
            }
            if (time() > $checkout_data['otp_expire']) {
                unset($_SESSION['guest_checkout_data']);
                throw new Exception('Mã OTP đã hết hạn!');
            }

            $cart_id = $checkout_data['cart_id'];
            $cartItems = $checkout_data['cart_items'];
            $_POST = $checkout_data['post_data']; // Nạp lại dữ liệu POST để tái sử dụng logic

            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            // KIỂM TRA TRÙNG EMAIL VỚI USER CÓ SẴN ĐỂ ĐƯA VÀO LỊCH SỬ ĐƠN HÀNG
            $userModel = $this->model('UserModel');
            $existingUser = $userModel->getUserByEmail($email);
            $user_id = $existingUser ? $existingUser['id'] : null;

            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $dia_chi_chi_tiet = trim($_POST['dia_chi_chi_tiet'] ?? '');
            $to_district_id = intval($_POST['to_district_id'] ?? 0);
            $to_ward_code = trim($_POST['to_ward_code'] ?? '');
            $ghi_chu = trim($_POST['ghi_chu'] ?? '');
            $phuong_thuc = $_POST['phuong_thuc_thanh_toan'] ?? 'COD';
            
            // Lấy dữ liệu hóa đơn công ty
            $xuat_hoa_don_cong_ty = isset($_POST['xuat_hoa_don_cong_ty']) ? 1 : 0;
            $ten_cong_ty = $xuat_hoa_don_cong_ty ? trim($_POST['ten_cong_ty'] ?? '') : null;
            $ma_so_thue = $xuat_hoa_don_cong_ty ? trim($_POST['ma_so_thue'] ?? '') : null;
            $dia_chi_cong_ty = $xuat_hoa_don_cong_ty ? trim($_POST['dia_chi_cong_ty'] ?? '') : null;
            $email_nhan_hoa_don = $xuat_hoa_don_cong_ty ? trim($_POST['email_nhan_hoa_don'] ?? '') : null;

            if (empty($cartItems)) {
                throw new Exception('Giỏ hàng của bạn đang trống!');
            }

            $tong_tien = 0;
            $tong_can_nang = 0;
            $ghn_items = [];
            foreach ($cartItems as $item) {
                $tong_tien += $item['price'] * $item['quantity'];
                $tong_can_nang += ($item['weight'] ?? 200) * $item['quantity'];
                $ghn_items[] = ["name" => $item['name'], "quantity" => $item['quantity'], "price" => intval($item['price']), "weight" => intval($item['weight'] ?? 200)];
            }

            $ghnModel = $this->model('GHNModel');
            $feeResponse = $ghnModel->calculateFee($to_district_id, $to_ward_code, $tong_can_nang);
            $phi_van_chuyen_thuc_te = (isset($feeResponse['code']) && $feeResponse['code'] == 200) ? $feeResponse['data']['total'] : 0;

            // Khách không có giảm giá thành viên
            $giam_gia_thanh_vien = 0;
            
            $ma_voucher = trim($_POST['ma_voucher'] ?? '');
            $giam_gia_voucher = 0;
            $giam_gia_freeship = 0;
            $tien_giam_ghi_db = 0;
            
            if (!empty($ma_voucher)) {
                $voucherModel = $this->model('VoucherModel');
                $checkVoucher = $voucherModel->checkVoucher($ma_voucher);
                if ($checkVoucher['status'] && $tong_tien >= $checkVoucher['data']['don_toi_thieu']) {
                    $vData = $checkVoucher['data'];
                    if ($vData['loai_voucher'] == 'TienMat') {
                        $giam_gia_voucher = $vData['gia_tri'];
                    } elseif ($vData['loai_voucher'] == 'PhanTram') {
                        $giam_gia_voucher = ($tong_tien * $vData['gia_tri']) / 100;
                        if ($vData['giam_toi_da'] > 0 && $giam_gia_voucher > $vData['giam_toi_da']) $giam_gia_voucher = $vData['giam_toi_da'];
                    } elseif ($vData['loai_voucher'] == 'FreeShip') {
                        $giam_gia_freeship = min($phi_van_chuyen_thuc_te, $vData['gia_tri']);
                    }
                    $tien_giam_ghi_db = ($vData['loai_voucher'] == 'FreeShip') ? $giam_gia_freeship : $giam_gia_voucher;
                } else {
                    $ma_voucher = null;
                }
            }

            $tien_hang_sau_giam = max(0, $tong_tien - $giam_gia_thanh_vien - $giam_gia_voucher);
            $phi_ship_sau_giam = max(0, $phi_van_chuyen_thuc_te - $giam_gia_freeship);
            $tien_truoc_thue = $tien_hang_sau_giam + $phi_ship_sau_giam;
            $thue_gtgt = round($tien_truoc_thue * 0.08);
            $tong_tien_cuoi = $tien_truoc_thue + $thue_gtgt;
            $cod_amount = ($phuong_thuc === 'COD') ? intval($tong_tien_cuoi) : 0;

            $ghnOrderData = ["payment_type_id" => 2, "note" => $ghi_chu, "required_note" => "KHONGCHOXEMHANG", "to_name" => $ho_ten, "to_phone" => $so_dien_thoai, "to_address" => $dia_chi_chi_tiet, "to_ward_code" => $to_ward_code, "to_district_id" => $to_district_id, "cod_amount" => $cod_amount, "weight" => $tong_can_nang, "service_type_id" => 2, "items" => $ghn_items];

            $ghnResponse = $ghnModel->createOrder($ghnOrderData);

            if (!isset($ghnResponse['code']) || $ghnResponse['code'] != 200) {
                throw new Exception($ghnResponse['message'] ?? 'Lỗi không xác định từ Giao Hàng Nhanh.');
            }
            $ghn_order_code = $ghnResponse['data']['order_code'];

            $order_id = $orderModel->createOrder($user_id, $cart_id, $tong_tien_cuoi, $ho_ten, $so_dien_thoai, $dia_chi, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen_thuc_te, $giam_gia_thanh_vien, $ma_voucher, $tien_giam_ghi_db, $email, $xuat_hoa_don_cong_ty, $ten_cong_ty, $ma_so_thue, $dia_chi_cong_ty, $email_nhan_hoa_don);

            if (!$order_id) {
                throw new Exception("Không thể lưu đơn hàng vào cơ sở dữ liệu.");
            }

            if (!empty($ma_voucher)) {
                $voucherModel = $this->model('VoucherModel');
                if (!$voucherModel->incrementVoucherUsage($ma_voucher)) {
                    throw new Exception("Lỗi cập nhật voucher.");
                }
            }

            $db->commit();

            if ($phuong_thuc !== 'ChuyenKhoan') {
                // Gửi email xác nhận cho khách
                $guest_user_info = ['email' => $_POST['email'], 'ho_ten' => $ho_ten];
                $orderInfoMail = [
                    'xuat_hoa_don_cong_ty' => $xuat_hoa_don_cong_ty,
                    'ten_cong_ty' => $ten_cong_ty,
                    'ma_so_thue' => $ma_so_thue,
                    'dia_chi_cong_ty' => $dia_chi_cong_ty,
                    'email_nhan_hoa_don' => $email_nhan_hoa_don,
                    'phi_van_chuyen' => $phi_van_chuyen_thuc_te,
                    'giam_gia_thanh_vien' => $giam_gia_thanh_vien,
                    'giam_gia_voucher' => $tien_giam_ghi_db,
                    'ma_voucher' => $ma_voucher
                ];
                $this->sendOrderConfirmationEmail($guest_user_info, $order_id, $tong_tien_cuoi, $cartItems, $orderInfoMail);
            }

            unset($_SESSION['guest_checkout_data']);
            $_SESSION['guest_just_completed_order'] = $order_id; // Cấp quyền xem cho phiên khách vừa đặt
            header('Location: ' . BASE_URL . 'index.php?url=order/success&id=' . $order_id);
            exit;

        } catch (Exception $e) {
            $db->rollback();

            if ($ghn_order_code) {
                $ghnModel = $this->model('GHNModel');
                $ghnModel->cancelOrder($ghn_order_code);
            }

            $_SESSION['otp_error_message'] = 'Lỗi khi xử lý đơn hàng: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?url=order/showVerifyCheckoutOtp');
            exit;
        }
    }

    private function processLoggedInUserCheckout()
    {
        $orderModel = $this->model('OrderModel');
        $db = $orderModel->getDbConnection();
        $ghn_order_code = null;

        $db->begin_transaction();

        try {
            $user_id = $_SESSION['user_id'];
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $dia_chi_chi_tiet = trim($_POST['dia_chi_chi_tiet'] ?? '');
            $to_district_id = intval($_POST['to_district_id'] ?? 0);
            $to_ward_code = trim($_POST['to_ward_code'] ?? '');
            $ghi_chu = trim($_POST['ghi_chu'] ?? '');
            $phuong_thuc = $_POST['phuong_thuc_thanh_toan'] ?? 'COD';
            
            // Lấy dữ liệu hóa đơn công ty
            $xuat_hoa_don_cong_ty = isset($_POST['xuat_hoa_don_cong_ty']) ? 1 : 0;
            $ten_cong_ty = $xuat_hoa_don_cong_ty ? trim($_POST['ten_cong_ty'] ?? '') : null;
            $ma_so_thue = $xuat_hoa_don_cong_ty ? trim($_POST['ma_so_thue'] ?? '') : null;
            $dia_chi_cong_ty = $xuat_hoa_don_cong_ty ? trim($_POST['dia_chi_cong_ty'] ?? '') : null;
            $email_nhan_hoa_don = $xuat_hoa_don_cong_ty ? trim($_POST['email_nhan_hoa_don'] ?? '') : null;

            // Tính năng Auto-save: Tự động lưu địa chỉ mới vào sổ nếu khách có tick chọn
            if (isset($_POST['save_address']) && $_POST['save_address'] == 1) {
                require_once __DIR__ . '/../models/AddressModel.php';
                $addrModel = new AddressModel();
                $addrModel->addAddress([
                    'user_id' => $user_id,
                    'ho_ten' => $ho_ten,
                    'so_dien_thoai' => $so_dien_thoai,
                    'province_id' => intval($_POST['province_id'] ?? 0), // Ta sẽ đón thêm từ JS ở View
                    'district_id' => $to_district_id,
                    'ward_code' => $to_ward_code,
                    'province_name' => trim($_POST['province_name'] ?? ''),
                    'district_name' => trim($_POST['district_name'] ?? ''),
                    'ward_name' => trim($_POST['ward_name'] ?? ''),
                    'dia_chi_chi_tiet' => str_replace(', ' . trim($_POST['ward_name'] ?? ''), '', $dia_chi), // Cắt lấy số nhà
                    'loai_dia_chi' => 'NhaRieng',
                    'is_default' => 0
                ]);
            }

            if (empty($ho_ten) || empty($so_dien_thoai) || empty($dia_chi) || empty($to_district_id) || empty($to_ward_code)) {
                throw new Exception('Vui lòng điền đầy đủ thông tin giao hàng!');
            }

            $cartModel = $this->model('CartModel');
            $cart_id = $cartModel->getCartId($user_id, session_id()); // Quan trọng: lấy cart_id
            $cartItems = $cart_id ? $cartModel->getCartItems($cart_id) : [];

            $tong_tien = 0;
            $tong_can_nang = 0;
            $ghn_items = [];
            foreach ($cartItems as $item) {
                $tong_tien += $item['price'] * $item['quantity'];
                $tong_can_nang += ($item['weight'] ?? 200) * $item['quantity'];
                $ghn_items[] = ["name" => $item['name'], "quantity" => $item['quantity'], "price" => intval($item['price']), "weight" => intval($item['weight'] ?? 200)];
            }

            $ghnModel = $this->model('GHNModel');
            $feeResponse = $ghnModel->calculateFee($to_district_id, $to_ward_code, $tong_can_nang);
            $phi_van_chuyen_thuc_te = (isset($feeResponse['code']) && $feeResponse['code'] == 200) ? $feeResponse['data']['total'] : 0;

            $userModel = $this->model('UserModel');
            $user = $userModel->getUserById($user_id);
            $hang = $user['hang'] ?? 'Đồng';
            $phanTramGiam = 0;
            if ($hang === 'Kim Cương') $phanTramGiam = 10;
            elseif ($hang === 'Vàng') $phanTramGiam = 5;
            elseif ($hang === 'Bạc') $phanTramGiam = 2;
            $giam_gia_thanh_vien = ($tong_tien * $phanTramGiam) / 100;

            $ma_voucher = trim($_POST['ma_voucher'] ?? '');
            $giam_gia_voucher = 0;
            $giam_gia_freeship = 0;
            $tien_giam_ghi_db = 0;
            if (!empty($ma_voucher)) {
                $voucherModel = $this->model('VoucherModel');
                $checkVoucher = $voucherModel->checkVoucher($ma_voucher);
                if ($checkVoucher['status'] && $tong_tien >= $checkVoucher['data']['don_toi_thieu']) {
                    $vData = $checkVoucher['data'];
                    if ($vData['loai_voucher'] == 'TienMat') $giam_gia_voucher = $vData['gia_tri'];
                    elseif ($vData['loai_voucher'] == 'PhanTram') {
                        $giam_gia_voucher = ($tong_tien * $vData['gia_tri']) / 100;
                        if ($vData['giam_toi_da'] > 0 && $giam_gia_voucher > $vData['giam_toi_da']) $giam_gia_voucher = $vData['giam_toi_da'];
                    } elseif ($vData['loai_voucher'] == 'FreeShip') $giam_gia_freeship = min($phi_van_chuyen_thuc_te, $vData['gia_tri']);
                    $tien_giam_ghi_db = ($vData['loai_voucher'] == 'FreeShip') ? $giam_gia_freeship : $giam_gia_voucher;
                } else $ma_voucher = null;
            }

            $tien_hang_sau_giam = max(0, $tong_tien - $giam_gia_thanh_vien - $giam_gia_voucher);
            $phi_ship_sau_giam = max(0, $phi_van_chuyen_thuc_te - $giam_gia_freeship);
            $tien_truoc_thue = $tien_hang_sau_giam + $phi_ship_sau_giam;
            $thue_gtgt = round($tien_truoc_thue * 0.08);
            $tong_tien_cuoi = $tien_truoc_thue + $thue_gtgt;
            $cod_amount = ($phuong_thuc === 'COD') ? intval($tong_tien_cuoi) : 0;

            $ghnOrderData = ["payment_type_id" => 2, "note" => $ghi_chu, "required_note" => "KHONGCHOXEMHANG", "to_name" => $ho_ten, "to_phone" => $so_dien_thoai, "to_address" => $dia_chi_chi_tiet, "to_ward_code" => $to_ward_code, "to_district_id" => $to_district_id, "cod_amount" => $cod_amount, "weight" => $tong_can_nang, "service_type_id" => 2, "items" => $ghn_items];

            $ghnResponse = $ghnModel->createOrder($ghnOrderData);

            if (!isset($ghnResponse['code']) || $ghnResponse['code'] != 200) {
                throw new Exception($ghnResponse['message'] ?? 'Lỗi không xác định từ Giao Hàng Nhanh.');
            }
            $ghn_order_code = $ghnResponse['data']['order_code'];

            $email_nguoi_nhan = $user['email'] ?? null;
            $order_id = $orderModel->createOrder($user_id, $cart_id, $tong_tien_cuoi, $ho_ten, $so_dien_thoai, $dia_chi, $ghi_chu, $cartItems, $ghn_order_code, $phuong_thuc, $phi_van_chuyen_thuc_te, $giam_gia_thanh_vien, $ma_voucher, $tien_giam_ghi_db, $email_nguoi_nhan, $xuat_hoa_don_cong_ty, $ten_cong_ty, $ma_so_thue, $dia_chi_cong_ty, $email_nhan_hoa_don);

            if (!$order_id) {
                throw new Exception("Không thể lưu đơn hàng vào cơ sở dữ liệu.");
            }

            if (!empty($ma_voucher)) {
                $voucherModel = $this->model('VoucherModel');
                if (!$voucherModel->incrementVoucherUsage($ma_voucher)) {
                    throw new Exception("Lỗi cập nhật voucher.");
                }
            }

            $db->commit();

            if ($phuong_thuc !== 'ChuyenKhoan') {
                $orderInfoMail = [
                    'xuat_hoa_don_cong_ty' => $xuat_hoa_don_cong_ty,
                    'ten_cong_ty' => $ten_cong_ty,
                    'ma_so_thue' => $ma_so_thue,
                    'dia_chi_cong_ty' => $dia_chi_cong_ty,
                    'email_nhan_hoa_don' => $email_nhan_hoa_don,
                    'phi_van_chuyen' => $phi_van_chuyen_thuc_te,
                    'giam_gia_thanh_vien' => $giam_gia_thanh_vien,
                    'giam_gia_voucher' => $tien_giam_ghi_db,
                    'ma_voucher' => $ma_voucher
                ];
                $this->sendOrderConfirmationEmail($user, $order_id, $tong_tien_cuoi, $cartItems, $orderInfoMail);
            }
            header('Location: ' . BASE_URL . 'index.php?url=order/success&id=' . $order_id);
            exit;

        } catch (Exception $e) {
            $db->rollback();

            if ($ghn_order_code) {
                $ghnModel = $this->model('GHNModel');
                $ghnModel->cancelOrder($ghn_order_code);
            }

            if ($e->getMessage() === "Không thể lưu đơn hàng vào cơ sở dữ liệu.") {
                $_SESSION['error_message'] = 'Lỗi hệ thống! Đã tạo đơn trên GHN (' . $ghn_order_code . ') nhưng không thể lưu vào website. Vui lòng liên hệ admin.';
            } else {
                $_SESSION['error_message'] = 'Lỗi khi xử lý đơn hàng: ' . $e->getMessage();
            }

            header('Location: ' . BASE_URL . 'index.php?url=order/checkout');
            exit;
        }
    }

    public function cancel()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth/showLogin');
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $user_id = $_SESSION['user_id'];

        if ($order_id > 0) {
            $orderModel = $this->model('OrderModel');
            $order = $orderModel->getOrderByIdAndUser($order_id, $user_id);

            // Hủy đơn hàng trên GHN nếu có mã vận đơn
            if ($order && !empty($order['ghn_order_code'])) {
                $ghnModel = $this->model('GHNModel');
                $ghnModel->cancelOrder($order['ghn_order_code']);
            }

            if ($orderModel->cancelOrder($order_id, $user_id)) {
                $_SESSION['success_message'] = "Đã hủy đơn hàng #ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . " thành công.";
            } else {
                $_SESSION['error_message'] = "Không thể hủy đơn hàng này hoặc bạn không có quyền.";
            }
        } else {
            $_SESSION['error_message'] = "Mã đơn hàng không hợp lệ.";
        }

        header('Location: ' . BASE_URL . 'index.php?url=user/account&tab=orders');
        exit;
    }

    // Chức năng hiển thị Hóa Đơn / Mã QR
    public function success()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $user_id = $_SESSION['user_id'] ?? null;

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $orderModel = $this->model('OrderModel');

        $order = null;
        // Nếu khách (chưa đăng nhập) vừa thanh toán thành công đơn này trong phiên hiện tại
        if (isset($_SESSION['guest_just_completed_order']) && $_SESSION['guest_just_completed_order'] == $order_id) {
            $order = $orderModel->getOrderById($order_id);
        } else {
            // Cho phép cả khách và người dùng đã đăng nhập xem đơn hàng
            $order = $orderModel->getOrderByIdAndUser($order_id, $user_id);
            // Nếu không tìm thấy với user_id hiện tại (có thể là khách), thử tìm với user_id là NULL
            if (!$order && $user_id === null) {
                $order = $orderModel->getOrderByIdAndUser($order_id, null);
            }
        }

        if (!$order) {
            die("Đơn hàng không tồn tại hoặc không thuộc về bạn.");
        }
        $order['items'] = $orderModel->getOrderDetails($order_id);

        $this->view('order/ThanhToanThanhCong', [
            'order' => $order
        ]);
    }

    // Chức năng Xem và In Hóa Đơn GTGT (Từ link Email hoặc thao tác của Admin)
    public function printInvoice()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($order_id <= 0) {
            die("Mã hóa đơn không hợp lệ.");
        }

        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderById($order_id);

        if (!$order) {
            die("Không tìm thấy đơn hàng.");
        }

        // Kiểm tra quyền: Chỉ cho phép admin hoặc chủ đơn hàng (đã đăng nhập) xem
        $is_admin = isset($_SESSION['admin_id']);
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$is_admin && $order['user_id'] !== null && $order['user_id'] !== $user_id) {
            die("Bạn không có quyền xem hóa đơn này. Vui lòng đăng nhập đúng tài khoản mua hàng!");
        }

        $order['items'] = $orderModel->getOrderDetails($order_id);
        require_once __DIR__ . '/../view/order/HoadonGTGT.php';
    }

    // API kiểm tra trạng thái đơn hàng (Dành cho chức năng tự động load QR Code)
    public function check_status()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE)
        session_start();

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $user_id = $_SESSION['user_id'] ?? null;
        $orderModel = $this->model('OrderModel');
        
        $order = null;
        if (isset($_SESSION['guest_just_completed_order']) && $_SESSION['guest_just_completed_order'] == $order_id) {
            $order = $orderModel->getOrderById($order_id);
        } else if ($user_id) {
            $order = $orderModel->getOrderByIdAndUser($order_id, $user_id);
        } else {
            $order = $orderModel->getOrderByIdAndUser($order_id, null);
        }

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

        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Unauthorized']);
            exit;
        }

        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $orderModel = $this->model('OrderModel');
        
        // Quét dọn các đơn quá hạn trong lúc trình duyệt đang tự động kiểm tra
        $orderModel->cancelExpiredQROrders();

        $order = $orderModel->getOrderByIdAndUser($order_id, $_SESSION['user_id']);

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

    private function sendCheckoutOtpEmail($email, $otp)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(SMTP_USERNAME, 'COZY CORNER');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Mã xác nhận thanh toán - COZY CORNER";
            $mail->Body = "Xin chào,<br><br>Mã xác thực để hoàn tất đơn hàng của bạn là: <strong style='font-size: 20px; color: #355F2E;'>$otp</strong><br>Mã có hiệu lực trong 5 phút.<br>Nếu không phải bạn, vui lòng bỏ qua email này.";

            $mail->send();
            return true;

        } catch (Exception $e) {
            // Ghi log lỗi và throw exception để bên ngoài bắt
            error_log("Lỗi gửi mail OTP thanh toán: " . $mail->ErrorInfo);
            throw new Exception('Không thể gửi email xác thực. Vui lòng thử lại.');
        }
    }




    // --- HÀM GỬI EMAIL XÁC NHẬN ĐƠN HÀNG ---
    private function sendOrderConfirmationEmail($user, $order_id, $tong_tien_cuoi, $cartItems, $orderInfo = null) {
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

            // Gửi thêm bản sao email cho email nhận hóa đơn của công ty nếu có yêu cầu
            if ($orderInfo && !empty($orderInfo['xuat_hoa_don_cong_ty']) && !empty($orderInfo['email_nhan_hoa_don'])) {
                $mail->addAddress($orderInfo['email_nhan_hoa_don'], $orderInfo['ten_cong_ty'] ?? 'Công ty');
            }

            $mail->isHTML(true);
            $mail->Subject = "Xác nhận đơn hàng #ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . " từ COZY CORNER";
            
            // Tạo bảng HTML chứa danh sách sản phẩm
            $itemsHtml = '';
            $tong_san_pham = 0;
            foreach ($cartItems as $item) {
                $subtotal = number_format($item['price'] * $item['quantity'], 0, ',', '.');
                $price = number_format($item['price'], 0, ',', '.');
                $tong_san_pham += $item['price'] * $item['quantity'];
                
                // LOGIC UI: Thêm chữ [Đặt trước] nếu sản phẩm không có sẵn hoặc hết hàng
                $preOrderTag = '';
                if (isset($item['trang_thai']) && $item['trang_thai'] === 'HetHang' || (isset($item['so_luong_ton']) && $item['so_luong_ton'] < $item['quantity'])) {
                    $preOrderTag = ' <span style="color: #F57F17; font-size: 12px; font-weight: bold;">[Đặt trước]</span>';
                }
                
                $itemName = htmlspecialchars($item['name']) . $preOrderTag;
                
                $itemsHtml .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$itemName}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$item['quantity']}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$price}đ</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$subtotal}đ</td>
                    </tr>
                ";
            }

            $totalFormatted = number_format($tong_tien_cuoi, 0, ',', '.');
            
            $companyInvoiceHtml = '';
            if ($orderInfo && !empty($orderInfo['xuat_hoa_don_cong_ty'])) {
                $companyInvoiceHtml = "
                    <h3 style='border-bottom: 2px solid #eee; padding-bottom: 10px; color: #2e5932; margin-top: 30px;'>Yêu cầu xuất hóa đơn GTGT (VAT)</h3>
                    <div style='background: #f8fbf9; padding: 15px; border-radius: 8px; border: 1px solid #eef6f0; font-size: 14px;'>
                        <p style='margin: 0 0 8px 0;'><strong>Tên công ty:</strong> {$orderInfo['ten_cong_ty']}</p>
                        <p style='margin: 0 0 8px 0;'><strong>Mã số thuế:</strong> {$orderInfo['ma_so_thue']}</p>
                        <p style='margin: 0 0 8px 0;'><strong>Địa chỉ công ty:</strong> {$orderInfo['dia_chi_cong_ty']}</p>
                        <p style='margin: 0 0 0 0;'><strong>Email nhận hóa đơn:</strong> {$orderInfo['email_nhan_hoa_don']}</p>
                    </div>
                    <p style='color: #d9534f; font-size: 13px; font-style: italic; margin-top: 10px;'>* Hóa đơn điện tử GTGT chính thức có mã của Cơ quan Thuế sẽ được hệ thống tự động phát hành và gửi đến email của quý khách sau khi đơn hàng được giao và thanh toán thành công.</p>
                ";
            }
            
            $vatBreakdownHtml = '';
            $phi_ship = $orderInfo['phi_van_chuyen'] ?? 0;
            $giam_gia_thanh_vien = $orderInfo['giam_gia_thanh_vien'] ?? 0;
            $giam_gia_voucher = $orderInfo['giam_gia_voucher'] ?? 0;
            $ma_voucher = $orderInfo['ma_voucher'] ?? '';

            $tien_truoc_thue = $tong_san_pham - $giam_gia_thanh_vien + $phi_ship - $giam_gia_voucher;
            $tien_truoc_thue = max(0, $tien_truoc_thue);
            $tien_thue = round($tien_truoc_thue * 0.08);

            $vatBreakdownHtml = "
                <tr>
                    <td colspan='3' style='padding: 15px 10px 5px; text-align: right;'>Tổng tiền hàng:</td>
                    <td style='padding: 15px 10px 5px; text-align: right;'>" . number_format($tong_san_pham, 0, ',', '.') . "đ</td>
                </tr>
            ";
            
            if ($giam_gia_thanh_vien > 0) {
                $vatBreakdownHtml .= "
                <tr>
                    <td colspan='3' style='padding: 5px 10px; text-align: right;'>Giảm giá hạng thành viên:</td>
                    <td style='padding: 5px 10px; text-align: right;'>-" . number_format($giam_gia_thanh_vien, 0, ',', '.') . "đ</td>
                </tr>
                ";
            }
            
            $phi_ship_text = $phi_ship == 0 ? 'Miễn phí' : number_format($phi_ship, 0, ',', '.') . "đ";
            $vatBreakdownHtml .= "
                <tr>
                    <td colspan='3' style='padding: 5px 10px; text-align: right;'>Phí vận chuyển:</td>
                    <td style='padding: 5px 10px; text-align: right;'>" . $phi_ship_text . "</td>
                </tr>
            ";
            
            if ($giam_gia_voucher > 0) {
                $vatBreakdownHtml .= "
                <tr>
                    <td colspan='3' style='padding: 5px 10px; text-align: right;'>Mã giảm giá" . ($ma_voucher ? " ($ma_voucher)" : "") . ":</td>
                    <td style='padding: 5px 10px; text-align: right;'>-" . number_format($giam_gia_voucher, 0, ',', '.') . "đ</td>
                </tr>
                ";
            }

            $vatBreakdownHtml .= "
                <tr>
                    <td colspan='4' style='border-top: 1px dashed #ccc; padding: 0;'></td>
                </tr>
                <tr>
                    <td colspan='3' style='padding: 15px 10px 5px; text-align: right;'>Tiền trước thuế:</td>
                    <td style='padding: 15px 10px 5px; text-align: right;'>" . number_format($tien_truoc_thue, 0, ',', '.') . "đ</td>
                </tr>
                <tr>
                    <td colspan='3' style='padding: 5px 10px 15px; text-align: right;'>Thuế GTGT (8%):</td>
                    <td style='padding: 5px 10px 15px; text-align: right;'>" . number_format($tien_thue, 0, ',', '.') . "đ</td>
                </tr>
                <tr>
                    <td colspan='4' style='border-top: 1px dashed #ccc; padding: 0;'></td>
                </tr>
            ";

            // Nắp ráp toàn bộ khung Email
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                    <div style='background-color: #2e5932; color: #fff; padding: 25px; text-align: center;'>
                        <h2 style='margin: 0; font-size: 24px;'>Cảm ơn bạn đã đặt hàng!</h2>
                    </div>
                    <div style='padding: 30px; color: #444; line-height: 1.6;'>
                        <p style='font-size: 16px;'>Xin chào <strong>{$user['ho_ten']}</strong>,</p>
                        <p style='font-size: 15px;'>COZY CORNER đã nhận được đơn hàng <strong>#ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . "</strong> của bạn và đang tiến hành xử lý.</p>
                        
                        {$companyInvoiceHtml}

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
                                {$vatBreakdownHtml}
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
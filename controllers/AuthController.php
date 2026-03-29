<?php
// controllers/AuthController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/AdminModel.php';


require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $remember = isset($_POST['remember']);
            $redirect = $_POST['redirect'] ?? BASE_URL;

            if (empty($email) || empty($password)) {
                $_SESSION['error_message'] = 'Vui lòng nhập đầy đủ thông tin!';
                header("Location: " . BASE_URL . "view/user/DangNhap.php?redirect=" . urlencode($redirect));
                exit;
            }

            // . Kiểm tra bảng admins trước 
            // Cho phép Admin đăng nhập bằng email hoặc tên đăng nhập (username)
            $adminModel = new AdminModel();
            $admin = $adminModel->getAdminByEmailOrUsername($email);

            if ($admin) {

                // Kiểm tra nếu tài khoản bị khóa
                if ($admin['trang_thai'] === 'Khoa') {
                    $_SESSION['error_message'] = 'Tài khoản của bạn đã bị khóa!';
                    header("Location: " . BASE_URL . "view/user/DangNhap.php");
                    exit;
                }

                $dbPassword = trim($admin['password']); 

               
                if (password_verify($password, $dbPassword) || $password === $dbPassword) {

                   
                    if ($password === $dbPassword) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $adminModel->updateAdminPassword($admin['id'], $newHash);
                    }

                    // Đăng nhập Admin thành công
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['ho_ten'];
                    $_SESSION['admin_avatar'] = $admin['avatar'] ?? null;
                    $_SESSION['admin_role'] = $admin['vai_tro'];

                    header("Location: " . BASE_URL . "admin");
                    exit;
                }
            }

            // 2. Nếu không phải Admin thì kiểm tra xem có phải Khách hàng (User) không
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);
            
            if ($user) {
                if (password_verify($password, $user['mat_khau'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['ho_ten'];

                    // Cập nhật giỏ hàng tạm
                    $cartPath = __DIR__ . '/../models/CartModel.php';
                    if (file_exists($cartPath)) {
                        require_once $cartPath;
                        if (class_exists('CartModel')) {
                            $cartModel = new CartModel();
                            $cartModel->mergeCart(session_id(), $user['id']);
                        }
                    }

                    if ($remember) {
                        setcookie('remember_email', $email, time() + 30 * 24 * 3600, '/', '', false, true);
                        setcookie('remember_password', $password, time() + 30 * 24 * 3600, '/', '', false, true);
                    } else {
                        setcookie('remember_email', '', time() - 3600, '/', '', false, true);
                        setcookie('remember_password', '', time() - 3600, '/', '', false, true);
                    }

                    header("Location: $redirect");
                    exit;
                }
            }

            // Sai tài khoản hoặc mật khẩu (chung cho cả admin và user)
            $_SESSION['error_message'] = 'Tài khoản hoặc mật khẩu không chính xác!';
            header("Location: " . BASE_URL . "view/user/DangNhap.php?redirect=" . urlencode($redirect));
            exit;
        } else {
            header("Location: " . BASE_URL . "view/user/DangNhap.php");
            exit;
        }
    }

    // ---  PHƯƠNG THỨC CHO QUÊN MẬT KHẨU  ---

    public function forgotPassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');

            if (empty($so_dien_thoai)) {
                $error = 'Vui lòng nhập số điện thoại!';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $so_dien_thoai)) {
                $error = 'Số điện thoại không hợp lệ!';
            } else {
                $userModel = new UserModel();
                $user = $userModel->getUserByPhone($so_dien_thoai);
                if ($user) {
                    $email = $user['email'];

                    $otp = rand(100000, 999999);

                    $_SESSION['reset_email'] = $email;
                    $_SESSION['reset_otp'] = $otp;
                    $_SESSION['otp_expire'] = time() + 300;

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
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = "Mã OTP quên mật khẩu - COZY CORNER";
                        $mail->Body    = "Xin chào,<br><br>Mã OTP của bạn là: <strong style='font-size: 20px; color: #355F2E;'>$otp</strong><br>Mã có hiệu lực trong 5 phút.<br>Nếu không phải bạn, vui lòng bỏ qua email này.";
                        
                        $mail->send();
                        
                        // Chỉ chuyển hướng sang trang nhập OTP khi gửi email THÀNH CÔNG
                        header("Location: " . BASE_URL . "index.php?url=auth/verifyOtp");
                        exit;
                    } catch (Exception $e) {
                        // Hiển thị lỗi chi tiết từ Google 
                        $error = 'Lỗi SMTP: ' . $mail->ErrorInfo;
                        unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_expire']);
                    }
                } else {
                    $error = 'Số điện thoại không tồn tại trong hệ thống!';
                }
            }
        }
        // Gọi View hiển thị
        require_once __DIR__ . '/../view/user/NhapSdt.php';
    }

    public function verifyOtp()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
            header("Location: " . BASE_URL . "index.php?url=auth/forgotPassword");
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp_input = trim($_POST['otp'] ?? '');

            if (empty($otp_input)) {
                $error = 'Vui lòng nhập mã OTP!';
            } elseif (!preg_match('/^[0-9]{6}$/', $otp_input)) {
                $error = 'Mã OTP phải là 6 chữ số!';
            } elseif ($otp_input != $_SESSION['reset_otp']) {
                $error = 'Mã OTP không đúng!';
            } elseif (time() > $_SESSION['otp_expire']) {
                $error = 'Mã OTP đã hết hạn!';
                unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_expire']);
            } else {
                header("Location: " . BASE_URL . "index.php?url=auth/resetPassword");
                exit;
            }
        }
        // Gọi View hiển thị
        require_once __DIR__ . '/../view/user/NhapOtp.php';
    }

    public function resetPassword()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
            header("Location: " . BASE_URL . "index.php?url=auth/verifyOtp");
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mat_khau_moi = trim($_POST['mat_khau_moi'] ?? '');
            $xac_nhan_mk = trim($_POST['xac_nhan_mk'] ?? '');

            if (empty($mat_khau_moi) || empty($xac_nhan_mk)) {
                $error = 'Vui lòng nhập đầy đủ thông tin!';
            } elseif (strlen($mat_khau_moi) < 6) {
                $error = 'Mật khẩu phải ít nhất 6 ký tự!';
            } elseif ($mat_khau_moi !== $xac_nhan_mk) {
                $error = 'Mật khẩu xác nhận không khớp!';
            } else {
                $userModel = new UserModel();
                $hashed_password = password_hash($mat_khau_moi, PASSWORD_DEFAULT);
                if ($userModel->updatePasswordByEmail($_SESSION['reset_email'], $hashed_password)) {
                    unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_expire'], $_SESSION['otp_delivery_error'], $_SESSION['otp_debug']);
                    header("Location: " . BASE_URL . "view/user/DoiMkThanhCong.php");
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra. Vui lòng thử lại!';
                }
            }
        }
        // Gọi View hiển thị
        require_once __DIR__ . '/../view/user/MatKhauMoi.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Hủy chỉ session của user, không ảnh hưởng admin
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);

        // Thiết lập flash message để hiển thị khi chuyển hướng
        $_SESSION['success_message'] = 'Bạn đã đăng xuất thành công.';

        // Redirect về trang trước đó (hoặc trang chủ nếu không có)
        $redirect = $_SERVER['HTTP_REFERER'] ?? BASE_URL;

        //  Nếu trang trước đó là trang cần đăng nhập, chuyển về trang chủ
        if (strpos($redirect, 'TaiKhoan.php') !== false || strpos($redirect, 'CapNhatTaiKhoan.php') !== false || strpos($redirect, 'ThanhToan.php') !== false) {
            $redirect = BASE_URL;
        }
        header('Location: ' . $redirect);
        exit;
    }
}
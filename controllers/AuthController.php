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

// Thêm dòng này để nạp thư viện Google đã cài bằng Composer
require_once __DIR__ . '/../vendor/autoload.php';

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
                header("Location: " . BASE_URL . "index.php?url=auth/showLogin&redirect=" . urlencode($redirect));
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
                    header("Location: " . BASE_URL . "index.php?url=auth/showLogin");
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

                            // Xóa lịch sử chat của guest sau khi đăng nhập
                            unset($_SESSION['guest_chat_history']);
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
            header("Location: " . BASE_URL . "index.php?url=auth/showLogin&redirect=" . urlencode($redirect));
            exit;
        } else {
            $this->showLogin();
        }
    }

    public function showLogin()
    {
        require_once __DIR__ . '/../view/user/DangNhap.php';
    }

    public function showRegister()
    {
        $formData = [
            'ho_ten' => '',
            'email' => '',
            'so_dien_thoai' => '',
            'gioi_tinh' => 'Nam',
            'ngay_sinh' => '',
        ];
        $errors = [];
        require_once __DIR__ . '/../view/user/DangKy.php';
    }

    public function register()
    {
        $formData = [
            'ho_ten' => trim($_POST['ho_ten'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? ''),
            'gioi_tinh' => $_POST['gioi_tinh'] ?? 'Nam',
            'ngay_sinh' => trim($_POST['ngay_sinh'] ?? ''),
        ];
        $password = trim($_POST['mat_khau'] ?? '');
        $confirmPassword = trim($_POST['confirm_mat_khau'] ?? '');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate
            if ($formData['ho_ten'] === '') {
                $errors[] = 'Vui lòng nhập họ tên.';
            }

            if ($formData['email'] === '' || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ.';
            }

            if ($password === '' || strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Mật khẩu xác nhận không khớp.';
            }

            if (empty($errors)) {
                $userModel = new UserModel();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $result = $userModel->registerUser(
                    $formData['ho_ten'],
                    $formData['email'],
                    $hashedPassword,
                    $formData['so_dien_thoai'],
                    $formData['gioi_tinh'],
                    $formData['ngay_sinh']
                );

                if ($result === 'email_exists') {
                    $errors[] = 'Email đã được sử dụng.';
                } elseif ($result) {
                    $_SESSION['success_message'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                    header('Location: ' . BASE_URL . 'index.php?url=auth/showLogin');
                    exit;
                } else {
                    $errors[] = 'Có lỗi xảy ra, vui lòng thử lại.';
                }
            }
        }

        // Nếu là GET request hoặc có lỗi validation, hiển thị lại form với dữ liệu đã nhập
        require_once __DIR__ . '/../view/user/DangKy.php';
    }













    // ---  PHƯƠNG THỨC CHO QUÊN MẬT KHẨU  ---

    public function forgotPassword()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
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
                        $mail->Subject = "Mã OTP quên mật khẩu - COZY CORNER";
                        $mail->Body = "Xin chào,<br><br>Mã OTP của bạn là: <strong style='font-size: 20px; color: #355F2E;'>$otp</strong><br>Mã có hiệu lực trong 5 phút.<br>Nếu không phải bạn, vui lòng bỏ qua email này.";

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
        if (session_status() === PHP_SESSION_NONE)
            session_start();
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
        if (session_status() === PHP_SESSION_NONE)
            session_start();
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
                    unset($_SESSION['reset_email'], $_SESSION['reset_otp'], $_SESSION['otp_expire']);
                    $_SESSION['success_message'] = 'Mật khẩu của bạn đã được cập nhật thành công. Vui lòng đăng nhập lại.';
                    header("Location: " . BASE_URL . "index.php?url=auth/showLogin");
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
        if (strpos($redirect, 'url=user/account') !== false || strpos($redirect, 'url=user/update') !== false || strpos($redirect, 'url=order/checkout') !== false) {
            $redirect = BASE_URL;
        }
        header('Location: ' . $redirect);
        exit;
    }

    // --- PHƯƠNG THỨC CHO ĐĂNG NHẬP GOOGLE ---

    /**
     * Khởi tạo và cấu hình Google Client.
     * Tách ra thành một hàm riêng để giữ code sạch sẽ.
     * @return \Google\Client
     */
    private function getGoogleClient()
    {
        $client = new \Google\Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");
        return $client;
    }

    /**
     * Tạo URL xác thực của Google và chuyển hướng người dùng đến đó.
     * URL này sẽ được gắn vào nút "Đăng nhập bằng Google".
     */
    public function googleLogin()
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit;
    }

    /**
     * Xử lý callback từ Google sau khi người dùng xác thực.
     */
    public function googleCallback()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Trường hợp người dùng hủy hoặc có lỗi
        if (isset($_GET['error'])) {
            $_SESSION['error_message'] = 'Đăng nhập Google bị hủy hoặc có lỗi xảy ra.';
            header("Location: " . BASE_URL . "index.php?url=auth/showLogin");
            exit;
        }

        // Trường hợp có mã 'code' trả về
        if (isset($_GET['code'])) {
            $client = $this->getGoogleClient();
            try {
                // 1. Dùng 'code' để lấy access token
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                if (isset($token['error'])) {
                    throw new Exception($token['error_description']);
                }
                $client->setAccessToken($token['access_token']);

                // 2. Dùng access token để lấy thông tin người dùng
                $google_oauth = new \Google\Service\Oauth2($client);
                $google_account_info = $google_oauth->userinfo->get();

                $email = $google_account_info->email;
                $name = $google_account_info->name;
                $google_id = $google_account_info->id;
                $avatar = $google_account_info->picture;

                // --- START: SỬA LỖI ADMIN ---
                // 3a. Kiểm tra xem email có phải của admin không
                $adminModel = new AdminModel();
                $admin = $adminModel->getAdminByEmailOrUsername($email);

                if ($admin) {
                    // Nếu là admin, đăng nhập với quyền admin
                    if ($admin['trang_thai'] === 'Khoa') {
                        throw new Exception("Tài khoản quản trị của bạn đã bị khóa.");
                    }
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['ho_ten'];
                    $_SESSION['admin_avatar'] = $admin['avatar'] ?? null;
                    $_SESSION['admin_role'] = $admin['vai_tro'];
                    header("Location: " . BASE_URL . "admin");
                    exit;
                }
                // --- END: SỬA LỖI ADMIN ---

                $userModel = new UserModel();
                $user_by_email = $userModel->getUserByEmail($email);

                // 3b. Xử lý logic đăng nhập hoặc đăng ký cho người dùng thường
                if (!$user_by_email) {
                    // Nếu email chưa tồn tại -> Tạo tài khoản mới
                    $user_id = $userModel->registerGoogleUser($name, $email, $google_id, $avatar);
                    if (!$user_id) throw new Exception("Không thể tạo tài khoản mới từ thông tin Google.");
                    $user = $userModel->getUserById($user_id); // Lấy lại thông tin user vừa tạo
                } else {
                    // Nếu email đã tồn tại, lấy đầy đủ thông tin user
                    $user = $userModel->getUserById($user_by_email['id']);
                    if (empty($user['google_id'])) {
                        // Nếu chưa có google_id -> Cập nhật để liên kết tài khoản
                        $userModel->updateGoogleId($user['id'], $google_id);
                    }
                }

                // 4. Thiết lập session đăng nhập
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['ho_ten'];

                $_SESSION['success_message'] = 'Đăng nhập bằng Google thành công!';
                header("Location: " . BASE_URL);
                exit;

            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Lỗi xác thực Google: ' . $e->getMessage();
                header("Location: " . BASE_URL . "index.php?url=auth/showLogin");
                exit;
            }
        }

        // Nếu không có 'code' hoặc 'error', chuyển hướng về trang đăng nhập
        header("Location: " . BASE_URL . "index.php?url=auth/showLogin");
        exit;
    }
}
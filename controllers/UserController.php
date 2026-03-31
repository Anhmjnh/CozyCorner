<?php
// controllers/UserController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/VoucherModel.php';

class UserController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Chặn truy cập nếu chưa đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?url=auth/showLogin&redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
    }

    public function account() {
        $userId = $_SESSION['user_id'];
        $userModel = new UserModel();
        $userModel->updateUserRank($userId);
        
        $tab = $_GET['tab'] ?? 'profile';
        
        $user = $userModel->getUserById($userId);
        
        $orders = [];
        $totalCompletedSpent = 0;
        $activeVouchers = [];
        
        if ($tab === 'orders') {
            $orderModel = new OrderModel();
            $orders = $orderModel->getOrdersByUserId($userId);
            foreach ($orders as $o) {
                if ($o['trang_thai'] === 'HoanThanh' || ($o['trang_thai'] === 'DangGiao' && ($o['phuong_thuc_thanh_toan'] ?? '') === 'ChuyenKhoan')) {
                    $totalCompletedSpent += $o['tong_tien'];
                }
            }
        } elseif ($tab === 'vouchers') {
            $voucherModel = new VoucherModel();
            $activeVouchers = $voucherModel->getActiveVouchers();
        }

        $page_css = ['assets/css/CapNhatTaiKhoan.css'];
        require_once __DIR__ . '/../view/user/TaiKhoan.php';
    }

    public function update() {
        $userId = $_SESSION['user_id'];
        $userModel = new UserModel();
        $user = $userModel->getUserById($userId);
        
        $formData = [
            'ho_ten' => $user['ho_ten'] ?? '',
            'email' => $user['email'] ?? '',
            'so_dien_thoai' => $user['so_dien_thoai'] ?? '',
            'dia_chi' => $user['dia_chi'] ?? '',
            'gioi_tinh' => $user['gioi_tinh'] ?? 'Nam',
            'ngay_sinh' => $user['ngay_sinh'] ?? '',
            'avatar' => $user['avatar'] ?? '',
        ];

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData['ho_ten'] = trim($_POST['ho_ten'] ?? '');
            $formData['so_dien_thoai'] = trim($_POST['so_dien_thoai'] ?? '');
            $formData['dia_chi'] = trim($_POST['dia_chi'] ?? '');
            $formData['gioi_tinh'] = $_POST['gioi_tinh'] ?? 'Nam';
            $formData['ngay_sinh'] = trim($_POST['ngay_sinh'] ?? '');
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');

            if ($formData['ho_ten'] === '') $errors[] = 'Vui lòng nhập họ tên.';
            if ($formData['so_dien_thoai'] !== '' && !preg_match('/^[0-9+\- ]{7,20}$/', $formData['so_dien_thoai'])) $errors[] = 'Số điện thoại không hợp lệ.';

            $hashedPassword = null;
            $changePassword = $currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '';
            if ($changePassword) {
                if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') $errors[] = 'Để thay đổi mật khẩu, vui lòng điền đầy đủ các trường liên quan.';
                elseif ($newPassword !== $confirmPassword) $errors[] = 'Mật khẩu mới và xác nhận không khớp.';
                elseif (strlen($newPassword) < 6) $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
                else {
                    if (!password_verify($currentPassword, $user['mat_khau'])) $errors[] = 'Mật khẩu hiện tại không chính xác.';
                    else $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                }
            }

            $avatarPath = null;
            if (empty($errors) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $targetFile = __DIR__ . '/../uploads/' . time() . '_' . basename($_FILES['avatar']['name']);
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) $avatarPath = 'uploads/' . basename($targetFile);
                else $errors[] = 'Upload avatar thất bại.';
            }

            if (empty($errors)) {
                if ($userModel->updateUserProfile($userId, $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $avatarPath, $hashedPassword)) {
                    $_SESSION['user_name'] = $formData['ho_ten'];
                    header('Location: ' . BASE_URL . 'index.php?url=user/account');
                    exit;
                } else $errors[] = 'Cập nhật thất bại, vui lòng thử lại.';
            }
        }

        $page_css = ['assets/css/CapNhatTaiKhoan.css'];
        require_once __DIR__ . '/../view/user/CapNhatTaiKhoan.php';
    }
}
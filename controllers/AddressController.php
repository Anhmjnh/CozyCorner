<?php
// controllers/AddressController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/Address.php';

class AddressController
{
    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $ten_nguoi_nhan = trim($_POST['ten_nguoi_nhan'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $is_default = isset($_POST['is_default']) ? 1 : 0;

            if (empty($ten_nguoi_nhan) || empty($so_dien_thoai) || empty($dia_chi)) {
                $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin (Tên, SĐT, Địa chỉ).';
                header('Location: ' . BASE_URL . 'view/user/ThemDiaChi.php');
                exit;
            }

            if (!preg_match('/^[0-9]{10}$/', $so_dien_thoai)) {
                $_SESSION['error_message'] = 'Số điện thoại không hợp lệ.';
                header('Location: ' . BASE_URL . 'view/user/ThemDiaChi.php');
                exit;
            }

            if (Address::add($userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default)) {
                $_SESSION['success_message'] = 'Đã thêm địa chỉ thành công!';
                header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php?tab=addresses');
            } else {
                $_SESSION['error_message'] = 'Có lỗi hệ thống xảy ra, vui lòng thử lại!';
                header('Location: ' . BASE_URL . 'view/user/ThemDiaChi.php');
            }
            exit;
        }
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $id = isset($_POST['id']) ? intval($_POST['id']) : -1;
            $ten_nguoi_nhan = trim($_POST['ten_nguoi_nhan'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $is_default = isset($_POST['is_default']) ? 1 : 0;

            if (empty($ten_nguoi_nhan) || empty($so_dien_thoai) || empty($dia_chi) || $id < 0) {
                $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin!';
                header('Location: ' . BASE_URL . 'view/user/SuaDiaChi.php?id=' . $id);
                exit;
            }

            if (!preg_match('/^[0-9]{10}$/', $so_dien_thoai)) {
                $_SESSION['error_message'] = 'Số điện thoại không hợp lệ (Phải là 10 chữ số).';
                header('Location: ' . BASE_URL . 'view/user/SuaDiaChi.php?id=' . $id);
                exit;
            }

            if ($id == 0) {
                // Cập nhật vào hồ sơ gốc
                $success = Address::updateProfileAddress($userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi);
                if ($success)
                    $_SESSION['user_name'] = $ten_nguoi_nhan; // Update Tên trên header lập tức
            } else {
                // Cập nhật địa chỉ phụ
                $success = Address::update($id, $userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default);
            }

            if ($success) {
                $_SESSION['success_message'] = 'Cập nhật địa chỉ thành công!';
                header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php?tab=addresses');
            } else {
                $_SESSION['error_message'] = 'Có lỗi hệ thống xảy ra, vui lòng thử lại!';
                header('Location: ' . BASE_URL . 'view/user/SuaDiaChi.php?id=' . $id);
            }
            exit;
        }
    }

    public function delete()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $id = intval($_GET['id'] ?? 0);

        if ($id > 0) {
            if (Address::delete($id, $userId)) {
                $_SESSION['success_message'] = 'Đã xóa địa chỉ thành công!';
            } else {
                $_SESSION['error_message'] = 'Không thể xóa địa chỉ này!';
            }
        }
        header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php?tab=addresses');
        exit;
    }
}
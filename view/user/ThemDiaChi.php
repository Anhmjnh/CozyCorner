<?php
// view/user/ThemDiaChi.php
ob_start();
require_once __DIR__ . '/../../config.php';

// Chặn người dùng nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'view/user/DangNhap.php');
    exit;
}

$page_css = ['assets/css/CapNhatTaiKhoan.css'];
require_once __DIR__ . '/../../includes/header.php';

$userId = $_SESSION['user_id'];
?>

<!-- BREADCRUMB -->
<ul class="breadcrumb" style="max-width: 1200px; margin: 20px auto; padding: 0 20px; list-style: none; display: flex; gap: 10px; align-items: center; color: #555;">
    <li><a href="<?= BASE_URL ?>" style="color: #333; text-decoration: none;">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt=">" style="width: 12px; opacity: 0.5;"></li>
    <li><a href="<?= BASE_URL ?>view/user/TaiKhoan.php?tab=addresses" style="color: #333; text-decoration: none;">Địa chỉ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt=">" style="width: 12px; opacity: 0.5;"></li>
    <li style="color: #333; text-decoration: none;">Thêm địa chỉ mới</li>
</ul>

<!-- FORM THÊM ĐỊA CHỈ -->
<div class="update" style="max-width: 600px; margin: 0 auto 50px auto; background: #fff; padding: 35px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee;">
    <h2 style="color: #355F2E; margin-top: 0; margin-bottom: 25px; text-align: center;">Thêm Địa Chỉ Mới</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?url=address/add">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Tên Người Nhận *</label>
            <input type="text" name="ten_nguoi_nhan" style="width: 100%; padding: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Số Điện Thoại *</label>
            <input type="text" name="so_dien_thoai" style="width: 100%; padding: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" required>
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Địa Chỉ Giao Hàng *</label>
            <textarea name="dia_chi" rows="4" style="width: 100%; padding: 14px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; resize: vertical;" placeholder="Ví dụ: Số nhà, Đường, Phường/Xã, Quận/Huyện, Tỉnh/Thành phố..." required></textarea>
        </div>
        <div style="margin-bottom: 30px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #333; font-weight: 500;">
                <input type="checkbox" name="is_default" style="transform: scale(1.3); accent-color: #355F2E;"> Đặt làm địa chỉ mặc định
            </label>
        </div>
        
        <div style="display: flex; gap: 15px;">
            <a href="<?= BASE_URL ?>view/user/TaiKhoan.php?tab=addresses" style="flex: 1; padding: 14px; text-align: center; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #555; font-weight: bold; transition: 0.3s;">Hủy</a>
            <button type="submit" style="flex: 1; padding: 14px; background: #355F2E; color: #fff; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(53, 95, 46, 0.2);">Lưu Địa Chỉ</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
<?php
// views/user/DangKy.php
require_once __DIR__ . '/../../config.php';
$page_css = ['assets/css/DangKy.css'];
require_once __DIR__ . '/../../includes/header.php';
?>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/showRegister">Đăng ký</a></li>
</ul>

<!-- CONTENT -->
<div class="register">
    <form class="register__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/register">
        <h1 class="register__title">Đăng Ký Tài Khoản</h1>

        <?php if (!empty($errors)): ?>
            <div class="register__error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="register__group">
            <label for="ho_ten" class="register__label">Họ Tên *</label>
            <input type="text" id="ho_ten" name="ho_ten" class="register__input" placeholder="Nhập họ tên đầy đủ" value="<?= htmlspecialchars($formData['ho_ten']) ?>" required>
        </div>

        <div class="register__group">
            <label for="email" class="register__label">Email *</label>
            <input type="email" id="email" name="email" class="register__input" placeholder="Nhập email của bạn" value="<?= htmlspecialchars($formData['email']) ?>" required>
        </div>

        <div class="register__group">
            <label for="mat_khau" class="register__label">Mật Khẩu *</label>
            <div class="register__password-wrapper">
                <input type="password" id="mat_khau" name="mat_khau" class="register__input" placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
                <i class="fas fa-eye register__icon" id="toggle-password"></i>
            </div>
        </div>

        <div class="register__group">
            <label for="confirm_mat_khau" class="register__label">Xác Nhận Mật Khẩu *</label>
            <div class="register__password-wrapper">
                <input type="password" id="confirm_mat_khau" name="confirm_mat_khau" class="register__input" placeholder="Nhập lại mật khẩu" required>
                <i class="fas fa-eye register__icon" id="toggle-confirm-password"></i>
            </div>
        </div>

        <div class="register__group">
            <label for="so_dien_thoai" class="register__label">Số Điện Thoại</label>
            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="register__input" placeholder="Nhập số điện thoại (tùy chọn)" value="<?= htmlspecialchars($formData['so_dien_thoai']) ?>">
        </div>

        <div class="register__group">
            <label for="gioi_tinh" class="register__label">Giới Tính</label>
            <select id="gioi_tinh" name="gioi_tinh" class="register__input">
                <option value="Nam" <?= ($formData['gioi_tinh']) === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= ($formData['gioi_tinh']) === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="register__group">
            <label for="ngay_sinh" class="register__label">Ngày Sinh</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" class="register__input" value="<?= htmlspecialchars($formData['ngay_sinh']) ?>">
        </div>

        <button type="submit" class="register__button">Đăng Ký</button>

        <p class="register__footer">
            Đã có tài khoản? <a href="<?= BASE_URL ?>index.php?url=auth/showLogin" class="register__link">Đăng nhập ngay</a>
        </p>
    </form>
</div>

<script>
// Toggle hiển thị mật khẩu
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('toggle-password').addEventListener('click', function() {
    togglePassword('mat_khau', 'toggle-password');
});

document.getElementById('toggle-confirm-password').addEventListener('click', function() {
    togglePassword('confirm_mat_khau', 'toggle-confirm-password');
});
</script>
<script src="<?= BASE_URL ?>assets/js/register.js"></script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

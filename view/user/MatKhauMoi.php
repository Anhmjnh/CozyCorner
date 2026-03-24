<?php
// views/user/MatKhauMoi.php
ob_start();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Mật Khẩu Mới - COZY CORNER</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <!-- Font Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- CSS chính (chung cho toàn site) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/DangNhap.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>view/user/DangNhap.php">Đăng nhập</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/forgotPassword">Quên mật khẩu</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/verifyOtp">Nhập OTP</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/resetPassword">Mật khẩu mới</a></li>
</ul>

<!-- CONTENT -->
<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/resetPassword">
        <h1 class="login__title">Đặt Mật Khẩu Mới</h1>
        <p class="login__subtitle">Nhập mật khẩu mới cho tài khoản của bạn</p>

        <?php if (!empty($error)): ?>
            <div class="login__error" style="color: red; text-align: center; margin-bottom: 16px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="login__group">
            <label for="mat_khau_moi" class="login__label">Mật Khẩu Mới</label>
            <div class="login__password-wrapper">
                <input type="password" id="mat_khau_moi" name="mat_khau_moi" class="login__input" placeholder="Nhập mật khẩu mới" required>
                <i class="fas fa-eye login__icon" id="toggle-new-password"></i>
            </div>
        </div>

        <div class="login__group">
            <label for="xac_nhan_mk" class="login__label">Xác Nhận Mật Khẩu</label>
            <div class="login__password-wrapper">
                <input type="password" id="xac_nhan_mk" name="xac_nhan_mk" class="login__input" placeholder="Nhập lại mật khẩu" required>
                <i class="fas fa-eye login__icon" id="toggle-confirm-password"></i>
            </div>
        </div>

        <button type="submit" class="login__button">Đặt Mật Khẩu</button>

        <p class="login__footer">
            <a href="<?= BASE_URL ?>view/user/DangNhap.php" class="login__link">Quay lại đăng nhập</a>
        </p>
    </form>
</div>

<script>
// Toggle hiển thị mật khẩu mới
document.getElementById('toggle-new-password').addEventListener('click', function() {
    const input = document.getElementById('mat_khau_moi');
    const icon = this;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Toggle hiển thị xác nhận mật khẩu
document.getElementById('toggle-confirm-password').addEventListener('click', function() {
    const input = document.getElementById('xac_nhan_mk');
    const icon = this;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>

</body>
</html>

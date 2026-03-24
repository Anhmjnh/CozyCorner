<?php
// views/user/NhapOtp.php
ob_start();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Mã OTP - COZY CORNER</title>

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
</ul>

<!-- CONTENT -->
<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/verifyOtp">
        <h1 class="login__title">Nhập Mã OTP</h1>
        <p class="login__subtitle">Mã OTP đã được gửi đến email: <strong><?= htmlspecialchars($_SESSION['reset_email']) ?></strong></p>

        <?php if (!empty($error)): ?>
            <div class="login__error" style="color: red; text-align: center; margin-bottom: 16px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="login__group">
            <label for="otp" class="login__label">Mã OTP</label>
            <input type="text" id="otp" name="otp" class="login__input" placeholder="Nhập 6 chữ số OTP" maxlength="6" required>
        </div>

        <button type="submit" class="login__button">Xác Nhận</button>

        <p class="login__footer">
            <a href="<?= BASE_URL ?>index.php?url=auth/forgotPassword" class="login__link">Quay lại nhập số điện thoại</a>
        </p>
    </form>
</div>

<script>
// Tự động focus vào input OTP
document.getElementById('otp').focus();
</script>

</body>
</html>

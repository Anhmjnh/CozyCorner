<?php
// view/user/XacThucOTP.php
ob_start();
require_once __DIR__ . '/../../includes/header.php';
// require_once __DIR__ . '/../../config.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực Tài Khoản - COZY CORNER</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/DangNhap.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/showRegister">Đăng ký</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/verifyRegistration">Xác thực tài khoản</a></li>
</ul>

<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/verifyRegistration">
        <h1 class="login__title">Xác Thực Tài Khoản</h1>
        <p class="login__desc" style="margin-bottom: 32px;">
            Một mã OTP gồm 6 chữ số đã được gửi đến email <strong><?= htmlspecialchars($_SESSION['registration_data']['email'] ?? '') ?></strong>. Vui lòng nhập mã vào ô bên dưới để hoàn tất đăng ký.
        </p>

        <?php if (!empty($error)): ?>
            <div class="login__error" style="color: red; text-align: center; margin-bottom: 16px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="login__group">
            <label for="otp" class="login__label">Mã OTP</label>
            <input type="text" id="otp" name="otp" class="login__input" placeholder="Nhập 6 chữ số OTP" maxlength="6" pattern="\d{6}" title="Vui lòng nhập 6 chữ số" required>
        </div>

        <button type="submit" class="login__button">Xác Nhận</button>

        <div class="login__resend" style="margin-bottom: 16px;">
            <span style="color: #9E9E9E;">Không nhận được mã?</span>
            <a href="<?= BASE_URL ?>index.php?url=auth/resendOtp" class="login__link">Gửi lại mã</a>
        </div>

        <p class="login__footer">
            <a href="<?= BASE_URL ?>index.php?url=auth/showLogin" class="login__link">Quay lại Đăng nhập</a>
        </p>
    </form>
</div>

<script>
// Tự động focus vào input OTP
document.getElementById('otp').focus();
</script>

</body>
</html>
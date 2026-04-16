<?php
// views/order/XacThucThanhToan.php 
ob_start();
require_once __DIR__ . '/../../includes/header.php';
// require_once __DIR__ . '/../../config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Thực Đơn Hàng - COZY CORNER</title>

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
    <li><a href="<?= BASE_URL ?>index.php?url=cart">Giỏ hàng</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="#">Thanh toán</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="#">Xác thực đơn hàng</a></li>
</ul>

<div class="login">
    <form class="login__form" action="<?= BASE_URL ?>index.php?url=order/verifyGuestOrder" method="POST">
        <h1 class="login__title">Xác Thực Đơn Hàng</h1>
        
        <p class="login__desc" style="margin-bottom: 32px;">
            Một mã OTP đã được gửi đến email <strong><?= htmlspecialchars($data['email'] ?? '') ?></strong>.<br>
            Vui lòng nhập mã để hoàn tất. Mã có hiệu lực trong 5 phút.
        </p>

        <?php if (isset($_SESSION['otp_error_message'])) : ?>
            <div class="login__error" style="color: red; text-align: center; margin-bottom: 16px;">
                <?= htmlspecialchars($_SESSION['otp_error_message']); ?>
            </div>
            <?php unset($_SESSION['otp_error_message']); ?>
        <?php endif; ?>

        <div class="login__group">
            <label for="otp" class="login__label">Mã OTP</label>
            <input type="text" id="otp" name="otp" class="login__input" placeholder="Nhập 6 chữ số OTP" maxlength="6" pattern="\d{6}" title="Mã OTP gồm 6 chữ số" required>
        </div>

        <button type="submit" class="login__button" style="margin-bottom: 0;">Xác Nhận & Đặt Hàng</button>
    </form>
</div>

<script>
// Tự động focus vào input OTP để tăng trải nghiệm người dùng
document.getElementById('otp').focus();
</script>

</body>
</html>
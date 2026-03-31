<?php
// views/user/NhapSdt.php
ob_start();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu - COZY CORNER</title>

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
    <li><a href="<?= BASE_URL ?>index.php?url=auth/showLogin">Đăng nhập</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/forgotPassword">Quên mật khẩu</a></li>
</ul>

<!-- CONTENT -->
<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/forgotPassword">
        <h1 class="login__title">Quên Mật Khẩu</h1>
        <p class="login__subtitle">Nhập số điện thoại đã đăng ký để nhận mã OTP</p>

        <?php if (!empty($error)): ?>
            <div class="login__error" style="color: red; text-align: center; margin-bottom: 16px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="login__group">
            <label for="so_dien_thoai" class="login__label">Số Điện Thoại</label>
            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="login__input" placeholder="Nhập số điện thoại" required>
        </div>

        <button type="submit" class="login__button">Gửi Mã OTP</button>

        <p class="login__footer">
            <a href="<?= BASE_URL ?>index.php?url=auth/showLogin" class="login__link">Quay lại đăng nhập</a>
        </p>
    </form>
</div>

</body>
</html>

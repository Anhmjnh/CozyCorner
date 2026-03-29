<?php
// views/user/CapNhatTaiKhoan.php

if (!isset($formData)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=user/update");
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Tài Khoản - COZY CORNER</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/CapNhatTaiKhoan.css">
</head>
<body>

<?php showSessionMessage(); ?>

<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=user/account">Cập nhật tài khoản</a></li>
</ul>

<div class="update">
    <form class="update__form" method="POST" action="" enctype="multipart/form-data">
        <h1 class="update__title">Cập Nhật Tài Khoản</h1>

        <?php if (!empty($errors)): ?>
            <div class="update__error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <div class="update__group">
            <label for="ho_ten" class="update__label">Họ Tên</label>
            <input type="text" id="ho_ten" name="ho_ten" class="update__input" value="<?= htmlspecialchars($formData['ho_ten']) ?>" required>
        </div>

        <div class="update__group">
            <label for="email" class="update__label">Email</label>
            <input type="email" id="email" name="email" class="update__input" value="<?= htmlspecialchars($formData['email']) ?>" readonly>
        </div>

        <div class="update__group">
            <label for="so_dien_thoai" class="update__label">Số điện thoại</label>
            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="update__input" value="<?= htmlspecialchars($formData['so_dien_thoai']) ?>">
        </div>

        <div class="update__group">
            <label for="dia_chi" class="update__label">Địa chỉ</label>
            <input type="text" id="dia_chi" name="dia_chi" class="update__input" value="<?= htmlspecialchars($formData['dia_chi']) ?>">
        </div>

        <div class="update__group">
            <label for="gioi_tinh" class="update__label">Giới tính</label>
            <select id="gioi_tinh" name="gioi_tinh" class="update__input">
                <option value="Nam" <?= $formData['gioi_tinh'] === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= $formData['gioi_tinh'] === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="update__group">
            <label for="ngay_sinh" class="update__label">Ngày sinh</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" class="update__input" value="<?= htmlspecialchars($formData['ngay_sinh']) ?>">
        </div>

        <div class="update__group">
            <label for="avatar" class="update__label">Avatar</label>
            <input type="file" id="avatar" name="avatar" class="update__input" accept="image/*">
            <?php if ($formData['avatar']): ?>
                <img src="<?= BASE_URL . $formData['avatar'] ?>" alt="Avatar hiện tại" style="max-width: 100px; margin-top: 10px;">
            <?php endif; ?>
        </div>

        <div class="update__divider">Đổi mật khẩu (tùy chọn)</div>

        <div class="update__group">
            <label for="current_password" class="update__label">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="update__input" placeholder="Nhập mật khẩu hiện tại">
        </div>

        <div class="update__group">
            <label for="new_password" class="update__label">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" class="update__input" placeholder="Nhập mật khẩu mới">
        </div>

        <div class="update__group">
            <label for="confirm_password" class="update__label">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" class="update__input" placeholder="Nhập lại mật khẩu mới">
        </div>

        <button type="submit" class="update__button">Cập nhật</button>
    </form>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

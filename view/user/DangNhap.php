<?php
// views/user/DangNhap.php
ob_start();
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';

$redirect = $_GET['redirect'] ?? BASE_URL;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - COZY CORNER</title>

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
</ul>

<!-- CONTENT -->
<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>?url=auth/login">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <h1 class="login__title">Đăng Nhập</h1>


        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="login__success" style="color: green; text-align: center; margin-bottom: 16px;">
                Đăng ký thành công! Vui lòng đăng nhập.
            </div>
        <?php endif; ?>

        <div class="login__group">
            <label for="email" class="login__label">Email / Tên đăng nhập</label>
            <input type="text" id="email" name="email" class="login__input" placeholder="Nhập email hoặc tên đăng nhập " value="<?php echo htmlspecialchars($_COOKIE['remember_email'] ?? ''); ?>" required>
        </div>

        <div class="login__group">
            <label for="password" class="login__label">Mật Khẩu</label>
            <div class="login__password-wrapper">
                <input type="password" id="password" name="password" class="login__input" placeholder="Nhập mật khẩu" value="<?php echo htmlspecialchars($_COOKIE['remember_password'] ?? ''); ?>" required>
                <i class="fas fa-eye login__icon" id="toggle-password"></i>
            </div>
        </div>

        <div class="login__options">
            <label class="login__checkbox">
                <input type="checkbox" name="remember" id="remember">
                Ghi nhớ đăng nhập
            </label>
            <a href="<?= BASE_URL ?>index.php?url=auth/forgotPassword" class="login__link">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="login__button">Đăng Nhập</button>

        <p class="login__footer">
            Chưa có tài khoản? <a href="<?= BASE_URL ?>view/user/DangKy.php" class="login__link">Đăng ký ngay</a>
        </p>
    </form>
</div>

<script>
// Toggle hiển thị mật khẩu
document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this;
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>

<?php
// views/user/DangNhap.php
ob_start();
require_once __DIR__ . '/../../config.php';

$redirect = $_GET['redirect'] ?? BASE_URL;

// Thêm CSS của trang đăng nhập vào mảng page_css để load vào header chung
$page_css = ['assets/css/DangNhap.css'];
require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    .login__divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #999;
        margin: 24px 0;
    }

    .login__divider::before,
    .login__divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #eee;
    }

    .login__divider-text {
        padding: 0 1em;
        font-size: 13px;
        font-weight: 600;
    }

    .login__button--social {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        background-color: #4285F4;
        color: white;
        border-color: #4285F4;
    }
</style>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=auth/showLogin">Đăng nhập</a></li>
</ul>

<!-- CONTENT -->
<div class="login">
    <form class="login__form" method="POST" action="<?= BASE_URL ?>index.php?url=auth/login">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <h1 class="login__title">Đăng Nhập</h1>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="login__error" style="color: #e74c3c; background: #fde8e8; padding: 12px; border-radius: 6px; text-align: center; margin-bottom: 16px; font-weight: 600;">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <div class="login__group">
            <label for="email" class="login__label">Email / Tên đăng nhập</label>
            <input type="text" id="email" name="email" class="login__input"
                   placeholder="Nhập email hoặc tên đăng nhập"
                   value="<?php echo htmlspecialchars($_COOKIE['remember_email'] ?? ''); ?>" required>
        </div>

        <div class="login__group">
            <label for="password" class="login__label">Mật Khẩu</label>
            <div class="login__password-wrapper">
                <input type="password" id="password" name="password" class="login__input"
                       placeholder="Nhập mật khẩu"
                       value="<?php echo htmlspecialchars($_COOKIE['remember_password'] ?? ''); ?>" required>
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

        <!-- LOGIN THƯỜNG -->
        <button type="submit" class="login__button">Đăng Nhập</button>

        <!-- DIVIDER -->
        <div class="login__divider">
            <span class="login__divider-text">HOẶC</span>
        </div>

        <!-- LOGIN GOOGLE -->
        <a href="<?= BASE_URL ?>index.php?url=auth/googleLogin" class="login__button login__button--social">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" style="width: 18px; margin-right: 10px;">
            Đăng Nhập Bằng Google
        </a>

        <p class="login__footer">
            Chưa có tài khoản?
            <a href="<?= BASE_URL ?>index.php?url=auth/showRegister" class="login__link">Đăng ký ngay</a>
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
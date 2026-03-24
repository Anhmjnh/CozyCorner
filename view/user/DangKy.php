<?php
// views/user/DangKy.php
require_once __DIR__ . '/../../config.php';

// Dữ liệu mặc định cho form
$formData = [
    'ho_ten' => '',
    'email' => '',
    'so_dien_thoai' => '',
    'gioi_tinh' => 'Nam',
    'ngay_sinh' => '',
];

$errors = [];

// Xử lý đăng ký (nếu có POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['ho_ten'] = trim($_POST['ho_ten'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $password = trim($_POST['mat_khau'] ?? '');
    $confirmPassword = trim($_POST['confirm_mat_khau'] ?? '');
    $formData['so_dien_thoai'] = trim($_POST['so_dien_thoai'] ?? '');
    $formData['gioi_tinh'] = $_POST['gioi_tinh'] ?? 'Nam';
    $formData['ngay_sinh'] = trim($_POST['ngay_sinh'] ?? '');

    // Validate
    if ($formData['ho_ten'] === '') {
        $errors[] = 'Vui lòng nhập họ tên.';
    }

    if ($formData['email'] === '' || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    }

    if ($password === '' || strlen($password) < 6) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }

    if ($password !== $confirmPassword) {
        $errors[] = 'Mật khẩu xác nhận không khớp.';
    }

    if (empty($errors)) {
        $conn = connectDB();

        // Kiểm tra email tồn tại
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $formData['email']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = 'Email đã được sử dụng.';
        } else {
            // Thêm user mới
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (ho_ten, email, mat_khau, so_dien_thoai, gioi_tinh, ngay_sinh) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssss', $formData['ho_ten'], $formData['email'], $hashedPassword, $formData['so_dien_thoai'], $formData['gioi_tinh'], $formData['ngay_sinh']);

            if ($stmt->execute()) {
                header('Location: ' . BASE_URL . 'view/user/DangNhap.php?success=1');
                exit;
            }

            $errors[] = 'Có lỗi xảy ra, vui lòng thử lại.';
        }

        $stmt->close();
        $conn->close();
    }
}

require_once __DIR__ . '/../../includes/header.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký - COZY CORNER</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <!-- Font Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- CSS chính (chung cho toàn site) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/DangKy.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>view/user/DangKy.php">Đăng ký</a></li>
</ul>

<!-- CONTENT -->
<div class="register">
    <form class="register__form" method="POST" action="">
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
            <input type="text" id="ho_ten" name="ho_ten" class="register__input" placeholder="Nhập họ tên đầy đủ" value="<?= htmlspecialchars($_POST['ho_ten'] ?? '') ?>" required>
        </div>

        <div class="register__group">
            <label for="email" class="register__label">Email *</label>
            <input type="email" id="email" name="email" class="register__input" placeholder="Nhập email của bạn" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
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
            <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="register__input" placeholder="Nhập số điện thoại (tùy chọn)" value="<?= htmlspecialchars($_POST['so_dien_thoai'] ?? '') ?>">
        </div>

        <div class="register__group">
            <label for="gioi_tinh" class="register__label">Giới Tính</label>
            <select id="gioi_tinh" name="gioi_tinh" class="register__input">
                <option value="Nam" <?= ($_POST['gioi_tinh'] ?? '') === 'Nam' ? 'selected' : '' ?>>Nam</option>
                <option value="Nữ" <?= ($_POST['gioi_tinh'] ?? '') === 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            </select>
        </div>

        <div class="register__group">
            <label for="ngay_sinh" class="register__label">Ngày Sinh</label>
            <input type="date" id="ngay_sinh" name="ngay_sinh" class="register__input" value="<?= htmlspecialchars($_POST['ngay_sinh'] ?? '') ?>">
        </div>

        <button type="submit" class="register__button">Đăng Ký</button>

        <p class="register__footer">
            Đã có tài khoản? <a href="<?= BASE_URL ?>view/user/DangNhap.php" class="register__link">Đăng nhập ngay</a>
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

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>

<?php
// views/user/CapNhatTaiKhoan.php
ob_start();

// Trang này cần CSS riêng (CapNhatTaiKhoan)
$page_css = ['assets/css/CapNhatTaiKhoan.css'];

require_once __DIR__ . '/../../includes/header.php';

// Chặn truy cập nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'view/user/DangNhap.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// showSessionMessage() đã được header.php gọi sẵn

$userId = $_SESSION['user_id'];

// Lấy dữ liệu user hiện tại
$conn = connectDB();
$stmt = $conn->prepare("SELECT ho_ten, email, so_dien_thoai, dia_chi, gioi_tinh, ngay_sinh, avatar FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$formData = [
    'ho_ten' => $user['ho_ten'] ?? '',
    'email' => $user['email'] ?? '',
    'so_dien_thoai' => $user['so_dien_thoai'] ?? '',
    'dia_chi' => $user['dia_chi'] ?? '',
    'gioi_tinh' => $user['gioi_tinh'] ?? 'Nam',
    'ngay_sinh' => $user['ngay_sinh'] ?? '',
    'avatar' => $user['avatar'] ?? '',
];

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['ho_ten'] = trim($_POST['ho_ten'] ?? '');
    $formData['so_dien_thoai'] = trim($_POST['so_dien_thoai'] ?? '');
    $formData['dia_chi'] = trim($_POST['dia_chi'] ?? '');
    $formData['gioi_tinh'] = $_POST['gioi_tinh'] ?? 'Nam';
    $formData['ngay_sinh'] = trim($_POST['ngay_sinh'] ?? '');
    $currentPassword = trim($_POST['current_password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if ($formData['ho_ten'] === '') {
        $errors[] = 'Vui lòng nhập họ tên.';
    }

    if ($formData['so_dien_thoai'] !== '' && !preg_match('/^[0-9+\- ]{7,20}$/', $formData['so_dien_thoai'])) {
        $errors[] = 'Số điện thoại không hợp lệ.';
    }

    // Nếu người dùng muốn đổi mật khẩu
    $changePassword = $currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '';
    if ($changePassword) {
        if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
            $errors[] = 'Để thay đổi mật khẩu, vui lòng điền đầy đủ các trường liên quan.';
        }

        if ($newPassword !== $confirmPassword) {
            $errors[] = 'Mật khẩu mới và xác nhận không khớp.';
        }

        if (strlen($newPassword) > 0 && strlen($newPassword) < 6) {
            $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT mat_khau FROM users WHERE id = ?");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            $dbUser = $res->fetch_assoc();
            $stmt->close();

            if (!$dbUser || !password_verify($currentPassword, $dbUser['mat_khau'])) {
                $errors[] = 'Mật khẩu hiện tại không chính xác.';
            }
        }
    }

    if (empty($errors)) {
        // Cập nhật user
        if ($changePassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ?, mat_khau = ? WHERE id = ?");
            $stmt->bind_param('ssssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $hashedPassword, $userId);
        } else {
            $stmt = $conn->prepare("UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ? WHERE id = ?");
            $stmt->bind_param('sssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $userId);
        }

        // Handle avatar upload (nếu có)
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetFile = $uploadDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES['avatar']['tmp_name']);
            if ($check !== false && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
                    $avatarPath = 'uploads/' . $fileName;
                    $formData['avatar'] = $avatarPath;
                } else {
                    $errors[] = 'Upload avatar thất bại.';
                }
            } else {
                $errors[] = 'File không phải là hình ảnh hợp lệ.';
            }
        }

        if (empty($errors)) {
            // Cập nhật user
            if ($changePassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ?, mat_khau = ?" . (empty($formData['avatar']) ? '' : ', avatar = ?') . " WHERE id = ?");
                if (empty($formData['avatar'])) {
                    $stmt->bind_param('ssssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $hashedPassword, $userId);
                } else {
                    $stmt->bind_param('sssssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $hashedPassword, $formData['avatar'], $userId);
                }
            } else {
                $stmt = $conn->prepare("UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ?" . (empty($formData['avatar']) ? '' : ', avatar = ?') . " WHERE id = ?");
                if (empty($formData['avatar'])) {
                    $stmt->bind_param('sssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $userId);
                } else {
                    $stmt->bind_param('ssssssi', $formData['ho_ten'], $formData['so_dien_thoai'], $formData['dia_chi'], $formData['gioi_tinh'], $formData['ngay_sinh'], $formData['avatar'], $userId);
                }
            }

            if ($stmt->execute()) {
                $_SESSION['user_name'] = $formData['ho_ten'];
                header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php');
                exit;
            } else {
                $errors[] = 'Cập nhật thất bại, vui lòng thử lại.';
            }

            $stmt->close();
        }
    }
}

$conn->close();
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
    <li><a href="<?= BASE_URL ?>view/user/CapNhatTaiKhoan.php">Cập nhật tài khoản</a></li>
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

<?php
// views/user/Logout.php
session_start();

// Thiết lập flash message để hiển thị khi chuyển hướng
$_SESSION['success_message'] = 'Bạn đã đăng xuất thành công.';

// Huỷ cookie ghi nhớ đăng nhập (theo yêu cầu mới, không xóa để vẫn hiện sẵn email/mk)
// setcookie('remember_email', '', time() - 3600, '/', '', false, true);
// setcookie('remember_password', '', time() - 3600, '/', '', false, true);

// Hủy session
session_unset();
session_destroy();

// Redirect về trang trước đó (hoặc trang chủ nếu không có)
$redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
header('Location: ' . $redirect);
exit;

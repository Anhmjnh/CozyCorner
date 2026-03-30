<?php require_once __DIR__ . '/../../config.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cozy Corner</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- CSS MỚI NHẤT -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css?v=<?= time() ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-wrapper">
    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="<?= BASE_URL ?>index.php?url=admin/index" style="text-decoration: none; color: inherit;">
                <h2>Cozy<span>Admin</span></h2>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'url=admin/index') !== false || $_SERVER['REQUEST_URI'] == '/cozycorner/admin/') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/index"><i class="fas fa-home"></i> <span>Trang chủ</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/products') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/products"><i class="fas fa-box"></i> <span>Sản phẩm</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/categories') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/categories"><i class="fas fa-list"></i> <span>Danh mục</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/orders') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/orders"><i class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/vouchers') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/vouchers"><i class="fas fa-ticket-alt"></i> <span>Quản lý Voucher</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/users') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/users"><i class="fas fa-users"></i> <span>Người dùng</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/staffs') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/staffs"><i class="fas fa-user-tie"></i> <span>Nhân sự</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/news') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/news"><i class="fas fa-newspaper"></i> <span>Tin tức</span></a></li>
            <li class="<?= strpos($_SERVER['REQUEST_URI'], 'url=admin/chatbot_faq') ? 'active' : '' ?>"><a href="<?= BASE_URL ?>index.php?url=admin/chatbot_faq"><i class="fas fa-robot"></i> <span>Chatbot</span></a></li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <!-- HEADER -->
        <header class="admin-header">
            <div class="header-left">
                <button id="toggleSidebar" class="toggle-btn"><i class="fas fa-bars"></i></button>
                <span class="page-title" style="margin-left: 15px; font-weight: bold; font-size: 18px;">Hệ Thống Quản Trị</span>
            </div>
            <div class="header-right">
                <div style="display: flex; align-items: center;">
                    <div class="admin-profile" id="openAdminProfileModal" title="Click để sửa thông tin cá nhân" style="cursor: pointer; display: flex; align-items: center; padding: 5px 10px; border-radius: 20px; transition: background 0.3s;" onmouseover="this.style.backgroundColor='#f1f1f1'" onmouseout="this.style.backgroundColor='transparent'">
                        <img id="adminAvatarImg" src="<?= isset($_SESSION['admin_avatar']) && $_SESSION['admin_avatar'] ? BASE_URL . 'uploads/' . $_SESSION['admin_avatar'] : BASE_URL . 'assets/icon/Icon-user.svg' ?>" alt="Avatar" style="background: #2c3e50; border-radius: 50%; object-fit: cover; width: 40px; height: 40px;">
                        <span id="adminNameTxt" style="margin-left: 8px; font-weight: 600; color: #2c3e50;"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
                    </div>
                    <a href="<?= BASE_URL ?>index.php?url=admin/logout" class="logout-btn" style="color: #e74c3c; margin-left: 15px; font-size: 1.2rem;" title="Đăng xuất"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </header>

        <style>
            #adminProfileModal,
            #adminProfileModal input,
            #adminProfileModal select,
            #adminProfileModal button {
                font-family: 'Open Sans', sans-serif;
            }
        </style>

        <!-- Modal Sửa Thông Tin Cá Nhân Admin -->
        <div id="adminProfileModal" class="modal" style="display: none;">
            <div class="modal-content" style="max-width: 500px; max-height: 90vh; overflow-y: auto;">
                <span class="close-modal" id="closeAdminProfileModal">&times;</span>
                <h2 style="margin-bottom: 20px;">Thông Tin Cá Nhân</h2>
                <form id="formAdminProfile" enctype="multipart/form-data">
                    <div style="text-align: center; margin-bottom: 15px;">
                        <img id="admin_profile_avatar_preview" src="<?= isset($_SESSION['admin_avatar']) && $_SESSION['admin_avatar'] ? BASE_URL . 'uploads/' . $_SESSION['admin_avatar'] : BASE_URL . 'assets/icon/Icon-user.svg' ?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; margin-bottom: 15px; display: inline-block;">
                        <input type="file" name="avatar" id="admin_profile_avatar" accept="image/*" style="width: 100%;">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Họ Tên (*)</label>
                        <input type="text" name="ho_ten" id="admin_profile_ho_ten" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Email (*)</label>
                        <input type="email" name="email" id="admin_profile_email" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Số Điện Thoại</label>
                        <input type="tel" name="so_dien_thoai" id="admin_profile_so_dien_thoai" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Địa Chỉ</label>
                        <input type="text" name="dia_chi" id="admin_profile_dia_chi" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px; display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Giới Tính</label>
                            <select name="gioi_tinh" id="admin_profile_gioi_tinh" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                <option value="Nam">Nam</option>
                                <option value="Nu">Nữ</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ngày Sinh</label>
                            <input type="date" name="ngay_sinh" id="admin_profile_ngay_sinh" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                    </div>

                    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                    <h4 style="margin-bottom: 15px; color: #555;">Đổi Mật Khẩu (Tùy chọn)</h4>
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mật Khẩu Hiện Tại</label>
                        <input type="password" name="current_password" id="admin_profile_current_password" placeholder="Bỏ trống nếu không đổi" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mật Khẩu Mới</label>
                        <input type="password" name="new_password" id="admin_profile_new_password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Xác Nhận Mật Khẩu</label>
                        <input type="password" name="confirm_password" id="admin_profile_confirm_password" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; background: #355F2E; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Lưu Thay Đổi</button>
                </form>
            </div>
        </div>

        <div class="admin-content">
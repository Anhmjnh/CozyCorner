<?php
// admin/users.php (Đóng vai trò View trong MVC)

// Nếu truy cập trực tiếp file này mà không qua Controller, chuyển hướng về Route chuẩn
if (!isset($users)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/users");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #2c3e50;">Quản lý Người Dùng</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">Tổng số:
            <strong><?= number_format($total) ?></strong> người dùng</p>
    </div>
    <button class="btn btn-primary" onclick="openUserModal()"><i class="fas fa-plus"></i> Thêm Người Dùng</button>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>admin/users"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <!-- Input Search -->
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên, email, SĐT..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

        <!-- Filter Rank -->
        <div class="filter-box" style="min-width: 150px;">
            <select name="hang"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Hạng --</option>
                <option value="Đồng" <?= ($hang ?? '') === 'Đồng' ? 'selected' : '' ?>>Đồng</option>
                <option value="Bạc" <?= ($hang ?? '') === 'Bạc' ? 'selected' : '' ?>>Bạc</option>
                <option value="Vàng" <?= ($hang ?? '') === 'Vàng' ? 'selected' : '' ?>>Vàng</option>
                <option value="Kim Cương" <?= ($hang ?? '') === 'Kim Cương' ? 'selected' : '' ?>>Kim Cương</option>
            </select>
        </div>

        <!-- Filter Status -->
        <div class="filter-box" style="min-width: 150px;">
            <select name="trang_thai"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Trạng thái --</option>
                <option value="HoatDong" <?= ($trang_thai ?? '') === 'HoatDong' ? 'selected' : '' ?>>Hoạt Động</option>
                <option value="Khoa" <?= ($trang_thai ?? '') === 'Khoa' ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i
                class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($hang) || !empty($trang_thai)): ?>
            <a href="<?= BASE_URL ?>admin/users" class="btn btn-light"
                style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i
                    class="fas fa-times"></i> Xóa lọc</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Email</th>
                <th>SĐT</th>
                <th>Hạng</th>
                <th>Trạng Thái</th>
                <th>Ngày Đăng Ký</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px; color: #7f8c8d;">Không tìm thấy người dùng nào
                        phù hợp!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr id="row-user-<?= $user['id'] ?>">
                        <td>#<?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['ho_ten']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['so_dien_thoai']) ?></td>
                        <td>
                            <?php
                            $badgeColor = '#cd7f32'; // Đồng
                            if ($user['hang'] == 'Kim Cương') $badgeColor = '#3498db'; // Xanh dương
                            elseif ($user['hang'] == 'Vàng') $badgeColor = '#f1c40f';
                            elseif ($user['hang'] == 'Bạc') $badgeColor = '#95a5a6';
                            ?>
                            <span class="badge"
                                style="background-color: <?= $badgeColor ?>; color: #fff;">
                                <?= $user['hang'] ?? 'Đồng' ?>
                            </span>
                        </td>
                        <td>
                            <span
                                class="badge <?= ($user['trang_thai'] ?? 'HoatDong') == 'HoatDong' ? 'badge-success' : 'badge-danger' ?>">
                                <?= ($user['trang_thai'] ?? 'HoatDong') == 'HoatDong' ? 'Hoạt Động' : 'Đã Khóa' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                        <td>
                            <button class="btn-icon text-blue" onclick="openUserModal(<?= $user['id'] ?>)" title="Chỉnh sửa"><i
                                    class="fas fa-edit"></i></button>
                            <button class="btn-icon text-red" onclick="deleteUser(<?= $user['id'] ?>)" title="Xóa tài khoản">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php
    $query_string = "";
    if (!empty($search))
        $query_string .= "&search=" . urlencode($search);
    if (!empty($hang))
        $query_string .= "&hang=" . urlencode($hang);
    if (!empty($trang_thai))
        $query_string .= "&trang_thai=" . urlencode($trang_thai);
    ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/users?page=<?= $i ?><?= $query_string ?>"
                class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<!-- MODAL SỬA NGƯỜI DÙNG -->
<div id="userModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 id="userModalTitle">Sửa Thông Tin Người Dùng</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="formUser">
            <input type="hidden" name="id" id="user_id">
            <div class="form-row">
                <div class="form-group">
                    <label>Họ Tên (*)</label>
                    <input type="text" name="ho_ten" id="user_ho_ten" required>
                </div>
                <div class="form-group">
                    <label>Email (*)</label>
                    <input type="email" name="email" id="user_email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="so_dien_thoai" id="user_so_dien_thoai">
                </div>
                <div class="form-group">
                    <label>Giới Tính</label>
                    <select name="gioi_tinh" id="user_gioi_tinh">
                        <option value="Nam">Nam</option>
                        <option value="Nu">Nữ</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Địa Chỉ</label>
                    <input type="text" name="dia_chi" id="user_dia_chi">
                </div>
                <div class="form-group">
                    <label>Ngày Sinh</label>
                    <input type="date" name="ngay_sinh" id="user_ngay_sinh">
                </div>
            </div>
            <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">
            <div class="form-row">
                <div class="form-group">
                    <label>Hạng Tài Khoản</label>
                    <select name="hang" id="user_hang">
                        <option value="Đồng">Đồng</option>
                        <option value="Bạc">Bạc</option>
                        <option value="Vàng">Vàng</option>
                        <option value="Kim Cương">Kim Cương</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng Thái</label>
                    <select name="trang_thai" id="user_trang_thai">
                        <option value="HoatDong">Hoạt Động</option>
                        <option value="Khoa">Khóa (Chặn Đăng Nhập)</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Mật Khẩu <small id="user_pw_hint"
                        style="font-weight: normal; color: #777;">(* Bắt buộc khi thêm mới)</small></label>
                <input type="password" name="mat_khau" id="user_mat_khau"
                    style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <button type="submit" class="btn btn-primary w-100" style="margin-top: 15px;">LƯU THÔNG TIN</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
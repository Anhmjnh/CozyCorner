<?php
// admin/staffs.php (Đóng vai trò View trong MVC)

if (!isset($staffs)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/staffs");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
$current_role = $_SESSION['admin_role'] ?? 'Staff';
?>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #2c3e50;">Quản lý Admin & Staff</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">Tổng số:
            <strong><?= number_format($total) ?></strong> tài khoản</p>
    </div>
    <?php if ($current_role === 'Admin'): ?>
        <button class="btn btn-primary" onclick="openStaffModal()"><i class="fas fa-plus"></i> Thêm Tài Khoản</button>
    <?php endif; ?>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>admin/staffs"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên, email, SĐT..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>
        <div class="filter-box" style="min-width: 150px;">
            <select name="vai_tro"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Vai trò --</option>
                <option value="Admin" <?= ($vai_tro ?? '') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Staff" <?= ($vai_tro ?? '') === 'Staff' ? 'selected' : '' ?>>Staff</option>
            </select>
        </div>
        <div class="filter-box" style="min-width: 150px;">
            <select name="trang_thai"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Trạng thái --</option>
                <option value="HoatDong" <?= ($trang_thai ?? '') === 'HoatDong' ? 'selected' : '' ?>>Hoạt Động</option>
                <option value="Khoa" <?= ($trang_thai ?? '') === 'Khoa' ? 'selected' : '' ?>>Khóa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i
                class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($vai_tro) || !empty($trang_thai)): ?>
            <a href="<?= BASE_URL ?>admin/staffs" class="btn btn-light"
                style="padding: 10px 20px; text-decoration: none; border-radius: 5px;"><i class="fas fa-times"></i> Xóa
                lọc</a>
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
                <th>Vai Trò</th>
                <th>Trạng Thái</th>
                <th>Ngày Tham Gia</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($staffs)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; padding: 30px;">Không tìm thấy nhân sự!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($staffs as $nv):
                    $can_edit = ($current_role === 'Admin' || $nv['vai_tro'] === 'Staff' || $nv['id'] == $_SESSION['admin_id']);
                    ?>
                    <tr id="row-staff-<?= $nv['id'] ?>">
                        <td>#<?= $nv['id'] ?></td>
                        <td><?= htmlspecialchars($nv['ho_ten']) ?> <br><small
                                style="color:#888;">@<?= htmlspecialchars($nv['username']) ?></small></td>
                        <td><?= htmlspecialchars($nv['email']) ?></td>
                        <td><?= htmlspecialchars($nv['so_dien_thoai']) ?></td>
                        <td><span class="badge"
                                style="background: <?= $nv['vai_tro'] == 'Admin' ? '#e74c3c' : '#3498db' ?>; color:#fff;"><?= $nv['vai_tro'] ?></span>
                        </td>
                        <td><span
                                class="badge <?= $nv['trang_thai'] == 'HoatDong' ? 'badge-success' : 'badge-danger' ?>"><?= $nv['trang_thai'] == 'HoatDong' ? 'Hoạt Động' : 'Đã Khóa' ?></span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($nv['created_at'])) ?></td>
                        <td>
                            <?php if ($can_edit): ?>
                                <button class="btn-icon text-blue" onclick="openStaffModal(<?= $nv['id'] ?>)" title="Chỉnh sửa"><i
                                        class="fas fa-edit"></i></button>
                            <?php endif; ?>
                            <?php if ($current_role === 'Admin' && $nv['id'] != $_SESSION['admin_id']): ?>
                                <button class="btn-icon text-red" onclick="deleteStaff(<?= $nv['id'] ?>)" title="Xóa"><i
                                        class="fas fa-trash"></i></button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    $qs = "";
    if (!empty($search))
        $qs .= "&search=" . urlencode($search);
    if (!empty($vai_tro))
        $qs .= "&vai_tro=" . urlencode($vai_tro);
    if (!empty($trang_thai))
        $qs .= "&trang_thai=" . urlencode($trang_thai);
    ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/staffs?page=<?= $i ?><?= $qs ?>"
                class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<!-- MODAL THÊM/SỬA STAFF -->
<div id="staffModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 id="staffModalTitle">Quản Lý Nhân Sự</h3>
            <span class="close-modal"
                onclick="document.getElementById('staffModal').style.display='none'">&times;</span>
        </div>
        <form id="formStaff">
            <input type="hidden" name="id" id="staff_id">
            <div class="form-row">
                <div class="form-group"><label>Họ Tên (*)</label><input type="text" name="ho_ten" id="staff_ho_ten"
                        required></div>
                <div class="form-group"><label>Username (*)</label><input type="text" name="username"
                        id="staff_username" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Email</label><input type="email" name="email" id="staff_email"></div>
                <div class="form-group"><label>SĐT</label><input type="text" name="so_dien_thoai" id="staff_sdt"></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Vai Trò</label>
                    <select name="vai_tro" id="staff_vai_tro" <?= $current_role !== 'Admin' ? 'disabled' : '' ?>>
                        <option value="Staff">Staff</option>
                        <option value="Admin">Admin</option>
                    </select>
                    <?php if ($current_role !== 'Admin'): ?>
                        <input type="hidden" name="vai_tro" value="Staff"> <!-- Gửi ẩn để lưu form -->
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Trạng Thái</label>
                    <select name="trang_thai" id="staff_trang_thai">
                        <option value="HoatDong">Hoạt Động</option>
                        <option value="Khoa">Khóa</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Mật Khẩu <small id="staff_pw_hint">(Bỏ trống nếu không muốn đổi)</small></label>
                <input type="password" name="password" id="staff_password">
            </div>
            <button type="submit" class="btn btn-primary w-100">LƯU THÔNG TIN</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
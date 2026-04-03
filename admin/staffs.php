<?php
// admin/staffs.php 

if (!isset($staffs)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/staffs");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
$current_role = $_SESSION['admin_role'] ?? 'Staff';
?>

<style>
    /* S CHO MODAL XÁC NHẬN XÓA  */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 25px;
        border: 1px solid #888;
        width: 95%;
        max-width: 450px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation-name: animatetop;
        animation-duration: 0.4s;
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .custom-modal-title {
        margin: 5px 0 0 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }

    .custom-modal-close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .custom-modal-body p {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 20px;
        text-align: center;
    }

    .custom-modal-body i {
        display: block;
        text-align: center;
        font-size: 50px;
        color: #f39c12;
        /* Màu vàng cảnh báo */
        margin-bottom: 20px;
    }

    @keyframes animatetop {
        from {
            top: -300px;
            opacity: 0
        }

        to {
            top: 0;
            opacity: 1
        }
    }

    .header-actions {
        display: flex; 
        gap: 10px; 
        align-items: center;
    }
    .btn-sync {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        height: 40px; 
        padding: 0 15px;
        border-radius: 5px;
        font-weight: 600;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
</style>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản lý Admin & Staff</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số:
            <strong><?= number_format($total) ?></strong> tài khoản</p>
    </div>
    <div class="header-actions">
        <?php
        $export_query = http_build_query([
            'search' => $search ?? '',
            'vai_tro' => $vai_tro ?? '',
            'trang_thai' => $trang_thai ?? ''
        ]);
        ?>
        <!-- Nút Xuất Excel -->
        <a href="<?= BASE_URL ?>index.php?url=admin/export_staffs_to_csv&<?= $export_query ?>" class="btn btn-primary btn-sync" style="background-color: #1D6F42; border-color: #1D6F42;">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
        <?php if ($current_role === 'Admin'): ?>
            <button class="btn btn-primary btn-sync" onclick="openStaffModal()"><i class="fas fa-plus"></i> Thêm Tài Khoản</button>
        <?php endif; ?>
    </div>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/staffs">
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
            <a href="<?= BASE_URL ?>index.php?url=admin/staffs" class="btn btn-light"
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
                                <button class="btn-icon text-red"
                                    onclick="showDeleteConfirm(<?= $nv['id'] ?>, '<?= htmlspecialchars(addslashes($nv['ho_ten'])) ?>')" title="Xóa"><i class="fas fa-trash"></i></button>
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
            <a href="<?= BASE_URL ?>index.php?url=admin/staffs&page=<?= $i ?><?= $qs ?>"
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
                    <select id="staff_trang_thai" onchange="document.getElementById('staff_trang_thai_hidden').value = this.value">
                        <option value="HoatDong">Hoạt Động</option>
                        <option value="Khoa">Khóa</option>
                    </select>
                    <input type="hidden" name="trang_thai" id="staff_trang_thai_hidden" value="HoatDong">
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

<!-- Custom Modal Xác nhận Xóa Nhân Sự -->
<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Nhân Sự</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa tài khoản <strong id="delete_staff_display_name"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_staff_id_input">
        </div>
        <div class="modal-footer"
            style="border-top: 1px solid #eee; padding-top: 15px; display: flex; justify-content: flex-end; gap: 12px;">
            <button type="button" class="btn btn-light" onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-primary" style="background-color: #355f2e; border-color: #355f2e;"
                id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
    // Lưu thông tin admin hiện tại để xử lý phân quyền trên JS
    const CURRENT_ADMIN_ID = <?= $_SESSION['admin_id'] ?? 0 ?>;
    const CURRENT_ADMIN_ROLE = '<?= $_SESSION['admin_role'] ?? 'Staff' ?>';

    function showDeleteConfirm(id, name) {
        document.getElementById('delete_staff_display_name').innerText = `"${name}"`;
        document.getElementById('delete_staff_id_input').value = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
    }

    // Thực hiện gọi API Xóa
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const id = document.getElementById('delete_staff_id_input').value;

        fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_staff', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
            .then(res => res.json())
            .then(res => {
                closeDeleteConfirmModal();
                if (res.status === 'success') {
                    showToast(res.msg, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(res.msg, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                closeDeleteConfirmModal();
                showToast('Lỗi kết nối đến máy chủ.', 'error');
            });
    });

    // Đóng Modal khi bấm ra bên ngoài
    window.addEventListener('click', function (event) {
        let modal = document.getElementById('deleteConfirmModal');
        if (event.target === modal) {
            closeDeleteConfirmModal();
        }
    });
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
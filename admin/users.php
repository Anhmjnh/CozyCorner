<?php
// admin/users.php 


if (!isset($users)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/users");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
    /*  MODAL XÁC NHẬN XÓA  */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6);
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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

    .custom-modal-close:hover,
    .custom-modal-close:focus {
        color: #000;
        text-decoration: none;
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
        color: #f39c12; /* Màu vàng cảnh báo */
        margin-bottom: 20px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-danger-custom {
        background-color: #355f2e;
        border-color: #355f2c;
        color: #fff;
    }
    .btn-danger-custom:hover {
        background-color: #2c4f26;
    }
    .btn-secondary-custom {
        background-color: #f0f0f0;
        border-color: #dcdcdc;
        color: #555;
    }
    .btn-secondary-custom:hover {
        background-color: #e0e0e0;
    }

    @keyframes animatetop {
        from {top: -300px; opacity: 0}
        to {top: 0; opacity: 1}
    }
</style>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản lý Người Dùng</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số:
            <strong><?= number_format($total) ?></strong> người dùng</p>
    </div>
    <button class="btn btn-primary" onclick="openUserModal()"><i class="fas fa-plus"></i> Thêm Người Dùng</button>
</div>

<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/users">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên, email, SĐT..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

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
        <?php if (!empty($search) || !empty($hang) || !empty($trang_thai)): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/users" class="btn btn-light"
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
                            <button class="btn-icon text-red" onclick="showDeleteConfirm(<?= $user['id'] ?>)" title="Xóa tài khoản">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

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
            <a href="<?= BASE_URL ?>index.php?url=admin/users&page=<?= $i ?><?= $query_string ?>"
                class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

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

<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Người Dùng</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa người dùng <strong id="delete_user_display_id"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_user_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer; border: 1px solid #dcdcdc;" onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-danger-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer;" id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
// --- XỬ LÝ MODAL XÓA ---
function showDeleteConfirm(id) {
    document.getElementById('delete_user_display_id').innerText = '#' + id;
    document.getElementById('delete_user_id_input').value = id;
    document.getElementById('deleteConfirmModal').style.display = 'flex';
}

function closeDeleteConfirmModal() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
}

// Thực hiện gọi API Xóa
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    const id = document.getElementById('delete_user_id_input').value;
    
    // GỌI API: Trỏ về Controller MVC
    fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_user', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(res => {
        closeDeleteConfirmModal();
        if (res.status === 'success') {
            if (typeof showToast === 'function') showToast(res.msg, 'success');
            else alert(res.msg);
            setTimeout(() => window.location.reload(), 1000);
        } else {
            if (typeof showToast === 'function') showToast(res.msg, 'error');
            else alert(res.msg);
        }
    })
    .catch(err => {
        console.error(err);
        closeDeleteConfirmModal();
        alert('Lỗi kết nối đến máy chủ.');
    });
});

// Đóng Modal khi bấm ra bên ngoài
window.addEventListener('click', function(event) {
    let modal = document.getElementById('deleteConfirmModal');
    if (event.target === modal) {
        closeDeleteConfirmModal();
    }
});
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
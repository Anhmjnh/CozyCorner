<?php
// admin/categories.php (

if (!isset($categories)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/categories");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
    /* O MODAL XÁC NHẬN XÓA - */
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
        margin-bottom: 20px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 15px;
        border-top: 1px solid #eee;
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
        <h2 style="margin: 0; color: #333;">Quản lý Danh Mục</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số:
            <strong><?= number_format($total) ?></strong> danh mục
        </p>
    </div>
    <div class="header-actions">
        <?php
        // Xây dựng chuỗi query cho link export để giữ lại bộ lọc hiện tại
        $export_query = http_build_query([
            'search' => $search,
            'trang_thai' => $trang_thai
        ]);
        ?>
        <!-- Nút Xuất Excel -->
        <a href="<?= BASE_URL ?>index.php?url=admin/export_categories_to_csv&<?= $export_query ?>" class="btn btn-primary btn-sync" style="background-color: #1D6F42; border-color: #1D6F42;">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
        <button class="btn btn-primary btn-sync" id="openAddModal"><i class="fas fa-plus"></i> Thêm Danh Mục</button>
    </div>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/categories">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên hoặc slug danh mục..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>
        <div class="filter-box" style="min-width: 150px;">
            <select name="trang_thai"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Trạng thái --</option>
                <option value="HienThi" <?= ($trang_thai ?? '') === 'HienThi' ? 'selected' : '' ?>>Hiển Thị</option>
                <option value="An" <?= ($trang_thai ?? '') === 'An' ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i
                class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($trang_thai)): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/categories" class="btn btn-light"
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
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Trạng Thái</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #7f8c8d;">Không tìm thấy danh mục nào
                        phù hợp!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                    <tr id="row-cat-<?= $cat['id'] ?>">
                        <td>#<?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['ten_danh_muc']) ?></td>
                        <td><?= htmlspecialchars($cat['slug']) ?></td>
                        <td><span
                                class="badge <?= $cat['trang_thai'] == 'HienThi' ? 'badge-success' : 'badge-danger' ?>"><?= $cat['trang_thai'] ?></span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($cat['created_at'])) ?></td>
                        <td>
                            <button class="btn-icon text-blue" onclick="openCategoryModal(<?= $cat['id'] ?>)"
                                title="Chỉnh sửa"><i class="fas fa-edit"></i></button>
                            <button class="btn-icon text-red"
                                onclick="showDeleteConfirm(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['ten_danh_muc'])) ?>')"><i
                                    class="fas fa-trash"></i></button>
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
    if (!empty($trang_thai))
        $query_string .= "&trang_thai=" . urlencode($trang_thai);
    ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/categories&page=<?= $i ?><?= $query_string ?>"
                class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<!-- MODAL THÊM DANH MỤC -->
<div id="categoryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="categoryModalTitle">Thêm Danh mục Mới</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="formCategory">
            <input type="hidden" name="id" id="category_id">
            <div class="form-group">
                <label>Tên Danh mục (*)</label>
                <input type="text" name="ten_danh_muc" id="category_ten_danh_muc" required>
            </div>
            <div class="form-group">
                <label>Trạng Thái</label>
                <select name="trang_thai">
                    <option value="HienThi">Hiển Thị</option>
                    <option value="An">Ẩn</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">LƯU DANH MỤC</button>
        </form>
    </div>
</div>

<!-- Custom Modal Xác nhận Xóa Danh Mục -->
<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Danh Mục</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa danh mục <strong id="delete_category_display_name"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_category_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-light" onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-primary" style="background-color: #355f2e; border-color: #355f2e;"
                id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
    function showDeleteConfirm(id, name) {
        document.getElementById('delete_category_display_name').innerText = `"${name}"`;
        document.getElementById('delete_category_id_input').value = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
    }

    // Thực hiện gọi API Xóa
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const id = document.getElementById('delete_category_id_input').value;

        fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_category', {
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
<?php
// admin/categories.php (Đóng vai trò View trong MVC)

// Nếu truy cập trực tiếp file này mà không qua Controller, chuyển hướng về Route chuẩn
if (!isset($categories)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/categories");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #2c3e50;">Quản lý Danh Mục</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">Tổng số: <strong><?= number_format($total) ?></strong> danh mục</p>
    </div>
    <button class="btn btn-primary" id="openAddModal"><i class="fas fa-plus"></i> Thêm Danh Mục</button>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container" style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>admin/categories" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên hoặc slug danh mục..." value="<?= htmlspecialchars($search ?? '') ?>" style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>
        <div class="filter-box" style="min-width: 150px;">
            <select name="trang_thai" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Trạng thái --</option>
                <option value="HienThi" <?= ($trang_thai ?? '') === 'HienThi' ? 'selected' : '' ?>>Hiển Thị</option>
                <option value="An" <?= ($trang_thai ?? '') === 'An' ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary" style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($trang_thai)): ?>
            <a href="<?= BASE_URL ?>admin/categories" class="btn btn-light" style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i class="fas fa-times"></i> Xóa lọc</a>
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
                <td colspan="6" style="text-align: center; padding: 30px; color: #7f8c8d;">Không tìm thấy danh mục nào phù hợp!</td>
            </tr>
            <?php else: ?>
            <?php foreach ($categories as $cat): ?>
            <tr id="row-cat-<?= $cat['id'] ?>">
                <td>#<?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['ten_danh_muc']) ?></td>
                <td><?= htmlspecialchars($cat['slug']) ?></td>
                <td><span class="badge <?= $cat['trang_thai'] == 'HienThi' ? 'badge-success' : 'badge-danger' ?>"><?= $cat['trang_thai'] ?></span></td>
                <td><?= date('d/m/Y H:i', strtotime($cat['created_at'])) ?></td>
                <td>
                    <button class="btn-icon text-blue" onclick="openCategoryModal(<?= $cat['id'] ?>)" title="Chỉnh sửa"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon text-red" onclick="deleteCategory(<?= $cat['id'] ?>)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php
    $query_string = "";
    if (!empty($search)) $query_string .= "&search=" . urlencode($search);
    if (!empty($trang_thai)) $query_string .= "&trang_thai=" . urlencode($trang_thai);
    ?>
    <div class="pagination">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/categories?page=<?= $i ?><?= $query_string ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
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
                <select name="trang_thai"><option value="HienThi">Hiển Thị</option><option value="An">Ẩn</option></select>
            </div>
            <button type="submit" class="btn btn-primary w-100">LƯU DANH MỤC</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
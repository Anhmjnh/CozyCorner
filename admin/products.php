<?php
// admin/products.php (Đóng vai trò View trong MVC)

// Nếu truy cập trực tiếp file này mà không qua Controller, chuyển hướng về Route chuẩn
if (!isset($products)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/products");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #2c3e50;">Quản lý Sản Phẩm</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d; font-size: 14px;">Tổng số: <strong><?= number_format($total) ?></strong> sản phẩm</p>
    </div>
    <button class="btn btn-primary" id="openAddProductModal"><i class="fas fa-plus"></i> Thêm Sản Phẩm</button>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container" style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>admin/products" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <!-- Input Search -->
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên sản phẩm cần tìm..." value="<?= htmlspecialchars($search ?? '') ?>" style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

        <!-- Filter Category -->
        <div class="filter-box" style="min-width: 200px;">
            <select name="category" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Tất cả danh mục --</option>
                <?php if (!empty($all_categories)): ?>
                    <?php foreach ($all_categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['ten_danh_muc']) ?>" <?= ($category ?? '') === $cat['ten_danh_muc'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['ten_danh_muc']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-secondary" style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($category)): ?>
            <a href="<?= BASE_URL ?>admin/products" class="btn btn-light" style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i class="fas fa-times"></i> Xóa lọc</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên SP</th>
                <th>Danh Mục</th>
                <th>Giá</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)): ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #7f8c8d;">Không tìm thấy sản phẩm nào phù hợp!</td>
            </tr>
            <?php else: ?>
                <?php foreach ($products as $p): ?>
            <tr id="row-<?= $p['id'] ?>">
                <td>#<?= $p['id'] ?></td>
                <td>
                    <?php if (!empty($p['anh'])): ?>
                        <img src="<?= BASE_URL ?>uploads/<?= $p['anh'] ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                    <?php else: ?>
                        <span style="color:#999; font-size:12px;">No img</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['ten_sp']) ?></td>
                <td><?= $p['danh_muc'] ?></td>
                <td><span class="text-green font-bold"><?= number_format($p['gia']) ?>đ</span></td>
                <td><span class="badge <?= $p['trang_thai'] == 'HienThi' ? 'badge-success' : 'badge-danger' ?>"><?= $p['trang_thai'] ?></span></td>
                <td>
                    <button class="btn-icon text-blue" onclick="openProductModal(<?= $p['id'] ?>)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon text-red" onclick="deleteProduct(<?= $p['id'] ?>)"><i class="fas fa-trash"></i></button>
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
    if (!empty($category)) $query_string .= "&category=" . urlencode($category);
    ?>
    <div class="pagination">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/products?page=<?= $i ?><?= $query_string ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<!-- MODAL THÊM SẢN PHẨM -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="productModalTitle">Thêm Sản Phẩm Mới</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="formProduct" enctype="multipart/form-data">
            <input type="hidden" name="id" id="product_id">
            <div class="form-group"><label>Tên Sản Phẩm (*)</label><input type="text" name="ten_sp" required></div>
            <div class="form-row">
                <div class="form-group"><label>Giá (*)</label><input type="number" name="gia" required></div>
                <div class="form-group"><label>Giá Cũ</label><input type="number" name="gia_cu"></div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Danh Mục</label>
                    <select name="danh_muc" id="product_danh_muc">
                        <?php if (!empty($all_categories)): ?>
                            <?php foreach($all_categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['ten_danh_muc']) ?>"><?= htmlspecialchars($cat['ten_danh_muc']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">-- Vui lòng thêm danh mục trước --</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group"><label>Số lượng</label><input type="number" name="so_luong" value="100"></div>
            </div>
            <div class="form-group"><label>Trạng Thái</label><select name="trang_thai" id="product_trang_thai"><option value="HienThi">Hiển Thị</option><option value="An">Ẩn</option><option value="HetHang">Hết Hàng</option></select></div>
            <div class="form-group">
                <label>Ảnh Sản Phẩm</label><input type="file" name="anh" accept="image/*">
                <input type="hidden" name="current_anh" id="product_current_anh">
                <img id="product_image_preview" src="" alt="Ảnh hiện tại" style="max-width: 100px; margin-top: 10px; display: none;">
            </div>
            <button type="submit" class="btn btn-primary w-100">LƯU SẢN PHẨM</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
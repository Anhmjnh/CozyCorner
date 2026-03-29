<?php
// admin/products.php 

if (!isset($products)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "admin/products");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
    /* MODAL XÁC NHẬN XÓA */
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

    .btn-danger-custom {
        background-color: #355f2e;
        border-color: #355f2c;
        color: #fff;
    }
    .btn-danger-custom:hover {
        background-color: #2a4d24; /* Đã sửa mã màu hover */
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

    /* Đảm bảo các nút trong header thẳng hàng */
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
        height: 40px; /* Cố định chiều cao để 2 nút bằng nhau */
        padding: 0 15px;
        border-radius: 5px;
        font-weight: 600;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
</style>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản lý Sản Phẩm</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số: <strong><?= number_format($total) ?></strong> sản phẩm</p>
    </div>
    <div class="header-actions">
        <?php
        $export_query = http_build_query([
            'search' => $search,
            'category' => $category
        ]);
        ?>
        <a href="<?= BASE_URL ?>index.php?url=admin/export_products_to_csv&<?= $export_query ?>" 
           class="btn btn-primary btn-sync" style="background-color: #1D6F42; border-color: #1D6F42;">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>

        <button class="btn btn-primary btn-sync" id="openAddProductModal">
            <i class="fas fa-plus"></i> Thêm Sản Phẩm
        </button>
    </div>
</div>

<div class="filter-container" style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/products">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập tên sản phẩm cần tìm..." value="<?= htmlspecialchars($search ?? '') ?>" style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

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

        <button type="submit" class="btn btn-secondary" style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($category)): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/products" class="btn btn-light" style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i class="fas fa-times"></i> Xóa lọc</a>
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
                    <button class="btn-icon text-red" onclick="showDeleteConfirm(<?= $p['id'] ?>)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <?php
    $query_string = "";
    if (!empty($search)) $query_string .= "&search=" . urlencode($search);
    if (!empty($category)) $query_string .= "&category=" . urlencode($category);
    ?>
    <div class="pagination">
        <?php for($i=1; $i<=$totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/products&page=<?= $i ?><?= $query_string ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<div id="productModal" class="modal">
    <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
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
            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="mo_ta" id="product_mo_ta" rows="6" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 15px; resize: vertical;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="margin-top: 10px; margin-bottom: 10px;">LƯU SẢN PHẨM</button>
        </form>
    </div>
</div>

<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Sản Phẩm</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa sản phẩm <strong id="delete_product_display_id"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_product_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer; border: 1px solid #dcdcdc;" onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-danger-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer;" id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
function showDeleteConfirm(id) {
    document.getElementById('delete_product_display_id').innerText = '#' + id;
    document.getElementById('delete_product_id_input').value = id;
    document.getElementById('deleteConfirmModal').style.display = 'flex';
}

function closeDeleteConfirmModal() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
}

// Thực hiện gọi API Xóa
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    const id = document.getElementById('delete_product_id_input').value;
    
    fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_product', {
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
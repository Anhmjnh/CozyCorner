<?php
if (!isset($newsList)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "index.php?url=admin/news");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
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
</style>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản Lý Tin Tức</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số: <strong><?= number_format($total) ?></strong>
            bài viết</p>
    </div>
    <button class="btn btn-primary" onclick="openNewsModal()"><i class="fas fa-plus"></i> Thêm Bài Viết Mới</button>
</div>

<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php"
        style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/news">
        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Tìm kiếm tiêu đề tin tức..."
                value="<?= htmlspecialchars($search ?? '') ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

        <div class="filter-box" style="min-width: 150px;">
            <select name="danh_muc"
                style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                <option value="">-- Danh mục --</option>
                <option value="Mẹo vặt" <?= $danh_muc === 'Mẹo vặt' ? 'selected' : '' ?>>Mẹo vặt</option>
                <option value="Sản phẩm" <?= $danh_muc === 'Sản phẩm' ? 'selected' : '' ?>>Sản phẩm</option>
                <option value="Thiết bị" <?= $danh_muc === 'Thiết bị' ? 'selected' : '' ?>>Thiết bị</option>
                <option value="Sức khỏe" <?= $danh_muc === 'Sức khỏe' ? 'selected' : '' ?>>Sức khỏe</option>
            </select>
        </div>

        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i
                class="fas fa-filter"></i> Lọc</button>
        <?php if (!empty($search) || !empty($danh_muc)): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/news" class="btn btn-light"
                style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i
                    class="fas fa-times"></i> Xóa lọc</a>
        <?php endif; ?>
    </form>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Hình Ảnh</th>
                <th width="35%">Tiêu Đề</th>
                <th width="10%">Danh Mục</th>
                <th width="10%">Lượt Xem</th>
                <th width="15%">Trạng Thái</th>
                <th width="10%">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($newsList)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #888;">Chưa có bài viết tin tức nào.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($newsList as $item): ?>
                    <tr id="row-news-<?= $item['id'] ?>">
                        <td><strong style="color: #333;">#<?= $item['id'] ?></strong></td>
                        <td>
                            <?php if ($item['anh']): ?>
                                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>" alt="News Image"
                                    style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                            <?php else: ?>
                                <div
                                    style="width: 80px; height: 60px; background: #eee; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 12px;">
                                    No Image</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div
                                style="font-weight: 600; color: #2e5932; margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($item['tieu_de']) ?>
                            </div>
                            <div style="font-size: 12px; color: #888;"><i class="far fa-clock"></i>
                                <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></div>
                        </td>
                        <td><span
                                style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px; font-size: 13px; color: #555; font-weight: 600;"><?= htmlspecialchars($item['danh_muc'] ?? 'Tin tức') ?></span>
                        </td>
                        <td><i class="far fa-eye"
                                style="color: #95a5a6; margin-right: 5px;"></i><?= number_format($item['luot_xem']) ?></td>
                        <td>
                            <span class="badge <?= $item['trang_thai'] === 'HienThi' ? 'badge-success' : 'badge-danger' ?>">
                                <?= $item['trang_thai'] === 'HienThi' ? 'Hiển Thị' : 'Đã Ẩn' ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn-icon text-blue" onclick="openNewsModal(<?= $item['id'] ?>)" title="Chỉnh sửa"><i
                                    class="fas fa-edit"></i></button>
                            <button class="btn-icon text-red"
                                onclick="showDeleteConfirm(<?= $item['id'] ?>, '<?= htmlspecialchars(addslashes($item['tieu_de'])) ?>')"
                                title="Xóa"><i class="fas fa-trash"></i></button>
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
    if (!empty($danh_muc))
        $qs .= "&danh_muc=" . urlencode($danh_muc);
    ?>
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= BASE_URL ?>index.php?url=admin/news&page=<?= $i ?><?= $qs ?>"
                    class="page-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>


<div id="toast" class="toast"></div>

<div id="modal-container-inject"></div>

<!-- Custom Modal Xác nhận Xóa Tin Tức -->
<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Tin Tức</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa bài viết <strong id="delete_news_display_name"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_news_id_input">
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
        document.getElementById('delete_news_display_name').innerText = `"${name}"`;
        document.getElementById('delete_news_id_input').value = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
    }

    // Thực hiện gọi API Xóa
    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const id = document.getElementById('delete_news_id_input').value;

        fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_news', {
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

<?php
if (file_exists(__DIR__ . '/includes/admin_footer.php'))
    require_once __DIR__ . '/includes/admin_footer.php';
?>
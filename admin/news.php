<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/AdminModel.php'; // Sẽ cần model này sau

// Tạm thời lấy dữ liệu trực tiếp, sau này sẽ chuyển vào model
$conn = connectDB();
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");
$news_list = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0; color: #2c3e50;">Quản lý Tin tức</h2>
    <button class="btn btn-primary" id="openAddNewsModal"><i class="fas fa-plus"></i> Thêm Tin tức</button>
</div>

<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Trạng Thái</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news_list as $news): ?>
                <tr>
                    <td>#<?= $news['id'] ?></td>
                    <td><?= htmlspecialchars($news['tieu_de']) ?></td>
                    <td><span
                            class="badge <?= $news['trang_thai'] == 'HienThi' ? 'badge-success' : 'badge-danger' ?>"><?= $news['trang_thai'] ?></span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($news['created_at'])) ?></td>
                    <td>
                        <button class="btn-icon text-blue"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon text-red"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
<?php
// admin/index.php
if (!isset($stats)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "index.php?url=admin/index");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="dashboard-cards">
    <div class="card card-blue">
        <div class="card-info">
            <h3>Tổng Sản Phẩm</h3>
            <h2><?= number_format($stats['total_products']) ?></h2>
        </div>
        <i class="fas fa-box card-icon"></i>
    </div>
    <div class="card card-green">
        <div class="card-info">
            <h3>Đơn Hàng</h3>
            <h2><?= number_format($stats['total_orders']) ?></h2>
        </div>
        <i class="fas fa-shopping-cart card-icon"></i>
    </div>
    <div class="card card-orange">
        <div class="card-info">
            <h3>Khách Hàng</h3>
            <h2><?= number_format($stats['total_users']) ?></h2>
        </div>
        <i class="fas fa-users card-icon"></i>
    </div>
    <div class="card card-red">
        <div class="card-info">
            <h3>Doanh Thu</h3>
            <h2><?= number_format($stats['total_revenue']) ?>đ</h2>
        </div>
        <i class="fas fa-chart-line card-icon"></i>
    </div>
</div>

<div class="chart-container" style="background:#fff; padding:20px; border-radius:8px; margin-top:30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h3 style="margin-bottom: 20px;">Biểu Đồ Doanh Thu 7 Ngày Qua</h3>
    <canvas id="revenueChart" height="100"></canvas>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
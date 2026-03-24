<?php
// views/news/DanhMucTinTuc.php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';

// Load danh sách tin tức từ DB
$conn = connectDB();
$result = $conn->query("
    SELECT * FROM news 
    WHERE trang_thai = 'HienThi' 
    ORDER BY created_at DESC 
    LIMIT 12
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZY CORNER</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">

    <!-- Font Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- CSS chính (chung cho toàn site) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/DanhMucTinTuc.css">

    <!-- CSS riêng cho từng trang - chỉ include ở view cụ thể, không nên include hết ở header -->
    <!-- Ví dụ: nếu trang chủ cần CSS riêng, include ở TrangChu.php thay vì ở đây -->

    <!-- Font Awesome (cho icon save, user, v.v. nếu cần sau này) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<!-- BANNER -->
<div class="banner__tintuc">
    <img class="banner__img" src="<?= BASE_URL ?>assets/img/Banner-DanhMucSanPham.png" alt="Banner Danh Muc Tin Tuc">
</div>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li>Tin tức</li>
</ul>

<!-- CATEGORI -->
<div class="category">
    <button class="category__item category__item-active">Tất cả</button>
    <button class="category__item">Mẹo vặt</button>
    <button class="category__item">Sản phẩm</button>
    <button class="category__item">Thiết bị</button>
    <button class="category__item">Sức khỏe</button>
</div>

<!-- CONTENT -->
<div class="news">
    <div class="news__list">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <article class="news__item">
                    <a href="<?= BASE_URL ?>view/news/ChiTietTinTuc.php?id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>" alt="<?= htmlspecialchars($row['tieu_de']) ?>" class="news__image">
                    </a>
                    <div class="news__content">
                        <div class="news__date"><?= date('d/m/Y', strtotime($row['created_at'])) ?></div>
                        <div class="news__category">Tin tức</div> <!-- Sau này có thể thêm cột category -->
                    </div>
                    <div class="news__headline">
                        <a href="<?= BASE_URL ?>view/news/ChiTietTinTuc.php?id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['tieu_de']) ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có tin tức nào đang hiển thị.</p>
        <?php endif; ?>
    </div>

    <button class="more__btn">
        <div class="more__btn-text">XEM THÊM</div>
        <img class="more__btn-img" src="<?= BASE_URL ?>assets/icon/Icon-right2.svg" alt="icon right">
    </button>
</div>

<!-- LỢI ÍCH -->
<div class="benefits">
    <div class="benefits__list">
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-box.svg" alt="Giao hàng miễn phí" class="benefits__icon">
            <p class="benefits__text">Miễn Phí Giao Hàng Với Đơn Hàng Từ 900K</p>
        </div>
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-Truck.svg" alt="Giao hàng tận nơi" class="benefits__icon">
            <p class="benefits__text">Hỗ Trợ Giao Hàng Tận Nơi</p>
        </div>
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-medal.svg" alt="Bảo hành chính hãng" class="benefits__icon">
            <p class="benefits__text">Cam Kết Bảo Hành Chính Hãng</p>
        </div>
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-voucher.svg" alt="Ưu đãi voucher" class="benefits__icon">
            <p class="benefits__text">Ưu Đãi Voucher Lên Đến 500K</p>
        </div>
    </div>
</div>

<?php 
$conn->close(); 
require_once __DIR__ . '/../../includes/footer.php'; 
?>


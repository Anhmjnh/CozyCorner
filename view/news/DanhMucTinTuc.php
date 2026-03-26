<?php
require_once __DIR__ . '/../../includes/header.php';
?>
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
        <?php if (!empty($news_list)): ?>
            <?php foreach ($news_list as $row): ?>
                <article class="news__item">
                    <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>"
                            alt="<?= htmlspecialchars($row['tieu_de']) ?>" class="news__image">
                    </a>
                    <div class="news__content">
                        <div class="news__date"><?= date('d/m/Y', strtotime($row['created_at'])) ?></div>
                        <div class="news__category">Tin tức</div> <!-- Sau này có thể thêm cột category -->
                    </div>
                    <div class="news__headline">
                        <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['tieu_de']) ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
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
require_once __DIR__ . '/../../includes/footer.php';
?>
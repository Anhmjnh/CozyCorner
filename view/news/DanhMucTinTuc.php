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
<?php
$current_category = isset($_GET['category']) ? $_GET['category'] : 'Tất cả';
?>
<div class="category" style="display: flex; gap: 10px; margin-bottom: 30px; justify-content: center; flex-wrap: wrap;">
    <a href="<?= BASE_URL ?>index.php?url=news" class="category__item <?= $current_category === 'Tất cả' || $current_category === '' ? 'category__item-active' : '' ?>" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Tất cả</a>
    <a href="<?= BASE_URL ?>index.php?url=news&category=Mẹo vặt" class="category__item <?= $current_category === 'Mẹo vặt' ? 'category__item-active' : '' ?>" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Mẹo vặt</a>
    <a href="<?= BASE_URL ?>index.php?url=news&category=Sản phẩm" class="category__item <?= $current_category === 'Sản phẩm' ? 'category__item-active' : '' ?>" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Sản phẩm</a>
    <a href="<?= BASE_URL ?>index.php?url=news&category=Thiết bị" class="category__item <?= $current_category === 'Thiết bị' ? 'category__item-active' : '' ?>" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Thiết bị</a>
    <a href="<?= BASE_URL ?>index.php?url=news&category=Sức khỏe" class="category__item <?= $current_category === 'Sức khỏe' ? 'category__item-active' : '' ?>" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Sức khỏe</a>
</div>

<style>
    /* Canh trái các tin tức và chia làm 3 cột bằng CSS Grid */
    .news__list {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    @media (max-width: 992px) {
        .news__list { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .news__list { grid-template-columns: 1fr; }
    }

    /* Đồng bộ chiều cao ảnh và căn chỉnh nội dung bài viết */
    .news__item {
        display: flex;
        flex-direction: column;
        height: 100%; /* Giúp các khung bài viết dài bằng nhau trên cùng 1 hàng */
    }
    .news__item > a {
        display: block;
        width: 100%;
    }
    .news__image {
        width: 100%;
        height: 240px; /* Cố định chiều cao ảnh, bạn có thể chỉnh to/nhỏ tùy ý */
        object-fit: cover; /* Cắt ảnh cho vừa vặn khung mà không bị méo tỉ lệ */
        border-radius: 8px; /* Bo tròn góc ảnh nhẹ nhàng */
    }
    .news__headline {
        margin-top: 10px;
        flex-grow: 1; /* Tự động giãn không gian để các chữ thẳng hàng */
    }
</style>

<!-- CONTENT -->
<div class="news">
    <div class="news__list">
        <?php if (!empty($news_list)): ?>
            <?php foreach ($news_list as $index => $row): ?>
                <article class="news__item js__news-item" <?= $index >= 3 ? 'style="display: none;"' : '' ?>>
                    <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>"
                            alt="<?= htmlspecialchars($row['tieu_de']) ?>" class="news__image">
                    </a>
                    <div class="news__content">
                        <div class="news__date"><?= date('d/m/Y', strtotime($row['created_at'])) ?></div>
                        <div class="news__category"><?= htmlspecialchars($row['danh_muc'] ?? 'Tin tức') ?></div>
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

    <?php if (!empty($news_list) && count($news_list) > 3): ?>
        <button class="more__btn" id="loadMoreNewsBtn" style="cursor: pointer;">
            <div class="more__btn-text">XEM THÊM</div>
            <img class="more__btn-img" src="<?= BASE_URL ?>assets/icon/Icon-right2.svg" alt="icon right" style="transform: rotate(90deg);">
        </button>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('loadMoreNewsBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const hiddenItems = document.querySelectorAll('.js__news-item[style*="display: none"]');
                
                for (let i = 0; i < 3 && i < hiddenItems.length; i++) {
                    hiddenItems[i].style.display = 'block'; 
                }
                
                if (document.querySelectorAll('.js__news-item[style*="display: none"]').length === 0) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }
    });
</script>

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
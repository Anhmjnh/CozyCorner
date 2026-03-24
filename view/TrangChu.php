<?php
// views/home/TrangChu.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config.php';

// Kết nối DB
$conn = connectDB();

// 1. Sản phẩm bán chạy (top theo lượt bán)
$bestseller_result = $conn->query("
    SELECT * FROM products 
    WHERE trang_thai = 'HienThi' 
    ORDER BY luot_ban DESC 
    LIMIT 9
");

// 2. Sản phẩm mới nhất (theo ngày tạo)
$new_products_result = $conn->query("
    SELECT * FROM products 
    WHERE trang_thai = 'HienThi' 
    ORDER BY created_at DESC 
    LIMIT 9
");

// 3. Tin tức mới nhất
$news_result = $conn->query("
    SELECT * FROM news 
    WHERE trang_thai = 'HienThi' 
    ORDER BY created_at DESC 
    LIMIT 3
");
?>

<!-- BANNER -->
<div class="banner" style="background: url('<?= BASE_URL ?>assets/img/Banner.png') center center / cover no-repeat; ">
    <div class="banner__content">
        <p class="banner__subtitle-top">Tiện nghi tối ưu</p>
        <div class="banner__title">Bí Quyết Cho Căn <br>Bếp Hiện Đại, <br>Tiện Nghi.</div>
        <p class="banner__subtitle-bot">Sản phẩm thông minh, thiết kế tinh tế, giúp bạn dễ dàng nấu những bữa ăn <br>ngon mỗi ngày.</p>
        <div class="banner__buttons">
            <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="banner__button banner__button--primary">KHÁM PHÁ NGAY</a>
            <a href="<?= BASE_URL ?>LienHe.php" class="banner__button banner__button--secondary">VỀ CHÚNG TÔI</a>
        </div>
    </div>
</div>

<!-- LABEL (danh mục icon) -->
<div class="label__icon-list">
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-noi.svg" alt="Nồi">
        </div>           
        <p class="label__icon-list__text">NỒI</p>
    </div>
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-chao.svg" alt="Chảo">
        </div>
        <p class="label__icon-list__text">CHẢO</p>
    </div>
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-chen.svg" alt="Chén">
        </div>
        <p class="label__icon-list__text">CHÉN</p>
    </div>
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-thot.svg" alt="Thớt">
        </div>
        <p class="label__icon-list__text">THỚT</p>
    </div>
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-mayxay.svg" alt="Đồ điện">
        </div>
        <p class="label__icon-list__text">ĐỒ ĐIỆN</p>
    </div>
    <div class="label__icon-list__item">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-dao.svg" alt="Dao">
        </div>
        <p class="label__icon-list__text">DAO</p>
    </div>
</div>

<!-- SẢN PHẨM BÁN CHẠY -->
<div class="bestseller">
    <div class="bestseller__info">
        <div class="bestseller__title">Sản Phẩm Bán Chạy</div>
        <p class="bestseller__desc">Khám phá những sản phẩm gia dụng được yêu thích nhất, lựa chọn hàng đầu của hàng ngàn gia đình.</p>
        <div class="bestseller__nav">
            <button class="bestseller__nav-button" onclick="scrollProducts(-500)">
                <img class="bestseller__nav-button--prev" src="<?= BASE_URL ?>assets/icon/icon-button-left.svg" alt="button left">
            </button>
            <button class="bestseller__nav-button" onclick="scrollProducts(500)">
                <img class="bestseller__nav-button--next" src="<?= BASE_URL ?>assets/icon/icon-button-right.svg" alt="button right">
            </button>
        </div>
    </div>

    <div class="product__container" id="product_scroll">
        <?php if ($bestseller_result->num_rows > 0): ?>
            <?php while ($row = $bestseller_result->fetch_assoc()): ?>
                <div class="product__card">
                    <a href="<?= BASE_URL ?>view/product/ChiTietSanPham.php?id=<?= $row['id'] ?>" draggable="false">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>" alt="<?= htmlspecialchars($row['ten_sp']) ?>" class="product__card-image" draggable="false">
                    </a>
                    <div class="product__card-text">
                        <p class="product__card-name">
                            <?= htmlspecialchars($row['ten_sp']) ?> <br>
                            <span class="product__card-price">
                                <?= number_format($row['gia']) ?>đ 
                                <?php if ($row['gia_cu'] > 0): ?>
                                    <span class="product__card-old-price"><?= number_format($row['gia_cu']) ?>đ</span>
                                <?php endif; ?>
                            </span>
                        </p>
                        <a href="javascript:void(0)" class="product__card-cart js__add-to-cart" data-product-id="<?= $row['id'] ?>">
                            <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm bán chạy nào.</p>
        <?php endif; ?>
    </div>
</div>

<!-- MINI BANNER -->
<div class="kitchen">
    <div class="kitchen__section kitchen__section--left">
        <div class="kitchen__panel kitchen__panel--left">
            <img src="<?= BASE_URL ?>assets/img/Left-Mini Banner.png" alt="Bếp bên trái" class="kitchen__image">
        </div>
    </div>
    <div class="kitchen__section kitchen__section--right">
        <div class="kitchen__panel kitchen__panel--right">
            <img src="<?= BASE_URL ?>assets/img/Right-Mini Banner.png" alt="Bếp bên phải" class="kitchen__image">
        </div>
    </div>
</div>

<!-- SẢN PHẨM MỚI -->
<div class="product__list">
    <div class="product__list-title">Sản Phẩm</div>
    <div class="product__list-tabs">
        <div class="product__list-tab product__list-tab--active">Mới</div>
        <div class="product__list-tab product__list-tab--not-active">Phổ biến</div>
        <div class="product__list-tab product__list-tab--not-active">Khuyến mãi</div>
    </div>

    <div class="product__list-items">
        <?php if ($new_products_result->num_rows > 0): ?>
            <?php while ($row = $new_products_result->fetch_assoc()): ?>
                <div class="product__list-item">
                    <a href="<?= BASE_URL ?>view/product/ChiTietSanPham.php?id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>" alt="<?= htmlspecialchars($row['ten_sp']) ?>" class="product__list-image">
                    </a>
                    <div class="product__list-text">
                        <p class="product__list-item-title">
                            <?= htmlspecialchars($row['ten_sp']) ?> <br>
                            <span class="product__list-price">
                                <?= number_format($row['gia']) ?>đ 
                                <?php if ($row['gia_cu'] > 0): ?>
                                    <span class="product__list-old-price"><?= number_format($row['gia_cu']) ?>đ</span>
                                <?php endif; ?>
                            </span>
                        </p>
                        <a href="javascript:void(0)" class="product__list-cart-button js__add-to-cart" data-product-id="<?= $row['id'] ?>">
                            <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm mới nào.</p>
        <?php endif; ?>
    </div>

    <button class="more__btn" onclick="window.location.href='<?= BASE_URL ?>view/product/DanhMucSanPham.php'">
        <div class="more__btn-text">XEM THÊM</div>
        <img class="more__btn-img" src="<?= BASE_URL ?>assets/icon/Icon-right2.svg" alt="icon right">
    </button>
</div>

<!-- VỀ CHÚNG TÔI -->
<div class="about">
    <div class="about__content">
        <div class="about__title">Về Chúng Tôi</div>
        <p class="about__description">
            Chào mừng bạn đến với trang web chuyên cung cấp sản phẩm gia dụng bếp chất lượng cao.
            Chúng tôi mang đến các giải pháp tiện ích và hiện đại, giúp bạn tận hưởng không gian bếp trọn vẹn hơn.
        </p>
        <p class="about__description">
            Với đa dạng sản phẩm từ dụng cụ nhà bếp đến thiết bị thông minh, chúng tôi cam kết chất lượng và an toàn, 
            đáp ứng mọi nhu cầu của gia đình bạn.
        </p>
    </div>
    <div class="about__image">
        <img src="<?= BASE_URL ?>assets/img/img-about.png" alt="Gian bếp ấm cúng">
    </div>
</div>

<!-- TIN TỨC -->
<div class="news">
    <div class="news__title">Tin Tức</div>
    <div class="news__list">
        <?php if ($news_result->num_rows > 0): ?>
            <?php while ($row = $news_result->fetch_assoc()): ?>
                <article class="news__item">
                    <a href="<?= BASE_URL ?>view/news/ChiTietTinTuc.php?id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>" alt="<?= htmlspecialchars($row['tieu_de']) ?>" class="news__image">
                    </a>
                    <div class="news__content">
                        <div class="news__date"><?= date('d/m/Y', strtotime($row['created_at'])) ?></div>
                        <div class="news__category">Tin tức</div>
                    </div>
                    <div class="news__headline">
                        <a href="<?= BASE_URL ?>view/news/ChiTietTinTuc.php?id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['tieu_de']) ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có tin tức nào.</p>
        <?php endif; ?>
    </div>
    <button class="more__btn" onclick="window.location.href='<?= BASE_URL ?>view/news/DanhMucTinTuc.php'">
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

<!-- SCRIPT: Cuộn sản phẩm bán chạy -->
<script>
    function scrollProducts(amount) {
        document.querySelector('.product__container').scrollBy({
            left: amount,
            behavior: 'smooth'
        });
    }
</script>

<!-- SCRIPT: Kéo cuộn sản phẩm bằng chuột -->
<script>
    const slider = document.getElementById('product_scroll');
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('dragging');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('dragging');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('dragging');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });
</script>

<?php 
$conn->close(); 
require_once __DIR__ . '/../includes/footer.php'; 
?>
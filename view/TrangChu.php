<?php
// views/home/TrangChu.php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- BANNER -->
<div class="banner" style="background: url('<?= BASE_URL ?>assets/img/Banner.png') center center / cover no-repeat; ">
    <div class="banner__content">
        <p class="banner__subtitle-top">Tiện nghi tối ưu</p>
        <div class="banner__title">Bí Quyết Cho Căn <br>Bếp Hiện Đại, <br>Tiện Nghi.</div>
        <p class="banner__subtitle-bot">Sản phẩm thông minh, thiết kế tinh tế, giúp bạn dễ dàng nấu những bữa ăn
            <br>ngon mỗi ngày.
        </p>
        <div class="banner__buttons">
            <a href="<?= BASE_URL ?>index.php?url=product" class="banner__button banner__button--primary">KHÁM
                PHÁ NGAY</a>
            <a href="<?= BASE_URL ?>index.php?url=contact" class="banner__button banner__button--secondary">VỀ CHÚNG
                TÔI</a>
        </div>
    </div>
</div>

<!-- LABEL (danh mục icon) -->
<div class="label__icon-list">
    <a href="<?= BASE_URL ?>index.php?url=product&category=n-i" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-noi.svg" alt="Nồi">
        </div>
        <p class="label__icon-list__text">NỒI</p>
    </a>
    <a href="<?= BASE_URL ?>index.php?url=product&category=ch-o" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-chao.svg" alt="Chảo">
        </div>
        <p class="label__icon-list__text">CHẢO</p>
    </a>
    <a href="<?= BASE_URL ?>index.php?url=product&category=ch-n" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-chen.svg" alt="Chén">
        </div>
        <p class="label__icon-list__text">CHÉN</p>
    </a>
    <a href="<?= BASE_URL ?>index.php?url=product&category=th-t" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-thot.svg" alt="Thớt">
        </div>
        <p class="label__icon-list__text">THỚT</p>
    </a>
    <a href="<?= BASE_URL ?>index.php?url=product&category=-i-n" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-mayxay.svg" alt="Đồ điện">
        </div>
        <p class="label__icon-list__text">ĐỒ ĐIỆN</p>
    </a>
    <a href="<?= BASE_URL ?>index.php?url=product&category=dao" class="label__icon-list__item"
        style="text-decoration: none; color: inherit;">
        <div class="label__icon-list--background">
            <img class="label__icon-list__image" src="<?= BASE_URL ?>assets/icon/icon-dao.svg" alt="Dao">
        </div>
        <p class="label__icon-list__text">DAO</p>
    </a>
</div>

<!-- SẢN PHẨM BÁN CHẠY -->
<div class="bestseller">
    <div class="bestseller__info">
        <div class="bestseller__title">Sản Phẩm Bán Chạy</div>
        <p class="bestseller__desc">Khám phá những sản phẩm gia dụng được yêu thích nhất, lựa chọn hàng đầu của hàng
            ngàn gia đình.</p>
        <div class="bestseller__nav">
            <button class="bestseller__nav-button" onclick="scrollProducts(-500)">
                <img class="bestseller__nav-button--prev" src="<?= BASE_URL ?>assets/icon/icon-button-left.svg"
                    alt="button left">
            </button>
            <button class="bestseller__nav-button" onclick="scrollProducts(500)">
                <img class="bestseller__nav-button--next" src="<?= BASE_URL ?>assets/icon/icon-button-right.svg"
                    alt="button right">
            </button>
        </div>
    </div>

    <div class="product__container" id="product_scroll">
        <?php if (!empty($bestsellers)): ?>
            <?php foreach ($bestsellers as $row): ?>
                <div class="product__card">
                    <a href="<?= BASE_URL ?>view/product/ChiTietSanPham.php?id=<?= $row['id'] ?>" draggable="false">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>"
                            alt="<?= htmlspecialchars($row['ten_sp']) ?>" class="product__card-image" draggable="false">
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
                        <?php if ($row['so_luong_ton'] > 0): ?>
                            <a href="javascript:void(0)" class="product__card-cart js__add-to-cart"
                                data-product-id="<?= $row['id'] ?>">
                                <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                            </a>
                        <?php else: ?>
                            <span class="product__card-cart"
                                style="border-color: #ccc; background-color: #f5f5f5; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; color: #999; text-decoration: none;"
                                title="Hết hàng">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
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

<!-- SẢN PHẨM  -->
<div class="product__list">
    <div class="product__list-title">Sản Phẩm</div>

    <!-- Tabs Bộ Lọc Sản Phẩm -->
    <div class="product__tabs">
        <button class="product__tab-btn active" data-tab="new">Mới</button>
        <button class="product__tab-btn" data-tab="foryou">Dành riêng cho bạn</button>
        <button class="product__tab-btn" data-tab="sale">Đang khuyến mãi</button>
    </div>

    <div class="product__list-items" id="home-product-grid">
        <?php if (!empty($new_products)): ?>
            <?php foreach ($new_products as $row): ?>
                <div class="product__list-item">
                    <a href="<?= BASE_URL ?>view/product/ChiTietSanPham.php?id=<?= $row['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($row['anh']) ?>"
                            alt="<?= htmlspecialchars($row['ten_sp']) ?>" class="product__list-image">
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
                        <?php if ($row['so_luong_ton'] > 0): ?>
                            <a href="javascript:void(0)" class="product__list-cart-button js__add-to-cart"
                                data-product-id="<?= $row['id'] ?>">
                                <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                            </a>
                        <?php else: ?>
                            <span class="product__list-cart-button"
                                style="border-color: #ccc; background-color: #f5f5f5; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; color: #999; padding: 12px; text-decoration: none;"
                                title="Hết hàng">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm mới nào.</p>
        <?php endif; ?>
    </div>

    <button class="more__btn" onclick="window.location.href='<?= BASE_URL ?>index.php?url=product'">
        <div class="more__btn-text">XEM THÊM</div>
        <img class="more__btn-img" src="<?= BASE_URL ?>assets/icon/Icon-right2.svg" alt="icon right">
    </button>
</div>

<!-- VỀ CHÚNG TÔI -->
<<div class="about">
    <div class="about__content">
        <div class="about__title">Về Chúng Tôi</div>
        
        <p class="about__description">
            Chào mừng bạn đến với cửa hàng của chúng tôi – nơi mang đến những sản phẩm gia dụng nhà bếp chất lượng cao, 
            hiện đại và tiện ích. Chúng tôi luôn đặt trải nghiệm của khách hàng lên hàng đầu, với mong muốn giúp mỗi gia đình 
            có một không gian bếp tiện nghi, ấm cúng và đầy cảm hứng.
        </p>

        <p class="about__description">
            Các sản phẩm của chúng tôi được lựa chọn kỹ lưỡng từ những thương hiệu uy tín, đảm bảo độ bền, an toàn và tính thẩm mỹ. 
            Từ những dụng cụ nhà bếp cơ bản đến các thiết bị thông minh, tất cả đều nhằm giúp bạn tiết kiệm thời gian và nâng cao chất lượng cuộc sống.
        </p>

        <p class="about__description">
            Chúng tôi không chỉ bán sản phẩm, mà còn mong muốn đồng hành cùng bạn trong hành trình chăm sóc gia đình, 
            mang lại những bữa ăn ngon và khoảnh khắc sum vầy đáng nhớ.
        </p>
    </div>

    <div class="about__image">
        <img src="<?= BASE_URL ?>assets/img/img-about.png" alt="Gian bếp ấm cúng">
    </div>
</div>

<style>
        /* --- CSS cho Tabs Sản Phẩm --- */
    .product__tabs {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 40px;
        border-bottom: 2px solid #EEEEEE;
        padding-bottom: 5px;
    }

    .product__tab-btn {
        background: none;
        border: none;
        font-size: 18px;
        font-weight: 600;
        color: #9E9E9E;
        cursor: pointer;
        padding: 10px 20px;
        position: relative;
        transition: all 0.3s ease;
       
    }

    .product__tab-btn:hover {
        color: #355F2E;
    }

    .product__tab-btn.active {
        color: #355F2E;
        font-weight: 700;
    }

    .product__tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -7px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #355F2E;
        border-radius: 3px;
    }

    #home-product-grid {
        transition: opacity 0.3s ease;
    }

    @media (max-width: 768px) {
        .product__tabs {
            gap: 10px;
            flex-wrap: wrap;
        }
        .product__tab-btn {
            font-size: 14px;
            padding: 8px 10px;
        }
    }


    /* Đồng bộ chiều cao ảnh và căn chỉnh nội dung bài viết tin tức ở trang chủ */
    .news__item {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .news__item>a {
        display: block;
        width: 100%;
    }

    .news__image {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 8px;
    }

    .news__headline {
        margin-top: 10px;
        flex-grow: 1;
    }
</style>

<!-- TIN TỨC -->
<div class="news">
    <div class="news__title">Tin Tức</div>
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
                        <div class="news__category">Tin tức</div>
                    </div>
                    <div class="news__headline">
                        <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['tieu_de']) ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có tin tức nào.</p>
        <?php endif; ?>
    </div>
    <button class="more__btn" onclick="window.location.href='<?= BASE_URL ?>index.php?url=news'">
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

<!-- SCRIPT: Xử lý Tab Sản Phẩm (AJAX) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.product__tab-btn');
    const productGrid = document.getElementById('home-product-grid');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Nếu click vào tab đang active thì bỏ qua không load lại
            if (this.classList.contains('active')) return;

            // Đổi trạng thái hiển thị của Tab
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const tabType = this.getAttribute('data-tab');
            
            // Hiệu ứng mờ lưới sản phẩm khi đang tải
            productGrid.style.opacity = '0.4';

            // Gửi request ngầm xuống API
            fetch(`<?= BASE_URL ?>index.php?url=product/api_get_products_by_tab&tab=${tabType}`)
                .then(response => response.json())
                .then(res => {
                    productGrid.style.opacity = '1';
                    if (res.status === 'success') {
                        productGrid.innerHTML = res.html;
                    } else {
                        productGrid.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #777; font-size: 16px; margin: 40px 0;">${res.msg || 'Chưa có sản phẩm nào.'}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching tab products:', error);
                    productGrid.style.opacity = '1';
                    productGrid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red; margin: 40px 0;">Lỗi kết nối. Vui lòng thử lại sau.</p>';
                });
        });
    });
});
</script>

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
require_once __DIR__ . '/../includes/footer.php';
?>
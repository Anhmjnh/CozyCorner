<?php
// views/product/DanhMucSanPham.php

if (!isset($products)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=product");
    exit;
}

require_once __DIR__ . '/../../includes/header.php';

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COZY CORNER</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/DanhMucSanPham.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<!-- BANNER -->
<div class="banner__product">
    <img class="banner__img" src="<?= BASE_URL ?>assets/img/Banner-DanhMucSanPham.png" alt="Banner Danh Muc San Pham">
</div>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=product">Sản phẩm</a></li>
</ul>

<!-- CONTENT -->
<div class="content">
    <!-- Bộ lọc ( -->
    <div class="filter">
        <div class="filter__header">
            <img src="<?= BASE_URL ?>assets/icon/icon-boloc.svg" alt="icon bo loc">
            <div class="filter__title">Bộ lọc</div>
        </div>

        <div class="filter__section" style="display: none;"> 
            <div class="filter__label">Giá</div>
            <div class="filter__price">
                <input type="range" class="filter__range" min="0" max="2500000" value="1250000">
                <div class="filter__price-values">
                    <span class="filter__price-min">0đ</span>
                    <span>~</span>
                    <span class="filter__price-max">2.500.000đ</span>
                </div>
            </div>
        </div>

        <div class="filter__section">
            <div class="filter__label">Danh Mục Sản Phẩm</div>
            <ul class="filter__list" style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($all_categories as $cat): ?>
                    <li class="filter__item" style="margin-bottom: 10px;">
                        <input type="checkbox" id="cat_<?= $cat['id'] ?>" class="filter__checkbox cat-checkbox"
                            value="<?= htmlspecialchars($cat['ten_danh_muc']) ?>" onchange="updateFilter(this)"
                            <?= in_array($cat['ten_danh_muc'], $categories_filter) ? 'checked' : '' ?>
                            style="margin-right: 8px; cursor: pointer;">
                        <label for="cat_<?= $cat['id'] ?>" class="filter__label-text"
                            style="cursor: pointer;"><?= htmlspecialchars($cat['ten_danh_muc']) ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Bộ lọc mobile -->
    <input type="checkbox" class="filter__mobile-checked" id="filter__mobile-checkbox" hidden>

    <label for="filter__mobile-checkbox" class="filter__mobile-overlay"></label>

    <div class="filter__mobile">
        <label for="filter__mobile-checkbox">
            <img src="<?= BASE_URL ?>assets/icon/icon-close.svg" alt="icon close">
        </label>

        <div class="filter__mobile-section" style="display: none;">
            <div class="filter__label">Giá</div>
            <div class="filter__price">
                <input type="range" class="filter__range" min="0" max="2500000" value="1250000">
                <div class="filter__price-values">
                    <span class="filter__price-min">0đ</span>
                    <span>~</span>
                    <span class="filter__price-max">2.500.000đ</span>
                </div>
            </div>
        </div>

        <div class="filter__section">
            <div class="filter__label">Danh Mục Sản Phẩm</div>
            <ul class="filter__list" style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($all_categories as $cat): ?>
                    <li class="filter__item" style="margin-bottom: 10px;">
                        <input type="checkbox" id="m_cat_<?= $cat['id'] ?>" class="filter__checkbox cat-checkbox"
                            value="<?= htmlspecialchars($cat['ten_danh_muc']) ?>" onchange="updateFilter(this)"
                            <?= in_array($cat['ten_danh_muc'], $categories_filter) ? 'checked' : '' ?>
                            style="margin-right: 8px; cursor: pointer;">
                        <label for="m_cat_<?= $cat['id'] ?>" class="filter__label-text"
                            style="cursor: pointer;"><?= htmlspecialchars($cat['ten_danh_muc']) ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Sản phẩm  -->
    <div class="product">
        <div class="product__header">
            <span class="product__header-count">Hiển thị <?= $total ?> sản phẩm</span>
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="<?= BASE_URL ?>assets/icon/icon-sapxep.svg" alt="icon sắp xếp" style="width: 20px;">
                <select name="sort" onchange="updateFilter(this)"
                    style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; outline: none; font-family: inherit; font-weight: 600; cursor: pointer; color: #2c3e50; background-color: #f9f9f9;">
                    <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                    <option value="bestseller" <?= $sort == 'bestseller' ? 'selected' : '' ?>>Bán chạy</option>
                    <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                </select>
            </div>
            <label for="filter__mobile-checkbox" class="filter__mobile-header">
                <img src="<?= BASE_URL ?>assets/icon/icon-boloc.svg" alt="icon bo loc">
            </label>
        </div>

        <div class="product__list-items">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $row): ?>
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
                <p style="grid-column: 1 / -1; text-align: center; color: #7f8c8d; font-size: 16px; margin-top: 50px;">Không
                    tìm thấy sản phẩm nào phù hợp với bộ lọc!</p>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination"
                style="display: flex; justify-content: center; gap: 10px; margin-top: 40px; margin-bottom: 20px;">
                <?php
                $params = $_GET;
                for ($i = 1; $i <= $totalPages; $i++):
                    $params['page'] = $i;
                    $url = '?' . http_build_query($params);
                    ?>
                    <a href="<?= htmlspecialchars($url) ?>"
                        style="padding: 10px 18px; border: 1px solid #355F2E; border-radius: 5px; color: <?= $i == $page ? '#fff' : '#355F2E' ?>; background-color: <?= $i == $page ? '#355F2E' : 'transparent' ?>; text-decoration: none; font-weight: 600; transition: 0.3s;"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- LỢI ÍCH (LABEL2) -->
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

<script>
    function updateFilter(element) {
        const urlParams = new URLSearchParams(window.location.search);

        // Nếu thay đổi mục sắp xếp
        if (element.name === 'sort') {
            urlParams.set('sort', element.value);
            urlParams.set('page', 1); // Reset về trang 1
        }
        // Nếu tích chọn danh mục
        else if (element.classList.contains('cat-checkbox')) {
            const container = element.closest('.filter') || element.closest('.filter__mobile');
            const checked = container.querySelectorAll('.cat-checkbox:checked');

            urlParams.delete('categories[]');
            urlParams.delete('category');
            urlParams.set('page', 1); // Reset về trang 1

            checked.forEach(cb => {
                urlParams.append('categories[]', cb.value);
            });
        }

        window.location.href = window.location.pathname + '?' + urlParams.toString();
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
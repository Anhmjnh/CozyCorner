<?php
// views/product/ChiTietSanPham.php


if (!isset($product)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=product/detail&id=" . ($_GET['id'] ?? 0));
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<ul class="breadcrumb">

    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>index.php?url=product">Sản phẩm</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><?= htmlspecialchars($product['ten_sp'] ?? 'Chi tiết sản phẩm') ?></li>
</ul>

<style>
    .review {
        width: 100% !important;
    }


    @media (min-width: 481px) {
        .review {
            margin-top: 48px;
        }
    }

    /* Giữ khoảng cách gọn gàng trên điện thoại */
    @media (max-width: 480px) {
        .review {
            margin-top: 48px !important;
        }
    }

    /* 2. Giữ MÔ TẢ ở cột trái cân đối (Máy tính 75%, Điện thoại 100%) */
    @media (min-width: 481px) {
        .product__description {
            width: 75% !important;
            margin-top: 48px;
        }
    }

    @media (max-width: 480px) {
        .product__description {
            width: 100% !important;
            margin-top: 48px;
        }
    }

    /* 3. Sửa lỗi hiển thị Đánh giá trên điện thoại khi đưa vào Sidebar */
    @media (max-width: 480px) {
        .product__sidebar {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
        }

        /* Ẩn các phần trùng lặp của Desktop trên Mobile để không bị lặp tên, giá 2 lần */
        .product__sidebar>.product__title,
        .product__sidebar>.product__rating,
        .product__sidebar>.product__price,
        .product__sidebar>.product__actions-form {
            display: none !important;
        }
    }

    /* ---  LIGHTBOX PHÓNG TO ẢNH --- */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.85);
        justify-content: center;
        align-items: center;
    }

    .lightbox-content {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 90vh;
        animation-name: zoom;
        animation-duration: 0.4s;
    }

    .lightbox-close {
        position: absolute;
        top: 25px;
        right: 45px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .lightbox-close:hover,
    .lightbox-close:focus {
        color: #bbb;
        text-decoration: none;
    }

    /* ---  KHUNG ẢNH CHÍNH --- */
    .product__image {
        position: relative;
        cursor: zoom-in;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid #eee;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .product__image img {
        width: 100%;
        display: block;
        transition: transform 0.4s ease;
    }

    .product__image:hover img {
        transform: scale(1.05);
    }

    .zoom-icon {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.8);
        color: #333;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    .product__image:hover .zoom-icon {
        opacity: 1;
    }

    /* ---  MODAL THÔNG BÁO --- */
    .custom-notification-modal {
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

    .custom-notification-modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 30px;
        border: 1px solid #888;
        width: 95%;
        max-width: 400px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation-name: animatetop;
        animation-duration: 0.4s;
        text-align: center;
    }

    .custom-notification-modal-body i {
        display: block;
        font-size: 50px;
        margin-bottom: 20px;
    }

    .custom-notification-modal-body p {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 25px;
    }

    .custom-notification-modal-body .btn {
        padding: 12px 40px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        color: white;
    }

    .btn-success-modal {
        background-color: #28a745;
    }

    .btn-success-modal:hover {
        background-color: #218838;
    }

    .btn-error-modal {
        background-color: #dc3545;
    }

    .btn-error-modal:hover {
        background-color: #c82333;
    }

    /* Animation */
    @keyframes animatetop {
        from {
            transform: scale(0.5);
            opacity: 0
        }

        to {
            transform: scale(1);
            opacity: 1
        }
    }


    .product__quantity-value,
    .product__mobile-quantity-value {
        padding: 0 5px !important;
        text-align: center;
        transition: width 0.2s ease-out;
        box-sizing: border-box;
        height: 40px !important;
        font-weight: 400 !important;
        vertical-align: middle;
        margin: 0;
    }

    .product__quantity-btn,
    .product__mobile-quantity-btn {
        height: 40px !important;
        box-sizing: border-box;
        vertical-align: middle;
    }

    .product__cart:hover i,
    .product__mobile-cart:hover i {
        color: #fff !important;
        transition: color 0.3s ease;
    }
</style>
<?php if (!$product): ?>
    <p style="text-align: center; padding: 50px; font-size: 1.2rem;">Sản phẩm không tồn tại hoặc đã bị ẩn.</p>
    <?php require_once __DIR__ . '/../../includes/footer.php';
    exit; ?>
<?php endif; ?>

<?php $isPreOrder = ($product['so_luong_ton'] <= 0 || $product['trang_thai'] == 'HetHang'); ?>
<div class="product">
    <div class="product__left">
        <div class="product__gallery">
            <div class="product__image" id="product-image-container">
                <?php if ($product && $product['anh']): ?>
                    <img id="main-product-image" src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['anh']) ?>"
                        alt="<?= htmlspecialchars($product['ten_sp']) ?>">
                <?php else: ?>
                    <img id="main-product-image" src="<?= BASE_URL ?>assets/img/no-image.png" alt="Chưa có ảnh">
                <?php endif; ?>
                <div class="zoom-icon"><i class="fas fa-search-plus"></i></div>
            </div>

        </div>

        <div class="product__mobile-sidebar">
            <div class="product__mobile-title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

            <?php if ($total_reviews > 0): ?>
                <div class="product__mobile-rating">
                    <span class="product__mobile-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($avg_rating)): ?>
                                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star">
                            <?php else: ?>
                                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off"
                                    style="filter: grayscale(100%) opacity(30%);">
                            <?php endif; ?>
                        <?php endfor; ?>
                    </span>
                    <span class="product__mobile-reviews">(<?= $total_reviews ?> đánh giá)</span>
                </div>
            <?php endif; ?>

            <div class="product__mobile-price">
                <?php if ($product): ?>
                    <span
                        class="product__mobile-price-old"><?= $product['gia_cu'] > $product['gia'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                    <span class="product__mobile-price-new" id="mobile-price"><?= number_format($product['gia']) ?>đ</span>
                    <?php if ($product['gia_cu'] > $product['gia']): ?>
                        <span
                            class="product__mobile-discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="product__status" style="margin-top: 8px; margin-bottom: 12px;">
                <?php if ($isPreOrder): ?>
                    <span style="color: #F57F17; font-weight: bold;">
                        <i class="fas fa-clock"></i> Hàng Đặt Trước
                    </span>
                <?php else: ?>
                    <span style="color: #355F2E; font-weight: bold;">
                        <i class="fas fa-check-circle"></i> Còn hàng (<?= $product['so_luong_ton'] ?> sản phẩm)
                    </span>
                <?php endif; ?>
            </div>

            <form id="form-add-to-cart-mobile" class="product__mobile-actions-form">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="product__mobile-quantity">
                    <p class="product__mobile-label">Số lượng</p>
                    <button type="button" class="product__mobile-quantity-btn"
                        onclick="changeQty('mobile-quantity', -1)">−</button>
                    <input id="mobile-quantity" name="quantity" class="product__mobile-quantity-value" type="number"
                        value="1" min="1" <?= !$isPreOrder ? 'max="' . $product['so_luong_ton'] . '"' : '' ?>>
                    <button type="button" class="product__mobile-quantity-btn"
                        onclick="changeQty('mobile-quantity', 1)">+</button>
                </div>

                <div class="product__mobile-actions">
                    <button type="submit" name="action" value="buy_now" class="product__mobile-buy">
                        <?= $isPreOrder ? 'ĐẶT TRƯỚC NGAY' : 'MUA NGAY' ?>
                    </button>
                    <button type="submit" name="action" value="add_to_cart" class="product__mobile-cart">
                        <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                    </button>
                    <button type="button" class="product__mobile-cart js__add-to-compare"
                        data-id="<?= $product['id'] ?>" data-cat="<?= $product['category_id'] ?>"
                        title="So sánh sản phẩm này">
                        <i class="fas fa-balance-scale" style="font-size: 24px; color: #355F2E;"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="product__description">
            <div class="product__description-title">Mô Tả</div>
            <?php if ($product && !empty($product['mo_ta'])): ?>
                <div class="product__description-text" style="line-height: 1.7; font-size: 16px;">
                    <?= nl2br(htmlspecialchars($product['mo_ta'])) ?>
                </div>
            <?php else: ?>
                <p class="product__description-text">Chưa có mô tả cho sản phẩm này.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="product__sidebar">
        <div class="product__title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

        <?php if ($total_reviews > 0): ?>
            <div class="product__rating">
                <span class="product__stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= floor($avg_rating)): ?>
                            <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star">
                        <?php else: ?>
                            <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off"
                                style="filter: grayscale(100%) opacity(30%);">
                        <?php endif; ?>
                    <?php endfor; ?>
                </span>
                <span class="product__reviews">(<?= $total_reviews ?> đánh giá)</span>
            </div>
        <?php endif; ?>

        <div class="product__price">
            <?php if ($product): ?>
                <span
                    class="product__price-old"><?= $product['gia_cu'] > $product['gia'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                <span class="product__price-new" id="desktop-price"><?= number_format($product['gia']) ?>đ</span>
                <?php if ($product['gia_cu'] > $product['gia']): ?>
                    <span
                        class="product__discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="product__status" style="margin-top: 16px; margin-bottom: 16px;">
            <?php if ($isPreOrder): ?>
                <span style="color: #F57F17; font-weight: bold;">
                    <i class="fas fa-clock"></i> Hàng Đặt Trước 
                </span>
            <?php else: ?>
                <span style="color: #355F2E; font-weight: bold;">
                    <i class="fas fa-check-circle"></i> Còn hàng (<?= $product['so_luong_ton'] ?> sản phẩm)
                </span>
            <?php endif; ?>
        </div>

        <form id="form-add-to-cart-desktop" class="product__actions-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

            <div class="product__quantity">
                <p class="product__label">Số lượng</p>
                <button type="button" class="product__quantity-btn"
                    onclick="changeQty('desktop-quantity', -1)">−</button>
                <input id="desktop-quantity" name="quantity" class="product__quantity-value" type="number" value="1"
                    min="1" <?= !$isPreOrder ? 'max="' . $product['so_luong_ton'] . '"' : '' ?>>
                <button type="button" class="product__quantity-btn"
                    onclick="changeQty('desktop-quantity', 1)">+</button>
            </div>

            <div class="product__actions">
                <button type="submit" name="action" value="buy_now" class="product__buy">
                    <?= $isPreOrder ? 'ĐẶT TRƯỚC NGAY' : 'MUA NGAY' ?>
                </button>
                <button type="submit" name="action" value="add_to_cart" class="product__cart">
                    <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                </button>
                <button type="button" class="product__cart js__add-to-compare" data-id="<?= $product['id'] ?>"
                    data-cat="<?= $product['category_id'] ?>" title="So sánh sản phẩm này">
                    <i class="fas fa-balance-scale" style="font-size: 24px; color: #355F2E;"></i>
                </button>
            </div>
        </form>

        <div class="review">
            <div class="review__title">Đánh Giá</div>

            <div class="review__total">
                <div class="review__summary">
                    <div class="review__rating">
                        <span class="review__score"><?= $avg_rating ?></span>
                        <img class="review__stars" src="<?= BASE_URL ?>assets/icon/icon-sao-to.svg"
                            alt="Big Review Stars">
                    </div>
                    <div class="review__count">(<?= $total_reviews ?> đánh giá)</div>
                    <?php if ($is_logged_in): ?>
                        <button class="review__button js__rating-btn">VIẾT ĐÁNH GIÁ</button>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>view/user/DangNhap.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>"
                            class="review__button" style="text-decoration: none;">Đăng nhập để đánh giá</a>
                    <?php endif; ?>
                </div>

                <div class="review__progress">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <div class="review__progress-item">
                            <span class="review__progress-stars"><?= $i ?></span>
                            <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="Review Stars">
                            <div class="review__progress-bar">
                                <div class="review__progress-fill"
                                    style="width: <?= $total_reviews > 0 ? ($rating_counts[$i] / $total_reviews) * 100 : 0 ?>%;">
                                </div>
                            </div>
                            <span class="review__progress-count"><?= $rating_counts[$i] ?> đánh giá</span>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="review__list">
                <?php if (empty($reviews)): ?>
                    <p style="text-align: center; color: #888; padding: 30px 0;">Chưa có đánh giá nào cho sản phẩm này.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $index => $review): ?>
                        <div class="review__item js__review-item" <?= $index >= 3 ? 'style="display: none;"' : '' ?>>
                            <div class="review__author">
                                <div class="review__avatar"
                                    style="padding: 0; overflow: hidden; background: #F5F5F5; display: flex; align-items: center; justify-content: center;">
                                    <img style="width: 100%; height: 100%; object-fit: cover;"
                                        src="<?= !empty($review['avatar']) ? BASE_URL . htmlspecialchars($review['avatar']) : BASE_URL . 'assets/icon/icon-user-black.svg' ?>"
                                        alt="user rating">
                                </div>
                                <div>
                                    <p class="review__name"><?= htmlspecialchars($review['ho_ten']) ?></p>
                                    <p class="review__date"><?= date('d/m/Y', strtotime($review['created_at'])) ?></p>
                                </div>
                            </div>
                            <div class="review__content">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <?php if ($i < $review['rating']): ?>
                                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star">
                                    <?php else: ?>
                                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off"
                                            style="filter: grayscale(100%) opacity(30%);">
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <p class="review__text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>

                                <?php if ($is_logged_in && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                                    <div style="margin-top: 10px;">
                                        <button
                                            onclick="editReview(<?= $review['id'] ?>, <?= $review['rating'] ?>, '<?= htmlspecialchars(addslashes($review['comment'])) ?>')"
                                            style="background: none; border: none; color: #2e5932; cursor: pointer; font-size: 13px; font-weight: bold; padding: 0; margin-right: 15px;"><i
                                                class="fas fa-edit"></i> Sửa</button>
                                        <button onclick="deleteReview(<?= $review['id'] ?>)"
                                            style="background: none; border: none; color: #2e5932; cursor: pointer; font-size: 13px; font-weight: bold; padding: 0;"><i
                                                class="fas fa-trash"></i> Xóa</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if (count($reviews) > 3): // Chỉ hiện nút khi có nhiều hơn 3 đánh giá ?>
                <button class="review__more js__load-more-reviews">
                    XEM THÊM<img src="<?= BASE_URL ?>assets/icon/icon-down-green.svg" alt="icon down">
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="product__similar">
    <div class="product__similar-title">Sản Phẩm Tương Tự</div>

    <div class="product__cards">
        <?php if (!empty($similar_products)): ?>
            <?php foreach ($similar_products as $item): 
                $isPreOrder = ($item['so_luong_ton'] <= 0 || $item['trang_thai'] == 'HetHang');
            ?>
                <div class="product__card" style="position: relative;">
                    <?php if ($isPreOrder): ?>
                        <div style="position: absolute; top: 10px; left: 10px; background: #F57F17; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 2;">HÀNG ĐẶT TRƯỚC</div>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>index.php?url=product/detail&id=<?= $item['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>"
                            alt="<?= htmlspecialchars($item['ten_sp']) ?>" class="product__card-image">
                    </a>
                    <div class="product__card-text">
                        <p class="product__card-name">
                            <?= htmlspecialchars($item['ten_sp']) ?> <br>
                            <span class="product__card-price">
                                <?= number_format($item['gia']) ?>đ
                                <?php if ($item['gia_cu'] > 0): ?>
                                    <span class="product__card-old-price"><?= number_format($item['gia_cu']) ?>đ</span>
                                <?php endif; ?>
                            </span>
                        </p>
                        <a href="javascript:void(0)" class="product__card-cart js__add-to-cart"
                            data-product-id="<?= $item['id'] ?>" title="<?= $isPreOrder ? 'Đặt hàng trước' : 'Thêm vào giỏ' ?>">
                            <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm tương tự.</p>
        <?php endif; ?>
    </div>
</div>

<!-- GỢI Ý SẢN PHẨM MUA KÈM -->
<div class="product__similar" style="margin-top: 48px;">
    <div class="product__similar-title">Gợi Ý Sản Phẩm Mua Kèm</div>

    <div class="product__cards">
        <?php if (!empty($bought_together_products)): ?>
            <?php foreach ($bought_together_products as $item): 
                $isPreOrder = ($item['so_luong_ton'] <= 0 || $item['trang_thai'] == 'HetHang');
            ?>
                <div class="product__card" style="position: relative;">
                    <?php if ($isPreOrder): ?>
                        <div style="position: absolute; top: 10px; left: 10px; background: #F57F17; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 2;">HÀNG ĐẶT TRƯỚC</div>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>index.php?url=product/detail&id=<?= $item['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>"
                            alt="<?= htmlspecialchars($item['ten_sp']) ?>" class="product__card-image">
                    </a>
                    <div class="product__card-text">
                        <p class="product__card-name">
                            <?= htmlspecialchars($item['ten_sp']) ?> <br>
                            <span class="product__card-price">
                                <?= number_format($item['gia']) ?>đ
                                <?php if ($item['gia_cu'] > 0): ?>
                                    <span class="product__card-old-price"><?= number_format($item['gia_cu']) ?>đ</span>
                                <?php endif; ?>
                            </span>
                        </p>
                        <a href="javascript:void(0)" class="product__card-cart js__add-to-cart"
                            data-product-id="<?= $item['id'] ?>" title="<?= $isPreOrder ? 'Đặt hàng trước' : 'Thêm vào giỏ' ?>">
                            <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có gợi ý mua kèm.</p>
        <?php endif; ?>
    </div>
</div>

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

<div class="review__modal js__rating-modal">
    <div class="review__modal-content js__rating-content">
        <div class="review__modal-title">Đánh Giá</div>

        <?php if ($is_logged_in && $user_info): ?>
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 24px;">
                <img src="<?= !empty($user_info['avatar']) ? BASE_URL . htmlspecialchars($user_info['avatar']) : BASE_URL . 'assets/icon/icon-user-black.svg' ?>"
                    alt="avatar"
                    style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #355F2E;">
                <strong style="font-size: 20px; color: #333;"><?= htmlspecialchars($user_info['ho_ten']) ?></strong>
            </div>
        <?php endif; ?>

        <form id="review-form" class="review__modal-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="review_id" id="review-id-input" value="">
            <input type="hidden" name="rating" id="review-rating-input" value="5">

            <div class="review__modal-stars" id="review-star-selector">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <img class="review__modal-star" data-value="<?= $i ?>" src="<?= BASE_URL ?>assets/icon/icon-sao-to.svg"
                        alt="icon star-on">
                <?php endfor; ?>
            </div>

            <textarea name="comment" class="review__modal-textarea" placeholder="Nội dung đánh giá của bạn..."
                required></textarea>

            <button type="submit" class="review__modal-button">GỬI</button>
        </form>
    </div>
</div>

<div id="notificationModal" class="custom-notification-modal">
    <div class="custom-notification-modal-content">
        <div class="custom-notification-modal-body">
            <i id="notificationIcon" class="fas"></i>
            <p id="notificationMessage"></p>
            <button id="notificationCloseBtn" class="btn">OK</button>
        </div>
    </div>
</div>


<div id="imageLightbox" class="lightbox">
    <span class="lightbox-close" id="closeLightbox">&times;</span>
    <img class="lightbox-content" id="lightboxImage">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productPrice = <?= $product['gia'] ?? 0 ?>;

        // SCRIPT CHO LIGHTBOX 
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        const mainImgContainer = document.getElementById('product-image-container');
        const closeBtn = document.getElementById('closeLightbox');

        if (mainImgContainer) {
            mainImgContainer.addEventListener('click', function () {
                lightbox.style.display = 'flex';
                lightboxImg.src = document.getElementById('main-product-image').src;
            });
        }

        const closeLightbox = () => lightbox.style.display = 'none';
        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (lightbox) {
            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox) closeLightbox();
            });
        }
        // --- TỰ ĐỘNG CĂN BẰNG MÔ TẢ VÀ ĐÁNH GIÁ TRÊN MỌI MÀN HÌNH ---
        function alignReviewAndDescription() {

            if (window.innerWidth <= 480) {
                document.querySelector('.review').style.marginTop = '48px';
                document.querySelector('.product__description').style.marginTop = '48px';
                return;
            }

            const review = document.querySelector('.review');
            const description = document.querySelector('.product__description');

            if (review && description) {

                review.style.marginTop = '48px';
                description.style.marginTop = '48px';


                const descTop = description.getBoundingClientRect().top;
                const reviewTop = review.getBoundingClientRect().top;


                if (descTop > reviewTop) {
                    const diff = descTop - reviewTop;
                    review.style.marginTop = (48 + diff) + 'px';
                } else if (reviewTop > descTop) {
                    const diff = reviewTop - descTop;
                    description.style.marginTop = (48 + diff) + 'px';
                }
            }
        }

        // Chạy thước đo ngay khi web vừa load xong ảnh
        window.addEventListener('load', alignReviewAndDescription);

        // Tự động đo lại mỗi khi người dùng kéo, thu phóng kích thước cửa sổ trình duyệt
        window.addEventListener('resize', alignReviewAndDescription);

        // LOGIC TĂNG GIẢM SỐ LƯỢNG 
        window.changeQty = function (inputId, amount) {
            const qtyInput = document.getElementById(inputId);
            if (!qtyInput) return;
            let currentValue = parseInt(qtyInput.value);
            let newValue = currentValue + amount;
            const max = parseInt(qtyInput.max);
            if (newValue < 1)
                newValue = 1;
            if (!isNaN(max) && newValue > max)
                newValue = max;
            qtyInput.value = newValue;
            updatePrice(inputId);

            // Hiệu ứng mở rộng ô nhập theo số lượng chữ số
            updateInputWidth(qtyInput);
        }

        // Hàm cập nhật độ rộng ô input
        function updateInputWidth(inputEl) {
            if (inputEl) {
                const numLength = inputEl.value.toString().length;
                inputEl.style.width = (35 + numLength * 10) + 'px';
            }
        }


        function setupManualInput(inputId) {
            const inputEl = document.getElementById(inputId);
            if (!inputEl) return;

            inputEl.addEventListener('keydown', function (e) {
                if (['e', 'E', '+', '-', '.', ','].includes(e.key)) {
                    e.preventDefault();
                }
            });

            inputEl.addEventListener('input', function () {
                if (this.value !== '') {
                    let val = parseInt(this.value);
                    const max = parseInt(this.getAttribute('max'));

                    if (val > max) {
                        this.value = max;


                        setTimeout(() => {
                            this.setSelectionRange(this.value.length, this.value.length);
                        }, 0);
                    }
                }

                updateInputWidth(this);
                updatePrice(inputId);
            });


            inputEl.addEventListener('blur', function () {
                let val = parseInt(this.value);
                if (isNaN(val) || val < 1) {
                    this.value = 1; // Nếu để trống hoặc nhập số < 1, tự đưa về 1
                }
                updateInputWidth(this);
                updatePrice(inputId);
            });
        }

        // --- LOGIC CẬP NHẬT GIÁ ---
        window.updatePrice = function (inputId) {
            const qtyInput = document.getElementById(inputId);
            const priceId = inputId.includes('mobile') ? 'mobile-price' : 'desktop-price';
            const priceEl = document.getElementById(priceId);
            if (qtyInput && priceEl) {
                const qty = parseInt(qtyInput.value) || 1;
                const newPrice = productPrice * qty;
                priceEl.innerText = newPrice.toLocaleString('vi-VN') + 'đ';
            }
        }

        // --- LOGIC MODAL THÔNG BÁO ---
        function showNotification(message, isSuccess) {
            const modal = document.getElementById('notificationModal');
            const icon = document.getElementById('notificationIcon');
            const msg = document.getElementById('notificationMessage');
            const btn = document.getElementById('notificationCloseBtn');
            msg.innerText = message;
            icon.className = 'fas';
            btn.className = 'btn';
            if (isSuccess) {
                icon.classList.add('fa-check-circle');
                icon.style.color = '#28a745';
                btn.classList.add('btn-success-modal');
            } else {
                icon.classList.add('fa-times-circle');
                icon.style.color = '#dc3545';
                btn.classList.add('btn-error-modal');
            }
            modal.style.display = 'flex';
            const closeModal = () => {
                modal.style.display = 'none';
                if (isSuccess) window.location.reload();
            };
            btn.onclick = closeModal;
            modal.onclick = (event) => { if (event.target === modal) closeModal(); };
            document.addEventListener('keydown', (event) => { if (event.key === "Escape") closeModal(); }, { once: true });
        }

        // --- LOGIC MODAL ĐÁNH GIÁ ---
        const ratingBtn = document.querySelector('.js__rating-btn');
        const modalRating = document.querySelector('.js__rating-modal');
        const modalRatingContent = document.querySelector('.js__rating-content');

        window.openReviewModal = function (reviewId = '', rating = 5, comment = '') {
            document.getElementById('review-id-input').value = reviewId;
            document.getElementById('review-rating-input').value = rating;
            document.querySelector('.review__modal-textarea').value = comment;

            const starSelector = document.getElementById('review-star-selector');
            if (starSelector) {
                starSelector.querySelectorAll('.review__modal-star').forEach((star, index) => {
                    star.src = index < rating ? '<?= BASE_URL ?>assets/icon/icon-sao-to.svg' : '<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg';
                });
            }
            if (modalRating) modalRating.classList.add('open');
        }

        if (ratingBtn) ratingBtn.addEventListener('click', () => openReviewModal());
        if (modalRating) modalRating.addEventListener('click', () => modalRating.classList.remove('open'));
        if (modalRatingContent) modalRatingContent.addEventListener('click', e => e.stopPropagation());

        const starSelector = document.getElementById('review-star-selector');
        if (starSelector) {
            starSelector.addEventListener('click', function (e) {
                if (e.target.classList.contains('review__modal-star')) {
                    const ratingValue = e.target.dataset.value;
                    document.getElementById('review-rating-input').value = ratingValue;
                    starSelector.querySelectorAll('.review__modal-star').forEach((star, index) => {
                        star.src = index < ratingValue ? '<?= BASE_URL ?>assets/icon/icon-sao-to.svg' : '<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg';
                    });
                }
            });
        }

        const reviewForm = document.getElementById('review-form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const reviewId = document.getElementById('review-id-input').value;
                const actionUrl = reviewId ? '<?= BASE_URL ?>index.php?url=review/update' : '<?= BASE_URL ?>index.php?url=review/add';

                fetch(actionUrl, {
                    method: 'POST',
                    body: new FormData(reviewForm)
                })
                    .then(res => res.json())
                    .then(res => {
                        const isSuccess = res.status === 'success';
                        if (isSuccess) modalRating.classList.remove('open');
                        showNotification(res.msg, isSuccess);
                    })
                    .catch(() => showNotification('Lỗi kết nối, không thể gửi đánh giá.', false));
            });
        }

        window.editReview = function (id, rating, comment) {
            openReviewModal(id, rating, comment);
        };

        window.deleteReview = function (id) {
            if (confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')) {
                fetch('<?= BASE_URL ?>index.php?url=review/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ review_id: id })
                })
                    .then(res => res.json())
                    .then(res => {
                        showNotification(res.msg, res.status === 'success');
                    })
                    .catch(() => showNotification('Lỗi kết nối, không thể xóa đánh giá.', false));
            }
        };

        // --- LOGIC XEM THÊM / THU GỌN ĐÁNH GIÁ ---
        const loadMoreBtn = document.querySelector('.js__load-more-reviews');
        if (loadMoreBtn) {
            // Khởi tạo trạng thái mặc định là chưa mở rộng hết
            loadMoreBtn.dataset.expanded = 'false';

            loadMoreBtn.addEventListener('click', function () {
                const isExpanded = this.dataset.expanded === 'true';

                if (isExpanded) {
                    // 1. NẾU ĐANG MỞ RỘNG -> THU GỌN LẠI
                    const allReviews = document.querySelectorAll('.js__review-item');
                    // Ẩn tất cả các đánh giá từ vị trí thứ 4 trở đi (index 3)
                    for (let i = 3; i < allReviews.length; i++) {
                        allReviews[i].style.display = 'none';
                    }
                    // Trả lại text XEM THÊM và mũi tên hướng xuống
                    this.innerHTML = 'XEM THÊM<img src="<?= BASE_URL ?>assets/icon/icon-down-green.svg" alt="icon down">';
                    this.dataset.expanded = 'false';

                    // Cuộn màn hình nhẹ lên phần đầu của đánh giá để user không bị lạc
                    document.querySelector('.review').scrollIntoView({ behavior: 'smooth', block: 'start' });

                } else {
                    // 2. NẾU ĐANG THU GỌN -> HIỂN THỊ THÊM 3 ĐÁNH GIÁ
                    const hiddenReviews = document.querySelectorAll('.js__review-item[style*="display: none"]');
                    for (let i = 0; i < 3 && i < hiddenReviews.length; i++) {
                        hiddenReviews[i].style.display = 'block';
                    }

                    // Kiểm tra xem sau khi mở, còn cái nào bị ẩn không?
                    const remainingHidden = document.querySelectorAll('.js__review-item[style*="display: none"]').length;

                    if (remainingHidden === 0) {
                        // Nếu đã hiển thị hết -> Đổi nút thành THU GỌN và xoay ngược mũi tên lên 180 độ
                        this.innerHTML = 'THU GỌN<img src="<?= BASE_URL ?>assets/icon/icon-down-green.svg" alt="icon up" style="transform: rotate(180deg); transition: 0.3s;">';
                        this.dataset.expanded = 'true';
                    }
                }
            });
        }

        // --- LOGIC THÊM VÀO GIỎ HÀNG ---
        function handleAddToCart(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const action = event.submitter.value;
            const productId = form.querySelector('input[name="product_id"]').value;
            const qtyInput = form.querySelector('input[name="quantity"]');
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);

            fetch('<?= BASE_URL ?>index.php?url=cart/add', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        if (action === 'buy_now') {
                            window.location.href = '<?= BASE_URL ?>index.php?url=order/checkout';
                        } else {
                            // Gọi hàm vẽ lại HTML giỏ hàng từ cart.js và mở sidebar
                            if (typeof window.renderCart === 'function') {
                                window.renderCart(res);
                            }
                            const modalCart = document.querySelector('.js__cart-modal');
                            if (modalCart) modalCart.classList.add('open');
                        }
                    } else {
                        alert(res.msg || 'Thêm vào giỏ hàng thất bại!');
                    }
                })
                .catch(() => alert('Lỗi kết nối, vui lòng thử lại sau.'));
        }

        document.getElementById('form-add-to-cart-desktop').addEventListener('submit', handleAddToCart);
        document.getElementById('form-add-to-cart-mobile').addEventListener('submit', handleAddToCart);

        // Khởi tạo kích thước chuẩn cho ô input ngay khi vừa load trang
        updateInputWidth(document.getElementById('desktop-quantity'));
        updateInputWidth(document.getElementById('mobile-quantity'));

        // Kích hoạt chức năng nhập tay
        setupManualInput('desktop-quantity');
        setupManualInput('mobile-quantity');

        // --- LOGIC THÊM VÀO SO SÁNH ---
        document.querySelectorAll('.js__add-to-compare').forEach(btn => {
            btn.addEventListener('click', function () {
                const pid = this.dataset.id;
                const catid = this.dataset.cat;
                fetch('<?= BASE_URL ?>index.php?url=product/api_compare_add', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: pid, category_id: catid })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'conflict') {
                            // Xử lý xung đột danh mục cực thông minh
                            if (confirm(data.msg)) {
                                fetch('<?= BASE_URL ?>index.php?url=product/api_compare_add', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ product_id: pid, category_id: catid, force_clear: true })
                                }).then(() => window.location.href = '<?= BASE_URL ?>index.php?url=product/compare');
                            }
                        } else if (data.status === 'success') {
                            window.location.href = '<?= BASE_URL ?>index.php?url=product/compare';
                        }
                    });
            });
        });
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
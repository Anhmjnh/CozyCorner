<?php
// views/product/ChiTietSanPham.php

// Nếu truy cập trực tiếp file này thay vì qua MVC, tự động Redirect về Router chuẩn
if (!isset($product)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=product/detail&id=" . ($_GET['id'] ?? 0));
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php">Sản phẩm</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><?= htmlspecialchars($product['ten_sp'] ?? 'Chi tiết sản phẩm') ?></li>
</ul>

<style>
    /* --- STYLES CHO MODAL THÔNG BÁO --- */
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

    .btn-success-modal { background-color: #28a745; }
    .btn-success-modal:hover { background-color: #218838; }
    .btn-error-modal { background-color: #dc3545; }
    .btn-error-modal:hover { background-color: #c82333; }

    /* Animation */
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
<?php if (!$product): ?>
    <p style="text-align: center; padding: 50px; font-size: 1.2rem;">Sản phẩm không tồn tại hoặc đã bị ẩn.</p>
    <?php require_once __DIR__ . '/../../includes/footer.php';
    exit; // Dừng không hiển thị phần còn lại ?>
<?php endif; ?>

<!-- CONTENT -->
<div class="product">
    <!-- LEFT -->
    <div class="product__left">
        <!-- Gallery -->
        <div class="product__gallery">
            <div class="product__image">
                <?php if ($product && $product['anh']): ?>
                    <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['anh']) ?>"
                        alt="<?= htmlspecialchars($product['ten_sp']) ?>">
                <?php else: ?>
                    <img src="<?= BASE_URL ?>assets/img/no-image.png" alt="Chưa có ảnh">
                <?php endif; ?>
            </div>
            <div class="product__thumbnails">
                <!-- Hiện tại chỉ 1 ảnh chính, sau này có thể thêm nhiều ảnh thumbnail từ DB -->
                <?php if ($product && $product['anh']): ?>
                    <img class="product__thumbnail product__thumbnail--active"
                        src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['anh']) ?>" alt="Thumbnail">
                <?php endif; ?>
            </div>
        </div>

        <!-- SIDEBAR__MOBILE -->
        <div class="product__mobile-sidebar">
            <div class="product__mobile-title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

            <?php if ($total_reviews > 0): ?>
                <div class="product__mobile-rating">
                    <span class="product__mobile-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($avg_rating)): ?>
                                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star">
                            <?php else: ?>
                                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off" style="filter: grayscale(100%) opacity(30%);">
                            <?php endif; ?>
                        <?php endfor; ?>
                    </span>
                    <span class="product__mobile-reviews">(<?= $total_reviews ?> đánh giá)</span>
                </div>
            <?php endif; ?>

            <div class="product__mobile-price">
                <?php if ($product): ?>
                    <span
                        class="product__mobile-price-old"><?= $product['gia_cu'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                    <span class="product__mobile-price-new" id="mobile-price"><?= number_format($product['gia']) ?>đ</span>
                    <?php if ($product['gia_cu'] > $product['gia']): ?>
                        <span
                            class="product__mobile-discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Các tùy chọn màu sắc, kích thước này là giao diện tĩnh, chưa có logic -->
            <div class="product__mobile-options">
                <div class="product__mobile-colors">
                    <p class="product__mobile-label">Màu</p>
                    <button class="product__mobile-color product__mobile-color--white"></button>
                    <button class="product__mobile-color product__mobile-color--green"></button>
                    <button class="product__mobile-color product__mobile-color--orange"></button>
                </div>

                <div class="product__mobile-sizes">
                    <p class="product__mobile-label">Kích thước</p>
                    <button class="product__mobile-size">20cm</button>
                    <button class="product__mobile-size">24cm</button>
                    <button class="product__mobile-size">28cm</button>
                </div>

                <!-- Form thêm vào giỏ hàng -->
                <form id="form-add-to-cart-mobile" class="product__mobile-actions-form">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="product__mobile-quantity">
                        <p class="product__mobile-label">Số lượng</p>
                        <?php if ($product['so_luong_ton'] > 0): ?>
                            <button type="button" class="product__mobile-quantity-btn"
                                onclick="this.nextElementSibling.stepDown(); updatePrice('mobile-quantity', 'mobile-price')">−</button>
                            <input id="mobile-quantity" name="quantity" class="product__mobile-quantity-value" type="number"
                                value="1" min="1" max="<?= $product['so_luong_ton'] ?>" readonly>
                            <button type="button" class="product__mobile-quantity-btn"
                                onclick="this.previousElementSibling.stepUp(); updatePrice('mobile-quantity', 'mobile-price')">+</button>
                        <?php else: ?>
                            <span style="color: #e74c3c; font-weight: bold; font-size: 16px;">Hết hàng</span>
                        <?php endif; ?>
                    </div>
            </div>

            <div class="product__mobile-actions">
                <?php if ($product['so_luong_ton'] > 0): ?>
                    <button type="submit" name="action" value="buy_now" class="product__mobile-buy">MUA NGAY</button>
                    <button type="submit" name="action" value="add_to_cart" class="product__mobile-cart">
                        <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                    </button>
                <?php else: ?>
                    <button type="button" disabled class="product__mobile-buy" style="background: #ccc; cursor: not-allowed; width: 100%;">HẾT HÀNG</button>
                <?php endif; ?>
            </div>
            </form>
        </div>

        <!-- Mô Tả Sản Phẩm -->
        <div class="product__description">
            <div class="product__description-title">Mô Tả</div>
            <?php if ($product && $product['mo_ta']): ?>
                <p class="product__description-text">
                    <?= nl2br(htmlspecialchars($product['mo_ta'])) ?>
                </p>
            <?php else: ?>
                <p class="product__description-text">Chưa có mô tả cho sản phẩm này.</p>
            <?php endif; ?>

            <!-- Các phần mô tả chi tiết khác giữ nguyên tĩnh hoặc thêm từ DB nếu cần -->
            <div class="product__description-subtitle">• Thiết kế tiện dụng</div>
            <p class="product__description-text">
                Sản phẩm được thiết kế đơn giản nhưng tiện lợi, dễ sử dụng cho mọi gia đình.
            </p>
        </div>

        <!-- Đánh Giá -->
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

            <!-- Danh sách đánh giá -->
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
                                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off" style="filter: grayscale(100%) opacity(30%);">
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <p class="review__text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
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

    <!-- SIDEBAR -->
    <div class="product__sidebar">
        <div class="product__title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

        <?php if ($total_reviews > 0): ?>
            <div class="product__rating">
                <span class="product__stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= floor($avg_rating)): ?>
                            <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star">
                        <?php else: ?>
                            <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="star off" style="filter: grayscale(100%) opacity(30%);">
                        <?php endif; ?>
                    <?php endfor; ?>
                </span>
                <span class="product__reviews">(<?= $total_reviews ?> đánh giá)</span>
            </div>
        <?php endif; ?>

        <div class="product__price">
            <?php if ($product): ?>
                <span
                    class="product__price-old"><?= $product['gia_cu'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                <span class="product__price-new" id="desktop-price"><?= number_format($product['gia']) ?>đ</span>
                <?php if ($product['gia_cu'] > $product['gia']): ?>
                    <span
                        class="product__discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Form thêm vào giỏ hàng -->
        <form id="form-add-to-cart-desktop" class="product__actions-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

            <!-- Các tùy chọn màu sắc, kích thước này là giao diện tĩnh, chưa có logic -->
            <div class="product__options">
                <div class="product__colors">
                    <p class="product__label">Màu</p>
                    <button type="button" class="product__color product__color--white"></button>
                    <button type="button" class="product__color product__color--green"></button>
                    <button type="button" class="product__color product__color--orange"></button>
                </div>

                <div class="product__sizes">
                    <p class="product__label">Kích thước</p>
                    <button type="button" class="product__size">20cm</button>
                    <button type="button" class="product__size">24cm</button>
                    <button type="button" class="product__size">28cm</button>
                </div>

                <div class="product__quantity">
                    <p class="product__label">Số lượng</p>
                    <?php if ($product['so_luong_ton'] > 0): ?>
                        <button type="button" class="product__quantity-btn"
                            onclick="this.nextElementSibling.stepDown(); updatePrice('desktop-quantity', 'desktop-price')">−</button>
                        <input id="desktop-quantity" name="quantity" class="product__quantity-value" type="number" value="1"
                            min="1" max="<?= $product['so_luong_ton'] ?>" readonly>
                        <button type="button" class="product__quantity-btn"
                            onclick="this.previousElementSibling.stepUp(); updatePrice('desktop-quantity', 'desktop-price')">+</button>
                    <?php else: ?>
                        <span style="color: #e74c3c; font-weight: bold; font-size: 16px;">Hết hàng</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="product__actions">
                <?php if ($product['so_luong_ton'] > 0): ?>
                    <button type="submit" name="action" value="buy_now" class="product__buy">MUA NGAY</button>
                    <button type="submit" name="action" value="add_to_cart" class="product__cart">
                        <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                    </button>
                <?php else: ?>
                    <button type="button" disabled class="product__buy" style="background: #ccc; cursor: not-allowed; width: 100%;">HẾT HÀNG</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- SẢN PHẨM TƯƠNG TỰ -->
<div class="product__similar">
    <div class="product__similar-title">Sản Phẩm Tương Tự</div>

    <div class="product__cards">
        <?php if (!empty($similar_products)): ?>
            <?php foreach ($similar_products as $item): ?>
                <div class="product__card">
                    <a href="<?= BASE_URL ?>view/product/ChiTietSanPham.php?id=<?= $item['id'] ?>">
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
                        <?php if ($item['so_luong_ton'] > 0): ?>
                            <a href="javascript:void(0)" class="product__card-cart js__add-to-cart"
                                data-product-id="<?= $item['id'] ?>">
                                <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                            </a>
                        <?php else: ?>
                            <span class="product__card-cart" style="border-color: #ccc; background-color: #f5f5f5; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; color: #999; text-decoration: none;" title="Hết hàng">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có sản phẩm tương tự.</p>
        <?php endif; ?>
    </div>
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

<!-- Form Modal Đánh Giá -->
<div class="review__modal js__rating-modal">
    <div class="review__modal-content js__rating-content">
        <div class="review__modal-title">Đánh Giá</div>
        
        <?php if ($is_logged_in && $user_info): ?>
            <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 24px;">
                <img src="<?= !empty($user_info['avatar']) ? BASE_URL . htmlspecialchars($user_info['avatar']) : BASE_URL . 'assets/icon/icon-user-black.svg' ?>" alt="avatar" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #355F2E;">
                <strong style="font-size: 20px; color: #333;"><?= htmlspecialchars($user_info['ho_ten']) ?></strong>
            </div>
        <?php endif; ?>

        <form id="review-form" class="review__modal-form">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
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

<!-- Custom Notification Modal -->
<div id="notificationModal" class="custom-notification-modal">
    <div class="custom-notification-modal-content">
        <div class="custom-notification-modal-body">
            <i id="notificationIcon" class="fas"></i>
            <p id="notificationMessage"></p>
            <button id="notificationCloseBtn" class="btn">OK</button>
        </div>
    </div>
</div>


<a href="javascript:void(0)" id="hidden-cart-trigger" class="js__add-to-cart" style="display:none;"
    data-product-id="<?= $product['id'] ?>"></a>

<!-- SCRIPT CHUNG CHO TRANG -->
<script>
    // --- LOGIC MODAL THÔNG BÁO TÙY CHỈNH ---
    function showNotification(message, isSuccess) {
        const modal = document.getElementById('notificationModal');
        const icon = document.getElementById('notificationIcon');
        const msg = document.getElementById('notificationMessage');
        const btn = document.getElementById('notificationCloseBtn');

        msg.innerText = message;

        // Xóa các class cũ để reset
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
            if (isSuccess) {
                window.location.reload(); // Tải lại trang chỉ khi thành công
            }
        };

        btn.onclick = closeModal;

        // Đóng modal khi click ra ngoài
        modal.onclick = function (event) {
            if (event.target === modal) {
                closeModal();
            }
        }

        // Đóng modal khi nhấn phím Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        });
    }

    // Cập nhật giá theo số lượng
    const productPrice = <?= $product['gia'] ?? 0 ?>;

    function updatePrice(inputId, priceId) {
        const qtyInput = document.getElementById(inputId);
        const priceEl = document.getElementById(priceId);
        if (qtyInput && priceEl) {
            const qty = parseInt(qtyInput.value) || 1;
            const newPrice = productPrice * qty;
            priceEl.innerText = newPrice.toLocaleString('vi-VN') + 'đ';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        // --- LOGIC MODAL ĐÁNH GIÁ ---
        const ratingBtn = document.querySelector('.js__rating-btn');
        const modalRating = document.querySelector('.js__rating-modal');
        const modalRatingContent = document.querySelector('.js__rating-content');
        const reviewForm = document.getElementById('review-form');
        const starSelector = document.getElementById('review-star-selector');
        const ratingInput = document.getElementById('review-rating-input');

        if (ratingBtn) {
            ratingBtn.addEventListener('click', () => modalRating.classList.add('open'));
        }
        if (modalRating) {
            modalRating.addEventListener('click', () => modalRating.classList.remove('open'));
        }
        if (modalRatingContent) {
            modalRatingContent.addEventListener('click', e => e.stopPropagation());
        }

        // Star rating logic
        if (starSelector) {
            const stars = starSelector.querySelectorAll('.review__modal-star');
            starSelector.addEventListener('click', function (e) {
                if (e.target.classList.contains('review__modal-star')) {
                    const ratingValue = e.target.dataset.value;
                    ratingInput.value = ratingValue;
                    stars.forEach((star, index) => {
                        if (index < ratingValue) {
                            star.src = '<?= BASE_URL ?>assets/icon/icon-sao-to.svg';
                        } else {
                            star.src = '<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg';
                        }
                    });
                }
            });
        }

        // AJAX Submit Review
        if (reviewForm) {
            reviewForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(reviewForm);
                fetch('<?= BASE_URL ?>index.php?url=review/add', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(res => {
                        const isSuccess = res.status === 'success';
                        if (isSuccess) {
                            modalRating.classList.remove('open');
                        }
                        showNotification(res.msg, isSuccess);
                    })
                    .catch(err => {
                        showNotification('Lỗi kết nối, không thể gửi đánh giá.', false);
                    });
            });
        }

        // --- LOGIC XEM THÊM ĐÁNH GIÁ ---
        const loadMoreBtn = document.querySelector('.js__load-more-reviews');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const hiddenReviews = document.querySelectorAll('.js__review-item[style*="display: none"]');
                for (let i = 0; i < 3 && i < hiddenReviews.length; i++) {
                    hiddenReviews[i].style.display = 'block';
                }
                if (document.querySelectorAll('.js__review-item[style*="display: none"]').length === 0) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }

        // --- LOGIC THÊM VÀO GIỎ HÀNG ---
        function handleAddToCart(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const action = event.submitter.value; // Lấy value của nút bấm (buy_now hoặc add_to_cart)
            const productId = form.querySelector('input[name="product_id"]').value;
            const qtyInput = form.querySelector('input[name="quantity"]');
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

            if (action === 'buy_now') {
                const formData = new FormData(form);
                formData.append('action', 'buy_now');
                fetch('<?= BASE_URL ?>index.php?url=cart/add', {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            window.location.href = '<?= BASE_URL ?>view/order/ThanhToan.php';
                        } else {
                            alert(res.msg || 'Thêm vào giỏ hàng thất bại!');
                        }
                    })
                    .catch(err => alert('Lỗi kết nối, vui lòng thử lại sau.'));
                return;
            }

            // Kích hoạt script gốc của hệ thống để mở giỏ hàng chuẩn xác
            const triggerGlobalCart = () => {
                const hiddenBtn = document.getElementById('hidden-cart-trigger');
                if (hiddenBtn) {
                    hiddenBtn.setAttribute('data-product-id', productId);
                    hiddenBtn.click();
                }
            };

            if (quantity > 1) {
                // Vì script gốc mặc định thêm 1, ta gửi trước (quantity - 1) lên server
                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', quantity - 1);
                formData.append('action', 'add_to_cart');

                fetch('<?= BASE_URL ?>index.php?url=cart/add', {
                    method: 'POST',
                    body: formData
                })
                    .then(() => triggerGlobalCart())
                    .catch(() => alert('Lỗi kết nối!'));
            } else {
                // Nếu khách chỉ mua 1 cái, nhường toàn quyền cho script hệ thống tự làm
                triggerGlobalCart();
            }
        }

        document.getElementById('form-add-to-cart-desktop').addEventListener('submit', handleAddToCart);
        document.getElementById('form-add-to-cart-mobile').addEventListener('submit', handleAddToCart);
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
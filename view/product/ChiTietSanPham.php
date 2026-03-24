<?php
// views/product/ChiTietSanPham.php
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../config.php';

// Kết nối DB
$conn = connectDB();

// Lấy id từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;
$similar_products = [];

// Load sản phẩm chi tiết
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND trang_thai = 'HienThi'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    // Load sản phẩm tương tự (4 sản phẩm khác id, cùng danh mục hoặc mới nhất)
    if ($product) {
        $similar_stmt = $conn->prepare("
            SELECT * FROM products 
            WHERE id != ? AND trang_thai = 'HienThi' 
            ORDER BY created_at DESC 
            LIMIT 4
        ");
        $similar_stmt->bind_param("i", $id);
        $similar_stmt->execute();
        $similar_result = $similar_stmt->get_result();
        while ($row = $similar_result->fetch_assoc()) {
            $similar_products[] = $row;
        }
        $similar_stmt->close();
    }
}

$conn->close();
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/ChiTietSanPham.css">

    <!-- CSS riêng cho từng trang - chỉ include ở view cụ thể, không nên include hết ở header -->
    <!-- Ví dụ: nếu trang chủ cần CSS riêng, include ở TrangChu.php thay vì ở đây -->

    <!-- Font Awesome (cho icon save, user, v.v. nếu cần sau này) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php">Sản phẩm</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li><?= htmlspecialchars($product['ten_sp'] ?? 'Chi tiết sản phẩm') ?></li>
</ul>

<!-- CONTENT -->
<div class="product">
    <!-- LEFT -->
    <div class="product__left">
        <!-- Gallery -->
        <div class="product__gallery">
            <div class="product__image">
                <?php if ($product && $product['anh']): ?>
                    <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['anh']) ?>" alt="<?= htmlspecialchars($product['ten_sp']) ?>">
                <?php else: ?>
                    <img src="<?= BASE_URL ?>assets/img/no-image.png" alt="Chưa có ảnh">
                <?php endif; ?>
            </div>
            <div class="product__thumbnails">
                <!-- Hiện tại chỉ 1 ảnh chính, sau này có thể thêm nhiều ảnh thumbnail từ DB -->
                <?php if ($product && $product['anh']): ?>
                    <img class="product__thumbnail product__thumbnail--active" src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($product['anh']) ?>" alt="Thumbnail">
                <?php endif; ?>
            </div>
        </div>

        <!-- SIDEBAR__MOBILE -->
        <div class="product__mobile-sidebar">
            <div class="product__mobile-title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

            <div class="product__mobile-rating">
                <span class="product__mobile-score">4.8</span>
                <span class="product__mobile-stars">
                    <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                    <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                    <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                    <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                    <img src="<?= BASE_URL ?>assets/icon/icon-sao-0,5.svg" alt="stars">
                </span>
                <span class="product__mobile-reviews">5 đánh giá</span>
            </div>

            <div class="product__mobile-price">
                <?php if ($product): ?>
                    <span class="product__mobile-price-old"><?= $product['gia_cu'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                    <span class="product__mobile-price-new"><?= number_format($product['gia']) ?>đ</span>
                    <?php if ($product['gia_cu'] > $product['gia']): ?>
                        <span class="product__mobile-discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

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

                <div class="product__mobile-quantity">
                    <p class="product__mobile-label">Số lượng</p>
                    <button class="product__mobile-quantity-btn">−</button>
                    <span class="product__mobile-quantity-value">1</span>
                    <button class="product__mobile-quantity-btn">+</button>
                </div>
            </div>

            <div class="product__mobile-actions">
                <button class="product__mobile-buy">MUA NGAY</button>
                <button class="product__mobile-cart">
                    <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
                </button>
            </div>
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

        <!-- Đánh Giá (tạm giữ tĩnh) -->
        <div class="review">
            <div class="review__title">Đánh Giá</div>

            <div class="review__total">
                <div class="review__summary">
                    <div class="review__rating">
                        <span class="review__score">4.8</span>
                        <img class="review__stars" src="<?= BASE_URL ?>assets/icon/icon-sao-to.svg" alt="Big Review Stars">
                    </div>
                    <div class="review__count">(5 đánh giá)</div>
                    <button class="review__button js__rating-btn">VIẾT ĐÁNH GIÁ</button>
                </div>

                <div class="review__progress">
                    <div class="review__progress-item">
                        <span class="review__progress-stars">5</span>
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="Review Stars">
                        <div class="review__progress-bar"><div class="review__progress-fill" style="width: 80%;"></div></div>
                        <span class="review__progress-count">4 đánh giá</span>
                    </div>
                    <!-- Giữ nguyên phần còn lại -->
                </div>
            </div>

            <!-- Danh sách đánh giá giữ tĩnh -->
            <div class="review__list">
                <!-- Giữ nguyên nội dung tĩnh như code cũ của bạn -->
                <div class="review__item">
                    <div class="review__author">
                        <div class="review__avatar"> <img src="<?= BASE_URL ?>assets/icon/icon-user-black.svg" alt="user rating"></div> 
                        <div>
                            <p class="review__name">Trần Cao Minh</p>
                            <p class="review__date">12/12/2024</p>
                        </div>
                    </div>
                    <div class="review__content">
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                        <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                        <p class="review__text">Chảo chắc chắn, cầm nặng tay nhưng không quá nặng. Nấu ăn nhanh, không bị dính và dễ vệ sinh. Dùng bếp từ rất ổn định. Mình dùng hơn 3 tháng rồi mà chảo vẫn như mới.</p>
                    </div>
                </div>
                <!-- Các đánh giá khác giữ nguyên -->
            </div>

            <button class="review__more">
                XEM THÊM<img src="<?= BASE_URL ?>assets/icon/icon-down-green.svg" alt="icon down">
            </button>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="product__sidebar">
        <div class="product__title"><?= htmlspecialchars($product['ten_sp'] ?? 'Sản phẩm') ?></div>

        <div class="product__rating">
            <span class="product__score">4.8</span>
            <span class="product__stars">
                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                <img src="<?= BASE_URL ?>assets/icon/icon-sao.svg" alt="stars">
                <img src="<?= BASE_URL ?>assets/icon/icon-sao-0,5.svg" alt="stars">
            </span>
            <span class="product__reviews">5 đánh giá</span>
        </div>

        <div class="product__price">
            <?php if ($product): ?>
                <span class="product__price-old"><?= $product['gia_cu'] ? number_format($product['gia_cu']) . 'đ' : '' ?></span>
                <span class="product__price-new"><?= number_format($product['gia']) ?>đ</span>
                <?php if ($product['gia_cu'] > $product['gia']): ?>
                    <span class="product__discount">-<?= round((($product['gia_cu'] - $product['gia']) / $product['gia_cu']) * 100) ?>%</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="product__options">
            <div class="product__colors">
                <p class="product__label">Màu</p>
                <button class="product__color product__color--white"></button>
                <button class="product__color product__color--green"></button>
                <button class="product__color product__color--orange"></button>
            </div>

            <div class="product__sizes">
                <p class="product__label">Kích thước</p>
                <button class="product__size">20cm</button>
                <button class="product__size">24cm</button>
                <button class="product__size">28cm</button>
            </div>

            <div class="product__quantity">
                <p class="product__label">Số lượng</p>
                <button class="product__quantity-btn">−</button>
                <span class="product__quantity-value">1</span>
                <button class="product__quantity-btn">+</button>
            </div>
        </div>

        <div class="product__actions">
            <button class="product__buy">MUA NGAY</button>
            <button class="product__cart">
                <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="button cart">
            </button>
        </div>
    </div>
</div>

<!-- SẢN PHẨM TƯƠNG TỰ -->
<div class="product__similar">
    <div class="product__similar-title">Sản Phẩm Tương Tự</div>

    <div class="product__cards">
        <?php if (!empty($similar_products)): ?>
            <?php foreach ($similar_products as $item): ?>
                <div class="product__card">
                    <a href="<?= BASE_URL ?>ChiTietSanPham.php?id=<?= $item['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>" alt="<?= htmlspecialchars($item['ten_sp']) ?>" class="product__card-image">
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
                        <a href="#" class="product__card-cart">
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

        <div class="review__modal-stars">
            <img class="review__modal-star" src="<?= BASE_URL ?>assets/icon/icon-sao-to.svg" alt="icon star-on">
            <img class="review__modal-star" src="<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg" alt="icon star-off">
            <img class="review__modal-star" src="<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg" alt="icon star-off">
            <img class="review__modal-star" src="<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg" alt="icon star-off">
            <img class="review__modal-star" src="<?= BASE_URL ?>assets/icon/icon-sao-to-off.svg" alt="icon star-off">
        </div>

        <form class="review__modal-form">
            <input type="text" class="review__modal-input" placeholder="Họ và tên">
            <input type="tel" class="review__modal-input" placeholder="Số điện thoại">
            <textarea class="review__modal-textarea" placeholder="Nội dung"></textarea>

            <label class="review__modal-checkbox">
                <input type="checkbox" class="review__modal-checkbox-input">
                Đồng ý với <a href="#" class="review__modal-link">điều khoản</a> và 
                <a href="#" class="review__modal-link">điều kiện</a> của chúng tôi
            </label>

            <button type="submit" class="review__modal-button">GỬI</button>
        </form>
    </div>
</div>

<!-- SCRIPT MODAL ĐÁNH GIÁ -->
<script>
    const ratingBtn = document.querySelector('.js__rating-btn');
    const modalRating = document.querySelector('.js__rating-modal');
    const modalRatingContent = document.querySelector('.js__rating-content');

    function showRatingForm() {
        modalRating.classList.add('open');
    }

    function hideRatingForm() {
        modalRating.classList.remove('open');
    }

    ratingBtn.addEventListener('click', showRatingForm);
    modalRating.addEventListener('click', hideRatingForm);
    modalRatingContent.addEventListener('click', function(event) {
        event.stopPropagation();
    });
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
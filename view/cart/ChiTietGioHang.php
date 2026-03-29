<?php
// view/cart/ChiTietGioHang.php

if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=cart");
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    /* Định dạng lại khung bao quanh toàn bộ trang giỏ hàng */
    .cart-detail-wrapper {
        max-width: 1200px;
        margin: 20px auto 80px auto; 
        padding: 0 20px;
        min-height: 50vh; 
    }

    
    .breadcrumb-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
        font-size: 15px;
        color: #555;
    }

    .breadcrumb-custom a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.2s;
    }

    .breadcrumb-custom a:hover {
        color: #2e5932; 
    }

    .breadcrumb-custom img {
        width: 12px;
        height: 12px;
        opacity: 0.6;
    }

    /* Tiêu đề trang */
    .cart-page__title {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Khung trắng chứa sản phẩm */
    .cart-page__container {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06); 
        border: 1px solid #eaeaea;
    }

    /* Khu vực tổng tiền và nút bấm */
    .cart-page__footer {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eaeaea;
        display: flex;
        flex-direction: column;
        align-items: flex-end; 
        gap: 20px;
    }

    .cart__total-wrapper {
        font-size: 1.3rem;
        color: #333;
        font-weight: bold;
    }

    .cart__total-price {
        font-size: 1.8rem;
        color: #333; 
        margin-left: 10px;
    }

    /* Nhóm nút bấm */
    .cart__action-buttons {
        display: flex;
        gap: 15px;
    }

    /* --- NÚT TIẾP TỤC MUA HÀNG  */
    .btn-continue {
        padding: 12px 25px;
        background: #fff;
        color: #2e5932; 
        border: 1px solid #2e5932; 
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-continue:hover {
        background: #2e5932; 
        color: #fff; 
    }

    /* --- NÚT THANH TOÁN  */
    .btn-checkout {
        padding: 12px 30px;
        background: #2e5932; 
        color: #fff; 
        border: 1px solid #2e5932;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        background: #1f4023; 
        border-color: #1f4023;
    }
</style>

<div class="cart-detail-wrapper">
    <ul class="breadcrumb-custom">
        <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
        <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
        <li>Giỏ hàng chi tiết</li>
    </ul>

    <h2 class="cart-page__title">Giỏ Hàng Của Bạn</h2>
    
    <div class="cart-page__container">
        <ul class="cart__items js__cart-items-list" style="list-style: none; padding: 0; margin: 0;">
            </ul>
        
        <div class="cart-page__footer">
            <div class="cart__total-wrapper">
                Tổng tiền: <span class="js__cart-total-price cart__total-price">0đ</span>
            </div>
            <div class="cart__action-buttons">
                <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="btn-continue">TIẾP TỤC MUA HÀNG</a>
                <a href="<?= BASE_URL ?>index.php?url=order/checkout" class="btn-checkout">THANH TOÁN</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
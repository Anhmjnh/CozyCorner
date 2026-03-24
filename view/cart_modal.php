<div class="cart__modal js__cart-modal">
    <div class="cart__content js__cart-content">
        <div class="cart__header">
            <div class="cart__title">Giỏ Hàng</div>
            <button class="cart__close-button js__cart-modal--close">
                <img src="<?= BASE_URL ?>assets/icon/icon-close.svg" alt="icon close">
            </button>
        </div>

        <ul class="cart__items js__cart-items-list" style="list-style: none; padding: 0 40px; margin: 0; max-height: 50vh; overflow-y: auto; margin-bottom: 20px;">
        </ul>

        <div class="cart__footer"
            style="display: flex; flex-direction: column; width: 100%; box-sizing: border-box; padding: 0 40px 30px 40px; border-top: none !important;">

            <div class="cart__total"
                style="display: flex; justify-content: space-between; align-items: center; font-weight: bold; margin-bottom: 15px; font-size: 1.1rem; width: 100%; box-sizing: border-box; border-top: 1px solid #e0e0e0; padding-top: 15px;">
                <span>Tổng tiền:</span>
                <span class="js__cart-total-price"
                    style="color: #343131; font-size: 1.2rem; text-align: right; word-wrap: break-word;">0đ</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px; width: 100%; box-sizing: border-box;">
                <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>view/cart/ChiTietGioHang.php" class="cart__checkout-button"
                        style="width: 100%; display: flex; justify-content: center; align-items: center; box-sizing: border-box; min-height: 45px; padding: 10px 0;">XEM GIỎ HÀNG</a>
                <?php else: ?>
                    <a href="javascript:void(0)"
                        onclick="alert('Bạn cần đăng nhập để xem chi tiết và thanh toán giỏ hàng!'); window.location.href='<?= BASE_URL ?>view/user/DangNhap.php';"
                        class="cart__checkout-button"
                        style="width: 100%; display: flex; justify-content: center; align-items: center; box-sizing: border-box; min-height: 45px; padding: 10px 0;">XEM GIỎ HÀNG</a>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="cart__continue-shopping-button"
                    style="width: 100%; display: flex; justify-content: center; align-items: center; box-sizing: border-box; min-height: 45px; padding: 10px 0;">TIẾP TỤC MUA HÀNG</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cartBtn = document.querySelector('.js__cart-btn');
        const modalCart = document.querySelector('.js__cart-modal');
        const modalCartClose = document.querySelector('.js__cart-modal--close');
        const modalCartContent = document.querySelector('.js__cart-content');

        if (cartBtn && modalCart) {
            cartBtn.addEventListener('click', function () { modalCart.classList.add('open'); });
            modalCartClose.addEventListener('click', function () { modalCart.classList.remove('open'); });

            modalCart.addEventListener('click', function (e) {
                if (e.target === modalCart) {
                    modalCart.classList.remove('open');
                }
            });
        }
    });
</script>
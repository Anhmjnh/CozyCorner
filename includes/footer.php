<?php
// includes/footer.php
require_once __DIR__ . '/../config.php';  // Include config để lấy BASE_URL
?>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer__container">

        <!-- Cột 1: Thông tin công ty -->
        <div class="footer__column footer__company">
            <div class="footer__logo">
                <img src="<?= BASE_URL ?>assets/icon/Cozy Corner.svg" alt="logo cozy corner">
            </div>
            <p class="footer__name font600">CÔNG TY CỔ PHẦN COZY CORNER</p>
            
            <div class="footer__contact font400">
                <p class="footer__text">
                    <span class="font600">Địa chỉ:</span> Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh
                </p>
                <p class="footer__text">
                    <span class="font600">Số điện thoại:</span> 0888 888 888
                </p>
                <p class="footer__text">
                    <span class="font600">Email:</span> Cozy@cv.com.vn
                </p>
            </div>

            <div class="footer__support font400">
                <p class="footer__text">Tư vấn hỗ trợ (8:00 - 17:30)</p>
                <p class="footer__text">0888 888 888</p>
                <p class="footer__text">0999 999 999</p>
            </div>

            <!-- Mạng xã hội -->
            <div class="footer__social">
                <a href="https://www.facebook.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-facebook.svg" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-instargram.svg" alt="Instagram">
                </a>
                <a href="https://www.messenger.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-messenger.svg" alt="Messenger">
                </a>
                <a href="https://zalo.me/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-zalo.svg" alt="Zalo">
                </a>
                <a href="https://x.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-X.svg" alt="X">
                </a>
                <a href="https://www.pinterest.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-pinterest.svg" alt="Pinterest">
                </a>
            </div>
        </div>

        <!-- Cột 2: Về Cozy Corner -->
        <div class="footer__column footer__about">
            <div class="footer__title font600">Về Cozy Corner</div>
            <ul class="footer__list font400">
                <li class="footer__item"><a href="#" class="footer__link">Giới Thiệu</a></li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>" class="footer__link">Trang Chủ</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=product" class="footer__link">Sản Phẩm</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=news" class="footer__link">Tin Tức</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=contact" class="footer__link">Liên Hệ</a>
                </li>
            </ul>
        </div>

        <!-- Cột 3: Chính Sách -->
        <div class="footer__column footer__policy">
            <div class="footer__title font600">Chính Sách</div>
            <ul class="footer__list font400">
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Hoàn Tiền</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Giao Hàng</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Bảo Hành Thu Đổi</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Khách Hàng Thân Thiết</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Bảo Mật Thông Tin Khách Hàng</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Xử Lý Dữ Liệu Cá Nhân</a>
                </li>
            </ul>
        </div>

    </div>
</footer>

<!-- Dòng bản quyền -->
<div class="footer__bottom">
    <p class="footer__copyright">© 2026 All Rights Reserved. Design By Anh Minh.</p>
</div>

<!-- Đóng thẻ body và html (để hoàn thiện cấu trúc trang) -->
<?php // Nạp modal giỏ hàng và script xử lý
require_once __DIR__ . '/../view/cart_modal.php'; ?>
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= BASE_URL ?>assets/js/cart.js"></script>
</body>
</html>
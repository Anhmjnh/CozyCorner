<?php
// view/LienHe.php

require_once __DIR__ . '/../includes/header.php';
?>

<!-- BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt="icon next"></li>
    <li>Liên hệ</li>
</ul>

<!-- CONTENT -->
<section class="contact">
    <div class="contact__container">
        <div class="contact__form">
            <div class="contact__title">Liên Hệ Với Chúng Tôi</div>
            <p class="contact__description">
                Hãy liên hệ với chúng tôi nếu bạn có bất kỳ câu hỏi, thắc mắc hoặc nhu cầu hỗ trợ nào.
                Hoặc bạn có thể để lại thông tin trong biểu mẫu liên hệ, chúng tôi sẽ phản hồi trong vòng 24h.
            </p>

            <style>
                .contact-toast {
                    position: fixed;
                    top: 30px;
                    right: 30px;
                    padding: 16px 24px;
                    border-radius: 8px;
                    color: #fff !important;
                    font-weight: 500;
                    font-size: 15px;
                    z-index: 9999;
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
                    opacity: 1;
                    transition: opacity 0.5s ease, transform 0.5s ease;
                    transform: translateY(0);
                    display: flex;
                    align-items: center;
                    gap: 12px;
                }

                .contact-toast.success {
                    background-color: #355f2e;
                    /* Nền xanh lá chuẩn admin */
                }

                .contact-toast.error {
                    background-color: #e74c3c;
                    /* Nền đỏ báo lỗi */
                }

                .contact-toast.hide {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            </style>

            <?php if (!empty($success)): ?>
                <div id="contactToast" class="contact-toast success">

                    <span style="color: #fff !important;"><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div id="contactToast" class="contact-toast error">
                    <i class="fas fa-exclamation-circle" style="font-size: 24px;"></i>
                    <div>
                        <?php foreach ($errors as $err): ?>
                            <p style="margin: 0 0 5px 0; color: #fff !important;"><?= htmlspecialchars($err) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toast = document.getElementById('contactToast');
                    if (toast) {
                        setTimeout(() => {
                            toast.classList.add('hide'); // Thêm class để chạy hiệu ứng mờ dần
                            setTimeout(() => toast.remove(), 500); // Xóa hẳn phần tử sau khi mờ xong
                        }, 4000); // Hiển thị trong 4 giây
                    }
                });
            </script>

            <form class="form" method="POST" action="">
                <input type="text" name="ho_ten" class="form__input" placeholder="Họ và tên" required
                    value="<?= htmlspecialchars($old_data['ho_ten'] ?? '') ?>">
                <div class="form__group">
                    <input type="text" name="so_dien_thoai" class="form__input" placeholder="Số điện thoại" required
                        value="<?= htmlspecialchars($old_data['so_dien_thoai'] ?? '') ?>">
                    <input type="email" name="email" class="form__input" placeholder="Email" required
                        value="<?= htmlspecialchars($old_data['email'] ?? '') ?>">
                </div>
                <input type="text" name="tieu_de" class="form__input" placeholder="Tiêu đề" required
                    value="<?= htmlspecialchars($old_data['tieu_de'] ?? '') ?>">
                <textarea name="noi_dung" class="form__textarea" placeholder="Nội dung"
                    required><?= htmlspecialchars($old_data['noi_dung'] ?? '') ?></textarea>
                <button type="submit" class="form__button">GỬI</button>
            </form>

            <div class="contact__info">
                <p><span class="contact__info-bold">Địa chỉ:</span> Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh
                </p>
                <p><span class="contact__info-bold">Số điện thoại:</span> 0888 888 888</p>
                <p><span class="contact__info-bold">Email:</span> Cozy@cv.com.vn</p> <br>
                <p>Tư vấn hỗ trợ (8:00 - 17:30)</p>
                <p>0888 888 888</p>
                <p>0999 999 999</p>
            </div>
        </div>
        <div class="contact__map">
            <iframe
                src="https://maps.google.com/maps?q=Hoàng%20Hoa%20Thám,%20P.%207,%20Q.%20Bình%20Thạnh,%20TP.%20Hồ%20Chí%20Minh&t=&z=15&ie=UTF8&iwloc=&output=embed"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<!-- LỢI ÍCH -->
<div class="benefits">
    <div class="benefits__list">
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-box.svg" alt="Giao hàng miễn phí" class="benefits__icon">
            <p class="benefits__text">Giao Hàng Toàn Quốc</p>
        </div>
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-Truck.svg" alt="Giao hàng tận nơi" class="benefits__icon">
            <p class="benefits__text">Hỗ Trợ Giao Hàng Tận Nơi</p>
        </div>
       
        <div class="benefits__item">
            <img src="<?= BASE_URL ?>assets/icon/icon-voucher.svg" alt="Ưu đãi voucher" class="benefits__icon">
            <p class="benefits__text">Ưu Đãi Voucher Lên Đến 500K</p>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
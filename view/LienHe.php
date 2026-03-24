<?php
// views/contact/LienHe.php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../config.php';
// Chỉ chứa nội dung chính của trang Liên Hệ
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/LienHe.css">

    <!-- CSS riêng cho từng trang - chỉ include ở view cụ thể, không nên include hết ở header -->
    <!-- Ví dụ: nếu trang chủ cần CSS riêng, include ở TrangChu.php thay vì ở đây -->

    <!-- Font Awesome (cho icon save, user, v.v. nếu cần sau này) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

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

            <?php if (!empty($success)): ?>
                <p style="color: green; font-weight: bold; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div style="color: red; margin-bottom: 20px;">
                    <?php foreach ($errors as $err): ?>
                        <p><?= htmlspecialchars($err) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="form" method="POST" action="">
                <input type="text" name="ho_ten" class="form__input" placeholder="Họ và tên" required value="<?= htmlspecialchars($old_data['ho_ten'] ?? '') ?>">
                <div class="form__group">
                    <input type="text" name="so_dien_thoai" class="form__input" placeholder="Số điện thoại" required value="<?= htmlspecialchars($old_data['so_dien_thoai'] ?? '') ?>">
                    <input type="email" name="email" class="form__input" placeholder="Email" required value="<?= htmlspecialchars($old_data['email'] ?? '') ?>">
                </div>
                <input type="text" name="tieu_de" class="form__input" placeholder="Tiêu đề" required value="<?= htmlspecialchars($old_data['tieu_de'] ?? '') ?>">
                <textarea name="noi_dung" class="form__textarea" placeholder="Nội dung" required><?= htmlspecialchars($old_data['noi_dung'] ?? '') ?></textarea>
                <button type="submit" class="form__button">GỬI</button>
            </form>

            <div class="contact__info">
                <p><span class="contact__info-bold">Địa chỉ:</span>  Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh</p>
                <p><span class="contact__info-bold">Số điện thoại:</span> 0888 888 888</p>
                <p><span class="contact__info-bold">Email:</span> Cozy@cv.com.vn</p> <br>
                <p>Tư vấn hỗ trợ (8:00 - 17:30)</p>
                <p>0888 888 888</p>
                <p>0999 999 999</p>
            </div>
        </div>
        <div class="contact__map">
            <iframe src="https://maps.google.com/maps?q=Hoàng%20Hoa%20Thám,%20P.%207,%20Q.%20Bình%20Thạnh,%20TP.%20Hồ%20Chí%20Minh&t=&z=15&ie=UTF8&iwloc=&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

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

<?php 
require_once __DIR__ . '/../includes/footer.php'; 
?>
<?php
// view/news/ChiTietTinTuc.php
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/ChiTietTinTuc.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<style>
    /* Canh lề và đồng bộ chiều cao cho bài viết liên quan */
    .news__list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

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

    @media (max-width: 992px) {
        .news__list {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .news__list {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- CONTENT -->
<div class="post">
    <?php if ($news): ?>
        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($news['anh']) ?>"
            alt="<?= htmlspecialchars($news['tieu_de']) ?>" class="post__image">

        <div class="post__content">
            <span class="post__category">Tin tức</span>
            <div class="post__title"><?= htmlspecialchars($news['tieu_de']) ?></div>
            <div class="post__bot">
                <div class="post__meta">
                    <span class="post__bot-text"><?= date('d/m/Y', strtotime($news['created_at'])) ?></span>
                    <img src="<?= BASE_URL ?>assets/icon/icon-line.svg" alt="icon line">
                    <span class="post__bot-text">Admin</span> <!-- Thay bằng tác giả nếu có cột -->
                </div>
                <div class="post__share">
                    <span class="post__bot-text">Chia sẻ:</span>
                    <a href="#"><img src="<?= BASE_URL ?>assets/icon/icon-facebook-gray.svg" alt="icon facebook"></a>
                    <a href="#"><img src="<?= BASE_URL ?>assets/icon/icon-instargram-gray.svg" alt="icon instargram"></a>
                </div>
            </div>

            <div class="post__description">
                <?= nl2br(htmlspecialchars($news['noi_dung'])) ?>
            </div>
        </div>
    <?php else: ?>
        <p style="color: red; text-align: center; font-size: 20px;">Bài viết không tồn tại hoặc đã bị xóa.</p>
    <?php endif; ?>
</div>

<!-- BÀI VIẾT LIÊN QUAN -->
<div class="news">
    <div class="news__title">Bài Viết Liên Quan</div>
    <div class="news__list">
        <?php if (!empty($related_news)): ?>
            <?php foreach ($related_news as $item): ?>
                <article class="news__item">
                    <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $item['id'] ?>">
                        <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>"
                            alt="<?= htmlspecialchars($item['tieu_de']) ?>" class="news__image">
                    </a>
                    <div class="news__content">
                        <div class="news__date"><?= date('d/m/Y', strtotime($item['created_at'])) ?></div>
                        <div class="news__category">Tin tức</div>
                    </div>
                    <div class="news__headline">
                        <a href="<?= BASE_URL ?>index.php?url=news/chiTiet&id=<?= $item['id'] ?>">
                            <?= htmlspecialchars($item['tieu_de']) ?>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có bài viết liên quan.</p>
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

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
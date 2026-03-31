<?php
// includes/header.php
require_once __DIR__ . '/../config.php';  // Include config để lấy BASE_URL và session

// Kiểm tra trạng thái đăng nhập
$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$profile_link = $is_logged_in ? BASE_URL . 'index.php?url=user/account' : BASE_URL . 'index.php?url=auth/showLogin';
$user_title = $is_logged_in ? 'Tài khoản của tôi' : 'Đăng nhập / Đăng ký';
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <!-- CSS chính (chung cho toàn site) -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/TrangChu.css?v=<?= time() ?>">

    <!-- CSS riêng cho từng trang -->
    <?php if (!empty($page_css) && is_array($page_css)): ?>
        <?php foreach ($page_css as $css): ?>
            <link rel="stylesheet" href="<?= BASE_URL . ltrim($css, '/') ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Font Awesome (cho icon save, user, v.v. nếu cần sau này) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <?php showSessionMessage(); ?>

    <!-- HEADER -->
    <header class="navbar">
        <div class="navbar__logo">
            <a href="<?= BASE_URL ?>">
                <img src="<?= BASE_URL ?>assets/icon/Cozy Corner.svg" alt="Logo Cozy Corner">
            </a>
        </div>

        <nav class="navbar__menu">
            <ul class="navbar__list">
                <li class="navbar__item">
                    <a href="<?= BASE_URL ?>" class="navbar__link">Trang Chủ</a>
                </li>
                <li class="navbar__item nav__item--has-dropdown">
                    <a href="<?= BASE_URL ?>index.php?url=product" class="navbar__link">Sản Phẩm</a>
                    <div class="navbar__dropdown">
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=n-i"
                                class="navbar__dropdown-title navbar__dropdown-link">Nồi</a>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=ch-o"
                                class="navbar__dropdown-title navbar__dropdown-link">Chảo</a>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=-i-n"
                                class="navbar__dropdown-title navbar__dropdown-link">Đồ điện</a>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=ch-n"
                                class="navbar__dropdown-title navbar__dropdown-link">Chén</a>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=th-t"
                                class="navbar__dropdown-title navbar__dropdown-link">Thớt</a>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=dao"
                                class="navbar__dropdown-title navbar__dropdown-link">Dao</a>
                        </div>
                    </div>
                </li>
                <li class="navbar__item">
                    <a href="<?= BASE_URL ?>index.php?url=news" class="navbar__link">Tin Tức</a>
                </li>
                <li class="navbar__item">
                    <a href="<?= BASE_URL ?>index.php?url=contact" class="navbar__link">Liên Hệ</a>
                </li>
            </ul>
        </nav>

        <div class="navbar__actions">
            <div class="navbar__search">
                <form action="<?= BASE_URL ?>index.php" method="GET">
                    <input type="hidden" name="url" value="product">
                    <input type="text" name="search" class="navbar__search-input" placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit" class="navbar__search-button">
                        <img src="<?= BASE_URL ?>assets/icon/Icon-search.svg" alt="Icon Search">
                    </button>
                </form>
            </div>

            <div class="navbar__icons">
                <a class="navbar__icon navbar__icon--user" href="<?= $profile_link ?>" title="<?= $user_title ?>">
                    <img src="<?= BASE_URL ?>assets/icon/Icon-user.svg" alt="Icon User">
                </a>

                <button class="navbar__icon navbar__icon--cart js__cart-btn">
                    <img src="<?= BASE_URL ?>assets/icon/Icon-cart.svg" alt="Icon Cart">
                    <span class="navbar__cart-count">0</span>
                </button>
            </div>

            <label for="navbar__mobile-check" class="navbar__bars-btn">
                <img src="<?= BASE_URL ?>assets/icon/icon-bars.svg" alt="icon bars">
            </label>
        </div>

        <!-- nav mobile -->
        <input type="checkbox" hidden class="navbar__mobile-input" id="navbar__mobile-check">

        <label for="navbar__mobile-check" class="navbar__overlay"></label>

        <nav class="navbar__mobile">
            <div class="navbar__mobile-logo">
                <img src="<?= BASE_URL ?>assets/icon/Cozy Corner.svg" alt="Logo Cozy Corner">
                <label for="navbar__mobile-check">
                    <img class="navbar__mobile-close" src="<?= BASE_URL ?>assets/icon/icon-close.svg" alt="icon close">
                </label>
            </div>

            <ul class="navbar__mobile-list">
                <li class="navbar__mobile-item">
                    <a href="<?= BASE_URL ?>" class="navbar__mobile-link">Trang Chủ</a>
                </li>
                <li class="navbar__mobile-item">
                    <a href="<?= BASE_URL ?>index.php?url=product" class="navbar__mobile-link">Sản Phẩm</a>

                    <input type="checkbox" hidden name="" class="nav__mobile--has-dropdown"
                        id="nav__mobile-item--has-dropdown">
                    <label for="nav__mobile-item--has-dropdown">
                        <img src="<?= BASE_URL ?>assets/icon/icon-down-black.svg" alt="icon down">
                    </label>

                    <div class="navbar__dropdown-mobile">
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=n-i"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Nồi</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi inox</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi hấp</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi lẩu</a>
                                </li>
                            </ul>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=ch-o"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Chảo</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chảo
                                        inox</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chảo
                                        nhôm</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chảo chống
                                        dính</a></li>
                            </ul>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=-i-n"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Đồ điện</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi cơm</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi chiên
                                        không dầu</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi lẩu
                                        điện</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Nồi áp suất
                                        điện</a></li>
                            </ul>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=ch-n"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Chén</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chén sứ</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chén thủy
                                        tinh</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chén gốm</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Chén
                                        nhựa</a></li>
                            </ul>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=th-t"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Thớt</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Thớt gỗ</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Thớt
                                        nhựa</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Thớt tre</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Thớt
                                        silicone</a></li>
                            </ul>
                        </div>
                        <div class="navbar__dropdown-column">
                            <a href="<?= BASE_URL ?>index.php?url=product&category=dao"
                                class="navbar__dropdown-title"
                                style="text-decoration: none; color: inherit; display: block;">Dao</a>
                            <ul class="navbar__dropdown-mobile-list">
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Dao bếp</a>
                                </li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Dao thái
                                        thịt</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Dao rau
                                        củ</a></li>
                                <li class="navbar__dropdown-item"><a href="#" class="navbar__dropdown-link">Dao đa
                                        năng</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="navbar__mobile-item">
                    <a href="<?= BASE_URL ?>index.php?url=news" class="navbar__mobile-link">Tin Tức</a>
                </li>
                <li class="navbar__mobile-item">
                    <a href="<?= BASE_URL ?>index.php?url=contact" class="navbar__mobile-link">Liên Hệ</a>
                </li>

                <!-- Thêm mục Tài khoản / Đăng nhập ở mobile nav -->
                <li class="navbar__mobile-item">
                    <a href="<?= $profile_link ?>" class="navbar__mobile-link">
                        <?= $is_logged_in ? 'Tài khoản' : 'Đăng nhập' ?>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- nav mobile -->
    </header>
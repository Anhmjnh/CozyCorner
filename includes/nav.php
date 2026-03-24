<?php
// includes/nav.php
// Phần điều hướng (header) của các trang, chỉ chứa HTML của navbar (không chứa <html><head>...)
// Yêu cầu đã load config.php và session.

$is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$profile_link = $is_logged_in ? BASE_URL . 'view/user/TaiKhoan.php' : BASE_URL . 'view/user/DangNhap.php';
$user_title = $is_logged_in ? 'Tài khoản của tôi' : 'Đăng nhập / Đăng ký';
?>

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
                <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="navbar__link">Sản Phẩm</a>
                <div class="dropdown">
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=noi"
                            class="dropdown__title dropdown__link">Nồi</a>
                    </div>
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=chao"
                            class="dropdown__title dropdown__link">Chảo</a>
                    </div>
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=do-dien"
                            class="dropdown__title dropdown__link">Đồ điện</a>
                    </div>
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=chen"
                            class="dropdown__title dropdown__link">Chén</a>
                    </div>
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=thot"
                            class="dropdown__title dropdown__link">Thớt</a>
                    </div>
                    <div class="dropdown__column">
                        <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php?category=dao"
                            class="dropdown__title dropdown__link">Dao</a>
                    </div>
                </div>
            </li>
            <li class="navbar__item">
                <a href="<?= BASE_URL ?>view/news/DanhMucTinTuc.php" class="navbar__link">Tin Tức</a>
            </li>
            <li class="navbar__item">
                <a href="<?= BASE_URL ?>LienHe.php" class="navbar__link">Liên Hệ</a>
            </li>
        </ul>
    </nav>

    <div class="navbar__actions">
        <div class="navbar__search">
            <form action="<?= BASE_URL ?>view/product/DanhMucSanPham.php" method="GET">
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
                <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="navbar__mobile-link">Sản Phẩm</a>

                <input type="checkbox" hidden name="" class="nav__mobile--has-dropdown"
                    id="nav__mobile-item--has-dropdown">
                <label for="nav__mobile-item--has-dropdown">
                    <img src="<?= BASE_URL ?>assets/icon/icon-down-black.svg" alt="icon down">
                </label>

                <div class="dropdown__mobile">
                    <div class="dropdown__column">
                        <div class="dropdown__title">Nồi</div>
                        <ul class="dropdown__mobile-list">
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi inox</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi hấp</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi lẩu</a></li>
                        </ul>
                    </div>
                    <div class="dropdown__column">
                        <div class="dropdown__title">Chảo</div>
                        <ul class="dropdown__mobile-list">
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Chảo inox</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Chảo nhôm</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Chảo chống dính</a></li>
                        </ul>
                    </div>
                    <div class="dropdown__column">
                        <div class="dropdown__title">Đồ điện</div>
                        <ul class="dropdown__mobile-list">
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi cơm</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi chiên không dầu</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi lẩu điện</a></li>
                            <li class="dropdown__item"><a href="#" class="dropdown__link">Nồi áp suất điện</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="navbar__mobile-item">
                <a href="<?= BASE_URL ?>view/news/DanhMucTinTuc.php" class="navbar__mobile-link">Tin Tức</a>
            </li>
            <li class="navbar__mobile-item">
                <a href="<?= BASE_URL ?>LienHe.php" class="navbar__mobile-link">Liên Hệ</a>
            </li>
        </ul>
    </nav>
</header>
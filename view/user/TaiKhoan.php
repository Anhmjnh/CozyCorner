<?php
// views/user/TaiKhoan.php

if (!isset($user)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=user/account");
    exit;
}
require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    /* Reset & Container */
    .account-wrapper {
        max-width: 1200px;
        margin: 30px auto 80px auto;
        padding: 0 20px;
        display: flex;
        gap: 30px;
        align-items: flex-start;
        font-family: inherit;
    }

    /* --- CỘT TRÁI - SIDEBAR --- */
    .account-sidebar {
        width: 280px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        padding: 30px 20px;
        flex-shrink: 0;
        border: 1px solid #f0f0f0;
    }

    .account-sidebar__profile {
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 25px;
        margin-bottom: 20px;
    }

    .account-sidebar__avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #355F2E;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(46, 89, 50, 0.2);
    }

    .account-sidebar__name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
        margin: 0 0 8px 0;
    }

    .account-sidebar__tier {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 15px;
        color: #fff;
        font-size: 0.85rem;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .account-sidebar__menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .account-sidebar__menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        color: #555;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .account-sidebar__menu a i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .account-sidebar__menu a:hover {
        background: #f8fbf9;
        color: #355F2E;
    }

    .account-sidebar__menu a.active {
        background: #355F2E;
        color: #fff;
        box-shadow: 0 4px 10px rgba(46, 89, 50, 0.3);
    }

    /* --- CỘT PHẢI - NỘI DUNG --- */
    .account-content {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        padding: 40px;
        border: 1px solid #f0f0f0;
    }

    .account-content__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .account-content__title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #355F2E;
        margin: 0;
    }

    /* Định nghĩa nút bấm chuẩn */
    .account__button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 24px;
        background: #355F2E;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
        border-radius: 6px;
        border: 1px solid #355F2E;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .account__button:hover {
        background: #1f4023;
        border-color: #1f4023;
    }

    /* Tab: Thông tin tài khoản */
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        background: #fdfdfd;
        padding: 25px;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .profile-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .profile-item.full-width {
        grid-column: 1 / -1;
    }

    .profile-item__label {
        color: #888;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .profile-item__value {
        font-size: 1.1rem;
        color: #333;
        font-weight: 500;
    }

    /* Tab: Đơn hàng */
    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th,
    .order-table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .order-table th {
        background-color: #f8fbf9;
        color: #355F2E;
        font-weight: 700;
        font-size: 0.95rem;
        text-transform: uppercase;
    }

    .order-table tbody tr:hover {
        background-color: #fafafa;
    }

    .order-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-align: center;
    }

    .status-pending {
        background: #fff3cd;
        color: #d35400;
    }

    .status-success {
        background: #d4edda;
        color: #28a745;
    }

    .status-cancel {
        background: #f8d7da;
        color: #dc3545;
    }

    /* --- STYLES CHO MODAL XÁC NHẬN --- */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 22px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 6px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .btn-primary {
        background-color: #355F2E;
        border-color: #355F2E;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #1f4023;
        border-color: #1f4023;
    }

    .btn-secondary {
        background-color: #f0f0f0;
        border-color: #dcdcdc;
        color: #555;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
        border-color: #ccc;
    }

    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 2000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.6);
        /* Black w/ opacity */
        justify-content: center;
        /* Center horizontally */
        align-items: center;
        /* Center vertically */
    }

    .custom-modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 25px;
        border: 1px solid #888;
        width: 95%;
        max-width: 450px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation-name: animatetop;
        animation-duration: 0.4s;
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .custom-modal-title {
        margin: 5px 0 0 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
    }

    .custom-modal-close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .custom-modal-close:hover,
    .custom-modal-close:focus {
        color: #000;
        text-decoration: none;
    }

    .custom-modal-body p {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 20px;
        text-align: center;
    }

    .custom-modal-body i {
        display: block;
        text-align: center;
        font-size: 50px;
        color: #f39c12;
        /* Màu vàng cảnh báo */
        margin-bottom: 20px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

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

    /* Tab: Địa chỉ */
    .address-card {
        border: 1px solid #e0e0e0;
        padding: 25px;
        border-radius: 8px;
        position: relative;
        background: #fff;
        transition: all 0.3s ease;
    }

    .address-card:hover {
        border-color: #355F2E;
        box-shadow: 0 4px 15px rgba(46, 89, 50, 0.08);
    }

    .address-card__badge {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #355F2E;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    @media (max-width: 768px) {
        .account-wrapper {
            flex-direction: column;
        }

        .account-sidebar,
        .account-content {
            width: 100%;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .order-table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>

<ul class="breadcrumb"
    style="max-width: 1200px; margin: 20px auto;margin-top: 110px; padding: 0 20px; list-style: none; display: flex; gap: 10px; align-items: center; color: #555;">
    <li><a href="<?= BASE_URL ?>" style="color: #9e9e9e; text-decoration: none;">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt=">" style="width: 12px; opacity: 0.5;"></li>
    <li style="color: #333; text-decoration: none;">Tài khoản</li>
</ul>

<div class="account-wrapper">
    <div class="account-sidebar">
        <div class="account-sidebar__profile">
            <img src="<?= $user['avatar'] ? BASE_URL . $user['avatar'] : BASE_URL . 'assets/icon/Icon-user.svg' ?>"
                alt="Avatar" class="account-sidebar__avatar">
            <h3 class="account-sidebar__name"><?= htmlspecialchars($user['ho_ten']) ?></h3>
            <?php
            $tierBg = 'linear-gradient(135deg, #cd7f32, #b87333)'; // Đồng
            if ($user['hang'] === 'Kim Cương')
                $tierBg = 'linear-gradient(135deg, #3498db, #2980b9)'; // Xanh dương
            elseif ($user['hang'] === 'Vàng')
                $tierBg = 'linear-gradient(135deg, #f1c40f, #f39c12)';
            elseif ($user['hang'] === 'Bạc')
                $tierBg = 'linear-gradient(135deg, #bdc3c7, #95a5a6)';
            ?>
            <span class="account-sidebar__tier" style="background: <?= $tierBg ?>;"><i class="fas fa-crown"></i>
                <?= htmlspecialchars($user['hang'] ?? 'Đồng') ?></span>
        </div>

        <ul class="account-sidebar__menu">
            <li><a href="<?= BASE_URL ?>index.php?url=user/account&tab=profile"
                    class="<?= $tab === 'profile' ? 'active' : '' ?>"><i class="fas fa-user"></i>
                    Thông tin tài khoản</a></li>
            <li><a href="<?= BASE_URL ?>index.php?url=user/account&tab=addresses"
                    class="<?= $tab === 'addresses' ? 'active' : '' ?>"><i class="fas fa-address-book"></i> 
                    Địa chỉ</a></li>
            <li><a href="<?= BASE_URL ?>index.php?url=user/account&tab=orders"
                    class="<?= $tab === 'orders' ? 'active' : '' ?>"><i class="fas fa-box"></i> Lịch
                    sử mua hàng</a></li>
            <li><a href="<?= BASE_URL ?>index.php?url=user/account&tab=vouchers"
                    class="<?= $tab === 'vouchers' ? 'active' : '' ?>"><i class="fas fa-ticket-alt"></i> Kho Voucher</a>
            </li>
            <li><a href="<?= BASE_URL ?>index.php?url=auth/logout" style="color: #555555;"><i
                        class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </div>

    <div class="account-content">
        <?php if ($tab === 'profile'): ?>
            <div class="account-content__header">
                <h2 class="account-content__title">Hồ Sơ Của Tôi</h2>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <span class="profile-item__label">Họ Tên:</span>
                    <span class="profile-item__value"><?= htmlspecialchars($user['ho_ten']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-item__label">Email:</span>
                    <span class="profile-item__value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-item__label">Số điện thoại:</span>
                    <span
                        class="profile-item__value"><?= htmlspecialchars($user['so_dien_thoai'] ?? 'Chưa cập nhật') ?></span>
                </div>
                <div class="profile-item">
                    <span class="profile-item__label">Giới tính:</span>
                    <span class="profile-item__value"><?= htmlspecialchars($user['gioi_tinh'] ?? 'Chưa cập nhật') ?></span>
                </div>
               
            </div>

            <div style="margin-top: 30px;">
                <a href="<?= BASE_URL ?>index.php?url=user/update" class="account__button"><i class="fas fa-edit"></i>
                    Cập nhật tài khoản</a>
            </div>

        <?php elseif ($tab === 'addresses'): ?>
            <div class="account-content__header">
                <h2 class="account-content__title">Địa Chỉ Của Tôi </h2>
                <button onclick="document.getElementById('addAddressModal').style.display='flex'" class="account__button"><i class="fas fa-plus"></i> Thêm địa chỉ mới</button>
            </div>
            
            <?php if (isset($_SESSION['success_message'])): ?>
                <div style="padding: 15px; margin-bottom: 20px; background-color: #d4edda; color: #155724; border-radius: 8px;">
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <div class="address-grid" style="display: flex; flex-direction: column; gap: 20px;">
                <?php if (empty($userAddresses)): ?>
                    <div style="text-align: center; padding: 40px; background: #f9f9f9; border-radius: 8px; border: 1px dashed #ccc;">
                        <p style="color: #777;">Bạn chưa có địa chỉ nào trong sổ.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($userAddresses as $addr): ?>
                        <div class="address-card">
                            <?php if ($addr['is_default']): ?>
                                <span class="address-card__badge"><i class="fas fa-check-circle"></i> Mặc định</span>
                            <?php endif; ?>
                            <h4 style="margin: 0 0 10px 0; color: #333; font-size: 16px; display: flex; align-items: center; gap: 8px;">
                                <?= htmlspecialchars($addr['ho_ten']) ?>
                                <?php if ($addr['loai_dia_chi'] == 'VanPhong'): ?>
                                    <span style="font-size: 12px; background: #eef6f0; color: #2e5932; padding: 2px 8px; border-radius: 12px;"><i class="fas fa-building"></i> Văn phòng</span>
                                <?php else: ?>
                                    <span style="font-size: 12px; background: #eef6f0; color: #2e5932; padding: 2px 8px; border-radius: 12px;"><i class="fas fa-home"></i> Nhà riêng</span>
                                <?php endif; ?>
                            </h4>
                            <p style="margin: 5px 0; color: #555; font-size: 14px;"><i class="fas fa-phone-alt" style="width: 20px; color: #888;"></i> <?= htmlspecialchars($addr['so_dien_thoai']) ?></p>
                            <p style="margin: 5px 0; color: #555; font-size: 14px;"><i class="fas fa-map-marker-alt" style="width: 20px; color: #888;"></i> <?= htmlspecialchars($addr['dia_chi_chi_tiet'] . ', ' . $addr['ward_name'] . ', ' . $addr['district_name'] . ', ' . $addr['province_name']) ?></p>
                            
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; display: flex; gap: 15px;">
                                <?php if (!$addr['is_default']): ?>
                                    <a href="<?= BASE_URL ?>index.php?url=user/setDefaultAddress&id=<?= $addr['id'] ?>" style="color: #2e5932; font-weight: bold; font-size: 14px; text-decoration: none;">Thiết lập mặc định</a>
                                <?php endif; ?>
                                <a href="javascript:void(0)" onclick="openEditAddressModal(<?= htmlspecialchars(json_encode($addr), ENT_QUOTES, 'UTF-8') ?>)" style="color: #2e5932; font-weight: bold; font-size: 14px; text-decoration: none;">Sửa</a>
                                <a href="javascript:void(0)" onclick="showDeleteAddressConfirm(<?= $addr['id'] ?>)" style="color: #e74c3c; font-weight: bold; font-size: 14px; text-decoration: none;">Xóa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        <?php elseif ($tab === 'orders'): ?>
            <div class="account-content__header">
                <div>
                    <h2 class="account-content__title">Lịch Sử Mua Hàng</h2>
                    <p style="margin: 5px 0 0; color: #555; font-size: 15px;">Tổng tiền đã thanh toán: <strong
                            style="color: #355f2e; font-size: 18px;"><?= number_format($totalCompletedSpent) ?>đ</strong>
                    </p>
                </div>
            </div>

            <?php if (empty($orders)): ?>
                <div
                    style="text-align: center; padding: 60px 0; background: #fdfdfd; border-radius: 8px; border: 1px dashed #ccc;">
                    <i class="fas fa-box-open" style="font-size: 50px; color: #ddd; margin-bottom: 15px;"></i>
                    <p style="color: #777; font-size: 1.1rem; margin-bottom: 20px;">Bạn chưa có đơn hàng nào.</p>
                    <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="account__button">MUA SẮM NGAY</a>
                </div>
            <?php else: ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Đặt</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong style="color: #333;">#ORD<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong>
                                </td>
                                <td style="color: #666;"><?= date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now')) ?></td>
                                <td style="color: #355f2e; font-weight: 700;"><?= number_format($order['tong_tien']) ?>đ</td>
                                <td>
                                    <?php
                                    $statusClass = 'status-pending';
                                    if (($order['trang_thai'] ?? '') === 'HoanThanh')
                                        $statusClass = 'status-success';
                                    if (($order['trang_thai'] ?? '') === 'Huy')
                                        $statusClass = 'status-cancel';
                                    ?>
                                    <span
                                        class="order-status <?= $statusClass ?>"><?= htmlspecialchars($order['trang_thai'] ?? 'Chờ xử lý') ?></span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="viewOrder(<?= $order['id'] ?>)"
                                        style="color: #2e5932; font-weight: bold; text-decoration: none; margin-right: 15px;"><i
                                            class="fas fa-eye"></i> Xem</a>

                                    <?php
                                    // Logic: Chỉ cho phép hủy nếu đang Chờ Xác Nhận (chưa thanh toán QR / chưa duyệt COD).
                                    // Nếu đã Đang Giao, chỉ cho phép hủy nếu là đơn COD (vì chưa thu tiền). QR đã sang Đang Giao tức là đã thanh toán -> CẤM HỦY.
                                    $canCancel = false;
                                    if (($order['trang_thai'] ?? '') === 'ChoXacNhan')
                                        $canCancel = true;
                                    elseif (($order['trang_thai'] ?? '') === 'DangGiao' && ($order['phuong_thuc_thanh_toan'] ?? 'COD') === 'COD')
                                        $canCancel = true;
                                    ?>
                                    <?php if ($canCancel): ?>
                                        <a href="javascript:void(0)" onclick="showCancelConfirm(<?= $order['id'] ?>)"
                                            style="color: #e74c3c; font-weight: bold; text-decoration: none;"><i
                                                class="fas fa-times-circle"></i> Hủy</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php elseif ($tab === 'vouchers'): ?>
            <div class="account-content__header">
                <h2 class="account-content__title">Kho Voucher Của Bạn</h2>
            </div>

            <div class="voucher-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
                <?php if (empty($activeVouchers)): ?>
                    <div
                        style="grid-column: 1 / -1; text-align: center; padding: 60px 0; background: #fdfdfd; border-radius: 8px; border: 1px dashed #ccc;">
                        <i class="fas fa-ticket-alt" style="font-size: 50px; color: #ddd; margin-bottom: 15px;"></i>
                        <p style="color: #777; font-size: 1.1rem; margin-bottom: 20px;">Hiện tại chưa có mã giảm giá nào.</p>
                        <a href="<?= BASE_URL ?>index.php?url=product" class="account__button">MUA SẮM NGAY</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($activeVouchers as $v): ?>
                        <div class="user-voucher-card"
                            style="display: flex; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.03); transition: transform 0.3s, box-shadow 0.3s;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 15px rgba(0,0,0,0.08)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.03)'">
                            <div
                                style="background: <?= $v['loai_voucher'] == 'FreeShip' ? '#3498db' : '#2e5932' ?>; color: white; width: 90px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 28px; border-right: 2px dashed #eee; position: relative;">
                                <?= $v['loai_voucher'] == 'FreeShip' ? '<i class="fas fa-shipping-fast"></i>' : '<i class="fas fa-percent"></i>' ?>
                                <div
                                    style="position: absolute; right: -9px; top: -9px; width: 16px; height: 16px; background: white; border-radius: 50%; border: 1px solid #e0e0e0; border-top-color: transparent; border-right-color: transparent; transform: rotate(45deg);">
                                </div>
                                <div
                                    style="position: absolute; right: -9px; bottom: -9px; width: 16px; height: 16px; background: white; border-radius: 50%; border: 1px solid #e0e0e0; border-bottom-color: transparent; border-right-color: transparent; transform: rotate(-45deg);">
                                </div>
                            </div>
                            <div
                                style="padding: 15px 15px 15px 20px; flex: 1; background: #fff; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <h4 style="margin: 0 0 8px 0; color: #333; font-size: 16px;">
                                        <?php
                                        if ($v['loai_voucher'] == 'TienMat')
                                            echo 'Giảm ' . number_format($v['gia_tri']) . 'đ';
                                        elseif ($v['loai_voucher'] == 'PhanTram')
                                            echo 'Giảm ' . $v['gia_tri'] . '%';
                                        elseif ($v['loai_voucher'] == 'FreeShip')
                                            echo 'Miễn phí vận chuyển (tối đa ' . number_format($v['gia_tri']) . 'đ)';
                                        ?>
                                    </h4>
                                    <p style="margin: 0 0 12px 0; font-size: 13px; color: #666; line-height: 1.5;">
                                        Đơn tối thiểu <?= number_format($v['don_toi_thieu']) ?>đ
                                        <?php if ($v['loai_voucher'] == 'PhanTram' && $v['giam_toi_da'] > 0): ?>
                                            <br>Giảm tối đa <?= number_format($v['giam_toi_da']) ?>đ
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="font-size: 12px; color: #999;">
                                        HSD:
                                        <?= $v['ngay_het_han'] ? date('d/m/Y', strtotime($v['ngay_het_han'])) : 'Không giới hạn' ?>
                                    </div>
                                    <button onclick="copyVoucherCode('<?= htmlspecialchars($v['ma_voucher']) ?>')"
                                        style="background: #f8fbf9; border: 1px solid #2e5932; padding: 6px 12px; border-radius: 4px; font-weight: 600; color: #2e5932; cursor: pointer; font-size: 12px; transition: 0.3s;"
                                        onmouseover="this.style.background='#2e5932'; this.style.color='#fff'"
                                        onmouseout="this.style.background='#f8fbf9'; this.style.color='#2e5932'">Sao chép</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL XEM CHI TIẾT ĐƠN HÀNG (USER) -->
<div id="viewOrderModal"
    style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div
        style="background-color: #fff; margin: auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 800px; border-radius: 12px; position: relative; box-shadow: 0 5px 25px rgba(0,0,0,0.2);">
        <div
            style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
            <h3 style="margin: 0; color: #2e5932; font-family: 'Open Sans', sans-serif;">Chi Tiết Đơn Hàng #<span
                    id="detail_order_id"></span></h3>
            <span onclick="document.getElementById('viewOrderModal').style.display='none'"
                style="color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        </div>
        <div style="font-family: 'Open Sans', sans-serif; max-height: 65vh; overflow-y: auto; padding-right: 5px;">
            <div style="display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
                <div
                    style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px; color: #333;">Thông
                        tin đơn hàng</h4>
                    <p style="margin: 8px 0; color: #555;"><strong>Ngày đặt:</strong> <span id="detail_date"></span></p>
                    <p style="margin: 8px 0; color: #555;"><strong>Số điện thoại:</strong> <span id="detail_phone"></span></p>
                    <p style="margin: 8px 0; color: #555;"><strong>Email:</strong> <span id="detail_email"></span></p>
                    <p style="margin: 8px 0; color: #555;"><strong>Trạng thái:</strong> <span id="detail_status"></span>
                    </p>
                </div>
                <div
                    style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px; color: #333;">Thông
                        tin giao hàng</h4>
                    <p id="detail_address" style="line-height: 1.6; margin: 0; color: #555;"></p>
                    <p style="margin-top: 10px; color: #d35400;"><strong>Ghi chú:</strong> <span
                            id="detail_note"></span></p>
                </div>
            </div>
            <h4 style="margin-bottom: 10px; color: #333; font-family: 'Open Sans', sans-serif;">Sản phẩm đã mua</h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed;">
                <thead>
                    <tr style="background: #f8fbf9; border-bottom: 2px solid #eee;">
                        <th style="padding: 12px; text-align: left; color: #355F2E;">Sản phẩm</th>
                        <th style="padding: 12px; text-align: center; width: 60px; color: #355F2E;">SL</th>
                        <th style="padding: 12px; text-align: right; width: 120px; color: #355F2E;">Đơn giá</th>
                        <th style="padding: 12px; text-align: right; width: 120px; color: #355F2E;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="detail_items"></tbody>
            </table>
            <div id="detail_total_container" style="max-width: 400px; margin-left: auto; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #ccc;">
            </div>
        </div>
    </div>
</div>

<!-- Custom Modal Xác nhận Hủy Đơn Hàng -->
<div id="cancelConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Hủy Đơn Hàng</h3>
            <span class="custom-modal-close" onclick="closeCancelConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn hủy đơn hàng <strong id="cancel_order_display_id"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="cancel_order_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeCancelConfirmModal()">Không</button>
            <button type="button" class="btn btn-primary" id="confirmCancelBtn">Đồng ý</button>
        </div>
    </div>
</div>

<!-- Custom Modal Xác nhận Xóa Địa Chỉ -->
<div id="deleteAddressConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Địa Chỉ</h3>
            <span class="custom-modal-close" onclick="closeDeleteAddressConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa địa chỉ này không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_address_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteAddressConfirmModal()">Không</button>
            <button type="button" class="btn btn-primary" id="confirmDeleteAddressBtn">Đồng ý</button>
        </div>
    </div>
</div>

<!-- MODAL THÊM ĐỊA CHỈ -->
<div id="addAddressModal" class="custom-modal">
    <div class="custom-modal-content" style="max-width: 600px;">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Thêm Địa Chỉ Mới</h3>
            <span class="custom-modal-close" onclick="document.getElementById('addAddressModal').style.display='none'">&times;</span>
        </div>
        <form action="<?= BASE_URL ?>index.php?url=user/addAddress" method="POST">
            <div class="custom-modal-body" style="text-align: left; padding: 10px 0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Họ và tên *</label>
                        <input type="text" name="ho_ten" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Nhập họ tên">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Số điện thoại *</label>
                        <input type="text" name="so_dien_thoai" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Nhập SĐT">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Tỉnh/Thành phố *</label>
                        <select id="addr_province" name="province_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Tỉnh/Thành</option>
                        </select>
                        <input type="hidden" name="province_name" id="addr_province_name">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Quận/Huyện *</label>
                        <select id="addr_district" name="district_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Quận/Huyện</option>
                        </select>
                        <input type="hidden" name="district_name" id="addr_district_name">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Phường/Xã *</label>
                        <select id="addr_ward" name="ward_code" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Phường/Xã</option>
                        </select>
                        <input type="hidden" name="ward_name" id="addr_ward_name">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Địa chỉ cụ thể *</label>
                    <input type="text" name="dia_chi_chi_tiet" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Số nhà, tên đường...">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Loại địa chỉ</label>
                    <div style="display: flex; gap: 20px;">
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;"><input type="radio" name="loai_dia_chi" value="NhaRieng" checked> Nhà riêng</label>
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;"><input type="radio" name="loai_dia_chi" value="VanPhong"> Văn phòng</label>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_default" value="1">
                        Đặt làm địa chỉ mặc định
                    </label>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('addAddressModal').style.display='none'">Hủy</button>
                <button type="submit" class="btn" style="background: #2e5932; color: #fff;">Lưu Địa Chỉ</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL SỬA ĐỊA CHỈ -->
<div id="editAddressModal" class="custom-modal">
    <div class="custom-modal-content" style="max-width: 600px;">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Cập Nhật Địa Chỉ</h3>
            <span class="custom-modal-close" onclick="document.getElementById('editAddressModal').style.display='none'">&times;</span>
        </div>
        <form action="<?= BASE_URL ?>index.php?url=user/updateAddress" method="POST">
            <input type="hidden" name="id" id="edit_addr_id">
            <div class="custom-modal-body" style="text-align: left; padding: 10px 0;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Họ và tên *</label>
                        <input type="text" name="ho_ten" id="edit_addr_name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Nhập họ tên">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Số điện thoại *</label>
                        <input type="text" name="so_dien_thoai" id="edit_addr_phone" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Nhập SĐT">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Tỉnh/Thành phố *</label>
                        <select id="edit_addr_province" name="province_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Tỉnh/Thành</option>
                        </select>
                        <input type="hidden" name="province_name" id="edit_addr_province_name">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Quận/Huyện *</label>
                        <select id="edit_addr_district" name="district_id" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Quận/Huyện</option>
                        </select>
                        <input type="hidden" name="district_name" id="edit_addr_district_name">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Phường/Xã *</label>
                        <select id="edit_addr_ward" name="ward_code" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;">
                            <option value="">Chọn Phường/Xã</option>
                        </select>
                        <input type="hidden" name="ward_name" id="edit_addr_ward_name">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Địa chỉ cụ thể *</label>
                    <input type="text" name="dia_chi_chi_tiet" id="edit_addr_detail" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px;" placeholder="Số nhà, tên đường...">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">Loại địa chỉ</label>
                    <div style="display: flex; gap: 20px;">
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;"><input type="radio" name="loai_dia_chi" id="edit_addr_type_home" value="NhaRieng"> Nhà riêng</label>
                        <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;"><input type="radio" name="loai_dia_chi" id="edit_addr_type_office" value="VanPhong"> Văn phòng</label>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_default" id="edit_addr_default" value="1">
                        Đặt làm địa chỉ mặc định
                    </label>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('editAddressModal').style.display='none'">Hủy</button>
                <button type="submit" class="btn" style="background: #2e5932; color: #fff;">Lưu Thay Đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
    function viewOrder(id) {
        fetch('<?= BASE_URL ?>index.php?url=order/api_get_order&id=' + id)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const order = res.data;
                    document.getElementById('detail_order_id').innerText = order.id.toString().padStart(5, '0');

                    // Format thời gian thành dạng d/m/Y H:i
                    let dateStr = order.created_at;
                    let parts = dateStr.split(/[- :]/);
                    if (parts.length >= 5) {
                        dateStr = `${parts[2]}/${parts[1]}/${parts[0]} ${parts[3]}:${parts[4]}`;
                    }
                    document.getElementById('detail_date').innerText = dateStr;
                    document.getElementById('detail_phone').innerText = order.sdt_nguoi_nhan || 'Không có';
                    document.getElementById('detail_email').innerText = order.user_email || 'Không có';

                    let badgeClass = 'status-pending';
                    if (order.trang_thai === 'HoanThanh') badgeClass = 'status-success';
                    if (order.trang_thai === 'Huy' || order.trang_thai === 'DaHuy') badgeClass = 'status-cancel';
                    document.getElementById('detail_status').innerHTML = `<span class="order-status ${badgeClass}">${order.trang_thai}</span>`;

                    document.getElementById('detail_address').innerHTML = (order.dia_chi_giao || '').replace(/ \| /g, '<br>');
                    document.getElementById('detail_note').innerText = order.ghi_chu || 'Không có';

                    let tbody = '';
                    let tong_san_pham = 0;
                    if (order.items && order.items.length > 0) {
                        order.items.forEach(item => {
                            let price = parseInt(item.gia);
                            let subtotal = price * parseInt(item.so_luong);
                            tong_san_pham += subtotal;
                            tbody += `<tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?= BASE_URL ?>uploads/${item.anh}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #eee; flex-shrink: 0;">
                                    <span style="font-weight: 500; color: #333; word-break: break-word;">${item.ten_sp}</span>
                                </div>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center; font-weight: bold; color: #555;">${item.so_luong}</td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: right; color: #666;">${price.toLocaleString('vi-VN')}đ</td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold; color: #333;">${subtotal.toLocaleString('vi-VN')}đ</td>
                        </tr>`;
                        });
                    } else {
                        tbody = `<tr><td colspan="4" style="text-align:center; padding: 20px; color: #777;">Không có chi tiết sản phẩm</td></tr>`;
                    }
                    document.getElementById('detail_items').innerHTML = tbody;

                    let giam_gia_thanh_vien = parseInt(order.giam_gia_thanh_vien) || 0;
                    let phi_van_chuyen = parseInt(order.phi_van_chuyen) || 0;
                    let giam_gia_voucher = parseInt(order.giam_gia_voucher) || 0;
                    let ma_voucher = order.ma_voucher || '';
                    let tong_tien = parseInt(order.tong_tien) || 0;
                    let tien_truoc_thue = tong_san_pham - giam_gia_thanh_vien + phi_van_chuyen - giam_gia_voucher;
                    tien_truoc_thue = Math.max(0, tien_truoc_thue);
                    let thue_gtgt = Math.round(tien_truoc_thue * 0.08);
                    tong_tien = tien_truoc_thue + thue_gtgt;

                    let totalsHtml = `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #555;">Tổng tiền hàng:</span>
                            <span style="font-weight: bold; color: #333;">${tong_san_pham.toLocaleString('vi-VN')}đ</span>
                        </div>
                    `;
                    if (giam_gia_thanh_vien > 0) {
                        totalsHtml += `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #555;">Giảm giá hạng thành viên:</span>
                            <span style="font-weight: bold; color: #333;">-${giam_gia_thanh_vien.toLocaleString('vi-VN')}đ</span>
                        </div>`;
                    }
                    totalsHtml += `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #555;">Phí vận chuyển:</span>
                            <span style="font-weight: bold; color: #333;">${phi_van_chuyen === 0 ? 'Miễn phí' : phi_van_chuyen.toLocaleString('vi-VN') + 'đ'}</span>
                        </div>`;
                    if (giam_gia_voucher > 0) {
                        totalsHtml += `
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #555;">Mã giảm giá (${ma_voucher}):</span>
                            <span style="font-weight: bold; color: #333;">-${giam_gia_voucher.toLocaleString('vi-VN')}đ</span>
                        </div>`;
                    }
                    totalsHtml += `
                        <div style="border-top: 1px dashed #ccc; margin: 10px 0;"></div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #555;">Tiền trước thuế:</span>
                            <span style="font-weight: bold; color: #333;">${tien_truoc_thue.toLocaleString('vi-VN')}đ</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px dashed #ccc; padding-bottom: 15px;">
                            <span style="color: #555;">Thuế GTGT (8%):</span>
                            <span style="font-weight: bold; color: #333;">${thue_gtgt.toLocaleString('vi-VN')}đ</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 16px; color: #555; font-weight: bold;">Tổng thanh toán:</span>
                            <span style="font-size: 22px; color: #e74c3c; font-weight: bold;">${tong_tien.toLocaleString('vi-VN')}đ</span>
                        </div>`;
                    document.getElementById('detail_total_container').innerHTML = totalsHtml;

                    document.getElementById('viewOrderModal').style.display = 'flex';
                } else { alert(res.msg || 'Không thể lấy thông tin đơn hàng'); }
            })
            .catch(err => { console.error(err); alert('Lỗi kết nối đến máy chủ.'); });
    }

    // JavaScript cho modal hủy đơn hàng
    function showCancelConfirm(orderId) {
        document.getElementById('cancel_order_display_id').innerText = '#' + orderId.toString().padStart(5, '0');
        document.getElementById('cancel_order_id_input').value = orderId;
        document.getElementById('cancelConfirmModal').style.display = 'flex';
    }

    function closeCancelConfirmModal() {
        document.getElementById('cancelConfirmModal').style.display = 'none';
    }

    document.getElementById('confirmCancelBtn').addEventListener('click', function () {
        const orderId = document.getElementById('cancel_order_id_input').value;
        window.location.href = `<?= BASE_URL ?>index.php?url=order/cancel&id=${orderId}`;
    });

    // JavaScript cho modal xóa địa chỉ
    function showDeleteAddressConfirm(addressId) {
        document.getElementById('delete_address_id_input').value = addressId;
        document.getElementById('deleteAddressConfirmModal').style.display = 'flex';
    }

    function closeDeleteAddressConfirmModal() {
        document.getElementById('deleteAddressConfirmModal').style.display = 'none';
    }

    document.getElementById('confirmDeleteAddressBtn').addEventListener('click', function () {
        const addressId = document.getElementById('delete_address_id_input').value;
        window.location.href = `<?= BASE_URL ?>index.php?url=user/deleteAddress&id=${addressId}`;
    });

    function openEditAddressModal(address) {
        document.getElementById('edit_addr_id').value = address.id;
        document.getElementById('edit_addr_name').value = address.ho_ten;
        document.getElementById('edit_addr_phone').value = address.so_dien_thoai;
        document.getElementById('edit_addr_detail').value = address.dia_chi_chi_tiet;
        
        if(address.loai_dia_chi === 'VanPhong') {
            document.getElementById('edit_addr_type_office').checked = true;
        } else {
            document.getElementById('edit_addr_type_home').checked = true;
        }
        
        document.getElementById('edit_addr_default').checked = (address.is_default == 1);
        
        document.getElementById('edit_addr_province_name').value = address.province_name;
        document.getElementById('edit_addr_district_name').value = address.district_name;
        document.getElementById('edit_addr_ward_name').value = address.ward_name;

        const provEl = document.getElementById('edit_addr_province');
        
        if (provEl.options.length <= 1) {
            const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';
            fetch(ghnApiUrl + 'get_provinces')
                .then(res => res.json())
                .then(res => {
                    if (res.code === 200) {
                        res.data.forEach(p => {
                            let option = document.createElement('option');
                            option.value = p.ProvinceID;
                            option.text = p.ProvinceName;
                            option.dataset.name = p.ProvinceName;
                            provEl.appendChild(option);
                        });
                        provEl.value = address.province_id;
                        loadDistrictsForEdit(address.province_id, address.district_id, address.ward_code);
                    }
                });
        } else {
            provEl.value = address.province_id;
            loadDistrictsForEdit(address.province_id, address.district_id, address.ward_code);
        }
        
        document.getElementById('editAddressModal').style.display = 'flex';
    }

    // Đóng modal khi click ra ngoài khung
    window.onclick = function (event) {
        let modal = document.getElementById('viewOrderModal');
        let cancelModal = document.getElementById('cancelConfirmModal');
        let addAddressModal = document.getElementById('addAddressModal');
        let deleteAddressModal = document.getElementById('deleteAddressConfirmModal');
        let editAddressModal = document.getElementById('editAddressModal');
        if (event.target === modal) {
            modal.style.display = "none";
        }
        if (event.target === cancelModal) {
            cancelModal.style.display = "none";
        }
        if (event.target === addAddressModal) {
            addAddressModal.style.display = "none";
        }
        if (event.target === deleteAddressModal) {
            deleteAddressModal.style.display = "none";
        }
        if (event.target === editAddressModal) {
            editAddressModal.style.display = "none";
        }
    }

    // JS CHO MODAL THÊM ĐỊA CHỈ (GỌI API GHN)
    document.addEventListener("DOMContentLoaded", function () {
        const provEl = document.getElementById('addr_province');
        const distEl = document.getElementById('addr_district');
        const wardEl = document.getElementById('addr_ward');
        
        if (provEl && distEl && wardEl) {
            const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';
            
            // Load Provinces
            fetch(ghnApiUrl + 'get_provinces')
                .then(res => res.json())
                .then(res => {
                    if (res.code === 200) {
                        res.data.forEach(p => {
                            let option = document.createElement('option');
                            option.value = p.ProvinceID;
                            option.text = p.ProvinceName;
                            option.dataset.name = p.ProvinceName;
                            provEl.appendChild(option);
                        });
                    }
                });

            provEl.addEventListener('change', function () {
                document.getElementById('addr_province_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
                distEl.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                wardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                if (!this.value) return;

                fetch(ghnApiUrl + 'get_districts&province_id=' + this.value)
                    .then(res => res.json())
                    .then(res => {
                        if (res.code === 200) {
                            res.data.forEach(d => {
                                let option = document.createElement('option');
                                option.value = d.DistrictID;
                                option.text = d.DistrictName;
                                option.dataset.name = d.DistrictName;
                                distEl.appendChild(option);
                            });
                        }
                    });
            });

            distEl.addEventListener('change', function () {
                document.getElementById('addr_district_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
                wardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                if (!this.value) return;

                fetch(ghnApiUrl + 'get_wards&district_id=' + this.value)
                    .then(res => res.json())
                    .then(res => {
                        if (res.code === 200) {
                            res.data.forEach(w => {
                                let option = document.createElement('option');
                                option.value = w.WardCode;
                                option.text = w.WardName;
                                option.dataset.name = w.WardName;
                                wardEl.appendChild(option);
                            });
                        }
                    });
            });

            wardEl.addEventListener('change', function () {
                document.getElementById('addr_ward_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
            });
        }

        // Gắn sự kiện cho form sửa địa chỉ
        const editProvEl = document.getElementById('edit_addr_province');
        const editDistEl = document.getElementById('edit_addr_district');
        const editWardEl = document.getElementById('edit_addr_ward');
        
        if (editProvEl && editDistEl && editWardEl) {
            const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';
            
            editProvEl.addEventListener('change', function () {
                document.getElementById('edit_addr_province_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
                editDistEl.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
                editWardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                if (!this.value) return;

                loadDistrictsForEdit(this.value, null, null);
            });

            editDistEl.addEventListener('change', function () {
                document.getElementById('edit_addr_district_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
                editWardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
                if (!this.value) return;

                loadWardsForEdit(this.value, null);
            });

            editWardEl.addEventListener('change', function () {
                document.getElementById('edit_addr_ward_name').value = this.options[this.selectedIndex]?.dataset?.name || '';
            });
        }
    });

    function loadDistrictsForEdit(provinceId, districtIdToSelect, wardCodeToSelect) {
        const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';
        const distEl = document.getElementById('edit_addr_district');
        distEl.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        fetch(ghnApiUrl + 'get_districts&province_id=' + provinceId)
            .then(res => res.json())
            .then(res => {
                if (res.code === 200) {
                    res.data.forEach(d => {
                        let option = document.createElement('option');
                        option.value = d.DistrictID;
                        option.text = d.DistrictName;
                        option.dataset.name = d.DistrictName;
                        distEl.appendChild(option);
                    });
                    if (districtIdToSelect) {
                        distEl.value = districtIdToSelect;
                        loadWardsForEdit(districtIdToSelect, wardCodeToSelect);
                    }
                }
            });
    }

    function loadWardsForEdit(districtId, wardCodeToSelect) {
        const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';
        const wardEl = document.getElementById('edit_addr_ward');
        wardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        fetch(ghnApiUrl + 'get_wards&district_id=' + districtId)
            .then(res => res.json())
            .then(res => {
                if (res.code === 200) {
                    res.data.forEach(w => {
                        let option = document.createElement('option');
                        option.value = w.WardCode;
                        option.text = w.WardName;
                        option.dataset.name = w.WardName;
                        wardEl.appendChild(option);
                    });
                    if (wardCodeToSelect) {
                        wardEl.value = wardCodeToSelect;
                    }
                }
            });
    }
</script>

<script>
    function copyVoucherCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            // Tự động tạo một toast nhỏ báo thành công
            const toast = document.createElement('div');
            toast.innerText = `Đã sao chép mã: ${code}`;
            toast.style.cssText = 'position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); background: #355F2E; color: white; padding: 10px 20px; border-radius: 5px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); z-index: 9999; font-family: Open Sans; font-size: 14px;';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }).catch(err => {
            alert('Không thể sao chép mã. Vui lòng thử lại.');
        });
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
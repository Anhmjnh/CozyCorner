<?php
// view/order/ThanhToan.php

if (!isset($cartItems)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=order/checkout");
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    /* TRANG THANH TOÁN --- */
    .checkout-wrapper {
        max-width: 1200px;
        margin: 30px auto 80px auto;
        padding: 0 20px;
        color: #333;
        font-family: 'Open Sans', sans-serif;
    }

    .checkout__title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        color: #2e5932;
        text-transform: uppercase;
    }

    .checkout__container {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    /* CỘT TRÁI - FORM */
    .checkout__left {
        flex: 1;
        background: #fff;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #eaeaea;
    }

    .checkout__subtitle {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
        color: #2e5932;
    }

    .checkout__group {
        margin-bottom: 20px;
    }

    .checkout__label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 15px;
        color: #555;
    }

    .checkout__input,
    .checkout__textarea {
        width: 100%;
        padding: 14px 15px;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        font-size: 15px;
        box-sizing: border-box;
        transition: border-color 0.3s;
        font-family: inherit;
        background-color: #fdfdfd;
    }

    .checkout__input:focus,
    .checkout__textarea:focus {
        outline: none;
        border-color: #2e5932;
        background-color: #fff;
    }

    .checkout__input[readonly] {
        background-color: #f2f2f2;
        color: #888;
        cursor: not-allowed;
    }

    /* PHƯƠNG THỨC THANH TOÁN */
    .checkout__payment-methods {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .checkout__payment-method {
        display: flex;
        align-items: center;
        padding: 16px;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }

    .checkout__payment-method:hover {
        border-color: #2e5932;
        background: #f8fbf9;
    }

    .checkout__payment-method input[type="radio"] {
        margin-right: 15px;
        transform: scale(1.3);
        accent-color: #2e5932;
    }

    .checkout__payment-method span {
        font-size: 16px;
        font-weight: 600;
        color: #444;
    }

    /* CỘT PHẢI - ĐƠN HÀNG */
    .checkout__right {
        width: 420px;
        flex-shrink: 0;
        background: #fff;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #eaeaea;
        position: sticky;
        top: 20px;
    }

    .checkout__product-list {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 20px;
        max-height: 350px;
        overflow-y: auto;
    }

    .checkout__product-list::-webkit-scrollbar {
        width: 6px;
    }

    .checkout__product-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    .checkout__product-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .checkout__product-img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eaeaea;
    }

    .checkout__product-info {
        flex: 1;
    }

    .checkout__product-name {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: #333;
        line-height: 1.4;
    }

    .checkout__product-qty {
        font-size: 13px;
        color: #7f8c8d;
    }

    .checkout__product-price {
        font-weight: bold;
        color: #333;
        font-size: 15px;
    }

    .checkout__totals {
        margin-bottom: 25px;
        padding-top: 20px;
        border-top: 1px solid #eaeaea;
    }

    .checkout__total-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 15px;
        color: #555;
    }

    .checkout__total-line--final {
        font-size: 20px;
        font-weight: 700;
        color: #2e5932;
        padding-top: 20px;
        border-top: 2px dashed #eaeaea;
        margin-top: 10px;
    }

    .checkout__submit-btn {
        width: 100%;
        padding: 16px;
        background: #2e5932;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .checkout__submit-btn:hover {
        background: #1f4023;
        box-shadow: 0 4px 15px rgba(46, 89, 50, 0.4);
    }

    /* --- MODAL THÔNG BÁO LỖI --- */
    .checkout-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }

    .checkout-modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 25px;
        border: 1px solid #888;
        width: 95%;
        max-width: 480px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation-name: animatetop;
        animation-duration: 0.4s;
        text-align: center;
    }

    .checkout-modal-icon {
        font-size: 50px;
        color: #e74c3c;
        /* Màu đỏ lỗi */
        margin-bottom: 20px;
    }

    .checkout-modal-title {
        margin: 0 0 10px 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
    }

    .checkout-modal-body {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 25px;
    }

    .checkout-modal-footer {
        display: flex;
        justify-content: center;
    }

    .checkout-modal-button {
        padding: 12px 30px;
        background: #355f2e;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .checkout-modal-button:hover {
        background: #1f4023;
    }

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

    /* --- CSS CHO VOUCHER --- */
    .voucher-section {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eaeaea;
    }

    .voucher-title {
        font-size: 15px;
        font-weight: 600;
        margin: 0 0 12px 0;
        color: #333;
    }

    .voucher-input-group {
        display: flex;
        gap: 10px;
        align-items: stretch;
        width: 100%;
    }

    .voucher-input-group input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        font-size: 14px;
        background-color: #fdfdfd;
        transition: all 0.3s;
    }

    .voucher-input-group input:focus {
        border-color: #2e5932;
        background-color: #fff;
    }

    .btn-apply-voucher,
    .btn-select-voucher {
        padding: 0 13px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        white-space: nowrap;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        border: 1px solid transparent;
    }

    .btn-apply-voucher {
        background: #2e5932;
        color: white;
    }

    .btn-apply-voucher:hover {
        background: #1f4023;
    }

    .btn-select-voucher {
        background: #f8fbf9;
        color: #2e5932;
        border-color: #2e5932;
        gap: 6px;
    }

    .btn-select-voucher:hover {
        background: #eef6f0;
    }

    .voucher-message {
        margin-top: 10px;
        font-size: 13px;
        min-height: 18px;
    }

    .highlight-green {
        color: #2e5932 !important;
        font-weight: 600;
    }

    /* --- CSS VOUCHER MODAL (POPUP) --- */
    .voucher-modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .voucher-modal-content {
        background-color: white;
        padding: 25px;
        border-radius: 12px;
        width: 90%;
        max-width: 450px;
        position: relative;
        max-height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: animatetop 0.4s;
    }

    .voucher-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .voucher-modal-title {
        margin: 0;
        font-size: 18px;
        color: #2e5932;
        font-weight: bold;
    }

    .close-voucher-modal {
        font-size: 24px;
        cursor: pointer;
        color: #999;
        font-weight: bold;
        line-height: 1;
    }

    .close-voucher-modal:hover {
        color: #333;
    }

    .voucher-list {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-right: 5px;
    }

    .voucher-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        gap: 15px;
        transition: 0.3s;
    }

    .voucher-item:hover {
        border-color: #2e5932;
        background: #f8fbf9;
    }

    .voucher-icon {
        font-size: 24px;
        background: #eef6f0;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        flex-shrink: 0;
        color: #2e5932;
    }

    .voucher-info {
        flex: 1;
    }

    .voucher-info strong {
        display: block;
        color: #2e5932;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .voucher-info p {
        margin: 0;
        font-size: 13px;
        color: #555;
    }

    .voucher-info small {
        color: #888;
        font-size: 12px;
        display: block;
        margin-top: 4px;
    }

    .btn-use-voucher {
        background: #2e5932;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        white-space: nowrap;
        transition: 0.3s;
    }

    .btn-use-voucher:hover {
        background: #1f4023;
    }

    .voucher-list::-webkit-scrollbar {
        width: 6px;
    }

    .voucher-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    @media (max-width: 900px) {
        .checkout__container {
            flex-direction: column;
        }

        .checkout__left,
        .checkout__right {
            flex: 1 1 100%;
            width: 100%;
        }

        .checkout__right {
            position: static;
        }
    }
</style>

<!-- BREADCRUMB -->
<ul class="breadcrumb"
    style="max-width: 1200px; margin: 20px auto; padding: 0 20px; list-style: none; display: flex; gap: 10px; align-items: center; color: #555;">
    <li><a href="<?= BASE_URL ?>" style="color: #333; text-decoration: none;">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt=">" style="width: 12px; opacity: 0.5;"></li>
    <li><a href="<?= BASE_URL ?>view/cart/ChiTietGioHang.php" style="color: #333; text-decoration: none;">Giỏ hàng chi
            tiết</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" alt=">" style="width: 12px; opacity: 0.5;"></li>
    <li style="color: #333; text-decoration: none;">Thanh toán</li>
</ul>


<div class="checkout-wrapper">
    <h1 class="checkout__title">Thanh Toán Đơn Hàng</h1>

    <div class="checkout__container">

        <div class="checkout__left">
            <h2 class="checkout__subtitle">Thông Tin Giao Hàng</h2>

            <!-- KHỐI CHỌN ĐỊA CHỈ  -->
            <?php if (!$is_guest && !empty($userAddresses)): ?>
                <div class="saved-address-container checkout__group">
                    <label class="checkout__label" style="color: #2e5932;">Địa chỉ</label>
                    <select id="saved_address_select" class="form-select"
                        style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                        <option value="">-- + Thêm địa chỉ mới --</option>
                        <?php foreach ($userAddresses as $addr): ?>
                            <option value="<?= $addr['id'] ?>" data-name="<?= htmlspecialchars($addr['ho_ten']) ?>"
                                data-phone="<?= htmlspecialchars($addr['so_dien_thoai']) ?>"
                                data-province="<?= $addr['province_id'] ?>" data-district="<?= $addr['district_id'] ?>"
                                data-ward="<?= $addr['ward_code'] ?>"
                                data-detail="<?= htmlspecialchars($addr['dia_chi_chi_tiet']) ?>" <?= $addr['is_default'] ? 'selected' : '' ?>>
                                <?= $addr['loai_dia_chi'] == 'VanPhong' ? '' : '' ?>
                                <?= htmlspecialchars($addr['ho_ten']) ?> - <?= htmlspecialchars($addr['so_dien_thoai']) ?>
                                (<?= htmlspecialchars($addr['dia_chi_chi_tiet'] . ', ' . $addr['ward_name'] . ', ' . $addr['district_name']) ?>)
                                <?= $addr['is_default'] ? '[Mặc định]' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>


            <form action="<?= BASE_URL ?>index.php?url=order/process" method="POST" id="checkout-form"
                class="checkout__form">
                <div class="checkout__group">
                    <label for="ho_ten" class="checkout__label">Họ và tên *</label>
                    <input type="text" id="ho_ten" name="ho_ten" class="checkout__input"
                        value="<?= htmlspecialchars($data['user']['ho_ten'] ?? '') ?>" required>
                </div>

                <?php if ($data['is_guest']): ?>
                    <div class="checkout__group">
                        <label for="email" class="checkout__label">Email </label>
                        <input type="email" id="email" name="email" class="checkout__input" value="" required
                            placeholder="Nhập email của bạn...">
                    </div>
                <?php else: ?>
                    <div class="checkout__group">
                        <label for="email" class="checkout__label">Email *</label>
                        <input type="email" id="email" name="email" class="checkout__input"
                            value="<?= htmlspecialchars($data['user']['email'] ?? '') ?>" required readonly>
                    </div>
                <?php endif; ?>

                <div class="checkout__group">
                    <label for="so_dien_thoai" class="checkout__label">Số điện thoại *</label>
                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="checkout__input"
                        value="<?= htmlspecialchars($data['user']['so_dien_thoai'] ?? '') ?>" required>
                </div>

                <div class="checkout__group">
                    <label class="checkout__label">Tỉnh/Thành phố *</label>
                    <select id="province" class="checkout__input" required>
                        <option value="">Chọn Tỉnh/Thành</option>
                    </select>
                </div>
                <div class="checkout__group">
                    <label class="checkout__label">Quận/Huyện *</label>
                    <select id="district" class="checkout__input" required>
                        <option value="">Chọn Quận/Huyện</option>
                    </select>
                </div>
                <div class="checkout__group">
                    <label class="checkout__label">Phường/Xã *</label>
                    <select id="ward" class="checkout__input" required>
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                </div>
                <div class="checkout__group">
                    <label class="checkout__label">Số nhà, Tên đường *</label>
                    <input type="text" id="dia_chi_chi_tiet" class="checkout__input"
                        placeholder="Nhập số nhà, tên đường..." required>
                </div>

                <?php if (!$data['is_guest']): ?>
                    <div class="checkout__group" id="save_address_wrapper" style="margin-top: -10px;">
                        <label
                            style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #555; font-size: 14px;">
                            <input type="checkbox" name="save_address" id="save_address" value="1" checked
                                style="width: 16px; height: 16px; accent-color: #2e5932;">
                            Lưu thông tin giao hàng này vào địa chỉ
                        </label>
                    </div>
                <?php endif; ?>

                <!-- Input ẩn dùng để tự động nối địa chỉ dài và gửi phí ship -->
                <input type="hidden" name="dia_chi" id="dia_chi_day_du" value="">
                <input type="hidden" name="phi_ship" id="phi_ship_input" value="0">
                <input type="hidden" name="to_district_id" id="to_district_id_input" value="">
                <input type="hidden" name="to_ward_code" id="to_ward_code_input" value="">
                <input type="hidden" name="ma_voucher" id="hidden_ma_voucher" value="">

                <div class="checkout__group">
                    <label for="ghi_chu" class="checkout__label">Ghi chú đơn hàng (Tùy chọn)</label>
                    <textarea id="ghi_chu" name="ghi_chu" class="checkout__textarea" rows="4"
                        placeholder="Ví dụ: Giao hàng giờ hành chính..."></textarea>
                </div>

                <h2 class="checkout__subtitle" style="margin-top: 30px;">Phương Thức Thanh Toán</h2>
                <div class="checkout__payment-methods">
                    <label class="checkout__payment-method">
                        <input type="radio" name="phuong_thuc_thanh_toan" value="COD" checked>
                        <span>Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="checkout__payment-method">
                        <input type="radio" name="phuong_thuc_thanh_toan" value="ChuyenKhoan">
                        <span>Chuyển khoản qua Ngân hàng </span>
                    </label>
                </div>

                <!-- KHỐI XUẤT HÓA ĐƠN CÔNG TY -->
                <h2 class="checkout__subtitle" style="margin-top: 30px;">Thông Tin Hóa Đơn (Tùy chọn)</h2>
                <div class="company-invoice-section">
                    <div class="checkout__group">
                        <label
                            style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #2e5932; font-weight: bold;">
                            <input type="checkbox" id="xuat_hoa_don_cong_ty" name="xuat_hoa_don_cong_ty" value="1"
                                style="width: 18px; height: 18px; accent-color: #2e5932;">
                             Xuất hóa đơn GTGT  (VAT)
                        </label>
                    </div>

                    <div id="company_invoice_form"
                        style="display: none; background: #f9f9f9; padding: 20px; border: 1px solid #eaeaea; border-radius: 8px; margin-bottom: 20px;">
                        <div class="checkout__group">
                            <label class="checkout__label">Tên công ty *</label>
                            <input type="text" name="ten_cong_ty" id="ten_cong_ty" class="checkout__input">
                        </div>
                        <div class="checkout__group">
                            <label class="checkout__label">Mã số thuế *</label>
                            <input type="text" name="ma_so_thue" id="ma_so_thue" class="checkout__input"
                                pattern="[0-9\-]{10,14}">
                        </div>
                        <div class="checkout__group">
                            <label class="checkout__label">Địa chỉ công ty *</label>
                            <input type="text" name="dia_chi_cong_ty" id="dia_chi_cong_ty" class="checkout__input">
                        </div>
                        <div class="checkout__group" style="margin-bottom: 0;">
                            <label class="checkout__label">Email nhận hóa đơn *</label>
                            <input type="email" name="email_nhan_hoa_don" id="email_nhan_hoa_don"
                                class="checkout__input">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG -->
        <div class="checkout__right">
            <h2 class="checkout__subtitle">Đơn Hàng Của Bạn</h2>
            <div class="checkout__summary">

                <!-- Danh sách sản phẩm mua -->
                <ul class="checkout__product-list">
                    <?php if (!empty($data['cartItems'])): ?>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <li class="checkout__product-item">
                                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['image']) ?>"
                                    alt="<?= htmlspecialchars($item['name']) ?>" class="checkout__product-img">
                                <div class="checkout__product-info">
                                    <h4 class="checkout__product-name"><?= htmlspecialchars($item['name']) ?></h4>
                                    <span class="checkout__product-qty">Số lượng: <?= $item['quantity'] ?></span>
                                </div>
                                <div class="checkout__product-price">
                                    <?= number_format($item['price'] * $item['quantity']) ?>đ
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; color: #7f8c8d; font-size: 15px;">Chưa có sản phẩm nào</p>
                    <?php endif; ?>
                </ul>

                <?php if (!$data['is_guest']): ?>
                    <div class="voucher-section">
                        <h4 class="voucher-title">Mã giảm giá / Freeship</h4>
                        <div class="voucher-input-group">
                            <input type="text" id="ma_voucher_input" placeholder="Nhập mã..." autocomplete="off">
                            <button type="button" id="btn-show-vouchers" class="btn-select-voucher"><i
                                    class="fas fa-ticket-alt"></i> Chọn</button>
                            <button type="button" id="btn-apply-voucher" class="btn-apply-voucher">Áp dụng</button>
                        </div>
                        <div id="voucher-message" class="voucher-message"></div>
                    </div>
                <?php endif; ?>

                <div class="checkout__totals">
                    <div class="checkout__total-line">
                        <span>Tạm tính:</span>
                        <span id="summary-total-price" data-price="<?= $data['totalPrice'] ?>"
                            style="font-weight: 600;"><?= number_format($data['totalPrice']) ?>đ</span>
                    </div>

                    <?php if (!$data['is_guest'] && isset($data['giamGiaThanhVien']) && $data['giamGiaThanhVien'] > 0): ?>
                        <div class="checkout__total-line highlight-green">
                            <span>Hạng <?= htmlspecialchars($data['user']['hang'] ?? 'Đồng') ?>
                                (-<?= $data['phanTramGiam'] ?>%):</span>
                            <span>-<?= number_format($data['giamGiaThanhVien']) ?>đ</span>
                        </div>
                    <?php endif; ?>

                    <div class="checkout__total-line">
                        <span>Phí vận chuyển:</span>
                        <span id="summary-shipping-fee" data-fee="0" style="font-weight: 600;">0đ</span>
                    </div>
                    <?php if (!$data['is_guest']): ?>
                        <div class="checkout__total-line highlight-green" id="voucher-discount-line" style="display: none;">
                            <span>Mã giảm giá:</span>
                            <span id="summary-voucher-discount">-0đ</span>
                        </div>
                    <?php endif; ?>
                    <div id="vat-breakdown" style="border-top: 1px dashed #eaeaea; padding-top: 15px; margin-top: 15px;">
                        <div class="checkout__total-line" style="margin-bottom: 8px;">
                            <span>Tiền hàng trước thuế:</span>
                            <span id="summary-before-vat" style="font-weight: 600;"><?= number_format($data['totalPrice'] - ($data['giamGiaThanhVien'] ?? 0)) ?>đ</span>
                        </div>
                        <div class="checkout__total-line" style="margin-bottom: 0;">
                            <span>Thuế GTGT (8%):</span>
                            <span id="summary-vat-amount" style="font-weight: 600;"><?= number_format(round(($data['totalPrice'] - ($data['giamGiaThanhVien'] ?? 0)) * 0.08)) ?>đ</span>
                        </div>
                    </div>
                    <div class="checkout__total-line checkout__total-line--final">
                        <span>Tổng thanh toán:</span>
                        <span id="summary-final-total" class="checkout__final-price">
                            <?= number_format(round(($data['totalPrice'] - ($data['giamGiaThanhVien'] ?? 0)) * 1.08)) ?>đ
                        </span>
                    </div>
                </div>

                <button type="submit" form="checkout-form" class="checkout__submit-btn">ĐẶT HÀNG NGAY</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL THÔNG BÁO LỖI GHN -->
<div id="ghnErrorModal" class="checkout-modal">
    <div class="checkout-modal-content">
        <i class="fas fa-exclamation-circle checkout-modal-icon"></i>
        <h3 class="checkout-modal-title">Lỗi Hệ Thống</h3>
        <div class="checkout-modal-body">
            <p id="ghnErrorAction"></p>
            <p style="margin-top: 10px; font-size: 14px; color: #777;">Chi tiết từ GHN: <strong id="ghnErrorMessage"
                    style="color: #c0392b;"></strong></p>
            <p style="margin-top: 15px; font-size: 14px;">Vui lòng kiểm tra lại Token API trong file config.php hoặc
                liên hệ quản trị viên.</p>
        </div>
        <div class="checkout-modal-footer">
            <button type="button" class="checkout-modal-button"
                onclick="document.getElementById('ghnErrorModal').style.display='none'">Đã hiểu</button>
        </div>
    </div>
</div>

<!-- MODAL CHỌN VOUCHER -->
<div id="voucher-modal" class="voucher-modal">
    <div class="voucher-modal-content">
        <div class="voucher-modal-header">
            <h3 class="voucher-modal-title">Kho Voucher Của Bạn</h3>
            <span class="close-voucher-modal" id="close-voucher-modal">&times;</span>
        </div>
        <div class="voucher-list">
            <?php if (!$data['is_guest'] && !empty($data['activeVouchers'])): ?>
                <?php foreach ($data['activeVouchers'] as $v): ?>
                    <div class="voucher-item">
                        <div class="voucher-icon">
                            <?= $v['loai_voucher'] == 'FreeShip' ? '<i class="fas fa-shipping-fast"></i>' : '<i class="fas fa-ticket-alt"></i>' ?>
                        </div>
                        <div class="voucher-info">
                            <strong><?= htmlspecialchars($v['ma_voucher']) ?></strong>
                            <p>
                                <?php
                                if ($v['loai_voucher'] == 'TienMat')
                                    echo 'Giảm ' . number_format($v['gia_tri']) . 'đ';
                                elseif ($v['loai_voucher'] == 'PhanTram')
                                    echo 'Giảm ' . $v['gia_tri'] . '% (Tối đa ' . number_format($v['giam_toi_da']) . 'đ)';
                                elseif ($v['loai_voucher'] == 'FreeShip')
                                    echo 'Miễn phí vận chuyển (Tối đa ' . number_format($v['gia_tri']) . 'đ)';
                                ?>
                            </p>
                            <small>Đơn tối thiểu: <?= number_format($v['don_toi_thieu']) ?>đ</small>
                        </div>
                        <button type="button" class="btn-use-voucher" data-code="<?= htmlspecialchars($v['ma_voucher']) ?>">Dùng
                            ngay</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; padding: 20px; color: #777;">Hiện chưa có mã giảm giá nào khả dụng.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const provinceEl = document.getElementById('province');
        const districtEl = document.getElementById('district');
        const wardEl = document.getElementById('ward');
        const phiShipInput = document.getElementById('phi_ship_input');
        const addressInput = document.getElementById('dia_chi_day_du');
        const addressDetail = document.getElementById('dia_chi_chi_tiet');
        const districtIdInput = document.getElementById('to_district_id_input');
        const wardCodeInput = document.getElementById('to_ward_code_input');

        const ghnApiUrl = '<?= BASE_URL ?>index.php?url=ghn/';

        function handleGhnError(action, response) {
            console.error(`Lỗi khi ${action}:`, response);
            const errorModal = document.getElementById('ghnErrorModal');
            const errorActionEl = document.getElementById('ghnErrorAction');
            const errorMessageEl = document.getElementById('ghnErrorMessage');

            const ghnMessage = response?.ghn_response?.message || response?.message || 'Không có phản hồi từ GHN.';
            errorActionEl.innerText = `Thao tác "${action}" đã thất bại.`;
            errorMessageEl.innerText = ghnMessage;
            errorModal.style.display = 'flex';
        }

        // 1. Load Tỉnh/Thành
        fetch(ghnApiUrl + 'get_provinces')
            .then(res => res.json())
            .then(res => {
                if (res.code === 200) {
                    res.data.forEach(p => provinceEl.innerHTML += `<option value="${p.ProvinceID}" data-name="${p.ProvinceName}">${p.ProvinceName}</option>`);
                } else {
                    handleGhnError('tải Tỉnh/Thành', res);
                }
            }).catch(err => console.error('Lỗi mạng hoặc JSON khi tải Tỉnh/Thành:', err));

        // 2. Load Quận/Huyện
        provinceEl.addEventListener('change', function () {
            districtEl.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
            wardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            updateFullAddress();
            if (!this.value) return;
            districtIdInput.value = ''; // Reset
            fetch(`${ghnApiUrl}get_districts&province_id=${this.value}`).then(res => res.json()).then(res => {
                if (res.code === 200) {
                    res.data.forEach(d => districtEl.innerHTML += `<option value="${d.DistrictID}" data-name="${d.DistrictName}">${d.DistrictName}</option>`);
                } else {
                    handleGhnError('tải Quận/Huyện', res);
                }
            }).catch(err => console.error('Lỗi mạng hoặc JSON khi tải Quận/Huyện:', err));
        });

        // 3. Load Phường/Xã
        districtEl.addEventListener('change', function () {
            wardEl.innerHTML = '<option value="">Chọn Phường/Xã</option>';
            updateFullAddress();
            if (!this.value) return;
            districtIdInput.value = this.value; // Gán district_id vào input ẩn
            wardCodeInput.value = ''; // Reset
            fetch(`${ghnApiUrl}get_wards&district_id=${this.value}`).then(res => res.json()).then(res => {
                if (res.code === 200) {
                    res.data.forEach(w => wardEl.innerHTML += `<option value="${w.WardCode}" data-name="${w.WardName}">${w.WardName}</option>`);
                } else {
                    handleGhnError('tải Phường/Xã', res);
                }
            }).catch(err => console.error('Lỗi mạng hoặc JSON khi tải Phường/Xã:', err));
        });

        // 4. Tính phí ship
        wardEl.addEventListener('change', function () {
            updateFullAddress();
            if (!this.value) return;
            wardCodeInput.value = this.value; // Gán ward_code vào input ẩn
            fetch(`${ghnApiUrl}calculate_fee&district_id=${districtEl.value}&ward_code=${this.value}&weight=1000`)
                .then(res => res.json())
                .then(res => {
                    if (res.code === 200) {
                        const calculatedFee = res.data.total;
                        phiShipInput.value = calculatedFee; // Gán phí ship vào input ẩn

                        // Tự động hiển thị phí ship ra giao diện
                        document.getElementById('summary-shipping-fee').dataset.fee = calculatedFee;
                        document.getElementById('summary-shipping-fee').innerText = calculatedFee.toLocaleString('vi-VN') + 'đ';

                        if (typeof calculateFinalTotal === 'function') {
                            calculateFinalTotal();
                        }
                    } else {
                        handleGhnError('tính phí vận chuyển', res);
                    }
                }).catch(err => console.error('Lỗi mạng hoặc JSON khi tính phí:', err));
        });

        // Cập nhật chuỗi địa chỉ
        function updateFullAddress() {
            const pName = provinceEl.options[provinceEl.selectedIndex]?.dataset.name || '';
            const dName = districtEl.options[districtEl.selectedIndex]?.dataset.name || '';
            const wName = wardEl.options[wardEl.selectedIndex]?.dataset.name || '';
            const detail = addressDetail ? addressDetail.value : '';
            addressInput.value = `${detail}, ${wName}, ${dName}, ${pName}`.replace(/^,\s*/, '').replace(/,\s*,\s*/g, ', ');
        }

        if (addressDetail) addressDetail.addEventListener('input', updateFullAddress);

        // --- 5. LOGIC CHỌN ĐỊA CHỈ TỪ SỔ (AUTO-FILL) ---
        const addressSelect = document.getElementById('saved_address_select');
        const saveAddressWrapper = document.getElementById('save_address_wrapper');
        const inputName = document.getElementById('ho_ten');
        const inputPhone = document.getElementById('so_dien_thoai');
        const inputDetail = document.getElementById('dia_chi_chi_tiet');

        function autoFillGHN(provId, distId, wardCode) {
            provinceEl.value = provId;
            provinceEl.dispatchEvent(new Event('change'));

            let attempts = 0;
            let checkDistrict = setInterval(() => {
                attempts++;
                if (districtEl.options.length > 1) {
                    clearInterval(checkDistrict);
                    districtEl.value = distId;
                    districtEl.dispatchEvent(new Event('change'));

                    let attemptsWard = 0;
                    let checkWard = setInterval(() => {
                        attemptsWard++;
                        if (wardEl.options.length > 1) {
                            clearInterval(checkWard);
                            wardEl.value = wardCode;
                            wardEl.dispatchEvent(new Event('change')); // Trigger fee calc
                        } else if (attemptsWard > 50) clearInterval(checkWard);
                    }, 100);
                } else if (attempts > 50) clearInterval(checkDistrict);
            }, 100);
        }

        if (addressSelect) {
            addressSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const cbSaveAddress = document.getElementById('save_address');

                if (this.value === "") {
                    // Chọn "Thêm địa chỉ mới"
                    if (inputName) inputName.value = '';
                    if (inputPhone) inputPhone.value = '';
                    if (inputDetail) inputDetail.value = '';
                    if (saveAddressWrapper) saveAddressWrapper.style.display = 'block';
                    if (cbSaveAddress) cbSaveAddress.checked = true;

                    provinceEl.value = '';
                    provinceEl.dispatchEvent(new Event('change'));
                } else {
                    // Chọn địa chỉ cũ
                    if (inputName) inputName.value = selectedOption.dataset.name || '';
                    if (inputPhone) inputPhone.value = selectedOption.dataset.phone || '';
                    if (inputDetail) inputDetail.value = selectedOption.dataset.detail || '';
                    if (saveAddressWrapper) saveAddressWrapper.style.display = 'none';
                    if (cbSaveAddress) cbSaveAddress.checked = false;

                    const provId = selectedOption.dataset.province;
                    const distId = selectedOption.dataset.district;
                    const wardCode = selectedOption.dataset.ward;

                    autoFillGHN(provId, distId, wardCode);
                }
            });

            // Chờ API GHN load xong Tỉnh/Thành rồi mới fill địa chỉ mặc định
            let initialLoadAttempts = 0;
            let checkInitialProvince = setInterval(() => {
                initialLoadAttempts++;
                if (provinceEl.options.length > 1) {
                    clearInterval(checkInitialProvince);
                    if (addressSelect.value !== "") {
                        addressSelect.dispatchEvent(new Event('change'));
                    }
                } else if (initialLoadAttempts > 50) {
                    clearInterval(checkInitialProvince);
                }
            }, 100);
        }

        // --- 6. LOGIC ẨN/HIỆN HÓA ĐƠN CÔNG TY ---
        const invoiceCheckbox = document.getElementById('xuat_hoa_don_cong_ty');
        const invoiceForm = document.getElementById('company_invoice_form');
        const invoiceInputs = invoiceForm ? invoiceForm.querySelectorAll('input') : [];

        if (invoiceCheckbox) {
            invoiceCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    invoiceForm.style.display = 'block';
                    invoiceInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    invoiceForm.style.display = 'none';
                    invoiceInputs.forEach(input => input.removeAttribute('required'));
                }
                if (typeof calculateFinalTotal === 'function') calculateFinalTotal(); // Cập nhật lại khung tóm tắt
            });
        }

        // --- LOGIC TỰ ĐỘNG TRA CỨU MÃ SỐ THUẾ (API MIỄN PHÍ) ---
        const maSoThueInput = document.getElementById('ma_so_thue');
        const tenCongTyInput = document.getElementById('ten_cong_ty');
        const diaChiCongTyInput = document.getElementById('dia_chi_cong_ty');

        if (maSoThueInput) {
            maSoThueInput.addEventListener('blur', function () {
                const mst = this.value.trim();
                // MST ở Việt Nam thường có 10 số hoặc 14 ký tự (chứa dấu gạch ngang)
                if (mst.length >= 10) {
                    tenCongTyInput.placeholder = "Đang tự động tra cứu dữ liệu...";
                    diaChiCongTyInput.placeholder = "Đang tự động tra cứu dữ liệu...";
                    
                    // Gọi API miễn phí của VietQR (Tra cứu thông tin Doanh nghiệp theo MST)
                    fetch(`https://api.vietqr.io/v2/business/${mst}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.code === "00" && data.data) {
                                // Điền tự động và khóa ô không cho sửa linh tinh
                                tenCongTyInput.value = data.data.name;
                                diaChiCongTyInput.value = data.data.address;
                                tenCongTyInput.style.backgroundColor = '#f8fbf9';
                                diaChiCongTyInput.style.backgroundColor = '#f8fbf9';
                            } else {
                                tenCongTyInput.placeholder = "";
                                diaChiCongTyInput.placeholder = "";
                                alert("Không tìm thấy thông tin cho Mã số thuế này trên CSDL Quốc gia. Vui lòng nhập tay hoặc kiểm tra lại!");
                            }
                        })
                        .catch(err => {
                            console.error('Lỗi tra cứu MST:', err);
                        });
                }
            });
        }

        // --- LOGIC XỬ LÝ VOUCHER ---
        const btnApplyVoucher = document.getElementById('btn-apply-voucher');
        const inputVoucher = document.getElementById('ma_voucher_input');
        const hiddenMaVoucher = document.getElementById('hidden_ma_voucher');
        const voucherMessage = document.getElementById('voucher-message');
        const voucherDiscountLine = document.getElementById('voucher-discount-line');
        const summaryVoucherDiscount = document.getElementById('summary-voucher-discount');
        const summaryFinalTotal = document.getElementById('summary-final-total');
        const summaryShippingFee = document.getElementById('summary-shipping-fee');
        const summaryTotalPrice = document.getElementById('summary-total-price');

        let currentVoucherDiscount = 0;
        let currentVoucherType = '';

        window.calculateFinalTotal = function () {
            let tongTienHang = parseInt(summaryTotalPrice.dataset.price) || 0;
            let giamGiaThanhVien = <?= $data['giamGiaThanhVien'] ?? 0 ?>;
            let phiShip = parseInt(summaryShippingFee.dataset.fee) || 0;

            let giamVoucherDonHang = 0;
            let giamVoucherFreeShip = 0;

            if (currentVoucherType === 'FreeShip') {
                giamVoucherFreeShip = currentVoucherDiscount;
                if (giamVoucherFreeShip > phiShip) giamVoucherFreeShip = phiShip;
            } else {
                giamVoucherDonHang = currentVoucherDiscount;
            }

            let tienHangSauGiam = tongTienHang - giamGiaThanhVien - giamVoucherDonHang;
            if (tienHangSauGiam < 0) tienHangSauGiam = 0;

            let phiShipSauGiam = phiShip - giamVoucherFreeShip;
            if (phiShipSauGiam < 0) phiShipSauGiam = 0;

            let tongThanhToan = tienHangSauGiam + phiShipSauGiam;

            // --- BÓC TÁCH THUẾ VAT ---
            let vatBreakdown = document.getElementById('vat-breakdown');
            let summaryBeforeVat = document.getElementById('summary-before-vat');
            let summaryVatAmount = document.getElementById('summary-vat-amount');

            let truocThue = tongThanhToan;
            let tienThue = Math.round(truocThue * 0.08);
            let finalTotal = truocThue + tienThue;
            
            if(summaryBeforeVat) summaryBeforeVat.innerText = truocThue.toLocaleString('vi-VN') + 'đ';
            if(summaryVatAmount) summaryVatAmount.innerText = tienThue.toLocaleString('vi-VN') + 'đ';
            
            summaryFinalTotal.innerText = finalTotal.toLocaleString('vi-VN') + 'đ';

            let tongTienGiamVoucher = giamVoucherDonHang + giamVoucherFreeShip;
            if (tongTienGiamVoucher > 0) {
                voucherDiscountLine.style.display = 'flex';
                summaryVoucherDiscount.innerText = '-' + tongTienGiamVoucher.toLocaleString('vi-VN') + 'đ';
            } else {
                voucherDiscountLine.style.display = 'none';
            }
        };

        btnApplyVoucher.addEventListener('click', function () {
            let maVoucher = inputVoucher.value.trim();
            let tongTienHang = parseInt(summaryTotalPrice.dataset.price) || 0;
            let phiShip = parseInt(summaryShippingFee.dataset.fee) || 0;

            if (maVoucher === '') {
                voucherMessage.innerHTML = '<span style="color:#e74c3c">Vui lòng nhập mã!</span>';
                currentVoucherDiscount = 0;
                currentVoucherType = '';
                hiddenMaVoucher.value = '';
                calculateFinalTotal();
                return;
            }

            fetch('<?= BASE_URL ?>index.php?url=order/api_apply_voucher', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ma_voucher=${maVoucher}&tong_tien=${tongTienHang}&phi_ship=${phiShip}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        voucherMessage.innerHTML = `<span style="color:#28a745"><i class="fas fa-check-circle"></i> ${data.msg}</span>`;
                        currentVoucherDiscount = data.giam_gia;
                        currentVoucherType = data.loai_voucher;
                        hiddenMaVoucher.value = maVoucher; // Cập nhật input ẩn để submit form
                    } else {
                        voucherMessage.innerHTML = `<span style="color:#e74c3c"><i class="fas fa-times-circle"></i> ${data.msg}</span>`;
                        currentVoucherDiscount = 0;
                        currentVoucherType = '';
                        hiddenMaVoucher.value = '';
                        inputVoucher.value = '';
                    }
                    calculateFinalTotal();
                })
                .catch(error => console.error('Lỗi AJAX Voucher:', error));
        });

        // --- LOGIC XỬ LÝ POPUP CHỌN VOUCHER ---
        const vModal = document.getElementById('voucher-modal');
        const btnShowVouchers = document.getElementById('btn-show-vouchers');
        const btnCloseVModal = document.getElementById('close-voucher-modal');
        const btnsUseVoucher = document.querySelectorAll('.btn-use-voucher');

        if (btnShowVouchers) btnShowVouchers.addEventListener('click', () => vModal.style.display = 'flex');
        if (btnCloseVModal) btnCloseVModal.addEventListener('click', () => vModal.style.display = 'none');
        window.addEventListener('click', (e) => { if (e.target === vModal) vModal.style.display = 'none'; });

        btnsUseVoucher.forEach(btn => {
            btn.addEventListener('click', function () {
                inputVoucher.value = this.dataset.code;
                vModal.style.display = 'none';
                btnApplyVoucher.click(); // Tự động bấm "Áp dụng"
            });
        });
        
        // --- VALIDATE ĐƠN HÀNG > 20 TRIỆU ---
        const checkoutForm = document.getElementById('checkout-form');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                const isVat = document.getElementById('xuat_hoa_don_cong_ty')?.checked;
                const phuongThuc = document.querySelector('input[name="phuong_thuc_thanh_toan"]:checked')?.value;
                const tongThanhToanStr = document.getElementById('summary-final-total').innerText.replace(/\D/g, '');
                const tongThanhToan = parseInt(tongThanhToanStr) || 0;

                // Cảnh báo quy định Hóa đơn pháp luật
                if (isVat && tongThanhToan >= 20000000 && phuongThuc === 'COD') {
                    e.preventDefault();
                    alert('QUY ĐỊNH KẾ TOÁN:\nHóa đơn VAT có tổng thanh toán từ 20.000.000đ trở lên bắt buộc phải chọn phương thức "Chuyển khoản qua Ngân hàng" (Từ tài khoản Công ty).\n\nVui lòng thay đổi phương thức thanh toán!');
                    document.querySelector('.checkout__payment-methods').scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }
    });
</script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
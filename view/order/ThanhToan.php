<?php
// view/order/ThanhToan.php
// Nếu truy cập trực tiếp file này thay vì qua MVC, tự động Redirect về Router chuẩn
if (!isset($cartItems)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL . "index.php?url=order/checkout");
    exit;
}

require_once __DIR__ . '/../../includes/header.php';
?>

<style>
    /* --- BỘ CSS CHUẨN CHO TRANG THANH TOÁN --- */
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
        flex-wrap: wrap;
        gap: 30px;
        align-items: flex-start;
    }

    /* CỘT TRÁI - FORM */
    .checkout__left {
        flex: 1 1 60%;
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
        flex: 1 1 35%;
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

    /* --- STYLES CHO MODAL THÔNG BÁO LỖI --- */
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

<!-- CONTENT: CHECKOUT -->
<div class="checkout-wrapper">
    <h1 class="checkout__title">Thanh Toán Đơn Hàng</h1>

    <div class="checkout__container">
        <!-- CỘT TRÁI: FORM THÔNG TIN GIAO HÀNG -->
        <div class="checkout__left">
            <h2 class="checkout__subtitle">Thông Tin Giao Hàng</h2>

            <!-- Form gửi dữ liệu tạo đơn hàng (action trỏ về OrderController nếu có) -->
            <form action="<?= BASE_URL ?>index.php?url=order/process" method="POST" id="checkout-form"
                class="checkout__form">
                <div class="checkout__group">
                    <label for="ho_ten" class="checkout__label">Họ và tên *</label>
                    <input type="text" id="ho_ten" name="ho_ten" class="checkout__input"
                        value="<?= htmlspecialchars($defaultName) ?>" required>
                </div>

                <div class="checkout__group">
                    <label for="email" class="checkout__label">Email *</label>
                    <input type="email" id="email" name="email" class="checkout__input"
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>" required readonly>
                </div>

                <div class="checkout__group">
                    <label for="so_dien_thoai" class="checkout__label">Số điện thoại *</label>
                    <input type="tel" id="so_dien_thoai" name="so_dien_thoai" class="checkout__input"
                        value="<?= htmlspecialchars($defaultPhone) ?>" required>
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

                <!-- Input ẩn dùng để tự động nối địa chỉ dài và gửi phí ship -->
                <input type="hidden" name="dia_chi" id="dia_chi_day_du" value="">
                <input type="hidden" name="phi_ship" id="phi_ship_input" value="0">
                <input type="hidden" name="to_district_id" id="to_district_id_input" value="">
                <input type="hidden" name="to_ward_code" id="to_ward_code_input" value="">

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
                        <span>Chuyển khoản qua Ngân hàng (VietQR)</span>
                    </label>
                </div>
            </form>
        </div>

        <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG -->
        <div class="checkout__right">
            <h2 class="checkout__subtitle">Đơn Hàng Của Bạn</h2>
            <div class="checkout__summary">

                <!-- Danh sách sản phẩm mua -->
                <ul class="checkout__product-list">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
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

                <div class="checkout__totals">
                    <div class="checkout__total-line">
                        <span>Tạm tính:</span>
                        <span style="font-weight: 600;"><?= number_format($totalPrice) ?>đ</span>
                    </div>
                    <div class="checkout__total-line">
                        <span>Phí vận chuyển:</span>
                        <span style="font-weight: 600;">0đ</span>
                    </div>
                    <div class="checkout__total-line checkout__total-line--final">
                        <span>Tổng cộng:</span>
                        <span class="checkout__final-price"><?= number_format($finalTotal) ?>đ</span>
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

                        // Tự động hiển thị phí ship ra giao diện thay vì alert
                        const feeDisplay = document.querySelector('.checkout__total-line:nth-child(2) span:last-child');
                        if (feeDisplay) {
                            feeDisplay.innerText = calculatedFee.toLocaleString('vi-VN') + 'đ';
                        }

                        // Cập nhật tổng tiền
                        const tempTotal = <?= $totalPrice ?>;
                        const finalDisplay = document.querySelector('.checkout__final-price');
                        if (finalDisplay) finalDisplay.innerText = (tempTotal + calculatedFee).toLocaleString('vi-VN') + 'đ';
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
    });
</script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
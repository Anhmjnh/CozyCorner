<?php
// view/order/ThanhToanThanhCong.php

if (!isset($order)) {
    require_once __DIR__ . '/../../config.php';
    header("Location: " . BASE_URL);
    exit;
}

require_once __DIR__ . '/../../includes/header.php';

// Kiểm tra phương thức thanh toán từ cột `phuong_thuc_thanh_toan`
$isQR = (($order['phuong_thuc_thanh_toan'] ?? 'COD') === 'ChuyenKhoan');
$phuong_thuc_text = $isQR ? 'Chuyển khoản qua Ngân hàng (VietQR)' : 'Thanh toán khi nhận hàng (COD)';

// Trạng thái thanh toán
$isPendingPayment = ($isQR && $order['trang_thai'] === 'ChoXacNhan');

// Tính tổng tiền sản phẩm (Tạm tính)
$tong_san_pham = 0;
foreach ($order['items'] as $item) {
    $tong_san_pham += $item['gia'] * $item['so_luong'];
}

// Lấy các khoản phụ phí và giảm giá
$phi_ship = $order['phi_van_chuyen'] ?? 0;
$giam_gia_thanh_vien = $order['giam_gia_thanh_vien'] ?? 0;
$giam_gia_voucher = $order['giam_gia_voucher'] ?? 0;

// 1. Tính Tiền hàng trước thuế
$tien_truoc_thue = $tong_san_pham - $giam_gia_thanh_vien + $phi_ship - $giam_gia_voucher;

$tien_truoc_thue = max(0, $tien_truoc_thue);

$thue_suat = 0.08; // 8%
$tien_thue = $tien_truoc_thue * $thue_suat;

$tong_thanh_toan = $tien_truoc_thue + $tien_thue;
$order['tien_truoc_thue'] = $tien_truoc_thue;
$order['tien_thue'] = $tien_thue;
$order['tong_tien'] = $tong_thanh_toan;
// Tính thời gian đếm ngược 10 phút (600 giây)
$remaining_seconds = 0;
if ($isPendingPayment) {
    $created_at_time = strtotime($order['created_at']);

    $expire_time = $created_at_time + (10 * 60);
    $remaining_seconds = max(0, $expire_time - time());
}
?>
<style>
    /* Layout Container */
    .success-wrapper {
        max-width: 1200px;
        margin: 40px auto 80px auto;
        padding: 0 20px;
        display: flex;
        gap: 30px;
        align-items: flex-start;
        flex-wrap: wrap;
        font-family: 'Open Sans', sans-serif;
    }

    /* Cột trái: Thông tin đơn hàng */
    .success-main {
        flex: 1 1 60%;
        background: #fff;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid #eaeaea;
    }


    .success-main--center {
        max-width: 850px;
        margin: 0 auto;
        flex: 1 1 100%;
    }

    /* Cột phải: Mã QR */
    .success-sidebar {
        width: 380px;
        flex-shrink: 0;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 2px solid #2e5932;
        position: sticky;
        top: 20px;
        text-align: center;
    }

    /* Thành phần bên trong */
    .success-header {
        text-align: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 25px;
        margin-bottom: 25px;
    }

    .success-icon {
        font-size: 60px;
        color: #28a745;
        margin-bottom: 15px;
    }

    .success-title {
        font-size: 26px;
        font-weight: bold;
        color: #2e5932;
        margin: 0 0 10px 0;
        text-transform: uppercase;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-box {
        background: #f8fbf9;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #eef6f0;
    }

    .info-box h4 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 16px;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 8px;
    }

    .info-box p {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 25px;
    }

    .product-table th,
    .product-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .product-table th {
        background: #fafafa;
        color: #555;
        text-align: left;
        font-size: 14px;
        text-transform: uppercase;
    }

    .totals-box {
        text-align: right;
        font-size: 15px;
        background: #fafafa;
        padding: 20px;
        border-radius: 8px;
    }

    .totals-box p {
        margin: 5px 0;
        color: #555;
    }

    .totals-final {
        font-size: 22px;
        font-weight: bold;
        color: #e74c3c;
        margin-top: 15px !important;
        padding-top: 15px;
        border-top: 1px dashed #ccc;
    }

    .actions-box {
        text-align: center;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
        display: inline-block;
        margin: 0 10px;
        font-size: 15px;
    }

    .btn-primary {
        background: #2e5932;
        color: #fff;
        border: 1px solid #2e5932;
    }

    .btn-primary:hover {
        background: #1f4023;
    }

    .btn-outline {
        background: #fff;
        color: #2e5932;
        border: 1px solid #2e5932;
    }

    .btn-outline:hover {
        background: #f8fbf9;
    }

    /* Style riêng cho QR Box */
    .qr-title {
        color: #333;
        margin-top: 0;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .qr-subtitle {
        color: #666;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .qr-img-wrapper {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .qr-img {
        width: 250px;
        height: 250px;
        display: block;
        border-radius: 8px;
    }

    .qr-amount {
        font-size: 24px;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 15px;
    }

    .qr-bank-info {
        text-align: left;
        background: #f0f8ff;
        padding: 15px;
        border-radius: 8px;
        font-size: 14px;
        color: #333;
        line-height: 1.6;
        border: 1px solid #cce5ff;
    }

    .qr-bank-info span {
        font-weight: bold;
        color: #0056b3;
    }

    @media (max-width: 900px) {
        .success-sidebar {
            width: 100%;
            position: static;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="success-wrapper">

    <!-- CỘT TRÁI: THÔNG TIN ĐƠN HÀNG -->
    <div class="success-main <?= !$isPendingPayment ? 'success-main--center' : '' ?>">
        <div class="success-header">
            <?php if ($isPendingPayment): ?>
                <i class="fas fa-clock success-icon" style="color: #f39c12;"></i>
                <h1 class="success-title" style="color: #f39c12;">Chờ Thanh Toán!</h1>
                <p style="color: #666;">Đơn hàng của bạn đã được tạo. Vui lòng quét mã QR bên phải để hoàn tất thanh toán.
                </p>
            <?php else: ?>
                <i class="fas fa-check-circle success-icon"></i>
                <h1 class="success-title">Đặt Hàng Thành Công!</h1>
                <p style="color: #666;">Cảm ơn bạn đã mua sắm tại Cozy Corner. Đơn hàng của bạn đã được ghi nhận.</p>
            <?php endif; ?>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h4>Thông tin đơn hàng</h4>
                <p><strong>Mã đơn hàng:</strong> <span
                        style="color:#2e5932; font-weight:bold;">#ORD<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></span>
                </p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['sdt_nguoi_nhan'] ?? 'Không có') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order['user_email'] ?? 'Không có') ?></p>
                <p><strong>Phương thức:</strong> <?= $phuong_thuc_text ?></p>
                <p><strong>Trạng thái:</strong> <span
                        style="color: #d35400; font-weight: bold;"><?= htmlspecialchars($order['trang_thai']) ?></span>
                </p>
            </div>
            <div class="info-box">
                <h4>Thông tin nhận hàng</h4>
                <p><?= str_replace(' | ', '<br>', htmlspecialchars($order['dia_chi_giao'])) ?></p>
                <?php if (!empty($order['ghi_chu'])): ?>
                    <p style="margin-top: 10px; color: #d35400; font-style: italic;"><i class="fas fa-comment-dots"></i> Ghi
                        chú: <?= htmlspecialchars($order['ghi_chu']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if (!empty($order['xuat_hoa_don_cong_ty'])): ?>
        <div class="info-box" style="margin-bottom: 30px;">
            <h4>Thông tin yêu cầu xuất hóa đơn GTGT (VAT)</h4>
            <p><strong>Tên công ty:</strong> <?= htmlspecialchars($order['ten_cong_ty'] ?? '') ?></p>
            <p><strong>Mã số thuế:</strong> <?= htmlspecialchars($order['ma_so_thue'] ?? '') ?></p>
            <p><strong>Địa chỉ công ty:</strong> <?= htmlspecialchars($order['dia_chi_cong_ty'] ?? '') ?></p>
            <p><strong>Email nhận hóa đơn:</strong> <?= htmlspecialchars($order['email_nhan_hoa_don'] ?? '') ?></p>
        </div>
        <?php endif; ?>

        <h3 style="color: #333; margin-bottom: 15px;">Sản Phẩm Đã Mua</h3>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th style="text-align: center; width: 100px;">SL</th>
                    <th style="text-align: right;">Đơn giá</th>
                    <th style="text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <img src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($item['anh']) ?>"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                                <span style="font-weight: 600; color: #444;"><?= htmlspecialchars($item['ten_sp']) ?></span>
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: bold;"><?= $item['so_luong'] ?></td>
                        <td style="text-align: right; color: #666;"><?= number_format($item['gia']) ?>đ</td>
                        <td style="text-align: right; font-weight: bold; color: #333;">
                            <?= number_format($item['gia'] * $item['so_luong']) ?>đ
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totals-box">
            <p>Tổng tiền hàng: &nbsp;&nbsp;&nbsp;<strong><?= number_format($tong_san_pham) ?>đ</strong></p>
            <?php if ($giam_gia_thanh_vien > 0): ?>
                <p>Giảm giá hạng thành viên: &nbsp;&nbsp;&nbsp;<strong>-<?= number_format($giam_gia_thanh_vien) ?>đ</strong></p>
            <?php endif; ?>
            <p>Phí vận chuyển:
                &nbsp;&nbsp;&nbsp;<strong><?= $phi_ship == 0 ? 'Miễn phí' : number_format($phi_ship) . 'đ' ?></strong>
            </p>
            <?php if ($giam_gia_voucher > 0): ?>
                <p>Mã giảm giá (<?= htmlspecialchars($order['ma_voucher'] ?? '') ?>): &nbsp;&nbsp;&nbsp;<strong>-<?= number_format($giam_gia_voucher) ?>đ</strong></p>
            <?php endif; ?>
            <hr style="border: none; border-top: 1px dashed #ccc; margin: 10px 0;">
            <p>Tiền trước thuế: &nbsp;&nbsp;&nbsp;<strong><?= number_format($tien_truoc_thue) ?>đ</strong></p>
            <p>Thuế GTGT (8%): &nbsp;&nbsp;&nbsp;<strong><?= number_format($tien_thue) ?>đ</strong></p>
            <p class="totals-final">Tổng thanh toán: <?= number_format($order['tong_tien']) ?>đ</p>
        </div>

        <div class="actions-box">
            <a href="<?= BASE_URL ?>view/product/DanhMucSanPham.php" class="btn btn-outline"><i
                    class="fas fa-shopping-bag"></i> Tiếp Tục Mua Sắm</a>
            <a href="<?= BASE_URL ?>view/user/TaiKhoan.php?tab=orders" class="btn btn-primary"><i
                    class="fas fa-file-invoice"></i> Quản Lý Đơn Hàng</a>
        </div>
    </div>

    <!-- CỘT PHẢI: MÃ QR THANH TOÁN  -->
    <?php if ($isPendingPayment): ?>
        <div class="success-sidebar">
            <h2 class="qr-title">Thanh Toán Bằng QR Code</h2>
            <p class="qr-subtitle">Mở ứng dụng ngân hàng và quét mã để thanh toán tự động.</p>

            <!-- BỘ ĐẾM NGƯỢC THỜI GIAN -->
            <div id="qr-timer-container"
                style="text-align: center; margin-bottom: 15px; padding: 12px; background: #fff3f3; border-radius: 8px; border: 1px dashed #e74c3c;">
                <p style="margin: 0; color: #c0392b; font-weight: bold; font-size: 15px;">
                    Thời gian còn lại: <span id="countdown-timer" style="font-size: 18px;">--:--</span>
                </p>
            </div>

            <div class="qr-img-wrapper" id="qr-container" style="position: relative;">
                <?php

                $bank = SEPAY_BANK_ID;
                $acc = SEPAY_BANK_ACC;
                $accName = SEPAY_BANK_NAME;

                $des = 'ORD' . $order['id'];
                $qr_sepay_url = "https://qr.sepay.vn/img?acc={$acc}&bank={$bank}&amount=" . intval($order['tong_tien']) . "&des={$des}&accountName=" . urlencode($accName);
                ?>
                <img class="qr-img" src="<?= $qr_sepay_url ?>" alt="QR Code Thanh Toán SePay">
            </div>

            <div class="qr-amount"><?= number_format($order['tong_tien']) ?>đ</div>

            <div class="qr-bank-info">
                <p style="margin: 0 0 5px 0;">Ngân hàng: <span><?= htmlspecialchars($bank) ?></span></p>
                <p style="margin: 0 0 5px 0;">Chủ tài khoản: <span><?= htmlspecialchars($accName) ?></span></p>
                <p style="margin: 0 0 5px 0;">Số tài khoản: <span><?= htmlspecialchars($acc) ?></span></p>
                <p style="margin: 0; padding-top: 5px; border-top: 1px solid #b8daff;">
                    Nội dung CK: <span style="color: #e74c3c; font-size: 16px;"><?= $des ?></span>
                </p>
            </div>
            <p style="font-size: 13px; color: #888; margin-top: 15px; font-style: italic;">Đơn hàng sẽ được xử lý ngay sau
                khi hệ thống nhận được thanh toán.</p>
        </div>
    <?php endif; ?>

</div>

<?php if ($isPendingPayment): ?>
    <script>
        // JS Đếm ngược thời gian
        let remainingSeconds = <?= $remaining_seconds ?>;
        const countdownElement = document.getElementById('countdown-timer');
        const qrContainer = document.getElementById('qr-container');

        function updateTimerDisplay() {
            if (remainingSeconds <= 0) {
                countdownElement.innerHTML = "00:00";
                if (qrContainer && !qrContainer.classList.contains('expired')) {
                    qrContainer.classList.add('expired');
                    qrContainer.style.opacity = "0.2";
                    qrContainer.innerHTML += '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(255,255,255,0.9); padding: 10px 15px; border: 2px solid #e74c3c; border-radius: 5px; width: 85%; text-align: center; font-weight: bold; color: #e74c3c; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">MÃ QR ĐÃ HẾT HẠN</div>';

                    // Gửi request ép Backend dọn dẹp ngay lập tức để chuyển trạng thái sang "Hủy" trong DB
                    fetch('<?= BASE_URL ?>index.php?url=order/api_get_order&id=<?= $order['id'] ?>');

                    // Hiện Modal thông báo đẹp mắt thay vì alert xấu xí
                    const modalHtml = `
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(3px);">
                            <div style="background: #fff; padding: 40px 30px; border-radius: 12px; text-align: center; max-width: 400px; width: 90%; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transform: scale(1); animation: popIn 0.3s ease-out forwards;">
                                <i class="fas fa-times-circle" style="font-size: 60px; color: #e74c3c; margin-bottom: 20px;"></i>
                                <h3 style="color: #333; margin-top: 0; font-size: 22px; margin-bottom: 10px;">Đã Hết Thời Gian!</h3>
                                <p style="color: #666; margin-bottom: 25px; line-height: 1.5;">Thời gian thanh toán cho đơn hàng này đã hết. Đơn hàng của bạn đã tự động bị hủy.</p>
                                <a href="<?= BASE_URL ?>index.php?url=user/account&tab=orders" style="background: #355f2e; color: #fff; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; transition: background 0.3s; width: 100%; box-sizing: border-box;">Xem Lịch Sử Đơn Hàng</a>
                            </div>
                        </div>
                        <style>
                            @keyframes popIn { 0% { transform: scale(0.8); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
                        </style>
                    `;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
            }
            return;
        }

        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        countdownElement.innerHTML = (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
        remainingSeconds--;
    }

    updateTimerDisplay(); // Chạy ngay lần đầu
    const timerInterval = setInterval(updateTimerDisplay, 1000);

    // JS Tự động kiểm tra trạng thái đơn hàng (Polling) mỗi 3 giây
    setInterval(() => {
        // Chỉ kiểm tra trạng thái nếu mã QR chưa hết hạn
        if (remainingSeconds > 0) {
            fetch('<?= BASE_URL ?>index.php?url=order/check_status&id=<?= $order['id'] ?>')
                .then(res => res.json())
                .then(data => {
                    // Nếu webhook cập nhật trạng thái khác 'ChoXacNhan' (ví dụ: 'DangGiao')
                    if (data.status === 'success' && data.trang_thai !== 'ChoXacNhan') {
                        window.location.reload(); // Tự động load lại để hiện "Thanh toán thành công"
                    }
                });
        }
    }, 3000);
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
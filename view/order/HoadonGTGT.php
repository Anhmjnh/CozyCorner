<?php
// Hàm đọc số tiền bằng chữ (Tiếng Việt)
function doc_so_tien_viet($number) {
    $dictionary  = array(
        0 => 'không', 1 => 'một', 2 => 'hai', 3 => 'ba', 4 => 'bốn', 5 => 'năm', 6 => 'sáu', 7 => 'bảy', 8 => 'tám', 9 => 'chín',
        10 => 'mười', 11 => 'mười một', 12 => 'mười hai', 13 => 'mười ba', 14 => 'mười bốn', 15 => 'mười lăm', 16 => 'mười sáu', 17 => 'mười bảy', 18 => 'mười tám', 19 => 'mười chín',
        20 => 'hai mươi', 30 => 'ba mươi', 40 => 'bốn mươi', 50 => 'năm mươi', 60 => 'sáu mươi', 70 => 'bảy mươi', 80 => 'tám mươi', 90 => 'chín mươi',
        100 => 'trăm', 1000 => 'nghìn', 1000000 => 'triệu', 1000000000 => 'tỷ', 1000000000000 => 'nghìn tỷ'
    );
    if (!is_numeric($number) || $number == 0) return 'không';
    if ($number < 0) return 'âm ' . doc_so_tien_viet(abs($number));
    if ($number < 21) return $dictionary[$number];
    if ($number < 100) {
        $tens = ((int) ($number / 10)) * 10;
        $units = $number % 10;
        $string = $dictionary[$tens];
        if ($units) $string .= ' ' . ($units == 1 ? 'mốt' : ($units == 5 ? 'lăm' : $dictionary[$units]));
        return $string;
    }
    if ($number < 1000) {
        $hundreds = (int)($number / 100);
        $remainder = $number % 100;
        $string = $dictionary[$hundreds] . ' trăm';
        if ($remainder) $string .= ' ' . ($remainder < 10 ? 'lẻ ' : '') . doc_so_tien_viet($remainder);
        return $string;
    }
    $baseUnit = pow(1000, floor(log($number, 1000)));
    $numBaseUnits = (int) ($number / $baseUnit);
    $remainder = $number % $baseUnit;
    $string = doc_so_tien_viet($numBaseUnits) . ' ' . $dictionary[$baseUnit];
    if ($remainder) $string .= ' ' . doc_so_tien_viet($remainder);
    return $string;
}

// Xử lý tính toán lại nếu Controller chưa truyền ra
$ngay_tao = strtotime($order['created_at'] ?? 'now');
$tong_san_pham = 0;
foreach ($order['items'] as $item) {
    $tong_san_pham += ($item['gia'] ?? 0) * ($item['so_luong'] ?? 0);
}
$phi_ship = $order['phi_van_chuyen'] ?? 0;
$giam_gia = ($order['giam_gia_thanh_vien'] ?? 0) + ($order['giam_gia_voucher'] ?? 0);

$tien_truoc_thue = $tong_san_pham - $giam_gia + $phi_ship;
$tien_truoc_thue = max(0, $tien_truoc_thue);
$tien_thue = round($tien_truoc_thue * 0.08);
$tong_tien = $tien_truoc_thue + $tien_thue;
$so_tien_chu = ucfirst(doc_so_tien_viet($tong_tien)) . " đồng chẵn.";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn Giá Trị Gia Tăng - #ORD<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 15px;
            color: #222;
            line-height: 1.5;
            background: #525659; /* Màu nền xám giống trình xem PDF */
            padding: 30px 20px;
            margin: 0;
        }
        
        .invoice-wrapper {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            padding: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            position: relative;
        }

        /* Viền hóa đơn xanh lá đặc trưng */
        .invoice-border {
            border: 3px solid #2e5932;
            padding: 35px 40px;
            position: relative;
            background: url('https://www.transparenttextures.com/patterns/cubes.png'); /* Pattern chìm nhẹ cho sang */
        }

       /* Kẻ góc viền trang trí */
.invoice-border::before, .invoice-border::after {
    content: ''; 
    position: absolute; 
    width: 20px; 
    height: 20px; 
    border: 3px solid #2e5932;
}

/* Sửa -6px thành -3px ở 2 dòng dưới đây */
.invoice-border::before { 
    top: -3px; 
    left: -3px; 
    border-right: none; 
    border-bottom: none; 
    background: #fff;
}
.invoice-border::after { 
    bottom: -3px; 
    right: -3px; 
    border-left: none; 
    border-top: none; 
    background: #fff;
}
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .text-brand { color: #2e5932; } /* Xanh thương hiệu */

        /* Header Layout */
        .header-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            border-bottom: 2px dashed #2e5932;
            padding-bottom: 20px;
        }
        .header-left { width: 65%; }
        .header-left h2 { margin: 0 0 8px 0; font-size: 20px; color: #1f4023; text-transform: uppercase;}
        .header-left p { margin: 4px 0; font-size: 14px; }
        
        .header-right { width: 35%; text-align: left; background: #f8fbf9; padding: 10px 15px; border-radius: 6px; border: 1px solid #eef6f0;}
        .header-right p { margin: 4px 0; font-size: 14px;}

        /* Title */
        .invoice-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-title h1 {
            color: #2e5932;
            font-size: 28px;
            text-transform: uppercase;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        .invoice-title .subtitle { font-style: italic; color: #555; margin-bottom: 5px;}
        .invoice-title .date { font-style: italic; font-size: 15px; }

        /* Thông tin người mua/bán */
        .info-section { margin-bottom: 25px; background: #fff; z-index: 1; position: relative;}
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 6px 0; vertical-align: top; }
        .info-table .col-label { width: 170px; font-weight: bold; color: #444; }

        /* Bảng sản phẩm */
        table.table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: #fff;
        }
        table.table-items th, table.table-items td {
            border: 1px solid #cce0d1;
            padding: 10px 8px;
        }
        table.table-items th {
            background-color: #2e5932;
            color: #fff;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }
        table.table-items tbody tr:nth-child(even) { background-color: #fbfdfc; }

        /* Phần tổng tiền */
        .summary-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary-table { width: 60%; border-collapse: collapse; }
        .summary-table td { padding: 8px 10px; }
        .summary-table .col-label { text-align: left; color: #555; }
        .summary-table .col-value { text-align: right; font-weight: bold; }
        .row-total td { 
            border-top: 2px solid #2e5932; 
            font-size: 18px; 
            color: #2e5932; 
            padding-top: 12px;
        }

        .amount-words { 
            font-weight: bold; 
            font-size: 15px;
            margin-bottom: 40px; 
            border-bottom: 1px dashed #ccc; 
            padding-bottom: 15px;
        }

        /* Chữ ký */
        .signatures {
            display: flex;
            justify-content: space-around;
            text-align: center;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .sig-box { width: 40%; }
        
        .digital-sig {
            margin-top: 20px;
            padding: 15px;
            border: 2px solid #2e5932;
            background: rgba(46, 89, 50, 0.05);
            border-radius: 8px;
            color: #2e5932;
            text-align: left;
            display: inline-block;
            box-shadow: inset 0 0 10px rgba(46,89,50,0.1);
        }
        .digital-sig .sig-icon {
            font-size: 24px;
            float: left;
            margin-right: 15px;
            margin-top: 5px;
            opacity: 0.8;
        }

        /* Nút chức năng (Sẽ ẩn khi in) */
        .action-buttons { text-align: center; margin-bottom: 25px; }
        .btn { 
            padding: 12px 25px; 
            background: #2e5932; 
            color: #fff; 
            text-decoration: none; 
            border-radius: 6px; 
            cursor: pointer; 
            border: none; 
            font-size: 15px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn:hover { background: #1f4023; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .btn-secondary { background: #666; margin-left: 15px; }
        .btn-secondary:hover { background: #444; }

        @media print {
            body { background: #fff; padding: 0; }
            .invoice-wrapper { box-shadow: none; border: none; max-width: 100%; padding: 0; }
            .action-buttons { display: none; }
            .invoice-border { background: none; }
            table.table-items th { background-color: #f0f0f0 !important; color: #000 !important; }
            .row-total td { color: #000 !important; }
        }
    </style>
</head>
<body>

    <div class="action-buttons">
        <button class="btn" onclick="window.print()"><i class="fas fa-print"></i> IN HÓA ĐƠN</button>
        <button class="btn btn-secondary" onclick="window.close()"><i class="fas fa-times"></i> ĐÓNG</button>
    </div>

    <div class="invoice-wrapper">
        <div class="invoice-border">
            
            <div class="header-top">
                <div class="header-left">
                    <h2>CỬA HÀNG ĐỒ GIA DỤNG COZY CORNER</h2>
                    <p><strong>Mã số thuế:</strong> 0312345678</p>
                    <p><strong>Địa chỉ:</strong>  Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh</p>
                    <p><strong>Điện thoại:</strong> 0888 888 888 &nbsp;|&nbsp; <strong>Email:</strong> cozy@cv.com.vn</p>
                </div>
                <div class="header-right text-brand">
                    <p>Mẫu số (Form): <strong style="color: #000;">1</strong></p>
                    <p>Ký hiệu (Serial): <strong style="color: #000;">C<?= date('y', $ngay_tao) ?>TCC</strong></p>
                    <p>Số (No): <strong style="font-size: 18px; color: #d35400;"><?= str_pad($order['id'], 7, '0', STR_PAD_LEFT) ?></strong></p>
                </div>
            </div>

            <div class="invoice-title">
                <h1>HÓA ĐƠN GIÁ TRỊ GIA TĂNG</h1>
                <p class="subtitle">(Bản thể hiện của hóa đơn điện tử)</p>
                <p class="date">
                    Ngày <?= date('d', $ngay_tao) ?> tháng <?= date('m', $ngay_tao) ?> năm <?= date('Y', $ngay_tao) ?>
                </p>
            </div>

            <div class="info-section">
                <table class="info-table">
                    <tr>
                        <td class="col-label">Họ tên người mua hàng:</td>
                        <td><?= htmlspecialchars($order['ten_nguoi_nhan'] ?? 'Khách lẻ') ?></td>
                    </tr>
                    <tr>
                        <td class="col-label">Tên đơn vị:</td>
                        <td class="text-bold"><?= htmlspecialchars($order['ten_cong_ty'] ?? '') ?></td>
                    </tr>
                    <tr>
                        <td class="col-label">Mã số thuế:</td>
                        <td class="text-bold text-brand"><?= htmlspecialchars($order['ma_so_thue'] ?? '') ?></td>
                    </tr>
                    <tr>
                        <td class="col-label">Địa chỉ:</td>
                        <td><?= htmlspecialchars($order['dia_chi_cong_ty'] ?? $order['dia_chi_giao']) ?></td>
                    </tr>
                    <tr>
                        <td class="col-label">Hình thức thanh toán:</td>
                        <td>
                            <?= (($order['phuong_thuc_thanh_toan'] ?? '') == 'ChuyenKhoan') ? 'Chuyển khoản (CK)' : 'Tiền mặt (TM)' ?> 
                            &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Đồng tiền thanh toán:</strong> VND
                        </td>
                    </tr>
                </table>
            </div>

            <table class="table-items">
                <thead>
                    <tr>
                        <th width="5%">STT</th>
                        <th width="35%">Tên hàng hóa, dịch vụ</th>
                        <th width="8%">ĐVT</th>
                        <th width="8%">SL</th>
                        <th width="16%">Đơn giá (VNĐ)</th>
                        <th width="10%">Thuế suất</th>
                        <th width="18%">Thành tiền (VNĐ)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stt = 1;
                    foreach ($order['items'] as $item): 
                    ?>
                    <tr>
                        <td class="text-center"><?= $stt++ ?></td>
                        <td><?= htmlspecialchars($item['ten_sp'] ?? $item['ten_sp_snapshot'] ?? 'Sản phẩm') ?></td>
                        <td class="text-center">Cái</td>
                        <td class="text-center"><?= $item['so_luong'] ?></td>
                        <td class="text-right"><?= number_format($item['gia'] ?? 0) ?></td>
                        <td class="text-center">8%</td>
                        <td class="text-right text-bold"><?= number_format(($item['gia'] ?? 0) * ($item['so_luong'] ?? 0)) ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if ($phi_ship > 0): ?>
                    <tr>
                        <td class="text-center"><?= $stt++ ?></td>
                        <td>Phí vận chuyển</td>
                        <td class="text-center">Gói</td>
                        <td class="text-center">1</td>
                        <td class="text-right"><?= number_format($phi_ship) ?></td>
                        <td class="text-center">8%</td>
                        <td class="text-right text-bold"><?= number_format($phi_ship) ?></td>
                    </tr>
                    <?php endif; ?>
                    
                    <?php if ($giam_gia > 0): ?>
                    <tr>
                        <td colspan="6" class="text-right" style="color: #222222;">Giảm giá (Thành viên / Voucher):</td>
                        <td class="text-right text-bold" style="color: #222222;">-<?= number_format($giam_gia) ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="summary-wrapper">
                <div style="width: 35%; padding-top: 10px;">
                    <!-- Có thể thêm Ghi chú hóa đơn vào đây nếu muốn -->
                </div>
                <table class="summary-table">
                    <tr>
                        <td class="col-label">Cộng tiền hàng (chưa thuế):</td>
                        <td class="col-value"><?= number_format($tien_truoc_thue) ?></td>
                    </tr>
                    <tr>
                        <td class="col-label">Tiền thuế GTGT (8%):</td>
                        <td class="col-value"><?= number_format($tien_thue) ?></td>
                    </tr>
                    <tr class="row-total">
                        <td class="col-label text-bold" style="color: inherit;">Tổng cộng tiền thanh toán:</td>
                        <td class="col-value"><?= number_format($tong_tien) ?></td>
                    </tr>
                </table>
            </div>

            <div class="amount-words">
                <p>Số tiền viết bằng chữ: <span style="font-style: italic; color: #000;"><?= $so_tien_chu ?></span></p>
            </div>

            <div class="signatures">
                <div class="sig-box">
                    <p class="text-bold" style="font-size: 16px;">Người mua hàng</p>
                    <p style="color: #666;"><i>(Ký, ghi rõ họ tên)</i></p>
                    <br><br><br>
                    <p class="text-bold"><?= htmlspecialchars($order['ten_nguoi_nhan'] ?? '') ?></p>
                </div>
                <div class="sig-box">
                    <p class="text-bold" style="font-size: 16px;">Người bán hàng</p>
                    <div class="digital-sig">
                        <i class="fas fa-check-circle sig-icon"></i>
                        <div style="overflow: hidden;">
                            <p class="text-bold" style="margin: 0 0 5px 0; font-size: 15px; text-transform: uppercase;">Ký điện tử hợp lệ</p>
                            <p style="margin: 3px 0; font-size: 13px;"><strong>Đơn vị:</strong> CỬA HÀNG ĐỒ GIA DỤNG COZY CORNER</p>
                            <p style="margin: 3px 0; font-size: 13px;"><strong>Thời gian:</strong> <?= date('d/m/Y H:i:s', $ngay_tao) ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
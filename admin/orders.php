<?php
if (!isset($orders)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "index.php?url=admin/orders");
    exit;
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
    .header-actions {
        display: flex; 
        gap: 10px; 
        align-items: center;
    }
    .btn-sync {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        height: 40px; 
        padding: 0 15px;
        border-radius: 5px;
        font-weight: 600;
        white-space: nowrap;
        border: none;
        cursor: pointer;
    }
</style>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản lý Đơn Hàng</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">
            Tìm thấy: <strong><?= number_format($total) ?></strong> đơn hàng
            <span style="margin: 0 10px;">|</span>
            Tổng giá trị đơn hàng đã thanh toán: <strong
                style="color: #333;"><?= number_format($total_revenue) ?>đ</strong>
        </p>
    </div>
    <div class="header-actions">
        <?php
        // Xây dựng chuỗi query cho link export để giữ lại bộ lọc hiện tại
        $export_query = http_build_query([
            'search' => $search,
            'trang_thai' => $trang_thai,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);
        ?>
        <!-- Nút Xuất Excel -->
        <a href="<?= BASE_URL ?>index.php?url=admin/export_orders_to_csv&<?= $export_query ?>" class="btn btn-primary btn-sync" style="background-color: #1D6F42; border-color: #1D6F42;">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
    </div>
</div>

<!-- THANH TÌM KIẾM VÀ LỌC -->
<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form method="GET" action="<?= BASE_URL ?>index.php" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
        <input type="hidden" name="url" value="admin/orders">
        <div class="search-box" style="flex: 1; min-width: 200px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" name="search" placeholder="Nhập ID Đơn hàng hoặc Tên KH..."
                value="<?= htmlspecialchars($search) ?>"
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; outline: none;">
        </div>
        <div class="filter-box" style="min-width: 140px;">
            <select name="trang_thai"
                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; outline: none; background: #fafafa; cursor: pointer;">
                <option value="">-- Trạng thái --</option>
                <option value="ChoXacNhan" <?= $trang_thai === 'ChoXacNhan' ? 'selected' : '' ?>>Chờ Xác Nhận</option>
                <option value="DangGiao" <?= $trang_thai === 'DangGiao' ? 'selected' : '' ?>>Đang Giao</option>
                <option value="HoanThanh" <?= $trang_thai === 'HoanThanh' ? 'selected' : '' ?>>Hoàn Thành</option>
                <option value="Huy" <?= $trang_thai === 'Huy' ? 'selected' : '' ?>>Đã Hủy</option>
            </select>
        </div>
        <div class="filter-box" style="display: flex; align-items: center; gap: 5px;">
            <label style="font-size: 14px; color: #555;">Từ:</label>
            <input type="date" name="from_date" value="<?= htmlspecialchars($from_date) ?>"
                style="padding: 9px; border: 1px solid #ddd; border-radius: 5px; outline: none; background: #fafafa;">
        </div>
        <div class="filter-box" style="display: flex; align-items: center; gap: 5px;">
            <label style="font-size: 14px; color: #555;">Đến:</label>
            <input type="date" name="to_date" value="<?= htmlspecialchars($to_date) ?>"
                style="padding: 9px; border: 1px solid #ddd; border-radius: 5px; outline: none; background: #fafafa;">
        </div>
        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer;"><i
                class="fas fa-filter"></i> Lọc</button>
        <?php if ($search !== '' || $trang_thai !== '' || $from_date !== '' || $to_date !== ''): ?>
            <a href="<?= BASE_URL ?>index.php?url=admin/orders" class="btn btn-light"
                style="padding: 10px 20px; text-decoration: none; border-radius: 5px; background: #ecf0f1; color: #333;"><i
                    class="fas fa-times"></i> Hủy lọc</a>
        <?php endif; ?>
    </form>
</div>


<div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Địa Chỉ Giao</th>
                <th>Trạng Thái</th>
                <th>Ngày Đặt</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #7f8c8d;">Không có đơn hàng nào phù
                        hợp!</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['user_name']) ?></td>
                        <td><?= number_format($order['tong_tien']) ?>đ</td>
                        <td><?= htmlspecialchars(explode(' | ', $order['dia_chi_giao'] ?? '')[0] ?? '') ?>...</td>
                        <td><span class="badge 
                    <?php
                    if ($order['trang_thai'] == 'HoanThanh')
                        echo 'badge-success';
                    else if ($order['trang_thai'] == 'Huy')
                        echo 'badge-danger';
                    else
                        echo 'badge-orange'; // ChoXacNhan, DangGiao
                    ?>"><?= $order['trang_thai'] ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                        <td>
                            <button class="btn-icon text-green" onclick="viewOrder(<?= $order['id'] ?>)" title="Xem chi tiết"><i
                                    class="fas fa-eye"></i></button>
                            <button class="btn-icon text-blue"
                                onclick="openUpdateStatus(<?= $order['id'] ?>, '<?= $order['trang_thai'] ?>')"
                                title="Cập nhật trạng thái"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <?php
    $qs = "";
    if (!empty($search))
        $qs .= "&search=" . urlencode($search);
    if (!empty($trang_thai))
        $qs .= "&trang_thai=" . urlencode($trang_thai);
    if (!empty($from_date))
        $qs .= "&from_date=" . urlencode($from_date);
    if (!empty($to_date))
        $qs .= "&to_date=" . urlencode($to_date);
    ?>
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= BASE_URL ?>index.php?url=admin/orders&page=<?= $i ?><?= $qs ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL XEM CHI TIẾT ĐƠN HÀNG -->
<div id="viewOrderModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3>Chi Tiết Đơn Hàng #<span id="detail_order_id"></span></h3>
            <span class="close-modal"
                onclick="document.getElementById('viewOrderModal').style.display='none'">&times;</span>
        </div>
        <div class="order-details-body"
            style="font-family: 'Open Sans', sans-serif; max-height: 65vh; overflow-y: auto; padding-right: 5px;">
            <div style="display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Thông tin khách hàng
                    </h4>
                    <p><strong>Khách hàng:</strong> <span id="detail_customer"></span></p>
                    <p><strong>Ngày đặt:</strong> <span id="detail_date"></span></p>
                    <p><strong>Trạng thái:</strong> <span id="detail_status"></span></p>
                </div>
                <div style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Thông tin giao hàng
                    </h4>
                    <p id="detail_address" style="line-height: 1.6; margin: 0;"></p>
                    <p style="margin-top: 10px; color: #d35400;"><strong>Ghi chú:</strong> <span
                            id="detail_note"></span></p>
                </div>
            </div>
            <h4 style="margin-bottom: 10px;">Sản phẩm đã mua</h4>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th style="text-align: center; width: 60px;">SL</th>
                        <th style="text-align: right; width: 120px;">Đơn giá</th>
                        <th style="text-align: right; width: 120px;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody id="detail_items"></tbody>
            </table>
            <div style="text-align: right; margin-top: 15px;">
                <span style="font-size: 16px;">Tổng thanh toán: </span>
                <span id="detail_total" style="font-size: 22px; color: #e74c3c; font-weight: bold;"></span>
            </div>
        </div>
    </div>
</div>


<!-- MODAL CẬP NHẬT TRẠNG THÁI -->
<div id="statusModal" class="modal">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Cập Nhật Trạng Thái Đơn Hàng #<span id="status_order_id_display"></span></h3>
            <span class="close-modal"
                onclick="document.getElementById('statusModal').style.display='none'">&times;</span>
        </div>
        <form id="formStatus">
            <input type="hidden" id="status_order_id">
            <div class="form-group">
                <label>Trạng Thái Mới</label>
                <select id="status_select"
                    style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 15px;">
                    <option value="ChoXacNhan">Chờ Xác Nhận</option>
                    <option value="DangGiao">Đang Giao</option>
                    <option value="HoanThanh">Hoàn Thành</option>
                    <option value="Huy">Đã Hủy</option>
                </select>
            </div>
            <button type="button" id="btn_save_status" class="btn btn-primary w-100" onclick="saveOrderStatus()"
                style="margin-top: 10px;">LƯU TRẠNG THÁI</button>
        </form>
    </div>
</div>

<script>
    function viewOrder(id) {
        fetch('<?= BASE_URL ?>index.php?url=admin/api_get_order&id=' + id)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const order = res.data;
                    document.getElementById('detail_order_id').innerText = order.id;
                    document.getElementById('detail_customer').innerText = order.user_name || 'Khách vãng lai';
                    document.getElementById('detail_date').innerText = order.created_at;

                    let badgeClass = 'badge-orange';
                    if (order.trang_thai === 'HoanThanh') badgeClass = 'badge-success';
                    if (order.trang_thai === 'Huy') badgeClass = 'badge-danger';
                    document.getElementById('detail_status').innerHTML = `<span class="badge ${badgeClass}">${order.trang_thai}</span>`;

                    document.getElementById('detail_address').innerHTML = (order.dia_chi_giao || '').replace(/ \| /g, '<br>');
                    document.getElementById('detail_note').innerText = order.ghi_chu || 'Không có';
                    document.getElementById('detail_total').innerText = parseInt(order.tong_tien).toLocaleString('vi-VN') + 'đ';

                    let tbody = '';
                    if (order.items && order.items.length > 0) {
                        order.items.forEach(item => {
                            let price = parseInt(item.gia);
                            let subtotal = price * parseInt(item.so_luong);
                            tbody += `<tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?= BASE_URL ?>uploads/${item.anh}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                                    <span style="font-weight: 500;">${item.ten_sp}</span>
                                </div>
                            </td>
                            <td style="text-align: center; font-weight: bold;">${item.so_luong}</td>
                            <td style="text-align: right; color: #666;">${price.toLocaleString('vi-VN')}đ</td>
                            <td style="text-align: right; font-weight: bold; color: #333;">${subtotal.toLocaleString('vi-VN')}đ</td>
                        </tr>`;
                        });
                    } else {
                        tbody = `<tr><td colspan="4" style="text-align:center; padding: 20px;">Không có chi tiết sản phẩm</td></tr>`;
                    }
                    document.getElementById('detail_items').innerHTML = tbody;

                    document.getElementById('viewOrderModal').style.display = 'flex'; // Modal chi tiết đơn hàng vẫn dùng style cũ
                } else {
                    showToast(res.msg, 'error');
                }
            });
    }

    function openUpdateStatus(id, currentStatus) {
        document.getElementById('status_order_id').value = id;
        document.getElementById('status_order_id_display').innerText = id;
        
        const selectStatus = document.getElementById('status_select');
        const btnSave = document.getElementById('btn_save_status');
        
        selectStatus.value = currentStatus;

        // Khóa cứng nếu đơn hàng đã Hoàn Thành hoặc Hủy
        if (currentStatus === 'HoanThanh' || currentStatus === 'Huy') {
            selectStatus.disabled = true;
            btnSave.disabled = true;
            btnSave.style.opacity = '0.5';
            btnSave.style.cursor = 'not-allowed';
        } else {
            selectStatus.disabled = false;
            btnSave.disabled = false;
            btnSave.style.opacity = '1';
            btnSave.style.cursor = 'pointer';
        }

        document.getElementById('statusModal').style.display = 'flex';
    }

    function saveOrderStatus() {
        const id = document.getElementById('status_order_id').value;
        const status = document.getElementById('status_select').value;

        const formData = new FormData();
        formData.append('id', id);
        formData.append('trang_thai', status);

        fetch('<?= BASE_URL ?>index.php?url=admin/api_update_order_status', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    document.getElementById('statusModal').style.display = 'none';
                    showToast('Cập nhật trạng thái thành công!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(res.msg, 'error');
                }
            });
    }
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
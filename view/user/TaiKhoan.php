<?php
// views/user/TaiKhoan.php
require_once __DIR__ . '/../../config.php';

// Chặn truy cập nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'view/user/DangNhap.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

// Trang này cần CSS giống CapNhatTaiKhoan
$page_css = ['assets/css/CapNhatTaiKhoan.css'];

require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../models/Address.php';
require_once __DIR__ . '/../../models/UserModel.php';

$userId = $_SESSION['user_id'];

// Xử lý chức năng Xóa địa chỉ hồ sơ gốc
if (isset($_GET['clear_profile_address']) && $_GET['clear_profile_address'] == 1) {
    $conn = connectDB();
    $stmt = $conn->prepare("UPDATE users SET dia_chi = NULL WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: ' . BASE_URL . 'view/user/TaiKhoan.php?tab=addresses');
    exit;
}

// Tự động cập nhật hạng thành viên dựa trên tổng chi tiêu
$userModel = new UserModel();
$userModel->updateUserRank($userId);

// Lấy tab hiện tại (mặc định là profile)
$tab = $_GET['tab'] ?? 'profile';

$conn = connectDB();

// 1. Lấy thông tin User (bao gồm cả Hạng thành viên)
$stmt = $conn->prepare("SELECT ho_ten, email, so_dien_thoai, dia_chi, gioi_tinh, ngay_sinh, avatar, hang FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// 2. Lấy danh sách đơn hàng nếu đang ở tab Lịch sử đơn hàng
$orders = [];
$totalCompletedSpent = 0;
if ($tab === 'orders') {
    try {
        $stmtOrder = $conn->prepare("SELECT id, tong_tien, trang_thai, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        if ($stmtOrder) {
            $stmtOrder->bind_param('i', $userId);
            $stmtOrder->execute();
            $orders = $stmtOrder->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmtOrder->close();

            foreach ($orders as $o) {
                if ($o['trang_thai'] === 'HoanThanh') {
                    $totalCompletedSpent += $o['tong_tien'];
                }
            }
        }
    } catch (Exception $e) {
        // Bỏ qua lỗi nếu chưa có bảng orders
    }
}

// 3. Lấy danh sách sổ địa chỉ (Lấy luôn để kiểm tra địa chỉ mặc định cho mục Thông tin tài khoản)
$addresses = Address::getAllByUserId($userId);

$defaultAddress = null;
foreach ($addresses as $addr) {
    if ($addr['is_default']) {
        $defaultAddress = $addr;
        break;
    }
}

$conn->close();
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
        border-color: #355F2E   ;
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
    style="max-width: 1200px; margin: 20px auto; padding: 0 20px; list-style: none; display: flex; gap: 10px; align-items: center; color: #555;">
    <li><a href="<?= BASE_URL ?>" style="color: #333; text-decoration: none;">Trang chủ</a></li>
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
            if ($user['hang'] === 'Kim Cương') $tierBg = 'linear-gradient(135deg, #3498db, #2980b9)'; // Xanh dương
            elseif ($user['hang'] === 'Vàng') $tierBg = 'linear-gradient(135deg, #f1c40f, #f39c12)';
            elseif ($user['hang'] === 'Bạc') $tierBg = 'linear-gradient(135deg, #bdc3c7, #95a5a6)';
            ?>
            <span class="account-sidebar__tier" style="background: <?= $tierBg ?>;"><i class="fas fa-crown"></i>
                <?= htmlspecialchars($user['hang'] ?? 'Đồng') ?></span>
        </div>

        <ul class="account-sidebar__menu">
            <li><a href="?tab=profile" class="<?= $tab === 'profile' ? 'active' : '' ?>"><i class="fas fa-user"></i>
                    Thông tin tài khoản</a></li>
            <li><a href="?tab=orders" class="<?= $tab === 'orders' ? 'active' : '' ?>"><i class="fas fa-box"></i> Lịch
                    sử mua hàng</a></li>
            <li><a href="?tab=addresses" class="<?= $tab === 'addresses' ? 'active' : '' ?>"><i
                        class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng</a></li>
            <li><a href="<?= BASE_URL ?>view/user/Logout.php" style="color: #555555;"><i
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
                    <span class="profile-item__value" ><?= htmlspecialchars($user['ho_ten']) ?></span>
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
                <div class="profile-item full-width">
                    <span class="profile-item__label">Địa chỉ mặc định:</span>
                    <span class="profile-item__value"><?= htmlspecialchars($defaultAddress ? $defaultAddress['dia_chi'] : ($user['dia_chi'] ?? 'Chưa cập nhật')) ?></span>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <a href="<?= BASE_URL ?>view/user/CapNhatTaiKhoan.php" class="account__button"><i class="fas fa-edit"></i>
                    Cập nhật tài khoản</a>
            </div>

        <?php elseif ($tab === 'orders'): ?>
            <div class="account-content__header">
                <div>
                    <h2 class="account-content__title">Lịch Sử Mua Hàng</h2>
                    <p style="margin: 5px 0 0; color: #555; font-size: 15px;">Tổng tiền đã thanh toán: <strong style="color: #e74c3c; font-size: 18px;"><?= number_format($totalCompletedSpent) ?>đ</strong></p>
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
                                <td style="color: #e74c3c; font-weight: 700;"><?= number_format($order['tong_tien']) ?>đ</td>
                                <td>
                                    <?php
                                    $statusClass = 'status-pending';
                                    if (($order['trang_thai'] ?? '') === 'HoanThanh')
                                        $statusClass = 'status-success';
                                    if (($order['trang_thai'] ?? '') === 'DaHuy')
                                        $statusClass = 'status-cancel';
                                    ?>
                                    <span
                                        class="order-status <?= $statusClass ?>"><?= htmlspecialchars($order['trang_thai'] ?? 'Chờ xử lý') ?></span>
                                </td>
                                <td><a href="javascript:void(0)" onclick="viewOrder(<?= $order['id'] ?>)" style="color: #2e5932; font-weight: bold; text-decoration: none;"><i
                                            class="fas fa-eye"></i> Xem</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        <?php elseif ($tab === 'addresses'): ?>
            <div class="account-content__header">
                <h2 class="account-content__title"> Địa Chỉ</h2>
                <a href="<?= BASE_URL ?>view/user/ThemDiaChi.php" class="account__button"><i class="fas fa-plus"></i> Thêm địa chỉ mới</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <!-- Địa chỉ từ Hồ sơ gốc -->
                <?php if (!empty($user['dia_chi'])): ?>
                <div class="address-card">
                    <?php if (!$defaultAddress): ?>
                        <div class="address-card__badge"><i class="fas fa-check-circle"></i> Mặc định</div>
                    <?php endif; ?>
                    
                    <h4 style="margin: 0 0 10px 0; font-size: 1.2rem; color: #333;"><?= htmlspecialchars($user['ho_ten']) ?>
                        <span style="color: #888; font-weight: normal; font-size: 1rem;">|
                            <?= htmlspecialchars($user['so_dien_thoai'] ?? 'Chưa có SĐT') ?></span>
                    </h4>
                    <p style="margin: 0; color: #555; line-height: 1.5;"><i class="fas fa-map-marker-alt"
                            style="color: #2e5932; margin-right: 5px;"></i>
                        <?= htmlspecialchars($user['dia_chi']) ?></p>

                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee; text-align: right;">
                        <a href="<?= BASE_URL ?>view/user/SuaDiaChi.php?id=0" style="color: #355F2E; text-decoration: none; margin-right: 15px; font-weight: 600;"><i class="fas fa-edit"></i> Sửa</a>
                        <a href="?tab=addresses&clear_profile_address=1" onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ gốc này không?');" style="color: #e74c3c; text-decoration: none; font-weight: 600;"><i class="fas fa-trash-alt"></i> Xóa</a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Các địa chỉ được thêm mới -->
                <?php if (!empty($addresses)): ?>
                    <?php foreach ($addresses as $addr): ?>
                        <div class="address-card">
                            <?php if ($addr['is_default']): ?>
                                <div class="address-card__badge"><i class="fas fa-check-circle"></i> Mặc định</div>
                            <?php endif; ?>
                            
                            <h4 style="margin: 0 0 10px 0; font-size: 1.2rem; color: #333;"><?= htmlspecialchars($addr['ten_nguoi_nhan']) ?>
                                <span style="color: #888; font-weight: normal; font-size: 1rem;">| <?= htmlspecialchars($addr['so_dien_thoai']) ?></span>
                            </h4>
                            <p style="margin: 0; color: #555; line-height: 1.5;"><i class="fas fa-map-marker-alt" style="color: #2e5932; margin-right: 5px;"></i> <?= htmlspecialchars($addr['dia_chi']) ?></p>
                            
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee; text-align: right;">
                                <a href="<?= BASE_URL ?>view/user/SuaDiaChi.php?id=<?= $addr['id'] ?>" style="color: #355F2E; text-decoration: none; margin-right: 15px; font-weight: 600;"><i class="fas fa-edit"></i> Sửa</a>
                                <a href="<?= BASE_URL ?>index.php?url=address/delete&id=<?= $addr['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');" style="color: #e74c3c; text-decoration: none; font-weight: 600;"><i class="fas fa-trash-alt"></i> Xóa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
        <?php endif; ?>
    </div>
</div>

<!-- MODAL XEM CHI TIẾT ĐƠN HÀNG (USER) -->
<div id="viewOrderModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center;">
    <div style="background-color: #fff; margin: auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 800px; border-radius: 12px; position: relative; box-shadow: 0 5px 25px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
            <h3 style="margin: 0; color: #2e5932; font-family: 'Open Sans', sans-serif;">Chi Tiết Đơn Hàng #<span id="detail_order_id"></span></h3>
            <span onclick="document.getElementById('viewOrderModal').style.display='none'" style="color: #aaa; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        </div>
        <div style="font-family: 'Open Sans', sans-serif; max-height: 65vh; overflow-y: auto; padding-right: 5px;">
            <div style="display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px; color: #333;">Thông tin đơn hàng</h4>
                    <p style="margin: 8px 0; color: #555;"><strong>Ngày đặt:</strong> <span id="detail_date"></span></p>
                    <p style="margin: 8px 0; color: #555;"><strong>Trạng thái:</strong> <span id="detail_status"></span></p>
                </div>
                <div style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 10px; color: #333;">Thông tin giao hàng</h4>
                    <p id="detail_address" style="line-height: 1.6; margin: 0; color: #555;"></p>
                    <p style="margin-top: 10px; color: #d35400;"><strong>Ghi chú:</strong> <span id="detail_note"></span></p>
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
            <div style="text-align: right; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #ccc;">
                <span style="font-size: 16px; color: #555;">Tổng thanh toán: </span>
                <span id="detail_total" style="font-size: 22px; color: #e74c3c; font-weight: bold;"></span>
            </div>
        </div>
    </div>
</div>

<script>
function viewOrder(id) {
    fetch('<?= BASE_URL ?>index.php?url=order/api_get_order&id=' + id)
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                const order = res.data;
                document.getElementById('detail_order_id').innerText = order.id.toString().padStart(5, '0');
                
                // Format thời gian thành dạng d/m/Y H:i
                let dateStr = order.created_at;
                let parts = dateStr.split(/[- :]/);
                if(parts.length >= 5) {
                    dateStr = `${parts[2]}/${parts[1]}/${parts[0]} ${parts[3]}:${parts[4]}`;
                }
                document.getElementById('detail_date').innerText = dateStr;
                
                let badgeClass = 'status-pending';
                if(order.trang_thai === 'HoanThanh') badgeClass = 'status-success';
                if(order.trang_thai === 'Huy' || order.trang_thai === 'DaHuy') badgeClass = 'status-cancel';
                document.getElementById('detail_status').innerHTML = `<span class="order-status ${badgeClass}">${order.trang_thai}</span>`;
                
                document.getElementById('detail_address').innerHTML = (order.dia_chi_giao || '').replace(/ \| /g, '<br>');
                document.getElementById('detail_note').innerText = order.ghi_chu || 'Không có';
                document.getElementById('detail_total').innerText = parseInt(order.tong_tien).toLocaleString('vi-VN') + 'đ';

                let tbody = '';
                if(order.items && order.items.length > 0) {
                    order.items.forEach(item => {
                        let price = parseInt(item.gia);
                        let subtotal = price * parseInt(item.so_luong);
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
                
                document.getElementById('viewOrderModal').style.display = 'flex';
            } else { alert(res.msg || 'Không thể lấy thông tin đơn hàng'); }
        })
        .catch(err => { console.error(err); alert('Lỗi kết nối đến máy chủ.'); });
}

// Đóng modal khi click ra ngoài khung
window.onclick = function(event) {
    let modal = document.getElementById('viewOrderModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
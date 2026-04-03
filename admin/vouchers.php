<?php
if (!isset($vouchers)) {
    require_once __DIR__ . '/../config.php';
    header("Location: " . BASE_URL . "index.php?url=admin/vouchers");
    exit;
}
require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
    /*  MODAL XÁC NHẬN XÓA  */
    .custom-modal {
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
        margin-bottom: 20px;
    }

    .custom-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-danger-custom {
        background-color: #355f2e;
        border-color: #355f2c;
        color: #fff;
    }
    .btn-danger-custom:hover {
        background-color: #2c4f26;
    }
    .btn-secondary-custom {
        background-color: #f0f0f0;
        border-color: #dcdcdc;
        color: #555;
    }
    .btn-secondary-custom:hover {
        background-color: #e0e0e0;
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

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;"></i> Quản Lý Mã Giảm Giá</h2>
        <p style="margin: 5px 0 0; color: #333; font-size: 14px;">Tổng số: <strong><?= number_format($total ?? 0) ?></strong> mã</p>
    </div>
    <div class="header-actions">
        <?php
        $export_query = http_build_query([
            'search' => $search ?? '',
            'loai_voucher' => $loai_voucher ?? '',
            'trang_thai' => $trang_thai ?? ''
        ]);
        ?>
        <!-- Nút Xuất Excel -->
        <a href="<?= BASE_URL ?>index.php?url=admin/export_vouchers_to_csv&<?= $export_query ?>" class="btn btn-primary btn-sync" style="background-color: #1D6F42; border-color: #1D6F42;">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </a>
        <button class="btn btn-primary btn-sync" onclick="openModal()"><i class="fas fa-plus"></i> Thêm Mã Mới</button>
    </div>
</div>

    <!-- Bộ lọc & Tìm kiếm -->
    <div class="filter-container" style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <form method="GET" action="<?= BASE_URL ?>index.php" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <input type="hidden" name="url" value="admin/vouchers">
            <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                <input type="text" name="search" placeholder="Tìm theo mã voucher..." value="<?= htmlspecialchars($search ?? '') ?>" style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
            </div>
            <div class="filter-box" style="min-width: 150px;">
                <select name="loai_voucher" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                    <option value="">Tất cả loại</option>
                    <option value="PhanTram" <?= (isset($loai_voucher) && $loai_voucher == 'PhanTram') ? 'selected' : '' ?>>Phần Trăm (%)</option>
                    <option value="TienMat" <?= (isset($loai_voucher) && $loai_voucher == 'TienMat') ? 'selected' : '' ?>>Tiền Mặt</option>
                    <option value="FreeShip" <?= (isset($loai_voucher) && $loai_voucher == 'FreeShip') ? 'selected' : '' ?>>Miễn phí vận chuyển</option>
                </select>
            </div>
            <div class="filter-box" style="min-width: 150px;">
                <select name="trang_thai" style="width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; background: #fafafa; outline: none; cursor: pointer;">
                    <option value="">Tất cả trạng thái</option>
                    <option value="HoatDong" <?= (isset($trang_thai) && $trang_thai == 'HoatDong') ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="Khoa" <?= (isset($trang_thai) && $trang_thai == 'Khoa') ? 'selected' : '' ?>>Đã khóa</option>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary" style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"><i class="fas fa-filter"></i> Lọc</button>
            <?php if (!empty($search) || !empty($loai_voucher) || !empty($trang_thai)): ?>
                <a href="<?= BASE_URL ?>index.php?url=admin/vouchers" class="btn btn-light" style="padding: 10px 20px; background: #ecf0f1; color: #333; text-decoration: none; border-radius: 5px; font-weight: 600;"><i class="fas fa-times"></i> Xóa lọc</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Bảng Dữ Liệu -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã Voucher</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Điều kiện</th>
                    <th>Số lượng</th>
                    <th>Thời hạn</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($vouchers)): ?>
                    <tr><td colspan="9" style="text-align: center; padding: 20px;">Không có dữ liệu</td></tr>
                <?php else: ?>
                    <?php foreach ($vouchers as $v): ?>
                        <tr>
                            <td>#<?= $v['id'] ?></td>
                            <td><?= htmlspecialchars($v['ma_voucher']) ?></td>
                            <td>
                                <?php 
                                    if ($v['loai_voucher'] == 'PhanTram') echo 'Phần Trăm';
                                    elseif ($v['loai_voucher'] == 'TienMat') echo 'Tiền Mặt';
                                    else echo 'Miễn phí vận chuyển';
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if ($v['loai_voucher'] == 'PhanTram') echo $v['gia_tri'] . '%';
                                    else echo number_format($v['gia_tri']) . 'đ';
                                ?>
                            </td>
                            <td>
                                Đơn tối thiểu: <?= number_format($v['don_toi_thieu']) ?>đ<br>
                                <?php if ($v['loai_voucher'] == 'PhanTram' && $v['giam_toi_da'] > 0): ?>
                                    Giảm tối đa: <?= number_format($v['giam_toi_da']) ?>đ
                                <?php endif; ?>
                            </td>
                            <td>
                                Đã dùng: <?= $v['da_dung'] ?> / <?= $v['so_luong'] == 0 ? '∞' : $v['so_luong'] ?>
                            </td>
                            <td>
                                Bắt đầu: <?= $v['ngay_bat_dau'] ? date('d/m/Y H:i', strtotime($v['ngay_bat_dau'])) : 'Không giới hạn' ?><br>
                                Kết thúc: <span style="<?= ($v['ngay_het_han'] && strtotime($v['ngay_het_han']) < time()) ? 'color: red;' : '' ?>"><?= $v['ngay_het_han'] ? date('d/m/Y H:i', strtotime($v['ngay_het_han'])) : 'Không giới hạn' ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $v['trang_thai'] == 'HoatDong' ? 'badge-success' : 'badge-danger' ?>" style="display: inline-block; min-width: 80px; text-align: center;">
                                    <?= $v['trang_thai'] == 'HoatDong' ? 'Hoạt Động' : 'Đã Khóa' ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn-icon text-blue" onclick="editVoucher(<?= $v['id'] ?>)" title="Sửa"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon text-red" onclick="showDeleteConfirm(<?= $v['id'] ?>, '<?= htmlspecialchars(addslashes($v['ma_voucher'])) ?>')" title="Xóa"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    <!-- Phân trang -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= BASE_URL ?>index.php?url=admin/vouchers&page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>&loai_voucher=<?= urlencode($loai_voucher ?? '') ?>&trang_thai=<?= urlencode($trang_thai ?? '') ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Thêm/Sửa Voucher -->
<div id="voucherModal" class="modal" style="display: none; align-items: center;">
    <div class="modal-content" style="max-width: 600px; padding: 25px; border-radius: 12px;">
        <div class="modal-header" style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">
            <h3 id="modalTitle" style="margin: 0; color: #2e5932;">Thêm Mã Giảm Giá</h3>
            <span class="close" onclick="closeModal()" style="cursor: pointer; font-size: 24px;">&times;</span>
        </div>
        <div class="modal-body">
            <form id="voucherForm">
                <input type="hidden" id="voucher_id" name="id">
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Mã Voucher (Viết liền không dấu) *</label>
                    <input type="text" id="ma_voucher" name="ma_voucher" class="form-control" required style="width: 100%; text-transform: uppercase; padding: 10px;" placeholder="VD: TET2026">
                </div>

                <div class="form-row" style="display:flex; gap:15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Loại Voucher *</label>
                        <select id="loai_voucher" name="loai_voucher" class="form-control" required style="width: 100%; padding: 10px;">
                            <option value="TienMat">Giảm Tiền Mặt</option>
                            <option value="PhanTram">Giảm Phần Trăm (%)</option>
                            <option value="FreeShip">Miễn Phí Vận Chuyển</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Giá trị giảm *</label>
                        <input type="number" id="gia_tri" name="gia_tri" class="form-control" required min="1" style="width: 100%; padding: 10px;">
                        
                    </div>
                </div>

                <div class="form-row" style="display:flex; gap:15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Đơn tối thiểu (VNĐ)</label>
                        <input type="number" id="don_toi_thieu" name="don_toi_thieu" class="form-control" min="0" value="0" style="width: 100%; padding: 10px;">
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Giảm tối đa (VNĐ)</label>
                        <input type="number" id="giam_toi_da" name="giam_toi_da" class="form-control" min="0" value="0" style="width: 100%; padding: 10px;">
                        <small style="color:#666;">Chỉ áp dụng cho loại %</small>
                    </div>
                </div>

                <div class="form-row" style="display:flex; gap:15px; margin-bottom: 15px;">
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Số lượng tối đa</label>
                        <input type="number" id="so_luong" name="so_luong" class="form-control" min="0" value="0" style="width: 100%; padding: 10px;">
                        <small style="color:#666;">Để 0 nếu không giới hạn</small>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Trạng thái</label>
                        <select id="trang_thai" name="trang_thai" class="form-control" style="width: 100%; padding: 10px;">
                            <option value="HoatDong">Hoạt động</option>
                            <option value="Khoa">Khóa</option>
                        </select>
                    </div>
                </div>

                <div class="form-row" style="display:flex; gap:15px; margin-bottom: 20px;">
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Ngày bắt đầu</label>
                        <input type="datetime-local" id="ngay_bat_dau" name="ngay_bat_dau" class="form-control" style="width: 100%; padding: 10px;">
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label style="font-weight: bold; display: block; margin-bottom: 5px;">Ngày kết thúc</label>
                        <input type="datetime-local" id="ngay_het_han" name="ngay_het_han" class="form-control" style="width: 100%; padding: 10px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding: 12px; font-size: 16px;">Lưu Thay Đổi</button>
            </form>
        </div>
    </div>
</div>

<!-- Custom Modal Xác nhận Xóa -->
<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa Mã Giảm Giá</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle"></i>
            <p>
                Bạn có chắc chắn muốn xóa mã giảm giá <strong id="delete_voucher_display_name"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_voucher_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-secondary-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer; border: 1px solid #dcdcdc;" onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-danger-custom" style="padding: 10px 22px; font-weight: bold; border-radius: 6px; cursor: pointer;" id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("voucherModal");
    const form = document.getElementById("voucherForm");
    
    // Đổi gợi ý nhập liệu theo loại voucher
    document.getElementById('loai_voucher').addEventListener('change', function() {
        const hint = document.getElementById('gia_tri_hint');
        if (this.value === 'PhanTram') hint.innerText = "Ví dụ: 10 (tức là giảm 10%)";
        else if (this.value === 'TienMat') hint.innerText = "Ví dụ: 20000 (tức là giảm 20.000đ)";
        else hint.innerText = "Ví dụ: 30000 (tối đa miễn phí 30.000đ)";
    });

    function openModal() {
        document.getElementById('modalTitle').innerText = 'Thêm Mã Giảm Giá';
        form.reset();
        document.getElementById('voucher_id').value = '';
        document.getElementById('ngay_het_han').min = ''; // Xóa giới hạn khi thêm mới
        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    function editVoucher(id) {
        fetch(`<?= BASE_URL ?>index.php?url=admin/api_get_voucher&id=${id}`)
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                const v = data.data;
                document.getElementById('modalTitle').innerText = 'Chỉnh Sửa Mã Giảm Giá';
                document.getElementById('voucher_id').value = v.id;
                document.getElementById('ma_voucher').value = v.ma_voucher;
                document.getElementById('loai_voucher').value = v.loai_voucher;
                document.getElementById('gia_tri').value = v.gia_tri;
                document.getElementById('giam_toi_da').value = v.giam_toi_da;
                document.getElementById('don_toi_thieu').value = v.don_toi_thieu;
                document.getElementById('so_luong').value = v.so_luong;
                document.getElementById('trang_thai').value = v.trang_thai;
                document.getElementById('ngay_bat_dau').value = v.ngay_bat_dau || '';
                document.getElementById('ngay_het_han').value = v.ngay_het_han || '';
                document.getElementById('ngay_het_han').min = v.ngay_bat_dau || ''; // Cập nhật giới hạn ngày khi sửa
                
                // Cập nhật lại hint
                document.getElementById('loai_voucher').dispatchEvent(new Event('change'));
                
                modal.style.display = "flex";
            } else {
                if (typeof showToast === 'function') showToast(data.msg, 'error');
                else alert(data.msg);
            }
        });
    }

    // JS: Đảm bảo ngày kết thúc không được phép nhỏ hơn ngày bắt đầu
    document.getElementById('ngay_bat_dau').addEventListener('change', function() {
        const endDateInput = document.getElementById('ngay_het_han');
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?= BASE_URL ?>index.php?url=admin/api_save_voucher', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                if (typeof showToast === 'function') showToast(data.msg, 'success');
                else alert(data.msg);
                setTimeout(() => window.location.reload(), 1000);
            } else {
                if (typeof showToast === 'function') showToast(data.msg, 'error');
                else alert(data.msg);
            }
        });
    });

    function showDeleteConfirm(id, name) {
        document.getElementById('delete_voucher_display_name').innerText = `"${name}"`;
        document.getElementById('delete_voucher_id_input').value = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const id = document.getElementById('delete_voucher_id_input').value;

        fetch('<?= BASE_URL ?>index.php?url=admin/api_delete_voucher', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
            .then(res => res.json())
            .then(res => {
                closeDeleteConfirmModal();
                if (res.status === 'success') {
                    if (typeof showToast === 'function') showToast(res.msg, 'success');
                    else alert(res.msg);
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (typeof showToast === 'function') showToast(res.msg, 'error');
                    else alert(res.msg);
                }
            })
            .catch(err => {
                console.error(err);
                closeDeleteConfirmModal();
                if (typeof showToast === 'function') showToast('Lỗi kết nối đến máy chủ.', 'error');
                else alert('Lỗi kết nối đến máy chủ.');
            });
    });

    // Đóng popup khi click ra ngoài
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
        let deleteModal = document.getElementById('deleteConfirmModal');
        if (event.target == deleteModal) {
            closeDeleteConfirmModal();
        }
    }
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
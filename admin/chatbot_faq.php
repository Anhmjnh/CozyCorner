<?php
// admin/chatbot_faq.php
$page_title = "Quản lý Chatbot FAQ";
require_once __DIR__ . '/includes/admin_header.php';
?>

<style>
   
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
        max-width: 500px;
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

    .custom-modal-body p {
        font-size: 1rem;
        line-height: 1.6;
        color: #555;
        margin-bottom: 20px;
        text-align: center;
    }

    .custom-modal-body i.alert-icon {
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

    @keyframes animatetop {
        from {
            top: -300px;
            opacity: 0;
        }

        to {
            top: 0;
            opacity: 1;
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

    /* Style form Add/Edit */
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #333;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: 0.2s;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #355F2E;
    }

    .form-text {
        color: #888;
        font-size: 13px;
        margin-top: 5px;
        display: block;
    }

    .keyword-tag {
        background: #f1f3f5;
        border: 1px solid #e9ecef;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
        color: #495057;
        display: inline-block;
        margin: 2px;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        padding: 12px;
        border-radius: 5px;
        border-left: 4px solid #ffeeba;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 12px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #355F2E;
        border-radius: 4px;
        transition: 0.2s;
    }

    .pagination a:hover,
    .pagination a.active {
        background: #355F2E;
        color: white;
        border-color: #355F2E;
    }
</style>

<div class="page-header"
    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; color: #333;">Quản Lý Kiến Thức Chatbot (FAQ)</h2>

    </div>
    <div class="header-actions">
        <button class="btn btn-primary btn-sync" style="background-color: #355F2E; border-color: #355F2E;"
            onclick="prepareAdd()">
            <i class="fas fa-plus"></i> Thêm Câu Hỏi Mới
        </button>
    </div>
</div>



<div class="filter-container"
    style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px;">
    <form id="filter-form" style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;"
        onsubmit="event.preventDefault(); triggerSearch();">

        <div class="search-box" style="flex: 1; min-width: 250px; position: relative;">
            <i class="fas fa-search"
                style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
            <input type="text" id="search-input" placeholder="Tìm kiếm từ khóa hoặc câu trả lời..."
                style="width: 100%; box-sizing: border-box; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; font-size: 14px; outline: none;">
        </div>

        <button type="submit" class="btn btn-secondary"
            style="padding: 10px 20px; background: #34495e; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
            <i class="fas fa-search"></i> Tìm kiếm
        </button>
    </form>
</div>

<div class="table-container"
    style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto;">
    <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th width="5%"
                    style="padding: 15px; background: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #555;">ID</th>
                <th width="30%"
                    style="padding: 15px; background: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #555;">Từ Khóa
                    Kích Hoạt</th>
                <th width="40%"
                    style="padding: 15px; background: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #555;">Câu Trả
                    Lời</th>
                <th width="10%"
                    style="padding: 15px; background: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #555;">Trạng
                    Thái</th>
                <th width="15%"
                    style="padding: 15px; background: #f8f9fa; border-bottom: 2px solid #e9ecef; color: #555; text-align: center;">
                    Hành Động</th>
            </tr>
        </thead>
        <tbody id="faq-table-body">
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px;">Đang tải dữ liệu...</td>
            </tr>
        </tbody>
    </table>
</div>

<ul class="pagination" id="pagination"></ul>

<div id="toast" class="toast"></div>

<div id="faqModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title" id="faqModalLabel">Thêm FAQ Mới</h3>
            <span class="custom-modal-close" onclick="closeModal()">&times;</span>
        </div>
        <form id="faq-form">
            <div class="custom-modal-body" style="text-align: left;">
                <input type="hidden" id="faq-id" name="id">

                <div class="form-group">
                    <label for="keywords">Từ khóa kích hoạt (*)</label>
                    <input type="text" class="form-control" id="keywords" name="keywords" required
                        placeholder="VD: chính sách, địa chỉ, giờ làm việc">
                    <span class="form-text">Nhập các từ khóa liên quan, cách nhau bởi dấu phẩy (,).</span>
                </div>

                <div class="form-group">
                    <label for="answer">Nội dung trả lời (*)</label>
                    <textarea class="form-control" id="answer" name="answer" rows="6" required
                        placeholder="Nhập câu trả lời... (Hỗ trợ Markdown)"></textarea>
                    <span class="form-text">Bạn có thể sử dụng Markdown để định dạng (in đậm, chèn link).</span>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <select class="form-control" id="status" name="status">
                        <option value="HoatDong">Hiển Thị</option>
                        <option value="Khoa">Khóa / Đã Ẩn</option>
                    </select>
                </div>
            </div>

            <div class="custom-modal-footer">
                <button type="button" class="btn btn-light"
                    style="padding: 10px 20px; border: 1px solid #ccc; background: #f8f9fa; border-radius: 5px; cursor: pointer; font-weight: 600;"
                    onclick="closeModal()">Hủy Bỏ</button>
                <button type="button" class="btn btn-primary"
                    style="background-color: #355F2E; border-color: #355F2E; padding: 10px 20px; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
                    onclick="saveFaq()">Lưu Thay Đổi</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteConfirmModal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">Xác Nhận Xóa FAQ</h3>
            <span class="custom-modal-close" onclick="closeDeleteConfirmModal()">&times;</span>
        </div>
        <div class="custom-modal-body">
            <i class="fas fa-exclamation-triangle alert-icon"></i>
            <p>
                Bạn có chắc chắn muốn xóa bộ từ khóa <strong id="delete_faq_display_name"></strong> không?
                <br><small style="color: #777;">Hành động này không thể hoàn tác.</small>
            </p>
            <input type="hidden" id="delete_faq_id_input">
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn btn-light"
                style="padding: 10px 20px; border: 1px solid #ccc; background: #f8f9fa; border-radius: 5px; cursor: pointer;"
                onclick="closeDeleteConfirmModal()">Không</button>
            <button type="button" class="btn btn-primary"
                style="background-color: #355f2e; border-color: #355f2e; padding: 10px 20px; color: white; border: none; border-radius: 5px; cursor: pointer;"
                id="confirmDeleteBtn">Đồng ý</button>
        </div>
    </div>
</div>

<script>
   
    let currentPage = 1;

    // Hiển thị Toast thông báo
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        if (!toast) return;
        toast.textContent = message;
        toast.className = `toast show ${type}`;
        setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
    }

    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/[&<>'"]/g, tag => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
        }[tag] || tag));
    }

    // Modal Thêm/Sửa
    function openModal() { document.getElementById('faqModal').style.display = 'flex'; }
    function closeModal() { document.getElementById('faqModal').style.display = 'none'; }

    // Logic Tìm kiếm
    function triggerSearch() {
        loadFaqs(1, document.getElementById('search-input').value);
    }

    // Tải dữ liệu Bảng
    function loadFaqs(page = 1, search = '') {
        currentPage = page;
        fetch(`${BASE_URL}index.php?url=admin/api_get_faqs_list&page=${page}&search=${encodeURIComponent(search)}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const tbody = document.getElementById('faq-table-body');
                    if (data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 30px;">Không tìm thấy dữ liệu!</td></tr>';
                    } else {
                        tbody.innerHTML = '';
                        data.data.forEach(faq => {

                            // TRẢ LẠI CLASS GỐC CỦA HỆ THỐNG (.badge-success / .badge-danger) ĐỂ NÓ "MỜ MỜ ĐẸP ĐẸP"
                            const statusHtml = faq.status === 'HoatDong'
                                ? '<span class="badge badge-success">Hiển Thị</span>'
                                : '<span class="badge badge-danger">Đã Ẩn</span>';

                            const safeKeywords = escapeHTML(faq.keywords);
                            const safeAnswer = escapeHTML(faq.answer);
                            const keywordsHtml = safeKeywords.split(',').map(kw => `<span class="keyword-tag">${kw.trim()}</span>`).join(' ');
                            const shortAnswer = safeAnswer.length > 80 ? safeAnswer.substring(0, 80) + '...' : safeAnswer;

                            const row = `<tr>
                                <td style="padding: 15px; border-bottom: 1px solid #eee;"><strong>#${faq.id}</strong></td>
                                <td style="padding: 15px; border-bottom: 1px solid #eee;">${keywordsHtml}</td>
                                <td style="padding: 15px; border-bottom: 1px solid #eee;">${shortAnswer}</td>
                                <td style="padding: 15px; border-bottom: 1px solid #eee;">${statusHtml}</td>
                                <td style="padding: 15px; border-bottom: 1px solid #eee; text-align: center;">
                                    <button style="background:none; border:none; cursor:pointer; margin: 0 5px;" class="btn-icon text-blue" onclick="prepareEdit(${faq.id})" title="Chỉnh sửa"><i class="fas fa-edit" style="color: #3498db; font-size: 16px;"></i></button>
                                    <button style="background:none; border:none; cursor:pointer; margin: 0 5px;" class="btn-icon text-red" onclick="showDeleteConfirm(${faq.id}, '${escapeHTML(safeKeywords.split(',')[0])}')" title="Xóa"><i class="fas fa-trash" style="color: #e74c3c; font-size: 16px;"></i></button>
                                </td>
                            </tr>`;
                            tbody.innerHTML += row;
                        });
                    }
                    renderPagination(data.pagination);
                }
            });
    }

    function renderPagination(pagination) {
        const paginationUl = document.getElementById('pagination');
        paginationUl.innerHTML = '';
        if (pagination.totalPages <= 1) return;
        let html = '';
        if (pagination.page > 1) html += `<li><a href="#" onclick="loadFaqs(${pagination.page - 1}, document.getElementById('search-input').value); return false;">&laquo; Trước</a></li>`;
        for (let i = 1; i <= pagination.totalPages; i++) {
            if (i === pagination.page) {
                html += `<li><a href="#" class="active" onclick="return false;">${i}</a></li>`;
            } else {
                html += `<li><a href="#" onclick="loadFaqs(${i}, document.getElementById('search-input').value); return false;">${i}</a></li>`;
            }
        }
        if (pagination.page < pagination.totalPages) html += `<li><a href="#" onclick="loadFaqs(${pagination.page + 1}, document.getElementById('search-input').value); return false;">Sau &raquo;</a></li>`;
        paginationUl.innerHTML = html;
    }

    function prepareAdd() {
        document.getElementById('faq-form').reset();
        document.getElementById('faq-id').value = '';
        document.getElementById('faqModalLabel').innerText = 'Thêm FAQ Mới';
        openModal();
    }

    function prepareEdit(id) {
        fetch(`${BASE_URL}index.php?url=admin/api_get_faq&id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('faq-id').value = data.data.id;
                    document.getElementById('keywords').value = data.data.keywords;
                    document.getElementById('answer').value = data.data.answer;
                    document.getElementById('status').value = data.data.status;
                    document.getElementById('faqModalLabel').innerText = 'Chỉnh Sửa FAQ';
                    openModal();
                } else {
                    showToast(data.msg, 'error');
                }
            });
    }

    function saveFaq() {
        const form = document.getElementById('faq-form');
        if (!document.getElementById('keywords').value || !document.getElementById('answer').value) {
            showToast('Vui lòng nhập đầy đủ Từ khóa và Câu trả lời', 'error');
            return;
        }
        const formData = new FormData(form);
        fetch(`${BASE_URL}index.php?url=admin/api_save_faq`, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast(data.msg, 'success');
                    closeModal();
                    loadFaqs(currentPage, document.getElementById('search-input').value);
                } else {
                    showToast(data.msg, 'error');
                }
            });
    }

    // Modal Xóa
    function showDeleteConfirm(id, keywords) {
        document.getElementById('delete_faq_display_name').innerText = `"${keywords}..."`;
        document.getElementById('delete_faq_id_input').value = id;
        document.getElementById('deleteConfirmModal').style.display = 'flex';
    }

    function closeDeleteConfirmModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        const id = document.getElementById('delete_faq_id_input').value;

        fetch(`${BASE_URL}index.php?url=admin/api_delete_faq`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
            .then(res => res.json())
            .then(data => {
                closeDeleteConfirmModal();
                if (data.status === 'success') {
                    showToast('Đã xóa dữ liệu thành công!', 'success');
                    loadFaqs(currentPage, document.getElementById('search-input').value);
                } else {
                    showToast(data.msg, 'error');
                }
            })
            .catch(err => {
                console.error(err);
                closeDeleteConfirmModal();
                showToast('Lỗi kết nối đến máy chủ.', 'error');
            });
    });

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        loadFaqs();
    });

    window.onclick = function (event) {
        let modalAdd = document.getElementById('faqModal');
        let modalDel = document.getElementById('deleteConfirmModal');
        if (event.target === modalAdd) closeModal();
        if (event.target === modalDel) closeDeleteConfirmModal();
    }
</script>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
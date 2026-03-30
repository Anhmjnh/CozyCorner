<?php
// admin/chatbot_faq.php
$page_title = "Quản lý Chatbot FAQ";
require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-heading">
    <h3>Quản lý câu hỏi và trả lời cho Chatbot</h3>
    <p class="text-subtitle text-muted">
        Thêm các câu trả lời tự động cho những câu hỏi phổ biến để giảm tải cho AI và tăng tốc độ phản hồi.
    </p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Danh sách FAQ</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faq-modal" onclick="prepareAdd()">
                    <i class="bi bi-plus-lg"></i> Thêm mới
                </button>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control" placeholder="Tìm kiếm theo từ khóa hoặc câu trả lời...">
                            <button class="btn btn-primary" type="button" id="search-btn"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-lg">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 30%;">Từ khóa kích hoạt (cách nhau bởi dấu phẩy)</th>
                                <th style="width: 45%;">Câu trả lời</th>
                                <th style="width: 10%;">Trạng thái</th>
                                <th style="width: 10%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="faq-table-body">
                            <!-- Dữ liệu sẽ được load bằng JS -->
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination" id="pagination">
                        <!-- Phân trang sẽ được load bằng JS -->
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- Modal Thêm/Sửa FAQ -->
<div class="modal fade" id="faq-modal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">Thêm/Sửa FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="faq-form">
                    <input type="hidden" id="faq-id" name="id">
                    <div class="mb-3">
                        <label for="keywords" class="form-label">Từ khóa kích hoạt</label>
                        <input type="text" class="form-control" id="keywords" name="keywords" required placeholder="Ví dụ: mua hàng, đặt hàng, thanh toán">
                        <div class="form-text">Nhập các từ khóa liên quan, mỗi từ cách nhau bởi một dấu phẩy (,).</div>
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Nội dung trả lời</label>
                        <textarea class="form-control" id="answer" name="answer" rows="6" required placeholder="Nhập câu trả lời cho chatbot..."></textarea>
                        <div class="form-text">Bạn có thể sử dụng Markdown để định dạng (in đậm, chèn link).</div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="HoatDong">Hoạt Động</option>
                            <option value="Khoa">Khóa</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="saveFaq()">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>

<script>
    const BASE_URL = '<?= BASE_URL ?>';
    let currentPage = 1;

    function loadFaqs(page = 1, search = '') {
        currentPage = page;
        fetch(`${BASE_URL}admin/api_get_faqs_list?page=${page}&search=${search}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const tbody = document.getElementById('faq-table-body');
                    tbody.innerHTML = '';
                    data.data.forEach(faq => {
                        const row = `
                            <tr>
                                <td>${faq.id}</td>
                                <td><span class="badge bg-light-secondary">${faq.keywords.split(',').join(', ')}</span></td>
                                <td>${faq.answer.substring(0, 100)}...</td>
                                <td>
                                    <span class="badge ${faq.status === 'HoatDong' ? 'bg-success' : 'bg-danger'}">
                                        ${faq.status === 'HoatDong' ? 'Hoạt Động' : 'Khóa'}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="prepareEdit(${faq.id})"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteFaq(${faq.id})"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                    renderPagination(data.pagination);
                }
            });
    }

    function renderPagination(pagination) {
        const paginationUl = document.getElementById('pagination');
        paginationUl.innerHTML = '';
        if (pagination.totalPages <= 1) return;

        // Nút Previous
        paginationUl.innerHTML += `
            <li class="page-item ${pagination.page === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadFaqs(${pagination.page - 1}, document.getElementById('search-input').value)">‹</a>
            </li>
        `;

        for (let i = 1; i <= pagination.totalPages; i++) {
            paginationUl.innerHTML += `
                <li class="page-item ${i === pagination.page ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadFaqs(${i}, document.getElementById('search-input').value)">${i}</a>
                </li>
            `;
        }

        // Nút Next
        paginationUl.innerHTML += `
            <li class="page-item ${pagination.page === pagination.totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="loadFaqs(${pagination.page + 1}, document.getElementById('search-input').value)">›</a>
            </li>
        `;
    }

    function prepareAdd() {
        document.getElementById('faq-form').reset();
        document.getElementById('faq-id').value = '';
        document.getElementById('faqModalLabel').innerText = 'Thêm FAQ Mới';
    }

    function prepareEdit(id) {
        fetch(`${BASE_URL}admin/api_get_faq?id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('faq-id').value = data.data.id;
                    document.getElementById('keywords').value = data.data.keywords;
                    document.getElementById('answer').value = data.data.answer;
                    document.getElementById('status').value = data.data.status;
                    document.getElementById('faqModalLabel').innerText = 'Chỉnh Sửa FAQ';
                    new bootstrap.Modal(document.getElementById('faq-modal')).show();
                } else {
                    alert(data.msg);
                }
            });
    }

    function saveFaq() {
        const form = document.getElementById('faq-form');
        const formData = new FormData(form);

        fetch(`${BASE_URL}admin/api_save_faq`, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.msg);
            if (data.status === 'success') {
                bootstrap.Modal.getInstance(document.getElementById('faq-modal')).hide();
                loadFaqs(currentPage, document.getElementById('search-input').value);
            }
        });
    }

    function deleteFaq(id) {
        if (confirm('Bạn có chắc chắn muốn xóa FAQ này không?')) {
            fetch(`${BASE_URL}admin/api_delete_faq`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.msg);
                if (data.status === 'success') {
                    loadFaqs(currentPage, document.getElementById('search-input').value);
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadFaqs();
        document.getElementById('search-btn').addEventListener('click', () => {
            loadFaqs(1, document.getElementById('search-input').value);
        });
        document.getElementById('search-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                loadFaqs(1, document.getElementById('search-input').value);
            }
        });
    });
</script>
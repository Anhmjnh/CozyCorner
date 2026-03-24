document.addEventListener("DOMContentLoaded", function() {
    // 1. Toggle Sidebar
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    }

    // 2. Chart.js cho Dashboard
    const ctx = document.getElementById('revenueChart');
    if(ctx) {
        fetch(BASE_URL + 'admin/api.php?action=chart_data')
        .then(res => res.json())
        .then(data => {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Doanh thu (VNĐ)',
                        data: data.revenues,
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                }
            });
        });
    }

    // 3. Xử lý Modal Sản Phẩm (Thêm & Sửa)
    const productModal = document.getElementById('productModal');
    const openAddProductBtn = document.getElementById('openAddProductModal'); // Đã đổi ID để tránh trùng
    const formProduct = document.getElementById('formProduct');

    if (productModal && formProduct) {
        const closeProductBtn = productModal.querySelector('.close-modal');

        // Mở modal khi bấm nút "Thêm Sản Phẩm"
        if (openAddProductBtn) {
            openAddProductBtn.onclick = () => openProductModal();
        }
        closeProductBtn.onclick = () => productModal.style.display = "none";
        window.addEventListener('click', (e) => { if (e.target == productModal) productModal.style.display = "none"; });

        formProduct.addEventListener('submit', function(e) { // Xử lý submit form (thêm hoặc sửa)
            e.preventDefault();
            console.log("Đang thực hiện lưu sản phẩm...");
            const formData = new FormData(formProduct);
            
            // Kiểm tra ID để quyết định thêm hay sửa
            const productId = formData.get('id');
            const action = (productId && productId !== "") ? 'update_product' : 'add_product';

            console.log("Hành động:", action, "ID:", productId);

            fetch(BASE_URL + `admin/api.php?action=${action}`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.msg, 'success');
                    productModal.style.display = 'none';
                    setTimeout(() => window.location.reload(), 1000); // Tải lại để update table
                } else {
                    showToast(res.msg, 'error');
                }
            })
            .catch(err => {
                showToast('Lỗi kết nối Server hoặc lỗi PHP!', 'error');
                console.error('Lỗi chi tiết:', err);
            });
        });
    }

    // 4. Xử lý Modal Danh mục (Thêm & Sửa)
    const categoryModal = document.getElementById('categoryModal');
    const openAddCategoryBtn = document.getElementById('openAddModal'); // ID trên trang categories.php
    const formCategory = document.getElementById('formCategory');

    if (categoryModal && formCategory) {
        const closeCategoryBtn = categoryModal.querySelector('.close-modal');

        // Mở modal thêm danh mục
        if (openAddCategoryBtn) {
            openAddCategoryBtn.onclick = () => openCategoryModal();
        }
        closeCategoryBtn.onclick = () => categoryModal.style.display = "none";
        window.addEventListener('click', (e) => { if (e.target == categoryModal) categoryModal.style.display = "none"; });

        formCategory.addEventListener('submit', function(e) { // Xử lý submit form (thêm hoặc sửa)
            e.preventDefault();
            const formData = new FormData(formCategory);
            const action = formData.get('id') ? 'update_category' : 'add_category';
            fetch(BASE_URL + `admin/api.php?action=${action}`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.msg, 'success');
                    categoryModal.style.display = 'none';
                    setTimeout(() => window.location.reload(), 1000); // Tải lại để update table
                } else {
                    showToast(res.msg, 'error');
                }
            })
            .catch(err => {
                showToast('Lỗi hệ thống hoặc mạng khi lưu danh mục.', 'error');
                console.error('Fetch error:', err);
            });
        });
    }

    // 5. Xử lý Modal Người Dùng (Sửa)
    const userModal = document.getElementById('userModal');
    const formUser = document.getElementById('formUser');

    if (userModal && formUser) {
        const closeUserBtn = userModal.querySelector('.close-modal');
        closeUserBtn.onclick = () => userModal.style.display = "none";
        window.addEventListener('click', (e) => { if (e.target == userModal) userModal.style.display = "none"; });

        formUser.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formUser);
            fetch(BASE_URL + 'admin/api_save_user', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.msg, 'success');
                    userModal.style.display = 'none';
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(res.msg, 'error');
                }
            })
            .catch(err => {
                showToast('Lỗi hệ thống hoặc mạng khi lưu tin tức.', 'error');
                console.error('Fetch error:', err);
            });
        });
    }

    // 6. Xử lý Modal Tin Tức (Thêm)
    const newsModal = document.getElementById('newsModal');
    const openAddNewsBtn = document.getElementById('openAddNewsModal');
    const formNews = document.getElementById('formNews');

    if (newsModal && formNews) {
        const closeNewsBtn = newsModal.querySelector('.close-modal');

        if (openAddNewsBtn) {
            openAddNewsBtn.onclick = () => openNewsModal();
        }
        closeNewsBtn.onclick = () => newsModal.style.display = "none";
        window.addEventListener('click', (e) => { if (e.target == newsModal) newsModal.style.display = "none"; });

        formNews.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formNews);
            fetch(BASE_URL + 'admin/api.php?action=add_news', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.msg, 'success');
                    newsModal.style.display = 'none';
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(res.msg, 'error');
                }
            })
            .catch(err => {
                showToast('Lỗi hệ thống: Không thể lưu sản phẩm.', 'error');
            });
        });
    }

    // 7. Xử lý Modal Thông tin cá nhân Admin
    const adminProfileModal = document.getElementById('adminProfileModal');
    const openAdminProfileModal = document.getElementById('openAdminProfileModal');
    const closeAdminProfileModal = document.getElementById('closeAdminProfileModal');
    const formAdminProfile = document.getElementById('formAdminProfile');
    const adminProfileAvatarInput = document.getElementById('admin_profile_avatar');
    const adminProfileAvatarPreview = document.getElementById('admin_profile_avatar_preview');

    if (adminProfileModal && openAdminProfileModal && formAdminProfile) {
        openAdminProfileModal.addEventListener('click', () => {
            // Tự động tải dữ liệu cá nhân thông qua Controller (MVC)
            fetch(BASE_URL + 'admin/api_get_admin_profile')
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        document.getElementById('admin_profile_ho_ten').value = res.data.ho_ten || '';
                        document.getElementById('admin_profile_email').value = res.data.email || '';
                        document.getElementById('admin_profile_so_dien_thoai').value = res.data.so_dien_thoai || '';
                        document.getElementById('admin_profile_dia_chi').value = res.data.dia_chi || '';
                        document.getElementById('admin_profile_gioi_tinh').value = res.data.gioi_tinh || 'Nam';
                        document.getElementById('admin_profile_ngay_sinh').value = res.data.ngay_sinh || '';
                        if (res.data.avatar) {
                            adminProfileAvatarPreview.src = BASE_URL + 'uploads/' + res.data.avatar;
                        } else {
                            adminProfileAvatarPreview.src = BASE_URL + 'assets/icon/Icon-user.svg';
                        }
                        
                        // Làm rỗng trường mật khẩu (nếu trước đó đã nhập nửa chừng rồi tắt)
                        document.getElementById('admin_profile_current_password').value = '';
                        document.getElementById('admin_profile_new_password').value = '';
                        document.getElementById('admin_profile_confirm_password').value = '';

                        adminProfileModal.style.display = 'flex'; 
                    } else {
                        showToast(res.msg, 'error');
                    }
                });
        });

        if (closeAdminProfileModal) {
            closeAdminProfileModal.addEventListener('click', () => adminProfileModal.style.display = 'none');
        }
        window.addEventListener('click', (e) => { if (e.target == adminProfileModal) adminProfileModal.style.display = "none"; });

        if (adminProfileAvatarInput) {
            adminProfileAvatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) { adminProfileAvatarPreview.src = e.target.result; }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        formAdminProfile.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(BASE_URL + 'admin/api_update_admin_profile', { // Chuyển luồng sang Controller MVC
                method: 'POST',
                body: new FormData(formAdminProfile)
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    showToast(res.msg, 'success');
                    adminProfileModal.style.display = 'none';
                    document.getElementById('adminNameTxt').innerText = res.name;
                    if (res.avatar) document.getElementById('adminAvatarImg').src = BASE_URL + 'uploads/' + res.avatar;
                } else showToast(res.msg, 'error');
            })
            .catch(() => showToast('Lỗi mạng, cập nhật thất bại!', 'error'));
        });
    }

    // 8. Xử lý Modal Nhân sự
    const formStaff = document.getElementById('formStaff');
    if(formStaff) {
        formStaff.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(BASE_URL + 'admin/api_save_staff', {
                method: 'POST', body: new FormData(formStaff)
            })
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    showToast(res.msg, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else showToast(res.msg, 'error');
            });
        });
    }
});

// --- CÁC HÀM CHUNG ---
// Xóa sản phẩm bằng AJAX
function deleteProduct(id) {
    if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
        fetch(BASE_URL + 'admin/api.php?action=delete_product', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                showToast(res.msg, 'success');
                document.getElementById('row-' + id).remove();
            } else { showToast(res.msg, 'error'); }
        });
    }
}

// Hàm hiển thị Toast Notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.className = 'toast show ' + type;
    setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
}

// Xóa danh mục bằng AJAX
function deleteCategory(id) {
    if(confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
        fetch(BASE_URL + 'admin/api.php?action=delete_category', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                showToast(res.msg, 'success');
                document.getElementById('row-cat-' + id).remove();
            } else { showToast(res.msg, 'error'); }
        });
    }
}

// Toggle Trạng thái người dùng
function toggleUserStatus(id) {
    if(confirm('Bạn có chắc chắn muốn thay đổi trạng thái (Khóa/Mở Khóa) người dùng này?')) {
        fetch(BASE_URL + 'admin/api_toggle_user_status', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                showToast(res.msg, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else { showToast(res.msg, 'error'); }
        });
    }
}

// Xóa người dùng bằng AJAX
function deleteUser(id) {
    if(confirm('Bạn có chắc chắn muốn xóa người dùng này vĩnh viễn không?')) {
        fetch(BASE_URL + 'admin/api_delete_user', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {
                showToast(res.msg, 'success');
                const row = document.getElementById('row-user-' + id);
                if (row) row.remove();
            } else { showToast(res.msg, 'error'); }
        });
    }
}

// Xóa tin tức bằng AJAX (chưa có trong model/api, chỉ là khung)
function deleteNews(id) {
    if(confirm('Bạn có chắc chắn muốn xóa tin tức này không?')) {
        showToast('Chức năng xóa tin tức chưa được triển khai.', 'error');
        // fetch(BASE_URL + 'admin/api.php?action=delete_news', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ id: id })
        // })
        // .then(res => res.json())
        // .then(res => {
        //     if(res.status === 'success') {
        //         showToast(res.msg, 'success');
        //         document.getElementById('row-news-' + id).remove();
        //     } else { showToast(res.msg, 'error'); }
        // });
    }
}

// --- HÀM MỞ MODAL CHO SỬA ---

// Mở modal sản phẩm (dùng cho cả thêm và sửa)
function openProductModal(id = null) {
    const modal = document.getElementById('productModal');
    const title = document.getElementById('productModalTitle');
    const form = document.getElementById('formProduct');
    
    if (!modal || !form) return; // Bảo vệ nếu không có phần tử trên trang

    form.reset(); // Reset form
    if (document.getElementById('product_image_preview')) document.getElementById('product_image_preview').style.display = 'none';
    if (document.getElementById('product_current_anh')) document.getElementById('product_current_anh').value = '';
    if (document.getElementById('product_id')) document.getElementById('product_id').value = '';

    if (id) {
        title.innerText = 'Sửa Sản Phẩm';
        fetch(BASE_URL + `admin/api.php?action=get_product&id=${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const p = res.data;
                    document.getElementById('product_id').value = p.id;
                    form.querySelector('[name="ten_sp"]').value = p.ten_sp;
                    form.querySelector('[name="gia"]').value = p.gia;
                    form.querySelector('[name="gia_cu"]').value = p.gia_cu;
                    document.getElementById('product_danh_muc').value = p.danh_muc; // Chọn đúng danh mục đang có
                    form.querySelector('[name="so_luong"]').value = p.so_luong_ton;
                    document.getElementById('product_trang_thai').value = p.trang_thai;
                    if (p.anh) {
                        document.getElementById('product_image_preview').src = BASE_URL + 'uploads/' + p.anh;
                        document.getElementById('product_image_preview').style.display = 'block';
                        document.getElementById('product_current_anh').value = p.anh;
                    }
                    modal.style.display = 'flex';
                } else {
                    showToast(res.msg, 'error');
                }
            });
    } else {
        title.innerText = 'Thêm Sản Phẩm Mới';
        document.getElementById('product_id').value = '';
        modal.style.display = 'flex';
    }
}

// Mở modal danh mục (dùng cho cả thêm và sửa)
function openCategoryModal(id = null) {
    const modal = document.getElementById('categoryModal');
    const title = document.getElementById('categoryModalTitle');
    const form = document.getElementById('formCategory');
    form.reset(); // Reset form

    if (id) {
        title.innerText = 'Sửa Danh mục';
        fetch(BASE_URL + `admin/api.php?action=get_category&id=${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const cat = res.data;
                    document.getElementById('category_id').value = cat.id;
                    document.getElementById('category_ten_danh_muc').value = cat.ten_danh_muc;
                    form.querySelector('[name="trang_thai"]').value = cat.trang_thai;
                    modal.style.display = 'flex';
                } else {
                    showToast(res.msg, 'error');
                }
            });
    } else {
        title.innerText = 'Thêm Danh mục Mới';
        document.getElementById('category_id').value = '';
        modal.style.display = 'flex';
    }
}

// Mở modal người dùng (Thêm & Sửa)
function openUserModal(id = null) {
    const modal = document.getElementById('userModal');
    const title = document.getElementById('userModalTitle');
    const form = document.getElementById('formUser');
    form.reset();
    document.getElementById('user_id').value = '';
    document.getElementById('user_mat_khau').required = true;
    document.getElementById('user_pw_hint').innerText = '(*) Bắt buộc khi thêm mới';

    if (id) {
        title.innerText = 'Sửa Thông Tin Người Dùng';
        document.getElementById('user_mat_khau').required = false;
        document.getElementById('user_pw_hint').innerText = '(Bỏ trống nếu không muốn đổi)';
        fetch(BASE_URL + `admin/api_get_user?id=${id}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    const user = res.data;
                    document.getElementById('user_id').value = user.id;
                    document.getElementById('user_ho_ten').value = user.ho_ten;
                    document.getElementById('user_email').value = user.email;
                    document.getElementById('user_so_dien_thoai').value = user.so_dien_thoai;
                    document.getElementById('user_dia_chi').value = user.dia_chi;
                    document.getElementById('user_gioi_tinh').value = user.gioi_tinh;
                    document.getElementById('user_ngay_sinh').value = user.ngay_sinh; // Date input needs YYYY-MM-DD format
                    document.getElementById('user_hang').value = user.hang || 'Đồng'; 
                    document.getElementById('user_trang_thai').value = user.trang_thai || 'HoatDong'; 
                    modal.style.display = 'flex';
                } else { showToast(res.msg, 'error'); }
            });
    } else {
        title.innerText = 'Thêm Người Dùng Mới';
        modal.style.display = 'flex';
    }
}

// Mở modal tin tức (chỉ thêm)
function openNewsModal(id = null) {
    const modal = document.getElementById('newsModal');
    const title = document.getElementById('newsModalTitle');
    const form = document.getElementById('formNews');
    form.reset();
    document.getElementById('news_image_preview').style.display = 'none';
    document.getElementById('news_current_anh').value = '';

    if (id) { // Chức năng sửa tin tức chưa được triển khai hoàn chỉnh
        title.innerText = 'Sửa Tin Tức';
        // Logic fetch data và populate form tương tự sản phẩm/danh mục
        showToast('Chức năng sửa tin tức chưa được triển khai hoàn chỉnh.', 'info');
    } else {
        title.innerText = 'Thêm Tin Tức Mới';
        document.getElementById('news_id').value = '';
    }
    modal.style.display = 'flex';
}

// Mở Modal Nhân sự
function openStaffModal(id = null) {
    const modal = document.getElementById('staffModal');
    const title = document.getElementById('staffModalTitle');
    const form = document.getElementById('formStaff');
    form.reset();
    document.getElementById('staff_id').value = '';
    document.getElementById('staff_username').readOnly = false;
    document.getElementById('staff_password').required = true;
    document.getElementById('staff_pw_hint').innerText = '(*) Bắt buộc khi thêm mới';

    if (id) {
        title.innerText = 'Sửa Thông Tin Nhân Sự';
        document.getElementById('staff_username').readOnly = true; // Sửa thì ko đổi username
        document.getElementById('staff_password').required = false;
        document.getElementById('staff_pw_hint').innerText = '(Bỏ trống nếu không muốn đổi)';
        
        fetch(BASE_URL + `admin/api_get_staff?id=${id}`)
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    const s = res.data;
                    document.getElementById('staff_id').value = s.id;
                    document.getElementById('staff_ho_ten').value = s.ho_ten;
                    document.getElementById('staff_username').value = s.username;
                    document.getElementById('staff_email').value = s.email;
                    document.getElementById('staff_sdt').value = s.so_dien_thoai;
                    document.getElementById('staff_vai_tro').value = s.vai_tro;
                    document.getElementById('staff_trang_thai').value = s.trang_thai;
                    modal.style.display = 'flex';
                }
            });
    } else {
        title.innerText = 'Thêm Nhân Sự Mới';
        modal.style.display = 'flex';
    }
}

function deleteStaff(id) {
    if(confirm('Chắc chắn muốn xóa nhân sự này?')) {
        fetch(BASE_URL+'admin/api_delete_staff',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({id:id})})
        .then(res=>res.json()).then(res=>{if(res.status==='success'){document.getElementById('row-staff-'+id).remove();showToast(res.msg,'success');}else showToast(res.msg,'error');});
    }
}
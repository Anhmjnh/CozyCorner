document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = typeof BASE_URL !== 'undefined' ? BASE_URL : '/cozycorner/';

    // Load giỏ hàng lần đầu
    loadCart();

    // Xử lý sự kiện "Thêm vào giỏ" 
    document.body.addEventListener('click', function (e) {
        const addBtn = e.target.closest('.js__add-to-cart');
        if (addBtn) {
            e.preventDefault();
            
            const productId = addBtn.dataset.productId;

            if (productId) {
                addToCart(productId, 1);
            } else {
                alert('LỖI: Không thể xác định được mã sản phẩm. Vui lòng tải lại trang!');
            }
        }
    });

    // Xử lý sự kiện trong Modal & Giỏ hàng
    document.body.addEventListener('click', function (e) {
        // Tăng số lượng
        const btnInc = e.target.closest('.js__cart-qty-inc');
        if (btnInc) {
            e.preventDefault();
            const itemEl = btnInc.closest('.cart__item');
            const cartItemId = btnInc.dataset.cartItemId || itemEl.dataset.cartItemId;
            const qtySpan = itemEl.querySelector('.cart__quantity-value');
            const newQty = parseInt(qtySpan.innerText) + 1;
            updateQuantity(cartItemId, newQty);
        }

        // Giảm số lượng
        const btnDec = e.target.closest('.js__cart-qty-dec');
        if (btnDec) {
            e.preventDefault();
            const itemEl = btnDec.closest('.cart__item');
            const cartItemId = btnDec.dataset.cartItemId || itemEl.dataset.cartItemId;
            const qtySpan = itemEl.querySelector('.cart__quantity-value');
            const newQty = parseInt(qtySpan.innerText) - 1;
            if (newQty > 0) {
                updateQuantity(cartItemId, newQty);
            } else {
                removeItem(cartItemId);
            }
        }

        // Xóa sản phẩm
        const btnRemove = e.target.closest('.cart__item-remove-button');
        if (btnRemove) {
            e.preventDefault();
            const cartItemId = btnRemove.dataset.cartItemId || btnRemove.closest('.cart__item').dataset.cartItemId;
            removeItem(cartItemId);
        }
    });

    function loadCart() {
        // Thêm tham số chống cache để trình duyệt luôn lấy dữ liệu mới nhất từ CSDL
        const timestamp = new Date().getTime();
        return fetch(baseUrl + 'index.php?url=cart/get&t=' + timestamp, {
            headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' },
            credentials: 'same-origin'
        })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    renderCart(data);
                }
            })
            .catch(error => console.error('Lỗi tải giỏ hàng:', error));
    }

    function addToCart(productId, quantity) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch(baseUrl + 'index.php?url=cart/add', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Dùng luôn dữ liệu server trả về để vẽ lại giỏ hàng 
                if (data.items) {
                    renderCart(data);
                }
                const modalCart = document.querySelector('.js__cart-modal');
                if (modalCart) modalCart.classList.add('open');
            } else {
                alert(data.msg || data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng.');
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    function updateQuantity(cartItemId, quantity) {
        const formData = new FormData();
        formData.append('cart_item_id', cartItemId);
        formData.append('quantity', quantity);

        fetch(baseUrl + 'index.php?url=cart/update', { method: 'POST', body: formData, credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => { if (data.status === 'success') loadCart(); });
    }

    function removeItem(cartItemId) {
        const formData = new FormData();
        formData.append('cart_item_id', cartItemId);

        fetch(baseUrl + 'index.php?url=cart/remove', { method: 'POST', body: formData, credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => { if (data.status === 'success') loadCart(); });
    }

    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number) + 'đ';
    }

    function renderCart(data) {
        const cartLists = document.querySelectorAll('.js__cart-items-list');
        cartLists.forEach(cartList => {
            cartList.innerHTML = ''; 
            if (data.items.length === 0) {
                cartList.innerHTML = '<li style="text-align:center; padding: 20px;">Giỏ hàng trống</li>';
            } else {
                data.items.forEach(item => {
                    const li = document.createElement('li');
                    li.className = 'cart__item';
                    li.dataset.cartItemId = item.cart_item_id;

                    let oldPriceHtml = item.old_price > 0 ? `<span class="cart__item-price--old">${formatCurrency(item.old_price)}</span>` : '';

                    li.innerHTML = `
                        <div class="cart__item-image-wrapper">
                            <img src="${baseUrl}uploads/${item.image}" alt="${item.name}" class="cart__item-image">
                        </div>
                        <div class="cart__item-details">
                            <div class="cart__item-name" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal; line-height: 1.4; padding-right: 5px;">${item.name}</div>
                            <div class="cart__item-price" style="display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
                                ${oldPriceHtml} <span class="cart__item-price--current">${formatCurrency(item.price)}</span>
                            </div>
                            <div class="cart__item-quantity">
                                <button class="cart__quantity-btn js__cart-qty-dec" data-cart-item-id="${item.cart_item_id}">−</button>
                                <span class="cart__quantity-value">${item.quantity}</span>
                                <button class="cart__quantity-btn js__cart-qty-inc" data-cart-item-id="${item.cart_item_id}">+</button>
                            </div>
                        </div>
                        <button class="cart__item-remove-button" data-cart-item-id="${item.cart_item_id}" style="align-self: flex-start; margin-top: 5px;"><img src="${baseUrl}assets/icon/icon-bin.svg" alt="icon bin"></button>
                    `;
                    cartList.appendChild(li);
                });
            }
        });

        document.querySelectorAll('.js__cart-total-price').forEach(el => el.innerText = formatCurrency(data.total_price));
        const cartCountHeader = document.querySelector('.navbar__cart-count');
        if (cartCountHeader) cartCountHeader.innerText = data.total_quantity;
    }

    // Cho phép gọi renderCart từ các file khác 
    window.renderCart = renderCart;
});
<?php
// includes/footer.php
require_once __DIR__ . '/../config.php';  // Include config để lấy BASE_URL
?>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer__container">

        <!-- Cột 1: Thông tin công ty -->
        <div class="footer__column footer__company">
            <div class="footer__logo">
                <img src="<?= BASE_URL ?>assets/icon/Cozy Corner.svg" alt="logo cozy corner">
            </div>
            <p class="footer__name font600">CÔNG TY CỔ PHẦN COZY CORNER</p>

            <div class="footer__contact font400">
                <p class="footer__text">
                    <span class="font600">Địa chỉ:</span> Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh
                </p>
                <p class="footer__text">
                    <span class="font600">Số điện thoại:</span> 0888 888 888
                </p>
                <p class="footer__text">
                    <span class="font600">Email:</span> Cozy@cv.com.vn
                </p>
            </div>

            <div class="footer__support font400">
                <p class="footer__text">Tư vấn hỗ trợ (8:00 - 17:30)</p>
                <p class="footer__text">0888 888 888</p>
                <p class="footer__text">0999 999 999</p>
            </div>

            <!-- Mạng xã hội -->
            <div class="footer__social">
                <a href="https://www.facebook.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-facebook.svg" alt="Facebook">
                </a>
                <a href="https://www.instagram.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-instargram.svg" alt="Instagram">
                </a>
                <a href="https://www.messenger.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-messenger.svg" alt="Messenger">
                </a>
                <a href="https://zalo.me/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-zalo.svg" alt="Zalo">
                </a>
                <a href="https://x.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-X.svg" alt="X">
                </a>
                <a href="https://www.pinterest.com/" target="_blank" class="footer__social-icon">
                    <img src="<?= BASE_URL ?>assets/icon/icon-pinterest.svg" alt="Pinterest">
                </a>
            </div>
        </div>

        <!-- Cột 2: Về Cozy Corner -->
        <div class="footer__column footer__about">
            <div class="footer__title font600">Về Cozy Corner</div>
            <ul class="footer__list font400">
                <li class="footer__item"><a href="#" class="footer__link">Giới Thiệu</a></li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>" class="footer__link">Trang Chủ</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=product" class="footer__link">Sản Phẩm</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=news" class="footer__link">Tin Tức</a>
                </li>
                <li class="footer__item">
                    <a href="<?= BASE_URL ?>index.php?url=contact" class="footer__link">Liên Hệ</a>
                </li>
            </ul>
        </div>

        <!-- Cột 3: Chính Sách -->
        <div class="footer__column footer__policy">
            <div class="footer__title font600">Chính Sách</div>
            <ul class="footer__list font400">
               
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Giao Hàng</a>
                </li>
             
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Khách Hàng Thân Thiết</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Bảo Mật Thông Tin Khách Hàng</a>
                </li>
                <li class="footer__item">
                    <a href="#" class="footer__link">Chính Sách Xử Lý Dữ Liệu Cá Nhân</a>
                </li>
            </ul>
        </div>

    </div>
</footer>

<!-- Dòng bản quyền -->
<div class="footer__bottom">
    <p class="footer__copyright">© 2026 All Rights Reserved. Design By Anh Minh.</p>
</div>

<!-- GIAO DIỆN CHATBOT AI -->
<style>
    .cozy-chat-widget {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 10000;
        font-family: 'Inter', Arial, sans-serif;
    }

    .cozy-chat-btn {
        width: 60px;
        height: 60px;
        background: #355F2E;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 26px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .cozy-chat-btn:hover {
        transform: scale(1.05);
    }

    .cozy-chat-box {
        display: none;
        width: 360px;
        height: 500px;
        background: #fff;
        position: absolute;
        bottom: 75px;
        right: 0;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        flex-direction: column;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .cozy-chat-header {
        background: #355F2E;
        color: #ffffff !important;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
        font-size: 16px;
    }

    .cozy-chat-header i {
        cursor: pointer;
        color: #ffffff !important;
        transition: 0.3s;
    }

    .cozy-chat-header span {
        color: #ffffff !important;
    }

    .cozy-chat-header i:hover {
        color: #d1e2c6;
    }

    .cozy-chat-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #f9fbf9;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .msg-bubble {
        max-width: 85%;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 14.5px;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .msg-user {
        align-self: flex-end;
        background: #355F2E;
        color: white;
        border-bottom-right-radius: 2px;
    }

    .msg-bot {
        align-self: flex-start;
        background: #fff;
        color: #333;
        border: 1px solid #e0e0e0;
        border-bottom-left-radius: 2px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
    }

    .msg-bot p {
        margin: 0 0 8px 0;
    }

    .msg-bot p:last-child {
        margin: 0;
    }

    .msg-bot strong {
        color: #355F2E;
    }

    /* Fix lỗi thụt lề lộn xộn của Markdown */
    .msg-bot ul,
    .msg-bot ol {
        margin: 6px 0 6px 25px !important;
        padding: 0 !important;
        list-style-position: outside;
    }

    .msg-bot li {
        margin-bottom: 6px;
        text-align: left;
    }

    .msg-bot p {
        margin: 0 0 8px 0;
        text-align: left;
    }

    .msg-bot a {
        color: #d84b24;
        /* Màu cam Shopee để nổi bật link */
        text-decoration: underline;
        font-weight: bold;
    }

    .cozy-chat-footer {
        padding: 12px;
        background: #fff;
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cozy-chat-input {
        flex: 1;
        border: 1px solid #ddd;
        padding: 10px 15px;
        border-radius: 20px;
        outline: none;
        transition: 0.3s;
        font-family: 'Inter', Arial, sans-serif;
    }

    .cozy-chat-input:focus {
        border-color: #355F2E;
    }

    .cozy-chat-send {
        background: none;
        border: none;
        color: #355F2E;
        font-size: 20px;
        cursor: pointer;
        padding: 5px;
    }

    .cozy-typing {
        display: none;
        align-self: flex-start;
        font-size: 12px;
        color: #888;
        margin-top: -5px;
        font-style: italic;
    }

    /* Gợi ý câu hỏi chuẩn Shopee */
    .cozy-chat-suggestions {
        display: flex;
        gap: 8px;
        padding: 10px 15px;
        background: #fff;
        border-top: 1px solid #eee;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        /* Firefox */
        scrollbar-color: #ccc transparent;
        cursor: grab;
    }

    .cozy-chat-suggestions::-webkit-scrollbar {
        height: 6px;
        /* Chrome */
        display: block;
    }

    .cozy-chat-suggestions::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    .cozy-suggestion-btn {
        background: #f0f2f5;
        border: 1px solid #e4e6eb;
        color: #355F2E;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 13px;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
        font-family: 'Inter', Arial, sans-serif;
    }

    .cozy-suggestion-btn:hover {
        background: #e4e6eb;
        border-color: #355F2E;
    }

    /* Animation loading */
    .dot-typing {
        display: inline-flex;
        gap: 3px;
        align-items: center;
        height: 15px;
    }

    .dot-typing span {
        width: 4px;
        height: 4px;
        background-color: #888;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out both;
    }

    .dot-typing span:nth-child(1) {
        animation-delay: -0.32s;
    }

    .dot-typing span:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes typing {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }
</style>

<div class="cozy-chat-widget">
    <div class="cozy-chat-btn" id="aiChatBtn" title="Chat với Cozy Bot"><i class="fa-solid fa-comment-dots"
            style="color: #ffffff; font-size: 28px;"></i></div>
    <div class="cozy-chat-box" id="aiChatBox">
        <div class="cozy-chat-header">
            <span><i class="fa-solid fa-robot" style="margin-right: 8px;"></i> Cozy Bot AI</span>
            <div>
                <i class="fa-solid fa-broom" id="aiChatClear" title="Làm mới cuộc trò chuyện"
                    style="margin-right: 15px; font-size: 14px;"></i>
                <i class="fa-solid fa-xmark" id="aiChatClose" title="Đóng" style="font-size: 18px;"></i>
            </div>
        </div>

        <!-- Custom Confirm Overlay -->
        <div id="aiChatConfirm"
            style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 100; flex-direction: column; justify-content: center; align-items: center;">
            <div
                style="background: #fff; padding: 25px 20px; border-radius: 12px; width: 75%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <i class="fa-solid fa-broom" style="font-size: 32px; color: #355F2E; margin-bottom: 12px;"></i>
                <h4 style="margin: 0 0 8px 0; font-size: 16px; color: #333;">Làm mới trò chuyện?</h4>
                <p style="font-size: 13px; color: #666; margin-bottom: 20px; line-height: 1.5;">Trợ lý sẽ quên đoạn chat
                    cũ và bắt đầu lại từ đầu.</p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button id="aiConfirmCancel"
                        style="flex: 1; padding: 8px 0; border: 1px solid #ddd; background: #f4f4f4; border-radius: 20px; cursor: pointer; color: #555; font-size: 13.5px; transition: 0.2s;"
                        onmouseover="this.style.background='#ebebeb'" onmouseout="this.style.background='#f4f4f4'">Hủy
                        bỏ</button>
                    <button id="aiConfirmOk"
                        style="flex: 1; padding: 8px 0; border: none; background: #355F2E; color: #fff; border-radius: 20px; cursor: pointer; font-size: 13.5px; transition: 0.2s;"
                        onmouseover="this.style.background='#2a4c24'" onmouseout="this.style.background='#355F2E'">Đồng
                        ý</button>
                </div>
            </div>
        </div>

        <div class="cozy-chat-body" id="aiChatBody">
            <div class="msg-bubble msg-bot">
                Xin chào 👋 Mình là <strong>Cozy Bot</strong> – trợ lý siêu trí tuệ tại CozyCorner.<br><br>
                Mình có thể giúp bạn kiểm tra <strong>đơn hàng</strong>, tìm <strong>sản phẩm</strong>, tư vấn lựa chọn
                hoặc cung cấp <strong>link mua hàng</strong> và mã giảm giá.<br><br>Bạn đang cần gì hôm nay?
            </div>
            <div class="cozy-typing" id="aiTyping">
                Đang suy nghĩ <div class="dot-typing"><span></span><span></span><span></span></div>
            </div>
        </div>
        <div class="cozy-chat-suggestions" id="aiChatSuggestions">
            <button class="cozy-suggestion-btn">Đơn hàng của tôi đâu?</button>
            <button class="cozy-suggestion-btn">Shop có bán những gì</button>
            <button class="cozy-suggestion-btn">Mã giảm giá hôm nay</button>
            <button class="cozy-suggestion-btn">Chính sách bảo hành</button>
            <button class="cozy-suggestion-btn">Địa chỉ shop ở đâu?</button>
        </div>
        <div class="cozy-chat-footer">
            <input type="text" id="aiChatInput" class="cozy-chat-input" placeholder="Nhập tin nhắn..."
                autocomplete="off">
            <button id="aiChatSend" class="cozy-chat-send"><i class="fa-solid fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<!-- Thư viện parse Markdown (để in đậm chữ, list) -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<!-- Đóng thẻ body và html (để hoàn thiện cấu trúc trang) -->
<?php // Nạp modal giỏ hàng và script xử lý
require_once __DIR__ . '/../view/cart_modal.php'; ?>
<script>
    const BASE_URL = '<?= BASE_URL ?>';
</script>
<script src="<?= BASE_URL ?>assets/js/cart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const btn = document.getElementById("aiChatBtn");
        const box = document.getElementById("aiChatBox");
        const close = document.getElementById("aiChatClose");
        const clearBtn = document.getElementById("aiChatClear");
        const body = document.getElementById("aiChatBody");
        const input = document.getElementById("aiChatInput");
        const send = document.getElementById("aiChatSend");
        const typing = document.getElementById("aiTyping");

        const confirmModal = document.getElementById("aiChatConfirm");
        const btnConfirmOk = document.getElementById("aiConfirmOk");
        const btnConfirmCancel = document.getElementById("aiConfirmCancel");

        // Bật/tắt cửa sổ chat
        btn.onclick = () => {
            box.style.display = box.style.display === "flex" ? "none" : "flex";
            if (box.style.display === "flex") input.focus();
        };
        close.onclick = () => box.style.display = "none";

        // Hàm chèn tin nhắn
        const appendMsg = (sender, text, isHtml = false) => {
            const div = document.createElement("div");
            div.className = `msg-bubble msg-${sender}`;
            let htmlContent = isHtml ? text : text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            if (isHtml) {
                htmlContent = htmlContent.replace(/<a /g, '<a target="_blank" '); // Ép toàn bộ link mở sang Tab Mới
            }
            div.innerHTML = htmlContent;
            body.insertBefore(div, typing);
            body.scrollTop = body.scrollHeight;
        };

        // TÍNH NĂNG ĐỒNG BỘ LỊCH SỬ CHAT KHI CHUYỂN TRANG
        fetch(BASE_URL + 'index.php?url=chatbot/history')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    const defaultMsg = body.querySelector('.msg-bot');
                    if (defaultMsg) defaultMsg.remove(); // Ẩn câu chào mặc định

                    data.data.forEach(msg => {
                        if (msg.role === 'user') {
                            appendMsg('user', msg.content);
                        } else if (msg.role === 'bot') {
                            appendMsg('bot', marked.parse(msg.content), true);
                        }
                    });
                }
            });

        // Xử lý click vào các nút gợi ý câu hỏi
        const suggestionBtns = document.querySelectorAll('.cozy-suggestion-btn');
        suggestionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                input.value = btn.innerText;
                handleSend();
            });
        });

        // Tính năng kéo chuột để cuộn thanh gợi ý (Drag to scroll)
        const suggestionsContainer = document.getElementById('aiChatSuggestions');
        let isDown = false;
        let startX;
        let scrollLeft;

        suggestionsContainer.addEventListener('mousedown', (e) => {
            isDown = true;
            suggestionsContainer.style.cursor = 'grabbing';
            startX = e.pageX - suggestionsContainer.offsetLeft;
            scrollLeft = suggestionsContainer.scrollLeft;
        });
        suggestionsContainer.addEventListener('mouseleave', () => {
            isDown = false;
            suggestionsContainer.style.cursor = 'grab';
        });
        suggestionsContainer.addEventListener('mouseup', () => {
            isDown = false;
            suggestionsContainer.style.cursor = 'grab';
        });
        suggestionsContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - suggestionsContainer.offsetLeft;
            const walk = (x - startX) * 2; // Tốc độ trượt
            suggestionsContainer.scrollLeft = scrollLeft - walk;
        });

        // Xử lý gửi tin nhắn
        let isSending = false; // Cờ kiểm tra trạng thái đang gửi

        const handleSend = () => {
            if (isSending) return; // Chặn spam click (Debounce)

            const msg = input.value.trim();
            if (!msg) return;

            appendMsg('user', msg);
            input.value = "";
            typing.style.display = "flex";
            body.scrollTop = body.scrollHeight;

            // Khóa UI trong lúc chờ AI (Tạo luồng request tuần tự)
            isSending = true;
            input.disabled = true;
            send.disabled = true;

            // Gọi API
            fetch(BASE_URL + 'index.php?url=chatbot/ask', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: msg })
            })
                .then(res => res.json())
                .then(data => {
                    typing.style.display = "none";
                    if (data.status === 'success') {
                        appendMsg('bot', marked.parse(data.reply), true);
                    } else {
                        appendMsg('bot', "Lỗi: " + data.reply);
                    }
                }).catch(e => {
                    typing.style.display = "none";
                    appendMsg('bot', "Lỗi mất kết nối với máy chủ AI.");
                }).finally(() => {
                    // Mở khóa UI sau khi hoàn tất
                    isSending = false;
                    input.disabled = false;
                    send.disabled = false;
                    if (box.style.display === "flex") input.focus();
                });
        };

        send.onclick = handleSend;
        input.onkeypress = (e) => { if (e.key === 'Enter') handleSend(); };

        // Tính năng xóa trí nhớ
        clearBtn.onclick = () => {
            // Hiển thị custom confirm modal
            confirmModal.style.display = "flex";
        };

        btnConfirmCancel.onclick = () => {
            confirmModal.style.display = "none";
        };

        btnConfirmOk.onclick = () => {
            confirmModal.style.display = "none";
            fetch(BASE_URL + 'index.php?url=chatbot/ask', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'clear' })
            }).then(() => {
                // Dọn sạch màn hình và chèn lại câu chào
                Array.from(body.querySelectorAll('.msg-bubble')).forEach(el => el.remove());
                const welcomeHtml = `Xin chào 👋 Mình là <strong>Cozy Bot</strong> – trợ lý siêu trí tuệ tại CozyCorner.<br><br>Mình có thể giúp bạn kiểm tra <strong>đơn hàng</strong>, tìm <strong>sản phẩm</strong>, tư vấn lựa chọn hoặc cung cấp <strong>link mua hàng</strong> và mã giảm giá.<br><br>Bạn đang cần gì hôm nay?`;
                appendMsg('bot', welcomeHtml, true);
            });
        };
    });
</script>
</body>

</html>
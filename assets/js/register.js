document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('so_dien_thoai');
    const form = document.querySelector('.register__form');

  
    function createErrorElement(inputId, message) {
        removeErrorElement(inputId); // Remove old error first
        const inputElement = document.getElementById(inputId);
        const errorDiv = document.createElement('div');
        errorDiv.id = inputId + '-error-inline';
        errorDiv.textContent = message;
        errorDiv.style.color = '#D32F2F';
        errorDiv.style.fontSize = '14px';
        errorDiv.style.marginTop = '8px';
        errorDiv.style.textAlign = 'left';
        inputElement.parentNode.appendChild(errorDiv);
    }

   
    function removeErrorElement(inputId) {
        const errorElement = document.getElementById(inputId + '-error-inline');
        if (errorElement) {
            errorElement.remove();
        }
    }

    
    function checkExistence(field, value, inputId) {
        // Don't check empty values
        if (!value || value.trim() === '') {
            removeErrorElement(inputId);
            return;
        }

       
        if (field === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
             createErrorElement(inputId, 'Email không hợp lệ.');
             return;
        } else {
             removeErrorElement(inputId);
        }

        fetch(`${BASE_URL}index.php?url=auth/api_check_existence&field=${field}&value=${encodeURIComponent(value)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    createErrorElement(inputId, (field === 'email' ? 'Email' : 'Số điện thoại') + ' này đã được sử dụng.');
                } else {
                    removeErrorElement(inputId);
                }
            })
            .catch(error => console.error('Lỗi kiểm tra:', error));
    }

    
    let emailTimeout;
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            clearTimeout(emailTimeout);
            emailTimeout = setTimeout(() => {
                checkExistence('email', emailInput.value, 'email');
            }, 500); // Debounce for 500ms
        });
    }

    let phoneTimeout;
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            clearTimeout(phoneTimeout);
            phoneTimeout = setTimeout(() => {
                checkExistence('so_dien_thoai', phoneInput.value, 'so_dien_thoai');
            }, 500); // Debounce for 500ms
        });
    }
});

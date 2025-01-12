const passwordFields = document.querySelectorAll('input[type="password"]');
const passwordToggles = document.querySelectorAll('.password-toggle');

passwordToggles.forEach((toggle, index) => {
    toggle.addEventListener('click', function() {
        const type = passwordFields[index].getAttribute('type') === 'password' ? 'text' : 'password';
        passwordFields[index].setAttribute('type', type);
        toggle.textContent = type === 'password' ? 'Hide' : 'Show';
    });
});


// Lấy phần modal
var modal = document.getElementById("loginModal");

// Lấy nút mở modal
var btn = document.getElementById("loginButton");

// Lấy nút đóng modal
var span = document.getElementsByClassName("close-button")[0];

// Lấy phần login và signup form
var loginContainer = document.querySelector('.login-container');
var signupContainer = document.querySelector('.signup-container');
// Lấy nút chuyển đổi giữa login và signup form
var showSignupForm = document.getElementById('showSignupForm');
var showLoginForm = document.getElementById('showLoginForm');


//phần chuyển đổi login và signup form
function showLogin() {
    loginContainer.style.display = 'block';
    signupContainer.style.display = 'none';
}

function showSignup() {
    loginContainer.style.display = 'none';
    signupContainer.style.display = 'flex';
}

let redirect_url;
// hàm mở modal đăng nhập với tham số là url cần chuyển hướng sau khi đăng nhập
function openModal(url) {
    modal.style.display = "block";
    document.body.classList.add('modal-open');
    showLogin();//măc định hiển thị form login
    if(url && url === 'string'){
        redirect_url = url;
    }
}

// hàm đóng modal
function closeModal() {
    modal.style.display = "none";
    document.body.classList.remove('modal-open');
}

// Khi người dùng click nút, mở modal
btn.onclick = openModal;

// Khi người dùng click vào nút đóng, đóng modal
span.onclick = closeModal;

// Khi người dùng click bên ngoài modal, đóng modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.body.classList.remove('modal-open');
    }
}

//phần chuyển đổi nội dung login và signup form
showSignupForm.onclick = showSignup;

showLoginForm.onclick = showLogin;




/*
Xử lý form đăng nhập, đăng ký
*/
document.querySelector('.form-grid').addEventListener('submit', function (e) {
    e.preventDefault(); // Ngăn form submit mặc định

    // Reset errors
    clearErrors();

     // Validate
     let isValid = true;
     const email = this.querySelector('input[name="email"]');
     const password = this.querySelector('input[name="password"]');

     if (!email.value.trim()) {
         showError(email, 'Email is required');
         isValid = false;
     } else if (!isValidEmail(email.value)) {
         showError(email, 'Please enter a valid email');
         isValid = false;
     }

     // Password validation
    if (!password.value.trim()) {
        showError(password, 'Password is required');
        isValid = false;
    } else if (!isValidPassword(password.value)) {
        showError(password, 'Password must be at least 8 characters with 1 lowercase letter, 1 number, and no whitespace');
        isValid = false;
    }

     if (!isValid) return;

     // Submit form
    const formData = new FormData(this);

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Lưu thông báo vào sessionStorage trước khi chuyển hướng
            sessionStorage.setItem('message', data.message);
            window.location.href = data.redirect_url;
            //window.location.href = data.redirect_url;
        } else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error)
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    });
});


// hàm hiển thị thông báo lỗi
function showError(input, message) {
    input.classList.add('error');
    const errorElement = document.getElementById(`${input.name}-error`);
    if (errorElement) {
        errorElement.style.display = 'block';
        errorElement.textContent = message;
    }
}

// hàm clear thông báo lỗi
function clearErrors() {
    document.querySelectorAll('.error-message').forEach(el => {
        el.style.display = 'none';
        el.textContent = '';
    });
    document.querySelectorAll('.form-input').forEach(input => {
        input.classList.remove('error');
    });
}

//hàm kiểm tra email
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
//hàm kiểm tra pass
function isValidPassword(password) {
    // Password validation regex breakdown:
    // ^               - Start of string
    // (?=.*[a-z])    - At least one lowercase letter
    // (?=.*\d)       - At least one digit
    // (?!\s)         - No whitespace allowed
    // .{8,}          - At least 8 characters long
    // $              - End of string
    return /^(?=.*[a-z])(?=.*\d)(?!\s).{8,}$/.test(password);
}

// Add validation helper functions
function validatePassword(password) {
    const minLength = password.length >= 8;
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /\d/.test(password);
    const noWhitespace = !/\s/.test(password);
    return minLength && hasLowerCase && hasNumber && noWhitespace;
}

// Add real-time validation
document.querySelector('input[name="password"]').addEventListener('input', function() {
    const password = this.value.trim();
    const errorElement = document.getElementById('password-error');

    if (password === '') {
        // Don't show error for empty field during typing
        this.classList.remove('error');
        errorElement.style.display = 'none';
    } else if (!validatePassword(password)) {
        this.classList.add('error');
        errorElement.style.display = 'block';
        errorElement.textContent = 'Password must be at least 8 characters with 1 lowercase letter, 1 number, and no whitespace';
    } else {
        // Clear error when validation passes
        this.classList.remove('error');
        errorElement.style.display = 'none';
    }
});

// Update email validation
document.querySelector('input[name="email"]').addEventListener('input', function() {
    const email = this.value.trim();
    const errorElement = document.getElementById('email-error');

    if (email === '') {
        this.classList.remove('error');
        errorElement.style.display = 'none';
    } else if (!isValidEmail(email)) {
        this.classList.add('error');
        errorElement.style.display = 'block';
        errorElement.textContent = 'Please enter a valid email';
    } else {
        this.classList.remove('error');
        errorElement.style.display = 'none';
    }
});
/*
end đăng nhập, đăng ký
*/

/*
Xử lý đăng xuất bằng fetch
*/
function logout(e) {
    e.preventDefault();
    const button = document.getElementById('logout-btn');


    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...';

    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('message', data.message);
            window.location.href = data.redirect_url;
        }
        else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra khi đăng xuất', 'error');
        button.disabled = false;
        button.innerHTML = '<i class="fa fa-sign-out"></i> Đăng xuất';
    });
}

// TUỲ CHỌN: Xử lý đăng xuất bằng async/await và try/catch
async function handleLogout(e) {
    e.preventDefault();
    const button = document.getElementById('logout-btn');

    try {
        button.disabled = true;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...';

        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            sessionStorage.setItem('message', data.message);
            window.location.href = data.redirect_url;
        } else {
            throw new Error(data.message || 'Có lỗi xảy ra');
        }
    } catch (error) {
        console.error('Logout error:', error);
        notification('Có lỗi xảy ra khi đăng xuất', 'error');
        button.disabled = false;
        button.innerHTML = '<i class="fa fa-sign-out"></i> Đăng xuất';
    }
}

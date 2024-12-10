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

// hàm mở modal
function openModal() {
    modal.style.display = "block";
    document.body.classList.add('modal-open');
    showLogin();//măc định hiển thị form login
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

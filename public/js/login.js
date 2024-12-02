const passwordField = document.querySelector('input[type="password"]');
const passwordToggle = document.querySelector('.password-toggle');

passwordToggle.addEventListener('click', function() {
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    passwordToggle.textContent = type === 'password' ? 'Hide' : 'Show';
});

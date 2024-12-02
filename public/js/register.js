const passwordFields = document.querySelectorAll('input[type="password"]');
const passwordToggles = document.querySelectorAll('.password-toggle');

passwordToggles.forEach((toggle, index) => {
    toggle.addEventListener('click', function() {
        const type = passwordFields[index].getAttribute('type') === 'password' ? 'text' : 'password';
        passwordFields[index].setAttribute('type', type);
        toggle.textContent = type === 'password' ? 'Hide' : 'Show';
    });
});

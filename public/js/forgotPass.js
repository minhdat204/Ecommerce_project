// Handle email form submission
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;

    if (validateEmail(email)) {
        document.getElementById('emailStep').style.display = 'none';
        document.getElementById('otpStep').style.display = 'block';
    } else {
        document.querySelector('.error-message').style.display = 'block';
    }
});

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Handle OTP input
const otpInputs = document.querySelectorAll('.otp-input');
otpInputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        if (this.value.length === 1) {
            if (index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        }
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value) {
            if (index > 0) {
                otpInputs[index - 1].focus();
            }
        }
    });
});

// Verify OTP
function verifyOTP() {
    const otp = Array.from(otpInputs).map(input => input.value).join('');
    if (otp.length === 6) {
        document.getElementById('otpStep').style.display = 'none';
        document.getElementById('newPasswordStep').style.display = 'block';
    }
}

// Handle new password form
document.getElementById('newPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (newPassword === confirmPassword) {
        document.getElementById('newPasswordStep').style.display = 'none';
        document.querySelector('.success-message').style.display = 'block';
        // Here you would typically make an API call to update the password
    } else {
        document.querySelector('#newPasswordStep .error-message').style.display = 'block';
    }
});

// Resend OTP
function resendOTP() {
    // Implementation for resending OTP
    alert('New OTP has been sent to your email');
}

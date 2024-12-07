<!-- Modal Đăng nhập -->
<div id="loginModal" class="modal-custom">
    <div class="modal-content-custom">
        <span class="close-button">&times;</span>
        <!-- Form Đăng nhập-->
        <div class="login-container">
            <h1 class="login-title">Log in</h1>
            <p class="login-subtitle">To access your account</p>

            <form class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Email or Username</label>
                    <input type="email" class="form-input" placeholder="Enter your email or username">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Password</label>
                    <div class="password-field">
                        <input type="password" class="form-input" placeholder="Enter your password">
                        <button type="button" class="password-toggle">Hide</button>
                    </div>
                    <a href="#" class="forgot-password">I forgot my password</a>
                </div>

                <button type="submit" class="login-button full-width">LOG IN</button>

                <p class="signup-link full-width">Don't have an account? <a href="#" id="showSignupForm">Sign up</a></p>
            </form>
        </div>
        <!-- Quên mật khẩu -->

        <!-- Form Đăng ký -->
        <div class="signup-container" style="display: none;">
            <h1 class="signup-title">Sign up</h1>
            <p class="signup-subtitle">Create an account to get started</p>

            <form class="form-grid">
                <div class="form-group">
                    <label class="form-label">Profile name <span class="required">*</span></label>
                    <input type="text" class="form-input" placeholder="Enter your profile name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" class="form-input" placeholder="Enter your email address" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <div class="password-field">
                        <input type="password" class="form-input" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle">Hide</button>
                    </div>
                    <div class="password-hint">Use 6 or more characters with a mix of letters, numbers or symbols</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password <span class="required">*</span></label>
                    <div class="password-field">
                        <input type="password" class="form-input" placeholder="Enter your password" required>
                        <button type="button" class="password-toggle">Hide</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">What's your date of birth?</label>
                    <div class="date-input">
                        <input type="date" class="form-input" placeholder="MM/DD/YYYY">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">What's your gender? (optional)</label>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input type="radio" name="gender" value="female">
                            <span>Female</span>
                        </label>
                        <label class="gender-option">
                            <input type="radio" name="gender" value="male">
                            <span>Male</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="signup-button full-width">SIGN UP</button>

                <p class="login-link full-width">Already have an account? <a href="#" id="showLoginForm">Log in</a></p>
            </form>
        </div>
    </div>
</div>

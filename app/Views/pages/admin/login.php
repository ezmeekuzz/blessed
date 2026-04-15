<!DOCTYPE html>
<html lang="en">

<head>
    <title>The Blessed Manifest - Admin Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin Login - The Blessed Manifest" />
    <meta name="author" content="The Blessed Manifest" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="<?=base_url();?>images/favicon.ico">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Abel', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #E8DDD7 0%, #D4C5BC 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        
        .bg-animation .circle {
            position: absolute;
            background: rgba(61, 32, 78, 0.05);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }
        
        .bg-animation .circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .bg-animation .circle:nth-child(2) {
            width: 500px;
            height: 500px;
            bottom: -200px;
            right: -200px;
            animation-delay: 5s;
        }
        
        .bg-animation .circle:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }
        
        /* Login Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 2rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease;
            width: 100%;
            max-width: 1000px;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        /* Left Panel */
        .login-info {
            background: linear-gradient(135deg, #3D204E 0%, #5a2e72 100%);
            padding: 3rem;
            color: white;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-info h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .login-info p {
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }
        
        .feature-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .feature-list i {
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
        }
        
        .brand-icon {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
        }
        
        .brand-icon img {
            height: 50px;
            filter: brightness(0) invert(1);
        }
        
        /* Right Panel - Form */
        .login-form-panel {
            padding: 3rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h3 {
            color: #3D204E;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #666;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            color: #3D204E;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #3D204E;
            font-size: 1.1rem;
            opacity: 0.7;
        }
        
        .form-control-custom {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0d6cc;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-control-custom:focus {
            outline: none;
            border-color: #3D204E;
            box-shadow: 0 0 0 3px rgba(61, 32, 78, 0.1);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .checkbox-custom input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #3D204E;
        }
        
        .checkbox-custom label {
            margin: 0;
            font-weight: 400;
            cursor: pointer;
        }
        
        .forgot-link {
            color: #3D204E;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3D204E 0%, #5a2e72 100%);
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(61, 32, 78, 0.3);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .register-link {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid #e0d6cc;
        }
        
        .register-link a {
            color: #3D204E;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        /* Alert Messages */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            display: none;
            align-items: center;
            gap: 12px;
        }
        
        .alert-custom.show {
            display: flex;
        }
        
        .alert-custom i {
            font-size: 1.2rem;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }
        
        .alert-success {
            background: #e6f4ea;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                max-width: 90%;
            }
            
            .login-info {
                padding: 2rem;
            }
            
            .login-form-panel {
                padding: 2rem;
            }
            
            .login-info h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .login-card {
                max-width: 95%;
            }
            
            .login-form-panel {
                padding: 1.5rem;
            }
        }
        
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .loading-spinner {
            background: white;
            padding: 20px;
            border-radius: 16px;
            text-align: center;
        }
        
        .loading-spinner i {
            font-size: 2rem;
            color: #3D204E;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <i class="bi bi-arrow-repeat"></i>
            <p class="mt-2 mb-0">Authenticating...</p>
        </div>
    </div>
    
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    
    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <div class="row g-0">
                <!-- Left Panel - Brand Info -->
                <div class="col-lg-6">
                    <div class="login-info">
                        <div class="brand-icon">
                            <img src="<?=base_url();?>images/logo-white.png" alt="The Blessed Manifest" onerror="this.src='<?=base_url();?>images/logo.png'">
                            <span style="font-size: 1.5rem; font-weight: 700;">The Blessed Manifest</span>
                        </div>
                        
                        <h2>Welcome Back, Administrator</h2>
                        <p>Access your admin dashboard to manage products, users, orders, and monitor your faith-driven e-commerce platform.</p>
                        
                        <ul class="feature-list">
                            <li>
                                <i class="bi bi-check-lg"></i>
                                <span>Manage Products & Inventory</span>
                            </li>
                            <li>
                                <i class="bi bi-people"></i>
                                <span>User Management & Verification</span>
                            </li>
                            <li>
                                <i class="bi bi-cart-check"></i>
                                <span>Order Processing & Tracking</span>
                            </li>
                            <li>
                                <i class="bi bi-graph-up"></i>
                                <span>Sales Analytics & Reports</span>
                            </li>
                            <li>
                                <i class="bi bi-envelope-paper"></i>
                                <span>Email Campaign Management</span>
                            </li>
                        </ul>
                        
                        <div class="mt-auto">
                            <small style="opacity: 0.7;">© <?= date('Y') ?> The Blessed Manifest. All rights reserved.</small>
                        </div>
                    </div>
                </div>
                
                <!-- Right Panel - Login Form -->
                <div class="col-lg-6">
                    <div class="login-form-panel">
                        <div class="login-header">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3D204E 0%, #5a2e72 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                                <i class="bi bi-shield-lock" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <h3>Admin Sign In</h3>
                            <p>Enter your credentials to access the admin panel</p>
                        </div>
                        
                        <!-- Alert Messages -->
                        <div id="alertMessage" class="alert-custom alert-error">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span id="alertText"></span>
                        </div>
                        
                        <form id="loginForm">
                            <div class="form-group">
                                <label>Email Address</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" class="form-control-custom" id="emailaddress" name="emailaddress" placeholder="admin@theblessedmanifest.com" required autocomplete="email" value="<?= isset($_COOKIE['admin_email']) ? htmlspecialchars($_COOKIE['admin_email']) : '' ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-lock"></i>
                                    <input type="password" class="form-control-custom" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password" value="<?= isset($_COOKIE['admin_password']) ? htmlspecialchars($_COOKIE['admin_password']) : '' ?>">
                                </div>
                            </div>
                            
                            <div class="remember-forgot">
                                <label class="checkbox-custom">
                                    <input type="checkbox" id="rememberMe" name="remember_me" <?= isset($_COOKIE['admin_email']) ? 'checked' : '' ?>>
                                    <span>Remember me</span>
                                </label>
                                <a href="<?=base_url('forgot-password');?>" class="forgot-link">Forgot Password?</a>
                            </div>
                            
                            <button type="submit" class="btn-login" id="loginBtn">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </button>
                            
                            <div class="register-link">
                                <p>Don't have an account? <a href="<?=base_url('register');?>">Create an account</a></p>
                                <p class="mt-2">
                                    <a href="<?=base_url('/');?>" class="forgot-link">
                                        <i class="bi bi-arrow-left"></i> Back to Homepage
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Check if there's a saved email in cookie
            const savedEmail = getCookie('admin_email');
            if (savedEmail) {
                $('#emailaddress').val(savedEmail);
            }
            
            // Handle form submission
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const emailaddress = $('#emailaddress').val().trim();
                const password = $('#password').val();
                const rememberMe = $('#rememberMe').is(':checked');
                
                // Validate email
                if (!emailaddress) {
                    showAlert('Please enter your email address.', 'error');
                    return;
                }
                
                // Validate email format
                const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
                if (!emailRegex.test(emailaddress)) {
                    showAlert('Please enter a valid email address.', 'error');
                    return;
                }
                
                // Validate password
                if (!password) {
                    showAlert('Please enter your password.', 'error');
                    return;
                }
                
                // Show loading state
                const submitBtn = $('#loginBtn');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="bi bi-hourglass-split me-2"></i>Signing In...');
                
                // Show loading overlay
                $('#loadingOverlay').fadeIn(200);
                
                // Hide any existing alert
                $('#alertMessage').removeClass('show');
                
                // Make AJAX request to authenticate
                $.ajax({
                    type: 'POST',
                    url: '<?=base_url('admin/login/authenticate');?>',
                    data: {
                        emailaddress: emailaddress,
                        password: password,
                        remember_me: rememberMe
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Hide loading overlay
                        $('#loadingOverlay').fadeOut(200);
                        
                        if (response.success) {
                            // Handle Remember Me functionality
                            if (rememberMe) {
                                // Set cookies for 30 days
                                setCookie('admin_email', emailaddress, 30);
                                setCookie('admin_password', password, 30);
                                setCookie('admin_remember', 'true', 30);
                            } else {
                                // Clear cookies if remember me is unchecked
                                deleteCookie('admin_email');
                                deleteCookie('admin_password');
                                deleteCookie('admin_remember');
                            }
                            
                            // Show success message with SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: response.message || 'Welcome back to The Blessed Manifest Admin Panel.',
                                timer: 1500,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                // Redirect to dashboard
                                window.location.href = response.redirect || '<?=base_url('admin/dashboard');?>';
                            });
                        } else {
                            // Show error message
                            showAlert(response.message || 'Invalid login credentials', 'error');
                            submitBtn.prop('disabled', false);
                            submitBtn.html(originalText);
                            
                            // Clear password field for security
                            $('#password').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hide loading overlay
                        $('#loadingOverlay').fadeOut(200);
                        
                        console.error('AJAX Error:', error);
                        console.error('Response:', xhr.responseText);
                        
                        let errorMessage = 'An error occurred. Please try again.';
                        
                        // Try to parse error response
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch(e) {
                            // If response is not JSON, use default message
                        }
                        
                        showAlert(errorMessage, 'error');
                        submitBtn.prop('disabled', false);
                        submitBtn.html(originalText);
                        
                        // Clear password field for security
                        $('#password').val('');
                    }
                });
            });
            
            // Show alert message function
            function showAlert(message, type) {
                const alertBox = $('#alertMessage');
                const alertText = $('#alertText');
                
                alertBox.removeClass('alert-error alert-success');
                if (type === 'error') {
                    alertBox.addClass('alert-error');
                } else {
                    alertBox.addClass('alert-success');
                }
                
                alertText.text(message);
                alertBox.addClass('show');
                
                // Auto-hide after 5 seconds
                setTimeout(function() {
                    alertBox.removeClass('show');
                }, 5000);
            }
            
            // Cookie helper functions
            function setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }
            
            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for(let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }
            
            function deleteCookie(name) {
                document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }
            
            // Add floating label effect
            $('.form-control-custom').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                if (!$(this).val()) {
                    $(this).parent().removeClass('focused');
                }
            });
            
            // Enter key support for form submission
            $('#password').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#loginForm').submit();
                }
            });
        });
    </script>
</body>

</html>
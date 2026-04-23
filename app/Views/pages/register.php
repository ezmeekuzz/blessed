<?= $this->include('templates/header'); ?>

<!-- REGISTRATION SECTION -->
<section class="registration-section py-5">
    <div class="container">
        <div class="row g-0 align-items-stretch">
            <!-- Left Column - Registration Form -->
            <div class="col-lg-6">
                <div class="p-5 h-100 d-flex flex-column" style="background: #F9F7FA; border-radius: 24px 0 0 24px;">
                    <!-- Welcome header -->
                    <h1 class="display-5 fw-bold mb-3" style="color: #3D204E;">
                        Create Your Account
                    </h1>
                    
                    <!-- Login link -->
                    <p class="fs-5 mb-5">
                        Already Have An Account? 
                        <a href="/login" class="text-decoration-underline fw-semibold" style="color: #3D204E;">Login Here</a>
                    </p>

                    <!-- Registration Form -->
                    <form class="registration-form" id="register">
                        <!-- First Name field -->
                        <div class="mb-4">
                            <label for="firstname" class="form-label fw-semibold mb-2" style="color: #3D204E;">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-4 border" name="firstname" id="firstname" placeholder="Enter your first name" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                        </div>

                        <!-- Last Name field -->
                        <div class="mb-4">
                            <label for="lastname" class="form-label fw-semibold mb-2" style="color: #3D204E;">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg rounded-4 border" name="lastname" id="lastname" placeholder="Enter your last name" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                        </div>

                        <!-- Email field -->
                        <div class="mb-4">
                            <label for="emailaddress" class="form-label fw-semibold mb-2" style="color: #3D204E;">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-lg rounded-4 border" name="emailaddress" id="emailaddress" placeholder="Enter your email address" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                        </div>

                        <!-- Password field with strength indicator -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold mb-2" style="color: #3D204E;">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-lg rounded-4 border" name="password" id="password" placeholder="Create a password" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                            <div id="passwordStrength" class="mt-2"></div>
                            <small class="text-muted">Minimum 8 characters with at least one number and one letter</small>
                        </div>

                        <!-- Confirm Password field -->
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label fw-semibold mb-2" style="color: #3D204E;">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-lg rounded-4 border" name="confirmpassword" id="confirmpassword" placeholder="Confirm your password" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                            <div id="passwordMatch" class="mt-2"></div>
                        </div>

                        <!-- Terms and conditions checkbox -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" style="border-color: #3D204E; cursor: pointer;" required>
                                <label class="form-check-label text-secondary" for="terms">
                                    I agree to the <a href="/terms-and-conditions" style="color: #3D204E; text-decoration: underline;">Terms of Service</a> and <a href="/privacy-policy" style="color: #3D204E; text-decoration: underline;">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Register button -->
                        <button type="submit" class="btn w-100 py-3 rounded-4 text-white fs-5 fw-semibold border-0 mb-4" style="background: #3D204E;">
                            Create Account
                        </button>
                    </form>

                    <!-- Login link at bottom -->
                    <p class="text-center fs-6 mb-0 mt-3">
                        Already have an account? 
                        <a href="/login" class="text-decoration-underline fw-semibold" style="color: #3D204E;">Sign in</a>
                    </p>
                </div>
            </div>

            <!-- Right Column - Scripture Verses with Background Image -->
            <div class="col-lg-6">
                <div class="h-100 d-flex flex-column justify-content-center p-5" style="background: linear-gradient(rgba(61, 32, 78, 0.75), rgba(61, 32, 78, 0.75)), url('<?= base_url('images/login-bg.png') ?>'); background-size: cover; background-position: center; border-radius: 0 24px 24px 0; min-height: 700px;">
                    
                    <!-- Welcome message -->
                    <div class="text-white text-center mb-5">
                        <h2 class="display-6 fw-bold mb-4">Join Our Faith Community</h2>
                        <p class="fs-4">Begin your journey of faith and manifestation</p>
                    </div>
                    
                    <!-- Scripture verses -->
                    <div class="text-white text-center mb-5">
                        <p class="fs-3 fst-italic mb-4">"Ask and it will be given to you; seek and you will find; knock and the door will be opened to you."</p>
                        <p class="fs-5 fw-semibold">— Matthew 7:7</p>
                    </div>
                    
                    <div class="text-white text-center">
                        <p class="fs-3 fst-italic mb-4">"Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!"</p>
                        <p class="fs-5 fw-semibold">— 2 Corinthians 5:17</p>
                    </div>
                    
                    <!-- Benefits list -->
                    <div class="text-white mt-5">
                        <h5 class="fw-bold mb-3">When you join, you'll get:</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Daily devotionals</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Prayer community</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Scripture study guides</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Faith-based resources</li>
                            <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Personalized products</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>

<script>
$(document).ready(function() {
    // Password strength indicator
    $('#password').on('keyup', function() {
        const password = $(this).val();
        const strengthBar = $('#passwordStrength');
        
        if (password.length === 0) {
            strengthBar.html('');
            return;
        }
        
        let strength = 0;
        let strengthText = '';
        let strengthColor = '';
        
        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Contains number
        if (/\d/.test(password)) strength++;
        
        // Contains lowercase and uppercase
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        
        // Contains special character
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
        
        if (strength <= 2) {
            strengthText = 'Weak';
            strengthColor = '#dc3545';
        } else if (strength <= 4) {
            strengthText = 'Medium';
            strengthColor = '#ffc107';
        } else {
            strengthText = 'Strong';
            strengthColor = '#28a745';
        }
        
        const width = (strength / 5) * 100;
        
        strengthBar.html(`
            <div class="progress" style="height: 5px;">
                <div class="progress-bar" role="progressbar" style="width: ${width}%; background-color: ${strengthColor};" aria-valuenow="${width}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small style="color: ${strengthColor};">Password Strength: ${strengthText}</small>
        `);
    });
    
    // Password match indicator
    $('#confirmpassword').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        const matchDiv = $('#passwordMatch');
        
        if (confirmPassword.length === 0) {
            matchDiv.html('');
            return;
        }
        
        if (password === confirmPassword) {
            matchDiv.html('<small style="color: #28a745;"><i class="fas fa-check-circle"></i> Passwords match</small>');
        } else {
            matchDiv.html('<small style="color: #dc3545;"><i class="fas fa-times-circle"></i> Passwords do not match</small>');
        }
    });
    
    // Form submission
    $('#register').submit(function(event) {
        event.preventDefault();

        // Get form values
        let firstname = $('#firstname').val().trim();
        let lastname = $('#lastname').val().trim();
        let emailaddress = $('#emailaddress').val().trim();
        let password = $('#password').val();
        let confirmpassword = $('#confirmpassword').val();
        
        // Validate first name
        if (firstname === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Field',
                text: 'Please enter your first name.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate last name
        if (lastname === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Field',
                text: 'Please enter your last name.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate email
        if (emailaddress === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Field',
                text: 'Please enter your email address.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate email format
        let emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
        if (!emailRegex.test(emailaddress)) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate password
        if (password === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Field',
                text: 'Please enter a password.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        if (password.length < 8) {
            Swal.fire({
                icon: 'warning',
                title: 'Weak Password',
                text: 'Password must be at least 8 characters long.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate confirm password
        if (confirmpassword === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Field',
                text: 'Please confirm your password.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        if (password !== confirmpassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Password Mismatch',
                text: 'Passwords do not match.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }
        
        // Validate terms and conditions
        if (!$('#terms').is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms & Conditions',
                text: 'Please agree to the Terms of Service and Privacy Policy.',
                confirmButtonColor: '#3D204E'
            });
            return;
        }

        // Get form data
        let formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: '/register/insert',
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Creating Account...',
                    html: 'Please wait while we set up your account.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: response.message,
                        confirmButtonColor: '#3D204E',
                        confirmButtonText: 'Continue'
                    }).then(() => {
                        window.location.href = response.redirect || '/verification-sent';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: response.message,
                        confirmButtonColor: '#3D204E'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while registering. Please try again later.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                    confirmButtonColor: '#3D204E'
                });
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

<style>
/* Additional styles for registration page */
.progress {
    background-color: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.3s ease;
}

.form-check-input:checked {
    background-color: #3D204E;
    border-color: #3D204E;
}

.form-control:focus {
    border-color: #3D204E !important;
    box-shadow: 0 0 0 0.2rem rgba(61, 32, 78, 0.25);
}
</style>
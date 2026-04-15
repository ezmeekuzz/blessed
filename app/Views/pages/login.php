<?= $this->include('templates/header'); ?>

<!-- LOGIN SECTION -->
<section class="login-section py-5">
    <div class="container">
        <div class="row g-0 align-items-stretch">
            <!-- Left Column - Login Form -->
            <div class="col-lg-6">
                <div class="p-5 h-100 d-flex flex-column" style="background: #F9F7FA; border-radius: 24px 0 0 24px;">
                    <!-- Welcome header -->
                    <h1 class="display-5 fw-bold mb-3" style="color: #3D204E;">
                        Welcome To Blessed Manifest
                    </h1>
                    
                    <!-- Create account link -->
                    <p class="fs-5 mb-5">
                        Don't Have An Account? 
                        <a href="/register" class="text-decoration-underline fw-semibold" style="color: #3D204E;">Create An Account</a>
                    </p>

                    <!-- Login Form -->
                    <form class="login-form" id="signIn">
                        <!-- Email field -->
                        <div class="mb-4">
                            <label for="emailaddress" class="form-label fw-semibold mb-2" style="color: #3D204E;">Email Address</label>
                            <input type="email" class="form-control form-control-lg rounded-4 border" name="emailaddress" id="emailaddress" placeholder="Enter Your Email Address" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                        </div>

                        <!-- Password field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold mb-2" style="color: #3D204E;">Password</label>
                            <input type="password" class="form-control form-control-lg rounded-4 border" name="password" id="password" placeholder="Enter your password" style="border-color: #d9cde0 !important; padding: 0.9rem 1.2rem; background: white;" required>
                        </div>

                        <!-- Forgot password link -->
                        <div class="text-end mb-4">
                            <a href="/forgot-password" class="text-decoration-none" style="color: #3D204E;">Forgot Your Password?</a>
                        </div>
                        
                        <div class="py-3 g-recaptcha" data-sitekey="6LeJO_ApAAAAAKjH-ats7ZeBaHnW7s3U2HFePpS1"></div>
                        
                        <!-- Login button -->
                        <button type="submit" class="btn w-100 py-3 rounded-4 text-white fs-5 fw-semibold border-0 mb-4" style="background: #3D204E;">
                            Login
                        </button>
                    </form>

                    <!-- Create account alternative -->
                    <p class="text-center fs-5 mb-0 mt-auto">
                        Don't Have An Account? 
                        <a href="/register" class="text-decoration-underline fw-semibold" style="color: #3D204E;">Create An Account</a>
                    </p>
                </div>
            </div>

            <!-- Right Column - Scripture Verses with Background Image -->
            <div class="col-lg-6">
                <div class="h-100 d-flex flex-column justify-content-center p-5" style="background: linear-gradient(rgba(61, 32, 78, 0.3), rgba(61, 32, 78, 0.3)), url('images/login-bg.png'); background-size: cover; background-position: center; border-radius: 0 24px 24px 0; min-height: 700px;">
                    <!-- Scripture verses container -->
                    <div class="text-white text-center">
                        <p class="fs-3 fst-italic mb-4">"For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future."</p>
                        <p class="fs-5 fw-semibold">— Jeremiah 29:11</p>
                    </div>
                    
                    <div class="text-white text-center mt-5">
                        <p class="fs-3 fst-italic mb-4">"Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight."</p>
                        <p class="fs-5 fw-semibold">— Proverbs 3:5-6</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
<script>
    $(document).ready(function() {
        // Check if the current URL has the redirect parameter set to "quote"
        const urlParams = new URLSearchParams(window.location.search);
        $('#redirect').val(urlParams.get('redirect'));

        $('#signIn').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();
            // Check if reCAPTCHA is filled
            let captchaResponse = grecaptcha.getResponse();
            if (captchaResponse.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please complete the reCAPTCHA!',
                });
                return;
            }
            // Get form data
            var emailaddress = $('#emailaddress').val();
            var password = $('#password').val();

            // Perform client-side validation
            if (emailaddress.trim() === '' || password.trim() === '') {
                // Show error using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in the required fields!',
                });
                return;
            }

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: '<?= base_url('login/authenticate'); ?>',
                data: $('#signIn').serialize(), // Serialize form data
                dataType: 'json',
                beforeSend: function() {
                    // Show loading effect
                    Swal.fire({
                        title: 'Logging In...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        // Redirect upon successful login
                        Swal.fire({
                            icon: 'success',
                            title: 'Logged In',
                            text: response.message,
                            timer: 1000, // Display message for 3 seconds
                            timerProgressBar: true,
                            showConfirmButton: false // Hide the "OK" button
                        }).then((result) => {
                            // Redirect after Swal alert is closed
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while logging in. Please try again later.',
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
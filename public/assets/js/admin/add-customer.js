/**
 * Add Customer Page JavaScript
 * Handles form validation, password strength, and AJAX submission
 */

$(document).ready(function() {
    // DOM Elements
    const firstname = $('#firstname');
    const lastname = $('#lastname');
    const emailaddress = $('#emailaddress');
    const password = $('#password');
    const confirmPassword = $('#confirm_password');
    const resetFormBtn = $('#resetFormBtn');
    const submitBtn = $('#submitBtn');
    const addCustomerForm = $('#addCustomerForm');
    const passwordStrength = $('#passwordStrength');
    const strengthText = $('#strengthText');
    const passwordMatch = $('#passwordMatch');

    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Password strength checker
    function checkPasswordStrength(pwd) {
        let strength = 0;
        
        if (pwd.length === 0) {
            passwordStrength.removeClass('weak fair good strong').addClass('');
            strengthText.text('Enter a password');
            return 0;
        }
        
        if (pwd.length >= 6) strength++;
        if (pwd.length >= 8) strength++;
        if (pwd.match(/[a-z]+/)) strength++;
        if (pwd.match(/[A-Z]+/)) strength++;
        if (pwd.match(/[0-9]+/)) strength++;
        if (pwd.match(/[$@#&!]+/)) strength++;
        
        // Update UI
        passwordStrength.removeClass('weak fair good strong');
        
        if (strength <= 2) {
            passwordStrength.addClass('weak');
            strengthText.html('<i class="fas fa-exclamation-triangle"></i> Weak password');
            return 1;
        } else if (strength <= 4) {
            passwordStrength.addClass('fair');
            strengthText.html('<i class="fas fa-chart-line"></i> Fair password');
            return 2;
        } else if (strength <= 5) {
            passwordStrength.addClass('good');
            strengthText.html('<i class="fas fa-thumbs-up"></i> Good password');
            return 3;
        } else {
            passwordStrength.addClass('strong');
            strengthText.html('<i class="fas fa-shield-alt"></i> Strong password');
            return 4;
        }
    }

    // Check password match
    function checkPasswordMatch() {
        const pwd = password.val();
        const confirm = confirmPassword.val();
        
        if (confirm.length === 0) {
            passwordMatch.html('');
            return true;
        }
        
        if (pwd === confirm) {
            passwordMatch.html('<i class="fas fa-check-circle"></i> Passwords match');
            passwordMatch.removeClass('password-match-error').addClass('password-match-success');
            return true;
        } else {
            passwordMatch.html('<i class="fas fa-times-circle"></i> Passwords do not match');
            passwordMatch.removeClass('password-match-success').addClass('password-match-error');
            return false;
        }
    }

    password.on('input', function() {
        checkPasswordStrength($(this).val());
        checkPasswordMatch();
    });

    confirmPassword.on('input', checkPasswordMatch);

    // Email validation with regex
    function validateEmail(email) {
        const re = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
        return re.test(email);
    }

    // Reset form
    function resetForm() {
        $('#firstname').val('');
        $('#lastname').val('');
        $('#emailaddress').val('');
        $('#password').val('');
        $('#confirm_password').val('');
        $('#status').val('active');
        $('#emailVerified').prop('checked', false);
        
        // Reset password strength
        passwordStrength.removeClass('weak fair good strong').addClass('');
        strengthText.text('Enter a password');
        passwordMatch.html('');
        
        // Remove any validation errors
        $('.is-invalid').removeClass('is-invalid');
        
        showToast('Form has been reset', 'success');
    }

    resetFormBtn.on('click', resetForm);

    // Validate form
    function validateForm() {
        let isValid = true;
        const errors = [];
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        
        // Validate first name
        const firstNameVal = firstname.val().trim();
        if (!firstNameVal) {
            errors.push('First name is required');
            firstname.addClass('is-invalid');
            isValid = false;
        } else if (firstNameVal.length < 2) {
            errors.push('First name must be at least 2 characters');
            firstname.addClass('is-invalid');
            isValid = false;
        }
        
        // Validate last name
        const lastNameVal = lastname.val().trim();
        if (!lastNameVal) {
            errors.push('Last name is required');
            lastname.addClass('is-invalid');
            isValid = false;
        } else if (lastNameVal.length < 2) {
            errors.push('Last name must be at least 2 characters');
            lastname.addClass('is-invalid');
            isValid = false;
        }
        
        // Validate email
        const emailVal = emailaddress.val().trim();
        if (!emailVal) {
            errors.push('Email address is required');
            emailaddress.addClass('is-invalid');
            isValid = false;
        } else if (!validateEmail(emailVal)) {
            errors.push('Please enter a valid email address');
            emailaddress.addClass('is-invalid');
            isValid = false;
        }
        
        // Validate password
        const pwdVal = password.val();
        if (!pwdVal) {
            errors.push('Password is required');
            password.addClass('is-invalid');
            isValid = false;
        } else if (pwdVal.length < 6) {
            errors.push('Password must be at least 6 characters');
            password.addClass('is-invalid');
            isValid = false;
        }
        
        // Validate confirm password
        const confirmVal = confirmPassword.val();
        if (!confirmVal) {
            errors.push('Please confirm your password');
            confirmPassword.addClass('is-invalid');
            isValid = false;
        } else if (pwdVal !== confirmVal) {
            errors.push('Passwords do not match');
            confirmPassword.addClass('is-invalid');
            isValid = false;
        }
        
        if (!isValid && errors.length > 0) {
            showToast(errors.join('\n'), 'error');
        }
        
        return isValid;
    }

    // Show toast message
    function showToast(message, type = 'info') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type === 'success' ? 'success' : type === 'error' ? 'error' : 'info',
                title: type === 'success' ? 'Success!' : type === 'error' ? 'Error' : 'Info',
                text: message,
                timer: 3000,
                showConfirmButton: true,
                confirmButtonColor: '#3D204E'
            });
        } else {
            alert(message);
        }
    }

    // Handle form submission
    addCustomerForm.on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        // Show loading state
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Adding Customer...');
        
        // Create FormData
        const formData = new FormData(this);
        
        // Make AJAX request
        $.ajax({
            url: '/admin/add-customer/store',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Customer has been added successfully.',
                        confirmButtonColor: '#3D204E'
                    }).then((result) => {
                        if (result.isConfirmed && response.redirect) {
                            window.location.href = response.redirect;
                        } else if (result.isConfirmed) {
                            resetForm();
                        }
                    });
                } else {
                    showToast(response.message || 'Failed to add customer. Please try again.', 'error');
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                
                let errorMessage = 'An error occurred. Please try again.';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) errorMessage = response.message;
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).join('<br>');
                    }
                } catch(e) {}
                
                showToast(errorMessage, 'error');
            }
        });
    });
});
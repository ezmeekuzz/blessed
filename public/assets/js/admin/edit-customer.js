/**
 * Edit Customer Page JavaScript
 * Handles form validation, password strength, and AJAX submission
 */

$(document).ready(function() {
    // DOM Elements
    const firstname = $('#firstname');
    const lastname = $('#lastname');
    const emailaddress = $('#emailaddress');
    const password = $('#password');
    const confirmPassword = $('#confirm_password');
    const submitBtn = $('#submitBtn');
    const editCustomerForm = $('#editCustomerForm');
    const customerId = $('#customerId').val();
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
        if (pwd.length === 0) {
            passwordStrength.hide();
            return 0;
        }
        
        passwordStrength.show();
        let strength = 0;
        
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
        
        if (confirm.length === 0 && pwd.length === 0) {
            passwordMatch.html('');
            return true;
        }
        
        if (pwd === confirm && pwd.length > 0) {
            passwordMatch.html('<i class="fas fa-check-circle"></i> Passwords match');
            passwordMatch.removeClass('password-match-error').addClass('password-match-success');
            return true;
        } else if (pwd !== confirm && confirm.length > 0) {
            passwordMatch.html('<i class="fas fa-times-circle"></i> Passwords do not match');
            passwordMatch.removeClass('password-match-success').addClass('password-match-error');
            return false;
        } else if (pwd.length === 0 && confirm.length > 0) {
            passwordMatch.html('<i class="fas fa-times-circle"></i> Please enter a password first');
            passwordMatch.removeClass('password-match-success').addClass('password-match-error');
            return false;
        } else {
            passwordMatch.html('');
            return true;
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
        
        // Validate password if provided
        const pwdVal = password.val();
        if (pwdVal) {
            if (pwdVal.length < 6) {
                errors.push('Password must be at least 6 characters');
                password.addClass('is-invalid');
                isValid = false;
            }
            
            // Validate confirm password
            const confirmVal = confirmPassword.val();
            if (!confirmVal) {
                errors.push('Please confirm your new password');
                confirmPassword.addClass('is-invalid');
                isValid = false;
            } else if (pwdVal !== confirmVal) {
                errors.push('Passwords do not match');
                confirmPassword.addClass('is-invalid');
                isValid = false;
            }
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
    editCustomerForm.on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        // Show loading state
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        
        // Create FormData
        const formData = new FormData(this);
        
        // Make AJAX request
        $.ajax({
            url: '/admin/edit-customer/update/' + customerId,
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
                        text: response.message || 'Customer has been updated successfully.',
                        confirmButtonColor: '#3D204E'
                    }).then((result) => {
                        if (result.isConfirmed && response.redirect) {
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    showToast(response.message || 'Failed to update customer. Please try again.', 'error');
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
// contact-us.js
$(document).ready(function() {
    // Contact form submission
    $('.contact-form').on('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = $('#name').val();
        const email = $('#email').val();
        const reason = $('#reason').val();
        const message = $('#message').val();
        
        // Validate
        if (!name) {
            showNotification('Please enter your name', 'error');
            return;
        }
        
        if (!email) {
            showNotification('Please enter your email address', 'error');
            return;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showNotification('Please enter a valid email address', 'error');
            return;
        }
        
        if (!reason || reason === 'Select a reason') {
            showNotification('Please select a reason for contacting us', 'error');
            return;
        }
        
        if (!message) {
            showNotification('Please enter your message', 'error');
            return;
        }
        
        if (message.length < 10) {
            showNotification('Message must be at least 10 characters', 'error');
            return;
        }
        
        // Disable submit button
        const $submitBtn = $('.contact-form button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        // Send AJAX request
        $.ajax({
            url: '/contact/submit',
            method: 'POST',
            data: {
                name: name,
                email: email,
                reason: reason,
                message: message
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    // Reset form
                    $('#name').val('');
                    $('#email').val('');
                    $('#reason').val('Select a reason');
                    $('#message').val('');
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                let errorMsg = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification(errorMsg, 'error');
            },
            complete: function() {
                $submitBtn.prop('disabled', false).html('Submit');
            }
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        // Remove existing toast
        if ($('.notification-toast').length) {
            $('.notification-toast').remove();
        }
        
        const toast = $('<div class="notification-toast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 250px; padding: 15px 20px; border-radius: 10px; color: white; font-weight: 500; display: none;"></div>');
        const bgColor = type === 'success' ? '#28a745' : '#dc3545';
        toast.css('background', bgColor);
        toast.text(message);
        $('body').append(toast);
        toast.fadeIn(300);
        
        setTimeout(function() {
            toast.fadeOut(300, function() {
                toast.remove();
            });
        }, 5000);
    }
});
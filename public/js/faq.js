// faq.js
$(document).ready(function() {
    // Read More button functionality
    $('#readMoreBtn').on('click', function() {
        $('#moreFaqs').slideDown(300, function() {
            // Smooth scroll to the first newly revealed FAQ
            $('html, body').animate({
                scrollTop: $('#moreFaqs').offset().top - 100
            }, 500);
        });
        
        // Hide the read more button with fade effect
        $(this).fadeOut(300);
    });
    
    // Accordion icon toggle
    $('.accordion-button').on('click', function() {
        const icon = $(this).find('.accordion-icon');
        const isExpanded = $(this).attr('aria-expanded') === 'true';
        
        if (isExpanded) {
            icon.removeClass('fa-plus').addClass('fa-minus');
        } else {
            // Reset all icons in the same accordion
            $(this).closest('.accordion').find('.accordion-button .accordion-icon')
                .removeClass('fa-minus').addClass('fa-plus');
            icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
    
    // Contact form submission
    $('#contactForm').on('submit', function(e) {
        e.preventDefault();
        
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
        
        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
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
                $submitBtn.prop('disabled', false).html('Send Message');
            }
        });
    });
    
    // Helper function
    function showNotification(message, type) {
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
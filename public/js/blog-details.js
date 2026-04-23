// blog-details.js - Update only the newsletter subscription part

$(document).ready(function() {
    const postId = $('#post-id').data('post-id');
    const postTitle = $('h1.display-4').first().text();
    const postUrl = window.location.href;
    
    // Mark article as read when page loads
    if (postId) {
        markArticleAsRead(postId);
    }
    
    // Share functionality
    function initShareButtons() {
        const shareUrls = {
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`,
            twitter: `https://twitter.com/intent/tweet?text=${encodeURIComponent(postTitle)}&url=${encodeURIComponent(postUrl)}`,
            linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(postUrl)}&title=${encodeURIComponent(postTitle)}`,
            email: `mailto:?subject=${encodeURIComponent(postTitle)}&body=${encodeURIComponent(`Check out this article: ${postUrl}`)}`
        };
        
        $('.share-facebook, .share-facebook-footer').on('click', function(e) {
            e.preventDefault();
            window.open(shareUrls.facebook, '_blank', 'width=600,height=400');
        });
        
        $('.share-twitter, .share-twitter-footer').on('click', function(e) {
            e.preventDefault();
            window.open(shareUrls.twitter, '_blank', 'width=600,height=400');
        });
        
        $('.share-linkedin, .share-linkedin-footer').on('click', function(e) {
            e.preventDefault();
            window.open(shareUrls.linkedin, '_blank', 'width=600,height=400');
        });
        
        $('.share-email, .share-email-footer').on('click', function(e) {
            e.preventDefault();
            window.location.href = shareUrls.email;
        });
    }
    
    initShareButtons();
    
    // Newsletter subscription - FIXED VERSION
    $('.subscribe-newsletter-btn').on('click', function() {
        const email = $('#newsletterEmail').val();
        const $btn = $(this);
        
        // Validate email
        if (!email) {
            showNotification('Please enter your email address', 'error');
            return;
        }
        
        if (!isValidEmail(email)) {
            showNotification('Please enter a valid email address', 'error');
            return;
        }
        
        // Disable button and show loading
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Subscribing...');
        
        $.ajax({
            url: '/newsletter/subscribe',
            method: 'POST',
            data: { email: email },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.message, 'success');
                    $('#newsletterEmail').val('');
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
                $btn.prop('disabled', false).html('Subscribe');
            }
        });
    });
    
    // Helper Functions
    function markArticleAsRead(postId) {
        let readArticles = getReadArticles();
        if (!readArticles.includes(postId.toString())) {
            readArticles.push(postId.toString());
            setCookie('read_articles', JSON.stringify(readArticles), 365);
        }
    }
    
    function getReadArticles() {
        const readArticlesCookie = getCookie('read_articles');
        if (readArticlesCookie) {
            try {
                return JSON.parse(readArticlesCookie);
            } catch(e) {
                return [];
            }
        }
        return [];
    }
    
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
    }
    
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) {
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        return null;
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function showNotification(message, type) {
        // Remove existing toast if any
        if ($('.notification-toast').length) {
            $('.notification-toast').remove();
        }
        
        // Create notification element
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
        }, 3000);
    }
});
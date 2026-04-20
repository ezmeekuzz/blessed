$(document).ready(function() {
    // Update color preview dynamically
    function updateColorPreview(colorInput, previewElement) {
        $(colorInput).on('input', function() {
            var color = $(this).val();
            // Validate hex color
            if (/^#[0-9A-F]{6}$/i.test(color)) {
                $(previewElement).css('background-color', color);
            }
        });
    }
    
    updateColorPreview('#primary_color', '#primary_color_preview');
    updateColorPreview('#secondary_color', '#secondary_color_preview');
    
    // Toggle SMTP fields
    function toggleSmtpFields() {
        if ($('#use_smtp').is(':checked')) {
            $('.smtp_field').slideDown(300);
        } else {
            $('.smtp_field').slideUp(300);
        }
    }
    
    $('#use_smtp').on('change', function() {
        toggleSmtpFields();
    });
    
    // Initialize SMTP fields on page load
    toggleSmtpFields();
    
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        var label = $(this).next('.custom-file-label');
        
        if (fileName) {
            label.html(fileName);
        } else {
            label.html('Choose file');
        }
    });
    
    // Reset form to original values
    $('#resetSettingsBtn').on('click', function() {
        if (confirm('Are you sure you want to reset all changes? Unsaved changes will be lost.')) {
            // Reload the page to reset to saved values
            location.reload();
        }
    });
    
    // Form submission with loading state and validation
    $('#settingsForm').on('submit', function(e) {
        var btn = $('#saveSettingsBtn');
        var originalHtml = btn.html();
        
        // Basic client-side validation
        var siteName = $('#site_name').val().trim();
        if (siteName === '') {
            e.preventDefault();
            showErrorAlert('Site Name is required.');
            return false;
        }
        
        // Validate color formats
        var primaryColor = $('#primary_color').val();
        var secondaryColor = $('#secondary_color').val();
        
        var colorRegex = /^#[0-9A-F]{6}$/i;
        if (primaryColor && !colorRegex.test(primaryColor)) {
            e.preventDefault();
            showErrorAlert('Please enter a valid hex color for Primary Color (e.g., #4e73df)');
            return false;
        }
        
        if (secondaryColor && !colorRegex.test(secondaryColor)) {
            e.preventDefault();
            showErrorAlert('Please enter a valid hex color for Secondary Color (e.g., #1cc88a)');
            return false;
        }
        
        // Validate email fields
        var adminEmail = $('#admin_email').val();
        var emailFrom = $('#email_from').val();
        
        var emailRegex = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
        if (adminEmail && !emailRegex.test(adminEmail)) {
            e.preventDefault();
            showErrorAlert('Please enter a valid Admin Email address.');
            return false;
        }
        
        if (emailFrom && !emailRegex.test(emailFrom)) {
            e.preventDefault();
            showErrorAlert('Please enter a valid Email From address.');
            return false;
        }
        
        // Show loading state
        btn.html('<i class="ti ti-loader ti-spin"></i> Saving...').prop('disabled', true);
        
        // Allow form to submit normally
        // If there's an error, the button will be re-enabled after page reload
        setTimeout(function() {
            btn.html(originalHtml).prop('disabled', false);
        }, 5000);
    });
    
    // Helper function to show error alert
    function showErrorAlert(message) {
        // Check if alert container exists, if not create one
        if ($('.alert-danger').length === 0) {
            var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                '<i class="ti ti-alert-circle"></i> ' + message +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button></div>';
            $('.container-fluid').find('.row:first').before(alertHtml);
        } else {
            $('.alert-danger').html('<i class="ti ti-alert-circle"></i> ' + message +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span></button>');
        }
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert-danger').alert('close');
        }, 5000);
    }
    
    // Log settings changes for debugging (optional)
    $('#settingsForm').on('change', 'input, select, textarea', function() {
        console.log('Changed:', $(this).attr('name'), '=', $(this).val());
    });
});
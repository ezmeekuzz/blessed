$(document).ready(function() {
    // Toggle file upload / external link sections based on source type
    $('#sourceType').on('change', function() {
        let sourceType = $(this).val();
        
        if (sourceType === 'local') {
            $('#fileUploadSection').show();
            $('#externalLinkSection').hide();
            $('#fontLink').prop('required', false);
            $('#fontFile').prop('required', true);
        } else if (sourceType === 'external') {
            $('#fileUploadSection').hide();
            $('#externalLinkSection').show();
            $('#fontFile').prop('required', false);
            $('#fontLink').prop('required', true);
        } else {
            $('#fileUploadSection').hide();
            $('#externalLinkSection').hide();
            $('#fontFile').prop('required', false);
            $('#fontLink').prop('required', false);
        }
    });

    // Custom file input label update
    $('#fontFile').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file');
        
        if (fileName) {
            $('#fileName').text(fileName);
            $('#fontFilePreview').show();
            
            // For local font files, create a temporary preview
            let file = this.files[0];
            if (file) {
                let fontUrl = URL.createObjectURL(file);
                let fontName = $('#fontName').val() || 'CustomFont';
                loadCustomFontPreview(fontName, fontUrl);
            }
        } else {
            $('#fontFilePreview').hide();
        }
    });

    // Handle Google Font external link
    $('#fontLink').on('change blur', function() {
        let url = $(this).val();
        if (url && url.includes('fonts.googleapis.com')) {
            loadGoogleFontPreview(url);
        }
    });

    // Live preview when font name changes (for local fonts)
    $('#fontName').on('keyup', function() {
        let fontName = $(this).val();
        if (fontName && $('#sourceType').val() === 'local' && $('#fontFile').val()) {
            $('#fontPreview').css('font-family', `'${fontName}', sans-serif`);
        }
    });

    // Update preview when preview text or size changes
    $('#previewText').on('keyup', function() {
        $('#fontPreview').text($(this).val());
    });

    $('#previewSize').on('input', function() {
        let size = $(this).val();
        $('#fontPreview').css('font-size', size + 'px');
    });

    // Handle form submission
    $('#addFontForm').on('submit', function(e) {
        e.preventDefault();

        // Validate required fields
        let fontName = $('#fontName').val().trim();
        let sourceType = $('#sourceType').val();

        if (!fontName) {
            showError('Please enter a font name.');
            return;
        }
        if (!sourceType) {
            showError('Please select a source type.');
            return;
        }

        if (sourceType === 'local') {
            let fontFile = $('#fontFile').val();
            if (!fontFile) {
                showError('Please select a font file to upload.');
                return;
            }
        } else if (sourceType === 'external') {
            let fontLink = $('#fontLink').val().trim();
            if (!fontLink) {
                showError('Please enter a font link/URL.');
                return;
            }
        }

        // Show loading state
        let submitBtn = $('#submitBtn');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');

        // Create FormData object for file upload
        let formData = new FormData(this);

        // Make AJAX request
        $.ajax({
            url: '/admin/addfont/insert',
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
                        text: response.message || 'Font has been added successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || 'admin/font-masterlist';
                    });
                } else {
                    showError(response.message || 'Failed to add font. Please try again.');
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                
                let errorMessage = 'An error occurred. Please try again.';
                try {
                    let response = JSON.parse(xhr.responseText);
                    if (response.message) errorMessage = response.message;
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).join('<br>');
                    }
                } catch(e) {}
                
                showError(errorMessage);
            }
        });
    });

    // Load Google Font preview
    function loadGoogleFontPreview(url) {
        // Extract font family from URL
        let match = url.match(/family=([^:&]+)/);
        if (match) {
            let fontFamily = match[1].replace(/\+/g, ' ');
            let linkId = 'google-font-preview-' + Date.now();
            
            // Remove existing Google Font links
            $('link[id^="google-font-preview-"]').remove();
            
            // Add new link
            $('head').append(`<link id="${linkId}" href="${url}" rel="stylesheet">`);
            
            // Update preview
            setTimeout(function() {
                $('#fontPreview').css('font-family', `'${fontFamily}', sans-serif`);
                $('#googleFontPreview').show();
                
                // Auto-hide after 3 seconds
                setTimeout(function() {
                    $('#googleFontPreview').fadeOut();
                }, 3000);
            }, 500);
        }
    }

    // Load custom font preview for local files
    function loadCustomFontPreview(fontName, fontUrl) {
        let styleId = 'custom-font-preview-' + Date.now();
        
        // Remove existing custom font styles
        $('style[id^="custom-font-preview-"]').remove();
        
        let style = `
            @font-face {
                font-family: '${fontName}';
                src: url('${fontUrl}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }
        `;
        $('head').append(`<style id="${styleId}">${style}</style>`);
        
        setTimeout(function() {
            $('#fontPreview').css('font-family', `'${fontName}', sans-serif`);
        }, 100);
    }

    // Show error message
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: message,
            confirmButtonColor: '#dc3545'
        });
    }

    // Initialize
    $('#sourceType').trigger('change');
});
let baseUrl = "<?= base_url(); ?>";

$(document).ready(function() {
    let originalData = {
        font_name: $('#fontName').val(),
        source_type: $('#sourceType').val(),
        font_link: $('#fontLink').val(),
        status: $('#status').val(),
        is_featured: $('#isFeatured').is(':checked')
    };
    
    // Toggle file upload / external link sections based on source type
    $('#sourceType').on('change', function() {
        let sourceType = $(this).val();
        
        if (sourceType === 'local') {
            $('#fileUploadSection').show();
            $('#externalLinkSection').hide();
            $('#fontLink').prop('required', false);
        } else if (sourceType === 'external') {
            $('#fileUploadSection').hide();
            $('#externalLinkSection').show();
            $('#fontLink').prop('required', true);
        } else {
            $('#fileUploadSection').hide();
            $('#externalLinkSection').hide();
            $('#fontLink').prop('required', false);
        }
    });

    // Custom file input label update
    $('#fontFile').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose new file (leave empty to keep current)');
        
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

    // Remove existing file
    $(document).on('click', '.remove-existing-file', function() {
        let filePath = $(this).data('path');
        
        Swal.fire({
            title: 'Remove File?',
            text: 'Are you sure you want to remove the current font file?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#removeFile').val(1);
                $(this).closest('.existing-file').fadeOut();
                
                Swal.fire({
                    icon: 'success',
                    title: 'File will be removed',
                    text: 'The file will be deleted when you save the font.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Handle Google Font external link
    $('#fontLink').on('change blur', function() {
        let url = $(this).val();
        if (url && url.includes('fonts.googleapis.com')) {
            loadGoogleFontPreview(url);
        }
    });

    // Live preview when font name changes
    $('#fontName').on('keyup', function() {
        let fontName = $(this).val();
        if (fontName) {
            $('#fontPreview').css('font-family', `'${fontName}', sans-serif`);
            
            // If source type is local and a file is selected, also update preview
            if ($('#sourceType').val() === 'local' && $('#fontFile').val()) {
                let file = $('#fontFile')[0].files[0];
                if (file) {
                    let fontUrl = URL.createObjectURL(file);
                    loadCustomFontPreview(fontName, fontUrl);
                }
            }
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

    // Reset form
    $('#resetFormBtn').on('click', function() {
        Swal.fire({
            title: 'Reset Form?',
            text: 'Are you sure you want to reset all changes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#fontName').val(originalData.font_name);
                $('#sourceType').val(originalData.source_type).trigger('change');
                $('#fontLink').val(originalData.font_link);
                $('#status').val(originalData.status);
                $('#isFeatured').prop('checked', originalData.is_featured);
                $('#fontFile').val('');
                $('#fontFilePreview').hide();
                $('#removeFile').val(0);
                $('.existing-file').show();
                $('.custom-file-label').html('Choose new file (leave empty to keep current)');
                
                // Reset preview
                $('#fontPreview').css('font-family', `'${originalData.font_name}', sans-serif`);
                $('#previewText').val('The quick brown fox jumps over the lazy dog');
                $('#previewSize').val(24);
                $('#fontPreview').css('font-size', '24px');
                $('#fontPreview').text('The quick brown fox jumps over the lazy dog');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Reset Complete',
                    text: 'Form has been reset to original values.',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // Handle form submission
    $('#submitFontBtn').on('click', function(e) {
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

        if (sourceType === 'external') {
            let fontLink = $('#fontLink').val().trim();
            if (!fontLink) {
                showError('Please enter a font link/URL.');
                return;
            }
        }

        // Show loading state
        let submitBtn = $('#submitFontBtn');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        // Create FormData object for file upload
        let formData = new FormData($('#fontForm')[0]);

        // Make AJAX request
        $.ajax({
            url: '/admin/editfont/update/' + $('#fontId').val(),
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
                        text: response.message || 'Font has been updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || baseUrl + 'admin/font-masterlist';
                    });
                } else {
                    showError(response.message || 'Failed to update font. Please try again.');
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

    // Initialize preview with current font
    if ($('#sourceType').val() === 'external' && $('#fontLink').val()) {
        loadGoogleFontPreview($('#fontLink').val());
    } else if ($('#sourceType').val() === 'local' && $('#fontFile').val()) {
        // Preview will be handled by existing font from server
        let fontName = $('#fontName').val();
        $('#fontPreview').css('font-family', `'${fontName}', sans-serif`);
    }
    
    // Trigger source type change to show correct section
    $('#sourceType').trigger('change');
});
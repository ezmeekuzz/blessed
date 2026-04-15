/**
 * Edit Clip Art Page JavaScript
 * Handles form validation, image preview, and AJAX submission
 */

$(document).ready(function() {
    // DOM Elements
    const sourceTypeBtns = $('.source-type-btn');
    const sourceTypeInput = $('#sourceType');
    const localUploadSection = $('#localUploadSection');
    const externalUrlSection = $('#externalUrlSection');
    const clipartImage = $('#clipartImage');
    const imageUrl = $('#imageUrl');
    const localImagePreview = $('#localImagePreview');
    const externalImagePreview = $('#externalImagePreview');
    const removeLocalPreviewBtn = $('#removeLocalPreviewBtn');
    const removeExternalPreviewBtn = $('#removeExternalPreviewBtn');
    const submitBtn = $('#submitBtn');
    const editClipArtForm = $('#editClipArtForm');
    const clipArtId = $('#clipArtId').val();

    // Toggle between local and external source
    function setImageSource(source) {
        if (source === 'local') {
            localUploadSection.show();
            externalUrlSection.hide();
            sourceTypeInput.val('local');
            clipartImage.prop('required', false); // Not required since we can keep existing
            imageUrl.prop('required', false);
            
            // Update button styles
            sourceTypeBtns.removeClass('active');
            $('[data-source="local"]').addClass('active');
        } else {
            localUploadSection.hide();
            externalUrlSection.show();
            sourceTypeInput.val('external');
            clipartImage.prop('required', false);
            imageUrl.prop('required', true);
            
            // Update button styles
            sourceTypeBtns.removeClass('active');
            $('[data-source="external"]').addClass('active');
        }
    }

    // Handle source type button clicks
    sourceTypeBtns.on('click', function() {
        const source = $(this).data('source');
        setImageSource(source);
    });

    // Update custom file input label
    clipartImage.on('change', function() {
        const fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Choose file');
        
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            // Check file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                showToast('File size must not exceed 5MB', 'error');
                $(this).val('');
                $(this).next('.custom-file-label').html('Choose file');
                localImagePreview.hide();
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                localImagePreview.find('img').attr('src', e.target.result);
                localImagePreview.show();
            };
            reader.readAsDataURL(file);
        } else if (file) {
            showToast('Please select a valid image file (JPG, PNG, GIF, WEBP, SVG)', 'error');
            $(this).val('');
            $(this).next('.custom-file-label').html('Choose file');
            localImagePreview.hide();
        } else {
            localImagePreview.hide();
        }
    });

    // Preview external URL image
    let previewTimeout;
    imageUrl.on('input', function() {
        clearTimeout(previewTimeout);
        const url = $(this).val().trim();
        
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            previewTimeout = setTimeout(function() {
                // Test if image loads
                const img = new Image();
                img.onload = function() {
                    externalImagePreview.find('img').attr('src', url);
                    externalImagePreview.show();
                };
                img.onerror = function() {
                    externalImagePreview.hide();
                    if (url) {
                        showToast('Invalid image URL. Please check the link.', 'warning');
                    }
                };
                img.src = url;
            }, 500);
        } else if (url) {
            externalImagePreview.hide();
            if (url && !url.startsWith('http')) {
                showToast('Please enter a valid URL starting with http:// or https://', 'warning');
            }
        } else {
            externalImagePreview.hide();
        }
    });

    // Remove local image preview
    removeLocalPreviewBtn.on('click', function() {
        clipartImage.val('');
        $(clipartImage).next('.custom-file-label').html('Choose file');
        localImagePreview.hide();
        localImagePreview.find('img').attr('src', '');
    });

    // Remove external image preview
    removeExternalPreviewBtn.on('click', function() {
        imageUrl.val('');
        externalImagePreview.hide();
        externalImagePreview.find('img').attr('src', '');
    });

    // Validate form
    function validateForm() {
        let isValid = true;
        const errors = [];
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        
        // Validate title
        const title = $('#title').val().trim();
        if (!title) {
            errors.push('Title is required');
            $('#title').addClass('is-invalid');
            isValid = false;
        } else if (title.length < 3) {
            errors.push('Title must be at least 3 characters');
            $('#title').addClass('is-invalid');
            isValid = false;
        }
        
        // Get source type
        const selectedSourceType = sourceTypeInput.val();
        
        // Validate based on source type
        if (selectedSourceType === 'external') {
            const url = imageUrl.val().trim();
            if (!url) {
                errors.push('Please enter an image URL');
                imageUrl.addClass('is-invalid');
                isValid = false;
            } else if (!url.startsWith('http://') && !url.startsWith('https://')) {
                errors.push('Please enter a valid URL starting with http:// or https://');
                imageUrl.addClass('is-invalid');
                isValid = false;
            }
        }
        // For local, no validation needed since we can keep existing image
        
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
    editClipArtForm.on('submit', function(e) {
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
            url: '/admin/edit-clipart/update/' + clipArtId,
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
                        text: response.message || 'Clip art has been updated successfully.',
                        confirmButtonColor: '#3D204E'
                    }).then((result) => {
                        if (result.isConfirmed && response.redirect) {
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    showToast(response.message || 'Failed to update clip art. Please try again.', 'error');
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

    // Initialize - set correct source type based on current image
    const currentSourceType = sourceTypeInput.val();
    setImageSource(currentSourceType);
    
    // If external, show preview
    if (currentSourceType === 'external') {
        const currentUrl = imageUrl.val();
        if (currentUrl) {
            externalImagePreview.show();
        }
    }
});
/**
 * Add Sticker Page JavaScript
 * Handles form validation, image preview, and AJAX submission
 */

$(document).ready(function() {
    // DOM Elements
    const sourceTypeBtns = $('.source-type-btn');
    const sourceTypeInput = $('#sourceType');
    const localUploadSection = $('#localUploadSection');
    const externalUrlSection = $('#externalUrlSection');
    const stickerImage = $('#stickerImage');
    const imageUrl = $('#imageUrl');
    const localImagePreview = $('#localImagePreview');
    const externalImagePreview = $('#externalImagePreview');
    const removeLocalPreviewBtn = $('#removeLocalPreviewBtn');
    const removeExternalPreviewBtn = $('#removeExternalPreviewBtn');
    const resetFormBtn = $('#resetFormBtn');
    const submitBtn = $('#submitBtn');
    const addStickerForm = $('#addStickerForm');

    // Toggle between local and external source
    function setImageSource(source) {
        if (source === 'local') {
            localUploadSection.show();
            externalUrlSection.hide();
            sourceTypeInput.val('local');
            stickerImage.prop('required', true);
            imageUrl.prop('required', false);
            imageUrl.val('');
            externalImagePreview.hide();
            
            // Update button styles
            sourceTypeBtns.removeClass('active');
            $('[data-source="local"]').addClass('active');
        } else {
            localUploadSection.hide();
            externalUrlSection.show();
            sourceTypeInput.val('external');
            stickerImage.prop('required', false);
            imageUrl.prop('required', true);
            stickerImage.val('');
            $('.custom-file-label').text('Choose file');
            localImagePreview.hide();
            
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
    stickerImage.on('change', function() {
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
        stickerImage.val('');
        $(stickerImage).next('.custom-file-label').html('Choose file');
        localImagePreview.hide();
        localImagePreview.find('img').attr('src', '');
    });

    // Remove external image preview
    removeExternalPreviewBtn.on('click', function() {
        imageUrl.val('');
        externalImagePreview.hide();
        externalImagePreview.find('img').attr('src', '');
    });

    // Reset form
    function resetForm() {
        // Reset basic fields
        $('#title').val('');
        $('#description').val('');
        $('#tags').val('');
        $('#status').val('active');
        
        // Reset to local upload by default
        setImageSource('local');
        
        // Reset file upload
        stickerImage.val('');
        $('.custom-file-label').text('Choose file');
        localImagePreview.hide();
        localImagePreview.find('img').attr('src', '');
        
        // Reset external URL
        imageUrl.val('');
        externalImagePreview.hide();
        externalImagePreview.find('img').attr('src', '');
        
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
        if (selectedSourceType === 'local') {
            const file = stickerImage[0].files[0];
            if (!file) {
                errors.push('Please select an image file to upload');
                stickerImage.addClass('is-invalid');
                isValid = false;
            } else if (!file.type.startsWith('image/')) {
                errors.push('Please select a valid image file');
                stickerImage.addClass('is-invalid');
                isValid = false;
            } else if (file.size > 5 * 1024 * 1024) {
                errors.push('File size must not exceed 5MB');
                stickerImage.addClass('is-invalid');
                isValid = false;
            }
        } else if (selectedSourceType === 'external') {
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
        } else {
            errors.push('Please select an image source');
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
    addStickerForm.on('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            return;
        }
        
        // Show loading state
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        // Create FormData
        const formData = new FormData(this);
        
        // Make AJAX request
        $.ajax({
            url: '/admin/add-sticker/store',
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
                        text: response.message || 'Sticker has been added successfully.',
                        confirmButtonColor: '#3D204E'
                    }).then((result) => {
                        if (result.isConfirmed && response.redirect) {
                            window.location.href = response.redirect;
                        } else if (result.isConfirmed) {
                            resetForm();
                        }
                    });
                } else {
                    showToast(response.message || 'Failed to add sticker. Please try again.', 'error');
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

    // Initialize with local upload as default
    setImageSource('local');
});
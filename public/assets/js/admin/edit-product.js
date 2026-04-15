/**
 * Edit Product Page JavaScript
 * Handles all UI interactions with drag-and-drop file upload
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        const productName = document.getElementById('productName');
        const productSlug = document.getElementById('productSlug');
        const resetFormBtn = document.getElementById('resetFormBtn');
        const submitProductBtn = document.getElementById('submitProductBtn');
        const addSizeBtn = document.getElementById('addSizeBtn');
        const addColorBtn = document.getElementById('addColorBtn');
        const sizesTableBody = document.getElementById('sizesTableBody');
        const colorsContainer = document.getElementById('colorsContainer');
        const productImagesInput = document.getElementById('productImages');
        const deletedImagesInput = document.getElementById('deletedImages');
        
        const uploadArea = document.getElementById('productImageUploadArea');
        const fileSelectBtn = document.getElementById('productImageSelectBtn');
        const imageList = document.getElementById('productImageList');

        let sizeCounter = document.querySelectorAll('.size-row').length;
        let colorCounter = document.querySelectorAll('.color-card').length;
        let selectedFiles = [];
        let isSlugManuallyEdited = false;
        let deletedImages = [];

        function generateSlug(text) {
            if (!text) return '';
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        function updateSlug() {
            if (!isSlugManuallyEdited && productName) {
                const name = productName.value.trim();
                productSlug.value = name ? generateSlug(name) : '';
            }
        }

        function onSlugManuallyEdited() {
            isSlugManuallyEdited = true;
        }

        function showToast(message, type = 'info') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'Success!' : type === 'error' ? 'Error' : 'Info',
                    text: message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }

        function updateDefaultColorHighlight() {
            const allColorCards = colorsContainer.querySelectorAll('.color-card');
            allColorCards.forEach(card => {
                const radio = card.querySelector('.default-color-radio');
                if (radio && radio.checked) {
                    card.classList.add('selected-default');
                } else {
                    card.classList.remove('selected-default');
                }
            });
        }

        function updateDefaultSizeHighlight() {
            const allSizeRows = sizesTableBody.querySelectorAll('.size-row');
            allSizeRows.forEach(row => {
                const radio = row.querySelector('.default-size-radio');
                if (radio && radio.checked) {
                    row.style.backgroundColor = '#f8fff8';
                } else {
                    row.style.backgroundColor = '';
                }
            });
        }

        function setupColorRadioDelegation() {
            colorsContainer.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('default-color-radio') && e.target.checked) {
                    const allRadios = colorsContainer.querySelectorAll('.default-color-radio');
                    allRadios.forEach(radio => {
                        if (radio !== e.target) radio.checked = false;
                    });
                    updateDefaultColorHighlight();
                }
            });
        }

        function setupSizeRadioDelegation() {
            sizesTableBody.addEventListener('change', function(e) {
                if (e.target && e.target.classList.contains('default-size-radio') && e.target.checked) {
                    const allRadios = sizesTableBody.querySelectorAll('.default-size-radio');
                    allRadios.forEach(radio => {
                        if (radio !== e.target) radio.checked = false;
                    });
                    updateDefaultSizeHighlight();
                }
            });
        }

        function validateForm() {
            let isValid = true;
            const errors = [];

            if (!productName.value.trim()) {
                errors.push('Product name is required');
                productName.classList.add('error');
                isValid = false;
            } else {
                productName.classList.remove('error');
            }

            const categorySelect = document.getElementById('productCategory');
            if (!categorySelect.value) {
                errors.push('Please select a category');
                categorySelect.classList.add('error');
                isValid = false;
            } else {
                categorySelect.classList.remove('error');
            }

            const sizeRows = sizesTableBody.querySelectorAll('.size-row');
            let hasValidSize = false;
            sizeRows.forEach(row => {
                const sizeName = row.querySelector('.size-name').value.trim();
                const price = row.querySelector('.size-price').value;
                if (sizeName && price && parseFloat(price) > 0) hasValidSize = true;
            });
            if (!hasValidSize) {
                errors.push('At least one size with valid name and price is required');
                isValid = false;
            }

            const colorCards = colorsContainer.querySelectorAll('.color-card');
            if (colorCards.length === 0) {
                errors.push('At least one color variant is required');
                isValid = false;
            }

            if (!isValid) showToast(errors.join('\n'), 'error');
            return isValid;
        }

        function handleFiles(files) {
            if (!imageList) return;
            
            imageList.innerHTML = '';
            selectedFiles = Array.from(files);
            
            if (selectedFiles.length > 10) {
                showToast('Maximum 10 images allowed', 'warning');
                selectedFiles = selectedFiles.slice(0, 10);
            }
            
            selectedFiles.forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;
                
                const fileWrapper = document.createElement('div');
                fileWrapper.className = 'image-wrapper';
                fileWrapper.setAttribute('data-index', index);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    fileWrapper.appendChild(img);

                    const deleteBtn = document.createElement('span');
                    deleteBtn.className = 'delete-btn-preview';
                    deleteBtn.innerHTML = '&times;';
                    deleteBtn.onclick = function(e) {
                        e.stopPropagation();
                        selectedFiles.splice(index, 1);
                        handleFiles(selectedFiles);
                    };
                    fileWrapper.appendChild(deleteBtn);
                    imageList.appendChild(fileWrapper);
                };
                reader.readAsDataURL(file);
            });
            
            if (productImagesInput) {
                productImagesInput.value = JSON.stringify(selectedFiles.map(f => f.name));
            }
        }

        // Setup Drag & Drop
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('drag-over');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
                const files = e.dataTransfer.files;
                if (files && files.length > 0) {
                    const validFiles = Array.from(files).filter(f => f.type.startsWith('image/'));
                    if (validFiles.length > 0) {
                        const allFiles = [...selectedFiles, ...validFiles].slice(0, 10);
                        handleFiles(allFiles);
                    } else {
                        showToast('Only image files are allowed', 'warning');
                    }
                }
            });
        }

        if (fileSelectBtn) {
            fileSelectBtn.addEventListener('click', function() {
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.multiple = true;
                fileInput.accept = 'image/*';
                fileInput.style.display = 'none';
                
                fileInput.addEventListener('change', function() {
                    if (fileInput.files && fileInput.files.length > 0) {
                        const validFiles = Array.from(fileInput.files).filter(f => f.type.startsWith('image/'));
                        if (validFiles.length > 0) {
                            const allFiles = [...selectedFiles, ...validFiles].slice(0, 10);
                            handleFiles(allFiles);
                        }
                        if (validFiles.length !== fileInput.files.length) {
                            showToast('Only image files are allowed', 'warning');
                        }
                    }
                });
                
                fileInput.click();
            });
        }

        // Remove existing image
        $(document).on('click', '.remove-existing-image', function() {
            const imageId = $(this).data('image-id');
            const container = $(this).closest('.existing-image-item');
            
            deletedImages.push(imageId);
            deletedImagesInput.value = deletedImages.join(',');
            container.remove();
            
            showToast('Image marked for deletion', 'info');
        });

        // Remove existing color image
        $(document).on('click', '.remove-existing-color-image', function() {
            const type = $(this).data('type');
            const container = $(this).closest('.existing-image-preview');
            const colorCard = $(this).closest('.color-card');
            
            // Mark the image for deletion by setting a flag
            if (type === 'front') {
                colorCard.find('input[name$="[existing_front_image]"]').val('');
            } else {
                colorCard.find('input[name$="[existing_back_image]"]').val('');
            }
            container.remove();
            
            showToast('Image marked for deletion', 'info');
        });

        function addSizeRow() {
            const template = document.getElementById('sizeRowTemplate');
            const newRowHtml = template.innerHTML.replace(/__index__/g, sizeCounter);
            const tempDiv = document.createElement('tbody');
            tempDiv.innerHTML = newRowHtml;
            const newRow = tempDiv.firstElementChild;
            
            const allRemoveBtns = sizesTableBody.querySelectorAll('.remove-size-btn');
            allRemoveBtns.forEach(btn => btn.disabled = false);
            
            sizesTableBody.appendChild(newRow);
            attachSizeRowEvents(newRow);
            sizeCounter++;
        }

        function attachSizeRowEvents(row) {
            const removeBtn = row.querySelector('.remove-size-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    if (sizesTableBody.querySelectorAll('.size-row').length > 1) {
                        row.remove();
                        const remainingRows = sizesTableBody.querySelectorAll('.size-row');
                        let hasDefault = false;
                        remainingRows.forEach(r => {
                            const radio = r.querySelector('.default-size-radio');
                            if (radio && radio.checked) hasDefault = true;
                        });
                        if (!hasDefault && remainingRows.length > 0) {
                            const firstRadio = remainingRows[0].querySelector('.default-size-radio');
                            if (firstRadio) firstRadio.checked = true;
                        }
                        if (remainingRows.length === 1) {
                            const lastRemoveBtn = remainingRows[0].querySelector('.remove-size-btn');
                            if (lastRemoveBtn) lastRemoveBtn.disabled = true;
                        }
                        updateDefaultSizeHighlight();
                    } else {
                        showToast('At least one size is required', 'warning');
                    }
                });
            }
        }

        function addColorRow() {
            const template = document.getElementById('colorCardTemplate');
            const newColorHtml = template.innerHTML.replace(/__index__/g, colorCounter);
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newColorHtml;
            const newColorCard = tempDiv.firstElementChild;
            
            const allRemoveBtns = colorsContainer.querySelectorAll('.remove-color-btn');
            allRemoveBtns.forEach(btn => btn.disabled = false);
            
            colorsContainer.appendChild(newColorCard);
            attachColorCardEvents(newColorCard);
            colorCounter++;
            updateDefaultColorHighlight();
        }

        function attachColorCardEvents(card) {
            const hexPicker = card.querySelector('.color-hex-picker');
            const hexText = card.querySelector('.color-hex-text');
            if (hexPicker && hexText) {
                hexPicker.addEventListener('input', function() { hexText.value = this.value; });
                hexText.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) hexPicker.value = this.value;
                });
            }
            
            const fileInputs = card.querySelectorAll('.color-image-input');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const target = this.getAttribute('data-target');
                    const file = this.files[0];
                    if (file) {
                        this.fileObject = file;
                        
                        const label = this.nextElementSibling;
                        if (label) label.textContent = file.name;
                        
                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            const previewDiv = card.querySelector(`.${target}-preview`);
                            if (previewDiv) {
                                const img = previewDiv.querySelector('img');
                                if (img) img.src = evt.target.result;
                                previewDiv.style.display = 'flex';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
            
            const removePreviewBtns = card.querySelectorAll('.remove-image-preview');
            removePreviewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    const fileInput = card.querySelector(`.color-image-input[data-target="${type}"]`);
                    const previewDiv = card.querySelector(`.${type}-preview`);
                    if (fileInput) {
                        fileInput.value = '';
                        delete fileInput.fileObject;
                    }
                    if (previewDiv) previewDiv.style.display = 'none';
                    const label = fileInput ? fileInput.nextElementSibling : null;
                    if (label) label.textContent = 'Choose new file';
                });
            });
            
            const removeBtn = card.querySelector('.remove-color-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    if (colorsContainer.querySelectorAll('.color-card').length > 1) {
                        const wasDefault = card.querySelector('.default-color-radio').checked;
                        card.remove();
                        if (wasDefault) {
                            const remainingCards = colorsContainer.querySelectorAll('.color-card');
                            if (remainingCards.length > 0) {
                                const firstRadio = remainingCards[0].querySelector('.default-color-radio');
                                if (firstRadio) firstRadio.checked = true;
                            }
                        }
                        const remainingCards = colorsContainer.querySelectorAll('.color-card');
                        if (remainingCards.length === 1) {
                            const lastRemoveBtn = remainingCards[0].querySelector('.remove-color-btn');
                            if (lastRemoveBtn) lastRemoveBtn.disabled = true;
                        }
                        updateDefaultColorHighlight();
                    } else {
                        showToast('At least one color variant is required', 'warning');
                    }
                });
            }
        }

        // Reset form to original state
        function resetForm() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'All unsaved changes will be lost!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        }

        // Event Listeners
        if (productName) {
            productName.addEventListener('input', updateSlug);
        }
        if (productSlug) {
            productSlug.addEventListener('input', onSlugManuallyEdited);
        }
        if (resetFormBtn) resetFormBtn.addEventListener('click', resetForm);
        
        if (submitProductBtn) {
            submitProductBtn.addEventListener('click', async function(e) {
                e.preventDefault();
                if (!validateForm()) return;
                
                const originalHtml = submitProductBtn.innerHTML;
                submitProductBtn.disabled = true;
                submitProductBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                
                try {
                    const form = document.getElementById('productForm');
                    const productId = form.querySelector('input[name="product_id"]').value;
                    const formData = new FormData(form);
                    
                    // Append product images
                    if (selectedFiles.length > 0) {
                        for (let i = 0; i < selectedFiles.length; i++) {
                            formData.append('product_images_files[]', selectedFiles[i]);
                        }
                        formData.append('product_images_count', selectedFiles.length);
                    }
                    
                    // Append color images - use flat naming structure
                    const colorCards = document.querySelectorAll('.color-card');
                    for (let i = 0; i < colorCards.length; i++) {
                        const card = colorCards[i];
                        const frontInput = card.querySelector('.color-image-input[data-target="front"]');
                        const backInput = card.querySelector('.color-image-input[data-target="back"]');
                        
                        if (frontInput && frontInput.fileObject) {
                            formData.append(`front_image_${i}`, frontInput.fileObject);
                        }
                        if (backInput && backInput.fileObject) {
                            formData.append(`back_image_${i}`, backInput.fileObject);
                        }
                    }
                    
                    const response = await fetch(`/admin/edit-product/update/${productId}`, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: result.message,
                            showConfirmButton: true
                        }).then(() => {
                            if (result.redirect) {
                                window.location.href = result.redirect;
                            }
                        });
                    } else {
                        let errorMessage = result.message || 'Failed to update product';
                        if (result.errors) errorMessage = Object.values(result.errors).join('\n');
                        Swal.fire({ icon: 'error', title: 'Error!', text: errorMessage });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'An unexpected error occurred. Please try again.' });
                } finally {
                    submitProductBtn.disabled = false;
                    submitProductBtn.innerHTML = originalHtml;
                }
            });
        }
        
        if (addSizeBtn) addSizeBtn.addEventListener('click', addSizeRow);
        if (addColorBtn) addColorBtn.addEventListener('click', addColorRow);
        
        setupColorRadioDelegation();
        setupSizeRadioDelegation();
        
        function attachInitialEvents() {
            const initialSizeRows = sizesTableBody.querySelectorAll('.size-row');
            initialSizeRows.forEach(row => attachSizeRowEvents(row));
            const initialColorCards = colorsContainer.querySelectorAll('.color-card');
            initialColorCards.forEach(card => attachColorCardEvents(card));
            if (initialSizeRows.length === 1 && initialSizeRows[0].querySelector('.remove-size-btn')) {
                const removeBtn = initialSizeRows[0].querySelector('.remove-size-btn');
                const hasSizeId = initialSizeRows[0].querySelector('input[name$="[size_id]"]');
                if (!hasSizeId) removeBtn.disabled = true;
            }
            if (initialColorCards.length === 1 && initialColorCards[0].querySelector('.remove-color-btn')) {
                const removeBtn = initialColorCards[0].querySelector('.remove-color-btn');
                const hasColorId = initialColorCards[0].querySelector('input[name$="[color_id]"]');
                if (!hasColorId) removeBtn.disabled = true;
            }
            updateDefaultColorHighlight();
            updateDefaultSizeHighlight();
        }
        
        attachInitialEvents();
    });
})();
/**
 * Add Product Page JavaScript
 * Handles all UI interactions with drag-and-drop file upload
 */

// Suppress Chrome extension errors in console
(function() {
    const originalError = console.error;
    console.error = function(...args) {
        if (args[0] && typeof args[0] === 'string' && 
            (args[0].includes('Unchecked runtime.lastError') || 
             args[0].includes('Receiving end does not exist') ||
             args[0].includes('Could not establish connection'))) {
            return;
        }
        originalError.apply(console, args);
    };
})();

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
        
        const uploadArea = document.getElementById('productImageUploadArea');
        const fileSelectBtn = document.getElementById('productImageSelectBtn');
        const imageList = document.getElementById('productImageList');

        let sizeCounter = 1;
        let colorCounter = 1;
        let selectedFiles = [];
        let isSlugManuallyEdited = false;

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

        function resetSlugAutoGeneration() {
            isSlugManuallyEdited = false;
            updateSlug();
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

        function clearFormFields() {
            document.getElementById('productForm').reset();
            
            if (productSlug) productSlug.value = '';
            const inStockCheckbox = document.getElementById('isInStock');
            if (inStockCheckbox) inStockCheckbox.checked = true;
            const featuredCheckbox = document.getElementById('isFeatured');
            if (featuredCheckbox) featuredCheckbox.checked = false;
            const tagsInput = document.getElementById('productTags');
            if (tagsInput) tagsInput.value = '';
            
            resetSlugAutoGeneration();
        }

        function clearSizes() {
            const allSizeRows = sizesTableBody.querySelectorAll('.size-row');
            for (let i = allSizeRows.length - 1; i >= 1; i--) {
                allSizeRows[i].remove();
            }
            
            const firstRow = sizesTableBody.querySelector('.size-row');
            if (firstRow) {
                firstRow.querySelector('.size-name').value = '';
                firstRow.querySelector('.size-unit').value = '';
                firstRow.querySelector('.size-price').value = '';
                firstRow.querySelector('.size-discount').value = '';
                const defaultRadio = firstRow.querySelector('.default-size-radio');
                if (defaultRadio) {
                    defaultRadio.checked = true;
                    defaultRadio.value = '0';
                }
                const removeBtn = firstRow.querySelector('.remove-size-btn');
                if (removeBtn) removeBtn.disabled = true;
            }
            updateDefaultSizeHighlight();
        }

        function clearColors() {
            const allColorCards = colorsContainer.querySelectorAll('.color-card');
            for (let i = allColorCards.length - 1; i >= 1; i--) {
                allColorCards[i].remove();
            }
            
            const firstColor = colorsContainer.querySelector('.color-card');
            if (firstColor) {
                firstColor.querySelector('.color-hex-picker').value = '#3498db';
                firstColor.querySelector('.color-hex-text').value = '#3498db';
                
                const frontInput = firstColor.querySelector('.color-image-input[data-target="front"]');
                const backInput = firstColor.querySelector('.color-image-input[data-target="back"]');
                if (frontInput) frontInput.value = '';
                if (backInput) backInput.value = '';
                
                const frontPreview = firstColor.querySelector('.front-preview');
                const backPreview = firstColor.querySelector('.back-preview');
                if (frontPreview) frontPreview.style.display = 'none';
                if (backPreview) backPreview.style.display = 'none';
                
                // Clear any stored file objects
                if (frontInput) delete frontInput.fileObject;
                if (backInput) delete backInput.fileObject;
                
                const defaultColorRadio = firstColor.querySelector('.default-color-radio');
                if (defaultColorRadio) {
                    defaultColorRadio.checked = true;
                    defaultColorRadio.value = '0';
                }
                
                const removeColorBtn = firstColor.querySelector('.remove-color-btn');
                if (removeColorBtn) removeColorBtn.disabled = true;
                
                const frontLabel = firstColor.querySelector('.custom-file-input[data-target="front"] + .custom-file-label');
                const backLabel = firstColor.querySelector('.custom-file-input[data-target="back"] + .custom-file-label');
                if (frontLabel) frontLabel.textContent = 'Choose file';
                if (backLabel) backLabel.textContent = 'Choose file';
            }
            updateDefaultColorHighlight();
        }

        function clearProductImages() {
            selectedFiles = [];
            if (imageList) imageList.innerHTML = '';
            if (productImagesInput) productImagesInput.value = '';
        }

        function resetForm() {
            clearFormFields();
            clearSizes();
            clearColors();
            clearProductImages();
            
            sizeCounter = 1;
            colorCounter = 1;

            showToast('Form has been reset', 'success');
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
                // Store the file object directly on the input element
                input.addEventListener('change', function() {
                    const target = this.getAttribute('data-target');
                    const file = this.files[0];
                    if (file) {
                        // Store the file object for later use
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
                        delete fileInput.fileObject; // Clear stored file
                    }
                    if (previewDiv) previewDiv.style.display = 'none';
                    const label = fileInput ? fileInput.nextElementSibling : null;
                    if (label) label.textContent = 'Choose file';
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

        // Event Listeners
        if (productName) {
            productName.addEventListener('input', updateSlug);
            productName.addEventListener('keyup', updateSlug);
        }
        if (productSlug) {
            productSlug.addEventListener('input', onSlugManuallyEdited);
            productSlug.addEventListener('keyup', onSlugManuallyEdited);
        }
        if (resetFormBtn) resetFormBtn.addEventListener('click', resetForm);
        
        // In the submit button click handler, before creating FormData
        if (submitProductBtn) {
            submitProductBtn.addEventListener('click', async function(e) {
                e.preventDefault();
                if (!validateForm()) return;
                
                const originalHtml = submitProductBtn.innerHTML;
                submitProductBtn.disabled = true;
                submitProductBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                
                try {
                    const form = document.getElementById('productForm');
                    
                    // Remove empty hidden image fields to avoid confusion
                    const hiddenImageFields = form.querySelectorAll('input[type="hidden"][name*="[front_image]"], input[type="hidden"][name*="[back_image]"]');
                    hiddenImageFields.forEach(field => {
                        if (!field.value) {
                            field.remove();
                        }
                    });
                    
                    const formData = new FormData(form);
                    
                    // Append product images
                    if (selectedFiles.length > 0) {
                        for (let i = 0; i < selectedFiles.length; i++) {
                            formData.append('product_images_files[]', selectedFiles[i]);
                        }
                        formData.append('product_images_count', selectedFiles.length);
                    }
                    
                    // In the submit button click handler
                    // Append color images - use flat naming structure
                    const colorCards = document.querySelectorAll('.color-card');
                    for (let i = 0; i < colorCards.length; i++) {
                        const card = colorCards[i];
                        const frontInput = card.querySelector('.color-image-input[data-target="front"]');
                        const backInput = card.querySelector('.color-image-input[data-target="back"]');
                        
                        // Use flat naming structure (not nested)
                        if (frontInput && frontInput.fileObject) {
                            formData.append(`front_image_${i}`, frontInput.fileObject);
                        }
                        if (backInput && backInput.fileObject) {
                            formData.append(`back_image_${i}`, backInput.fileObject);
                        }
                    }
                    
                    const response = await fetch('/admin/add-product/store', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        resetForm();
                        
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
                        let errorMessage = result.message || 'Failed to save product';
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
            if (initialSizeRows.length === 1) {
                const removeBtn = initialSizeRows[0].querySelector('.remove-size-btn');
                if (removeBtn) removeBtn.disabled = true;
            }
            if (initialColorCards.length === 1) {
                const removeBtn = initialColorCards[0].querySelector('.remove-color-btn');
                if (removeBtn) removeBtn.disabled = true;
            }
            updateDefaultColorHighlight();
            updateDefaultSizeHighlight();
        }
        
        attachInitialEvents();
        if (productName && productName.value) updateSlug();
    });
})();
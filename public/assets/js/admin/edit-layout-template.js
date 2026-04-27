let currentGrid = null;
let currentLayout = {
    rows: [],
    images: {}
};
let selectedGridId = null;

$(document).ready(function() {
    
    // Ensure all buttons don't submit forms
    $('button').each(function() {
        if (!$(this).attr('type') || $(this).attr('type') !== 'submit') {
            $(this).attr('type', 'button');
        }
    });
    
    // Prevent form submission on enter key
    $('#editLayoutForm').on('keypress', function(e) {
        if (e.which === 13 && !$(e.target).is('textarea')) {
            e.preventDefault();
            return false;
        }
    });
    
    // Load existing layout data
    if (window.layoutData) {
        selectedGridId = window.layoutData.grid_template_id;
        
        // Get grid layout - ensure it has rows
        if (window.layoutData.grid_layout && window.layoutData.grid_layout.rows) {
            currentGrid = window.layoutData.grid_layout;
        } else {
            console.error('Invalid grid layout data:', window.layoutData.grid_layout);
            currentGrid = { rows: [] };
        }
        
        // Load existing images
        var existingImages = window.layoutData.images_data.images || {};
        currentLayout.images = {};
        
        Object.keys(existingImages).forEach(function(cellId) {
            var img = existingImages[cellId];
            currentLayout.images[cellId] = {
                id: img.id,
                url: img.url,
                name: img.name,
                transform: img.transform || {
                    left: 0,
                    top: 0,
                    scaleX: 1,
                    scaleY: 1,
                    angle: 0
                }
            };
        });
        
        $('#selectedGridId').val(selectedGridId);
        $('#layoutName').val(window.layoutData.name);
        $('#selectedTemplateName').text(window.layoutData.grid_name);
        
        loadFabricJS().then(function() {
            loadGrid();
        });
    }
    
    function loadFabricJS() {
        return new Promise(function(resolve, reject) {
            if (typeof fabric !== 'undefined') {
                resolve();
                return;
            }
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    
    function loadGrid() {
        console.log('Loading grid with data:', currentGrid);
        
        if (!currentGrid || !currentGrid.rows || currentGrid.rows.length === 0) {
            $('#gridContainer').html(`
                <div class="text-center p-5 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p>Invalid grid layout. Please contact administrator.</p>
                    <p class="small mt-2">Debug: No rows found in grid layout</p>
                </div>
            `);
            return;
        }
        
        var html = '<div class="rows-container">';
        var totalCells = 0;
        
        currentGrid.rows.forEach(function(row, rowIndex) {
            var columns = row.columns;
            var height = row.height || 150;
            var columnWidths = row.columnWidths || [];
            
            if (columnWidths.length === 0) {
                var defaultWidth = Math.floor(12 / columns);
                var remainder = 12 - (defaultWidth * columns);
                for (var i = 0; i < columns; i++) {
                    columnWidths.push(defaultWidth + (i < remainder ? 1 : 0));
                }
            }
            
            var columnsHtml = '<div class="row">';
            for (var colIndex = 0; colIndex < columns; colIndex++) {
                var width = columnWidths[colIndex];
                var cellId = rowIndex + '_' + colIndex;
                var savedImage = currentLayout.images[cellId];
                totalCells++;
                
                columnsHtml += `
                    <div class="col-md-${width}">
                        <div class="grid-cell" id="cell_${cellId}" data-row="${rowIndex}" data-col="${colIndex}" data-cell="${cellId}" style="min-height: ${height}px; height: ${height}px;">
                            <div class="image-editor-container" id="editor_${cellId}" style="height: 100%; width: 100%; position: relative; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                                ${!savedImage ? `
                                    <div class="empty-cell-overlay" id="overlay_${cellId}">
                                        <div class="text-center">
                                            <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                            <p class="mt-2 mb-0">Click or Drag Image Here</p>
                                            <small>Upload from computer</small>
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }
            columnsHtml += '</div>';
            
            html += '<div class="row-row mb-4" data-row-index="' + rowIndex + '">' + columnsHtml + '</div>';
        });
        
        html += '</div>';
        $('#gridContainer').html(html);
        $('#totalCells').text(totalCells);
        updateImagesPlacedCount();
        
        // Initialize fabric canvases for existing images
        Object.keys(currentLayout.images).forEach(function(cellId) {
            if (currentLayout.images[cellId] && currentLayout.images[cellId].url) {
                initializeFabricCanvas(cellId, currentLayout.images[cellId]);
            }
        });
        
        $('[id^="overlay_"]').each(function() {
            var cellId = $(this).attr('id').replace('overlay_', '');
            $(this).off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                initiateImageUpload(cellId);
                return false;
            });
        });
        
        setupDragAndDrop();
    }
    
    function setupDragAndDrop() {
        $('.grid-cell').off('dragover dragleave drop');
        
        $('.grid-cell').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $cell = $(this);
            if ($cell.find('.empty-cell-overlay').length > 0) {
                $cell.addClass('drag-over');
            }
        });
        
        $('.grid-cell').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-over');
        });
        
        $('.grid-cell').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-over');
            
            var $cell = $(this);
            var cellId = $cell.data('cell');
            
            if (currentLayout.images[cellId]) {
                Swal.fire({
                    title: 'Cell Occupied',
                    text: 'This cell already has an image. Replace it?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, replace it!',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        handleImageDrop(e, cellId);
                    }
                });
            } else {
                handleImageDrop(e, cellId);
            }
        });
    }
    
    function handleImageDrop(e, cellId) {
        var files = e.originalEvent.dataTransfer.files;
        if (files && files.length > 0) {
            var file = files[0];
            if (file.type.startsWith('image/')) {
                uploadImageToCell(file, cellId);
            } else {
                Swal.fire('Invalid File', 'Please drop an image file.', 'error');
            }
        }
    }
    
    function initiateImageUpload(cellId) {
        var input = $('<input type="file" accept="image/*" style="display:none">');
        $('body').append(input);
        
        input.on('change', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var file = e.target.files[0];
            if (file) {
                uploadImageToCell(file, cellId);
            }
            input.remove();
            return false;
        });
        
        input.click();
    }
    
    function uploadImageToCell(file, cellId) {
        if (!file.type.match('image.*')) {
            Swal.fire('Invalid File', 'Please select an image file.', 'error');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire('File Too Large', 'Image must be less than 5MB.', 'error');
            return;
        }
        
        var existingImage = currentLayout.images[cellId];
        
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var base64 = e.target.result;
            
            var imageData = {
                id: 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                base64: base64,
                name: file.name,
                size: file.size
            };
            
            if (existingImage && existingImage.fabricCanvas) {
                existingImage.fabricCanvas.dispose();
            }
            
            placeImageInCell(imageData, cellId);
            
            Swal.fire({ icon: 'success', title: 'Uploaded!', text: 'Image placed successfully. You can drag, resize, and rotate it.', timer: 2000, showConfirmButton: false });
        };
        
        reader.readAsDataURL(file);
    }
    
    function placeImageInCell(imageData, cellId) {
        currentLayout.images[cellId] = imageData;
        initializeFabricCanvas(cellId, imageData);
        updateImagesPlacedCount();
    }
    
    function initializeFabricCanvas(cellId, imageData) {
        var container = document.getElementById('editor_' + cellId);
        if (!container) return;
        
        $(container).empty();
        
        var $cell = $('#cell_' + cellId);
        var cellWidth = $cell.width();
        var cellHeight = $cell.height();
        
        var canvas = document.createElement('canvas');
        canvas.id = 'canvas_' + cellId;
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.borderRadius = '8px';
        container.appendChild(canvas);
        
        var fabricCanvas = new fabric.Canvas('canvas_' + cellId);
        fabricCanvas.setDimensions({ width: cellWidth, height: cellHeight });
        
        var imgUrl = imageData.base64 || imageData.url;
        
        fabric.Image.fromURL(imgUrl, function(img) {
            var scale = Math.min(
                (cellWidth * 0.85) / img.width,
                (cellHeight * 0.85) / img.height
            );
            
            var left = (imageData.transform && imageData.transform.left !== undefined) ? imageData.transform.left : (cellWidth - (img.width * scale)) / 2;
            var top = (imageData.transform && imageData.transform.top !== undefined) ? imageData.transform.top : (cellHeight - (img.height * scale)) / 2;
            var scaleX = (imageData.transform && imageData.transform.scaleX !== undefined) ? imageData.transform.scaleX : scale;
            var scaleY = (imageData.transform && imageData.transform.scaleY !== undefined) ? imageData.transform.scaleY : scale;
            var angle = (imageData.transform && imageData.transform.angle !== undefined) ? imageData.transform.angle : 0;
            
            img.set({
                left: left,
                top: top,
                scaleX: scaleX,
                scaleY: scaleY,
                angle: angle,
                hasControls: true,
                hasBorders: true,
                cornerColor: '#3D204E',
                cornerSize: 10,
                transparentCorners: false,
                borderColor: '#3D204E',
                borderScaleFactor: 2,
                cornerStyle: 'circle',
                padding: 5
            });
            
            fabricCanvas.add(img);
            fabricCanvas.setActiveObject(img);
            fabricCanvas.renderAll();
            
            currentLayout.images[cellId] = {
                id: imageData.id,
                base64: imageData.base64,
                url: imageData.url,
                name: imageData.name,
                fabricCanvas: fabricCanvas,
                fabricImage: img,
                transform: {
                    left: img.left,
                    top: img.top,
                    scaleX: img.scaleX,
                    scaleY: img.scaleY,
                    angle: img.angle
                }
            };
            
            img.on('modified', function() {
                if (currentLayout.images[cellId]) {
                    currentLayout.images[cellId].transform = {
                        left: img.left,
                        top: img.top,
                        scaleX: img.scaleX,
                        scaleY: img.scaleY,
                        angle: img.angle
                    };
                }
            });
            
        }, { crossOrigin: 'anonymous' });
        
        var controls = $(`
            <div class="fabric-controls">
                <button type="button" class="fabric-delete" data-cell="${cellId}">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <button type="button" class="fabric-reset" data-cell="${cellId}">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>
        `);
        
        $(container).append(controls);
        
        controls.find('.fabric-delete').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            removeImageFromCell(cellId);
        });
        
        controls.find('.fabric-reset').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var img = currentLayout.images[cellId]?.fabricImage;
            var canvas = currentLayout.images[cellId]?.fabricCanvas;
            if (img && canvas) {
                var newScale = Math.min(
                    (cellWidth * 0.85) / img.width,
                    (cellHeight * 0.85) / img.height
                );
                img.set({
                    left: (cellWidth - (img.width * newScale)) / 2,
                    top: (cellHeight - (img.height * newScale)) / 2,
                    scaleX: newScale,
                    scaleY: newScale,
                    angle: 0
                });
                canvas.renderAll();
                currentLayout.images[cellId].transform = {
                    left: img.left,
                    top: img.top,
                    scaleX: img.scaleX,
                    scaleY: img.scaleY,
                    angle: img.angle
                };
            }
        });
    }
    
    function removeImageFromCell(cellId) {
        Swal.fire({
            title: 'Remove Image?',
            text: 'This will remove the image from the layout. It will NOT be saved when you click Update.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, remove it!'
        }).then(function(result) {
            if (result.isConfirmed) {
                if (currentLayout.images[cellId] && currentLayout.images[cellId].fabricCanvas) {
                    currentLayout.images[cellId].fabricCanvas.dispose();
                }
                delete currentLayout.images[cellId];
                
                var $container = $('#editor_' + cellId);
                $container.html(`
                    <div class="empty-cell-overlay" id="overlay_${cellId}">
                        <div class="text-center">
                            <i class="fas fa-cloud-upload-alt fa-3x"></i>
                            <p class="mt-2 mb-0">Click or Drag Image Here</p>
                            <small>Upload from computer</small>
                        </div>
                    </div>
                `);
                
                $('#overlay_' + cellId).off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    initiateImageUpload(cellId);
                    return false;
                });
                
                updateImagesPlacedCount();
                Swal.fire({ icon: 'success', title: 'Removed!', text: 'Image has been removed from layout.', timer: 1500, showConfirmButton: false });
            }
        });
    }
    
    $('#clearAllImages').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var imageCount = Object.keys(currentLayout.images).length;
        if (imageCount === 0) {
            Swal.fire('No Images', 'There are no images to clear.', 'info');
            return;
        }
        
        Swal.fire({
            title: 'Clear All Images?',
            text: 'This will remove ' + imageCount + ' image(s) from the layout. They will NOT be saved when you click Update.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, clear all!'
        }).then(function(result) {
            if (result.isConfirmed) {
                Object.keys(currentLayout.images).forEach(function(cellId) {
                    if (currentLayout.images[cellId] && currentLayout.images[cellId].fabricCanvas) {
                        currentLayout.images[cellId].fabricCanvas.dispose();
                    }
                });
                currentLayout.images = {};
                loadGrid();
                Swal.fire('Cleared!', 'All images have been removed from the layout.', 'success');
            }
        });
        
        return false;
    });
    
    // Image Library Functions
    function initializeUploadArea() {
        var uploadAreaElement = document.getElementById('uploadArea');
        var fileInput = document.getElementById('imageUpload');
        
        if (uploadAreaElement) {
            var newUploadArea = uploadAreaElement.cloneNode(true);
            uploadAreaElement.parentNode.replaceChild(newUploadArea, uploadAreaElement);
            uploadAreaElement = newUploadArea;
            
            uploadAreaElement.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (fileInput) fileInput.click();
            });
            
            uploadAreaElement.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('drag-over');
            });
            
            uploadAreaElement.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');
            });
            
            uploadAreaElement.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('drag-over');
                
                if (e.dataTransfer && e.dataTransfer.files) {
                    var files = e.dataTransfer.files;
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (file.type.startsWith('image/')) {
                            uploadImageToLibrary(file);
                        } else {
                            Swal.fire('Invalid File', file.name + ' is not an image file.', 'error');
                        }
                    }
                }
            });
        }
        
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var files = e.target.files;
                if (files && files.length > 0) {
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (file.type.startsWith('image/')) {
                            uploadImageToLibrary(file);
                        } else {
                            Swal.fire('Invalid File', file.name + ' is not an image file.', 'error');
                        }
                    }
                }
                this.value = '';
            });
        }
    }
    
    function uploadImageToLibrary(file) {
        if (!file.type.match('image.*')) {
            Swal.fire('Invalid File', 'Please select an image file.', 'error');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            Swal.fire('File Too Large', file.name + ' is over 5MB.', 'error');
            return;
        }
        
        var $uploadArea = $('#uploadArea');
        var originalContent = $uploadArea.html();
        $uploadArea.html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x mb-2"></i><p>Uploading ' + escapeHtml(file.name) + '...</p></div>');
        
        var formData = new FormData();
        formData.append('image', file);
        
        $.ajax({
            url: '/admin/layout/upload-temp-image',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $uploadArea.html(originalContent);
                
                if (response.success) {
                    var imageData = {
                        id: response.image_id,
                        url: response.url,
                        name: file.name,
                        size: file.size
                    };
                    addImageToLibrary(imageData);
                    Swal.fire({ icon: 'success', title: 'Uploaded!', text: file.name + ' added to library.', timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire('Upload Failed', response.message, 'error');
                }
            },
            error: function() {
                $uploadArea.html(originalContent);
                Swal.fire('Error', 'Failed to upload ' + file.name + '. Please try again.', 'error');
            }
        });
    }
    
    function addImageToLibrary(imageData) {
        var imageId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        var imageHtml = `
            <div class="image-item" draggable="true" data-image-id="${imageId}" data-image-url="${imageData.url}" data-image-name="${escapeHtml(imageData.name)}">
                <div class="image-preview">
                    <img src="${imageData.url}" alt="${escapeHtml(imageData.name)}">
                </div>
                <div class="image-info">
                    <small>${imageData.name.length > 25 ? imageData.name.substring(0, 25) + '...' : imageData.name}</small>
                </div>
            </div>
        `;
        
        $('#uploadedImages').prepend(imageHtml);
        
        var $imageItem = $('.image-item[data-image-id="' + imageId + '"]');
        
        $imageItem[0].addEventListener('dragstart', function(e) {
            var imageInfo = {
                id: $imageItem.data('image-id'),
                url: $imageItem.data('image-url'),
                name: $imageItem.data('image-name')
            };
            e.dataTransfer.setData('text/plain', JSON.stringify(imageInfo));
            e.dataTransfer.effectAllowed = 'copy';
            e.dataTransfer.setDragImage(new Image(), 0, 0);
            $imageItem.addClass('dragging');
        });
        
        $imageItem[0].addEventListener('dragend', function(e) {
            $imageItem.removeClass('dragging');
        });
        
        $imageItem.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var imageInfo = {
                url: $(this).data('image-url'),
                name: $(this).data('image-name'),
                id: $(this).data('image-id')
            };
            
            Swal.fire({
                title: 'Place Image',
                html: 'Click on any <strong>empty cell</strong> to place "' + imageInfo.name + '"',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false,
                position: 'top'
            });
            
            window.selectedImageToPlace = imageInfo;
            
            document.querySelectorAll('.grid-cell').forEach(function(cell) {
                var $cell = $(cell);
                var cellId = $cell.data('cell');
                if (!currentLayout.images[cellId]) {
                    cell.classList.add('ready-for-image');
                    cell.style.cursor = 'crosshair';
                }
            });
            
            var cellClickHandler = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $cell = $(this);
                var targetCellId = $cell.data('cell');
                
                if (!currentLayout.images[targetCellId] && window.selectedImageToPlace) {
                    placeImageInCell(window.selectedImageToPlace, targetCellId);
                    window.selectedImageToPlace = null;
                    document.querySelectorAll('.grid-cell').forEach(function(cell) {
                        cell.classList.remove('ready-for-image');
                        cell.style.cursor = '';
                    });
                    document.querySelectorAll('.grid-cell').forEach(function(cell) {
                        cell.removeEventListener('click', cellClickHandler);
                    });
                    
                    Swal.fire({ icon: 'success', title: 'Image Placed!', toast: true, position: 'bottom-end', showConfirmButton: false, timer: 1500 });
                }
            };
            
            document.querySelectorAll('.grid-cell').forEach(function(cell) {
                cell.removeEventListener('click', cellClickHandler);
                cell.addEventListener('click', cellClickHandler);
            });
            
            setTimeout(function() {
                document.querySelectorAll('.grid-cell').forEach(function(cell) {
                    cell.classList.remove('ready-for-image');
                    cell.style.cursor = '';
                    cell.removeEventListener('click', cellClickHandler);
                });
                if (window.selectedImageToPlace) window.selectedImageToPlace = null;
            }, 10000);
        });
    }
    
    initializeUploadArea();
    
    function updateImagesPlacedCount() {
        var count = Object.keys(currentLayout.images).length;
        $('#imagesPlaced').text(count);
    }
    
    $('#updateLayoutBtn').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var layoutName = $('#layoutName').val().trim();
        var gridTemplateId = $('#selectedGridId').val();
        var layoutId = $('#layoutId').val();
        
        if (!layoutName) {
            Swal.fire('Error', 'Layout name is required.', 'error');
            return;
        }
        
        if (!gridTemplateId) {
            Swal.fire('Error', 'No grid template selected.', 'error');
            return;
        }
        
        var imagesToSave = {};
        Object.keys(currentLayout.images).forEach(function(cellId) {
            var img = currentLayout.images[cellId];
            imagesToSave[cellId] = {
                id: img.id,
                base64: img.base64 || null,
                url: img.url || null,
                name: img.name,
                transform: img.transform || {
                    left: 0,
                    top: 0,
                    scaleX: 1,
                    scaleY: 1,
                    angle: 0
                }
            };
        });
        
        var imagesData = {
            images: imagesToSave,
            placed_at: new Date().toISOString(),
            total_images: Object.keys(imagesToSave).length
        };
        
        var $submitBtn = $('#updateLayoutBtn');
        var originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true);
        $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Updating layout...');
        
        $.ajax({
            url: '/admin/edit-layout-template/update/' + layoutId,
            type: 'POST',
            data: {
                name: layoutName,
                grid_template_id: gridTemplateId,
                images_data: JSON.stringify(imagesData)
            },
            dataType: 'json',
            success: function(response) {
                $submitBtn.prop('disabled', false);
                $submitBtn.html(originalText);
                
                if (response.success) {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.message, timer: 1500, showConfirmButton: false })
                        .then(function() {
                            window.location.href = response.redirect || '/admin/layout-templates-masterlist';
                        });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                $submitBtn.prop('disabled', false);
                $submitBtn.html(originalText);
                var errorMsg = 'Failed to update layout. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
        
        return false;
    });
    
    function escapeHtml(text) {
        if (!text) return '';
        return String(text).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
});
let currentGrid = null;
let currentLayout = {
    rows: [],
    images: {}
};
let selectedGridId = null;
let activeCanvas = null;
let activeCellId = null;

$(document).ready(function() {
    
    $('button').each(function() {
        if (!$(this).attr('type') || $(this).attr('type') !== 'submit') {
            $(this).attr('type', 'button');
        }
    });
    
    $('#createLayoutForm').on('keypress', function(e) {
        if (e.which === 13 && !$(e.target).is('textarea')) {
            e.preventDefault();
            return false;
        }
    });
    
    if (window.isEditMode && window.existingLayout) {
        selectedGridId = window.existingLayout.grid_template_id;
        currentGrid = JSON.parse(window.existingLayout.grid_layout);
        currentLayout.images = window.existingLayout.images_data.images || {};
        $('#selectedGridId').val(selectedGridId);
        $('#layoutName').val(window.existingLayout.name);
        $('#selectedTemplateName').text(window.existingLayout.name);
        
        loadFabricJS().then(function() {
            loadGrid();
            $('#step2').show();
        });
    }
    
    $('.template-card').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        $('.template-card').removeClass('selected');
        $(this).addClass('selected');
        
        selectedGridId = $(this).data('grid-id');
        var gridJson = $(this).data('grid-json');
        var templateName = $(this).find('.card-title').text();
        
        $('#selectedGridId').val(selectedGridId);
        $('#selectedTemplateName').text(templateName);
        $('#nextToStep2').prop('disabled', false);
        
        if (typeof gridJson === 'string') {
            try {
                currentGrid = JSON.parse(gridJson);
            } catch(e) {
                console.error('Error parsing grid JSON:', e);
                currentGrid = null;
            }
        } else {
            currentGrid = gridJson;
        }
    });
    
    $('#nextToStep2').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var layoutName = $('#layoutName').val().trim();
        
        if (!layoutName) {
            Swal.fire({ icon: 'error', title: 'Required Field', text: 'Please enter a layout name.' });
            $('#layoutName').focus();
            return;
        }
        
        if (layoutName.length < 3) {
            Swal.fire({ icon: 'error', title: 'Invalid Name', text: 'Layout name must be at least 3 characters.' });
            return;
        }
        
        if (!selectedGridId) {
            Swal.fire({ icon: 'error', title: 'No Template Selected', text: 'Please select a grid template first.' });
            return;
        }
        
        loadFabricJS().then(function() {
            loadGrid();
            $('#step1').hide();
            $('#step2').show();
            showEditorModeIndicator();
        });
        
        return false;
    });
    
    $('#backToStep1').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        Object.keys(currentLayout.images).forEach(function(cellId) {
            if (currentLayout.images[cellId] && currentLayout.images[cellId].fabricCanvas) {
                currentLayout.images[cellId].fabricCanvas.dispose();
            }
        });
        
        $('#step2').hide();
        $('#step1').show();
        currentLayout = { rows: [], images: {} };
        hideEditorModeIndicator();
        
        return false;
    });
    
    function showEditorModeIndicator() {
        $('body').append('<div class="editor-mode-indicator" id="editorIndicator"><i class="fas fa-mouse-pointer"></i> Drag & Drop Images | Click to Select | Use Handles to Resize/Rotate</div>');
        $('#editorIndicator').fadeIn().delay(5000).fadeOut(function() { $(this).remove(); });
    }
    
    function hideEditorModeIndicator() {
        $('#editorIndicator').remove();
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
        if (!currentGrid || !currentGrid.rows || currentGrid.rows.length === 0) {
            $('#gridContainer').html(`
                <div class="text-center p-5 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p>Invalid grid layout. Please select another template.</p>
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
        
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var base64 = e.target.result;
            
            var imageData = {
                id: 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                base64: base64,
                name: file.name,
                size: file.size
            };
            
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
        
        // Clear container
        $(container).empty();
        
        var $cell = $('#cell_' + cellId);
        var cellWidth = $cell.width();
        var cellHeight = $cell.height();
        
        // Create canvas element
        var canvas = document.createElement('canvas');
        canvas.id = 'canvas_' + cellId;
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.borderRadius = '8px';
        container.appendChild(canvas);
        
        // Initialize fabric canvas
        var fabricCanvas = new fabric.Canvas('canvas_' + cellId);
        fabricCanvas.setDimensions({ width: cellWidth, height: cellHeight });
        
        // Load image
        var imgUrl = imageData.base64 || imageData.url;
        
        fabric.Image.fromURL(imgUrl, function(img) {
            // Calculate initial scale to fit within cell
            var scale = Math.min(
                (cellWidth * 0.85) / img.width,
                (cellHeight * 0.85) / img.height
            );
            
            // Apply saved transform if exists
            var left = (imageData.transform && imageData.transform.left) ? imageData.transform.left : (cellWidth - (img.width * scale)) / 2;
            var top = (imageData.transform && imageData.transform.top) ? imageData.transform.top : (cellHeight - (img.height * scale)) / 2;
            var scaleX = (imageData.transform && imageData.transform.scaleX) ? imageData.transform.scaleX : scale;
            var scaleY = (imageData.transform && imageData.transform.scaleY) ? imageData.transform.scaleY : scale;
            var angle = (imageData.transform && imageData.transform.angle) ? imageData.transform.angle : 0;
            
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
            
            // Store fabric canvas reference
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
            
            // Save transform on modification
            img.on('modified', function() {
                currentLayout.images[cellId].transform = {
                    left: img.left,
                    top: img.top,
                    scaleX: img.scaleX,
                    scaleY: img.scaleY,
                    angle: img.angle
                };
            });
            
        }, { crossOrigin: 'anonymous' });
        
        // Add control buttons
        var controls = $(`
            <div class="fabric-controls" style="position: absolute; top: 5px; right: 5px; z-index: 100; display: flex; gap: 5px;">
                <button type="button" class="btn btn-sm btn-light fabric-delete" data-cell="${cellId}" style="padding: 4px 8px; font-size: 12px;">
                    <i class="fas fa-trash"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light fabric-reset" data-cell="${cellId}" style="padding: 4px 8px; font-size: 12px;">
                    <i class="fas fa-undo"></i>
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
        
        // Handle cell resize
        $(window).on('resize', function() {
            if (fabricCanvas) {
                var newWidth = $('#cell_' + cellId).width();
                var newHeight = $('#cell_' + cellId).height();
                fabricCanvas.setDimensions({ width: newWidth, height: newHeight });
                fabricCanvas.renderAll();
            }
        });
    }
    
    function removeImageFromCell(cellId) {
        Swal.fire({
            title: 'Remove Image?',
            text: 'This will remove the image from the layout. It will NOT be saved when you click Save.',
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
            text: 'This will remove ' + imageCount + ' image(s) from the layout. They will NOT be saved when you click Save.',
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
    
    function updateImagesPlacedCount() {
        var count = Object.keys(currentLayout.images).length;
        $('#imagesPlaced').text(count);
    }
    
    $('#saveLayoutBtn').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var layoutName = $('#layoutName').val().trim();
        var gridTemplateId = $('#selectedGridId').val();
        
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
                base64: img.base64,
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
        
        var imagesData = {
            images: imagesToSave,
            placed_at: new Date().toISOString(),
            total_images: Object.keys(imagesToSave).length
        };
        
        var $submitBtn = $('#saveLayoutBtn');
        var originalText = $submitBtn.html();
        $submitBtn.prop('disabled', true);
        $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving layout...');
        
        var url = window.isEditMode ? '/admin/add-layout-template/update/' + window.existingLayout.id : '/admin/add-layout-template/save';
        
        $.ajax({
            url: url,
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
                var errorMsg = 'Failed to save layout. Please try again.';
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
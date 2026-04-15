let currentLayout = {
    rows: []
};
let originalLayout = null;
let draggedRowIndex = null;
let draggedCellData = null;

$(document).ready(function() {
    // Load template data
    loadTemplateData();
    
    // Add Row
    $('#addRowBtn').on('click', function() {
        let columns = parseInt($('#numColumns').val());
        let height = parseInt($('#rowHeight').val());
        addRow(columns, height);
        updateJsonFromLayout();
        renderGridPreview();
        showToast('Row added', 'success');
    });
    
    // Clear all
    $('#clearAllBtn').on('click', function() {
        Swal.fire({
            title: 'Clear All?',
            text: 'This will remove all rows from your layout.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, clear all!'
        }).then((result) => {
            if (result.isConfirmed) {
                currentLayout.rows = [];
                updateJsonFromLayout();
                renderGridPreview();
                showToast('Layout cleared', 'info');
            }
        });
    });
    
    // Reset form
    $('#resetFormBtn').on('click', function() {
        if (originalLayout) {
            Swal.fire({
                title: 'Reset Changes?',
                text: 'This will revert all unsaved changes.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset!'
            }).then((result) => {
                if (result.isConfirmed) {
                    currentLayout = JSON.parse(JSON.stringify(originalLayout));
                    $('#templateName').val(originalName);
                    $('#isFeatured').prop('checked', originalFeatured === 1);
                    updateJsonFromLayout();
                    renderGridPreview();
                    showToast('Changes reverted', 'info');
                }
            });
        }
    });
    
    // Format JSON
    $('#formatJsonBtn').on('click', function() {
        try {
            let json = $('#layoutJson').val();
            let parsed = JSON.parse(json);
            $('#layoutJson').val(JSON.stringify(parsed, null, 2));
            loadLayoutFromJson();
            showToast('JSON formatted', 'success');
        } catch(e) {
            showError('Invalid JSON: ' + e.message);
        }
    });
    
    // JSON editor change
    $('#layoutJson').on('change blur', function() {
        loadLayoutFromJson();
    });
    
    // Load template data from server
    function loadTemplateData() {
        let templateId = $('#templateId').val();
        
        $.ajax({
            url: '/admin/templatesmasterlist/getTemplate/' + templateId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let template = response.data;
                    
                    // Set template name
                    $('#templateName').val(template.name);
                    originalName = template.name;
                    
                    // Set featured status
                    let isFeatured = template.is_featured || 0;
                    $('#isFeatured').prop('checked', isFeatured === 1);
                    originalFeatured = isFeatured;
                    
                    // Parse and load layout
                    try {
                        let cleanJson = template.layout_json.replace(/&quot;/g, '"');
                        let layout = JSON.parse(cleanJson);
                        currentLayout = layout;
                        originalLayout = JSON.parse(JSON.stringify(layout));
                        updateJsonFromLayout();
                        renderGridPreview();
                    } catch(e) {
                        console.error("Parse error:", e);
                        showError('Failed to parse template layout');
                    }
                } else {
                    showError(response.message || 'Failed to load template');
                }
            },
            error: function() {
                showError('Failed to load template data');
            }
        });
    }
    
    // Add row
    function addRow(columns, height, columnWidths = null) {
        let row = { columns: columns, height: height };
        if (columnWidths) row.columnWidths = columnWidths;
        currentLayout.rows.push(row);
    }
    
    // Update JSON from current layout
    function updateJsonFromLayout() {
        $('#layoutJson').val(JSON.stringify(currentLayout, null, 2));
    }
    
    // Load layout from JSON
    function loadLayoutFromJson() {
        try {
            let json = $('#layoutJson').val();
            if (json.trim()) {
                let parsed = JSON.parse(json);
                if (parsed.rows && Array.isArray(parsed.rows)) {
                    currentLayout = parsed;
                    renderGridPreview();
                    $('#layoutJson').removeClass('json-error');
                }
            }
        } catch(e) {
            $('#layoutJson').addClass('json-error');
        }
    }
    
    // Render grid preview
    function renderGridPreview() {
        if (!currentLayout.rows || currentLayout.rows.length === 0) {
            $('#gridPreview').html(`
                <div class="text-center text-muted py-5">
                    <i class="fas fa-th-large fa-3x mb-3"></i>
                    <p>Your grid layout will appear here</p>
                    <p class="small">Click "Add Row" to start building</p>
                </div>
            `);
            return;
        }
        
        let html = '<div class="rows-container" id="rowsContainer">';
        
        // Top drop zone
        html += `
            <div class="drop-zone" data-position="top">
                <span class="drop-label">
                    <i class="fas fa-arrow-down"></i> ↓ Drop Here to Add Row at Top ↓
                </span>
            </div>
        `;
        
        currentLayout.rows.forEach((row, rowIndex) => {
            let columns = row.columns;
            let height = row.height || 120;
            let columnWidths = row.columnWidths || [];
            
            // Build columns HTML
            let columnsHtml = '<div class="row" style="flex-wrap: nowrap;">';
            for (let i = 0; i < columns; i++) {
                let width = columnWidths[i] || Math.floor(12 / columns);
                let colClass = `col-${width}`;
                
                columnsHtml += `
                    <div class="${colClass}" style="padding: 0 5px;">
                        <div class="layout-cell" data-row="${rowIndex}" data-col="${i}" draggable="true" style="min-height: ${height}px;">
                            <div class="remove-cell" data-row="${rowIndex}" data-col="${i}">
                                <i class="fas fa-times"></i>
                            </div>
                            <i class="fas fa-arrows-alt mb-2" style="font-size: 20px;"></i>
                            <div>
                                <strong>Column ${i + 1}</strong>
                                <div class="small mt-1">
                                    Width: ${width}/12
                                    <button type="button" class="btn btn-link btn-sm p-0 ml-1 adjust-width" data-row="${rowIndex}" data-col="${i}" data-current="${width}">
                                        <i class="fas fa-sliders-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            columnsHtml += '</div>';
            
            html += `
                <div class="layout-row" data-row-index="${rowIndex}" draggable="true">
                    <div class="row-controls">
                        <button type="button" class="btn btn-xs btn-outline-primary edit-row" data-row="${rowIndex}">
                            <i class="fas fa-edit"></i> Edit Row
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-danger remove-row" data-row="${rowIndex}">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                        <span class="drag-handle" title="Drag this row to reorder">
                            <i class="fas fa-grip-vertical"></i> Drag
                        </span>
                    </div>
                    ${columnsHtml}
                </div>
            `;
            
            // Drop zone between rows
            if (rowIndex < currentLayout.rows.length - 1) {
                html += `
                    <div class="row-drop-zone" data-position="between" data-after-row="${rowIndex}">
                        <span class="drop-label">
                            <i class="fas fa-arrow-down"></i> ↓ Drop Row Here ↓
                        </span>
                    </div>
                `;
            }
        });
        
        // Bottom drop zone
        html += `
            <div class="drop-zone" data-position="bottom">
                <span class="drop-label">
                    <i class="fas fa-arrow-down"></i> ↓ Drop Here to Add Row at Bottom ↓
                </span>
            </div>
        `;
        
        html += '</div>';
        $('#gridPreview').html(html);
        
        // Initialize drag and drop
        initializeRowDragDrop();
        initializeCellDragDrop();
        initializeAddDropZones();
        
        // Bind events
        $('.remove-cell').on('click', function(e) {
            e.stopPropagation();
            let rowIndex = parseInt($(this).data('row'));
            let colIndex = parseInt($(this).data('col'));
            removeCell(rowIndex, colIndex);
        });
        
        $('.remove-row').on('click', function(e) {
            e.stopPropagation();
            let rowIndex = parseInt($(this).data('row'));
            removeRow(rowIndex);
        });
        
        $('.edit-row').on('click', function(e) {
            e.stopPropagation();
            let rowIndex = parseInt($(this).data('row'));
            editRow(rowIndex);
        });
        
        $('.adjust-width').on('click', function(e) {
            e.stopPropagation();
            let rowIndex = parseInt($(this).data('row'));
            let colIndex = parseInt($(this).data('col'));
            let currentWidth = parseInt($(this).data('current'));
            adjustColumnWidth(rowIndex, colIndex, currentWidth);
        });
    }
    
    // Initialize drop zones
    function initializeAddDropZones() {
        $('.drop-zone').off('dragover drop dragleave').on({
            dragover: function(e) {
                e.preventDefault();
                $(this).addClass('active');
            },
            dragleave: function() {
                $(this).removeClass('active');
            },
            drop: function(e) {
                e.preventDefault();
                $(this).removeClass('active');
                
                let position = $(this).data('position');
                let columns = parseInt($('#numColumns').val());
                let height = parseInt($('#rowHeight').val());
                let newRow = { columns: columns, height: height };
                
                if (position === 'top') {
                    currentLayout.rows.unshift(newRow);
                    showToast('Row added at top', 'success');
                } else if (position === 'bottom') {
                    currentLayout.rows.push(newRow);
                    showToast('Row added at bottom', 'success');
                }
                
                updateJsonFromLayout();
                renderGridPreview();
            }
        });
        
        $('.row-drop-zone').off('dragover drop dragleave').on({
            dragover: function(e) {
                e.preventDefault();
                $(this).addClass('active');
            },
            dragleave: function() {
                $(this).removeClass('active');
            },
            drop: function(e) {
                e.preventDefault();
                $(this).removeClass('active');
                
                let afterRow = $(this).data('after-row');
                if (afterRow !== undefined && draggedRowIndex !== null) {
                    let insertIndex = parseInt(afterRow) + 1;
                    if (draggedRowIndex < insertIndex) insertIndex--;
                    
                    const [movedRow] = currentLayout.rows.splice(draggedRowIndex, 1);
                    currentLayout.rows.splice(insertIndex, 0, movedRow);
                    
                    updateJsonFromLayout();
                    renderGridPreview();
                    showToast('Row moved', 'success');
                    draggedRowIndex = null;
                }
            }
        });
    }
    
    // Initialize row drag and drop
    function initializeRowDragDrop() {
        const rows = document.querySelectorAll('.layout-row');
        
        rows.forEach(row => {
            row.addEventListener('dragstart', function(e) {
                draggedRowIndex = parseInt(this.getAttribute('data-row-index'));
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', draggedRowIndex);
            });
            
            row.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                document.querySelectorAll('.layout-row').forEach(r => r.classList.remove('drag-over'));
                document.querySelectorAll('.row-drop-zone').forEach(z => z.classList.remove('active'));
            });
        });
    }
    
    // Initialize cell drag and drop
    function initializeCellDragDrop() {
        const cells = document.querySelectorAll('.layout-cell');
        
        cells.forEach(cell => {
            cell.addEventListener('dragstart', function(e) {
                let rowIndex = parseInt(this.getAttribute('data-row'));
                let colIndex = parseInt(this.getAttribute('data-col'));
                draggedCellData = { rowIndex, colIndex };
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', JSON.stringify(draggedCellData));
            });
            
            cell.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                const targetCell = e.target.closest('.layout-cell');
                if (targetCell && targetCell !== this) {
                    document.querySelectorAll('.layout-cell').forEach(c => c.classList.remove('drag-over'));
                    targetCell.classList.add('drag-over');
                }
            });
            
            cell.addEventListener('dragend', function() {
                this.classList.remove('dragging');
                document.querySelectorAll('.layout-cell').forEach(c => c.classList.remove('drag-over'));
                draggedCellData = null;
            });
            
            cell.addEventListener('drop', function(e) {
                e.preventDefault();
                const targetCell = e.target.closest('.layout-cell');
                if (targetCell && draggedCellData) {
                    const targetRow = parseInt(targetCell.getAttribute('data-row'));
                    const targetCol = parseInt(targetCell.getAttribute('data-col'));
                    
                    if (draggedCellData.rowIndex !== targetRow || draggedCellData.colIndex !== targetCol) {
                        moveCell(draggedCellData.rowIndex, draggedCellData.colIndex, targetRow, targetCol);
                    }
                }
                document.querySelectorAll('.layout-cell').forEach(c => c.classList.remove('drag-over'));
            });
        });
    }
    
    // Move cell
    function moveCell(fromRow, fromCol, toRow, toCol) {
        const sourceRow = currentLayout.rows[fromRow];
        const targetRow = currentLayout.rows[toRow];
        
        if (!sourceRow || !targetRow) return;
        
        let sourceWidth = sourceRow.columnWidths && sourceRow.columnWidths[fromCol] 
            ? sourceRow.columnWidths[fromCol] 
            : Math.floor(12 / sourceRow.columns);
        
        sourceRow.columns--;
        if (sourceRow.columnWidths) sourceRow.columnWidths.splice(fromCol, 1);
        
        targetRow.columns++;
        if (!targetRow.columnWidths) {
            targetRow.columnWidths = [];
            let defaultWidth = Math.floor(12 / (targetRow.columns - 1));
            for (let i = 0; i < targetRow.columns - 1; i++) {
                targetRow.columnWidths.push(defaultWidth);
            }
        }
        
        targetRow.columnWidths.splice(toCol, 0, sourceWidth);
        recalculateColumnWidths(targetRow);
        if (sourceRow.columns > 0) recalculateColumnWidths(sourceRow);
        
        updateJsonFromLayout();
        renderGridPreview();
        showToast('Column moved', 'success');
    }
    
    // Recalculate column widths
    function recalculateColumnWidths(row) {
        if (!row.columnWidths || row.columnWidths.length !== row.columns) {
            row.columnWidths = [];
            let defaultWidth = Math.floor(12 / row.columns);
            let remainder = 12 - (defaultWidth * row.columns);
            for (let i = 0; i < row.columns; i++) {
                let width = defaultWidth;
                if (remainder > 0 && i < remainder) width++;
                row.columnWidths.push(width);
            }
        }
    }
    
    // Edit row
    function editRow(rowIndex) {
        let row = currentLayout.rows[rowIndex];
        
        Swal.fire({
            title: 'Edit Row',
            html: `
                <div class="form-group">
                    <label>Number of Columns</label>
                    <input type="number" id="editColumns" class="form-control" min="1" max="6" value="${row.columns}">
                </div>
                <div class="form-group">
                    <label>Row Height (px)</label>
                    <input type="number" id="editHeight" class="form-control" min="50" max="400" value="${row.height || 120}">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            preConfirm: () => {
                let newColumns = parseInt(document.getElementById('editColumns').value);
                let newHeight = parseInt(document.getElementById('editHeight').value);
                
                if (newColumns < 1 || newColumns > 6) {
                    Swal.showValidationMessage('Columns must be between 1 and 6');
                    return false;
                }
                
                return { newColumns, newHeight };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let oldColumns = row.columns;
                row.columns = result.value.newColumns;
                row.height = result.value.newHeight;
                
                if (oldColumns !== row.columns) {
                    recalculateColumnWidths(row);
                }
                
                updateJsonFromLayout();
                renderGridPreview();
                showToast('Row updated', 'success');
            }
        });
    }
    
    // Remove cell
    function removeCell(rowIndex, colIndex) {
        let row = currentLayout.rows[rowIndex];
        if (row.columns > 1) {
            row.columns--;
            if (row.columnWidths) row.columnWidths.splice(colIndex, 1);
            updateJsonFromLayout();
            renderGridPreview();
            showToast('Column removed', 'info');
        } else {
            showError('Cannot remove last column. Remove the row instead.');
        }
    }
    
    // Remove row
    function removeRow(rowIndex) {
        Swal.fire({
            title: 'Remove Row?',
            text: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, remove!'
        }).then((result) => {
            if (result.isConfirmed) {
                if (currentLayout.rows.length > 1) {
                    currentLayout.rows.splice(rowIndex, 1);
                    updateJsonFromLayout();
                    renderGridPreview();
                    showToast('Row removed', 'success');
                } else {
                    showError('Cannot remove the last row.');
                }
            }
        });
    }
    
    // Adjust column width
    function adjustColumnWidth(rowIndex, colIndex, currentWidth) {
        let row = currentLayout.rows[rowIndex];
        
        Swal.fire({
            title: 'Column Width',
            html: `
                <div class="form-group">
                    <label>Width (1-12): <span id="widthValue">${currentWidth}</span>/12</label>
                    <input type="range" id="widthSlider" class="form-control-range" min="1" max="12" value="${currentWidth}" step="1">
                </div>
                <div class="alert alert-info small mt-2">
                    Total width of all columns must not exceed 12
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Apply',
            didOpen: () => {
                const slider = document.getElementById('widthSlider');
                const display = document.getElementById('widthValue');
                slider.addEventListener('input', (e) => display.textContent = e.target.value);
            },
            preConfirm: () => {
                let newWidth = parseInt(document.getElementById('widthSlider').value);
                let otherTotal = 0;
                for (let i = 0; i < row.columns; i++) {
                    if (i !== colIndex) {
                        let w = row.columnWidths && row.columnWidths[i] ? row.columnWidths[i] : Math.floor(12 / row.columns);
                        otherTotal += w;
                    }
                }
                if (newWidth + otherTotal > 12) {
                    Swal.showValidationMessage(`Total would exceed 12. Available: ${12 - otherTotal}`);
                    return false;
                }
                return newWidth;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (!row.columnWidths) {
                    row.columnWidths = [];
                    let defaultWidth = Math.floor(12 / row.columns);
                    for (let i = 0; i < row.columns; i++) row.columnWidths.push(defaultWidth);
                }
                row.columnWidths[colIndex] = result.value;
                updateJsonFromLayout();
                renderGridPreview();
                showToast('Width updated', 'success');
            }
        });
    }
    
    // Form submission
    $('#editTemplateForm').on('submit', function(e) {
        e.preventDefault();
        
        let templateName = $('#templateName').val().trim();
        let layoutJson = $('#layoutJson').val().trim();
        let templateId = $('#templateId').val();
        let isFeatured = $('#isFeatured').is(':checked') ? 1 : 0;
        
        if (!templateName) {
            showError('Please enter a template name.');
            return;
        }
        
        if (!layoutJson) {
            showError('Please create a layout.');
            return;
        }
        
        try {
            JSON.parse(layoutJson);
        } catch(e) {
            showError('Invalid JSON format.');
            return;
        }
        
        $('#loadingOverlay').fadeIn(200);
        
        $.ajax({
            url: '/admin/edit-template/update/' + templateId,
            type: 'POST',
            data: {
                name: templateName,
                layout_json: layoutJson,
                is_featured: isFeatured
            },
            dataType: 'json',
            success: function(response) {
                $('#loadingOverlay').fadeOut(200);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Template updated successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || '/admin/templates-masterlist';
                    });
                } else {
                    showError(response.message || 'Failed to update template.');
                }
            },
            error: function() {
                $('#loadingOverlay').fadeOut(200);
                showError('An error occurred. Please try again.');
            }
        });
    });
    
    function showToast(message, type) {
        Swal.fire({
            icon: type,
            title: message,
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    }
    
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#dc3545'
        });
    }
});
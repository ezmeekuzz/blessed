let currentLayout = {
    rows: []
};

let draggedRowIndex = null;
let draggedCell = null;

$(document).ready(function() {
    
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
            text: 'This will remove all rows.',
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
    
    // Preset selection
    $('.preset-card').on('click', function() {
        $('.preset-card').removeClass('selected');
        $(this).addClass('selected');
        
        let preset = $(this).data('preset');
        loadPreset(preset);
        showToast('Preset loaded', 'success');
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
    
    // Load preset layouts
    function loadPreset(preset) {
        let rows = [];
        
        switch(preset) {
            case '3-col':
                rows.push({ columns: 3, height: 120 });
                break;
            case '2-col':
                rows.push({ columns: 2, height: 120 });
                break;
            case '4-col':
                rows.push({ columns: 4, height: 120 });
                break;
            case 'hero':
                rows.push({ columns: 1, height: 200 });
                rows.push({ columns: 2, height: 120 });
                break;
            case 'sidebar':
                rows.push({ columns: 2, columnWidths: [8, 4], height: 120 });
                break;
            case 'gallery':
                rows.push({ columns: 3, columnWidths: [6, 3, 3], height: 120 });
                break;
        }
        
        currentLayout.rows = rows;
        updateJsonFromLayout();
        renderGridPreview();
    }
    
    // Add row
    function addRow(columns, height, columnWidths = null) {
        let row = {
            columns: columns,
            height: height
        };
        
        if (columnWidths) {
            row.columnWidths = columnWidths;
        }
        
        currentLayout.rows.push(row);
    }
    
    // Update JSON
    function updateJsonFromLayout() {
        $('#layoutJson').val(JSON.stringify(currentLayout, null, 2));
    }
    
    // Load from JSON
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
                <div class="empty-state">
                    <i class="fas fa-th-large"></i>
                    <h5>No Layout Yet</h5>
                    <p class="text-muted">Select a preset or click "Add Row" to start</p>
                </div>
            `);
            return;
        }
        
        let html = '<div class="rows-container" id="rowsContainer">';
        
        currentLayout.rows.forEach((row, rowIndex) => {
            let columns = row.columns;
            let height = row.height || 120;
            let columnWidths = row.columnWidths || [];
            
            // Build columns HTML
            let columnsHtml = '<div class="row">';
            for (let i = 0; i < columns; i++) {
                let width = columnWidths[i] || Math.floor(12 / columns);
                let colClass = `col-${width}`;
                
                columnsHtml += `
                    <div class="${colClass}">
                        <div class="layout-cell" data-row="${rowIndex}" data-col="${i}" style="min-height: ${height}px;">
                            <div class="remove-cell" data-row="${rowIndex}" data-col="${i}">
                                <i class="fas fa-times"></i>
                            </div>
                            <i class="fas fa-grip-vertical mb-2"></i>
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
                <div class="layout-row" data-row-index="${rowIndex}">
                    <div class="row-controls">
                        <button type="button" class="btn btn-xs btn-outline-danger remove-row" data-row="${rowIndex}">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                        <span class="drag-handle" title="Drag to reorder">
                            <i class="fas fa-grip-vertical"></i> Drag
                        </span>
                    </div>
                    ${columnsHtml}
                </div>
            `;
        });
        
        html += '</div>';
        $('#gridPreview').html(html);
        
        // Initialize drag and drop
        initializeDragDrop();
        
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
        
        $('.adjust-width').on('click', function(e) {
            e.stopPropagation();
            let rowIndex = parseInt($(this).data('row'));
            let colIndex = parseInt($(this).data('col'));
            let currentWidth = parseInt($(this).data('current'));
            adjustColumnWidth(rowIndex, colIndex, currentWidth);
        });
    }
    
    // Initialize drag and drop for rows
    function initializeDragDrop() {
        const rows = document.querySelectorAll('.layout-row');
        
        rows.forEach(row => {
            row.setAttribute('draggable', 'true');
            
            row.addEventListener('dragstart', function(e) {
                draggedRowIndex = parseInt(this.getAttribute('data-row-index'));
                this.classList.add('dragging');
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/plain', draggedRowIndex);
            });
            
            row.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
                const targetRow = e.target.closest('.layout-row');
                if (targetRow && targetRow !== this) {
                    document.querySelectorAll('.layout-row').forEach(r => r.classList.remove('drag-over'));
                    targetRow.classList.add('drag-over');
                }
            });
            
            row.addEventListener('dragend', function() {
                document.querySelectorAll('.layout-row').forEach(r => {
                    r.classList.remove('dragging');
                    r.classList.remove('drag-over');
                });
                draggedRowIndex = null;
            });
            
            row.addEventListener('drop', function(e) {
                e.preventDefault();
                const targetRow = e.target.closest('.layout-row');
                if (targetRow && draggedRowIndex !== null) {
                    const targetIndex = parseInt(targetRow.getAttribute('data-row-index'));
                    if (draggedRowIndex !== targetIndex) {
                        reorderRows(draggedRowIndex, targetIndex);
                    }
                }
                document.querySelectorAll('.layout-row').forEach(r => r.classList.remove('drag-over'));
            });
        });
    }
    
    // Reorder rows
    function reorderRows(fromIndex, toIndex) {
        const [movedRow] = currentLayout.rows.splice(fromIndex, 1);
        currentLayout.rows.splice(toIndex, 0, movedRow);
        updateJsonFromLayout();
        renderGridPreview();
        showToast('Row reordered', 'success');
    }
    
    // Remove cell
    function removeCell(rowIndex, colIndex) {
        let row = currentLayout.rows[rowIndex];
        
        if (row.columns > 1) {
            row.columns--;
            
            if (row.columnWidths && row.columnWidths[colIndex]) {
                row.columnWidths.splice(colIndex, 1);
            }
            
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
                
                slider.addEventListener('input', (e) => {
                    display.textContent = e.target.value;
                });
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
                    for (let i = 0; i < row.columns; i++) {
                        row.columnWidths.push(defaultWidth);
                    }
                }
                
                row.columnWidths[colIndex] = result.value;
                updateJsonFromLayout();
                renderGridPreview();
                showToast('Width updated', 'success');
            }
        });
    }
    
    // Show toast
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
    
    // Show error
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            confirmButtonColor: '#dc3545'
        });
    }
    
    // Form submission
    $('#addTemplateForm').on('submit', function(e) {
        e.preventDefault();
        
        let templateName = $('#templateName').val().trim();
        let layoutJson = $('#layoutJson').val().trim();
        
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
        
        let submitBtn = $('#submitBtn');
        let originalText = submitBtn.html();
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: '/admin/addtemplate/insert',
            type: 'POST',
            data: {
                name: templateName,
                layout_json: layoutJson
            },
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Template saved successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect || '/admin/templates-masterlist';
                    });
                } else {
                    showError(response.message || 'Failed to save.');
                }
            },
            error: function() {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                showError('An error occurred. Please try again.');
            }
        });
    });
    
    // Initialize with default preset
    loadPreset('3-col');
});
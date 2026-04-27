$(document).ready(function () {
    let table = $('#templatesmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/gridtemplatesmasterlist/getData",
            "type": "POST",
            "dataSrc": function(json) {
                console.log("Response:", json);
                return json.data || [];
            }
        },
        "columns": [
            { 
                "data": "grid_template_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "name",
                "render": function(data, type, row) {
                    let name = escapeHtml(data);
                    if (name.length > 40) {
                        name = name.substring(0, 40) + '...';
                    }
                    return `<div class="template-name-cell">
                                <strong>${name}</strong>
                                <div class="small text-muted mt-1">ID: ${row.grid_template_id}</div>
                            </div>`;
                }
            },
            { 
                "data": "layout_json",
                "render": function(data, type, row) {
                    try {
                        // Clean up the JSON string (remove &quot; and other HTML entities)
                        let cleanJson = data.replace(/&quot;/g, '"');
                        let layout = JSON.parse(cleanJson);
                        let rows = layout.rows || [];
                        let previewHtml = '';
                        
                        if (rows.length > 0) {
                            previewHtml = '<div class="template-preview-box">';
                            rows.forEach(row => {
                                let columns = row.columns || 1;
                                let colClass = `col-${Math.floor(12 / columns)}`;
                                previewHtml += '<div class="row mb-1">';
                                for (let i = 0; i < columns; i++) {
                                    previewHtml += `<div class="${colClass}">${i + 1}</div>`;
                                }
                                previewHtml += '</div>';
                            });
                            previewHtml += '</div>';
                        } else {
                            previewHtml = '<span class="text-muted">No preview</span>';
                        }
                        return previewHtml;
                    } catch(e) {
                        console.error("Parse error:", e, data);
                        return '<span class="text-muted">Invalid layout</span>';
                    }
                },
                "className": "text-center"
            },
            { 
                "data": "layout_json",
                "render": function(data, type, row) {
                    try {
                        let cleanJson = data.replace(/&quot;/g, '"');
                        let layout = JSON.parse(cleanJson);
                        let rows = layout.rows || [];
                        let totalColumns = 0;
                        let maxColumns = 0;
                        
                        rows.forEach(row => {
                            let cols = row.columns || 1;
                            totalColumns += cols;
                            if (cols > maxColumns) maxColumns = cols;
                        });
                        
                        let columnInfo = `${rows.length} row(s)`;
                        if (maxColumns > 0) {
                            columnInfo += `<br><small class="text-muted">Max: ${maxColumns} cols</small>`;
                        }
                        
                        return `<div class="columns-badge text-center">
                                    <i class="fas fa-columns"></i> ${columnInfo}
                                </div>`;
                    } catch(e) {
                        return '<span class="text-muted">-</span>';
                    }
                },
                "className": "text-center"
            },
            { 
                "data": "is_featured",
                "render": function(data, type, row) {
                    let isFeatured = parseInt(data) === 1;
                    let starClass = isFeatured ? 'featured-star' : 'featured-star not-featured';
                    return `<div class="text-center">
                                <i class="fas fa-star ${starClass}" style="cursor: pointer;" title="${isFeatured ? 'Featured' : 'Not Featured'}"></i>
                                <button class="btn btn-sm btn-link toggle-featured p-0 mt-1" data-id="${row.grid_template_id}" data-featured="${isFeatured ? 1 : 0}">
                                    <i class="fas fa-sync-alt fa-xs"></i>
                                </button>
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    if (!data || data === '-0001-11-30 00:00:00') return 'N/A';
                    let date = new Date(data);
                    return date.toLocaleDateString();
                }
            },
            { 
                "data": "updated_at",
                "render": function(data, type, row) {
                    if (!data || data === '-0001-11-30 00:00:00') {
                        return row.created_at && row.created_at !== '-0001-11-30 00:00:00' 
                            ? new Date(row.created_at).toLocaleDateString() 
                            : 'N/A';
                    }
                    let date = new Date(data);
                    return date.toLocaleDateString();
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="#" title="View" class="view-btn" data-id="${row.grid_template_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-grid-template/${row.grid_template_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.grid_template_id}" style="color: #b91a0f;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                },
                "className": "text-center"
            }
        ],
        "order": [[0, 'desc']],
        "pageLength": 25,
        "responsive": true,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "zeroRecords": "No templates found"
        }
    });

    // View Template
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewTemplateModal').modal('show');
        $('#templatePreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading template details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/gridtemplatesmasterlist/getTemplate/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayTemplatePreview(response.data);
                } else {
                    $('#templatePreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load template details'}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr);
                $('#templatePreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the template details.
                    </div>
                `);
            }
        });
    });
    
    function displayTemplatePreview(template) {
        let layout = template.layout_json;
        let layoutObj = null;
        let previewHtml = '';
        
        try {
            // Clean up the JSON string
            let cleanJson = layout.replace(/&quot;/g, '"');
            layoutObj = JSON.parse(cleanJson);
        } catch(e) {
            console.error("Parse error:", e);
            layoutObj = null;
        }
        
        // Build visual preview
        if (layoutObj && layoutObj.rows) {
            previewHtml = '<div class="template-preview-large">';
            layoutObj.rows.forEach((row, idx) => {
                let columns = row.columns || 1;
                let height = row.height || 120;
                let columnWidths = row.columnWidths || [];
                
                previewHtml += `<div class="row mb-2" style="min-height: ${height}px;">`;
                for (let i = 0; i < columns; i++) {
                    let width = columnWidths[i] || Math.floor(12 / columns);
                    let colClass = `col-${width}`;
                    previewHtml += `<div class="${colClass}">Col ${i + 1}</div>`;
                }
                previewHtml += '</div>';
            });
            previewHtml += '</div>';
        } else {
            previewHtml = '<div class="alert alert-warning">Unable to render preview</div>';
        }
        
        // Get column statistics
        let rowCount = 0;
        let totalColumns = 0;
        let maxColumns = 0;
        let minHeight = Infinity;
        let maxHeight = 0;
        
        if (layoutObj && layoutObj.rows) {
            rowCount = layoutObj.rows.length;
            layoutObj.rows.forEach(row => {
                let cols = row.columns || 1;
                totalColumns += cols;
                if (cols > maxColumns) maxColumns = cols;
                let height = row.height || 120;
                if (height < minHeight) minHeight = height;
                if (height > maxHeight) maxHeight = height;
            });
            if (minHeight === Infinity) minHeight = 0;
        }
        
        let formattedJson = JSON.stringify(layoutObj, null, 2);
        
        // Format dates
        let createdDate = 'N/A';
        let updatedDate = 'N/A';
        
        if (template.created_at && template.created_at !== '-0001-11-30 00:00:00') {
            createdDate = new Date(template.created_at).toLocaleString();
        }
        if (template.updated_at && template.updated_at !== '-0001-11-30 00:00:00') {
            updatedDate = new Date(template.updated_at).toLocaleString();
        } else if (template.created_at && template.created_at !== '-0001-11-30 00:00:00') {
            updatedDate = new Date(template.created_at).toLocaleString();
        }
        
        let html = `
            <div class="template-details-container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mb-3">${escapeHtml(template.name)}</h3>
                        <hr>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <h5><i class="fas fa-eye"></i> Visual Preview</h5>
                        ${previewHtml}
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5><i class="fas fa-info-circle"></i> Template Information</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th width="40%">Template ID:</th>
                                <td>${template.grid_template_id}</td>
                            </tr>
                            <tr>
                                <th>Template Name:</th>
                                <td><strong>${escapeHtml(template.name)}</strong></td>
                            </tr>
                            <tr>
                                <th>Number of Rows:</th>
                                <td>${rowCount}</td>
                            </tr>
                            <tr>
                                <th>Total Columns:</th>
                                <td>${totalColumns}</td>
                            </tr>
                            <tr>
                                <th>Max Columns per Row:</th>
                                <td>${maxColumns}</td>
                            </tr>
                            <tr>
                                <th>Row Heights:</th>
                                <td>Min: ${minHeight}px | Max: ${maxHeight}px</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>${createdDate}</td>
                            </tr>
                            <tr>
                                <th>Last Modified:</th>
                                <td>${updatedDate}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-code"></i> JSON Layout</h5>
                        <div class="json-viewer">
                            <pre style="margin: 0; color: #d4d4d4; background: transparent; border: none;">${escapeHtml(formattedJson)}</pre>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary mt-2" id="copyJsonBtn">
                            <i class="fas fa-copy"></i> Copy JSON
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#templatePreviewContent').html(html);
        
        $('#copyJsonBtn').on('click', function() {
            navigator.clipboard.writeText(formattedJson).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'JSON layout copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Toggle Featured Status
    $(document).on('click', '.toggle-featured', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let isFeatured = $(this).data('featured');
        
        Swal.fire({
            title: 'Toggle Featured Status',
            text: `Are you sure you want to ${isFeatured == 1 ? 'remove from' : 'mark as'} featured?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, toggle it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/gridtemplatesmasterlist/toggleFeatured/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });
    
    // Delete Template
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will permanently delete the template.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/gridtemplatesmasterlist/delete/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'Something went wrong!',
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong with the request!',
                        });
                    }
                });
            }
        });
    });
});
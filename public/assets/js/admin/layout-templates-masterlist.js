$(document).ready(function () {
    let table = $('#layouttemplatesmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/layout-templates-masterlist/getData",
            "type": "POST",
            "dataSrc": function(json) {
                console.log("Response:", json);
                return json.data || [];
            }
        },
        "columns": [
            { 
                "data": "layout_template_id",
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
                    return `<div class="layout-name-cell">
                                <strong>${name}</strong>
                                <div class="small text-muted mt-1">ID: ${row.layout_template_id}</div>
                            </div>`;
                }
            },
            { 
                "data": "grid_name",
                "render": function(data, type, row) {
                    let gridName = escapeHtml(data);
                    if (gridName.length > 30) {
                        gridName = gridName.substring(0, 30) + '...';
                    }
                    return `<div class="grid-badge">
                                <i class="fas fa-th"></i> ${gridName}
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "image_count",
                "render": function(data, type, row) {
                    // Ensure data is a number
                    let count = parseInt(data) || 0;
                    let icon = count > 0 ? 'fa-image' : 'fa-images';
                    let color = count > 0 ? '#e65100' : '#999';
                    let text = count === 1 ? 'image' : 'images';
                    return `<div class="images-count-badge">
                                <i class="fas ${icon}" style="color: ${color};"></i> 
                                ${count} ${text}
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "grid_layout",
                "render": function(data, type, row) {
                    try {
                        let cleanJson = data.replace(/&quot;/g, '"');
                        let layout = JSON.parse(cleanJson);
                        let rows = layout.rows || [];
                        let previewHtml = '<div class="layout-preview-box">';
                        
                        // Show first 2 rows only for preview
                        let displayRows = rows.slice(0, 2);
                        displayRows.forEach(row => {
                            let columns = row.columns || 1;
                            let colClass = `col-${Math.floor(12 / columns)}`;
                            previewHtml += '<div class="row mb-1">';
                            for (let i = 0; i < columns; i++) {
                                previewHtml += `<div class="${colClass}">${i + 1}</div>`;
                            }
                            previewHtml += '</div>';
                        });
                        
                        if (rows.length > 2) {
                            previewHtml += '<div class="text-center mt-1"><small>+ more</small></div>';
                        }
                        
                        previewHtml += '</div>';
                        return previewHtml;
                    } catch(e) {
                        console.error("Parse error:", e, data);
                        return '<span class="text-muted">Invalid layout</span>';
                    }
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
                            <a href="#" title="View" class="view-btn" data-id="${row.layout_template_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-layout-template/${row.layout_template_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Duplicate" class="duplicate-btn" data-id="${row.layout_template_id}" style="color: #28a745;">
                                <i class="ti ti-copy" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.layout_template_id}" style="color: #b91a0f;">
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
            "zeroRecords": "No layout templates found"
        }
    });

    // View Layout Template
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewLayoutModal').modal('show');
        $('#layoutPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading layout details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/layout-templates-masterlist/getTemplate/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayLayoutPreview(response.data);
                } else {
                    $('#layoutPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load layout details'}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr);
                $('#layoutPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the layout details.
                    </div>
                `);
            }
        });
    });
    
    function displayLayoutPreview(template) {
        let gridLayout = template.grid_layout;
        let gridLayoutObj = null;
        let gridPreviewHtml = '';
        let imagesGalleryHtml = '';
        
        // Parse grid layout
        try {
            if (typeof gridLayout === 'string') {
                let cleanJson = gridLayout.replace(/&quot;/g, '"');
                gridLayoutObj = JSON.parse(cleanJson);
            } else {
                gridLayoutObj = gridLayout;
            }
        } catch(e) {
            console.error("Parse error:", e);
            gridLayoutObj = null;
        }
        
        // Build grid visual preview
        if (gridLayoutObj && gridLayoutObj.rows) {
            gridPreviewHtml = '<div class="layout-preview-large">';
            gridLayoutObj.rows.forEach((row, idx) => {
                let columns = row.columns || 1;
                let height = row.height || 120;
                let columnWidths = row.columnWidths || [];
                
                gridPreviewHtml += `<div class="row mb-2" style="min-height: ${height}px;">`;
                for (let i = 0; i < columns; i++) {
                    let width = columnWidths[i] || Math.floor(12 / columns);
                    let colClass = `col-${width}`;
                    gridPreviewHtml += `<div class="${colClass}">Cell ${i + 1}</div>`;
                }
                gridPreviewHtml += '</div>';
            });
            gridPreviewHtml += '</div>';
        } else {
            gridPreviewHtml = '<div class="alert alert-warning">Unable to render grid preview</div>';
        }
        
        // Build images gallery
        if (template.images && Object.keys(template.images).length > 0) {
            imagesGalleryHtml = '<div class="images-gallery">';
            Object.keys(template.images).forEach(cellId => {
                let image = template.images[cellId];
                imagesGalleryHtml += `
                    <div class="gallery-image-item">
                        <img src="${image.url}" alt="${escapeHtml(image.name)}">
                        <div class="image-info">
                            <small><strong>Cell:</strong> ${cellId}</small><br>
                            <small>${image.name.length > 30 ? image.name.substring(0, 30) + '...' : image.name}</small>
                        </div>
                    </div>
                `;
            });
            imagesGalleryHtml += '</div>';
        } else {
            imagesGalleryHtml = '<div class="alert alert-info">No images placed in this layout</div>';
        }
        
        // Format dates
        let createdDate = template.created_at || 'N/A';
        let updatedDate = template.updated_at || 'N/A';
        
        let formattedJson = JSON.stringify(template.images, null, 2);
        
        let html = `
            <div class="layout-details-container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mb-3">${escapeHtml(template.name)}</h3>
                        <hr>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-info-circle"></i> Layout Information</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th width="40%">Layout ID:</th>
                                <td>${template.layout_template_id}</td>
                            </tr>
                            <tr>
                                <th>Layout Name:</th>
                                <td><strong>${escapeHtml(template.name)}</strong></td>
                            </tr>
                            <tr>
                                <th>Grid Template:</th>
                                <td><span class="grid-badge">${escapeHtml(template.grid_name)}</span></td>
                            </tr>
                            <tr>
                                <th>Grid Template ID:</th>
                                <td>${template.grid_template_id}</td>
                            </tr>
                            <tr>
                                <th>Total Images:</th>
                                <td><span class="images-count-badge">${template.image_count} image(s)</span></td>
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
                        <h5><i class="fas fa-th"></i> Grid Structure Preview</h5>
                        ${gridPreviewHtml}
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5><i class="fas fa-images"></i> Placed Images (${template.image_count})</h5>
                        ${imagesGalleryHtml}
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5><i class="fas fa-code"></i> Images Data JSON</h5>
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
        
        $('#layoutPreviewContent').html(html);
        
        $('#copyJsonBtn').on('click', function() {
            navigator.clipboard.writeText(formattedJson).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Images data JSON copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    }
    
    // Duplicate Layout Template
    $(document).on('click', '.duplicate-btn', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Duplicate Layout Template?',
            text: "This will create a copy of this layout template.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, duplicate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Duplicating...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/layout-templates-masterlist/duplicate/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Duplicated!',
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
                        Swal.close();
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
    
    // Delete Layout Template
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will permanently delete the layout template and all image placements.",
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
                    url: '/admin/layout-templates-masterlist/delete/' + id,
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
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
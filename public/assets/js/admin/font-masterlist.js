$(document).ready(function () {
    let table = $('#fontmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/fontmasterlist/getData",
            "type": "POST"
        },
        "columns": [
            { 
                "data": "font_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "font_name",
                "render": function(data, type, row) {
                    return `<div class="font-name-cell">
                                <strong>${escapeHtml(data)}</strong>
                                <div class="font-preview" style="font-family: '${escapeHtml(data)}', sans-serif;">
                                    Sample Text
                                </div>
                            </div>`;
                }
            },
            { 
                "data": "source_type",
                "render": function(data, type, row) {
                    if (data === 'local') {
                        return `<span class="source-badge source-local"><i class="fas fa-upload"></i> Local</span>`;
                    } else if (data === 'external') {
                        return `<span class="source-badge source-external"><i class="fab fa-google"></i> External</span>`;
                    }
                    return `<span class="source-badge">${escapeHtml(data)}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": null,
                "render": function(data, type, row) {
                    if (row.source_type === 'external') {
                        if (row.font_link) {
                            let displayLink = row.font_link.length > 50 ? row.font_link.substring(0, 50) + '...' : row.font_link;
                            return `<div class="font-link-cell">
                                        <a href="${escapeHtml(row.font_link)}" target="_blank" title="${escapeHtml(row.font_link)}">
                                            <i class="fas fa-external-link-alt"></i> ${escapeHtml(displayLink)}
                                        </a>
                                    </div>`;
                        }
                        return '<span class="text-muted">No link provided</span>';
                    } else {
                        if (row.file_path) {
                            let fileName = row.file_path.split('/').pop();
                            return `<div class="file-path-cell">
                                        <i class="fas fa-file-font"></i> ${escapeHtml(fileName)}
                                        <button class="btn btn-sm btn-link download-font p-0 ml-2" data-path="${escapeHtml(row.file_path)}" data-name="${escapeHtml(row.font_name)}">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>`;
                        }
                        return '<span class="text-muted">No file uploaded</span>';
                    }
                }
            },
            { 
                "data": "is_featured",
                "render": function(data, type, row) {
                    let starClass = data == 1 ? 'featured-star' : 'featured-star not-featured';
                    return `<div class="text-center">
                                <i class="fas fa-star ${starClass}" style="cursor: pointer;" title="${data == 1 ? 'Featured' : 'Not Featured'}"></i>
                                <button class="btn btn-sm btn-link toggle-featured p-0 mt-1" data-id="${row.font_id}" data-featured="${data}">
                                    <i class="fas fa-sync-alt fa-xs"></i>
                                </button>
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    if (data === 'active') {
                        return `<span class="status-badge status-active"><i class="fas fa-check-circle"></i> Active</span>`;
                    } else {
                        return `<span class="status-badge status-inactive"><i class="fas fa-times-circle"></i> Inactive</span>`;
                    }
                },
                "className": "text-center"
            },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    if (!data) return 'N/A';
                    let date = new Date(data);
                    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="#" title="View" class="view-btn" data-id="${row.font_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-font/${row.font_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.font_id}" style="color: #b91a0f;">
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
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.font_id);
        },
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "zeroRecords": "No fonts found"
        }
    });

    // Download font file
    $(document).on('click', '.download-font', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        let filePath = $(this).data('path');
        let fontName = $(this).data('name');
        
        if (filePath) {
            window.location.href = baseUrl + 'admin/fontmasterlist/download/' + encodeURIComponent(filePath);
        }
    });

    // View Font
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewFontModal').modal('show');
        $('#fontPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading font details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/fontmasterlist/getFont/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayFontPreview(response.data);
                } else {
                    $('#fontPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load font details'}
                        </div>
                    `);
                }
            },
            error: function () {
                $('#fontPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the font details.
                    </div>
                `);
            }
        });
    });
    
    function displayFontPreview(font) {
        // Build sample text previews with different sizes
        let previewSizes = [16, 24, 32, 48];
        let previewHtml = '';
        
        if (font.source_type === 'external' && font.font_link) {
            // Load external font for preview
            loadExternalFontForPreview(font.font_link, font.font_name);
        } else if (font.source_type === 'local' && font.file_path) {
            // Load local font for preview
            loadLocalFontForPreview(font.file_path, font.font_name);
        }
        
        previewSizes.forEach(size => {
            previewHtml += `
                <div class="mb-3">
                    <label class="text-muted small">${size}px</label>
                    <div class="preview-text" style="font-size: ${size}px; font-family: '${escapeHtml(font.font_name)}', sans-serif;">
                        The quick brown fox jumps over the lazy dog
                    </div>
                </div>
            `;
        });
        
        let html = `
            <div class="font-preview-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center mb-4">
                            <div style="font-size: 48px; font-family: '${escapeHtml(font.font_name)}', sans-serif;">
                                ${escapeHtml(font.font_name)}
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle"></i> Font Information</h5>
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <th width="35%">Font Name:</th>
                                        <td><strong>${escapeHtml(font.font_name)}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Source Type:</th>
                                        <td>${font.source_type === 'local' ? '<span class="source-badge source-local">Local Upload</span>' : '<span class="source-badge source-external">External Link</span>'}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>${font.status === 'active' ? '<span class="status-badge status-active">Active</span>' : '<span class="status-badge status-inactive">Inactive</span>'}</td>
                                    </tr>
                                    <tr>
                                        <th>Featured:</th>
                                        <td>${font.is_featured == 1 ? '<span class="badge badge-warning"><i class="fas fa-star"></i> Featured</span>' : '<span class="badge badge-secondary">Not Featured</span>'}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>${font.created_at}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-link"></i> Source Details</h5>
                                <table class="table table-sm table-bordered">
                                    ${font.source_type === 'external' ? `
                                    <tr>
                                        <th>Font Link:</th>
                                        <td><a href="${escapeHtml(font.font_link)}" target="_blank">${escapeHtml(font.font_link)}</a></td>
                                    </tr>
                                    ` : `
                                    <tr>
                                        <th>File Path:</th>
                                        <td><code>${escapeHtml(font.file_path)}</code></td>
                                    </tr>
                                    `}
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5><i class="fas fa-eye"></i> Live Preview</h5>
                                <div class="card">
                                    <div class="card-body">
                                        ${previewHtml}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#fontPreviewContent').html(html);
    }
    
    // Load external font for preview
    function loadExternalFontForPreview(url, fontName) {
        let linkId = 'font-preview-link-' + Date.now();
        
        // Remove existing font preview links
        $('link[id^="font-preview-link-"]').remove();
        
        // Add new link
        $('head').append(`<link id="${linkId}" href="${url}" rel="stylesheet">`);
        
        // Update preview elements after font loads
        setTimeout(function() {
            $('.preview-text').css('font-family', `'${fontName}', sans-serif`);
        }, 500);
    }
    
    // Load local font for preview
    function loadLocalFontForPreview(filePath, fontName) {
        let styleId = 'font-preview-style-' + Date.now();
        
        // Remove existing custom font styles
        $('style[id^="font-preview-style-"]').remove();
        
        let fontUrl = baseUrl + '/' + filePath;
        let style = `
            @font-face {
                font-family: '${fontName}';
                src: url('${fontUrl}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }
        `;
        $('head').append(`<style id="${styleId}">${style}</style>`);
        
        setTimeout(function() {
            $('.preview-text').css('font-family', `'${fontName}', sans-serif`);
        }, 100);
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
                    url: '/admin/fontmasterlist/toggleFeatured/' + id,
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
    
    // Delete Font
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will permanently delete the font.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
                    url: '/admin/fontmasterlist/delete/' + id,
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
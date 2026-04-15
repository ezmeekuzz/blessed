$(document).ready(function () {
    let table = null;
    let currentView = 'active'; // 'active' or 'trash'
    
    // Initialize DataTable for active records
    function initDataTable(view) {
        if (table) {
            table.destroy();
        }
        
        let ajaxUrl = view === 'active' 
            ? '/admin/stickermasterlist/getData' 
            : '/admin/stickermasterlist/getTrashData';
        
        table = $('#stickermasterlist').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": ajaxUrl,
                "type": "POST"
            },
            "columns": [
                { 
                    "data": "sticker_id",
                    "render": function(data, type, row) {
                        let deletedBadge = (view === 'trash' || row.deleted_at) ? 
                            '<span class="deleted-badge"><i class="fas fa-trash"></i> Deleted</span>' : '';
                        return `<span class="badge badge-secondary">#${data}</span>${deletedBadge}`;
                    },
                    "className": "text-center"
                },
                { 
                    "data": "image_url",
                    "render": function(data, type, row) {
                        let sourceBadge = row.is_external ? 
                            '<span class="source-badge source-external"><i class="fas fa-link"></i> URL</span>' : 
                            '<span class="source-badge source-local"><i class="fas fa-upload"></i> Local</span>';
                        
                        // For local images, construct the full URL from relative path
                        let imageDisplayUrl = row.is_external ? row.image_url : baseUrl + '/' + row.image_url;
                        
                        return `<div class="text-center">
                                    <img src="${imageDisplayUrl}" class="sticker-thumbnail" alt="${escapeHtml(row.title)}" onerror="this.src='${baseUrl}assets/images/no-image.png'">
                                    ${sourceBadge}
                                </div>`;
                    },
                    "className": "text-center"
                },
                { 
                    "data": "title",
                    "render": function(data, type, row) {
                        let title = escapeHtml(data);
                        if (title.length > 50) {
                            title = title.substring(0, 50) + '...';
                        }
                        let description = escapeHtml(row.description);
                        if (description && description.length > 60) {
                            description = description.substring(0, 60) + '...';
                        }
                        return `<div class="sticker-title-cell">
                                    <strong>${title}</strong>
                                    ${description ? `<small class="text-muted">${description}</small>` : ''}
                                </div>`;
                    }
                },
                { 
                    "data": "tags_html",
                    "render": function(data, type, row) {
                        if (!data || data === '') {
                            return '<span class="text-muted">No tags</span>';
                        }
                        return `<div class="tags-container">${data}</div>`;
                    }
                },
                { 
                    "data": "is_active",
                    "render": function(data, type, row) {
                        if (view === 'trash' || row.deleted_at) {
                            return '<span class="badge badge-secondary">Deleted</span>';
                        }
                        let statusClass = data == 1 ? 'status-active' : 'status-inactive';
                        let statusText = data == 1 ? 'Active' : 'Inactive';
                        return `<div class="text-center">
                                    <span class="status-badge ${statusClass}">${statusText}</span>
                                    <button class="btn btn-sm btn-link toggle-status p-0 mt-1" data-id="${row.sticker_id}" data-status="${data}">
                                        <i class="fas fa-sync-alt fa-xs"></i>
                                    </button>
                                </div>`;
                    },
                    "className": "text-center"
                },
                { 
                    "data": view === 'trash' ? "deleted_at" : "created_at",
                    "render": function(data, type, row) {
                        if (!data) return 'N/A';
                        let date = new Date(data);
                        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                    }
                },
                {
                    "data": null,
                    "render": function (data, type, row) {
                        if (view === 'trash' || row.deleted_at) {
                            // Show restore and permanent delete buttons for trash
                            return `
                                <div class="action-buttons">
                                    <a href="#" title="Restore" class="restore-btn" data-id="${row.sticker_id}" style="color: #28a745;">
                                        <i class="fas fa-trash-restore" style="font-size: 18px;"></i>
                                    </a>
                                    <a href="#" title="Permanently Delete" class="force-delete-btn" data-id="${row.sticker_id}" style="color: #dc3545;">
                                        <i class="fas fa-trash-alt" style="font-size: 18px;"></i>
                                    </a>
                                </div>
                            `;
                        } else {
                            // Show view, edit, and soft delete buttons for active records
                            return `
                                <div class="action-buttons">
                                    <a href="#" title="View" class="view-btn" data-id="${row.sticker_id}" style="color: #92b0d0;">
                                        <i class="ti ti-eye" style="font-size: 18px;"></i>
                                    </a>
                                    <a href="/admin/edit-sticker/${row.sticker_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                        <i class="ti ti-pencil" style="font-size: 18px;"></i>
                                    </a>
                                    <a href="#" title="Move to Trash" class="delete-btn" data-id="${row.sticker_id}" style="color: #dc3545;">
                                        <i class="ti ti-trash" style="font-size: 18px;"></i>
                                    </a>
                                </div>
                            `;
                        }
                    },
                    "className": "text-center"
                }
            ],
            "order": [[0, 'desc']],
            "pageLength": 25,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('data-id', data.sticker_id);
            },
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "zeroRecords": view === 'trash' ? "No stickers in trash" : "No stickers found"
            }
        });
    }
    
    // Get trash count
    function updateTrashCount() {
        $.ajax({
            url: '/admin/stickermasterlist/getTrashCount',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let count = response.count || 0;
                    $('#trashCount').text(count);
                }
            },
            error: function() {
                console.log('Failed to get trash count');
                $('#trashCount').text('0');
            }
        });
    }
    
    // Toggle between active and trash views
    $('#showActiveBtn').on('click', function() {
        if (currentView === 'active') return;
        currentView = 'active';
        $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
        $('#showTrashBtn').removeClass('btn-danger').addClass('btn-outline-danger');
        initDataTable('active');
    });
    
    $('#showTrashBtn').on('click', function() {
        if (currentView === 'trash') return;
        currentView = 'trash';
        $(this).removeClass('btn-outline-danger').addClass('btn-danger');
        $('#showActiveBtn').removeClass('btn-primary active').addClass('btn-outline-primary');
        initDataTable('trash');
    });
    
    // View Sticker
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewStickerModal').modal('show');
        $('#stickerPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading sticker details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/stickermasterlist/getSticker/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayStickerPreview(response.data);
                } else {
                    $('#stickerPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load sticker details'}
                        </div>
                    `);
                }
            },
            error: function () {
                $('#stickerPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the sticker details.
                    </div>
                `);
            }
        });
    });
    
    function displayStickerPreview(sticker) {
        let sourceTypeText = sticker.is_external ? 'External URL' : 'Local Upload';
        let sourceIcon = sticker.is_external ? '<i class="fas fa-link"></i>' : '<i class="fas fa-upload"></i>';
        
        // For local images, construct full URL
        let displayUrl = sticker.is_external ? sticker.image_url : baseUrl + '/' + sticker.image_url;
        
        let deletedWarning = '';
        if (sticker.is_deleted) {
            deletedWarning = `
                <div class="alert alert-warning">
                    <i class="fas fa-trash"></i> 
                    <strong>This sticker is in the trash!</strong> Deleted on: ${sticker.deleted_at}
                </div>
            `;
        }
        
        let html = `
            <div class="sticker-preview-container">
                ${deletedWarning}
                <div class="row">
                    <div class="col-md-12">
                        <!-- Image Preview -->
                        <div class="sticker-preview-image">
                            <img src="${displayUrl}" alt="${escapeHtml(sticker.title)}" onerror="this.src='${baseUrl}assets/images/no-image.png'">
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="mb-3 text-center">${escapeHtml(sticker.title)}</h3>
                                
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Sticker ID:</th>
                                        <td>#${sticker.sticker_id}${sticker.is_deleted ? ' <span class="deleted-badge">Deleted</span>' : ''}</td>
                                    </tr>
                                    <tr>
                                        <th>Title:</th>
                                        <td><strong>${escapeHtml(sticker.title)}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Source Type:</th>
                                        <td>${sourceIcon} ${sourceTypeText}</td>
                                    </tr>
                                    <tr>
                                        <th>Image Path:</th>
                                        <td><code style="word-break: break-all;">${escapeHtml(sticker.image_url)}</code></td>
                                    </tr>
                                    ${sticker.tags_html ? `
                                    <tr>
                                        <th>Tags:</th>
                                        <td>${sticker.tags_html}</td>
                                    </tr>
                                    ` : ''}
                                    ${sticker.description ? `
                                    <tr>
                                        <th>Description:</th>
                                        <td>${sticker.description}</td>
                                    </tr>
                                    ` : ''}
                                    <tr>
                                        <th>Status:</th>
                                        <td>${sticker.status_badge}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>${sticker.created_at}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Updated:</th>
                                        <td>${sticker.updated_at}</td>
                                    </tr>
                                年table
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#stickerPreviewContent').html(html);
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Soft Delete (Move to Trash)
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Move to Trash?',
            text: "This sticker will be moved to trash. You can restore it later.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, move to trash!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Moving to trash...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/stickermasterlist/softDelete/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Moved to Trash!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                table.ajax.reload();
                                updateTrashCount();
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
    
    // Restore from trash
    $(document).on('click', '.restore-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Restore Sticker?',
            text: "This sticker will be restored and visible again.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, restore it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Restoring...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/stickermasterlist/restore/' + id,
                    method: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Restored!',
                                text: response.message,
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                table.ajax.reload();
                                updateTrashCount();
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
    
    // Permanently Delete
    $(document).on('click', '.force-delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Permanently Delete?',
            text: "This action cannot be undone! The sticker and its image file will be permanently deleted.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, permanently delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting permanently...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/stickermasterlist/forceDelete/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Permanently!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                table.ajax.reload();
                                updateTrashCount();
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
    
    // Toggle Status (Active/Inactive)
    $(document).on('click', '.toggle-status', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let currentStatus = $(this).data('status');
        
        Swal.fire({
            title: 'Toggle Status',
            text: `Are you sure you want to ${currentStatus == 1 ? 'deactivate' : 'activate'} this sticker?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, toggle it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/stickermasterlist/toggleStatus/' + id,
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
    
    // Initialize DataTable and trash count
    initDataTable('active');
    updateTrashCount();
});
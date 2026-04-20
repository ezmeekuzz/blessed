// File: assets/js/admin/messages.js
// Contact Messages JavaScript

$(document).ready(function () {
    // Initialize date range picker
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        placeholder: "Select date range"
    });
    
    let selectedIds = new Set();
    
    // Initialize DataTable
    let table = $('#contactmessageslist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/messages/getData",
            "type": "POST",
            "data": function(d) {
                d.status = $('#statusFilter').val();
                d.date_range = $('#dateRange').val();
                return d;
            },
            "dataSrc": function(json) {
                // Update stats cards
                if (json.stats) {
                    $('#unreadCount').text(json.stats.unread || 0);
                    $('#todayCount').text(json.stats.today || 0);
                    $('#totalCount').text(json.stats.total || 0);
                }
                return json.data || [];
            }
        },
        "columns": [
            {
                "data": "contact_id",
                "render": function(data, type, row) {
                    return `<input type="checkbox" class="message-checkbox" data-id="${data}">`;
                },
                "className": "text-center",
                "orderable": false
            },
            { 
                "data": "contact_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "name",
                "render": function(data, type, row) {
                    let name = escapeHtml(data || 'Anonymous');
                    let isUnread = row.status === 'unread';
                    return `<div class="${isUnread ? 'font-weight-bold' : ''}">
                                <i class="fas fa-user"></i> ${name}
                            </div>`;
                }
            },
            { 
                "data": "email",
                "render": function(data, type, row) {
                    let email = escapeHtml(data || '');
                    let isUnread = row.status === 'unread';
                    return `<div class="${isUnread ? 'font-weight-bold' : 'text-muted'}">
                                <i class="fas fa-envelope"></i> ${email}
                            </div>`;
                }
            },
            { 
                "data": "subject",
                "render": function(data, type, row) {
                    let subject = escapeHtml(data || 'No Subject');
                    if (subject.length > 40) {
                        subject = subject.substring(0, 40) + '...';
                    }
                    let isUnread = row.status === 'unread';
                    return `<div class="${isUnread ? 'font-weight-bold' : ''}">
                                ${subject}
                            </div>`;
                }
            },
            { 
                "data": "message",
                "render": function(data, type, row) {
                    let message = escapeHtml(data || '');
                    let preview = message.length > 80 ? message.substring(0, 80) + '...' : message;
                    return `<div class="message-preview" title="${message.replace(/"/g, '&quot;')}">
                                <i class="fas fa-comment"></i> ${preview}
                            </div>`;
                }
            },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    let status = data || 'unread';
                    let statusClass = status === 'unread' ? 'status-unread' : 'status-read';
                    let icon = status === 'unread' ? 'fa-envelope' : 'fa-check-circle';
                    return `<span class="status-badge ${statusClass}">
                                <i class="fas ${icon}"></i> ${status.toUpperCase()}
                            </span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    if (!data) return 'N/A';
                    let date = new Date(data);
                    let now = new Date();
                    let diff = now - date;
                    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    
                    if (days === 0) {
                        return `<span class="text-success"><i class="fas fa-clock"></i> Today ${date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>`;
                    } else if (days === 1) {
                        return `Yesterday ${date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
                    } else {
                        return `${date.toLocaleDateString()} ${date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
                    }
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="#" title="View Message" class="view-btn" data-id="${row.contact_id}" style="color: #007bff;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.contact_id}" style="color: #b91a0f;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                },
                "className": "text-center",
                "orderable": false
            }
        ],
        "order": [[7, 'desc']],
        "pageLength": 25,
        "responsive": true,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ messages",
            "infoEmpty": "Showing 0 to 0 of 0 messages",
            "zeroRecords": "No messages found"
        },
        "drawCallback": function() {
            // Reinitialize checkboxes after table redraw
            $('.message-checkbox').off('change').on('change', function() {
                let id = $(this).data('id');
                if ($(this).is(':checked')) {
                    selectedIds.add(id);
                } else {
                    selectedIds.delete(id);
                }
                updateBulkActionsBar();
            });
            
            // Update select all checkbox
            let allChecked = $('.message-checkbox:checked').length === $('.message-checkbox').length && $('.message-checkbox').length > 0;
            $('#selectAllCheckbox').prop('checked', allChecked);
        }
    });
    
    // Reload table when filters change
    $('#statusFilter, #dateRange').on('change', function() {
        selectedIds.clear();
        updateBulkActionsBar();
        table.ajax.reload();
    });
    
    // Reset filters
    $('#resetFiltersBtn').on('click', function() {
        $('#statusFilter').val('');
        $('#dateRange').val('');
        selectedIds.clear();
        updateBulkActionsBar();
        table.ajax.reload();
    });
    
    // Select All functionality
    $('#selectAllCheckbox').on('change', function() {
        let isChecked = $(this).is(':checked');
        $('.message-checkbox').each(function() {
            $(this).prop('checked', isChecked);
            let id = $(this).data('id');
            if (isChecked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
        });
        updateBulkActionsBar();
    });
    
    function updateBulkActionsBar() {
        let count = selectedIds.size;
        $('#selectedCount').text(count);
        if (count > 0) {
            $('#bulkActionsBar').addClass('show');
        } else {
            $('#bulkActionsBar').removeClass('show');
        }
    }
    
    // Bulk Mark as Read
    function bulkMarkAsRead() {
        if (selectedIds.size === 0) return;
        
        Swal.fire({
            title: 'Mark as Read',
            text: `Are you sure you want to mark ${selectedIds.size} message(s) as read?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, mark as read'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/messages/bulkMarkRead',
                    method: 'POST',
                    data: { ids: Array.from(selectedIds) },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            selectedIds.clear();
                            updateBulkActionsBar();
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    }
    
    // Bulk Delete
    function bulkDelete() {
        if (selectedIds.size === 0) return;
        
        Swal.fire({
            title: 'Delete Messages',
            text: `Are you sure you want to delete ${selectedIds.size} message(s)? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them'
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
                    url: '/admin/messages/bulkDelete',
                    method: 'POST',
                    data: { ids: Array.from(selectedIds) },
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                selectedIds.clear();
                                updateBulkActionsBar();
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
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
    }
    
    $('#bulkMarkReadBtn, #bulkMarkReadBtn2').on('click', bulkMarkAsRead);
    $('#bulkDeleteBtn, #bulkDeleteBtn2').on('click', bulkDelete);
    $('#clearSelectionBtn').on('click', function() {
        selectedIds.clear();
        $('#selectAllCheckbox').prop('checked', false);
        $('.message-checkbox').prop('checked', false);
        updateBulkActionsBar();
    });
    
    // View Message
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#messageModal').modal('show');
        $('#messageDetailContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading message details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/messages/getMessage/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayMessageDetail(response.data);
                    // Reload table to update status
                    table.ajax.reload(null, false);
                } else {
                    $('#messageDetailContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load message details'}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr);
                $('#messageDetailContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the message details.
                    </div>
                `);
            }
        });
    });
    
    function displayMessageDetail(message) {
        let statusClass = message.is_read == 0 ? 'status-unread' : 'status-read';
        
        let html = `
            <div class="message-detail-header">
                <h4 class="mb-2">${escapeHtml(message.subject || 'No Subject')}</h4>
                <div class="d-flex flex-wrap justify-content-between">
                    <span><i class="fas fa-user"></i> ${escapeHtml(message.name || 'Anonymous')}</span>
                    <span><i class="fas fa-envelope"></i> ${escapeHtml(message.email)}</span>
                    <span><i class="fas fa-calendar"></i> ${message.formatted_date || message.created_at}</span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-row">
                        <span class="message-detail-label"><i class="fas fa-tag"></i> Status:</span>
                        <span class="status-badge ${statusClass}">${message.is_read == 0 ? 'UNREAD' : 'READ'}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <span class="message-detail-label"><i class="fas fa-phone"></i> Phone:</span>
                        <span>${escapeHtml(message.phone) || '<span class="text-muted">Not provided</span>'}</span>
                    </div>
                </div>
            </div>
            
            <h6 class="mt-3"><i class="fas fa-comment-dots"></i> Message:</h6>
            <div class="message-content-box">
                ${escapeHtml(message.message || '').replace(/\n/g, '<br>')}
            </div>
        `;
        
        $('#messageDetailContent').html(html);
    }
    
    // Delete single message
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Delete Message',
            text: "Are you sure you want to delete this message? This action cannot be undone.",
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
                    url: '/admin/messages/delete/' + id,
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
                                selectedIds.delete(id);
                                updateBulkActionsBar();
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
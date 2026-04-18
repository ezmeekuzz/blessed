// File: assets/js/admin/subscribers-masterlist.js
// Newsletter Subscribers Masterlist JavaScript

$(document).ready(function () {
    // Initialize date range picker
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        placeholder: "Select date range"
    });
    
    // Initialize DataTable
    let table = $('#subscribersmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/subscribersmasterlist/getData",
            "type": "POST",
            "data": function(d) {
                // Add custom filter values
                d.status = $('#statusFilter').val();
                d.verified = $('#verifiedFilter').val();
                d.date_range = $('#dateRange').val();
                return d;
            },
            "dataSrc": function(json) {
                // Update stats cards
                if (json.stats) {
                    $('#totalSubscribers').text(json.stats.total || 0);
                    $('#activeSubscribers').text(json.stats.active || 0);
                    $('#verifiedSubscribers').text(json.stats.verified || 0);
                    $('#newThisMonth').text(json.stats.new_this_month || 0);
                }
                return json.data || [];
            }
        },
        "columns": [
            { 
                "data": "subscriber_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "email",
                "render": function(data, type, row) {
                    let email = escapeHtml(data);
                    return `<div class="subscriber-email-cell">
                                <i class="fas fa-envelope"></i> ${email}
                            </div>`;
                }
            },
            { 
                "data": "name",
                "render": function(data, type, row) {
                    if (!data || data === '') {
                        return '<span class="text-muted">—</span>';
                    }
                    let name = escapeHtml(data);
                    if (name.length > 30) {
                        name = name.substring(0, 30) + '...';
                    }
                    return `<div><i class="fas fa-user"></i> ${name}</div>`;
                }
            },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    let statusClass = '';
                    let statusText = '';
                    
                    switch(data) {
                        case 'active':
                            statusClass = 'status-active';
                            statusText = 'Active';
                            break;
                        case 'inactive':
                            statusClass = 'status-inactive';
                            statusText = 'Inactive';
                            break;
                        case 'pending':
                            statusClass = 'status-pending';
                            statusText = 'Pending';
                            break;
                        default:
                            statusClass = 'status-pending';
                            statusText = data || 'Pending';
                    }
                    
                    return `<span class="status-badge ${statusClass}">${statusText}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "is_verified",
                "render": function(data, type, row) {
                    let isVerified = parseInt(data) === 1;
                    return `<div class="text-center">
                                <span class="verified-badge ${isVerified ? 'verified-yes' : 'verified-no'}">
                                    <i class="fas ${isVerified ? 'fa-check-circle' : 'fa-clock'}"></i>
                                    ${isVerified ? 'Verified' : 'Not Verified'}
                                </span>
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "subscribed_at",
                "render": function(data, type, row) {
                    if (!data || data === '-0001-11-30 00:00:00') return 'N/A';
                    let date = new Date(data);
                    return `<span title="${date.toLocaleString()}">${date.toLocaleDateString()}</span>`;
                },
                "className": "text-center"
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="#" title="View" class="view-btn" data-id="${row.subscriber_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Edit Status" class="edit-status-btn" data-id="${row.subscriber_id}" data-status="${row.status}" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.subscriber_id}" style="color: #b91a0f;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                },
                "className": "text-center",
                "orderable": false
            }
        ],
        "order": [[5, 'desc']],
        "pageLength": 25,
        "responsive": true,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ subscribers",
            "infoEmpty": "Showing 0 to 0 of 0 subscribers",
            "zeroRecords": "No subscribers found"
        }
    });
    
    // Reload table when filters change
    $('#statusFilter, #verifiedFilter, #dateRange').on('change', function() {
        table.ajax.reload();
    });
    
    // Reset filters
    $('#resetFiltersBtn').on('click', function() {
        $('#statusFilter').val('');
        $('#verifiedFilter').val('');
        $('#dateRange').val('');
        table.ajax.reload();
    });
    
    // View Subscriber Details
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewSubscriberModal').modal('show');
        $('#subscriberDetailContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading subscriber details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/subscribersmasterlist/getSubscriber/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displaySubscriberDetails(response.data);
                } else {
                    $('#subscriberDetailContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load subscriber details'}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error("AJAX Error:", xhr);
                $('#subscriberDetailContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the subscriber details.
                    </div>
                `);
            }
        });
    });
    
    function displaySubscriberDetails(subscriber) {
        let statusClass = '';
        switch(subscriber.status) {
            case 'active': statusClass = 'status-active'; break;
            case 'inactive': statusClass = 'status-inactive'; break;
            default: statusClass = 'status-pending';
        }
        
        let verifiedHtml = subscriber.is_verified == 1 
            ? '<span class="verified-badge verified-yes"><i class="fas fa-check-circle"></i> Verified</span>'
            : '<span class="verified-badge verified-no"><i class="fas fa-clock"></i> Not Verified</span>';
        
        let html = `
            <div class="subscriber-details">
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-id-badge"></i> Subscriber ID:</span>
                    <span>#${subscriber.subscriber_id}</span>
                </div>
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-envelope"></i> Email Address:</span>
                    <span><strong>${escapeHtml(subscriber.email)}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-user"></i> Full Name:</span>
                    <span>${escapeHtml(subscriber.name) || '<span class="text-muted">Not provided</span>'}</span>
                </div>
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-flag-checkered"></i> Status:</span>
                    <span><span class="status-badge ${statusClass}">${subscriber.status || 'Pending'}</span></span>
                </div>
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-shield-alt"></i> Verification:</span>
                    <span>${verifiedHtml}</span>
                </div>
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-calendar-plus"></i> Subscribed Date:</span>
                    <span>${subscriber.subscribed_at || 'N/A'}</span>
                </div>
                ${subscriber.verified_at ? `
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-check-circle"></i> Verified Date:</span>
                    <span>${subscriber.verified_at}</span>
                </div>
                ` : ''}
                ${subscriber.unsubscribed_at ? `
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-sign-out-alt"></i> Unsubscribed Date:</span>
                    <span>${subscriber.unsubscribed_at}</span>
                </div>
                ` : ''}
                <div class="detail-row">
                    <span class="subscriber-detail-label"><i class="fas fa-globe"></i> IP Address:</span>
                    <span>${subscriber.ip_address || '<span class="text-muted">Not recorded</span>'}</span>
                </div>
            </div>
        `;
        
        $('#subscriberDetailContent').html(html);
    }
    
    // Edit Status Modal
    $(document).on('click', '.edit-status-btn', function () {
        let id = $(this).data('id');
        let currentStatus = $(this).data('status');
        
        Swal.fire({
            title: 'Update Subscriber Status',
            html: `
                <div class="text-left">
                    <p>Select the new status for this subscriber:</p>
                    <select id="newStatus" class="form-control">
                        <option value="active" ${currentStatus === 'active' ? 'selected' : ''}>Active</option>
                        <option value="inactive" ${currentStatus === 'inactive' ? 'selected' : ''}>Inactive</option>
                        <option value="pending" ${currentStatus === 'pending' ? 'selected' : ''}>Pending</option>
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update Status',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const newStatus = document.getElementById('newStatus').value;
                return { status: newStatus };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/subscribersmasterlist/updateStatus/' + id,
                    method: 'POST',
                    data: { status: result.value.status },
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
    
    // Delete Subscriber
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete this subscriber from the newsletter list. They will no longer receive emails.",
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
                    url: '/admin/subscribersmasterlist/delete/' + id,
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
    
    // Export CSV
    $('#exportCSVBtn').on('click', function() {
        let params = {
            status: $('#statusFilter').val(),
            verified: $('#verifiedFilter').val(),
            date_range: $('#dateRange').val(),
            format: 'csv'
        };
        
        window.location.href = '/admin/subscribersmasterlist/export?' + $.param(params);
    });
    
    // Export Excel
    $('#exportExcelBtn').on('click', function() {
        let params = {
            status: $('#statusFilter').val(),
            verified: $('#verifiedFilter').val(),
            date_range: $('#dateRange').val(),
            format: 'excel'
        };
        
        window.location.href = '/admin/subscribersmasterlist/export?' + $.param(params);
    });
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
$(document).ready(function () {
    let table = $('#customermasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/customermasterlist/getData",
            "type": "POST"
        },
        "columns": [
            { 
                "data": "user_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "fullname",
                "render": function(data, type, row) {
                    let name = escapeHtml(data);
                    if (name.length > 40) {
                        name = name.substring(0, 40) + '...';
                    }
                    return `<div class="customer-name-cell">
                                <strong>${name}</strong>
                                <div class="small text-muted mt-1">ID: ${row.user_id}</div>
                            </div>`;
                }
            },
            { 
                "data": "emailaddress",
                "render": function(data, type, row) {
                    let email = escapeHtml(data);
                    return `<div class="email-cell">
                                <a href="mailto:${email}">${email}</a>
                            </div>`;
                }
            },
            { 
                "data": "email_verified_badge",
                "render": function(data, type, row) {
                    return `<div class="text-center">
                                ${data}
                                <button class="btn btn-sm btn-link verify-toggle p-0 mt-1" data-id="${row.user_id}" data-verified="${row.email_verified}">
                                    <i class="fas fa-sync-alt fa-xs"></i>
                                </button>
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "status_badge",
                "render": function(data, type, row) {
                    return `<div class="text-center">
                                ${data}
                                <button class="btn btn-sm btn-link status-toggle p-0 mt-1" data-id="${row.user_id}" data-status="${row.status}">
                                    <i class="fas fa-sync-alt fa-xs"></i>
                                </button>
                            </div>`;
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
                            <a href="#" title="View" class="view-btn" data-id="${row.user_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-customer/${row.user_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.user_id}" style="color: #b91a0f;">
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
            $(row).attr('data-id', data.user_id);
        },
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "zeroRecords": "No customers found"
        }
    });

    // View Customer
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewCustomerModal').modal('show');
        $('#customerPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading customer details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/customermasterlist/getCustomer/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayCustomerPreview(response.data);
                } else {
                    $('#customerPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load customer details'}
                        </div>
                    `);
                }
            },
            error: function () {
                $('#customerPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the customer details.
                    </div>
                `);
            }
        });
    });
    
    function displayCustomerPreview(customer) {
        let html = `
            <div class="customer-preview-container">
                <div class="text-center mb-4">
                    <div class="avatar-circle" style="width: 80px; height: 80px; background-color: #3D204E; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                    <h4 class="mt-3">${escapeHtml(customer.fullname)}</h4>
                    <p class="text-muted">Customer ID: #${customer.user_id}</p>
                </div>
                
                <hr>
                
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">First Name:</th>
                        <td><strong>${escapeHtml(customer.firstname)}</strong></td>
                    </tr>
                    <tr>
                        <th>Last Name:</th>
                        <td><strong>${escapeHtml(customer.lastname)}</strong></td>
                    </tr>
                    <tr>
                        <th>Email Address:</th>
                        <td><a href="mailto:${escapeHtml(customer.emailaddress)}">${escapeHtml(customer.emailaddress)}</a></td>
                    </tr>
                    <tr>
                        <th>User Type:</th>
                        <td><span class="badge badge-info">${escapeHtml(customer.usertype)}</span></td>
                    </tr>
                    <tr>
                        <th>Email Verified:</th>
                        <td>${customer.email_verified_badge}</td>
                    </tr>
                    <tr>
                        <th>Account Status:</th>
                        <td>${customer.status_badge}</td>
                    </tr>
                    <tr>
                        <th>Date Registered:</th>
                        <td>${customer.created_at}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>${customer.updated_at}</td>
                    </tr>
                </table>
            </div>
        `;
        
        $('#customerPreviewContent').html(html);
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Toggle Status (Active/Inactive)
    $(document).on('click', '.status-toggle', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let currentStatus = $(this).data('status');
        
        Swal.fire({
            title: 'Toggle Account Status',
            text: `Are you sure you want to ${currentStatus == 1 ? 'deactivate' : 'activate'} this customer account?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, toggle it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/customermasterlist/toggleStatus/' + id,
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
    
    // Toggle Email Verification
    $(document).on('click', '.verify-toggle', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let currentStatus = $(this).data('verified');
        
        Swal.fire({
            title: 'Toggle Email Verification',
            text: `Are you sure you want to ${currentStatus == 1 ? 'mark as unverified' : 'mark as verified'} this customer's email?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, toggle it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/customermasterlist/toggleEmailVerification/' + id,
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
    
    // Delete Customer
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will permanently delete the customer account.",
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
                    url: '/admin/customermasterlist/delete/' + id,
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
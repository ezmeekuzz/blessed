$(document).ready(function () {
    let table = $('#productcategories').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/productcategories/getData",
            "type": "POST"
        },
        "columns": [
            { "data": "categoryname" },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    if (data == 'active') {
                        return '<span class="badge badge-success">Active</span>';
                    }
                    return '<span class="badge badge-secondary">Inactive</span>';
                }
            },
            { "data": "created_at" },
            { "data": "updated_at" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <a href="#" title="Edit" class="edit-btn mr-2" data-id="${row.product_category_id}" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.product_category_id}" style="color: red;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ],
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.product_category_id);
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });

    // Add Category Form Submission
    $('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        let categoryName = $('#categoryName').val().trim();
        
        if (categoryName === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please enter a category name!',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        // Show loading state
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we add the category',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/productcategories/insert',
            method: 'POST',
            data: {
                categoryname: categoryName
            },
            dataType: 'json',
            success: function(response) {
                Swal.close();
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close modal
                            $('#addCategoryModal').modal('hide');
                            // Reset form
                            $('#addCategoryForm')[0].reset();
                            // Reload DataTable
                            table.ajax.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                
                let errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    });

    // Edit Category - Open Modal
    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        
        // Show loading
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/productcategories/getCategory/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                Swal.close();
                
                if (response.status === 'success') {
                    // Populate the edit form
                    $('#editCategoryId').val(response.data.product_category_id);
                    $('#editCategoryName').val(response.data.categoryname);
                    $('#editCategoryStatus').val(response.data.status);
                    
                    // Show the modal
                    $('#editCategoryModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                
                let errorMessage = 'Something went wrong with the request!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    });
    
    // Edit Category Form Submission
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        let categoryId = $('#editCategoryId').val();
        let categoryName = $('#editCategoryName').val().trim();
        let status = $('#editCategoryStatus').val();
        
        if (categoryName === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please enter a category name!',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        // Show loading state
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait while we update the category',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '/admin/productcategories/update/' + categoryId,
            method: 'POST',
            data: {
                categoryname: categoryName,
                status: status
            },
            dataType: 'json',
            success: function(response) {
                Swal.close();
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Close modal
                            $('#editCategoryModal').modal('hide');
                            // Reset form
                            $('#editCategoryForm')[0].reset();
                            // Reload DataTable
                            table.ajax.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonColor: '#3085d6'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                
                let errorMessage = 'An error occurred. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    });

    // Delete Category
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: '/admin/productcategories/delete/' + id,
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
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        
                        let errorMessage = 'Something went wrong with the request!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errorMessage,
                            confirmButtonColor: '#3085d6'
                        });
                    }
                });
            }
        });
    });
});
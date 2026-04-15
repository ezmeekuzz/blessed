$(document).ready(function () {
    let table = $('#blogmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/blogmasterlist/getData",
            "type": "POST"
        },
        "columns": [
            { 
                "data": "title",
                "render": function(data, type, row) {
                    return `<strong>${escapeHtml(data)}</strong>`;
                }
            },
            { "data": "categoryname" },
            { 
                "data": "tags_html",
                "render": function(data, type, row) {
                    if (!data || data === '') {
                        return '<span class="text-muted">No tags</span>';
                    }
                    
                    // If tags_html is already formatted HTML, we'll need to process it
                    // Assuming tags_html comes as HTML string with tags
                    // Let's create a container with proper styling
                    return `<div class="tags-container">${data}</div>`;
                }
            },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    if (data === 'published') {
                        return '<span class="badge badge-success">Published</span>';
                    } else {
                        return '<span class="badge badge-warning">Draft</span>';
                    }
                }
            },
            { "data": "published_at" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <a href="#" title="View" class="view-btn mr-2" data-id="${row.blog_post_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-blog/${row.blog_post_id}" title="Edit" class="edit-btn mr-2" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn mr-2" data-id="${row.blog_post_id}" style="color: #b91a0f;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ],
        "order": [[0, 'desc']],
        "pageLength": 25,
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.blog_post_id);
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });

    // View Blog Post
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        // Show modal with loading state
        $('#viewBlogModal').modal('show');
        $('#blogPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading blog content...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/blogmasterlist/getBlog/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayBlogPreview(response.data);
                } else {
                    $('#blogPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load blog content'}
                        </div>
                    `);
                }
            },
            error: function () {
                $('#blogPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the blog content.
                    </div>
                `);
            }
        });
    });
    
    // Function to display blog preview
function displayBlogPreview(blog) {
    let imageHtml = '';
    if (blog.featured_image && blog.featured_image !== '') {
        imageHtml = `
            <div class="blog-hero mb-4">
                <img src="${baseUrl}/${blog.featured_image}" 
                     alt="${blog.title}" 
                     class="img-fluid w-100 rounded"
                     style="max-height: 450px; object-fit: cover;">
            </div>
        `;
    }

    let html = `
        <article class="blog-preview-container mx-auto" style="max-width: 800px;">

            ${imageHtml}

            <!-- Title -->
            <header class="mb-3">
                <h1 class="fw-bold">${blog.title}</h1>
                
                <!-- Meta Info -->
                <div class="text-muted small">
                    <span>
                        <i class="fas fa-calendar-alt"></i> ${blog.published_at}
                    </span>
                    <span class="mx-2">•</span>
                    <span>
                        <i class="fas fa-folder"></i> ${blog.categoryname}
                    </span>
                    ${blog.tags_html ? `
                        <span class="mx-2">•</span>
                        <span><i class="fas fa-tags"></i> ${blog.tags_html}</span>
                    ` : ''}
                </div>
            </header>

            <!-- Description / Intro -->
            ${blog.description ? `
                <section class="blog-intro mb-4">
                    <p class="lead text-secondary">
                        ${escapeHtml(blog.description)}
                    </p>
                </section>
            ` : ''}

            <!-- Content -->
            <section class="blog-content">
                <div class="blog-body" style="line-height: 1.8; font-size: 1.05rem;">
                    ${blog.content}
                </div>
            </section>

            <!-- Footer Meta -->
            <footer class="mt-5 pt-3 border-top text-muted small">
                <div>
                    <i class="fas fa-edit"></i> Last updated: ${blog.updated_at}
                </div>
                <div class="mt-1">
                    ${blog.status_badge}
                </div>
            </footer>

        </article>
    `;

    $('#blogPreviewContent').html(html);
}
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Delete Blog Post
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let row = $(this).closest('tr');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will also delete the featured image.",
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
                    url: '/admin/blogmasterlist/delete/' + id,
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
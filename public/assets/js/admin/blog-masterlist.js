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
                    let titleHtml = `<strong>${escapeHtml(data)}</strong>`;
                    if (row.excerpt_text) {
                        titleHtml += `<div class="small text-muted mt-1">${escapeHtml(row.excerpt_text.substring(0, 60))}...</div>`;
                    }
                    return titleHtml;
                }
            },
            { "data": "categoryname" },
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
                "data": "view_count",
                "render": function(data, type, row) {
                    let count = data || 0;
                    let icon = count > 0 ? '<i class="fas fa-eye"></i> ' : '<i class="far fa-eye"></i> ';
                    return `<span class="view-count">${icon}${count.toLocaleString()}</span>`;
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
                "data": "is_featured",
                "render": function(data, type, row) {
                    if (data == 1) {
                        return `<a href="#" class="featured-star toggle-featured" data-id="${row.blog_post_id}" title="Remove from featured">
                                    <i class="fas fa-star text-warning" style="font-size: 18px;"></i>
                                </a>`;
                    } else {
                        return `<a href="#" class="featured-star toggle-featured" data-id="${row.blog_post_id}" title="Mark as featured">
                                    <i class="far fa-star text-secondary" style="font-size: 18px;"></i>
                                </a>`;
                    }
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function (data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <a href="#" title="View" class="view-btn mr-2" data-id="${row.blog_post_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-blog/${row.blog_post_id}" title="Edit" class="edit-btn mr-2" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.blog_post_id}" style="color: #b91a0f;">
                                <i class="ti ti-trash" style="font-size: 18px;"></i>
                            </a>
                        </div>
                    `;
                }
            }
        ],
        "order": [[5, 'desc']],
        "pageLength": 25,
        "createdRow": function (row, data, dataIndex) {
            $(row).attr('data-id', data.blog_post_id);
        },
        "initComplete": function (settings, json) {
            $(this).trigger('dt-init-complete');
        }
    });

    // Toggle Featured Status
    $(document).on('click', '.toggle-featured', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let starIcon = $(this).find('i');
        
        $.ajax({
            url: '/admin/blogmasterlist/toggleFeatured/' + id,
            method: 'POST',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                starIcon.css('opacity', '0.5');
            },
            success: function (response) {
                if (response.status === 'success') {
                    // Reload the table to refresh the featured status
                    table.ajax.reload(null, false);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    starIcon.css('opacity', '1');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to update featured status'
                    });
                }
            },
            error: function() {
                starIcon.css('opacity', '1');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
            }
        });
    });

    // View Blog Post
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
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
                    <h1 class="fw-bold">${escapeHtml(blog.title)}</h1>
                    
                    <!-- Meta Info -->
                    <div class="text-muted small">
                        <span>
                            <i class="fas fa-calendar-alt"></i> ${blog.published_at}
                        </span>
                        <span class="mx-2">•</span>
                        <span>
                            <i class="fas fa-folder"></i> ${blog.categoryname}
                        </span>
                        <span class="mx-2">•</span>
                        <span>
                            <i class="fas fa-eye"></i> ${blog.view_count.toLocaleString()} views
                        </span>
                        ${blog.tags_html ? `
                            <span class="mx-2">•</span>
                            <span><i class="fas fa-tags"></i> ${blog.tags_html}</span>
                        ` : ''}
                        ${blog.featured_badge ? `
                            <span class="mx-2">•</span>
                            <span>${blog.featured_badge}</span>
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

                <!-- Excerpt -->
                ${blog.excerpt ? `
                    <section class="blog-excerpt mb-4 p-3 bg-light rounded">
                        <small class="text-muted">Excerpt:</small>
                        <p class="mb-0">${escapeHtml(blog.excerpt)}</p>
                    </section>
                ` : ''}

                <!-- Meta Keywords -->
                ${blog.meta_keywords ? `
                    <section class="blog-meta-keywords mb-3">
                        <small class="text-muted">Keywords:</small>
                        <div class="mt-1">${escapeHtml(blog.meta_keywords)}</div>
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
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
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
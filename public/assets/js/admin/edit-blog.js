$(document).ready(function () {
    // Summernote initialization
    if (typeof $('#content') !== 'undefined' && $.fn.summernote) {
        $('#content').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['picture', 'hr']],
                ['view', ['codeview']]
            ],
            tabsize: 2,
            height: 300
        });
    }
    
    // Initialize tags input if the plugin exists
    if ($('#tags').length && $.fn.tagsinput) {
        $('#tags').tagsinput({
            tagClass: 'badge badge-primary',
            confirmKeys: [13, 44],
            trimValue: true
        });
    }
    
    // Auto-generate slug from title
    $('#title').on('input', function() {
        let title = $(this).val();
        let slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        $('#slug').val(slug);
    });
    
    // Filter categories function
    window.filterCategories = function() {
        let input = $('#searchcategory').val().toLowerCase();
        $('#categorylist li').each(function() {
            let txtValue = $(this).text() || $(this).html();
            if (txtValue.toLowerCase().indexOf(input) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    };
    
    // Add event listener for search
    $('#searchcategory').on('keyup', filterCategories);
    
    // Handle category selection
    window.selectCategory = function(categoryId, categoryName) {
        $('#categorylist li').removeClass('active bg-primary text-white');
        $(`#categorylist li[data-id="${categoryId}"]`).addClass('active bg-primary text-white');
        $('#blog_category_id').val(categoryId);
    };
    
    // Image preview
    $('#featured_image').on('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Choose file';
        $(this).next('.custom-file-label').text(fileName);
        
        let file = e.target.files[0];
        let preview = $('#imagePreview');
        
        if (file && file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.html(`<img src="${e.target.result}" class="img-fluid rounded" alt="Preview" style="max-height: 150px;">`);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Fetch categories and set selected
    fetchCategories();
    
    function fetchCategories() {
        $.ajax({
            url: '/admin/editblog/getCategories',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(categories) {
                let categoryList = $('#categorylist');
                let selectedCategoryId = $('#blog_category_id').val();
                
                if (categories.length > 0) {
                    categoryList.empty();
                    categories.forEach(function(category) {
                        let isSelected = (category.blog_category_id == selectedCategoryId);
                        let li = $('<li>')
                            .addClass('list-group-item list-group-item-action')
                            .attr('data-id', category.blog_category_id)
                            .attr('onclick', `selectCategory(${category.blog_category_id}, '${escapeHtml(category.categoryname).replace(/'/g, "\\'")}')`)
                            .css('cursor', 'pointer')
                            .html(`
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>${escapeHtml(category.categoryname)}</span>
                                    <i class="fa fa-chevron-right text-muted"></i>
                                </div>
                            `);
                        
                        if (isSelected) {
                            li.addClass('active bg-primary text-white');
                        }
                        
                        categoryList.append(li);
                    });
                } else {
                    categoryList.html('<li class="list-group-item text-muted">No categories found.</li>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading categories:', error);
                $('#categorylist').html('<li class="list-group-item text-danger">Failed to load categories.</li>');
            }
        });
    }
    
    function escapeHtml(text) {
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Handle form submission with AJAX
    $('#editBlogForm').submit(function(event) {
        event.preventDefault();
        
        // Get Summernote content
        if ($('#content').summernote) {
            let content = $('#content').summernote('code');
            $('#content').val(content);
        }
        
        // Basic validation
        let title = $('#title').val() || '';
        let slug = $('#slug').val() || '';
        let blog_category_id = $('#blog_category_id').val() || '';
        let content = $('#content').val() || '';
        
        if (title.trim() === '' || slug.trim() === '' || blog_category_id.trim() === '' || content.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Title, Slug, Category and Content are required.',
            });
            return;
        }
        
        let blogId = $('#blog_id').val();
        let formData = new FormData(this);
        
        $.ajax({
            type: 'POST',
            url: '/admin/editblog/update/' + blogId,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Updating Blog Post...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.close();
                if (response.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Blog post updated successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to blog masterlist
                            window.location.href = '/admin/blog-masterlist';
                        }
                    });
                } else {
                    // Show error message from server
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: response.message || 'Failed to update blog post. Please check your input.',
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMessage = 'An unexpected error occurred. Please try again later.';
                
                // Try to parse error response
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    errorMessage = xhr.responseText;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: errorMessage,
                });
            }
        });
    });
    
    // Warn before leaving if changes were made
    let formChanged = false;
    
    $('#editBlogForm input, #editBlogForm textarea, #editBlogForm select').on('change', function() {
        formChanged = true;
    });
    
    $('#content').on('summernote.change', function() {
        formChanged = true;
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
    
    $('#editBlogForm').on('submit', function() {
        formChanged = false;
    });
});
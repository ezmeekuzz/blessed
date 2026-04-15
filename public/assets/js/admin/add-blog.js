// add-blog.js - Updated with AJAX submission similar to addportfolio.js

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
            height: 200
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
        let previewImg = preview.find('img');
        
        if (file && file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewImg.attr('src', e.target.result);
                preview.show();
            }
            reader.readAsDataURL(file);
        } else {
            preview.hide();
            previewImg.attr('src', '');
        }
    });
    
    // Fetch categories
    fetchCategories();
    
    function fetchCategories() {
        $.ajax({
            url: '/admin/addblog/categoryList',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                let categoryList = $('#categorylist');
                if (data.length > 0) {
                    categoryList.empty();
                    data.forEach(function(category) {
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
    $('#addblog').submit(function(event) {
        event.preventDefault();
        
        // Get Summernote content if Summernote is used
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
        
        let formData = new FormData(this);
        
        $.ajax({
            type: 'POST',
            url: '/admin/addblog/insert',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Saving Blog Post...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.close();
                if (response.success) {
                    // Reset form
                    $('#addblog')[0].reset();
                    
                    // Reset Summernote
                    if ($('#content').summernote) {
                        $('#content').summernote('reset');
                    }
                    
                    // Reset tags input
                    if ($('#tags').tagsinput) {
                        $('#tags').tagsinput('removeAll');
                    }
                    
                    // Reset image preview
                    $('#imagePreview').hide();
                    $('#imagePreview img').attr('src', '');
                    $('.custom-file-label').text('Choose file');
                    
                    // Reset category selection
                    $('#blog_category_id').val('');
                    $('#categorylist li').removeClass('active bg-primary text-white');
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Blog post created successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Optionally redirect or stay on page
                            window.location.href = '/admin/add-blog';
                        }
                    });
                } else {
                    // Show error message from server
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: response.message || 'Failed to create blog post. Please check your input.',
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
});
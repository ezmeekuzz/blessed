// add-blog.js - Complete updated version with all fields

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
                ['insert', ['picture', 'link', 'hr']],
                ['view', ['codeview', 'fullscreen']]
            ],
            tabsize: 2,
            height: 300,
            placeholder: 'Write your blog content here...'
        });
    }
    
    // Character count for meta description
    $('#description').on('input', function() {
        let count = $(this).val().length;
        $('#descCount').text(count);
        if (count > 160) {
            $('#descCount').addClass('text-danger').removeClass('text-muted');
        } else {
            $('#descCount').removeClass('text-danger').addClass('text-muted');
        }
    });
    
    // Trigger initial count
    $('#description').trigger('input');
    
    // Auto-generate slug from title
    let isSlugManuallyEdited = false;
    
    $('#title').on('input', function() {
        if (!isSlugManuallyEdited) {
            let title = $(this).val();
            let slug = title.toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            $('#slug').val(slug);
            checkSlugUniqueness(slug);
        }
    });
    
    $('#slug').on('input', function() {
        isSlugManuallyEdited = true;
        let slug = $(this).val();
        checkSlugUniqueness(slug);
    });
    
    function checkSlugUniqueness(slug) {
        if (slug.length < 3) return;
        
        $.ajax({
            url: '/admin/addblog/checkSlug',
            type: 'POST',
            data: { slug: slug },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.exists) {
                    $('#slugError').show();
                    $('#slug').addClass('is-invalid');
                } else {
                    $('#slugError').hide();
                    $('#slug').removeClass('is-invalid');
                }
            }
        });
    }
    
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
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Image size should not exceed 2MB.'
                });
                $(this).val('');
                $(this).next('.custom-file-label').text('Choose file');
                preview.hide();
                return;
            }
            
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
    
    // Tags input initialization
    if ($.fn.tagsinput) {
        $('#tags').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44],
            tagClass: 'badge badge-primary m-1'
        });
    }
    
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
        
        // Get Summernote content
        if ($('#content').summernote) {
            let content = $('#content').summernote('code');
            $('#content').val(content);
        }
        
        // Get tags value
        if ($('#tags').tagsinput) {
            let tags = $('#tags').tagsinput('items');
            $('#tags').val(tags.join(','));
        }
        
        // Basic validation
        let title = $('#title').val() || '';
        let slug = $('#slug').val() || '';
        let blog_category_id = $('#blog_category_id').val() || '';
        let content = $('#content').val() || '';
        
        if (title.trim() === '') {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Title is required.' });
            return;
        }
        
        if (slug.trim() === '') {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Slug is required.' });
            return;
        }
        
        if (blog_category_id.trim() === '') {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select a category.' });
            return;
        }
        
        if (content.trim() === '' || content === '<p><br></p>') {
            Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Content is required.' });
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
                $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
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
                $('#submitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Publish Blog');
                
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
                    
                    // Reset slug manual edit flag
                    isSlugManuallyEdited = false;
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Blog post created successfully!',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/add-blog';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: response.message || 'Failed to create blog post. Please check your input.',
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                $('#submitBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Publish Blog');
                
                let errorMessage = 'An unexpected error occurred. Please try again later.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        let response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch(e) {
                        errorMessage = xhr.responseText;
                    }
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
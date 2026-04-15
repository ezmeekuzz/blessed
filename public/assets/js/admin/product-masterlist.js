$(document).ready(function () {
    let table = $('#productmasterlist').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/productmasterlist/getData",
            "type": "POST"
        },
        "columns": [
            { 
                "data": "product_id",
                "render": function(data, type, row) {
                    return `<span class="badge badge-secondary">#${data}</span>`;
                },
                "className": "text-center"
            },
            { 
                "data": "thumbnail",
                "render": function(data, type, row) {
                    return `<img src="${data}" class="product-thumbnail" alt="${escapeHtml(row.product_name)}" onerror="this.src='${baseUrl}assets/images/no-image.png'">`;
                },
                "className": "text-center"
            },
            { 
                "data": "product_name",
                "render": function(data, type, row) {
                    // Truncate product name if too long
                    let productName = escapeHtml(data);
                    if (productName.length > 50) {
                        productName = productName.substring(0, 50) + '...';
                    }
                    let excerpt = escapeHtml(row.excerpt);
                    if (excerpt.length > 60) {
                        excerpt = excerpt.substring(0, 60) + '...';
                    }
                    return `<div class="product-name-cell">
                                <strong>${productName}</strong>
                                ${excerpt ? `<small class="text-muted">${excerpt}</small>` : ''}
                            </div>`;
                }
            },
            { 
                "data": "categoryname",
                "render": function(data, type, row) {
                    return `<span class="category-cell">${escapeHtml(data)}</span>`;
                }
            },
            { 
                "data": "price_range",
                "render": function(data, type, row) {
                    if (!data || data === '') {
                        return '<span class="text-muted">No price</span>';
                    }
                    return `<span class="price-range">${data}</span>`;
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
                "data": "is_featured_badge",
                "render": function(data, type, row) {
                    return `<div class="text-center">
                                ${data}
                                <button class="btn btn-sm btn-link toggle-featured p-0 mt-1" data-id="${row.product_id}" data-featured="${row.is_featured}">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>`;
                },
                "className": "text-center"
            },
            { 
                "data": "created_at",
                "render": function(data, type, row) {
                    if (!data) return 'N/A';
                    // Format date to show only date if needed
                    let date = new Date(data);
                    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                }
            },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <div class="action-buttons">
                            <a href="#" title="View" class="view-btn" data-id="${row.product_id}" style="color: #92b0d0;">
                                <i class="ti ti-eye" style="font-size: 18px;"></i>
                            </a>
                            <a href="/admin/edit-product/${row.product_id}" title="Edit" class="edit-btn" style="color: #007bff;">
                                <i class="ti ti-pencil" style="font-size: 18px;"></i>
                            </a>
                            <a href="#" title="Delete" class="delete-btn" data-id="${row.product_id}" style="color: #b91a0f;">
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
            $(row).attr('data-id', data.product_id);
        },
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "zeroRecords": "No products found"
        }
    });

    // Rest of your functions remain the same...
    // (view product, displayProductPreview, escapeHtml, toggle featured, delete)
    
    // View Product
    $(document).on('click', '.view-btn', function () {
        let id = $(this).data('id');
        
        $('#viewProductModal').modal('show');
        $('#productPreviewContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Loading product details...</p>
            </div>
        `);
        
        $.ajax({
            url: '/admin/productmasterlist/getProduct/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    displayProductPreview(response.data);
                } else {
                    $('#productPreviewContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            ${response.message || 'Failed to load product details'}
                        </div>
                    `);
                }
            },
            error: function () {
                $('#productPreviewContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        An error occurred while loading the product details.
                    </div>
                `);
            }
        });
    });
    
    function displayProductPreview(product) {
        let imagesArray = [];
        
        // Get all product images
        if (product.images && product.images.length > 0) {
            imagesArray = product.images;
        }
        
        // Build main carousel HTML
        let carouselHtml = '';
        if (imagesArray.length > 0) {
            carouselHtml = `
                <div class="product-carousel-container">
                    <div id="productImageCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            ${imagesArray.map((image, index) => `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="${baseUrl}/${image.file_path}" class="d-block w-100 rounded" alt="Product image ${index + 1}" style="height: 400px; object-fit: cover;">
                                </div>
                            `).join('')}
                        </div>
                        ${imagesArray.length > 1 ? `
                        <a class="carousel-control-prev" href="#productImageCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productImageCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        ` : ''}
                    </div>
                    
                    ${imagesArray.length > 1 ? `
                    <!-- Horizontal scrolling thumbnails -->
                    <div class="thumbnail-scroll-container mt-3">
                        <div class="thumbnail-scroll-wrapper">
                            <button type="button" class="scroll-btn scroll-left" style="display: none;">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="thumbnail-scroll" id="thumbnailScroll">
                                ${imagesArray.map((image, index) => `
                                    <div class="thumbnail-item ${index === 0 ? 'active' : ''}" data-slide-index="${index}">
                                        <img src="${baseUrl}/${image.file_path}" alt="Thumbnail ${index + 1}">
                                    </div>
                                `).join('')}
                            </div>
                            <button type="button" class="scroll-btn scroll-right" style="display: none;">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
        } else {
            carouselHtml = `<div class="bg-light text-center py-5 rounded">
                                <i class="fas fa-image fa-4x text-muted"></i>
                                <p class="mt-2 text-muted">No product image</p>
                            </div>`;
        }
        
        let html = `
            <div class="product-preview-container">
                <div class="row">
                    <div class="col-md-6">
                        ${carouselHtml}
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-2">${escapeHtml(product.product_name)}</h2>
                        
                        <div class="mb-3">
                            ${product.is_featured_badge}
                        </div>
                        
                        <div class="mb-3">
                            <span class="text-muted"><i class="fas fa-folder"></i> Category:</span>
                            <strong>${escapeHtml(product.categoryname)}</strong>
                        </div>
                        
                        ${product.tags_html ? `
                        <div class="mb-3">
                            <span class="text-muted"><i class="fas fa-tags"></i> Tags:</span>
                            <div class="mt-1">${product.tags_html}</div>
                        </div>
                        ` : ''}
                        
                        <div class="mb-3">
                            <span class="text-muted"><i class="fas fa-calendar-alt"></i> Created:</span>
                            ${product.created_at}
                        </div>
                        
                        <div class="mb-3">
                            <span class="text-muted"><i class="fas fa-edit"></i> Last Updated:</span>
                            ${product.updated_at}
                        </div>
                        
                        <div class="mb-3">
                            <span class="text-muted"><i class="fas fa-chart-line"></i> Stats:</span>
                            <div class="mt-1">
                                <span class="badge badge-info">${product.size_count} Sizes</span>
                                <span class="badge badge-success">${product.color_count} Colors</span>
                                <span class="badge badge-warning">${product.image_count} Images</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                ${product.description ? `
                <div class="row mt-4">
                    <div class="col-12">
                        <h5><i class="fas fa-align-left"></i> Description</h5>
                        <div class="card">
                            <div class="card-body">
                                ${product.description}
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h5><i class="fas fa-tags"></i> Sizes & Pricing</h5>
                        ${product.sizes_html}
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <h5><i class="fas fa-palette"></i> Color Variants</h5>
                        <div class="mt-2">${product.colors_html}</div>
                    </div>
                </div>
            </div>
        `;
        
        $('#productPreviewContent').html(html);
        
        // Initialize carousel if there are multiple images
        if (imagesArray.length > 1) {
            $('#productImageCarousel').carousel();
            
            // Update thumbnail active state when slide changes
            $('#productImageCarousel').on('slide.bs.carousel', function (e) {
                const index = e.to;
                $('.thumbnail-item').removeClass('active');
                $(`.thumbnail-item[data-slide-index="${index}"]`).addClass('active');
                
                // Scroll thumbnail into view
                const thumbnail = $(`.thumbnail-item[data-slide-index="${index}"]`)[0];
                if (thumbnail) {
                    thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                }
            });
            
            // Click on thumbnail to navigate
            $('.thumbnail-item').on('click', function() {
                const index = $(this).data('slide-index');
                $('#productImageCarousel').carousel(index);
            });
            
            // Initialize thumbnail scroll functionality
            initThumbnailScroll();
        }
        
        // Function to go to specific slide (keep for backward compatibility)
        window.goToSlide = function(index) {
            $('#productImageCarousel').carousel(index);
        };
    }

    // Initialize horizontal thumbnail scrolling
    function initThumbnailScroll() {
        const scrollContainer = document.querySelector('.thumbnail-scroll');
        const scrollLeftBtn = document.querySelector('.scroll-left');
        const scrollRightBtn = document.querySelector('.scroll-right');
        
        if (!scrollContainer) return;
        
        // Function to check if scrolling is needed and show/hide buttons
        function checkScrollButtons() {
            if (!scrollLeftBtn || !scrollRightBtn) return;
            
            const hasScroll = scrollContainer.scrollWidth > scrollContainer.clientWidth;
            
            if (!hasScroll) {
                scrollLeftBtn.style.display = 'none';
                scrollRightBtn.style.display = 'none';
                return;
            }
            
            scrollLeftBtn.style.display = 'flex';
            scrollRightBtn.style.display = 'flex';
            
            // Check if at start
            if (scrollContainer.scrollLeft <= 0) {
                scrollLeftBtn.style.opacity = '0.5';
                scrollLeftBtn.disabled = true;
            } else {
                scrollLeftBtn.style.opacity = '1';
                scrollLeftBtn.disabled = false;
            }
            
            // Check if at end
            if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 5) {
                scrollRightBtn.style.opacity = '0.5';
                scrollRightBtn.disabled = true;
            } else {
                scrollRightBtn.style.opacity = '1';
                scrollRightBtn.disabled = false;
            }
        }
        
        // Scroll left
        if (scrollLeftBtn) {
            scrollLeftBtn.addEventListener('click', function() {
                scrollContainer.scrollBy({ left: -200, behavior: 'smooth' });
                setTimeout(checkScrollButtons, 300);
            });
        }
        
        // Scroll right
        if (scrollRightBtn) {
            scrollRightBtn.addEventListener('click', function() {
                scrollContainer.scrollBy({ left: 200, behavior: 'smooth' });
                setTimeout(checkScrollButtons, 300);
            });
        }
        
        // Check scroll on scroll event
        scrollContainer.addEventListener('scroll', checkScrollButtons);
        
        // Initial check
        setTimeout(checkScrollButtons, 100);
        window.addEventListener('resize', checkScrollButtons);
    }

    // Function to go to specific slide
    window.goToSlide = function(index) {
        $('#productImageCarousel').carousel(index);
    };
    
    window.updateMainImage = function(element, imageUrl) {
        $('#mainImageContainer').html(`<img src="${imageUrl}" alt="Product image" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">`);
        $('.product-gallery img').removeClass('active');
        $(element).addClass('active');
    };
    
    function escapeHtml(text) {
        if (!text) return '';
        let div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Toggle Featured Status
    $(document).on('click', '.toggle-featured', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let isFeatured = $(this).data('featured');
        let btn = $(this);
        
        Swal.fire({
            title: 'Toggle Featured Status',
            text: `Are you sure you want to ${isFeatured == 1 ? 'remove from' : 'mark as'} featured?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, toggle it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/productmasterlist/toggleFeatured/' + id,
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
    
    // Delete Product
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this! This will also delete all associated images, sizes, and colors.",
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
                    url: '/admin/productmasterlist/delete/' + id,
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
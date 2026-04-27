// Product Details Module - Optimized & Professional
(function($) {
    'use strict';
    
    // Product Details Module
    const ProductDetails = {
        // Configuration
        config: {
            currentColorId: null,
            currentSizeId: null,
            cache: {},
            debounceTimer: null,
            isLoggedIn: false,
            productSlug: null,
            productId: null
        },
        
        // DOM Elements Cache
        elements: {},
        
        // Initialize module
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.checkLoginStatus().then(() => {
                this.loadProductData();
            });
        },
        
        // Cache DOM elements for performance
        cacheElements: function() {
            this.elements = {
                breadcrumbs: $('#breadCrumbs'),
                productName: $('#productName'),
                productDescription: $('#productDescription'),
                productPrice: $('#productPrice'),
                productImages: $('#productImages'),
                colorLists: $('#colorLists'),
                sizeLists: $('#sizeLists'),
                otherProducts: $('#otherProducts'),
                accordionDesc: $('#accordionDescription'),
                startDesigningBtn: $('#startDesigningBtn')
            };
        },
        
        // Bind global events
        bindEvents: function() {
            // Share button functionality
            $(document).on('click', '.share-icon', () => this.shareProduct());
            
            // Wishlist functionality
            $(document).on('click', '.wishlist-btn', (e) => this.toggleWishlist($(e.currentTarget)));
            
            // Start designing button click handler
            if (this.elements.startDesigningBtn.length) {
                this.elements.startDesigningBtn.off('click').on('click', (e) => this.handleStartDesigning(e));
            }
        },
        
        // Check if user is logged in via AJAX
        checkLoginStatus: function() {
            return this.ajaxRequest('/product-details/checkLoginStatus', {})
                .then(response => {
                    this.config.isLoggedIn = response.logged_in;
                    return response;
                })
                .catch(error => {
                    console.error('Error checking login status:', error);
                    this.config.isLoggedIn = false;
                    return { logged_in: false };
                });
        },
        
        // Handle Start Designing button click
        handleStartDesigning: function(e) {
            e.preventDefault();
            
            // Get the current product slug
            const productSlug = this.config.productSlug || this.getProductSlug();
            const customizeUrl = `/customize-design/${productSlug}`;
            
            if (this.config.isLoggedIn) {
                // User is logged in, redirect to customize page
                window.location.href = customizeUrl;
            } else {
                // User is not logged in, show SweetAlert2 popup with close button
                Swal.fire({
                    title: '<span style="color: #3D204E;">Login Required</span>',
                    html: `
                        <div style="text-align: left;">
                            <p style="color: #666; margin-bottom: 20px;">
                                Please login or create an account to start designing your product.
                            </p>
                            <div style="background: #f8f4fa; padding: 15px; border-radius: 12px; margin-top: 10px;">
                                <p style="color: #3D204E; font-weight: 600; margin-bottom: 10px;">✨ Benefits of creating an account:</p>
                                <ul style="color: #666; list-style: none; padding-left: 0; margin-bottom: 0;">
                                    <li style="margin-bottom: 8px;">✓ Save your designs</li>
                                    <li style="margin-bottom: 8px;">✓ Track orders easily</li>
                                    <li style="margin-bottom: 8px;">✓ Get exclusive offers</li>
                                    <li style="margin-bottom: 8px;">✓ Faster checkout process</li>
                                </ul>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    iconColor: '#3D204E',
                    showCancelButton: true,
                    showCloseButton: true, // Add close button (X) in top right
                    confirmButtonColor: '#3D204E',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Login Now',
                    cancelButtonText: 'Create Account',
                    backdrop: true,
                    allowOutsideClick: true, // Allow clicking outside to close
                    allowEscapeKey: true,    // Allow ESC key to close
                    customClass: {
                        popup: 'rounded-4',
                        title: 'fs-4 fw-bold',
                        confirmButton: 'px-4 py-2 rounded-pill',
                        cancelButton: 'px-4 py-2 rounded-pill',
                        closeButton: 'text-purple' // Style the close button
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked Login Now
                        sessionStorage.setItem('redirectAfterLogin', window.location.href);
                        window.location.href = '/login';
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // User clicked Create Account
                        sessionStorage.setItem('redirectAfterLogin', window.location.href);
                        window.location.href = '/register';
                    }
                    // If user clicks close button (X) or clicks outside or presses ESC, just close the modal
                });
            }
        },
        
        // Helper method to get product slug
        getProductSlug: function() {
            // Get slug from URL
            const urlParts = window.location.pathname.split('/');
            const slugFromUrl = urlParts[urlParts.length - 1];
            
            // If you have it in the page data
            if (typeof productSlug !== 'undefined' && productSlug) {
                return productSlug;
            }
            
            return slugFromUrl;
        },
        
        // Share product
        shareProduct: function() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href);
                this.showNotification('Link copied to clipboard!', 'success');
            }
        },
        
        // Toggle wishlist
        toggleWishlist: function($btn) {
            if (!this.config.isLoggedIn) {
                this.showLoginPromptForWishlist();
                return;
            }
            
            $btn.toggleClass('active');
            const icon = $btn.find('i');
            icon.toggleClass('bi-heart bi-heart-fill');
            this.showNotification(icon.hasClass('bi-heart-fill') ? 'Added to wishlist' : 'Removed from wishlist', 'success');
        },
        
        // Show login prompt for wishlist (closeable)
        showLoginPromptForWishlist: function() {
            Swal.fire({
                title: '<span style="color: #3D204E;">Login Required</span>',
                html: '<p style="color: #666;">Please login to add items to your wishlist.</p>',
                icon: 'info',
                iconColor: '#3D204E',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: '#3D204E',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Login',
                cancelButtonText: 'Cancel',
                allowOutsideClick: true,
                allowEscapeKey: true,
                customClass: {
                    popup: 'rounded-4',
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    sessionStorage.setItem('redirectAfterLogin', window.location.href);
                    window.location.href = '/login';
                }
                // If user closes, just dismiss
            });
        },
        
        // Load all product data
        loadProductData: function() {
            if (!this.config.productId) {
                this.showNotification('Product ID is missing', 'error');
                return;
            }
            
            this.showSkeletonLoaders();
            this.getProductDetails();
            this.getOtherProducts();
        },
        
        // Fetch product details
        getProductDetails: function() {
            this.ajaxRequest('/product-details/getData', { product_id: this.config.productId })
                .then(response => this.renderProductDetails(response))
                .catch(error => this.handleError(error, 'Failed to load product details'));
        },
        
        // Fetch product images by color
        getProductImages: function(colorId = null) {
            const data = { product_id: this.config.productId };
            if (colorId) data.color_id = colorId;
            
            return this.ajaxRequest('/product-details/getProductColorImages', data);
        },
        
        // Fetch product colors
        getProductColors: function() {
            return this.ajaxRequest('/product-details/getProductColors', { product_id: this.config.productId });
        },
        
        // Fetch product sizes
        getProductSizes: function() {
            return this.ajaxRequest('/product-details/getProductSizes', { product_id: this.config.productId });
        },
        
        // Fetch other products
        getOtherProducts: function() {
            this.showOtherProductsSkeleton();
            this.ajaxRequest('/product-details/otherProducts', { product_id: this.config.productId })
                .then(response => this.renderOtherProducts(response))
                .catch(() => this.renderNoOtherProducts());
        },
        
        // Generic AJAX request with promise
        ajaxRequest: function(url, data) {
            return $.ajax({
                url: url,
                method: 'GET',
                data: data,
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                timeout: 10000 // 10 second timeout
            });
        },
        
        // Render product details
        renderProductDetails: function(response) {
            if (!response) return;
            
            // Store product slug for later use
            this.config.productSlug = response.slug;
            
            this.renderBreadcrumbs(response);
            this.renderProductName(response);
            this.renderProductDescription(response);
            
            // Load dependent data in parallel
            Promise.all([
                this.getProductImages(),
                this.getProductColors(),
                this.getProductSizes()
            ]).then(([images, colors, sizes]) => {
                this.renderProductImages(images);
                this.renderColors(colors);
                this.renderSizes(sizes);
            }).catch(error => console.error('Error loading product data:', error));
        },
        
        // Render breadcrumbs
        renderBreadcrumbs: function(data) {
            const html = `
                <div class="d-flex justify-content-between align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mb-0 fs-5">
                            <li class="breadcrumb-item"><a href="/products">Products</a></li>
                            <li class="breadcrumb-item active">${this.escapeHtml(data.categoryname || 'Category')}</li>
                            <li class="breadcrumb-item active">${this.escapeHtml(data.product_name || 'Product')}</li>
                        </ol>
                    </nav>
                    <div class="share-icon d-flex align-items-center gap-1" style="cursor: pointer;">
                        <i class="bi bi-share"></i> <span class="fs-6 fw-light">Share</span>
                    </div>
                </div>
            `;
            this.elements.breadcrumbs.html(html);
        },
        
        // Render product name
        renderProductName: function(data) {
            this.elements.productName.text(this.escapeHtml(data.product_name || 'Product Name'));
        },
        
        // Render product description
        renderProductDescription: function(data) {
            const description = this.escapeHtml(data.description || 'Product Description');
            this.elements.productDescription.html(description);
            this.elements.accordionDesc.html(description);
        },
        
        // Render product images
        renderProductImages: function(response) {
            if (!response || response.error) {
                this.elements.productImages.html('<div class="alert alert-warning">No images available</div>');
                return;
            }
            
            const imageData = Array.isArray(response) ? response[0] : response;
            const frontImage = imageData.front_image ? `/${imageData.front_image}` : '/default-image.jpg';
            const backImage = imageData.back_image ? `/${imageData.back_image}` : null;
            
            const html = `
                <div class="product-img-large position-relative">
                    <img src="${frontImage}" alt="Product Image" class="img-square w-100" style="aspect-ratio: 1/1; object-fit: cover; border-radius: 28px;" onerror="this.src='/default-image.jpg'">
                    <button class="wishlist-btn btn position-absolute top-0 end-0 m-3 p-2 rounded-circle bg-white border-0 shadow-sm" style="width: 45px; height: 45px;">
                        <i class="bi bi-heart fs-5" style="color: #3D204E;"></i>
                    </button>
                </div>
                <div class="d-flex gap-3 mt-3">
                    <img src="${frontImage}" alt="Front" class="thumb-img active" onerror="this.src='/default-thumb.jpg'" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; cursor: pointer;">
                    ${backImage ? `<img src="${backImage}" alt="Back" class="thumb-img" onerror="this.src='/default-thumb.jpg'" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; cursor: pointer;">` : ''}
                </div>
            `;
            
            this.elements.productImages.html(html);
            this.initThumbnailClick();
        },
        
        // Initialize thumbnail click handler
        initThumbnailClick: function() {
            $('.thumb-img').off('click').on('click', function() {
                $('.thumb-img').removeClass('active');
                $(this).addClass('active');
                $('.product-img-large img').attr('src', $(this).attr('src'));
            });
        },
        
        // Render color options
        renderColors: function(colors) {
            if (!colors || colors.error || colors.length === 0) {
                this.elements.colorLists.html('<p class="text-muted">No color variations available</p>');
                return;
            }
            
            let html = '<div class="d-flex gap-2 flex-wrap">';
            colors.forEach(color => {
                const isDefault = color.is_default == 1;
                if (isDefault) this.config.currentColorId = color.color_id;
                
                html += `
                    <div class="color-option ${isDefault ? 'active' : ''}" 
                         data-color-id="${color.color_id}"
                         data-color-hex="${color.color_hex || '#ccc'}"
                         style="width: 40px; height: 40px; background-color: ${color.color_hex || '#ccc'}; border-radius: 50%; cursor: pointer; border: 2px solid ${isDefault ? '#3D204E' : 'transparent'}; transition: all 0.2s;">
                        <span class="visually-hidden">${this.escapeHtml(color.color_name || 'Color')}</span>
                    </div>
                `;
            });
            html += '</div>';
            
            this.elements.colorLists.html(html);
            this.initColorClick();
        },
        
        // Initialize color click handler
        initColorClick: function() {
            $('.color-option').off('click').on('click', async (e) => {
                const $target = $(e.currentTarget);
                const colorId = $target.data('color-id');
                
                $('.color-option').css('border', '2px solid transparent');
                $target.css('border', '2px solid #3D204E');
                
                if (this.config.currentColorId === colorId) return;
                this.config.currentColorId = colorId;
                
                // Show loading state
                this.elements.productImages.html('<div class="skeleton-image" style="width: 100%; height: 400px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 28px;"></div>');
                
                const images = await this.getProductImages(colorId);
                this.renderProductImages(images);
            });
        },
        
        // Render size options
        renderSizes: function(sizes) {
            if (!sizes || sizes.error) {
                this.elements.sizeLists.html('<p class="text-danger">Failed to load sizes</p>');
                return;
            }
            
            if (!sizes.length) {
                this.elements.sizeLists.html('<p class="text-muted">No size options available</p>');
                return;
            }
            
            let html = '<div class="d-flex gap-2 flex-wrap">';
            let defaultPrice = "0.00";
            
            sizes.forEach(size => {
                const isDefault = size.is_default == 1;
                if (isDefault) {
                    defaultPrice = size.price || "0.00";
                    this.config.currentSizeId = size.size_id;
                }
                
                html += `
                    <span class="size-badge ${isDefault ? 'active' : ''}" 
                          data-size-id="${size.size_id}"
                          data-price="${size.price || 0}"
                          style="cursor: pointer; padding: 8px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; transition: all 0.2s; ${isDefault ? 'background-color: #3D204E; color: #fff; border-color: #3D204E;' : 'background-color: #fff; color: #333;'}">
                        ${this.escapeHtml(size.size)} ${this.escapeHtml(size.unit_of_measure)}
                    </span>
                `;
            });
            html += '</div>';
            
            this.elements.sizeLists.html(html);
            this.elements.productPrice.text('$' + parseFloat(defaultPrice).toFixed(2));
            this.initSizeClick();
        },
        
        // Initialize size click handler
        initSizeClick: function() {
            $('.size-badge').off('click').on('click', (e) => {
                const $target = $(e.currentTarget);
                const price = $target.data('price');
                
                $('.size-badge').removeClass('active').css({
                    'background-color': '#fff',
                    'color': '#333',
                    'border-color': '#ddd'
                });
                
                $target.addClass('active').css({
                    'background-color': '#3D204E',
                    'color': '#fff',
                    'border-color': '#3D204E'
                });
                
                if (price && price > 0) {
                    this.elements.productPrice.text('$' + parseFloat(price).toFixed(2));
                }
            });
        },
        
        // Render other products
        renderOtherProducts: function(products) {
            if (!products || !products.length) {
                this.renderNoOtherProducts();
                return;
            }
            
            const html = products.slice(0, 6).map(product => `
                <div class="col-6 col-md-4">
                    <div class="card h-100 border-0 p-2 p-sm-3 hover-effect" style="background: #f7f2eb; border-radius: 24px; cursor: pointer;" onclick="window.location.href='/product/${product.slug || product.product_id}'">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <img src="/${product.front_image || 'default-product.jpg'}" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="${this.escapeHtml(product.product_name)}" loading="lazy" onerror="this.src='/default-product.jpg'">
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-3 gap-2">
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #3D204E;">${this.escapeHtml(product.product_name)}</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold fs-5" style="color: #3D204E;">$${parseFloat(product.price || 0).toFixed(2)}</span>
                                    ${product.compare_price ? `<span class="text-decoration-line-through text-secondary small">$${parseFloat(product.compare_price).toFixed(2)}</span>` : ''}
                                </div>
                            </div>
                            <button class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2" style="border-color: #3D204E; color: #3D204E;">View Details</button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            this.elements.otherProducts.html(html);
        },
        
        // Show skeleton loaders
        showSkeletonLoaders: function() {
            const skeletons = {
                breadcrumbs: '<div class="skeleton-text" style="width: 200px; height: 24px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px;"></div>',
                productName: '<div class="skeleton-text" style="width: 60%; height: 48px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px;"></div>',
                productDescription: '<div class="skeleton-text" style="width: 100%; height: 80px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px;"></div>',
                productImages: '<div class="skeleton-image" style="width: 100%; height: 400px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 28px;"></div><div class="d-flex gap-3 mt-3"><div class="skeleton-thumb" style="width: 80px; height: 80px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 12px;"></div><div class="skeleton-thumb" style="width: 80px; height: 80px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 12px;"></div></div>',
                colorLists: '<div class="d-flex gap-2"><div class="skeleton-color" style="width: 40px; height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 50%;"></div><div class="skeleton-color" style="width: 40px; height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 50%;"></div><div class="skeleton-color" style="width: 40px; height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 50%;"></div></div>',
                sizeLists: '<div class="d-flex gap-2"><div class="skeleton-size" style="width: 80px; height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 5px;"></div><div class="skeleton-size" style="width: 80px; height: 40px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 5px;"></div></div>',
                productPrice: '<div class="skeleton-text" style="width: 120px; height: 48px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px;"></div>'
            };
            
            Object.keys(skeletons).forEach(key => {
                if (this.elements[key] && this.elements[key].length) {
                    this.elements[key].html(skeletons[key]);
                }
            });
        },
        
        // Show other products skeleton
        showOtherProductsSkeleton: function() {
            const skeletons = Array(3).fill().map(() => `
                <div class="col-6 col-md-4">
                    <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <div class="skeleton-image w-100 h-100 rounded-4" style="background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite;"></div>
                        </div>
                        <div class="mt-3">
                            <div class="skeleton-text" style="width: 70%; height: 20px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px; margin-bottom: 10px;"></div>
                            <div class="skeleton-text" style="width: 40%; height: 15px; background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; border-radius: 4px;"></div>
                        </div>
                    </div>
                </div>
            `).join('');
            
            if (this.elements.otherProducts.length) {
                this.elements.otherProducts.html(skeletons);
            }
        },
        
        // Render no other products message
        renderNoOtherProducts: function() {
            const html = `
                <div class="col-12">
                    <div class="text-center py-5" style="background: #f8f4fa; border-radius: 24px;">
                        <div class="mb-3">
                            <i class="bi bi-box-seam fs-1" style="color: #3D204E;"></i>
                        </div>
                        <h5 class="mb-2" style="color: #3D204E;">No other products available</h5>
                        <p class="text-muted">Check back later for more products in this category.</p>
                        <a href="/products" class="btn btn-outline-purple rounded-pill px-4 py-2" style="border-color: #3D204E; color: #3D204E;">Browse All Products</a>
                    </div>
                </div>
            `;
            this.elements.otherProducts.html(html);
        },
        
        // Handle errors
        handleError: function(error, defaultMessage) {
            console.error('ProductDetails Error:', error);
            this.showNotification(defaultMessage, 'error');
        },
        
        // Show notification
        showNotification: function(message, type = 'error') {
            const $notification = $('#notification-area');
            if ($notification.length) {
                $notification.removeClass('alert-success alert-danger')
                    .addClass(`alert alert-${type === 'error' ? 'danger' : 'success'}`)
                    .text(message)
                    .fadeIn();
                setTimeout(() => $notification.fadeOut(), 3000);
            } else {
                // Fallback to toast or console
                if (type === 'error') {
                    console.error(message);
                } else {
                    console.log(message);
                }
            }
        },
        
        // Escape HTML for XSS protection
        escapeHtml: function(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }
    };
    
    // Initialize when document ready with productId
    $(document).ready(function() {
        if (typeof productId !== 'undefined' && productId) {
            ProductDetails.config.productId = productId;
            ProductDetails.init();
        } else {
            console.error('Product ID not defined');
        }
    });
    
})(jQuery);
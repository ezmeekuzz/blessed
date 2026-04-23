/**
 * Products Page JavaScript - Updated with price filtering and color/size support
 */

$(document).ready(function() {
    // DOM Elements
    const $productsContainer = $('#productsContainer');
    const $loadingSpinner = $('#loadingSpinner');
    const $resultsCount = $('#resultsCount');
    const $categoryTitle = $('#categoryTitle');
    const $selectedCategoryText = $('#selectedCategoryText');
    const $selectedSortText = $('#selectedSortText');
    
    // Price filter elements (optional - add to your view)
    const $minPriceInput = $('#minPrice');
    const $maxPriceInput = $('#maxPrice');
    const $priceFilterBtn = $('#applyPriceFilter');
    
    // State variables
    let currentCategoryId = 'all';
    let currentSort = 'most_popular';
    let currentCategoryName = 'All Products';
    let currentMinPrice = null;
    let currentMaxPrice = null;
    let isLoading = false;
    
    // Initialize
    initEventListeners();
    
    function initEventListeners() {
        // Category filter
        $(document).on('click', '#categoryDropdown .dropdown-item', function(e) {
            e.preventDefault();
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).text().trim();
            updateCategoryFilter(categoryId, categoryName);
        });
        
        // Sort filter
        $(document).on('click', '#sortDropdown .dropdown-item', function(e) {
            e.preventDefault();
            const sortValue = $(this).data('sort');
            const sortText = $(this).text().trim();
            updateSortFilter(sortValue, sortText);
        });
        
        // Price filter
        if ($priceFilterBtn.length) {
            $priceFilterBtn.on('click', function() {
                const minPrice = $minPriceInput.val();
                const maxPrice = $maxPriceInput.val();
                updatePriceFilter(minPrice, maxPrice);
            });
        }
        
        // Reset filters
        $(document).on('click', '.btn-reset-filters', function() {
            resetAllFilters();
        });
        
        // Category chips
        $(document).on('click', '.category-chip', function(e) {
            e.preventDefault();
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).text().trim();
            updateCategoryFilter(categoryId, categoryName);
        });
        
        // Enter key on price inputs
        if ($minPriceInput.length && $maxPriceInput.length) {
            $minPriceInput.on('keypress', function(e) {
                if (e.which === 13) $priceFilterBtn.trigger('click');
            });
            $maxPriceInput.on('keypress', function(e) {
                if (e.which === 13) $priceFilterBtn.trigger('click');
            });
        }
    }
    
    function updateCategoryFilter(categoryId, categoryName) {
        if (isLoading) return;
        currentCategoryId = categoryId;
        currentCategoryName = categoryName === 'All Categories' ? 'All Products' : categoryName;
        $selectedCategoryText.text(categoryName);
        updateActiveDropdownItem('#categoryDropdown .dropdown-item', categoryId);
        loadProducts();
    }
    
    function updateSortFilter(sortValue, sortText) {
        if (isLoading) return;
        currentSort = sortValue;
        $selectedSortText.text(sortText);
        updateActiveDropdownItem('#sortDropdown .dropdown-item', sortValue, 'data-sort');
        loadProducts();
    }
    
    function updatePriceFilter(minPrice, maxPrice) {
        if (isLoading) return;
        currentMinPrice = minPrice ? parseFloat(minPrice) : null;
        currentMaxPrice = maxPrice ? parseFloat(maxPrice) : null;
        loadProducts();
    }
    
    window.resetAllFilters = function() {
        if (isLoading) return;
        currentCategoryId = 'all';
        currentSort = 'most_popular';
        currentCategoryName = 'All Products';
        currentMinPrice = null;
        currentMaxPrice = null;
        
        $selectedCategoryText.text('All Categories');
        $selectedSortText.text('Most Popular');
        if ($minPriceInput.length) $minPriceInput.val('');
        if ($maxPriceInput.length) $maxPriceInput.val('');
        
        $('#categoryDropdown .dropdown-item').removeClass('active bg-primary text-white');
        $('#categoryDropdown .dropdown-item[data-category-id="all"]').addClass('active bg-primary text-white');
        
        $('#sortDropdown .dropdown-item').removeClass('active bg-primary text-white');
        $('#sortDropdown .dropdown-item[data-sort="most_popular"]').addClass('active bg-primary text-white');
        
        loadProducts();
    };
    
    function updateActiveDropdownItem(selector, value, dataAttr = 'data-category-id') {
        $(selector).removeClass('active bg-primary text-white');
        $(`${selector}[${dataAttr}="${value}"]`).addClass('active bg-primary text-white');
    }
    
    function loadProducts() {
        if (isLoading) return;
        isLoading = true;
        showLoading();
        
        let requestData = {
            category_id: currentCategoryId,
            sort: currentSort
        };
        
        if (currentMinPrice !== null) requestData.min_price = currentMinPrice;
        if (currentMaxPrice !== null) requestData.max_price = currentMaxPrice;
        
        $.ajax({
            url: '/products/filter',  // ProductsController::filterByCategory
            method: 'GET',
            data: requestData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateProductsDisplay(response.products, response.total);
                    updateCategoryTitle();
                    updateResultsCount(response.total);
                } else {
                    showError('Failed to load products.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                showError('An error occurred while loading products.');
            },
            complete: function() {
                isLoading = false;
                hideLoading();
            }
        });
    }
    
    function updateProductsDisplay(products, total) {
        if (!products || products.length === 0) {
            showNoResults();
            return;
        }
        
        let html = '';
        
        products.forEach(function(product) {
            const firstImage = product.images && product.images.length > 0 
                ? product.images[0] 
                : '/images/placeholder-product.png';
            
            const hasDiscount = product.discount_percentage > 0;
            const discountHtml = hasDiscount 
                ? `<span class="badge position-absolute top-0 end-0 m-2" style="background: #e74c3c; color: white;">${product.discount_percentage}% OFF</span>`
                : '';
            
            const originalPriceHtml = hasDiscount
                ? `<span class="text-decoration-line-through text-secondary-emphasis small">$${parseFloat(product.original_price).toFixed(2)}</span>`
                : '';
            
            html += `
                <div class="col-6 col-md-4 product-card-item" data-product-id="${product.product_id}">
                    <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <img src="${firstImage}" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="${escapeHtml(product.product_name)}" onerror="this.src='/images/placeholder-product.png'">
                            ${discountHtml}
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-6 fw-semibold mb-1 text-truncate" style="color: #3D204E;">${escapeHtml(product.product_name)}</h3>
                            ${product.categoryname ? `<p class="small text-muted mb-2">${escapeHtml(product.categoryname)}</p>` : ''}
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-2 gap-2 gap-sm-0">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold fs-4" style="color: #3D204E;">$${parseFloat(product.price).toFixed(2)}</span>
                                    ${originalPriceHtml}
                                </div>
                                <a href="/product/${product.slug}" class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto text-decoration-none" style="border-color: #3D204E;">
                                    Personalize Design
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $productsContainer.html(html);
        initializeProductCards();
    }
    
    function showNoResults() {
        $productsContainer.html(`
            <div class="col-12">
                <div class="no-results-enhanced text-center py-5">
                    <div class="no-results-icon mx-auto">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="no-results-title">No Products Found</h3>
                    <p class="no-results-message">We couldn't find any products matching your criteria.</p>
                    <div class="no-results-actions">
                        <button class="btn btn-primary mt-3" onclick="window.resetAllFilters()">
                            <i class="fas fa-undo-alt me-2"></i>Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        `);
    }
    
    function updateCategoryTitle() {
        $categoryTitle.text(currentCategoryName);
    }
    
    function updateResultsCount(count) {
        $resultsCount.text(`${count} ${count === 1 ? 'Result' : 'Results'}`);
    }
    
    function showLoading() {
        $loadingSpinner.removeClass('d-none');
        $productsContainer.addClass('opacity-50');
    }
    
    function hideLoading() {
        $loadingSpinner.addClass('d-none');
        $productsContainer.removeClass('opacity-50');
    }
    
    function showError(message) {
        $productsContainer.html(`
            <div class="col-12">
                <div class="alert alert-danger text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3 d-block"></i>
                    <h4>Something went wrong!</h4>
                    <p>${escapeHtml(message)}</p>
                    <button class="btn btn-outline-danger mt-3" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh Page
                    </button>
                </div>
            </div>
        `);
    }
    
    function initializeProductCards() {
        $('.product-card-item .card').on('mouseenter', function() {
            $(this).css('transform', 'translateY(-6px)');
        }).on('mouseleave', function() {
            $(this).css('transform', 'translateY(0)');
        });
    }
    
    function escapeHtml(str) {
        if (!str) return '';
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
});
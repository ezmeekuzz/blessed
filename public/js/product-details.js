/**
 * Product Details Page JavaScript
 * Handles color/size selection, quantity updates, add to cart, and more
 */

// State variables - These will be populated from data attributes
let currentProductId = null;
let currentSizeId = null;
let currentColorId = null;
let currentQuantity = 1;
let currentPrice = 0;
let currentOriginalPrice = 0;

// DOM Elements
let $wishlistBtn;
let $addToCartBtn;
let $quantityInput;
let $displayPrice;
let $originalPriceDisplay;
let $discountBadge;
let $selectedSizeLabel;
let $selectedColorName;

$(document).ready(function() {
    // Get product data from data attributes on the container
    const $productContainer = $('#productDetailsSection');
    currentProductId = $productContainer.data('product-id');
    currentPrice = parseFloat($productContainer.data('default-price')) || 0;
    currentOriginalPrice = parseFloat($productContainer.data('original-price')) || 0;
    
    // Initialize DOM references
    $wishlistBtn = $('.wishlist-btn');
    $addToCartBtn = $('#addToCartBtn');
    $quantityInput = $('#quantityInput');
    $displayPrice = $('#displayPrice');
    $originalPriceDisplay = $('#originalPriceDisplay');
    $discountBadge = $('#discountBadge');
    $selectedSizeLabel = $('#selectedSizeLabel');
    $selectedColorName = $('#selectedColorName');
    
    // Get initial size and color IDs from data attributes
    const $activeSize = $('.size-option .size-badge.active').closest('.size-option');
    const $activeColor = $('.color-option .color-swatch[style*="border: 2px solid rgb(61, 32, 78)"]').closest('.color-option');
    
    currentSizeId = $activeSize.length ? $activeSize.data('size-id') : null;
    currentColorId = $activeColor.length ? $activeColor.data('color-id') : null;
    
    // Initialize event listeners
    initEventListeners();
});

function initEventListeners() {
    // Quantity input change
    if ($quantityInput.length) {
        $quantityInput.on('change', function() {
            let val = parseInt($(this).val());
            if (isNaN(val) || val < 1) val = 1;
            if (val > 99) val = 99;
            currentQuantity = val;
            $(this).val(val);
        });
    }
    
    // Keyboard shortcuts
    $(document).on('keydown', function(e) {
        // Alt + C to add to cart
        if (e.altKey && e.key === 'c') {
            e.preventDefault();
            addToCart();
        }
    });
}

/**
 * Change main product image
 */
function changeMainImage(element) {
    const newImageSrc = $(element).data('image') || $(element).attr('src');
    if (newImageSrc) {
        $('#mainProductImage').attr('src', newImageSrc);
        
        // Update active state on thumbnails
        $('.thumb-img').removeClass('active');
        $(element).addClass('active');
    }
}

/**
 * Select color option
 */
function selectColor(element) {
    const $colorOption = $(element).closest('.color-option');
    const colorId = $colorOption.data('color-id');
    const colorHex = $colorOption.data('color-hex');
    const frontImage = $colorOption.data('front-image');
    
    // Get color name from hex
    const colorName = getColorNameFromHex(colorHex);
    
    // Update UI
    $('.color-swatch').css('border', '2px solid #ddd');
    $colorOption.find('.color-swatch').css('border', '2px solid #3D204E');
    if ($selectedColorName.length) $selectedColorName.text(colorName);
    
    // Update current color ID
    currentColorId = colorId;
    
    // Update main image if front image exists
    if (frontImage) {
        $('#mainProductImage').attr('src', frontImage);
        
        // Also update thumbnail if available
        if ($('#thumbnailContainer').length && frontImage) {
            // Check if thumbnail already exists
            let thumbnailExists = false;
            $('.thumb-img').each(function() {
                if ($(this).data('image') === frontImage || $(this).attr('src') === frontImage) {
                    thumbnailExists = true;
                }
            });
            
            if (!thumbnailExists) {
                // Add new thumbnail
                $('#thumbnailContainer').prepend(`
                    <img src="${frontImage}" alt="Color thumbnail" class="thumb-img" data-image="${frontImage}" onclick="changeMainImage(this)">
                `);
                // Make the first thumbnail (the new one) active
                $('.thumb-img').removeClass('active');
                $('#thumbnailContainer .thumb-img').first().addClass('active');
            }
        }
    }
    
    // Load variations for this color
    loadVariations();
}

/**
 * Select size option
 */
function selectSize(element) {
    const $sizeOption = $(element).closest('.size-option');
    const sizeId = $sizeOption.data('size-id');
    const sizeValue = $sizeOption.data('size-value');
    const unit = $sizeOption.data('unit') || 'oz';
    const price = parseFloat($sizeOption.data('price'));
    const originalPrice = parseFloat($sizeOption.data('original-price'));
    const hasDiscount = $sizeOption.data('has-discount') === 'true';
    const discountLabel = $sizeOption.data('discount-label');
    
    // Update UI
    $('.size-badge').removeClass('active border-2').css({
        'background': 'transparent',
        'color': '#3D204E'
    });
    $sizeOption.find('.size-badge').addClass('active border-2').css({
        'background': '#3D204E',
        'color': 'white'
    });
    
    if ($selectedSizeLabel.length) $selectedSizeLabel.text(`${sizeValue} ${unit}`);
    
    // Update current size ID and price
    currentSizeId = sizeId;
    currentPrice = price;
    currentOriginalPrice = originalPrice;
    
    // Update price display
    if ($displayPrice.length) $displayPrice.text(`$${price.toFixed(2)}`);
    
    if (hasDiscount && originalPrice > price) {
        if ($originalPriceDisplay.length) {
            $originalPriceDisplay.show();
            $originalPriceDisplay.text(`$${originalPrice.toFixed(2)}`);
        }
        if ($discountBadge.length) {
            $discountBadge.show();
            $discountBadge.text(discountLabel || 'SALE');
        }
    } else {
        if ($originalPriceDisplay.length) $originalPriceDisplay.hide();
        if ($discountBadge.length) $discountBadge.hide();
    }
    
    // Load variations for this size
    loadVariations();
}

/**
 * Load variations (price updates, image updates) based on selected size/color
 * Uses ProductDetailsController::getVariations
 */
function loadVariations() {
    if (!currentProductId) return;
    
    $.ajax({
        url: '/product-details/variations',  // ProductDetailsController::getVariations
        method: 'GET',
        data: {
            product_id: currentProductId,
            size_id: currentSizeId,
            color_id: currentColorId
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update front image if available
                if (response.front_image) {
                    $('#mainProductImage').attr('src', response.front_image);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading variations:', error);
        }
    });
}

/**
 * Update quantity
 */
function updateQuantity(delta) {
    let newQuantity = currentQuantity + delta;
    if (newQuantity < 1) newQuantity = 1;
    if (newQuantity > 99) newQuantity = 99;
    
    currentQuantity = newQuantity;
    if ($quantityInput.length) $quantityInput.val(newQuantity);
}

/**
 * Add product to cart
 * Uses ProductDetailsController::addToCart
 */
function addToCart() {
    if (!currentSizeId) {
        showToast('Please select a size first!', 'warning');
        return;
    }
    
    // Show loading state on button
    const $btn = $addToCartBtn;
    const originalText = $btn.html();
    $btn.html('<i class="bi bi-hourglass-split me-2"></i>Adding...').prop('disabled', true);
    
    $.ajax({
        url: '/product-details/add-to-cart',  // ProductDetailsController::addToCart
        method: 'POST',
        data: {
            product_id: currentProductId,
            size_id: currentSizeId,
            color_id: currentColorId || null,
            quantity: currentQuantity
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showToast(response.message, 'success');
                updateCartBadge(response.cart_count);
                animateCartIcon();
            } else {
                showToast(response.message || 'Failed to add to cart', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Add to cart error:', error);
            showToast('An error occurred. Please try again.', 'error');
        },
        complete: function() {
            $btn.html(originalText).prop('disabled', false);
        }
    });
}

/**
 * Start designing/customizing product
 */
function startDesigning() {
    // Redirect to customization page with product details
    window.location.href = `/customize/${currentProductId}?size=${currentSizeId || ''}&color=${currentColorId || ''}`;
}

/**
 * Toggle product in wishlist
 */
function toggleWishlist(productId) {
    const $icon = $wishlistBtn.find('i');
    
    $.ajax({
        url: '/wishlist/toggle',
        method: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.in_wishlist) {
                $icon.removeClass('bi-heart').addClass('bi-heart-fill');
                showToast('Added to wishlist!', 'success');
            } else {
                $icon.removeClass('bi-heart-fill').addClass('bi-heart');
                showToast('Removed from wishlist', 'info');
            }
        },
        error: function() {
            showToast('Please login to use wishlist', 'warning');
        }
    });
}

/**
 * Share product
 */
function shareProduct() {
    const url = window.location.href;
    const title = document.title;
    
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(() => {
            copyToClipboard(url);
        });
    } else {
        copyToClipboard(url);
    }
}

/**
 * Copy to clipboard helper
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('Link copied to clipboard!', 'success');
    }).catch(() => {
        showToast('Failed to copy link', 'error');
    });
}

/**
 * Show toast notification
 */
function showToast(message, type = 'success') {
    let toastEl = $('#cartToast');
    
    // Check if toast element exists, if not create it
    if (!toastEl.length) {
        $('body').append(`
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="cartToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        `);
        toastEl = $('#cartToast');
    }
    
    // Update toast styling based on type
    toastEl.removeClass('bg-success bg-danger bg-warning bg-info');
    if (type === 'success') toastEl.addClass('bg-success');
    else if (type === 'error') toastEl.addClass('bg-danger');
    else if (type === 'warning') toastEl.addClass('bg-warning');
    else toastEl.addClass('bg-info');
    
    toastEl.find('.toast-body').html(`<i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'error' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>${escapeHtml(message)}`);
    
    const toast = new bootstrap.Toast(toastEl[0], { delay: 3000 });
    toast.show();
}

/**
 * Update cart badge in header
 */
function updateCartBadge(count) {
    const $cartBadge = $('.cart-badge, #cartCount');
    if ($cartBadge.length) {
        $cartBadge.text(count);
        if (count > 0) {
            $cartBadge.show();
        } else {
            $cartBadge.hide();
        }
    }
}

/**
 * Animate cart icon on add
 */
function animateCartIcon() {
    const $cartIcon = $('.cart-icon, .bi-cart, .fa-cart-shopping');
    $cartIcon.addClass('animate__animated animate__rubberBand');
    setTimeout(() => {
        $cartIcon.removeClass('animate__animated animate__rubberBand');
    }, 1000);
}

/**
 * Get color name from hex code
 */
function getColorNameFromHex(hex) {
    const colors = {
        '#FFFFFF': 'White',
        '#000000': 'Black',
        '#FF0000': 'Red',
        '#00FF00': 'Green',
        '#0000FF': 'Blue',
        '#FFFF00': 'Yellow',
        '#FFC0CB': 'Pink',
        '#800080': 'Purple',
        '#FFA500': 'Orange',
        '#808080': 'Gray',
        '#A52A2A': 'Brown',
        '#FF69B4': 'Hot Pink',
        '#00FFFF': 'Cyan',
        '#FF4500': 'Orange Red'
    };
    return colors[hex.toUpperCase()] || 'Custom';
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(str) {
    if (!str) return '';
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// Export functions for global access
window.changeMainImage = changeMainImage;
window.selectColor = selectColor;
window.selectSize = selectSize;
window.updateQuantity = updateQuantity;
window.addToCart = addToCart;
window.startDesigning = startDesigning;
window.toggleWishlist = toggleWishlist;
window.shareProduct = shareProduct;
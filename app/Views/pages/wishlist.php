<?= $this->include('templates/header'); ?>

<style>
/* Wishlist CSS */
.wishlist-section {
    background: #f0f2f5;
    min-height: calc(100vh - 200px);
    padding: 40px 0;
}

/* Page Header */
.page-header {
    margin-bottom: 30px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.page-subtitle {
    color: #65676b;
    font-size: 14px;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
    margin-bottom: 24px;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: #f0e9f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.stat-icon i {
    font-size: 24px;
    color: #dc3545;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 13px;
    color: #65676b;
}

/* Wishlist Grid */
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.product-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: #dc3545;
    color: white;
    padding: 4px 10px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 600;
    z-index: 2;
}

.product-image {
    position: relative;
    height: 240px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0e9f5 0%, #e8dfd7 100%);
}

.image-placeholder i {
    font-size: 64px;
    color: #3D204E;
    opacity: 0.5;
}

.remove-wishlist-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 32px;
    height: 32px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.remove-wishlist-btn:hover {
    background: #dc3545;
    color: white;
    transform: scale(1.1);
}

.remove-wishlist-btn i {
    font-size: 14px;
    color: #dc3545;
}

.remove-wishlist-btn:hover i {
    color: white;
}

.product-info {
    padding: 16px;
}

.product-category {
    font-size: 11px;
    color: #3D204E;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.product-title {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 8px;
    line-height: 1.4;
}

.product-title a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-title a:hover {
    color: #3D204E;
}

.product-price {
    font-size: 18px;
    font-weight: 700;
    color: #3D204E;
    margin-bottom: 12px;
}

.product-original-price {
    font-size: 13px;
    color: #65676b;
    text-decoration: line-through;
    margin-left: 8px;
    font-weight: normal;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 12px;
}

.rating-stars {
    color: #ffc107;
    font-size: 12px;
}

.rating-count {
    font-size: 11px;
    color: #65676b;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.btn-add-cart {
    flex: 1;
    background: #3D204E;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-add-cart:hover {
    background: #5a2d73;
    transform: translateY(-1px);
}

.btn-view {
    background: #f0f2f5;
    color: #65676b;
    border: none;
    padding: 10px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-view:hover {
    background: #e4e6eb;
    color: #1a1a2e;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
}

.empty-icon {
    font-size: 80px;
    color: #e4e6eb;
    margin-bottom: 20px;
}

.empty-title {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.empty-text {
    color: #65676b;
    margin-bottom: 24px;
}

/* Loading State */
.loading-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
}

.spinner-custom {
    width: 50px;
    height: 50px;
    border: 3px solid #f0f2f5;
    border-top-color: #3D204E;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .wishlist-section {
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 24px;
    }
    
    .wishlist-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }
    
    .product-image {
        height: 200px;
    }
    
    .product-title {
        font-size: 14px;
    }
    
    .product-price {
        font-size: 16px;
    }
    
    .stat-value {
        font-size: 22px;
    }
}
</style>

<section class="wishlist-section">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Wishlist</h1>
            <p class="page-subtitle">Save your favorite items and purchase them later</p>
        </div>

        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-4 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="stat-value" id="totalItems">6</div>
                    <div class="stat-label">Items in Wishlist</div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="stat-value" id="totalSavings">$47.94</div>
                    <div class="stat-label">Total Savings</div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value" id="totalValue">$239.94</div>
                    <div class="stat-label">Total Value</div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-secondary" id="selectAllBtn">
                    <i class="fas fa-check-square me-1"></i> Select All
                </button>
                <button class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                    <i class="fas fa-square me-1"></i> Deselect All
                </button>
                <button class="btn btn-sm btn-outline-danger" id="removeSelectedBtn" style="display: none;">
                    <i class="fas fa-trash me-1"></i> Remove Selected
                </button>
            </div>
            <button class="btn btn-primary-custom" id="addAllToCartBtn">
                <i class="fas fa-shopping-cart me-1"></i> Add All to Cart
            </button>
        </div>

        <!-- Wishlist Grid -->
        <div id="wishlistGrid">
            <!-- Loading State -->
            <div class="loading-state" id="loadingState">
                <div class="spinner-custom"></div>
                <p>Loading your wishlist...</p>
            </div>

            <!-- Sample Wishlist Items - Replace with actual database data -->
            <div class="wishlist-grid" id="wishlistItemsGrid" style="display: none;">
                <!-- Item 1 -->
                <div class="product-card" data-id="1" data-price="24.99" data-sale-price="19.99">
                    <span class="product-badge">Sale</span>
                    <div class="remove-wishlist-btn" data-id="1">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Books</div>
                        <h3 class="product-title">
                            <a href="/product/daily-devotional">Daily Devotional: Finding Peace in God's Word</a>
                        </h3>
                        <div class="product-price">
                            $19.99
                            <span class="product-original-price">$24.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(128 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="1">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="product-card" data-id="2" data-price="34.99" data-sale-price="29.99">
                    <div class="remove-wishlist-btn" data-id="2">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-mug-hot"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Home & Living</div>
                        <h3 class="product-title">
                            <a href="/product/faith-inspirational-mug">Faith Inspirational Mug - Set of 4</a>
                        </h3>
                        <div class="product-price">
                            $29.99
                            <span class="product-original-price">$34.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-count">(245 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="2">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="2">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="product-card" data-id="3" data-price="49.99" data-sale-price="39.99">
                    <span class="product-badge">Limited Edition</span>
                    <div class="remove-wishlist-btn" data-id="3">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-tshirt"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Apparel</div>
                        <h3 class="product-title">
                            <a href="/product/christian-faith-tshirt">Christian Faith T-Shirt - Premium Cotton</a>
                        </h3>
                        <div class="product-price">
                            $39.99
                            <span class="product-original-price">$49.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="rating-count">(89 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="3">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="3">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="product-card" data-id="4" data-price="29.99" data-sale-price="24.99">
                    <div class="remove-wishlist-btn" data-id="4">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-praying-hands"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Jewelry</div>
                        <h3 class="product-title">
                            <a href="/product/cross-necklace">Cross Necklace - Sterling Silver</a>
                        </h3>
                        <div class="product-price">
                            $24.99
                            <span class="product-original-price">$29.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(167 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="4">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="4">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="product-card" data-id="5" data-price="59.99" data-sale-price="49.99">
                    <span class="product-badge">Bestseller</span>
                    <div class="remove-wishlist-btn" data-id="5">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-palette"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Wall Art</div>
                        <h3 class="product-title">
                            <a href="/product/wall-art-psalm-23">Wall Art - Psalm 23 Canvas Print</a>
                        </h3>
                        <div class="product-price">
                            $49.99
                            <span class="product-original-price">$59.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="rating-count">(312 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="5">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="5">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="product-card" data-id="6" data-price="39.99" data-sale-price="34.99">
                    <div class="remove-wishlist-btn" data-id="6">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="product-image">
                        <div class="image-placeholder">
                            <i class="fas fa-journal-whills"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-category">Stationery</div>
                        <h3 class="product-title">
                            <a href="/product/prayer-journal">Prayer Journal - Leather Bound</a>
                        </h3>
                        <div class="product-price">
                            $34.99
                            <span class="product-original-price">$39.99</span>
                        </div>
                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="rating-count">(203 reviews)</span>
                        </div>
                        <div class="product-actions">
                            <button class="btn-add-cart add-to-cart" data-id="6">
                                <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                            </button>
                            <button class="btn-view" data-id="6">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Move to Cart Modal -->
<div class="modal fade" id="moveToCartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="border-bottom: 1px solid #e4e6eb; padding: 20px 24px;">
                <h5 class="modal-title fw-bold" style="color: #1a1a2e;">
                    <i class="fas fa-shopping-cart me-2" style="color: #3D204E;"></i> Added to Cart
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-check-circle fa-4x" style="color: #28a745; margin-bottom: 16px;"></i>
                <h5 class="fw-bold mb-2">Item Added to Cart!</h5>
                <p class="text-muted" id="modalMessage">The item has been successfully added to your cart.</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e4e6eb; padding: 16px 24px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                <a href="/cart" class="btn btn-primary-custom">View Cart</a>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer'); ?>

<script>
$(document).ready(function() {
    // Initialize wishlist
    let selectedItems = new Set();
    
    // Hide loading and show grid
    setTimeout(function() {
        $('#loadingState').hide();
        $('#wishlistItemsGrid').show();
    }, 500);
    
    // Remove wishlist item
    $('.remove-wishlist-btn').on('click', function(e) {
        e.stopPropagation();
        const $card = $(this).closest('.product-card');
        const itemId = $(this).data('id');
        const itemName = $card.find('.product-title a').text();
        
        Swal.fire({
            title: 'Remove from wishlist?',
            text: `Remove "${itemName}" from your wishlist?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $card.fadeOut(300, function() {
                    $(this).remove();
                    updateWishlistStats();
                    showNotification('Item removed from wishlist', 'success');
                    
                    // Check if wishlist is empty
                    if ($('.product-card').length === 0) {
                        $('#wishlistItemsGrid').hide();
                        $('#wishlistGrid').append(`
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="far fa-heart"></i>
                                </div>
                                <h3 class="empty-title">Your wishlist is empty</h3>
                                <p class="empty-text">Save your favorite items here to purchase them later.</p>
                                <a href="/shop" class="btn btn-primary-custom">Start Shopping</a>
                            </div>
                        `);
                    }
                });
            }
        });
    });
    
    // Add to cart
    $('.add-to-cart').on('click', function() {
        const $card = $(this).closest('.product-card');
        const itemName = $card.find('.product-title a').text();
        const itemPrice = $card.find('.product-price').contents().first().text().trim();
        
        $('#modalMessage').text(`"${itemName}" has been added to your cart.`);
        $('#moveToCartModal').modal('show');
    });
    
    // View product
    $('.btn-view').on('click', function() {
        const $card = $(this).closest('.product-card');
        const productLink = $card.find('.product-title a').attr('href');
        window.location.href = productLink;
    });
    
    // Select All
    let selectAllFlag = false;
    $('#selectAllBtn').on('click', function() {
        $('.product-card').addClass('selected');
        $('.product-card').css('border', '2px solid #3D204E');
        selectAllFlag = true;
        $('#removeSelectedBtn').show();
        showNotification('All items selected', 'info');
    });
    
    // Deselect All
    $('#deselectAllBtn').on('click', function() {
        $('.product-card').removeClass('selected');
        $('.product-card').css('border', 'none');
        selectAllFlag = false;
        $('#removeSelectedBtn').hide();
        showNotification('All items deselected', 'info');
    });
    
    // Remove selected
    $('#removeSelectedBtn').on('click', function() {
        const selectedCards = $('.product-card.selected');
        
        if (selectedCards.length === 0) {
            showNotification('No items selected', 'error');
            return;
        }
        
        Swal.fire({
            title: 'Remove selected items?',
            text: `Are you sure you want to remove ${selectedCards.length} item(s) from your wishlist?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove them!'
        }).then((result) => {
            if (result.isConfirmed) {
                selectedCards.fadeOut(300, function() {
                    $(this).remove();
                    updateWishlistStats();
                    showNotification(`${selectedCards.length} item(s) removed from wishlist`, 'success');
                    $('#removeSelectedBtn').hide();
                    
                    if ($('.product-card').length === 0) {
                        $('#wishlistItemsGrid').hide();
                        $('#wishlistGrid').append(`
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="far fa-heart"></i>
                                </div>
                                <h3 class="empty-title">Your wishlist is empty</h3>
                                <p class="empty-text">Save your favorite items here to purchase them later.</p>
                                <a href="/shop" class="btn btn-primary-custom">Start Shopping</a>
                            </div>
                        `);
                    }
                });
            }
        });
    });
    
    // Add All to Cart
    $('#addAllToCartBtn').on('click', function() {
        const totalItems = $('.product-card').length;
        
        Swal.fire({
            title: 'Add all to cart?',
            text: `Are you sure you want to add all ${totalItems} item(s) to your cart?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3D204E',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, add all!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart!',
                    text: `${totalItems} item(s) have been added to your cart.`,
                    confirmButtonColor: '#3D204E'
                }).then(() => {
                    window.location.href = '/cart';
                });
            }
        });
    });
    
    // Update wishlist statistics
    function updateWishlistStats() {
        const itemCount = $('.product-card').length;
        let totalValue = 0;
        let totalSavings = 0;
        
        $('.product-card').each(function() {
            const price = parseFloat($(this).find('.product-price').contents().first().text().trim().replace('$', ''));
            const originalPrice = parseFloat($(this).find('.product-original-price').text().replace('$', ''));
            
            if (!isNaN(price)) {
                totalValue += price;
            }
            if (!isNaN(originalPrice) && originalPrice > price) {
                totalSavings += (originalPrice - price);
            }
        });
        
        $('#totalItems').text(itemCount);
        $('#totalValue').text('$' + totalValue.toFixed(2));
        $('#totalSavings').text('$' + totalSavings.toFixed(2));
    }
    
    // Notification function
    function showNotification(message, type) {
        $('.notification-toast').remove();
        const toast = $('<div class="notification-toast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 250px; padding: 12px 20px; border-radius: 10px; color: white; font-weight: 500; display: none;"></div>');
        const bgColor = type === 'success' ? '#28a745' : type === 'info' ? '#17a2b8' : '#dc3545';
        toast.css('background', bgColor);
        toast.text(message);
        $('body').append(toast);
        toast.fadeIn(300);
        setTimeout(() => toast.fadeOut(300, () => toast.remove()), 5000);
    }
    
    // Hover effect for product card selection
    $('.product-card').on('click', function(e) {
        if (e.target.closest('.remove-wishlist-btn') || e.target.closest('.add-to-cart') || e.target.closest('.btn-view')) {
            return;
        }
        
        $(this).toggleClass('selected');
        if ($(this).hasClass('selected')) {
            $(this).css('border', '2px solid #3D204E');
        } else {
            $(this).css('border', 'none');
        }
        
        const selectedCount = $('.product-card.selected').length;
        if (selectedCount > 0) {
            $('#removeSelectedBtn').show();
        } else {
            $('#removeSelectedBtn').hide();
        }
    });
});
</script>
<?= $this->include('templates/header'); ?>

<!-- BREADCRUMB NAVIGATION SECTION -->
<section class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 fs-5">
                <li class="breadcrumb-item"><a href="/products">Products</a></li>
                <li class="breadcrumb-item"><a href="/products?category=<?= $product['product_category_id']; ?>"><?= esc($product['categoryname'] ?? 'Products'); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($product['product_name']); ?></li>
            </ol>
        </nav>
        <div class="share-icon d-flex align-items-center gap-1" style="cursor: pointer;" onclick="shareProduct()">
            <i class="bi bi-share"></i> <span class="fs-6 fw-light">Share</span>
        </div>
    </div>
</section>

<!-- PRODUCT DETAILS SECTION -->
<section class="container mt-4" id="productDetailsSection" 
         data-product-id="<?= $product['product_id']; ?>"
         data-default-price="<?= $defaultPrice; ?>"
         data-original-price="<?= $originalPrice; ?>">
    <div class="row g-5">
        <!-- LEFT COLUMN: Product Images -->
        <div class="col-md-6">
            <!-- Main Product Image -->
            <div class="product-img-large position-relative" id="mainImageContainer">
                <img id="mainProductImage" src="<?= base_url($images[0] ?? 'images/placeholder-product.png'); ?>" alt="<?= esc($product['product_name']); ?>" class="img-square">
                <button class="btn position-absolute top-0 end-0 m-3 p-2 rounded-circle bg-white border-0 shadow-sm wishlist-btn" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;" aria-label="Add to wishlist" onclick="toggleWishlist(<?= $product['product_id']; ?>)">
                    <i class="bi bi-heart fs-5" style="color: #3D204E;"></i>
                </button>
            </div>
            
            <!-- Thumbnail Images -->
            <div class="d-flex gap-3 mt-3" id="thumbnailContainer">
                <?php foreach ($images as $index => $image): ?>
                <img src="<?= base_url($image); ?>" alt="Product thumbnail <?= $index + 1; ?>" class="thumb-img <?= $index === 0 ? 'active' : ''; ?>" data-image="<?= base_url($image); ?>" onclick="changeMainImage(this)">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- RIGHT COLUMN: Product Details -->
        <div class="col-md-6">
            <!-- Product Title -->
            <h1 class="display-5 fw-bold" style="color: #3D204E;"><?= esc($product['product_name']); ?></h1>
            
            <!-- Ratings (Optional - can be added later) -->
            <div class="d-flex align-items-center gap-2 mt-2">
                <div class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                </div>
                <span class="text-muted">(4.5/5)</span>
            </div>
            
            <!-- Product Description -->
            <p class="mt-3" style="font-size: 1.2rem; line-height: 1.4;">
                <?= nl2br(esc($product['description'])); ?>
            </p>

            <!-- Color Options -->
            <?php if (!empty($colors)): ?>
            <div class="mt-4">
                <span class="fw-semibold fs-6">Color: <span id="selectedColorName"><?= $defaultColor ? $defaultColor['color_name'] ?? 'Default' : 'Default'; ?></span></span>
                <div class="d-flex flex-wrap gap-2 mt-2" id="colorOptionsContainer">
                    <?php foreach ($colors as $color): ?>
                    <div class="color-option" 
                         data-color-id="<?= $color['color_id']; ?>"
                         data-color-hex="<?= $color['color_hex']; ?>"
                         data-front-image="<?= $color['front_image'] ? base_url($color['front_image']) : ''; ?>"
                         data-back-image="<?= $color['back_image'] ? base_url($color['back_image']) : ''; ?>"
                         onclick="selectColor(this)">
                        <div class="color-swatch rounded-circle" style="width: 40px; height: 40px; background: <?= $color['color_hex']; ?>; border: 2px solid <?= $color['is_default'] ? '#3D204E' : '#ddd'; ?>; cursor: pointer; transition: all 0.2s;">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Size Options -->
            <?php if (!empty($sizes)): ?>
            <div class="mt-4">
                <span class="fw-semibold fs-6">Size: <span id="selectedSizeLabel"><?= $defaultSize ? $defaultSize['size'] . ' ' . ($defaultSize['unit_of_measure'] ?? 'oz') : 'Select Size'; ?></span></span>
                <div class="d-flex flex-wrap gap-2 mt-2" id="sizeOptionsContainer">
                    <?php foreach ($sizes as $size): ?>
                    <div class="size-option" 
                         data-size-id="<?= $size['size_id']; ?>"
                         data-size-value="<?= $size['size']; ?>"
                         data-unit="<?= $size['unit_of_measure']; ?>"
                         data-price="<?= $size['final_price']; ?>"
                         data-original-price="<?= $size['price']; ?>"
                         data-has-discount="<?= ($size['discount_percentage'] > 0 || $size['discount_amount'] > 0) ? 'true' : 'false'; ?>"
                         data-discount-label="<?= $size['discount_label']; ?>"
                         onclick="selectSize(this)">
                        <span class="size-badge d-inline-block px-3 py-2 rounded-pill border <?= $size['is_default'] ? 'active border-2' : ''; ?>" style="border-color: #3D204E; cursor: pointer; <?= $size['is_default'] ? 'background: #3D204E; color: white;' : ''; ?>">
                            <?= $size['size'] . ' ' . ($size['unit_of_measure'] ?? 'oz'); ?>
                            <?php if ($size['discount_label']): ?>
                            <small class="ms-1">(<?= $size['discount_label']; ?>)</small>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Quantity Selector -->
            <div class="mt-4">
                <span class="fw-semibold fs-6">Quantity</span>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <button class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px;" onclick="updateQuantity(-1)">-</button>
                    <input type="number" id="quantityInput" class="form-control text-center" style="width: 80px; border-radius: 30px;" value="1" min="1" max="99">
                    <button class="btn btn-outline-secondary rounded-circle" style="width: 40px; height: 40px;" onclick="updateQuantity(1)">+</button>
                </div>
            </div>

            <!-- Price & Delivery Information -->
            <div class="mt-4 p-3" style="background: #f8f4fa; border-radius: 20px;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <!-- Price Block -->
                    <div>
                        <span class="text-secondary small">Price*</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-2" style="color: #3D204E;" id="displayPrice">$<?= number_format($defaultPrice, 2); ?></span>
                            <?php if ($hasDiscount): ?>
                            <span class="text-decoration-line-through text-secondary" id="originalPriceDisplay">$<?= number_format($originalPrice, 2); ?></span>
                            <span class="badge" style="background: #e74c3c; color: white;" id="discountBadge">
                                <?= $defaultSize && $defaultSize['discount_percentage'] ? $defaultSize['discount_percentage'] . '% OFF' : 'SALE'; ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">Print included</small>
                    </div>
                    
                    <!-- Separator -->
                    <div class="vr" style="height: 40px;"></div>
                    
                    <!-- Estimated Delivery -->
                    <div>
                        <span class="fw-medium">Estimated Delivery To:</span>
                        <span class="fw-bold" id="deliveryCountry"><?= $shippingEstimate['country']; ?></span>
                        <span class="fw-semibold ms-1" id="deliveryEstimate"><?= $shippingEstimate['min_days']; ?>–<?= $shippingEstimate['max_days']; ?> days</span>
                    </div>
                    
                    <!-- Separator -->
                    <div class="vr" style="height: 40px;"></div>
                    
                    <!-- Shipping Information -->
                    <div>
                        <span class="text-secondary">Shipping Starts At</span>
                        <span class="fw-semibold">$<?= number_format($shippingCost, 2); ?></span>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="d-flex gap-3 my-4">
                <button class="btn px-5 py-3 rounded-pill text-white fs-5 flex-grow-1" style="background: #3D204E;" onclick="addToCart()" id="addToCartBtn">
                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>
                <button class="btn px-4 py-3 rounded-pill border" style="border-color: #3D204E; color: #3D204E;" onclick="startDesigning()">
                    <i class="bi bi-pencil-square me-2"></i>Customize
                </button>
            </div>
            
            <!-- Trust Badges -->
            <div class="d-flex justify-content-center gap-4 mt-3 text-center">
                <div>
                    <i class="bi bi-shield-check fs-4" style="color: #3D204E;"></i>
                    <small class="d-block">Secure Checkout</small>
                </div>
                <div>
                    <i class="bi bi-truck fs-4" style="color: #3D204E;"></i>
                    <small class="d-block">Free Shipping Over $50</small>
                </div>
                <div>
                    <i class="bi bi-arrow-repeat fs-4" style="color: #3D204E;"></i>
                    <small class="d-block">30-Day Returns</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- PRODUCT INFORMATION ACCORDION -->
    <div class="row g-4 mt-4">
        <div class="col-lg-12 mb-4">
            <div class="accordion transparent-accordion" id="accordionExample">
                <!-- Accordion Item 1: Product Description -->
                <div class="accordion-item border-0 border-bottom" style="border-color: #3D204E !important; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="background: transparent; box-shadow: none; border: none; color: #3D204E;">
                            <span class="fs-5 me-2">Product Description</span>
                            <span class="accordion-icon ms-auto">
                                <i class="bi bi-plus fs-5"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;">
                            <?= nl2br(esc($product['description'])); ?>
                        </div>
                    </div>
                </div>
                
                <!-- Accordion Item 2: Product Details -->
                <div class="accordion-item border-0 border-bottom" style="border-color: #3D204E !important; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background: transparent; box-shadow: none; border: none; color: #3D204E;">
                            <span class="fs-5 me-2">Product Specifications</span>
                            <span class="accordion-icon ms-auto">
                                <i class="bi bi-plus fs-5"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;">
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 200px;"><strong>Available Sizes:</strong></td>
                                    <td>
                                        <?php foreach ($sizes as $size): ?>
                                        <span class="badge bg-light text-dark me-2 p-2"><?= $size['size'] . ' ' . ($size['unit_of_measure'] ?? 'oz'); ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Available Colors:</strong></td>
                                    <td>
                                        <?php foreach ($colors as $color): ?>
                                        <span class="badge bg-light text-dark me-2 p-2">
                                            <span class="d-inline-block rounded-circle me-1" style="width: 12px; height: 12px; background: <?= $color['color_hex']; ?>;"></span>
                                            <?= $this->getColorNameFromHex($color['color_hex']); ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Material:</strong></td>
                                    <td>High-quality ceramic with glossy finish</td>
                                </tr>
                                <tr>
                                    <td><strong>Care Instructions:</strong></td>
                                    <td>Dishwasher and microwave safe</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Accordion Item 3: Delivery & Returns -->
                <div class="accordion-item border-0 border-bottom" style="border-color: #3D204E !important; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="background: transparent; box-shadow: none; border: none; color: #3D204E;">
                            <span class="fs-5 me-2">Delivery & Returns</span>
                            <span class="accordion-icon ms-auto">
                                <i class="bi bi-plus fs-5"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;">
                            <p><strong>Delivery Information:</strong></p>
                            <ul>
                                <li>Estimated delivery: <?= $shippingEstimate['min_days']; ?>–<?= $shippingEstimate['max_days']; ?> business days to <?= $shippingEstimate['country']; ?></li>
                                <li>Shipping cost: Starting at $<?= number_format($shippingCost, 2); ?></li>
                                <li>Free shipping on orders over $50</li>
                                <li>Tracking provided for all orders</li>
                            </ul>
                            <p><strong>Returns Policy:</strong></p>
                            <ul>
                                <li>30-day return window for unused items</li>
                                <li>Customized products are final sale</li>
                                <li>Contact support for return authorization</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RELATED PRODUCTS SECTION -->
<section class="instagram-products py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h2 class="display-6 fw-bold mb-4" style="color: #3D204E;">Other Products You Might Like</h2>
            </div>
            <div class="col-6 text-end">
                <a href="/products" class="view-all-link">View All Products →</a>
            </div>
        </div>

        <div class="row g-3 mb-5" id="relatedProductsContainer">
            <?php if (!empty($relatedProducts)): ?>
                <?php foreach ($relatedProducts as $related): ?>
                <?php 
                    $relatedPrice = $relatedPricing[$related['product_id']]['price'] ?? 0;
                    $relatedOriginal = $relatedPricing[$related['product_id']]['original_price'] ?? 0;
                    $hasRelatedDiscount = $relatedPricing[$related['product_id']]['has_discount'] ?? false;
                    $relatedImage = $relatedImages[$related['product_id']][0] ?? 'images/placeholder-product.png';
                ?>
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <img src="<?= base_url($relatedImage); ?>" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="<?= esc($related['product_name']); ?>">
                            <?php if ($hasRelatedDiscount): ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge" style="background: #e74c3c; color: white;">SALE</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-6 fw-semibold mb-2 text-truncate" style="color: #3D204E;"><?= esc($related['product_name']); ?></h3>
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold fs-4" style="color: #3D204E;">$<?= number_format($relatedPrice, 2); ?></span>
                                    <?php if ($hasRelatedDiscount): ?>
                                    <span class="text-decoration-line-through text-secondary-emphasis small">$<?= number_format($relatedOriginal, 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="/product/<?= $related['slug']; ?>" class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto text-decoration-none" style="border-color: #3D204E;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">More products coming soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="cartToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>Product added to cart successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<?= $this->include('templates/footer'); ?>
<script src="<?= base_url('js/product-details.js'); ?>"></script>
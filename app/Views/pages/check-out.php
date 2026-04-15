<?= $this->include('templates/header'); ?>

<!-- SHOPPING CART SECTION -->
<section class="py-5 my-4">
    <div class="container">
        <!-- Back Navigation -->
        <a href="#" class="back-button" onclick="history.back(); return false;">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <!-- Cart Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="display-5 fw-semibold" style="color: #3D204E;">Your shopping cart</h1>
            <span class="text-secondary">2 items</span>
        </div>

        <!-- Cart Grid -->
        <div class="row g-5">
            <!-- LEFT COLUMN: Cart Items & Coupon -->
            <div class="col-lg-7">
                <!-- Cart Items Table -->
                <div class="table-responsive">
                    <table class="table cart-table align-middle">
                        <thead style="border-bottom: 2px solid #3D204E; color: #3D204E;">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cart Item 1 - Book Cover -->
                            <tr>
                                <td data-label="Product">
                                    <div class="d-flex align-items-center">
                                        <div class="product-image p-2">
                                            <div class="product-image-placeholder">
                                                <img src="images/front-mug.png" alt="Book cover product image">
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <span class="product-title">Book Cover</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Price">$79.00</td>
                                <td data-label="Quantity">
                                    <div class="d-flex align-items-center">
                                        <button class="qty-btn" aria-label="Decrease quantity">−</button>
                                        <span class="qty-input">1</span>
                                        <button class="qty-btn" aria-label="Increase quantity">+</button>
                                    </div>
                                </td>
                                <td data-label="Subtotal" class="text-end fw-bold">$79.00</td>
                            </tr>
                            
                            <!-- Cart Item 2 - Book Cover -->
                            <tr>
                                <td data-label="Product">
                                    <div class="d-flex align-items-center">
                                        <div class="product-image p-2">
                                            <div class="product-image-placeholder">
                                                <img src="images/back-mug.png" alt="Book cover product image">
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <span class="product-title">Book Cover</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Price">$79.00</td>
                                <td data-label="Quantity">
                                    <div class="d-flex align-items-center">
                                        <button class="qty-btn" aria-label="Decrease quantity">−</button>
                                        <span class="qty-input">1</span>
                                        <button class="qty-btn" aria-label="Increase quantity">+</button>
                                    </div>
                                </td>
                                <td data-label="Subtotal" class="text-end fw-bold">$79.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Coupon & Cart Actions -->
                <div class="mt-4 d-flex flex-wrap gap-3 align-items-center">
                    <span class="fw-semibold me-2" style="color: #3D204E;">COUPON CODE</span>
                    <div class="d-flex flex-grow-1" style="max-width: 400px;">
                        <input type="text" class="form-control coupon-input" placeholder="Enter code">
                        <button class="coupon-btn" type="button">APPLY COUPON</button>
                    </div>
                    <button class="update-cart" type="button">UPDATE CART</button>
                </div>
            </div>

            <!-- RIGHT COLUMN: Cart Totals -->
            <div class="col-lg-5">
                <div class="totals-card">
                    <h3 class="fw-semibold mb-4" style="color: #3D204E;">Cart Totals</h3>
                    
                    <!-- Subtotal Line -->
                    <div class="totals-line">
                        <span>Subtotal</span>
                        <span class="fw-semibold">$158.00</span>
                    </div>
                    
                    <!-- Shipping Line -->
                    <div class="totals-line">
                        <span>Shipping</span>
                        <span class="fw-semibold">Calculated at next step</span>
                    </div>

                    <hr class="my-3" style="border-top: 2px dashed #ccc;">

                    <!-- Grand Total -->
                    <div class="d-flex justify-content-between align-items-center grand-total">
                        <span>TOTAL</span>
                        <span>$158.00</span>
                    </div>

                    <!-- Checkout Button -->
                    <button class="checkout-btn mt-5" type="button">PROCEED TO CHECKOUT</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
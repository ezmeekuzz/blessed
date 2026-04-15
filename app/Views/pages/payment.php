<?= $this->include('templates/header'); ?>

<!-- PAYMENT SECTION -->
<section class="py-4 my-3">
    <div class="container">
        <!-- Back Navigation -->
        <a href="#" class="back-button" onclick="history.back(); return false;">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <!-- Payment Header with User Info -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <h1 class="display-5 fw-semibold" style="color: #3D204E;">Payment</h1>
            <div class="text-secondary">
                <i class="bi bi-person-circle me-2"></i> Logged In As <strong>johndoe@gmail.com</strong>.
                <a href="#" class="ms-2 text-decoration-underline" style="color: #3D204E;">Not You?</a>
            </div>
        </div>

        <!-- Required Fields Hint -->
        <p class="text-secondary mb-4"><span class="required-star">*</span> Required</p>

        <!-- Payment Grid -->
        <div class="row g-5">
            <!-- LEFT COLUMN: Billing Form & Payment Methods -->
            <div class="col-lg-7">
                <!-- Billing Details Form -->
                <div class="mb-5">
                    <h3 class="section-title">Billing details</h3>
                    <div class="row g-4">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label class="form-label">First Name<span class="required-star">*</span></label>
                            <input type="text" class="form-control" placeholder="John">
                        </div>
                        
                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label class="form-label">Last Name<span class="required-star">*</span></label>
                            <input type="text" class="form-control" placeholder="Doe">
                        </div>
                        
                        <!-- Email Address -->
                        <div class="col-md-6">
                            <label class="form-label">Email Address<span class="required-star">*</span></label>
                            <input type="email" class="form-control" value="johndoe@gmail.com" placeholder="johndoe@gmail.com">
                        </div>
                        
                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label">Phone Number<span class="required-star">*</span></label>
                            <input type="tel" class="form-control" placeholder="(123) 456-7890">
                        </div>
                        
                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label">Address<span class="required-star">*</span></label>
                            <input type="text" class="form-control" placeholder="Street address, city, state, ZIP">
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mb-4">
                    <h3 class="section-title">Pay With</h3>

                    <!-- Credit/Debit Card Method (Active) -->
                    <div class="payment-method-card active mb-3" id="cardMethod">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-credit-card-2-front fs-4 me-3" style="color:#3D204E;"></i>
                            <span class="fw-semibold fs-5">Credit Or Debit Card</span>
                        </div>

                        <!-- Card Input Fields -->
                        <div class="row g-3">
                            <!-- Card Number -->
                            <div class="col-12">
                                <label class="form-label">Card Number<span class="required-star">*</span></label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            
                            <!-- Expiration Date -->
                            <div class="col-md-5">
                                <label class="form-label">Expiration Date<span class="required-star">*</span></label>
                                <input type="text" class="form-control" placeholder="MM/YY">
                            </div>
                            
                            <!-- Security Code -->
                            <div class="col-md-3">
                                <label class="form-label">Security Code<span class="required-star">*</span></label>
                                <input type="text" class="form-control" placeholder="123">
                            </div>
                            
                            <!-- Zip Code -->
                            <div class="col-md-4">
                                <label class="form-label">Zip Code<span class="required-star">*</span></label>
                                <input type="text" class="form-control" placeholder="90210">
                            </div>
                        </div>

                        <!-- Save Payment Details Option -->
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="saveDetails">
                            <label class="form-check-label text-secondary" for="saveDetails">
                                Save Payment Details (Optional)
                            </label>
                        </div>
                    </div>

                    <!-- PayPal Method -->
                    <div class="paypal-section d-flex flex-wrap align-items-center justify-content-between mt-4">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-brands fa-cc-paypal fs-2" style="color:#003087;"></i>
                            <span class="fw-semibold fs-5">PayPal</span>
                        </div>
                        <p class="mb-0 text-secondary small w-100 w-md-auto mt-2 mt-md-0">
                            Proceed Below With Your PayPal Account And Complete Your Purchase.
                        </p>
                        <button class="paypal-btn mt-3 mt-lg-0 w-100 w-md-auto">Continue with PayPal</button>
                    </div>
                </div>

                <!-- Terms & Place Order -->
                <div class="mt-5">
                    <p class="terms-text mb-3">
                        By selecting Place Order, I agree to the CityAgenda
                        <a href="#" style="color: #3D204E; text-decoration: underline;">Terms of Services</a>
                    </p>
                    <button class="place-order-btn">Place Order</button>
                </div>
            </div>

            <!-- RIGHT COLUMN: Order Summary -->
            <div class="col-lg-5">
                <div class="order-summary-card">
                    <h3 class="section-title mb-4">Order Summary</h3>

                    <!-- Delivery Date -->
                    <div class="delivery-badge mb-4">
                        <i class="bi bi-calendar3 me-2"></i> Friday, December 27 · 12 - 9PM PST
                    </div>

                    <!-- Order Item -->
                    <div class="summary-item">
                        <span class="product-title-sm">Book Cover x3</span>
                        <span class="fw-semibold">$237.00</span>
                    </div>

                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 2px solid #d3c5db;">
                        <span class="fs-3 fw-bold" style="color: #3D204E;">Total</span>
                        <span class="fs-2 fw-bold" style="color: #3D204E;">$237.00</span>
                    </div>

                    <!-- Accepted Payment Cards -->
                    <div class="mt-4 d-flex gap-2 justify-content-center">
                        <i class="fa-brands fa-cc-visa fs-2 text-secondary"></i>
                        <i class="fa-brands fa-cc-mastercard fs-2 text-secondary"></i>
                        <i class="fa-brands fa-cc-amex fs-2 text-secondary"></i>
                        <i class="fa-brands fa-cc-paypal fs-2 text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
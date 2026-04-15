<?= $this->include('templates/header'); ?>

<!-- THANK YOU SECTION (replaces previous payment section) -->
<section class="thank-you-section py-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7 text-center">
                <!-- Success/Thank you icon -->
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 100px; height: 100px; background: rgba(61, 32, 78, 0.1);">
                        <i class="bi bi-check-circle-fill" style="font-size: 3.5rem; color: #3D204E;"></i>
                    </div>
                </div>
                        
                <!-- Main thank you message (with line break as shown in image) -->
                <h1 class="display-2 fw-bold mb-3" style="color: #3D204E; line-height: 1.2;">
                    Thank You For Your<br>Purchase!🎉
                </h1>
                        
                <!-- Success confirmation message -->
                <p class="lead fs-4 text-secondary mb-4" style="color: #555; max-width: 600px; margin-left: auto; margin-right: auto;">
                    Your order has been successfully placed, and we're excited to have you as our customer.
                </p>
                        
                <!-- Order processing details -->
                <p class="fs-5 mb-5" style="color: #666; max-width: 650px; margin-left: auto; margin-right: auto;">
                    We're currently processing your purchase and will notify you as soon as it's on its way. A 
                    confirmation email with your order details has been sent to your inbox.
                </p>
                        
                <!-- Back to homepage button -->
                <a href="#" class="btn px-5 py-3 rounded-pill text-white fs-5 fw-semibold border-0" style="background: #3D204E; min-width: 250px;">
                    BACK TO HOMEPAGE
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
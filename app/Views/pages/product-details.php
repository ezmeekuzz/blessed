<?= $this->include('templates/header'); ?>

<!-- BREADCRUMB NAVIGATION SECTION -->
<section class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0 fs-5">
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mugs</li>
            </ol>
        </nav>
        <div class="share-icon d-flex align-items-center gap-1">
            <i class="bi bi-share"></i> <span class="fs-6 fw-light">Share</span>
        </div>
    </div>
</section>

<!-- PRODUCT DETAILS SECTION -->
<section class="container mt-4">
    <div class="row g-5">
        <!-- LEFT COLUMN: Product Images -->
        <div class="col-md-6">
            <!-- Main Product Image -->
            <div class="product-img-large position-relative">
                <img src="images/product-1.png" alt="White Glossy Mug" class="img-square">
                <button class="btn position-absolute top-0 end-0 m-3 p-2 rounded-circle bg-white border-0 shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;" aria-label="Add to wishlist">
                    <i class="bi bi-heart fs-5" style="color: #3D204E;"></i>
                </button>
            </div>
            
            <!-- Thumbnail Images -->
            <div class="d-flex gap-3 mt-3">
                <img src="images/product-1.png" alt="Product thumbnail 1" class="thumb-img active">
                <img src="images/product-2.png" alt="Product thumbnail 2" class="thumb-img">
                <img src="images/product-3.png" alt="Product thumbnail 3" class="thumb-img">
            </div>
        </div>

        <!-- RIGHT COLUMN: Product Details -->
        <div class="col-md-6">
            <!-- Product Title -->
            <h1 class="display-5 fw-bold" style="color: #3D204E;">White Glossy Mug</h1>
            
            <!-- Product Description -->
            <p class="mt-3" style="font-size: 1.2rem; line-height: 1.4;">
                Enjoy your favorite tea or coffee by the fire with the 14 oz. Rover <br>
                Stainless Steel Insulated Camper Mug! Its durable, double-wall vacuum <br>
                construction keeps your beverage hot for 5 hours or cold for 15 hours.
            </p>

            <!-- Color Options -->
            <div class="mt-4">
                <span class="fw-semibold fs-6">Color</span>
                <div class="mt-2">
                    <span class="size-badge active" style="background:#fff; border:2px solid #3D204E; color:#3D204E; font-weight:500;">White</span>
                </div>
            </div>

            <!-- Size Options -->
            <div class="mt-4">
                <span class="fw-semibold fs-6">Size</span>
                <div class="d-flex flex-wrap gap-2 mt-2">
                    <span class="size-badge">11 oz</span>
                    <span class="size-badge active">14 oz</span>
                    <span class="size-badge">20 oz</span>
                </div>
            </div>

            <!-- Price & Delivery Information -->
            <div class="mt-4 d-flex flex-wrap align-items-center gap-3">
                <!-- Price Block -->
                <div>
                    <span class="text-secondary small">Price*</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold fs-2" style="color: #3D204E;">$7.95</span>
                        <span class="text-secondary small fw-light">Print included</span>
                    </div>
                </div>
                
                <!-- Separator Dot -->
                <span class="dot-separator mx-2" style="width:6px; height:6px; background:#3D204E; border-radius:50%; display:inline-block;"></span>
                
                <!-- Estimated Delivery -->
                <div>
                    <span class="fw-medium">Estimated Delivery To:</span>
                    <span class="fw-bold">United States</span>
                    <span class="fw-semibold ms-1">Feb 3–7</span>
                </div>
                
                <!-- Separator Dot -->
                <span class="dot-separator mx-2" style="width:6px; height:6px; background:#3D204E; border-radius:50%; display:inline-block;"></span>
                
                <!-- Shipping Information -->
                <div>
                    <span class="text-secondary">Shipping Starts At</span>
                    <span class="fw-semibold">$12.99</span>
                </div>
            </div>

            <!-- Start Designing Button -->
            <div class="d-flex align-items-center justify-content-center gap-3 my-4">
                <a href="#products" class="btn px-5 py-3 rounded-pill text-white fs-5 w-100" style="background: #3D204E;">Start Designing</a>
            </div>
        </div>
    </div>
    
    <!-- PRODUCT INFORMATION ACCORDION -->
    <div class="row g-4 mt-2">
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
                            This sturdy mug is perfect for your morning coffee, afternoon tea, or whatever hot beverage you enjoy. It's glossy white and yields vivid prints that retain their quality when dish-washed and microwaved. Add a graphic of your choice and add this best-seller to your store, so others can enjoy your magical designs too!.Disclaimer: The White Glossy Mug may vary slightly in size by up to +/- 0.1″ (2 mm) due to the nature of the production process. These variations are normal and won’t affect your mug’s quality or functionality. This product is made on demand. No minimums.
                        </div>
                    </div>
                </div>
                
                <!-- Accordion Item 2: Product Details -->
                <div class="accordion-item border-0 border-bottom" style="border-color: #3D204E !important; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="background: transparent; box-shadow: none; border: none; color: #3D204E;">
                            <span class="fs-5 me-2">Product Details</span>
                            <span class="accordion-icon ms-auto">
                                <i class="bi bi-plus fs-5"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;">
                            After selecting your product, you'll be taken to our customization page where you can upload your design files. Simply click the "Upload Design" button, select your file from your computer, and position it on the product preview. We accept JPG, PNG, and PDF files up to 20MB.
                        </div>
                    </div>
                </div>
                
                <!-- Accordion Item 3: Delivery Options -->
                <div class="accordion-item border-0 border-bottom" style="border-color: #3D204E !important; background: transparent;">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-semibold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="background: transparent; box-shadow: none; border: none; color: #3D204E;">
                            <span class="fs-5 me-2">Delivery Options</span>
                            <span class="accordion-icon ms-auto">
                                <i class="bi bi-plus fs-5"></i>
                            </span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;">
                            For best results, we recommend high-resolution files (300 DPI) in JPG, PNG, or PDF format. Your design should be at least 1000 x 1000 pixels. For text-only designs, we offer various fonts you can choose from without needing to upload a file.
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
        </div>

        <div class="row g-3 mb-5">
            <!-- Related Product 1 - Mug -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-1.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom mug">
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-3 gap-2 gap-sm-0">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-4" style="color: #3D204E;">$14.95</span>
                            <span class="text-decoration-line-through text-secondary-emphasis small">$20.00</span>
                        </div>
                        <button class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto" style="border-color: #3D204E; --bs-btn-hover-bg: #3D204E; --bs-btn-hover-color: white; --bs-btn-hover-border-color: #3D204E;">
                            Personalize Design
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Product 2 - Phone Case -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-2.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom phone case">
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-3 gap-2 gap-sm-0">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-4" style="color: #3D204E;">$14.95</span>
                            <span class="text-decoration-line-through text-secondary-emphasis small">$20.00</span>
                        </div>
                        <button class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto" style="border-color: #3D204E; --bs-btn-hover-bg: #3D204E; --bs-btn-hover-color: white; --bs-btn-hover-border-color: #3D204E;">
                            Personalize Design
                        </button>
                    </div>
                </div>
            </div>

            <!-- Related Product 3 - Bible Cover -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-3.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom bible cover">
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-3 gap-2 gap-sm-0">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold fs-4" style="color: #3D204E;">$14.95</span>
                        </div>
                        <button class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto" style="border-color: #3D204E; --bs-btn-hover-bg: #3D204E; --bs-btn-hover-color: white; --bs-btn-hover-border-color: #3D204E;">
                            Personalize Design
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
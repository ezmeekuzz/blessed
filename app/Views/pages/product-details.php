<?= $this->include('templates/header'); ?>

<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Your existing styles */
.skeleton-text {
    height: 20px;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 4px;
}

@keyframes shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
</style>

<section class="container mt-3" id="breadCrumbs"></section>

<section class="container mt-4">
    <div class="row g-5">
        <div class="col-md-6" id="productImages"></div>

        <div class="col-md-6">
            <h1 class="display-5 fw-bold" style="color: #3D204E;" id="productName"></h1>
            
            <p class="mt-3" style="font-size: 1.2rem; line-height: 1.4;" id="productDescription"></p>

            <div class="mt-4">
                <span class="fw-semibold fs-6">Color</span>
                <div class="mt-2" id="colorLists"></div>
            </div>

            <div class="mt-4">
                <span class="fw-semibold fs-6">Size</span>
                <div class="d-flex flex-wrap gap-2 mt-2" id="sizeLists"></div>
            </div>

            <div class="mt-4 d-flex flex-wrap align-items-center gap-3">
                <div>
                    <span class="text-secondary small">Price*</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold fs-2" style="color: #3D204E;" id="productPrice"></span>
                        <span class="text-secondary small fw-light">Print included</span>
                    </div>
                </div>
                <span class="dot-separator mx-2" style="width:6px; height:6px; background:#3D204E; border-radius:50%; display:inline-block;"></span>
                <div>
                    <span class="fw-medium">Estimated Delivery To:</span>
                    <span class="fw-bold">United States</span>
                    <span class="fw-semibold ms-1">Feb 3–7</span>
                </div>
                <span class="dot-separator mx-2" style="width:6px; height:6px; background:#3D204E; border-radius:50%; display:inline-block;"></span>
                <div>
                    <span class="text-secondary">Shipping Starts At</span>
                    <span class="fw-semibold">$12.99</span>
                </div>
            </div>

            <!-- START DESIGNING button with ID -->
            <div class="d-flex align-items-center justify-content-center gap-3 my-4">
                <a href="#" id="startDesigningBtn" class="btn px-5 py-3 rounded-pill text-white fs-5 w-100" style="background: #3D204E;">Start Designing</a>
            </div>
        </div>
    </div>
            
    <div class="row g-4 mt-2">
        <div class="col-lg-12 mb-4">
            <div class="accordion transparent-accordion" id="accordionExample">
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
                        <div class="fs-5 accordion-body px-0 py-3" style="background: transparent;" id="accordionDescription"></div>
                    </div>
                </div>
                        
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

<section class="instagram-products py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h2 class="display-6 fw-bold mb-4" style="color: #3D204E;">Other Products You Might Like</h2>
            </div>
        </div>
        <div class="row g-3 mb-5" id="otherProducts"></div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>

<script>
    let productId = "<?=$product['product_id'];?>";
    let productSlug = "<?=$product['slug'];?>";
</script>
<script src="<?= base_url('js/product-details.js'); ?>"></script>
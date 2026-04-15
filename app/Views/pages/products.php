<?= $this->include('templates/header'); ?>

<!-- HERO SECTION -->
<section class="hero-products mt-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold" style="color: #3D204E;">Create Your Own Personalized Products</h1>
                <p class="fs-5 mt-3">We offer a unique range of customizable, faith-based products that blend creativity, spiritual growth, and mental wellness. Whether it's a mug, journal, or vision board, our products are designed to inspire, motivate, and help you visualize your spiritual and personal goals every single day.</p>
                <div class="d-flex align-items-center justify-content-center gap-3 my-4">
                    <a href="#products" class="btn px-5 py-3 rounded-pill text-white fs-5" style="background: #3D204E;">How It Works</a>
                </div>
            </div>
        </div>
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
            <div class="sort-dropdown dropdown" style="max-width: 220px;">
                <button class="btn btn-outline-dark dropdown-toggle rounded-3 px-4 py-2 h-100 w-100 text-start" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-2"></i>Sort By: Most Popular
                </button>
                <ul class="dropdown-menu w-100 dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Most Popular</a></li>
                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCT GRID -->
<section class="product-grid py-5" id="products">
    <div class="container">
        <!-- Category Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h2 class="fw-bold mb-0" style="color: #3D204E; font-size: clamp(1.8rem, 4vw, 2.2rem);">All Accessories</h2>
            <span class="badge bg-light text-dark rounded-pill px-4 py-2 fs-6">9 Results</span>
        </div>

        <!-- Product Grid -->
        <div class="row g-3 g-sm-4">
            <!-- Product Card 1 - Mug -->
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

            <!-- Product Card 2 - Phone Case -->
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

            <!-- Product Card 3 - Bible Cover -->
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

            <!-- Product Card 4 - Tote Bag -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-1.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom tote bag">
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

            <!-- Product Card 5 - Wall Poster -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-2.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom wall poster">
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

            <!-- Product Card 6 - Tumbler -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-3.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom tumbler">
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

            <!-- Product Card 7 - Photo Tile -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-1.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom photo tile">
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

            <!-- Product Card 8 - Pins -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-2.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom pins">
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

            <!-- Product Card 9 - Journal -->
            <div class="col-6 col-md-4">
                <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                    <div class="position-relative" style="aspect-ratio: 1/1;">
                        <img src="images/product-3.png" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Custom journal">
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

<!-- INSTAGRAM SECTION -->
<section class="instagram-products py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h2 class="display-6 fw-bold mb-4" style="color: #3D204E;">Check Out Our Products On Instagram</h2>
            </div>
        </div>

        <div class="row g-3 mb-5">
            <!-- Instagram Image 1 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-1.png" alt="Product 1" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Image 2 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-2.png" alt="Product 2" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Image 3 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-3.png" alt="Product 3" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Image 4 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-4.png" alt="Product 4" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
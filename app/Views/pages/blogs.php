<?= $this->include('templates/header'); ?>

<!-- BLOG HEADER SECTION -->
<section class="blog-header mt-5">
    <div class="container">
        <h1 class="text-center mb-3 display-4 fw-semibold section-title">Find Hope And Encouragement Each Day</h1>
        <div class="row g-4 align-items-center">
            <div class="col-lg-8 mx-auto text-center mb-4">
                <p class="fs-5 text-secondary">Small Moments of Positivity to Brighten Your Day</p>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH AND FILTER SECTION -->
<section class="search-section py-4">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="d-flex flex-column flex-md-row gap-3">
                    <!-- Search Box -->
                    <div class="search-box d-flex align-items-center flex-grow-1">
                        <i class="fas fa-search text-secondary me-2"></i>
                        <input type="text" placeholder="Search By Title" class="bg-transparent w-100">
                        <button class="btn btn-link text-decoration-none" style="color: #3D204E;">Search</button>
                    </div>
                    
                    <!-- Categories Dropdown -->
                    <div class="dropdown" style="max-width: 220px;">
                        <button class="btn btn-outline-dark dropdown-toggle rounded-3 px-4 py-2 h-100 w-100 text-start" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>All Categories
                        </button>
                        <ul class="dropdown-menu w-100 dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">All Categories</a></li>
                            <li><a class="dropdown-item" href="#">Devotionals</a></li>
                            <li><a class="dropdown-item" href="#">Inspiration</a></li>
                            <li><a class="dropdown-item" href="#">Faith & Prayer</a></li>
                            <li><a class="dropdown-item" href="#">Testimonies</a></li>
                            <li><a class="dropdown-item" href="#">Scripture Study</a></li>
                            <li><a class="dropdown-item" href="#">Product Updates</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BLOG POSTS GRID -->
        <div class="row g-4">
            <!-- Blog Post 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="post-card h-100 rounded-4" style="background-image: url('images/hero-bg.png');">
                    <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                        <div class="post-meta">
                            <span class="read-time text-white">
                                <i class="far fa-clock me-2"></i>12 Mins Read
                            </span>
                            <a href="#" class="fs-5 text-decoration-none text-white">
                                <span class="post-title">Radiate | Devotions to Reflect the Heart of Jesus</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Blog Post 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="post-card h-100 rounded-4" style="background-image: url('images/hero-bg.png');">
                    <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                        <div class="post-meta">
                            <span class="read-time text-white">
                                <i class="far fa-clock me-2"></i>12 Mins Read
                            </span>
                            <a href="#" class="fs-5 text-decoration-none text-white">
                                <span class="post-title">Radiate | Devotions to Reflect the Heart of Jesus</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Blog Post 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="post-card h-100 rounded-4" style="background-image: url('images/hero-bg.png');">
                    <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                        <div class="post-meta">
                            <span class="read-time text-white">
                                <i class="far fa-clock me-2"></i>12 Mins Read
                            </span>
                            <a href="#" class="fs-5 text-decoration-none text-white">
                                <span class="post-title">Radiate | Devotions to Reflect the Heart of Jesus</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INSTAGRAM PRODUCTS SECTION -->
<section class="instagram-products py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-5 fw-bold mb-4" style="color: #3D204E;">Check Out Our Products On Instagram</h2>
            </div>
        </div>

        <div class="row g-3 mb-5">
            <!-- Instagram Product 1 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-1.png" alt="Instagram product 1" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Product 2 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-2.png" alt="Instagram product 2" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Product 3 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-3.png" alt="Instagram product 3" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Product 4 -->
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                    <img src="images/instagram-product-4.png" alt="Instagram product 4" class="w-100 h-100 object-fit-cover">
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
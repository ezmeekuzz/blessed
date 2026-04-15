<?= $this->include('templates/header'); ?>

<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center min-vh-50 g-5">
            <div class="col-lg-6 d-flex flex-column justify-content-center text-center text-lg-start">
                <h1 class="display-1 fw-semibold mb-4">
                    <span style="color: #3D204E;">Bring Your Vision</span><br>
                    <span style="color: #3D204E;">To Life</span>
                </h1>
                <p class="lead fs-5 mt-3" style="line-height: 1.8; color: #4a4a4a;">
                    To create a meaningful product, start by selecting a favorite Bible verse that aligns with your theme. Use our app to easily find verses by keywords or themes. Pair the verse with a relevant image like a peaceful landscape for a verse about calm or mountains for strength. This simple combination of scripture and imagery will create a product with both visual appeal and a deeper message.
                </p>
                
                <!-- Feature badges -->
                <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center justify-content-lg-start">
                    <span class="badge rounded-pill px-4 py-2 fs-6" style="background: #F9F7FA; color: #3D204E; border: 1px solid #d9cde0;">
                        <i class="bi bi-search me-2"></i>Search by Theme
                    </span>
                    <span class="badge rounded-pill px-4 py-2 fs-6" style="background: #F9F7FA; color: #3D204E; border: 1px solid #d9cde0;">
                        <i class="bi bi-image me-2"></i>Add Images
                    </span>
                    <span class="badge rounded-pill px-4 py-2 fs-6" style="background: #F9F7FA; color: #3D204E; border: 1px solid #d9cde0;">
                        <i class="bi bi-palette me-2"></i>Customize Design
                    </span>
                </div>
            </div>
            
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <div class="position-relative">
                    <img src="images/how-to-page-bg.png" class="img-fluid rounded-4 shadow" alt="Create your custom design">
                    <!-- Play button overlay -->
                    <a href="#video-section" class="position-absolute top-50 start-50 translate-middle">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                            <i class="bi bi-play-fill fs-1" style="color: #3D204E;"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Steps Section -->
<section class="steps-section py-5" style="background: #F9F7FA;">
    <div class="container">
        <h2 class="text-center display-4 fw-semibold mb-5" style="color: #3D204E;">How It Works</h2>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card text-center p-4 h-100">
                    <div class="step-number mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-white" style="width: 60px; height: 60px; border: 2px solid #3D204E; color: #3D204E; font-size: 24px; font-weight: bold;">1</div>
                    <h4 class="fw-semibold mb-3" style="color: #3D204E;">Choose Your Verse</h4>
                    <p class="text-secondary">Search by keyword, theme, or book to find the perfect scripture that speaks to your message.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card text-center p-4 h-100">
                    <div class="step-number mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-white" style="width: 60px; height: 60px; border: 2px solid #3D204E; color: #3D204E; font-size: 24px; font-weight: bold;">2</div>
                    <h4 class="fw-semibold mb-3" style="color: #3D204E;">Select Your Image</h4>
                    <p class="text-secondary">Choose from our library of beautiful images or upload your own to complement your verse.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card text-center p-4 h-100">
                    <div class="step-number mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-white" style="width: 60px; height: 60px; border: 2px solid #3D204E; color: #3D204E; font-size: 24px; font-weight: bold;">3</div>
                    <h4 class="fw-semibold mb-3" style="color: #3D204E;">Create & Order</h4>
                    <p class="text-secondary">Customize fonts, colors, and layout, then preview your design before ordering.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Presentation Section -->
<section class="video-presentation py-5" id="video-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-4 display-4 fw-semibold" style="color: #3D204E;">
                    Watch Video On How To Make Your Own<br>Custom Product Design
                </h2>
                <p class="text-center fs-5 text-secondary mb-5">Learn the step-by-step process to create your personalized faith-based products</p>
                
                <div class="ratio ratio-16x9 rounded-4 overflow-hidden shadow-lg">
                    <iframe 
                        src="https://www.youtube.com/embed/VbDx4iZ3O1Q?si=l28JeQMSoErGEkgl" 
                        title="How to create custom design video tutorial"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            
            <div class="col-12 text-center mt-5">
                <a href="#products" class="btn px-5 py-3 rounded-pill text-white fs-5 fw-semibold" style="background: #3D204E; display: inline-block; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#5a2d74'" onmouseout="this.style.backgroundColor='#3D204E'">
                    Start Your Journey Today
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Instagram Products Section -->
<section class="instagram-products py-5" style="background: #F9F7FA;">
    <div class="container">
        <div class="row mb-5 align-items-end">
            <div class="col-md-8">
                <h2 class="display-4 fw-semibold mb-3" style="color: #3D204E;">Check Out Our Products On Instagram</h2>
                <p class="fs-5 text-secondary">See how others are creating beautiful faith-based products and get inspired for your own design</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="#" class="btn btn-outline-primary rounded-pill px-4 py-2" style="color: #3D204E; border-color: #3D204E;">
                    Follow Us <i class="bi bi-instagram ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1; cursor: pointer;">
                    <img src="images/instagram-product-1.png" alt="Custom design product on Instagram" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(61,32,78,0.3) 0%, rgba(61,32,78,0.7) 100%); transition: all 0.3s ease;"></div>
                    <div class="position-absolute top-50 start-50 translate-middle opacity-75 hover-show">
                        <i class="bi bi-instagram text-white fs-1"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-3 text-white">
                        <small class="d-block">@blessedmanifest</small>
                        <small><i class="bi bi-heart-fill me-1"></i> 234</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1; cursor: pointer;">
                    <img src="images/instagram-product-2.png" alt="Custom design product on Instagram" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(61,32,78,0.3) 0%, rgba(61,32,78,0.7) 100%); transition: all 0.3s ease;"></div>
                    <div class="position-absolute top-50 start-50 translate-middle opacity-75 hover-show">
                        <i class="bi bi-instagram text-white fs-1"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-3 text-white">
                        <small class="d-block">@blessedmanifest</small>
                        <small><i class="bi bi-heart-fill me-1"></i> 189</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1; cursor: pointer;">
                    <img src="images/instagram-product-3.png" alt="Custom design product on Instagram" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(61,32,78,0.3) 0%, rgba(61,32,78,0.7) 100%); transition: all 0.3s ease;"></div>
                    <div class="position-absolute top-50 start-50 translate-middle opacity-75 hover-show">
                        <i class="bi bi-instagram text-white fs-1"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-3 text-white">
                        <small class="d-block">@blessedmanifest</small>
                        <small><i class="bi bi-heart-fill me-1"></i> 312</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1; cursor: pointer;">
                    <img src="images/instagram-product-4.png" alt="Custom design product on Instagram" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(61,32,78,0.3) 0%, rgba(61,32,78,0.7) 100%); transition: all 0.3s ease;"></div>
                    <div class="position-absolute top-50 start-50 translate-middle opacity-75 hover-show">
                        <i class="bi bi-instagram text-white fs-1"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 p-3 text-white">
                        <small class="d-block">@blessedmanifest</small>
                        <small><i class="bi bi-heart-fill me-1"></i> 156</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View more link -->
        <div class="text-center mt-5">
            <a href="#" class="text-decoration-none fw-semibold" style="color: #3D204E;">
                View More On Instagram <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="testimonial-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h3 class="display-6 fw-semibold mb-4" style="color: #3D204E;">What Our Customers Say</h3>
                <div class="testimonial-card p-5" style="background: #F9F7FA; border-radius: 24px;">
                    <i class="bi bi-quote fs-1" style="color: #3D204E; opacity: 0.3;"></i>
                    <p class="fs-4 fst-italic mb-4">"The process was so simple and meaningful. I created a custom piece with my favorite verse for my daughter's room, and it turned out beautiful!"</p>
                    <div>
                        <h5 class="fw-semibold mb-1">Sarah Johnson</h5>
                        <p class="text-secondary">Verified Customer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
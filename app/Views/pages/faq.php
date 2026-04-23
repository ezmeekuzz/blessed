<?= $this->include('templates/header'); ?>

<!-- FAQ Banner Section -->
<section class="faq-banner mt-5">
    <div class="container">
        <h1 class="text-center display-4 fw-semibold section-title">Frequently Asked Questions</h1>
        <div class="row g-4 align-items-center">
            <div class="col-lg-8 mx-auto text-center mb-4">
                <p class="fs-5">Common questions about the company and all the answers you need to get started</p>
            </div>
        </div>
    </div>
    <!-- Full width image outside container -->
    <div class="container-fluid p-0">
        <img src="<?= base_url('images/faq-bg.png') ?>" alt="FAQ banner" class="w-100" style="display: block;">
    </div>
</section>

<!-- FAQ Questions Section -->
<section class="faq-questions mt-5 py-5">
    <div class="container">
        <div class="row g-4 justify-content-center text-start">
            <div class="col-lg-8 mb-4">
                <h3 class="display-6 fw-semibold section-title mb-4" style="color: #3D204E;">Frequently Asked Questions</h3>
                
                <div class="accordion custom-accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                What Products Can I Customize?
                                <i class="fas fa-minus accordion-icon ms-auto"></i>
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-white">
                                You can customize a wide range of products including journals, mugs, t-shirts, hoodies, tote bags, phone cases, wall art, and greeting cards. Each product can be personalized with your favorite scripture verses, faith-inspired quotes, or custom designs that reflect your spiritual journey.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                How Do I Upload My Design?
                                <i class="fas fa-plus accordion-icon ms-auto"></i>
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-white">
                                After selecting your product, you'll be taken to our customization page where you can upload your design files. Simply click the "Upload Design" button, select your file from your computer, and position it on the product preview. We accept JPG, PNG, and PDF files up to 20MB.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                What Are The File Requirements For My Design?
                                <i class="fas fa-plus accordion-icon ms-auto"></i>
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-white">
                                For best results, we recommend high-resolution files (300 DPI) in JPG, PNG, or PDF format. Your design should be at least 1000 x 1000 pixels. For text-only designs, we offer various fonts you can choose from without needing to upload a file.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 4 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                How Long Will It Take To Receive My Order?
                                <i class="fas fa-plus accordion-icon ms-auto"></i>
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-white">
                                Production typically takes 3-5 business days. Shipping times vary based on your location: US orders arrive in 3-7 business days, international orders in 10-20 business days. You'll receive a tracking number once your order ships.
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden FAQs (initially hidden) -->
                    <div id="moreFaqs" style="display: none;">
                        <!-- FAQ Item 5 -->
                        <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                    What Is Your Return Policy?
                                    <i class="fas fa-plus accordion-icon ms-auto"></i>
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    We offer a 30-day return policy for unused and undamaged products. Customized items are non-refundable unless there is a manufacturing defect. Please contact our support team for assistance with returns.
                                </div>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 6 -->
                        <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                                    Do You Offer Wholesale Pricing?
                                    <i class="fas fa-plus accordion-icon ms-auto"></i>
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    Yes, we offer wholesale pricing for churches, ministries, and retailers. Please contact our wholesale department at wholesale@theblessedmanifest.com.au for a custom quote and minimum order requirements.
                                </div>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 7 -->
                        <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                                    Can I Cancel Or Modify My Order?
                                    <i class="fas fa-plus accordion-icon ms-auto"></i>
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    Orders can be canceled within 2 hours of placement. Once production has begun, modifications or cancellations may not be possible. Please contact our support team immediately if you need to make changes.
                                </div>
                            </div>
                        </div>
                        
                        <!-- FAQ Item 8 -->
                        <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false" aria-controls="faq8">
                                    Do You Ship Internationally?
                                    <i class="fas fa-plus accordion-icon ms-auto"></i>
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body bg-white">
                                    Yes, we ship worldwide! International shipping times vary from 10-20 business days depending on your location. Customs fees and import duties may apply and are the responsibility of the customer.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Read More Button -->
                <div id="readMoreContainer" class="col-12 text-center mt-5">
                    <button id="readMoreBtn" class="btn px-5 py-3 rounded-pill text-white fs-5" style="background: #3D204E; display: inline-block;">
                        Read More FAQs <i class="fas fa-arrow-down ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column - Contact Info -->
            <div class="col-lg-5">
                <h1 class="display-1 fw-semibold mb-4" style="color: #3D204E;">Still Have Questions?</h1>
                <p class="lead fs-5 text-secondary mb-4">We would love to hear from you. Please <a href="mailto:hello@TheBlessedManifest.com.au" style="color: #3D204E; text-decoration: underline; text-underline-offset: 4px;">contact us at hello@TheBlessedManifest.com.au</a> or fill in the below form.</p>
                
                <form class="contact-form" id="contactForm">
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold mb-2">Your Name</label>
                        <input type="text" class="form-control form-control-lg rounded-0 border-0 border-bottom" id="name" name="name" placeholder="Enter your full name" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold mb-2">Your Email</label>
                        <input type="email" class="form-control form-control-lg rounded-0 border-0 border-bottom" id="email" name="email" placeholder="Enter your email address" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
                    </div>

                    <!-- Reason for Contact Dropdown -->
                    <div class="mb-4">
                        <label for="reason" class="form-label fw-semibold mb-2">Choose Your Reason For Contacting Us</label>
                        <select class="form-select form-select-lg rounded-0 border-0 border-bottom" id="reason" name="reason" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
                            <option selected disabled>Select a reason</option>
                            <option>General Inquiry</option>
                            <option>Product Question</option>
                            <option>Order Support</option>
                            <option>Custom Order</option>
                            <option>Wholesale</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <!-- Message Field -->
                    <div class="mb-5">
                        <label for="message" class="form-label fw-semibold mb-2">Write Your Message</label>
                        <textarea class="form-control rounded-0 border-0 border-bottom" id="message" name="message" rows="4" placeholder="Type your message here..." style="border-color: #3D204E !important; background-color: transparent; padding-left: 0; resize: none;"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-start">
                        <button type="submit" class="btn px-5 py-3 rounded-pill text-white fs-5 fw-semibold border-0" style="background: #3D204E; min-width: 200px;">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Right Column - Image -->
            <div class="col-lg-7 py-5">
                <img src="<?= base_url('images/contact-bg.png') ?>" class="img-fluid rounded-4" alt="Contact">
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/faq.js'); ?>"></script>
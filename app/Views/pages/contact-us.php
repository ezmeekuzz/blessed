<?=$this->include('templates/header');?>
<section class="contact-section mt-5 py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Left Column - Contact Info -->
            <div class="col-lg-5">
                <h1 class="display-1 fw-semibold mb-4" style="color: #3D204E;">Drop Us A Line</h1>
                <p class="lead fs-5 text-secondary mb-4">We would love to hear from you. Please <a href="mailto:hello@TheBlessedManifest.com.au" style="color: #3D204E; text-decoration: underline; text-underline-offset: 4px;">contact us at hello@TheBlessedManifest.com.au</a> or fill in the below form.</p>
                <form class="contact-form">
                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold mb-2">Your Name</label>
                        <input type="text" class="form-control form-control-lg rounded-0 border-0 border-bottom" id="name" placeholder="Enter your full name" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold mb-2">Your Email</label>
                        <input type="email" class="form-control form-control-lg rounded-0 border-0 border-bottom" id="email" placeholder="Enter your email address" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
                    </div>

                    <!-- Reason for Contact Dropdown -->
                    <div class="mb-4">
                        <label for="reason" class="form-label fw-semibold mb-2">Choose Your Reason For Contacting Us</label>
                        <select class="form-select form-select-lg rounded-0 border-0 border-bottom" id="reason" style="border-color: #3D204E !important; background-color: transparent; padding-left: 0;">
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
                        <textarea class="form-control rounded-0 border-0 border-bottom" id="message" rows="4" placeholder="Type your message here..." style="border-color: #3D204E !important; background-color: transparent; padding-left: 0; resize: none;"></textarea>
                    </div>

                    <!-- reCAPTCHA and Privacy info for mobile -->
                    <div class="mb-4 d-lg-none">
                        <p class="small text-secondary mb-1">protected by reCAPTCHA</p>
                        <div class="d-flex gap-3">
                            <a href="#" class="small text-secondary text-decoration-none">Privacy</a>
                            <span class="small text-secondary">-</span>
                            <a href="#" class="small text-secondary text-decoration-none">Terms</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-start">
                        <button type="submit" class="btn px-5 py-3 rounded-pill text-white fs-5 fw-semibold border-0" style="background: #3D204E; min-width: 200px;">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-7 py-5">
                <img src="images/contact-bg.png" class="img-fluid rounded-4">
            </div>
        </div>
    </div>
</section>
<?=$this->include('templates/footer');?>
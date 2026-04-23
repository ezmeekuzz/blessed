<?= $this->include('templates/header'); ?>

<!-- Shipping Policy Banner Section -->
<section class="shipping-banner mt-5">
    <div class="container">
        <h1 class="text-center display-4 fw-semibold section-title" style="color: #3D204E;">Shipping Policy</h1>
        <div class="row g-4 align-items-center">
            <div class="col-lg-8 mx-auto text-center mb-4">
                <p class="fs-5 text-secondary">Fast, Reliable Delivery for Your Faith-Inspired Products</p>
                <p class="fs-6 text-muted">Last Updated: January 1, 2024</p>
            </div>
        </div>
    </div>
    
    <!-- Full width image outside container -->
    <div class="container-fluid p-0">
        <img src="<?= base_url('images/privacy-policy-bg.png') ?>" alt="The Blessed Manifest - Shipping Policy" class="w-100" style="display: block; max-height: 400px; object-fit: cover;">
    </div>
</section>

<!-- Shipping Policy Content Section -->
<section class="policy-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Introduction -->
                <div class="policy-intro mb-5">
                    <h2 class="fw-semibold mb-4" style="color: #3D204E;">Shipping Policy</h2>
                    <p class="fs-5" style="line-height: 1.8;">At The Blessed Manifest, we are committed to delivering your faith-inspired products in a timely and reliable manner. This Shipping Policy outlines our shipping methods, delivery times, and related information. Please review this policy before placing your order.</p>
                </div>

                <!-- Section 1 - Processing Time -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">1. Order Processing Time</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">All orders are processed within <strong>1-3 business days</strong> (excluding weekends and holidays) after receiving your order confirmation email. You will receive another notification when your order has shipped.</p>
                    
                    <div class="row g-4 mb-3 mt-2">
                        <div class="col-md-6">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 16px; border-left: 4px solid #3D204E;">
                                <h5 class="fw-semibold mb-2" style="color: #3D204E;">📦 Standard Products</h5>
                                <p class="mb-0" style="line-height: 1.6;">Processing Time: <strong>1-2 business days</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 16px; border-left: 4px solid #B48B5A;">
                                <h5 class="fw-semibold mb-2" style="color: #3D204E;">✨ Custom/Personalized Products</h5>
                                <p class="mb-0" style="line-height: 1.6;">Processing Time: <strong>3-5 business days</strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert-box p-4 mb-4" style="background: #fff8e7; border-radius: 16px; border-left: 4px solid #ffc107;">
                        <p class="mb-0 fs-5" style="color: #856404;">
                            <strong>⚠️ Note:</strong> During peak seasons (Christmas, Easter, Black Friday), processing times may be extended by 2-3 business days. We appreciate your patience and understanding.
                        </p>
                    </div>
                </div>

                <!-- Section 2 - Domestic Shipping Rates -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">2. Domestic Shipping Rates (United States)</h3>
                    
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered" style="background: white;">
                            <thead style="background: #3D204E; color: white;">
                                <tr>
                                    <th>Shipping Method</th>
                                    <th>Delivery Time</th>
                                    <th>Order Value</th>
                                    <th>Shipping Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Standard Shipping</strong></td>
                                    <td>3-7 business days</td>
                                    <td>Under $50</td>
                                    <td>$5.99</td>
                                </tr>
                                <tr>
                                    <td><strong>Standard Shipping</strong></td>
                                    <td>3-7 business days</td>
                                    <td>$50 - $99</td>
                                    <td>$4.99</td>
                                </tr>
                                <tr>
                                    <td><strong>Standard Shipping</strong></td>
                                    <td>3-7 business days</td>
                                    <td>$100+</td>
                                    <td><strong class="text-success">FREE</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Express Shipping</strong></td>
                                    <td>1-3 business days</td>
                                    <td>Any</td>
                                    <td>$14.99</td>
                                </tr>
                                <tr>
                                    <td><strong>Overnight Shipping</strong></td>
                                    <td>Next business day</td>
                                    <td>Any</td>
                                    <td>$29.99</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <p class="fs-5" style="line-height: 1.8;">Free standard shipping is automatically applied at checkout for orders over $100 (after discounts, before tax).</p>
                </div>

                <!-- Section 3 - International Shipping -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">3. International Shipping</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">We ship to select countries worldwide. International shipping rates and delivery times vary by location.</p>
                    
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered" style="background: white;">
                            <thead style="background: #3D204E; color: white;">
                                <tr>
                                    <th>Region</th>
                                    <th>Standard Shipping</th>
                                    <th>Express Shipping</th>
                                    <th>Delivery Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Canada & Mexico</strong></td>
                                    <td>$12.99</td>
                                    <td>$24.99</td>
                                    <td>7-14 business days</td>
                                </tr>
                                <tr>
                                    <td><strong>United Kingdom & Europe</strong></td>
                                    <td>$15.99</td>
                                    <td>$29.99</td>
                                    <td>10-18 business days</td>
                                </tr>
                                <tr>
                                    <td><strong>Australia & New Zealand</strong></td>
                                    <td>$16.99</td>
                                    <td>$34.99</td>
                                    <td>10-20 business days</td>
                                </tr>
                                <tr>
                                    <td><strong>Asia & Middle East</strong></td>
                                    <td>$14.99</td>
                                    <td>$29.99</td>
                                    <td>10-18 business days</td>
                                </tr>
                                <tr>
                                    <td><strong>Rest of World</strong></td>
                                    <td>$19.99</td>
                                    <td>$39.99</td>
                                    <td>14-25 business days</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="alert-box p-4 mb-4" style="background: #e8f5e9; border-radius: 16px; border-left: 4px solid #28a745;">
                        <p class="mb-0 fs-5" style="color: #155724;">
                            <strong>🌍 Free International Shipping:</strong> Free standard international shipping on orders over $150 USD.
                        </p>
                    </div>
                </div>

                <!-- Section 4 - Customs & Import Duties -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">4. Customs, Duties, and Taxes</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">International orders may be subject to customs fees, import duties, and taxes imposed by the destination country. These charges are the responsibility of the customer.</p>
                    
                    <ul class="fs-5 mb-4" style="line-height: 1.8;">
                        <li>Customs policies vary by country; please contact your local customs office for more information</li>
                        <li>We are not responsible for delays caused by customs clearance</li>
                        <li>We cannot predict or calculate customs fees; they are determined by your country's customs office</li>
                        <li>We declare the actual product value on customs forms (not as a gift)</li>
                    </ul>
                    
                    <div class="alert-box p-4" style="background: #fff8e7; border-radius: 16px; border-left: 4px solid #ffc107;">
                        <p class="mb-0 fs-5" style="color: #856404;">
                            <strong>⚠️ Important:</strong> If you refuse to pay customs fees and the package is returned to us, we will refund the product cost minus shipping fees and a 15% restocking fee.
                        </p>
                    </div>
                </div>

                <!-- Section 5 - Order Tracking -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">5. Order Tracking</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">Once your order has shipped, you will receive a shipping confirmation email containing:</p>
                    
                    <ul class="fs-5 mb-4" style="line-height: 1.8;">
                        <li>Tracking number(s) for your package(s)</li>
                        <li>Link to the carrier's tracking website</li>
                        <li>Estimated delivery date</li>
                    </ul>
                    
                    <p class="fs-5" style="line-height: 1.8;">You can also track your order by logging into your account and viewing your order history.</p>
                </div>

                <!-- Section 6 - Shipping Carriers -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">6. Shipping Carriers</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">We partner with reliable carriers to ensure your package arrives safely and on time:</p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3 text-center">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 12px;">
                                <i class="fas fa-truck fa-2x mb-2" style="color: #3D204E;"></i>
                                <p class="mb-0 fw-semibold">USPS</p>
                                <small class="text-muted">Standard & Priority</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 12px;">
                                <i class="fas fa-box fa-2x mb-2" style="color: #3D204E;"></i>
                                <p class="mb-0 fw-semibold">UPS</p>
                                <small class="text-muted">Ground & Express</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 12px;">
                                <i class="fas fa-shipping-fast fa-2x mb-2" style="color: #3D204E;"></i>
                                <p class="mb-0 fw-semibold">FedEx</p>
                                <small class="text-muted">Express & Overnight</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <div class="p-3" style="background: #F9F7FA; border-radius: 12px;">
                                <i class="fas fa-globe fa-2x mb-2" style="color: #3D204E;"></i>
                                <p class="mb-0 fw-semibold">DHL</p>
                                <small class="text-muted">International</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 7 - Lost or Stolen Packages -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">7. Lost or Stolen Packages</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">We are not responsible for lost or stolen packages after they have been marked as delivered by the carrier. However, we will assist you in filing a claim:</p>
                    
                    <ul class="fs-5 mb-4" style="line-height: 1.8;">
                        <li>Verify the shipping address provided at checkout is correct</li>
                        <li>Check with neighbors or building management</li>
                        <li>Contact the carrier with your tracking number</li>
                        <li>If still unresolved, contact us within 14 days of the "delivered" date</li>
                    </ul>
                    
                    <p class="fs-5" style="line-height: 1.8;">For added protection, we recommend selecting a shipping method that includes insurance.</p>
                </div>

                <!-- Section 8 - Shipping to P.O. Boxes -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">8. Shipping to P.O. Boxes</h3>
                    <p class="fs-5" style="line-height: 1.8;">We ship to P.O. Boxes via USPS only. Express and Overnight shipping options are not available for P.O. Box addresses. Please provide a physical address for faster shipping methods.</p>
                </div>

                <!-- Section 9 - Incorrect Shipping Address -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">9. Incorrect Shipping Address</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">Please double-check your shipping address at checkout. If you provide an incorrect address:</p>
                    
                    <ul class="fs-5 mb-4" style="line-height: 1.8;">
                        <li>Contact us immediately at <a href="mailto:support@theblessedmanifest.com.au" style="color: #3D204E;">support@theblessedmanifest.com.au</a></li>
                        <li>If the order hasn't shipped, we can update the address</li>
                        <li>If the order has shipped, you may need to contact the carrier directly</li>
                        <li>Returned packages due to incorrect addresses will incur a reshipping fee</li>
                    </ul>
                </div>

                <!-- Section 10 - Delivery Delays -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">10. Delivery Delays</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">While we strive to meet delivery estimates, unexpected delays may occur due to:</p>
                    
                    <ul class="fs-5 mb-4" style="line-height: 1.8;">
                        <li>Severe weather conditions</li>
                        <li>Carrier service disruptions</li>
                        <li>Customs clearance (for international orders)</li>
                        <li>Peak holiday seasons</li>
                        <li>Natural disasters</li>
                    </ul>
                    
                    <p class="fs-5" style="line-height: 1.8;">We are not responsible for delivery delays caused by these circumstances. We appreciate your patience and understanding.</p>
                </div>

                <!-- Section 11 - Split Shipments -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">11. Split Shipments</h3>
                    <p class="fs-5" style="line-height: 1.8;">If your order contains multiple items, they may be shipped separately. You will receive separate tracking information for each package. There is no additional charge for split shipments.</p>
                </div>

                <!-- Section 12 - Holiday Shipping -->
                <div class="policy-section mb-5">
                    <h3 class="fw-semibold mb-3" style="color: #3D204E;">12. Holiday Shipping</h3>
                    <p class="fs-5 mb-3" style="line-height: 1.8;">During major holidays (Christmas, Easter, Mother's Day, Father's Day, Thanksgiving, Black Friday, Cyber Monday), please expect longer processing and delivery times.</p>
                    
                    <div class="alert-box p-4" style="background: #e3f2fd; border-radius: 16px; border-left: 4px solid #2196f3;">
                        <p class="mb-0 fs-5" style="color: #0c5460;">
                            <strong>🎄 Holiday Order Deadlines:</strong> To ensure delivery before major holidays, please check our website for specific cutoff dates. Orders placed after the cutoff date may not arrive before the holiday.
                        </p>
                    </div>
                </div>

                <!-- Section 13 - Contact Information -->
                <div class="policy-contact mt-5 p-4" style="background: #F9F7FA; border-radius: 16px;">
                    <h4 class="fw-semibold mb-3" style="color: #3D204E;">Shipping Questions?</h4>
                    <p class="fs-5 mb-2">If you have any questions about our Shipping Policy, please contact our customer support team:</p>
                    <ul class="fs-5" style="list-style: none; padding-left: 0;">
                        <li class="mb-2">📧 Email: <a href="mailto:shipping@theblessedmanifest.com.au" style="color: #3D204E;">shipping@theblessedmanifest.com.au</a></li>
                        <li class="mb-2">📞 Phone: (555) 123-4567</li>
                        <li class="mb-2">💬 Live Chat: Available Monday-Friday, 9am-5pm EST</li>
                        <li class="mb-2">📬 Corporate Address: 123 Faith Avenue, Suite 100, City, State 12345</li>
                    </ul>
                </div>

                <!-- Track Order Button -->
                <div class="text-center mt-5">
                    <a href="/account/orders" class="btn px-5 py-3 rounded-pill text-white fs-5" style="background: #3D204E; display: inline-block;">
                        Track Your Order <i class="fas fa-truck ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
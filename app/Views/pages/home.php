<?=$this->include('templates/header');?>
<section class="hero mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <h1 class="display-1 fw-semibold"><span style="color: #6A5854;">Your Vision</span>, <br><span style="color: #3D204E;">His Purpose.</span></h1>
                <p class="lead fs-5 mt-4">The Blessed Manifest empowers you to bring your faith and vision to life by incorporating scripture into personalized products you use every day. We help you keep God's word at the center of your life. By placing scripture on items you see and use daily allowing you to meditate on His teachings, stay inspired, and visualize your goals with faith as your foundation.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#journey" class="btn w-50 px-4 py-3 rounded-pill text-white fs-5" style="background: #3D204E;"><i class="fas fa-pray me-2"></i>How It Works</a>
                </div>
                <p class="lead fs-5 mt-4">"I will meditate on your precepts, and fix my eyes on your ways. I will delight in your statutes; I will not forget your word"</p>
                <P class="lead fs-5">- Psalm 119:15-16</P>
            </div>
            <div class="col-lg-7">
                <img src="<?= base_url('images/hero-bg.png') ?>" class="img-fluid rounded-4">
            </div>
        </div>
    </div>
</section>

<section class="mission">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-semibold section-title">Our Mission</h2>
        <div class="row g-4 align-items-center">
            <div class="col-lg-8 mx-auto text-center mb-4">
                <p class="fs-5">Our mission is to empower individuals to manifest their vision, embrace healing, and foster growth by creating a space that nurtures spiritual alignment, inner peace, and self-discovery. We strive to inspire confidence in faith and guide others toward a life of purpose and fulfillment.</p>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-md-4">
                <div class="card-product p-4 h-100 text-center">
                    <i class="fas fa-spa icon-lg mb-3" style="font-size: 3.5rem; color: #3D204E;"></i>
                    <h3 class="fw-semibold h4">Foster Self-Awareness<br>And Inspiration</h3>
                    <p class="fs-5">We equip you with tools to reflect, grow, and create through a platform where you can connect and organize your visions to stay present, grounded, and attuned to your spiritual and emotional well-being.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-product p-4 h-100 text-center">
                    <i class="fas fa-hands-praying icon-lg mb-3" style="font-size: 3.5rem; color: #3D204E;"></i>
                    <h3 class="fw-semibold h4">Provide Faith-Centered<br>Inspirational Products</h3>
                    <p class="fs-5">Our platform enables you to express your identity, values, and aspirations through customizable designs, images, quotes, and scriptures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-product p-4 h-100 text-center">
                    <i class="fas fa-palette icon-lg mb-3" style="font-size: 3.5rem; color: #3D204E;"></i>
                    <h3 class="fw-semibold h4">Promote Creativity<br>And Purpose</h3>
                    <p class="fs-5">We celebrate creativity as a divine gift, offering products that empower self-expression and inspire personal and spiritual growth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="journey">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="<?= base_url('images/vision-bg.png') ?>" class="img-fluid rounded-4">
            </div>
            <div class="col-lg-6">
                <h2 class="display-5 fw-semibold">
                    <span style="color: #3D204E;">Take Your Vision Board Beyond Paper And Bring It To Life By Turning Your Goals And Scripture-Inspired Affirmations Into Personalized Products You Use And See Every Day.</span>
                </h2>
                <p class="lead fs-5 mt-4">Whether it's a mug with all your favorite motivating Bible verses, a phone case that keeps your vision and goals at your fingertips, a beautifully designed Bible cover, or wall art that keeps your prayer request in plain sight, we make it easy to stay focused and inspired.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#products" class="btn w-50 px-4 py-3 rounded-pill text-white fs-5" style="background: #3D204E;">Start Your Journey</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-items section-padding mb-3" id="featured-items">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-12">
                <h2 class="text-center mt-5 display-4 fw-semibold section-title">Create, Inspire, Achieve</h2>
            </div>
            <div class="col-lg-8 mx-auto text-center mb-4">
                <p class="fs-5">By integrating scripture and faith-centered reminders into your daily routine, these products help you stay aligned with your spiritual goals and live with purpose. Instead of tucking away vision boards or Bible meditations, surround yourself with tangible items that inspire action, remind you of God's promises, and encourage reflection. It's about making your faith and aspirations a visible, integral part of your life.</p>
            </div>
            <div class="col-12 text-center">
                <a href="#products" class="btn px-5 py-3 rounded-pill text-white fs-5" style="background: #3D204E; display: inline-block;">Check Out Our Featured Items</a>
            </div>
        </div>
    </div>
            
    <!-- Full width image outside container -->
    <div class="container-fluid p-0">
        <img src="<?= base_url('images/featured-items-bg.png') ?>" alt="Featured items collage" class="w-100" style="display: block;">
    </div>
</section>

<section class="scripture-section">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-10 col-lg-8 text-center position-relative">
                <!-- Top HR with overlapping quote -->
                <div class="position-relative mb-4">
                    <hr class="border border-black border-1 opacity-50">
                    <div class="position-absolute top-50 start-50 translate-middle bg-warm px-3" style="transform: translate(-50%, -50%);">
                        <i class="fas fa-quote-left fs-1" style="color: #3D204E;"></i>
                    </div>
                </div>
                        
                <!-- Scripture content -->
                <div class="py-5">
                    <p class="fs-3 fw-light" style="font-family: Merriweather;">"All Scripture is God-breathed and is useful for teaching, rebuking, correcting and training in righteousness, so that the servant of God may be thoroughly equipped for every good work."</p>
                    <p class="mt-2">— 2 Timothy 3:16-17</p>
                </div>
                        
                <!-- Bottom HR with overlapping quote -->
                <div class="position-relative mt-4">
                    <hr class="border border-black border-1 opacity-50">
                    <div class="position-absolute top-50 start-50 translate-middle bg-warm px-3" style="transform: translate(-50%, -50%);">
                        <i class="fas fa-quote-right fs-1" style="color: #3D204E;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-posts mt-5">
    <div class="container">
        <!-- Section Header -->
        <div class="row align-items-center mb-5">
            <div class="col-12">
                <h2 class="text-center display-4 fw-semibold section-title" style="color: #3D204E;">Find Hope And Encouragement Each Day</h2>
            </div>
        </div>
                
        <!-- Posts Grid -->
        <div class="row g-4">
            <?php if (!empty($featuredPosts)): ?>
                <?php foreach ($featuredPosts as $post): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="post-card h-100 rounded-4" style="background-image: url('<?= base_url($post['featured_image'] ?? 'images/hero-bg.png') ?>'); background-size: cover; background-position: center;">
                            <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                                <div class="post-meta">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="read-time text-white">
                                            <i class="far fa-clock me-2"></i><?= $post['read_time'] ?? 5 ?> min read
                                        </span>
                                        <?php if (!empty($post['categoryname'])): ?>
                                            <span class="category-badge text-white" style="background: rgba(61, 32, 78, 0.8); padding: 2px 8px; border-radius: 20px; font-size: 0.7rem;">
                                                <?= esc($post['categoryname']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="/blogs/<?= $post['slug'] ?>" class="fs-5 text-decoration-none text-white">
                                        <span class="post-title"><?= esc($post['title']) ?></span>
                                    </a>
                                    <div class="post-date text-white-50 mt-2">
                                        <i class="far fa-calendar-alt me-2"></i><?= date('F j, Y', strtotime($post['published_at'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback static posts if no featured posts exist -->
                <div class="col-lg-4 col-md-6">
                    <div class="post-card h-100 rounded-4" style="background-image: url('<?= base_url('images/hero-bg.png') ?>');">
                        <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                            <div class="post-meta">
                                <span class="read-time text-white">
                                    <i class="far fa-clock me-2"></i>Coming Soon
                                </span>
                                <a href="#" class="fs-5 text-decoration-none text-white">
                                    <span class="post-title">Check back soon for new blog posts</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
                
        <!-- View All Link -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="/blogs" class="view-all-link">
                    View All Posts <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?=$this->include('templates/footer');?>
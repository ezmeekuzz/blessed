<?= $this->include('templates/header'); ?>

<!-- BLOG POST HEADER SECTION -->
<section class="blog-post-header mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Category Badge -->
                <div class="mb-3">
                    <span class="category-badge d-inline-block" style="background: #3D204E; color: white; padding: 5px 15px; border-radius: 30px; font-size: 0.85rem;">
                        <?= esc($post['category_name'] ?? 'Uncategorized') ?>
                    </span>
                </div>
                
                <!-- Title -->
                <h1 class="display-4 fw-semibold mb-4" style="color: #3D204E;"><?= esc($post['title']) ?></h1>
                <hr class="mb-4" style="border-color: #3D204E; opacity: 0.3;">
                
                <!-- Meta Information Row -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-user" style="color: #3D204E;"></i>
                            <span>By <strong>The Blessed Manifest Team</strong></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="far fa-calendar-alt" style="color: #3D204E;"></i>
                            <span><?= date('F j, Y', strtotime($post['published_at'])) ?></span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="far fa-clock" style="color: #3D204E;"></i>
                            <span><?= $read_time ?> min read</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="far fa-eye" style="color: #3D204E;"></i>
                            <span><?= number_format($post['view_count'] ?? 0) ?> views</span>
                        </div>
                    </div>
                    
                    <!-- Social Share Row -->
                    <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                        <span class="small text-secondary">Share This</span>
                        <a href="#" class="icon-circle small share-facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon-circle small share-twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="icon-circle small share-linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="icon-circle small share-email"><i class="fa-regular fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BLOG CONTENT SECTION -->
<section class="blog-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Featured Image -->
                <?php if ($post['featured_image'] && $post['featured_image'] !== ''): ?>
                    <img src="<?= base_url($post['featured_image']) ?>" alt="<?= esc($post['title']) ?>" class="img-fluid rounded-4 w-100 mb-5">
                <?php else: ?>
                    <div class="featured-image-placeholder bg-light rounded-4 w-100 mb-5 d-flex align-items-center justify-content-center" style="height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-image fa-4x text-white opacity-50"></i>
                    </div>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="post-content-body">
                    <?= $post['content'] ?>
                </div>

                <!-- Tags Section -->
                <?php if (!empty($post['tags'])): ?>
                    <div class="tags-section mt-5 pt-3">
                        <h5 class="fw-semibold mb-3" style="color: #3D204E;">Tags:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <?php 
                            $tags = explode(',', $post['tags']);
                            foreach ($tags as $tag): 
                                $tag = trim($tag);
                                if (!empty($tag)):
                            ?>
                                <a href="/blogs?tag=<?= urlencode($tag) ?>" class="tag-link" style="background: #f0e9e2; padding: 5px 15px; border-radius: 30px; text-decoration: none; color: #3D204E; font-size: 0.85rem; transition: all 0.3s ease;">
                                    #<?= esc($tag) ?>
                                </a>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Blog Meta & Share -->
                <div class="blog-meta d-flex flex-wrap justify-content-between align-items-center mt-5 pt-3">
                    <div class="d-flex align-items-center gap-3">
                        <span class="small text-secondary">Share This Article:</span>
                        <a href="#" class="icon-circle small share-facebook-footer"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon-circle small share-twitter-footer"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="icon-circle small share-linkedin-footer"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="icon-circle small share-email-footer"><i class="fa-regular fa-envelope"></i></a>
                    </div>
                    <span class="small text-secondary"><?= $read_time ?> min read</span>
                </div>

                <!-- Author Bio Section -->
                <div class="author-bio mt-5 p-4" style="background: #f8f4fa; border-radius: 20px;">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                        <div class="author-avatar">
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                <i class="fas fa-pen-fancy fa-2x" style="color: #3D204E;"></i>
                            </div>
                        </div>
                        <div class="author-info text-center text-md-start">
                            <h5 class="fw-semibold mb-2" style="color: #3D204E;">The Blessed Manifest Team</h5>
                            <p class="text-secondary mb-0" style="font-size: 0.95rem;">We are passionate about using our God-given talents to create beautiful things that inspire and serve. Our mission is to provide encouragement and hope through meaningful content and designs.</p>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Subscription Card -->
                <div class="subscribe-card p-5 mt-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #f0e9e2 100%); border-radius: 24px;">
                    <div class="text-center">
                        <h4 class="fw-bold mb-3" style="color: #3D204E; font-size: 1.8rem;">Subscribe To Our Newsletter</h4>
                        <p class="text-secondary mb-4" style="font-size: 1.1rem; max-width: 500px; margin: 0 auto;">Get the best, coolest, and latest in faith and design delivered to your inbox each week.</p>
                        
                        <!-- Email Subscription Form -->
                        <div class="subscription-form mb-4">
                            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                                <input type="email" id="newsletterEmail" class="form-control form-control-lg rounded-pill px-4 py-3" placeholder="Enter Email Address" style="border: 2px solid #3D204E; max-width: 400px;">
                                <button class="btn px-5 py-3 rounded-pill text-white fs-6 fw-semibold subscribe-newsletter-btn" style="background: #3D204E; white-space: nowrap;">Subscribe</button>
                            </div>
                        </div>
                        
                        <!-- Privacy Policy Note -->
                        <div>
                            <p class="small text-secondary mb-0" style="font-size: 0.85rem;">
                                You Can Unsubscribe At Any Time, No Hard Feelings. 
                                <a href="/privacy-policy" class="text-decoration-none" style="color: #3D204E; font-weight: 500;">Privacy Policy.</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- RELATED ARTICLES SECTION -->
    <?php if (!empty($relatedPosts)): ?>
    <div class="container mt-5">
        <div class="related-articles">
            <h3 class="fw-semibold mb-4" style="color: #3D204E;">Related Articles</h3>
            <div class="row g-4">
                <?php foreach ($relatedPosts as $related): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="post-card h-100 rounded-4" style="background-image: url('<?= base_url($related['featured_image'] ?? 'images/hero-bg.png') ?>'); background-size: cover; background-position: center;">
                        <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                            <div class="post-meta">
                                <span class="read-time text-white">
                                    <i class="far fa-clock me-2"></i>5 min read
                                </span>
                                <a href="/blogs/<?= $related['slug'] ?>" class="fs-5 text-decoration-none text-white">
                                    <span class="post-title"><?= esc($related['title']) ?></span>
                                </a>
                                <div class="post-date text-white-50 mt-2">
                                    <i class="far fa-calendar-alt me-2"></i><?= date('M j, Y', strtotime($related['published_at'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- Hidden input for post ID -->
<input type="hidden" id="post-id" data-post-id="<?= $post['blog_post_id'] ?>">

<?= $this->include('templates/footer'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/blog-details.js'); ?>"></script>
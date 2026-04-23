<?= $this->include('templates/header'); ?>

<!-- HERO SECTION -->
<section class="hero-products mt-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold" style="color: #3D204E;">Create Your Own Personalized Products</h1>
                <p class="fs-5 mt-3">We offer a unique range of customizable, faith-based products that blend creativity, spiritual growth, and mental wellness. Whether it's a mug, journal, or vision board, our products are designed to inspire, motivate, and help you visualize your spiritual and personal goals every single day.</p>
                <div class="d-flex align-items-center justify-content-center gap-3 my-4">
                    <a href="/how-to" class="btn px-5 py-3 rounded-pill text-white fs-5" style="background: #3D204E;">How It Works</a>
                </div>
            </div>
        </div>
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
            <!-- Category Filter Dropdown -->
            <div class="sort-dropdown dropdown" style="max-width: 280px;">
                <button class="btn btn-outline-dark dropdown-toggle rounded-3 px-4 py-2 h-100 w-100 text-start" type="button" data-bs-toggle="dropdown" id="categoryDropdownBtn">
                    <i class="fas fa-filter me-2"></i><span id="selectedCategoryText">All Categories</span>
                </button>
                <ul class="dropdown-menu w-100 dropdown-menu-end" id="categoryDropdown">
                    <li><a class="dropdown-item" href="#" data-category-id="all">All Categories</a></li>
                    <?php foreach ($categories as $category): ?>
                    <li>
                        <a class="dropdown-item" href="#" data-category-id="<?= $category['product_category_id']; ?>">
                            <?= esc($category['categoryname']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Sort Dropdown -->
            <div class="sort-dropdown dropdown" style="max-width: 220px;">
                <button class="btn btn-outline-dark dropdown-toggle rounded-3 px-4 py-2 h-100 w-100 text-start" type="button" data-bs-toggle="dropdown" id="sortDropdownBtn">
                    <i class="fas fa-sort me-2"></i><span id="selectedSortText">Most Popular</span>
                </button>
                <ul class="dropdown-menu w-100 dropdown-menu-end" id="sortDropdown">
                    <li><a class="dropdown-item" href="#" data-sort="most_popular">Most Popular</a></li>
                    <li><a class="dropdown-item" href="#" data-sort="price_asc">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#" data-sort="price_desc">Price: High to Low</a></li>
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
            <h2 class="fw-bold mb-0" style="color: #3D204E; font-size: clamp(1.8rem, 4vw, 2.2rem);" id="categoryTitle">All Products</h2>
            <span class="badge bg-light text-dark rounded-pill px-4 py-2 fs-6" id="resultsCount"><?= $totalResults; ?> Results</span>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" style="color: #3D204E !important;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading products...</p>
        </div>

        <!-- Product Grid Container -->
        <div class="row g-3 g-sm-4" id="productsContainer">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="col-6 col-md-4 product-card-item" data-product-id="<?= $product['product_id']; ?>">
                    <div class="card h-100 border-0 p-2 p-sm-3" style="background: #f7f2eb; border-radius: 24px;">
                        <div class="position-relative" style="aspect-ratio: 1/1;">
                            <?php if (!empty($product['images'])): ?>
                                <img src="<?= base_url($product['images'][0]); ?>" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="<?= esc($product['product_name']); ?>">
                            <?php else: ?>
                                <img src="<?= base_url('images/placeholder-product.png'); ?>" class="img-fluid rounded-4 w-100 h-100 object-fit-cover" alt="Placeholder">
                            <?php endif; ?>
                            
                            <?php if ($product['has_discount']): ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge" style="background: #e74c3c; color: white;">
                                    <?= $product['discount_percentage'] ?>% OFF
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($product['is_featured']): ?>
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge" style="background: #3D204E; color: white;">Featured</span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <h3 class="fs-6 fw-semibold mb-1 text-truncate" style="color: #3D204E;"><?= esc($product['product_name']); ?></h3>
                            <?php if (isset($product['categoryname']) && $product['categoryname']): ?>
                            <p class="small text-muted mb-2"><?= esc($product['categoryname']); ?></p>
                            <?php endif; ?>
                            
                            <!-- Color swatches preview -->
                            <?php if (!empty($product['colors'])): ?>
                            <div class="d-flex gap-1 mb-2">
                                <?php foreach (array_slice($product['colors'], 0, 4) as $color): ?>
                                <div class="color-swatch-preview rounded-circle" style="width: 16px; height: 16px; background: <?= $color['color_hex']; ?>; border: 1px solid #ddd;"></div>
                                <?php endforeach; ?>
                                <?php if (count($product['colors']) > 4): ?>
                                <small class="text-muted">+<?= count($product['colors']) - 4; ?></small>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mt-2 gap-2 gap-sm-0">
                                <div class="d-flex align-items-center gap-2">
                                    <?php if ($product['has_discount']): ?>
                                    <span class="fw-bold fs-4" style="color: #3D204E;">$<?= number_format($product['price'], 2); ?></span>
                                    <span class="text-decoration-line-through text-secondary-emphasis small">$<?= number_format($product['original_price'], 2); ?></span>
                                    <?php else: ?>
                                    <span class="fw-bold fs-4" style="color: #3D204E;">$<?= number_format($product['price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="/product/<?= $product['slug']; ?>" class="btn btn-outline-purple rounded-pill px-3 px-sm-4 py-2 w-sm-auto text-decoration-none" style="border-color: #3D204E; --bs-btn-hover-bg: #3D204E; --bs-btn-hover-color: white; --bs-btn-hover-border-color: #3D204E;">
                                    Personalize Design
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- No products found -->
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- No Results Template (Hidden) -->
<div id="noResultsTemplate" class="d-none">
    <div class="col-12">
        <div class="no-results-enhanced text-center py-5">
            <div class="no-results-icon mx-auto">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="no-results-title">No Products Found</h3>
            <p class="no-results-message">We couldn't find any products matching your criteria.</p>
            <div class="no-results-actions">
                <button class="btn-reset-filters" onclick="resetAllFilters()">
                    <i class="fas fa-undo-alt me-2"></i>Reset Filters
                </button>
                <a href="/products" class="btn-browse-all">
                    <i class="fas fa-eye me-2"></i>Browse All Products
                </a>
            </div>
            <div class="featured-categories mt-4">
                <p class="featured-title">
                    <i class="fas fa-tags me-2"></i>Popular Categories
                </p>
                <div class="category-chips">
                    <?php foreach (array_slice($categories, 0, 5) as $category): ?>
                    <a href="#" class="category-chip" data-category-id="<?= $category['product_category_id']; ?>">
                        <?= esc($category['categoryname']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer'); ?>
<script src="<?= base_url('js/products.js'); ?>"></script>
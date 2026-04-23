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
            <div class="col-lg-10">
                <div class="d-flex flex-column flex-md-row gap-3">
                    <!-- Search Box -->
                    <div class="search-box flex-grow-1">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-search text-secondary me-2"></i>
                            <input type="text" id="searchInput" placeholder="Search by title, content, or tags..." class="bg-transparent w-100">
                            <button class="search-btn btn btn-link text-decoration-none" style="color: #3D204E;">Search</button>
                        </div>
                    </div>
                    
                    <!-- Categories Dropdown -->
                    <div class="dropdown" style="min-width: 200px;">
                        <button class="btn btn-outline-dark dropdown-toggle rounded-3 px-4 py-2 h-100 w-100 text-start" type="button" data-bs-toggle="dropdown">
                            <span class="category-text"><i class="fas fa-filter me-2"></i>All Categories</span>
                        </button>
                        <ul class="dropdown-menu w-100 dropdown-menu-end" id="categoryDropdown">
                            <!-- Categories will be loaded dynamically via AJAX -->
                            <li><a class="dropdown-item" href="#" data-category="all">All Categories</a></li>
                        </ul>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="sort-dropdown" style="min-width: 150px;">
                        <select class="form-select sort-select rounded-3 px-4 py-2 h-100 w-100 text-start">
                            <option value="latest">Latest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="title_asc">Title A-Z</option>
                            <option value="title_desc">Title Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- BLOG POSTS GRID -->
        <div class="row g-4 posts-grid-container">
            <!-- Posts will be loaded dynamically via AJAX -->
        </div>
    </div>
</section>

<?= $this->include('templates/footer'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url('js/blogs.js'); ?>"></script>
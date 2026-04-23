// blogs.js
$(document).ready(function() {
    // Global variables
    let currentPage = 1;
    let currentSearch = '';
    let currentCategory = '';
    let currentSort = 'latest';
    let isLoading = false;
    let hasMore = true;
    let allCategories = [];

    // Initialize
    loadCategories();
    loadBlogPosts();

    // Debug: Log current read articles on load
    console.log('Currently read articles:', getReadArticles());

    // Search input handler
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            currentSearch = $('#searchInput').val();
            currentPage = 1;
            hasMore = true;
            loadBlogPosts(true);
        }, 500);
    });

    // Search button click handler
    $('.search-btn').on('click', function() {
        currentSearch = $('#searchInput').val();
        currentPage = 1;
        hasMore = true;
        loadBlogPosts(true);
    });

    // Sort handler
    $('.sort-select').on('change', function() {
        currentSort = $(this).val();
        currentPage = 1;
        hasMore = true;
        loadBlogPosts(true);
    });

    // Load more on scroll
    $(window).on('scroll', function() {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 300) {
            if (!isLoading && hasMore) {
                currentPage++;
                loadBlogPosts();
            }
        }
    });

    // Load categories from database
    function loadCategories() {
        $.ajax({
            url: '/blogs/get-categories',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.categories.length > 0) {
                    allCategories = response.categories;
                    updateCategoryDropdown(allCategories);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading categories:', error);
            }
        });
    }

    // Update category dropdown
    function updateCategoryDropdown(categories) {
        let dropdownHtml = '<li><a class="dropdown-item" href="#" data-category="all">All Categories</a></li>';
        
        categories.forEach(category => {
            dropdownHtml += `
                <li>
                    <a class="dropdown-item" href="#" data-category="${category.blog_category_id}">
                        ${escapeHtml(category.categoryname)}
                        ${category.post_count > 0 ? `<span class="category-count">(${category.post_count})</span>` : ''}
                    </a>
                </li>
            `;
        });
        
        $('#categoryDropdown').html(dropdownHtml);
        
        // Attach category filter handler
        $('.dropdown-item').off('click').on('click', function(e) {
            e.preventDefault();
            const selectedCategory = $(this).data('category');
            const categoryName = $(this).clone().children().remove().end().text().trim().replace(/\(\d+\)/, '').trim();
            
            if (selectedCategory === 'all') {
                $('.category-text').html('<i class="fas fa-filter me-2"></i>All Categories');
                currentCategory = '';
            } else {
                $('.category-text').html('<i class="fas fa-filter me-2"></i>' + categoryName);
                currentCategory = selectedCategory;
            }
            
            currentPage = 1;
            hasMore = true;
            loadBlogPosts(true);
        });
    }

    // Load blog posts
    function loadBlogPosts(reset = false) {
        if (isLoading) return;
        
        isLoading = true;
        
        if (reset) {
            $('.posts-grid-container').html(`
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
        } else {
            $('.posts-grid-container').append(`
                <div class="col-12 text-center py-3 loading-more">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading more...</span>
                    </div>
                </div>
            `);
        }
        
        $.ajax({
            url: '/blogs/get-posts',
            method: 'GET',
            data: {
                page: currentPage,
                search: currentSearch,
                category: currentCategory,
                sort: currentSort
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    hasMore = response.has_more;
                    
                    if (reset) {
                        $('.posts-grid-container').empty();
                    } else {
                        $('.loading-more').remove();
                    }
                    
                    if (response.posts.length === 0 && reset) {
                        displayNoResults();
                    } else {
                        renderBlogPosts(response.posts);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading posts:', error);
                if (reset) {
                    $('.posts-grid-container').html(`
                        <div class="col-12 text-center py-5">
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Failed to load blog posts. Please try again.
                            </div>
                        </div>
                    `);
                } else {
                    $('.loading-more').remove();
                }
            },
            complete: function() {
                isLoading = false;
            }
        });
    }

    // Display no results
    function displayNoResults() {
        const searchTerm = currentSearch || '';
        
        let categoryChipsHtml = '';
        if (allCategories.length > 0) {
            const topCategories = allCategories.slice(0, 6);
            topCategories.forEach(category => {
                categoryChipsHtml += `
                    <a href="#" class="category-chip" data-category-id="${category.blog_category_id}" data-category-name="${escapeHtml(category.categoryname)}">
                        ${escapeHtml(category.categoryname)}
                        ${category.post_count > 0 ? `<small>(${category.post_count})</small>` : ''}
                    </a>
                `;
            });
        } else {
            categoryChipsHtml = `
                <a href="#" class="category-chip" data-category-id="1" data-category-name="Devotionals">Devotionals</a>
                <a href="#" class="category-chip" data-category-id="2" data-category-name="Inspiration">Inspiration</a>
                <a href="#" class="category-chip" data-category-id="3" data-category-name="Faith & Prayer">Faith & Prayer</a>
            `;
        }
        
        $('.posts-grid-container').html(`
            <div class="col-12">
                <div class="no-results-enhanced">
                    <div class="no-results-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="no-results-title">No Blog Posts Found</h3>
                    <p class="no-results-message">We couldn't find any posts matching your search criteria.</p>
                    
                    <div class="search-suggestions">
                        <h4 class="suggestions-title">
                            <i class="fas fa-lightbulb me-2"></i>
                            Try These Suggestions:
                        </h4>
                        <ul class="suggestions-list">
                            ${searchTerm ? `<li><i class="fas fa-search me-2"></i>Check your spelling for <strong>"${escapeHtml(searchTerm)}"</strong></li>` : ''}
                            <li><i class="fas fa-filter me-2"></i>Try using fewer or different filters</li>
                            <li><i class="fas fa-undo-alt me-2"></i>Browse all articles using the reset button below</li>
                            <li><i class="fas fa-tags me-2"></i>Explore popular categories to find interesting content</li>
                        </ul>
                    </div>
                    
                    <div class="no-results-actions">
                        <button class="btn btn-reset-filters" id="resetFiltersBtn">
                            <i class="fas fa-sync-alt me-2"></i>Reset All Filters
                        </button>
                        <a href="/blogs" class="btn btn-browse-all">
                            <i class="fas fa-newspaper me-2"></i>Browse All Articles
                        </a>
                    </div>
                    
                    <div class="featured-categories">
                        <h4 class="featured-title">
                            <i class="fas fa-star me-2"></i>
                            Popular Categories You Might Like:
                        </h4>
                        <div class="category-chips">
                            ${categoryChipsHtml}
                        </div>
                    </div>
                </div>
            </div>
        `);
        
        $('#resetFiltersBtn').on('click', function() {
            resetAllFilters();
        });
        
        $('.category-chip').on('click', function(e) {
            e.preventDefault();
            const categoryId = $(this).data('category-id');
            const categoryName = $(this).data('category-name');
            
            if (categoryId) {
                currentCategory = categoryId;
                $('.category-text').html('<i class="fas fa-filter me-2"></i>' + categoryName);
                currentPage = 1;
                hasMore = true;
                loadBlogPosts(true);
            }
        });
    }

    // Render blog posts
    function renderBlogPosts(posts) {
        let html = '';
        const readArticles = getReadArticles();
        
        console.log('Read articles from cookie:', readArticles);
        
        posts.forEach(post => {
            const publishDate = new Date(post.published_at);
            const formattedDate = publishDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Check if article has been read - convert both to string for comparison
            const isRead = readArticles.includes(String(post.blog_post_id));
            
            console.log(`Post ${post.blog_post_id} - "${post.title}" - Read: ${isRead}`);
            
            const bgImage = post.featured_image && post.featured_image !== '' 
                ? `url('${post.featured_image}')` 
                : `linear-gradient(135deg, #667eea 0%, #764ba2 100%)`;
            
            // Use the read_time from server (already calculated)
            const readTime = post.read_time || 5;
            
            html += `
                <div class="col-lg-4 col-md-6">
                    <div class="post-card h-100 rounded-4 ${isRead ? 'post-read' : ''}" style="background-image: ${bgImage};">
                        <div class="post-content p-4 d-flex flex-column h-100 justify-content-end">
                            <div class="post-meta">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="read-time text-white">
                                        <i class="far fa-clock me-2"></i>${readTime} min read
                                    </span>
                                    ${isRead ? '<span class="read-badge"><i class="fas fa-check-circle me-1"></i>Read</span>' : ''}
                                </div>
                                <a href="/blogs/${post.slug}" class="fs-5 text-decoration-none text-white post-link" data-post-id="${post.blog_post_id}">
                                    <span class="post-title">${escapeHtml(post.title)}</span>
                                </a>
                                <div class="post-date text-white-50 mt-2">
                                    <i class="far fa-calendar-alt me-2"></i>${formattedDate}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('.posts-grid-container').append(html);
        
        // Attach click handlers to mark articles as read
        $('.post-link').on('click', function(e) {
            const postId = $(this).data('post-id');
            console.log('Post clicked:', postId);
            markArticleAsRead(postId);
        });
    }
    
    // Get read articles from cookies
    function getReadArticles() {
        const readArticlesCookie = getCookie('read_articles');
        console.log('Raw cookie value:', readArticlesCookie);
        
        if (readArticlesCookie) {
            try {
                const parsed = JSON.parse(readArticlesCookie);
                // Ensure we return an array of strings
                return Array.isArray(parsed) ? parsed.map(String) : [];
            } catch(e) {
                console.error('Error parsing read articles cookie:', e);
                return [];
            }
        }
        return [];
    }
    
    // Mark article as read and save to cookie
    function markArticleAsRead(postId) {
        let readArticles = getReadArticles();
        const postIdStr = String(postId);
        
        console.log('Current read articles before adding:', readArticles);
        console.log('Adding post ID:', postIdStr);
        
        if (!readArticles.includes(postIdStr)) {
            readArticles.push(postIdStr);
            
            // Save to cookie (expires in 365 days)
            setCookie('read_articles', JSON.stringify(readArticles), 365);
            
            console.log('Saved to cookie. New read articles:', readArticles);
            
            // Update the UI for this specific post card
            const $postCard = $(`.post-link[data-post-id="${postId}"]`).closest('.post-card');
            $postCard.addClass('post-read');
            
            // Add read badge if not exists
            const $metaDiv = $(`.post-link[data-post-id="${postId}"]`).closest('.post-meta');
            if (!$metaDiv.find('.read-badge').length) {
                $metaDiv.find('.d-flex').append('<span class="read-badge ms-2"><i class="fas fa-check-circle me-1"></i>Read</span>');
            }
        } else {
            console.log('Post already marked as read');
        }
    }
    
    // Cookie helper functions
    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
        console.log(`Cookie set: ${name}=${value}`);
    }
    
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) {
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
            }
        }
        return null;
    }
    
    // Reset all filters
    window.resetAllFilters = function() {
        $('#searchInput').val('');
        $('.category-text').html('<i class="fas fa-filter me-2"></i>All Categories');
        $('.sort-select').val('latest');
        
        currentSearch = '';
        currentCategory = '';
        currentSort = 'latest';
        currentPage = 1;
        hasMore = true;
        
        loadBlogPosts(true);
    };
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Debug function to clear read history (accessible from console)
    window.clearReadHistory = function() {
        setCookie('read_articles', JSON.stringify([]), 365);
        console.log('Read history cleared');
        location.reload();
    };
    
    // Debug function to show read stats
    window.showReadStats = function() {
        const readArticles = getReadArticles();
        console.log('Total read articles:', readArticles.length);
        console.log('Article IDs:', readArticles);
        alert(`You have read ${readArticles.length} articles. Check console for details.`);
    };
});
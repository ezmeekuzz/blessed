document.addEventListener('DOMContentLoaded', function() {
    
    // --- Sidebar Toggle Functionality ---
    const sidebar = document.getElementById('sidebarMenu');
    const toggleBtn = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    
    // Check if sidebar state is stored in localStorage
    const sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed) {
        sidebar.classList.add('collapsed');
        toggleIcon.classList.remove('bi-chevron-left');
        toggleIcon.classList.add('bi-chevron-right');
        toggleBtn.innerHTML = '<i class="bi bi-chevron-right" id="toggleIcon"></i>';
    }
    
    // Toggle sidebar on button click
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        
        // Update icon and button text
        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.classList.remove('bi-chevron-left');
            toggleIcon.classList.add('bi-chevron-right');
            toggleBtn.innerHTML = '<i class="bi bi-chevron-right" id="toggleIcon"></i>';
            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            toggleIcon.classList.remove('bi-chevron-right');
            toggleIcon.classList.add('bi-chevron-left');
            toggleBtn.innerHTML = '<i class="bi bi-chevron-left" id="toggleIcon"></i> <span class="menu-text ms-2"></span>';
            localStorage.setItem('sidebarCollapsed', 'false');
        }
    });
    
    // Add keyboard navigation (optional) - Ctrl+M to toggle sidebar
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'm') {
            e.preventDefault();
            toggleBtn.click();
        }
    });
    
    // Responsive behavior - auto collapse on small screens
    function handleResize() {
        if (window.innerWidth < 768) {
            if (!sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('collapsed');
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
                toggleBtn.innerHTML = '<i class="bi bi-chevron-right" id="toggleIcon"></i>';
                localStorage.setItem('sidebarCollapsed', 'true');
            }
        }
    }
    
    // Check on load
    handleResize();
    
    // Check on resize
    window.addEventListener('resize', handleResize);

    // --- Main Image Area Toggle Functionality ---
    const mainImageArea = document.querySelector('.main-image-area');
    const createNewTab = document.getElementById('create-new-tab');
    const otherTabs = document.querySelectorAll('.tab-button:not(#create-new-tab)');
    
    // Function to show main image area
    function showMainImageArea() {
        if (mainImageArea) {
            mainImageArea.style.display = 'block';
        }
    }
    
    // Function to hide main image area
    function hideMainImageArea() {
        if (mainImageArea) {
            mainImageArea.style.display = 'none';
        }
    }
    
    // Add click event to Create New tab
    if (createNewTab) {
        createNewTab.addEventListener('click', function() {
            hideMainImageArea();
        });
    }
    
    // Add click events to all other tabs
    otherTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            showMainImageArea();
        });
    });
    
    // Also handle Bootstrap tab events for more reliable tab switching
    const tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabElements.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
            // Check if the activated tab is the Create New tab
            if (event.target.id === 'create-new-tab') {
                hideMainImageArea();
            } else {
                showMainImageArea();
            }
        });
    });

    // --- Category Navigation Functionality ---
    // Get all view elements
    const mainCategoriesView = document.getElementById('mainCategoriesView');
    const shapesDetailedView = document.getElementById('shapesDetailedView');
    const graphicsDetailedView = document.getElementById('graphicsDetailedView');
    const photosDetailedView = document.getElementById('photosDetailedView');
    const framesDetailedView = document.getElementById('framesDetailedView');
    const gridsDetailedView = document.getElementById('gridsDetailedView');
    const threedDetailedView = document.getElementById('threedDetailedView');
    const categoryItems = document.querySelectorAll('.category-item');
    const backButtons = document.querySelectorAll('.back-to-categories');
    
    // Function to show shapes view
    function showShapesView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'block';
    }
    
    // Function to show graphics view
    function showGraphicsView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'block';
    }
    
    // Function to show photos view
    function showPhotosView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'block';
    }
    
    // Function to show frames view
    function showFramesView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'block';
    }
    
    // Function to show grids view
    function showGridsView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'block';
    }
    
    // Function to show 3D view
    function showThreedView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'none';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'block';
    }
    
    // Function to show main categories view
    function showMainCategoriesView() {
        if (mainCategoriesView) mainCategoriesView.style.display = 'block';
        if (shapesDetailedView) shapesDetailedView.style.display = 'none';
        if (graphicsDetailedView) graphicsDetailedView.style.display = 'none';
        if (photosDetailedView) photosDetailedView.style.display = 'none';
        if (framesDetailedView) framesDetailedView.style.display = 'none';
        if (gridsDetailedView) gridsDetailedView.style.display = 'none';
        if (threedDetailedView) threedDetailedView.style.display = 'none';
    }
    
    // Add click event to all category items
    categoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const category = this.getAttribute('data-category');
            
            if (category === 'shapes') {
                showShapesView();
            } else if (category === 'graphics') {
                showGraphicsView();
            } else if (category === 'photos') {
                showPhotosView();
            } else if (category === 'frames') {
                showFramesView();
            } else if (category === 'grids') {
                showGridsView();
            } else if (category === '3d') {
                showThreedView();
            }
            // No more "Coming soon" alerts - categories just won't open if not implemented
        });
    });
    
    // Add click event to all back buttons
    backButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            showMainCategoriesView();
        });
    });
    
    // Handle Recently Used links - now just close or do nothing
    const recentlyUsedLinks = document.querySelectorAll('.recently-used-link, #recentlyUsedLink');
    recentlyUsedLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Do nothing or you could add functionality here later
        });
    });
    
    // Handle See All links
    const seeAllLinks = document.querySelectorAll('.see-all-link, #seeAllLink');
    seeAllLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Do nothing or you could add functionality here later
        });
    });
    
    // Handle Create buttons
    const createButtons = document.querySelectorAll('.create-shape-btn, .create-graphic-btn, .create-photo-btn, .create-frame-btn, .create-grid-btn, .create-threed-btn');
    createButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            // Do nothing or you could add functionality here later
        });
    });
    
    // Handle subcategory clicks in shapes view
    const shapeSubcategories = document.querySelectorAll('#shapesDetailedView .element-card');
    shapeSubcategories.forEach(subcat => {
        subcat.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle graphic item clicks
    const graphicItems = document.querySelectorAll('.social-card, .icon-card, .faith-card');
    graphicItems.forEach(item => {
        item.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle Photo item clicks
    const photoItems = document.querySelectorAll('.recent-photo-card, .recommendation-card, .collection-card');
    photoItems.forEach(item => {
        item.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle color dots
    const colorDots = document.querySelectorAll('.color-dot');
    colorDots.forEach(dot => {
        dot.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle category chips
    const categoryChips = document.querySelectorAll('.category-chip');
    categoryChips.forEach(chip => {
        chip.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle Frame item clicks
    const frameItems = document.querySelectorAll('.recent-frame-card, .frame-category-card, .paper-card, .trending-item');
    frameItems.forEach(item => {
        item.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle Grid item clicks
    const gridItems = document.querySelectorAll('.recent-grid-card, .grid-category-card, .template-card');
    gridItems.forEach(item => {
        item.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
    
    // Handle Apply Grid Settings button
    const applySettingsBtn = document.querySelector('.mb-4.p-3 .btn');
    if (applySettingsBtn) {
        applySettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Do nothing - just visual feedback
        });
    }
    
    // Handle 3D item clicks
    const threedItems = document.querySelectorAll('.recent-3d-card, .threed-category-card, .style-chip');
    threedItems.forEach(item => {
        item.addEventListener('click', function() {
            // Do nothing - just visual selection
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Sidebar Toggle Functionality ONLY ---
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
});

// Toggle filter sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('filterToggleBtn');
    const sidebar = document.querySelector('.filters-sidebar');
    const productsGrid = document.querySelector('.products-grid-full');
    const pageTitle = document.querySelector('.page-title');
    
    if (toggleBtn && sidebar && productsGrid) {
        toggleBtn.addEventListener('click', function() {
            // Toggle classes
            sidebar.classList.toggle('hidden');
            productsGrid.classList.toggle('sidebar-hidden');
            toggleBtn.classList.toggle('sidebar-hidden');
            
            // Toggle page title animation
            if (pageTitle) {
                if (sidebar.classList.contains('hidden')) {
                    pageTitle.classList.remove('sidebar-active');
                } else {
                    pageTitle.classList.add('sidebar-active');
                }
            }
            
            // Update aria-label
            const isHidden = sidebar.classList.contains('hidden');
            toggleBtn.setAttribute('aria-label', isHidden ? 'Show filters' : 'Hide filters');
        });
    }
});

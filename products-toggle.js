// Toggle filter sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('filterToggleBtn');
    const sidebar = document.querySelector('.filters-sidebar');
    const productsGrid = document.querySelector('.products-grid-full');
    
    if (toggleBtn && sidebar && productsGrid) {
        toggleBtn.addEventListener('click', function() {
            // Toggle classes
            sidebar.classList.toggle('hidden');
            productsGrid.classList.toggle('sidebar-hidden');
            toggleBtn.classList.toggle('sidebar-hidden');
            
            // Update aria-label
            const isHidden = sidebar.classList.contains('hidden');
            toggleBtn.setAttribute('aria-label', isHidden ? 'Show filters' : 'Hide filters');
        });
    }
});

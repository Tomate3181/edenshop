// search.js - Complete search functionality

(function() {
    'use strict';
    
    let searchTimeout;
    let suggestionsContainer;
    
    document.addEventListener('DOMContentLoaded', () => {
        const searchIconBtn = document.getElementById('search-icon-btn');
        const searchBar = document.getElementById('search-bar');
        
        if (!searchIconBtn || !searchBar) return;
        
        // Create suggestions dropdown container
        createSuggestionsContainer();
        
        // Check if we're on products page
        const isProductsPage = window.location.pathname.includes('products.php');
        
        // 1. Toggle search bar visibility
        searchIconBtn.addEventListener('click', (event) => {
            event.preventDefault();
            searchBar.classList.toggle('active');
            
            if (searchBar.classList.contains('active')) {
                searchBar.focus();
            } else {
                hideSuggestions();
            }
        });
        
        // 2. Real-time search as user types
        searchBar.addEventListener('input', (event) => {
            const searchTerm = event.target.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            if (searchTerm.length < 2) {
                if (isProductsPage) {
                    showAllProducts();
                } else {
                    hideSuggestions();
                }
                return;
            }
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                if (isProductsPage) {
                    filterProductsOnPage(searchTerm);
                } else {
                    fetchSuggestions(searchTerm);
                }
            }, 300);
        });
        
        // 3. Handle Enter key
        searchBar.addEventListener('keyup', (event) => {
            if (event.key === 'Enter') {
                const searchTerm = searchBar.value.trim();
                if (searchTerm) {
                    window.location.href = `products.php?search=${encodeURIComponent(searchTerm)}`;
                }
            }
        });
        
        // 4. Close search when clicking outside
        document.addEventListener('click', (event) => {
            const isClickInsideSearch = event.target.closest('.search-container');
            
            if (!isClickInsideSearch && searchBar.classList.contains('active')) {
                searchBar.classList.remove('active');
                hideSuggestions();
            }
        });
        
        // 5. Handle URL search parameter on products page
        if (isProductsPage) {
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                searchBar.value = searchParam;
                filterProductsOnPage(searchParam);
            }
        }
    });
    
    // Create suggestions dropdown container
    function createSuggestionsContainer() {
        const searchContainer = document.querySelector('.search-container');
        if (!searchContainer) return;
        
        suggestionsContainer = document.createElement('div');
        suggestionsContainer.className = 'search-suggestions';
        searchContainer.appendChild(suggestionsContainer);
    }
    
    // Fetch suggestions from API
    async function fetchSuggestions(searchTerm) {
        try {
            showLoading();
            
            const response = await fetch(`php/search_products.php?q=${encodeURIComponent(searchTerm)}`);
            const data = await response.json();
            
            if (data.success && data.products.length > 0) {
                displaySuggestions(data.products);
            } else {
                showNoResults();
            }
        } catch (error) {
            console.error('Error fetching suggestions:', error);
            hideSuggestions();
        }
    }
    
    // Display suggestions dropdown
    function displaySuggestions(products) {
        if (!suggestionsContainer) return;
        
        let html = '';
        products.forEach(product => {
            html += `
                <a href="product-detail.php?id=${product.id}" class="search-suggestion-item">
                    <img src="${product.image}" 
                         alt="${product.name}" 
                         class="search-suggestion-image"
                         onerror="this.src='https://via.placeholder.com/50x50?text=Sem+Imagem'">
                    <div class="search-suggestion-info">
                        <div class="search-suggestion-name">${product.name}</div>
                        <div class="search-suggestion-price">R$ ${product.price}</div>
                    </div>
                    <i class="fas fa-arrow-right search-suggestion-arrow"></i>
                </a>
            `;
        });
        
        suggestionsContainer.innerHTML = html;
        suggestionsContainer.classList.add('active');
    }
    
    // Show loading state
    function showLoading() {
        if (!suggestionsContainer) return;
        
        suggestionsContainer.innerHTML = `
            <div class="search-loading">
                <i class="fas fa-spinner fa-spin"></i> Buscando...
            </div>
        `;
        suggestionsContainer.classList.add('active');
    }
    
    // Show no results message
    function showNoResults() {
        if (!suggestionsContainer) return;
        
        suggestionsContainer.innerHTML = `
            <div class="search-no-results">
                Nenhum produto encontrado
            </div>
        `;
        suggestionsContainer.classList.add('active');
    }
    
    // Hide suggestions
    function hideSuggestions() {
        if (suggestionsContainer) {
            suggestionsContainer.classList.remove('active');
        }
    }
    
    // Filter products on products page
    function filterProductsOnPage(searchTerm) {
        const productCards = document.querySelectorAll('.product-card');
        const searchLower = searchTerm.toLowerCase();
        let visibleCount = 0;
        
        productCards.forEach(card => {
            const productName = card.getAttribute('data-name');
            if (productName && productName.toLowerCase().includes(searchLower)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show message if no products found
        updateNoProductsMessage(visibleCount);
    }
    
    // Show all products
    function showAllProducts() {
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.style.display = '';
        });
        updateNoProductsMessage(productCards.length);
    }
    
    // Update no products message
    function updateNoProductsMessage(count) {
        let noProductsMsg = document.querySelector('.no-products-search');
        
        if (count === 0) {
            if (!noProductsMsg) {
                const productsGrid = document.querySelector('.products-grid-full');
                if (productsGrid) {
                    noProductsMsg = document.createElement('p');
                    noProductsMsg.className = 'no-products-search';
                    noProductsMsg.style.gridColumn = '1 / -1';
                    noProductsMsg.style.textAlign = 'center';
                    noProductsMsg.style.padding = '3rem';
                    noProductsMsg.style.color = '#999';
                    noProductsMsg.textContent = 'Nenhum produto encontrado com esse nome.';
                    productsGrid.appendChild(noProductsMsg);
                }
            }
        } else {
            if (noProductsMsg) {
                noProductsMsg.remove();
            }
        }
    }
})();
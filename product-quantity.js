// Quantity selector functionality for product detail page
(function() {
    'use strict';
    
    // Only run once
    if (window.quantityInitialized) {
        return;
    }
    window.quantityInitialized = true;
    
    document.addEventListener('DOMContentLoaded', function() {
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        const quantityInput = document.getElementById('quantity');
        const quantityDisplay = document.getElementById('quantityDisplay');
        
        if (!decreaseBtn || !increaseBtn || !quantityInput || !quantityDisplay) {
            return;
        }
        
        const maxQuantity = parseInt(quantityInput.getAttribute('max')) || 99;
        const minQuantity = parseInt(quantityInput.getAttribute('min')) || 1;
        
        // Remove any existing listeners by cloning
        const newDecreaseBtn = decreaseBtn.cloneNode(true);
        const newIncreaseBtn = increaseBtn.cloneNode(true);
        decreaseBtn.parentNode.replaceChild(newDecreaseBtn, decreaseBtn);
        increaseBtn.parentNode.replaceChild(newIncreaseBtn, increaseBtn);
        
        // Decrease quantity
        newDecreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            let currentValue = parseInt(quantityInput.value) || minQuantity;
            if (currentValue > minQuantity) {
                currentValue--;
                quantityInput.value = currentValue;
                quantityDisplay.textContent = currentValue;
            }
        }, { once: false });
        
        // Increase quantity
        newIncreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            let currentValue = parseInt(quantityInput.value) || minQuantity;
            if (currentValue < maxQuantity) {
                currentValue++;
                quantityInput.value = currentValue;
                quantityDisplay.textContent = currentValue;
            }
        }, { once: false });
    });
})();

// Quantity selector functionality for product detail page
document.addEventListener('DOMContentLoaded', function() {
    const decreaseBtn = document.getElementById('decreaseQuantity');
    const increaseBtn = document.getElementById('increaseQuantity');
    const quantityInput = document.getElementById('quantity');
    const quantityDisplay = document.getElementById('quantityDisplay');
    
    if (decreaseBtn && increaseBtn && quantityInput && quantityDisplay) {
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));
        const minQuantity = parseInt(quantityInput.getAttribute('min'));
        
        // Decrease quantity
        decreaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > minQuantity) {
                currentValue--;
                quantityInput.value = currentValue;
                quantityDisplay.textContent = currentValue;
            }
        });
        
        // Increase quantity
        increaseBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxQuantity) {
                currentValue++;
                quantityInput.value = currentValue;
                quantityDisplay.textContent = currentValue;
            }
        });
    }
});

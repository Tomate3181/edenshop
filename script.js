document.addEventListener('DOMContentLoaded', () => {

    // ===================================================================
    // --- 1. FUNÇÕES GLOBAIS DE GERENCIAMENTO DO CARRINHO ---
    // ===================================================================

    const getCart = () => JSON.parse(localStorage.getItem('edenshopCart')) || [];
    const saveCart = (cart) => localStorage.setItem('edenshopCart', JSON.stringify(cart));

    const updateCartIcon = () => {
        const cart = getCart();
        const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);
        const cartIconCount = document.getElementById('cart-item-count');
        if (cartIconCount) {
            cartIconCount.textContent = itemCount;
            cartIconCount.style.display = itemCount > 0 ? 'block' : 'none';
        }
    };

    const addToCart = (product, quantity = 1) => {
        const cart = getCart();
        const existingItem = cart.find(item => item.id === product.id);
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({ ...product, quantity });
        }
        saveCart(cart);
        updateCartIcon();
    };


    // ===================================================================
    // --- 2. LÓGICA DO FORMULÁRIO DE LOGIN (login.html) ---
    // ===================================================================
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            if (email) {
                alert(`Login simulado com sucesso para ${email}! Redirecionando...`);
                window.location.href = 'index.html';
            }
        });
    }


    // ===================================================================
    // --- 3. LÓGICA DOS FILTROS (products.html) ---
    // ===================================================================
    const filtersSidebar = document.querySelector('.filters-sidebar');
    if (filtersSidebar) {
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        const applyFiltersBtn = document.getElementById('applyFilters');
        const productCards = document.querySelectorAll('.products-grid-full .product-card');

        priceRange.addEventListener('input', () => {
            priceValue.textContent = `R$ ${priceRange.value}`;
        });

        const filterProducts = () => {
            const maxPrice = parseFloat(priceRange.value);
            const selectedCategories = [...document.querySelectorAll('input[name="category"]:checked')].map(cb => cb.value);
            const selectedCares = [...document.querySelectorAll('input[name="care"]:checked')].map(cb => cb.value);

            productCards.forEach(card => {
                const priceMatch = parseFloat(card.dataset.price) <= maxPrice;
                const categoryMatch = selectedCategories.length === 0 || selectedCategories.some(cat => card.dataset.category.includes(cat));
                const careMatch = selectedCares.length === 0 || selectedCares.some(care => card.dataset.care.includes(care));

                card.style.display = (priceMatch && categoryMatch && careMatch) ? 'block' : 'none';
            });
        };

        applyFiltersBtn.addEventListener('click', filterProducts);
    }


    // ===================================================================
    // --- 4. LÓGICA DA PÁGINA DE DETALHES (product-detail.html) ---
    // ===================================================================
    if (document.querySelector('.product-detail-layout')) {
        // a) Galeria de Imagens
        const mainImage = document.getElementById('mainProductImage');
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => {
                mainImage.src = thumb.src;
                document.querySelector('.thumbnail.active').classList.remove('active');
                thumb.classList.add('active');
            });
        });

        // b) Seletor de Quantidade
        const decreaseBtn = document.getElementById('decreaseQuantity');
        const increaseBtn = document.getElementById('increaseQuantity');
        const quantityInput = document.getElementById('quantity');
        decreaseBtn.addEventListener('click', () => {
            if (parseInt(quantityInput.value) > 1) quantityInput.value--;
        });
        increaseBtn.addEventListener('click', () => {
            quantityInput.value++;
        });

        // c) Sistema de Abas (Tabs)
        const tabButtons = document.querySelectorAll('.tab-btn');
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.querySelector('.tab-btn.active').classList.remove('active');
                document.querySelector('.tab-content.active').classList.remove('active');
                button.classList.add('active');
                document.querySelector(button.dataset.target).classList.add('active');
            });
        });
    }


    // ===================================================================
    // --- 5. LÓGICA DA PÁGINA DO CARRINHO (cart.html) ---
    // ===================================================================
    const cartItemsContainer = document.getElementById('cart-items-container');
    if (cartItemsContainer) {
        const displayCartItems = () => {
            const cart = getCart();
            const cartWrapper = document.getElementById('cart-wrapper');
            const emptyCartMessage = document.getElementById('cart-empty-message');
            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                cartWrapper.style.display = 'none';
                emptyCartMessage.style.display = 'block';
            } else {
                cartWrapper.style.display = 'grid';
                emptyCartMessage.style.display = 'none';
                cart.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.classList.add('cart-item');
                    itemElement.innerHTML = `
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-info"><h3>${item.name}</h3><p class="price">R$ ${item.price.toFixed(2).replace('.', ',')}</p></div>
                        <div class="cart-item-actions"><div class="quantity-wrapper"><button class="change-quantity-btn" data-id="${item.id}" data-change="-1">-</button><input type="number" value="${item.quantity}" min="1" readonly><button class="change-quantity-btn" data-id="${item.id}" data-change="1">+</button></div><button class="remove-from-cart-btn" data-id="${item.id}">Remover</button></div>`;
                    cartItemsContainer.appendChild(itemElement);
                });
                updateCartSummary();
                addCartEventListeners();
            }
        };

        const updateCartSummary = () => {
            const cart = getCart();
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('cart-subtotal').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            document.getElementById('cart-total').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
        };

        const addCartEventListeners = () => {
            document.querySelectorAll('.remove-from-cart-btn').forEach(b => b.addEventListener('click', e => {
                let cart = getCart().filter(item => item.id !== e.target.dataset.id);
                saveCart(cart);
                displayCartItems();
                updateCartIcon();
            }));
            document.querySelectorAll('.change-quantity-btn').forEach(b => b.addEventListener('click', e => {
                let cart = getCart();
                const item = cart.find(item => item.id === e.target.dataset.id);
                if (item) item.quantity += parseInt(e.target.dataset.change);
                if (item.quantity < 1) item.quantity = 1;
                saveCart(cart);
                displayCartItems();
                updateCartIcon();
            }));
        };

        displayCartItems();
    }


    // ===================================================================
    // --- 6. EVENT LISTENER UNIVERSAL "ADICIONAR AO CARRINHO" ---
    // ===================================================================
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const card = e.target.closest('.product-card, .product-info');
            const quantity = card.querySelector('#quantity') ? parseInt(card.querySelector('#quantity').value) : 1;
            const product = {
                id: card.dataset.id,
                name: card.dataset.name || card.querySelector('h1').textContent,
                price: parseFloat(card.dataset.price),
                image: card.dataset.image || card.querySelector('.main-image').src,
            };
            addToCart(product, quantity);
            const originalText = button.textContent;
            button.textContent = 'Adicionado!';
            button.style.backgroundColor = '#DAA520';
            setTimeout(() => {
                button.textContent = originalText;
                button.style.backgroundColor = 'var(--primary-green)';
            }, 1500);
        });
    });

    // ===================================================================
    // --- LÓGICA DO FORMULÁRIO DE CONTATO (contact.html) ---
    // ===================================================================
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Impede o envio real

            // Simulação de envio
            alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');
            
            // Limpa o formulário
            contactForm.reset();
        });
    }

    // ===================================================================
    // --- 8. LÓGICA DAS NOVAS SEÇÕES (index.html) ---
    // ===================================================================
    
    // a) Lógica do Carrossel de Avaliações
    const testimonialWrapper = document.querySelector('.testimonial-wrapper');
    if (testimonialWrapper) {
        const slides = document.querySelectorAll('.testimonial-slide');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        const showSlide = (index) => {
            testimonialWrapper.style.transform = `translateX(-${index * 100}%)`;
        };

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        });

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex);
        });
        
        // Inicia o carrossel no primeiro slide
        showSlide(currentIndex);
    }
    
    // b) Lógica do Formulário de Newsletter
    const newsletterForm = document.getElementById('newsletterForm');
    if(newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('#email');
            alert(`Obrigado por se inscrever! Fique de olho em seu e-mail ${emailInput.value} para receber nossas ofertas.`);
            newsletterForm.reset();
        });
    }


    // ===================================================================
    // --- 7. INICIALIZAÇÃO GERAL (Executa em todas as páginas) ---
    // ===================================================================
    updateCartIcon();

});
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
        openCartModal();
    };

    // ===================================================================
    // --- LÓGICA DE SESSÃO DO USUÁRIO (Login, Logout, Verificação) ---
    // ===================================================================

    // --- Lógica de Login (agora no modal) ---
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // AQUI USAMOS O ID DO INPUT DO MODAL
            const emailInput = document.getElementById('modal-email');
            const user = {
                name: "Amante de Plantas",
                email: emailInput.value
            };

            localStorage.setItem('currentUser', JSON.stringify(user));

            // --- LINHA ADICIONADA ---
            closeLoginModal(); // Fecha o modal
            // -------------------------

            alert(`Bem-vindo(a), ${user.name}!`);
            window.location.href = 'profile.html';
        });
    }

    // ===================================================================
    // --- LÓGICA DO MODAL DE LOGIN E VERIFICAÇÃO DE SESSÃO ---
    // ===================================================================

    const loginModal = document.getElementById('loginModal');
    const userActionIcon = document.getElementById('user-action-icon');
    const closeModalBtn = document.querySelector('.close-btn');

    // Função para abrir o modal
    const openLoginModal = () => {
        if (loginModal) loginModal.style.display = 'block';
    }
    // Função para fechar o modal
    const closeLoginModal = () => {
        if (loginModal) loginModal.style.display = 'none';
    }

    // Lógica de Verificação de Login ATUALIZADA
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));

    if (currentUser && userActionIcon) {
        // Se o usuário está logado, o ícone leva para a página de perfil
        userActionIcon.href = 'profile.html';
    } else if (userActionIcon) {
        // Se não, o ícone abre o modal de login
        userActionIcon.href = '#'; // Garante que a página não recarregue
        userActionIcon.addEventListener('click', (e) => {
            e.preventDefault();
            openLoginModal();
        });
    }

    // Event Listeners para fechar o modal
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeLoginModal);
    window.addEventListener('click', (event) => {
        if (event.target == loginModal) {
            closeLoginModal();
        }
    });

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
    // --- 5. LÓGICA DO CARRINHO (MODAL) - VERSÃO CORRIGIDA ---
    // ===================================================================

    // --- Seletores dos Elementos do Modal ---
    const cartModal = document.getElementById('cartModal');
    const openCartBtn = document.getElementById('open-cart-btn');
    const closeCartBtn = document.querySelector('.close-cart-btn');
    const cartOverlay = document.querySelector('.cart-modal-overlay');
    const cartItemsContainerModal = document.getElementById('cart-items-container-modal');

    // --- Funções de Controle do Modal ---
    const openCartModal = () => {
        if (cartModal) {
            displayCartItems(); // Agora esta função já existe e pode ser chamada
            cartModal.classList.add('active');
        }
    }
    const closeCartModal = () => {
        if (cartModal) cartModal.classList.remove('active');
    }

    // --- Funções de Lógica e Renderização do Carrinho ---
    // MOVEMOS A DEFINIÇÃO DAS FUNÇÕES PARA CÁ, PARA O ESCOPO PRINCIPAL.

    const updateCartSummary = () => {
        const cart = getCart();
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const cartTotalEl = document.getElementById('cart-total-modal');
        if (cartTotalEl) {
            cartTotalEl.textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
        }
    };

    const addCartEventListeners = () => {
        // Usamos o container do modal como base para os seletores
        cartItemsContainerModal.querySelectorAll('.remove-from-cart-btn').forEach(b => b.addEventListener('click', e => {
            let cart = getCart().filter(item => item.id !== e.target.dataset.id);
            saveCart(cart);
            displayCartItems();
            updateCartIcon();
        }));
        cartItemsContainerModal.querySelectorAll('.change-quantity-btn').forEach(b => b.addEventListener('click', e => {
            let cart = getCart();
            const item = cart.find(item => item.id === e.target.dataset.id);
            if (item) item.quantity += parseInt(e.target.dataset.change);
            if (item.quantity < 1) {
                let newCart = getCart().filter(cartItem => cartItem.id !== item.id);
                saveCart(newCart);
            } else {
                saveCart(cart);
            }
            displayCartItems();
            updateCartIcon();
        }));
    };

    const displayCartItems = () => {
        // ADICIONAMOS UMA VERIFICAÇÃO DE SEGURANÇA AQUI DENTRO.
        // Se os elementos do carrinho não existirem na página, a função para.
        if (!cartItemsContainerModal) return;

        const cart = getCart();
        const emptyCartMessageModal = document.getElementById('cart-empty-message-modal');
        const cartFooterModal = document.getElementById('cart-modal-footer');

        cartItemsContainerModal.innerHTML = '';

        if (cart.length === 0) {
            emptyCartMessageModal.style.display = 'block';
            cartFooterModal.style.display = 'none';
            cartItemsContainerModal.style.display = 'none';
        } else {
            emptyCartMessageModal.style.display = 'none';
            cartFooterModal.style.display = 'block';
            cartItemsContainerModal.style.display = 'flex';

            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('cart-item');
                // Dentro da sua função displayCartItems, no loop cart.forEach(item => { ... })

                itemElement.innerHTML = `
                    <div class="cart-item-details">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-info">
                            <h3>${item.name}</h3>
                            <p class="price">R$ ${item.price.toFixed(2).replace('.', ',')}</p>
                        </div>
                    </div>
                    <div class="cart-item-actions">
                        <div class="quantity-controls">
                            <button class="change-quantity-btn" data-id="${item.id}" data-change="-1">-</button>
                            <span class="quantity-number">${item.quantity}</span>
                            <button class="change-quantity-btn" data-id="${item.id}" data-change="1">+</button>
                        </div>
                        <button class="remove-from-cart-btn" data-id="${item.id}">Remover</button>
                    </div>`;
                cartItemsContainerModal.appendChild(itemElement);
            });
            updateCartSummary();
            addCartEventListeners();
        }
    };

    // --- Event Listeners para Abrir/Fechar ---
    if (openCartBtn) openCartBtn.addEventListener('click', (e) => {
        e.preventDefault();
        openCartModal();
    });
    if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartModal);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCartModal);


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
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('#email');
            alert(`Obrigado por se inscrever! Fique de olho em seu e-mail ${emailInput.value} para receber nossas ofertas.`);
            newsletterForm.reset();
        });
    }

    // Adicione este bloco dentro do evento 'DOMContentLoaded' em script.js

    // ===================================================================
    // --- LÓGICA DA PÁGINA DE PERFIL (profile.html) ---
    // ===================================================================
    const profileName = document.getElementById('profile-name');
    if (profileName) { // Verifica se estamos na página de perfil
        const currentUser = JSON.parse(localStorage.getItem('currentUser'));

        // Proteção de Rota: se não houver usuário, volta para o login
        if (!currentUser) {
            window.location.href = 'login.html';
        } else {
            // Preenche as informações na página
            document.getElementById('profile-name').textContent = currentUser.name;
            document.getElementById('profile-email').textContent = currentUser.email;
            document.getElementById('profile-avatar').textContent = currentUser.name.charAt(0).toUpperCase();

            // Lógica de Logout
            const logoutBtn = document.getElementById('logout-btn');
            logoutBtn.addEventListener('click', () => {
                if (confirm('Você tem certeza que deseja sair?')) {
                    localStorage.removeItem('currentUser');
                    localStorage.removeItem('edenshopCart'); // Opcional: limpar o carrinho ao sair
                    alert('Você foi desconectado.');
                    window.location.href = 'index.html';
                }
            });
        }
    }

    // ===================================================================
    // --- 7. INICIALIZAÇÃO GERAL (Executa em todas as páginas) ---
    // ===================================================================
    updateCartIcon();

});
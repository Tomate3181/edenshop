// checkout.js
document.addEventListener('DOMContentLoaded', () => {

    // Funções auxiliares para pegar o carrinho do localStorage
    const getCart = () => JSON.parse(localStorage.getItem('edenshopCart')) || [];

    const formatCurrency = (value) => `R$ ${value.toFixed(2).replace('.', ',')}`;

    // Função para carregar itens na página de checkout
    const loadCheckoutPage = () => {
        const cart = getCart();
        const itemsContainer = document.getElementById('checkout-items-container');
        const totalElement = document.getElementById('checkout-total');

        if (!itemsContainer) return; // Sai se não estiver na página de checkout

        // Se o carrinho estiver vazio, redireciona para a home
        if (cart.length === 0) {
            window.location.href = 'index.php';
            return;
        }

        itemsContainer.innerHTML = '';
        let subtotal = 0;

        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('checkout-item');

            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="checkout-item-image">
                <div class="checkout-item-info">
                    <h4>${item.name}</h4>
                    <p>Qtd: ${item.quantity}</p>
                </div>
                <span class="checkout-item-price">${formatCurrency(item.price * item.quantity)}</span>
            `;
            itemsContainer.appendChild(itemElement);
            subtotal += item.price * item.quantity;
        });

        totalElement.textContent = formatCurrency(subtotal);
    };

    // Função para carregar itens na página de confirmação
    const loadConfirmationPage = () => {
        // Usamos sessionStorage para garantir que os dados só apareçam uma vez após o pedido
        const confirmedOrder = JSON.parse(sessionStorage.getItem('confirmedOrder'));
        const itemsContainer = document.getElementById('confirmation-items');
        const totalElement = document.getElementById('confirmation-total');

        if (!confirmedOrder) {
            // Se não houver pedido confirmado, talvez o usuário tenha atualizado a página.
            // Opcional: redirecionar para a home ou mostrar uma mensagem.
            if (itemsContainer) itemsContainer.innerHTML = '<p>Não há detalhes do pedido para exibir.</p>';
            return;
        }

        itemsContainer.innerHTML = '';
        let subtotal = 0;

        confirmedOrder.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('checkout-item'); // Reutilizando a classe
            itemElement.innerHTML = `
                 <div class="checkout-item-info">
                    <h4>${item.name} (x${item.quantity})</h4>
                </div>
                <span class="checkout-item-price">${formatCurrency(item.price * item.quantity)}</span>
            `;
            itemsContainer.appendChild(itemElement);
            subtotal += item.price * item.quantity;
        });

        totalElement.textContent = formatCurrency(subtotal);

        // Limpa o pedido da sessão para que não seja exibido novamente se a página for recarregada
        sessionStorage.removeItem('confirmedOrder');
        // Limpa o carrinho real
        localStorage.removeItem('edenshopCart');

        // Atualiza o ícone do carrinho no cabeçalho (para 0)
        const cartIconCount = document.getElementById('cart-item-count');
        if (cartIconCount) {
            cartIconCount.textContent = '0';
            cartIconCount.style.display = 'none';
        }
    };

    // Lógica para o formulário de checkout
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            const cart = getCart();

            if (cart.length === 0) {
                e.preventDefault(); // Impede envio se carrinho vazio
                Swal.fire({ icon: 'warning', title: 'Carrinho Vazio', text: 'Seu carrinho está vazio!', confirmButtonColor: '#6b8e23' });
                return;
            }

            // 1. Preenche o campo hidden para o PHP processar
            const cartDataInput = document.getElementById('cartData');
            if (cartDataInput) {
                cartDataInput.value = JSON.stringify(cart);
            }

            // 2. Guarda o pedido no sessionStorage APENAS para exibição na página de confirmação (frontend)
            sessionStorage.setItem('confirmedOrder', JSON.stringify(cart));

            // 3. NÃO chamamos e.preventDefault() nem window.location.href aqui.
            // Deixamos o formulário ser enviado via POST para php/process_checkout.php
        });
    }

    // Chama a função apropriada dependendo da página em que estamos
    if (document.getElementById('checkout-items-container')) {
        loadCheckoutPage();
    }

    if (document.getElementById('confirmation-items')) {
        loadConfirmationPage();
    }
});

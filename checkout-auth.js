// Verificação de login no botão de finalizar compra do modal de carrinho
document.addEventListener('DOMContentLoaded', () => {
    const checkoutBtnModal = document.getElementById('checkout-btn-modal');

    if (checkoutBtnModal) {
        checkoutBtnModal.addEventListener('click', (e) => {
            // Verifica se o usuário está logado através da sessão PHP
            // Como não temos acesso direto à sessão PHP no JavaScript,
            // vamos verificar se existe o elemento do menu do usuário logado
            const userMenuButton = document.getElementById('user-menu-button');

            if (!userMenuButton) {
                // Usuário não está logado
                e.preventDefault();

                // Fecha o modal de carrinho
                const cartModal = document.getElementById('cartModal');
                if (cartModal) {
                    cartModal.classList.remove('active');
                }

                // Abre o modal de login
                const loginModal = document.getElementById('loginModal');
                if (loginModal) {
                    loginModal.style.display = 'block';
                }

                // Exibe um alerta (que será convertido para SweetAlert2 pelo override)
                alert('Por favor, faça login para finalizar sua compra.');
            } else {
                // Usuário está logado, redireciona para checkout
                window.location.href = 'checkout.php';
            }
        });
    }
});

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Finalizar Compra - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="critical-fixes.css" />
    <link rel="stylesheet" href="search-dropdown.css" />
    <link rel="stylesheet" href="checkout.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .payment-option {
            cursor: pointer;
        }
        
        .payment-option input[type="radio"] {
            display: none;
        }
        
        .payment-card {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
        }
        
        .payment-option input[type="radio"]:checked + .payment-card {
            border-color: #6b8e23;
            background-color: rgba(107, 142, 35, 0.05);
        }
        
        .payment-card:hover {
            border-color: #6b8e23;
        }
        
        .payment-card i {
            font-size: 1.5rem;
            color: #6b8e23;
        }
        
        .payment-card span {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include 'php/header.php'; ?>

    <main class="page-padding">
        <div class="container">
            <h1 class="page-title" style="padding-top: 3rem; padding-bottom: 2rem;">Finalizar Compra</h1>
            
            <div class="checkout-layout">
                <!-- Seção de Detalhes do Cliente -->
                <div class="customer-details">
                    <h2>Seus Dados</h2>
                    <form id="checkout-form" method="POST" action="php/process_checkout.php">
                        <div class="form-group">
                            <label for="fullName">Nome Completo</label>
                            <input type="text" id="fullName" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <h2>Endereço de Entrega</h2>
                        <div class="form-group">
                            <label for="address">Endereço</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">Cidade</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="state">Estado</label>
                                <input type="text" id="state" name="state" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip">CEP</label>
                            <input type="text" id="zip" name="zip" required maxlength="9" placeholder="00000-000">
                        </div>

                        <h2>Método de Pagamento</h2>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="credit" required>
                                <div class="payment-card">
                                    <i class="fas fa-credit-card"></i>
                                    <span>Cartão de Crédito</span>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="debit">
                                <div class="payment-card">
                                    <i class="fas fa-money-check-alt"></i>
                                    <span>Cartão de Débito</span>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="pix">
                                <div class="payment-card">
                                    <i class="fas fa-qrcode"></i>
                                    <span>PIX</span>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="boleto">
                                <div class="payment-card">
                                    <i class="fas fa-barcode"></i>
                                    <span>Boleto</span>
                                </div>
                            </label>
                        </div>

                        <!-- Campos de cartão (aparecem quando cartão é selecionado) -->
                        <div id="card-fields" style="display: none;">
                            <div class="form-group">
                                <label for="cardNumber">Número do Cartão</label>
                                <input type="text" id="cardNumber" name="cardNumber" placeholder="0000 0000 0000 0000" maxlength="19">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cardExpiry">Validade</label>
                                    <input type="text" id="cardExpiry" name="cardExpiry" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="cardCVV">CVV</label>
                                    <input type="text" id="cardCVV" name="cardCVV" placeholder="000" maxlength="3">
                                </div>
                            </div>
                        </div>

                        <!-- Campo oculto para enviar dados do carrinho -->
                        <input type="hidden" id="cartData" name="cartData">
                    </form>
                </div>

                <!-- Seção de Resumo do Pedido -->
                <div class="order-summary-checkout">
                    <h3>Resumo do Pedido</h3>
                    <div id="checkout-items-container">
                        <!-- Itens do carrinho serão inseridos aqui pelo JS -->
                    </div>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="checkout-total">R$ 0,00</span>
                    </div>
                    <button type="submit" form="checkout-form" class="btn large-btn">Confirmar Pedido</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Carrinho -->
    <div id="cartModal" class="cart-modal">
      <div class="cart-modal-overlay"></div>
      <div class="cart-modal-content">
        <div class="cart-modal-header">
          <h3>Meu Carrinho</h3>
          <button class="close-cart-btn">&times;</button>
        </div>
        <div class="cart-modal-body">
          <div id="cart-items-container-modal"></div>
          <div id="cart-empty-message-modal" class="cart-empty" style="display: none">
            <h2>Seu carrinho está vazio.</h2>
            <p>Adicione algumas plantas para vê-las aqui!</p>
            <a href="products.php" class="btn">Ver Produtos</a>
          </div>
        </div>
        <div id="cart-modal-footer" class="cart-modal-footer">
          <div class="order-summary-modal">
            <div class="summary-row total-row">
              <span>Subtotal</span>
              <span id="cart-total-modal">R$ 0,00</span>
            </div>
            <button id="checkout-btn-modal" class="btn large-btn">Finalizar Compra</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="login-box-modal">
          <div class="login-header-text">
            <h2>Bem-vindo de volta!</h2>
            <p>Faça login para continuar</p>
          </div>
          <form id="loginForm" method="POST" action="php/login.php">
            <div class="input-group">
              <label for="modal-email">Email</label>
              <input type="email" id="modal-email" name="email" placeholder="seuemail@exemplo.com" required />
            </div>
            <div class="input-group">
              <label for="modal-password">Senha</label>
              <input type="password" id="modal-password" name="password" placeholder="Sua senha" required />
            </div>
            <button type="submit" class="btn">Entrar</button>
            <div class="login-footer">
              <p>Não tem uma conta? <a href="#" id="switchToRegister">Cadastre-se</a></p>
              <a href="#">Esqueceu sua senha?</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
        <div class="footer-section">
          <h3>Edenshop</h3>
          <p>Conectando pessoas e o verde no dia a dia.</p>
        </div>
        <div class="footer-section">
          <h3>Links Úteis</h3>
          <ul>
            <li><a href="#">Política de Privacidade</a></li>
            <li><a href="#">Termos de Serviço</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>Siga-nos</h3>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Edenshop. Todos os direitos reservados.</p>
      </div>
    </footer>

    <script src="checkout.js"></script>
    <script src="script.js"></script>
    <script src="navbar.js"></script>
    <script src="search.js"></script>
    <script>
        // Mostrar campos de cartão quando cartão for selecionado
        document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const cardFields = document.getElementById('card-fields');
                if (this.value === 'credit' || this.value === 'debit') {
                    cardFields.style.display = 'block';
                } else {
                    cardFields.style.display = 'none';
                }
            });
        });

        // Adicionar dados do carrinho ao formulário antes de enviar
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cartData').value = JSON.stringify(cart);
        });
    </script>
</body>
</html>
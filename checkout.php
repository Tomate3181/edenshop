<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Finalizar Compra - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="checkout.css" />
    <!-- Font Awesome para ícones -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>
    <?php include 'php/header.php'; ?>

    <main class="page-padding">
        <div class="container">
            <h1 class="page-title">Finalizar Compra</h1>
            
            <div class="checkout-layout">
                <!-- Seção de Detalhes do Cliente -->
                <div class="customer-details">
                    <h2>Seus Dados</h2>
                    <form id="checkout-form">
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
                            <input type="text" id="zip" name="zip" required>
                        </div>

                        <h2>Pagamento</h2>
                        <p>Funcionalidade de pagamento será implementada em breve. Clique abaixo para confirmar seu pedido.</p>

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

    <!-- =============================================== -->
    <!-- ============ INÍCIO DO MODAL DE CARRINHO ============ -->
    <!-- =============================================== -->
    <div id="cartModal" class="cart-modal">
      <!-- Fundo escurecido -->
      <div class="cart-modal-overlay"></div>

      <!-- Conteúdo do modal -->
      <div class="cart-modal-content">
        <!-- Cabeçalho do modal -->
        <div class="cart-modal-header">
          <h3>Meu Carrinho</h3>
          <button class="close-cart-btn">&times;</button>
        </div>

        <!-- Corpo do modal (onde os itens e a mensagem de vazio aparecem) -->
        <div class="cart-modal-body">
          <!-- Itens do Carrinho (serão preenchidos pelo JS) -->
          <div id="cart-items-container-modal"></div>

          <!-- Mensagem de Carrinho Vazio -->
          <div
            id="cart-empty-message-modal"
            class="cart-empty"
            style="display: none"
          >
            <h2>Seu carrinho está vazio.</h2>
            <p>Adicione algumas plantas para vê-las aqui!</p>
            <a href="products.html" class="btn">Ver Produtos</a>
          </div>
        </div>

        <!-- Rodapé do modal (resumo e botão de finalizar) -->
        <div id="cart-modal-footer" class="cart-modal-footer">
          <!-- Reutilizamos a sua classe order-summary com algumas adaptações -->
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
    <!-- =============================================== -->
    <!-- ============= FIM DO MODAL DE CARRINHO ============= -->
    <!-- =============================================== -->

    <!-- =============================================== -->
    <!-- ============= INÍCIO DO MODAL DE LOGIN ============= -->
    <!-- =============================================== -->
    <div id="loginModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <!-- Conteúdo reutilizado do seu login-box -->
        <div class="login-box-modal">
          <div class="login-header-text">
            <h2>Bem-vindo de volta!</h2>
            <p>Faça login para continuar</p>
          </div>
          <form id="loginForm">
            <!-- O ID importante que seu JS já usa -->
            <div class="input-group">
              <label for="modal-email">Email</label>
              <input
                type="email"
                id="modal-email"
                name="email"
                placeholder="seuemail@exemplo.com"
                required
              />
            </div>
            <div class="input-group">
              <label for="modal-password">Senha</label>
              <input
                type="password"
                id="modal-password"
                name="password"
                placeholder="Sua senha"
                required
              />
            </div>
            <button type="submit" class="btn">Entrar</button>
            <div class="login-footer">
              <p>
                Não tem uma conta?
                <a href="#" id="switchToRegister">Cadastre-se</a>
              </p>
              <a href="#">Esqueceu sua senha?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- =============================================== -->
    <!-- =============== FIM DO MODAL DE LOGIN =============== -->
    <!-- =============================================== -->

    <!-- Footer (consistente com o resto do site) -->
    <footer class="footer">
        <!-- O mesmo conteúdo do seu footer aqui -->
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

    <script src="navbar.js"></script> <!-- Carregue o script principal também -->
    <script src="search.js"></script>
</body>
</html>
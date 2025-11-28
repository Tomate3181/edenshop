<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedido Confirmado - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="checkout.css" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>
      <header>
    <nav class="navbar">
      <div class="logo">
        <a href="index.php">
          <img src="./assets/logo2.png" alt="Edenshop Logo" />
        </a>
      </div>

      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Produtos</a></li>
        <li><a href="about.php">Sobre Nós</a></li>
        <li><a href="contact.php">Contato</a></li>
      </ul>

      <div class="nav-icons">
        <div class="search-container">
          <input type="search" id="search-bar" class="search-bar" placeholder="Buscar plantas..." />
          <a href="#" id="search-icon-btn" aria-label="Buscar"><i class="fas fa-search"></i></a>
        </div>
        <a href="#" id="open-cart-btn" aria-label="Abrir carrinho de compras" class="cart-icon-link">
          <i class="fas fa-shopping-cart"></i>
          <span id="cart-item-count">0</span>
        </a>
        <a href="#" id="user-action-icon"><i class="fas fa-user"></i></a>
      </div>
    </nav>
  </header>

    <main class="page-padding">
        <div class="container text-center">
            <div class="confirmation-box">
                <i class="fas fa-check-circle confirmation-icon"></i>
                <h1 class="page-title">Obrigado pelo seu pedido!</h1>
                <p class="page-subtitle">Seu pedido foi recebido e está sendo preparado para envio. Enviamos um email de confirmação com os detalhes da sua compra.</p>
                <div class="order-summary-confirmation">
                    <h3>Resumo da Compra</h3>
                    <div id="confirmation-items"></div>
                    <div class="summary-row total-row">
                        <span>Total Pago</span>
                        <span id="confirmation-total"></span>
                    </div>
                </div>
                <a href="products.html" class="btn">Continuar Comprando</a>
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

    <!-- Footer -->
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

    <script src="navbar.js"></script>
    <script src="search.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monstera Deliciosa - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
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

    <main class="container page-padding">
      <div class="product-detail-layout">
        <!-- Galeria de Imagens do Produto -->
        <div class="product-image-gallery">
          <img
            src="https://growurban.uk/cdn/shop/articles/care-guide-monstera-deliciosa-668092_680bbf00-9564-4f0c-b9cb-27ededaf19d2.jpg?v=1748436514&width=2048"
            alt="Monstera Deliciosa - Vista Principal"
            id="mainProductImage"
            class="main-image"
          />
          <div class="thumbnail-images">
            <img
              src="https://growurban.uk/cdn/shop/articles/care-guide-monstera-deliciosa-668092_680bbf00-9564-4f0c-b9cb-27ededaf19d2.jpg?v=1748436514&width=2048"
              alt="Monstera Thumbnail 1"
              class="thumbnail active"
            />
            <img
              src="https://www.ourhouseplants.com/imgs-content/monstera-deliciosa-moss-pole.jpg"
              alt="Monstera Thumbnail 2"
              class="thumbnail"
            />
            <img
              src="https://www.smallandgreen.com/wp-content/uploads/2022/04/R_8FXiuKEemVpNz4j5wv6w-pnja_Dv0EeyYyr60XqKDaw-scaled.jpeg"
              alt="Monstera Thumbnail 3"
              class="thumbnail"
            />
          </div>
        </div>

        <!-- Informações do Produto -->
        <div
          class="product-info"
          data-id="p2"
          data-name="Monstera Deliciosa"
          data-price="89.90"
          data-image="https://growurban.uk/cdn/shop/articles/care-guide-monstera-deliciosa-668092_680bbf00-9564-4f0c-b9cb-27ededaf19d2.jpg?v=1748436514&width=2048"
          data-category="interna"
          data-care="pet-friendly"
        >
          <h1>Monstera Deliciosa</h1>
          <p class="product-price">R$ 89,90</p>
          <p class="short-description">
            Também conhecida como Costela-de-Adão, é uma planta icônica com
            folhas grandes e recortadas que adicionam um toque tropical a
            qualquer ambiente.
          </p>

          <div class="quantity-selector">
            <label for="quantity">Quantidade:</label>
            <div class="quantity-wrapper">
              <button id="decreaseQuantity">-</button>
              <input type="number" id="quantity" value="1" min="1" />
              <button id="increaseQuantity">+</button>
            </div>
          </div>

          <button class="btn add-to-cart-btn large-btn">
            Adicionar ao Carrinho
          </button>
        </div>
      </div>

      <!-- Abas com Detalhes Adicionais -->
      <div class="product-details-tabs">
        <div class="tab-buttons">
          <button class="tab-btn active" data-target="#description">
            Descrição
          </button>
          <button class="tab-btn" data-target="#care">Cuidados</button>
          <button class="tab-btn" data-target="#specs">Especificações</button>
        </div>
        <div id="description" class="tab-content active">
          <p>
            A Monstera Deliciosa é uma das plantas de interior mais populares do
            mundo, e por um bom motivo. Suas folhas exuberantes desenvolvem
            fendas naturais (fenestrações) à medida que amadurecem, criando um
            visual espetacular. É uma planta relativamente fácil de cuidar e que
            purifica o ar.
          </p>
        </div>
        <div id="care" class="tab-content">
          <ul>
            <li>
              <strong>Luz:</strong> Prefere luz indireta brilhante. Evite sol
              direto, que pode queimar as folhas.
            </li>
            <li>
              <strong>Água:</strong> Regue quando os 2-3 cm superiores do solo
              estiverem secos. Evite encharcar.
            </li>
            <li>
              <strong>Umidade:</strong> Gosta de umidade. Borrifar as folhas
              ocasionalmente pode ajudar.
            </li>
            <li>
              <strong>Solo:</strong> Substrato bem drenado, rico em matéria
              orgânica.
            </li>
          </ul>
        </div>
        <div id="specs" class="tab-content">
          <ul>
            <li>
              <strong>Nome Científico:</strong> <em>Monstera deliciosa</em>
            </li>
            <li><strong>Família:</strong> Araceae</li>
            <li>
              <strong>Origem:</strong> Florestas tropicais do México e América
              Central
            </li>
            <li><strong>Altura Média:</strong> 30-40 cm (no vaso)</li>
            <li>
              <strong>Pet-Friendly:</strong> Não. É tóxica se ingerida por
              animais de estimação.
            </li>
          </ul>
        </div>
      </div>

      <!-- Produtos Relacionados -->
      <section class="related-products">
        <h2 class="section-title">Você também pode gostar</h2>
        <div class="products-grid">
          <!-- Produto Relacionado 1 -->
          <div
            class="product-card"
            data-id="p5"
            data-name="Ficus Lyrata"
            data-price="129.90"
            data-image="https://cdn.store-assets.com/s/214074/i/88112830.jpeg"
            data-category="externa"
            data-care=""
          >
            <a href="product-detail.html" class="product-link">
              <img
                src="https://cdn.store-assets.com/s/214074/i/88112830.jpeg"
                alt="Planta Ficus Lyrata"
              />
              <h3>Ficus Lyrata</h3>
              <p class="price">R$ 129,90</p>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
          </div>
          <!-- Produto Relacionado 2 -->
          <div
            class="product-card"
            data-id="p3"
            data-name="Espada de São Jorge"
            data-price="59.90"
            data-image="https://cdn.awsli.com.br/600x700/1520/1520689/produto/247127180/espada-de-sao-jorge-mini3-b1rfi2xmr4.jpeg"
            data-category="interna"
            data-care="facil"
          >
            <a href="product-detail.html" class="product-link">
              <img
                src="https://cdn.awsli.com.br/600x700/1520/1520689/produto/247127180/espada-de-sao-jorge-mini3-b1rfi2xmr4.jpeg"
                alt="Planta Espada de São Jorge"
              />
              <h3>Espada de São Jorge</h3>
              <p class="price">R$ 59,90</p>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
          </div>
          <!-- Produto Relacionado 3 -->
          <div
            class="product-card"
            data-id="p4"
            data-name="Zamioculca"
            data-price="69.90"
            data-image="https://upload.wikimedia.org/wikipedia/commons/d/d6/Zamioculcas.jpg"
            data-category="interna suculenta"
            data-care="facil"
          >
            <a href="product-detail.html" class="product-link">
              <img
                src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Zamioculcas.jpg"
                alt="Planta Zamioculca"
              />
              <h3>Zamioculca</h3>
              <p class="price">R$ 69,90</p>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
          </div>
        </div>
      </section>
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
              <p>Não tem uma conta? <a href="#">Cadastre-se</a></p>
              <a href="#">Esqueceu sua senha?</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- =============================================== -->
    <!-- =============== FIM DO MODAL DE LOGIN =============== -->
    <!-- =============================================== -->

    <!-- =============================================== -->
<!-- =========== INÍCIO DO MODAL DE CADASTRO =========== -->
<!-- =============================================== -->
<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <!-- Conteúdo adaptado para o cadastro -->
    <div class="login-box-modal">
      <div class="login-header-text">
        <h2>Crie sua conta</h2>
        <p>É rápido e fácil!</p>
      </div>
      <form id="registerForm">
        <!-- Campo Nome -->
        <div class="input-group">
          <label for="register-name">Nome</label>
          <input
            type="text"
            id="register-name"
            name="name"
            placeholder="Seu nome completo"
            required
          />
        </div>
        <!-- Campo Email -->
        <div class="input-group">
          <label for="register-email">Email</label>
          <input
            type="email"
            id="register-email"
            name="email"
            placeholder="seuemail@exemplo.com"
            required
          />
        </div>
        <!-- Campo Senha -->
        <div class="input-group">
          <label for="register-password">Senha</label>
          <input
            type="password"
            id="register-password"
            name="password"
            placeholder="Crie uma senha forte"
            required
          />
        </div>
        <!-- Campo Confirmar Senha -->
        <div class="input-group">
          <label for="confirm-password">Confirmar Senha</label>
          <input
            type="password"
            id="confirm-password"
            name="confirm_password"
            placeholder="Digite a senha novamente"
            required
          />
        </div>
        <button type="submit" class="btn">Cadastrar</button>
        <div class="login-footer">
          <p>Já tem uma conta? <a href="#" id="switchToLogin">Faça login</a></p>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- =============================================== -->
<!-- ============ FIM DO MODAL DE CADASTRO ============ -->
<!-- =============================================== -->

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

    <script src="script.js"></script>

    <script src="navbar.js"></script>
    <script src="search.js"></script>
  </body>
</html>

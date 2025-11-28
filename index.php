<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edenshop - Sua loja de plantas online</title>
    <link rel="stylesheet" href="style.css" />

    <link rel="stylesheet" href="homepage.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body class="transparent-header">
    <header>
      <nav class="navbar">
        <div class="logo">
          <a href="index.html">
            <img src="./assets/logo2.png" alt="Edenshop Logo" />
            <!-- Edenshop -->
          </a>
        </div>
        <ul class="nav-links">
          <li><a href="index.html">Home</a></li>
          <li><a href="products.html">Produtos</a></li>
          <li><a href="about.html">Sobre Nós</a></li>
          <li><a href="contact.html">Contato</a></li>
        </ul>
        <div class="nav-icons">
          <!-- INÍCIO DO NOVO COMPONENTE DE BUSCA -->
          <div class="search-container">
            <input
              type="search"
              id="search-bar"
              class="search-bar"
              placeholder="Buscar plantas..."
            />
            <a href="#" id="search-icon-btn" aria-label="Buscar"
              ><i class="fas fa-search"></i
            ></a>
          </div>
          <!-- FIM DO NOVO COMPONENTE DE BUSCA -->

          <a
            href="#"
            id="open-cart-btn"
            aria-label="Abrir carrinho de compras"
            class="cart-icon-link"
          >
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-item-count">0</span>
          </a>
          <a href="#" id="user-action-icon"><i class="fas fa-user"></i></a>
        </div>
      </nav>
    </header>

    <main>
      <!-- Seção Hero -->
      <section class="hero">
        <div class="hero-content animate-on-scroll">
          <h1>Conecte-se com a Natureza</h1>
          <p>
            Plantas que trazem vida, bem-estar e sustentabilidade para o seu dia
            a dia.
          </p>
          <a href="products.html" class="btn">Ver Produtos</a>
        </div>
      </section>

      <!-- Seção de Produtos em Destaque CORRIGIDA -->
      <section class="featured-products">
        <div class="container">
          <h2 class="section-title animate-on-scroll">Produtos em Destaque</h2>
          <div class="products-grid">
            <!-- Produto 1 -->
            <div
              class="product-card animate-on-scroll"
              data-id="prod1"
              data-name="Monstera Deliciosa"
              data-price="89.90"
              data-image="https://growurban.uk/cdn/shop/articles/care-guide-monstera-deliciosa-668092_680bbf00-9564-4f0c-b9cb-27ededaf19d2.jpg?v=1748436514&width=2048"
            >
              <img
                src="https://growurban.uk/cdn/shop/articles/care-guide-monstera-deliciosa-668092_680bbf00-9564-4f0c-b9cb-27ededaf19d2.jpg?v=1748436514&width=2048"
                alt="Planta Monstera Deliciosa"
              />
              <div class="product-card-content">
                <h3>Monstera Deliciosa</h3>
                <p class="price">R$ 89,90</p>
              </div>
              <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
            </div>
            <!-- Produto 2 -->
            <div
              class="product-card animate-on-scroll"
              data-id="prod2"
              data-name="Jiboia (Epipremnum aureum)"
              data-price="49.90"
              data-image="https://www.shutterstock.com/image-photo/epipremnum-aureum-species-flowering-plant-600nw-2557759849.jpg"
            >
              <img
                src="https://www.shutterstock.com/image-photo/epipremnum-aureum-species-flowering-plant-600nw-2557759849.jpg"
                alt="Planta Jiboia"
              />
              <div class="product-card-content">
                <h3>Jiboia (Epipremnum aureum)</h3>
                <p class="price">R$ 49,90</p>
              </div>
              <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
            </div>
            <!-- Produto 3 -->
            <div
              class="product-card animate-on-scroll"
              data-id="prod3"
              data-name="Zamioculca"
              data-price="69.90"
              data-image="https://upload.wikimedia.org/wikipedia/commons/d/d6/Zamioculcas.jpg"
            >
              <img
                src="https://upload.wikimedia.org/wikipedia/commons/d/d6/Zamioculcas.jpg"
                alt="Planta Zamioculca"
              />
              <div class="product-card-content">
                <h3>Zamioculca</h3>
                <p class="price">R$ 69,90</p>
              </div>
              <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
            </div>
            <!-- Produto 4 -->
            <div
              class="product-card animate-on-scroll"
              data-id="prod4"
              data-name="Espada de São Jorge"
              data-price="59.90"
              data-image="https://cdn.awsli.com.br/600x700/1520/1520689/produto/247127180/espada-de-sao-jorge-mini3-b1rfi2xmr4.jpeg"
            >
              <img
                src="https://cdn.awsli.com.br/600x700/1520/1520689/produto/247127180/espada-de-sao-jorge-mini3-b1rfi2xmr4.jpeg"
                alt="Planta Espada de São Jorge"
              />
              <div class="product-card-content">
                <h3>Espada de São Jorge</h3>
                <p class="price">R$ 59,90</p>
              </div>
              <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
            </div>
          </div>
          <div class="text-center animate-on-scroll">
            <a href="products.html" class="btn">Ver todos os produtos</a>
          </div>
        </div>
      </section>

      <!-- Seção de Valores -->
      <section class="values-section">
        <div class="container">
          <h2 class="section-title">Nossos Valores</h2>
          <div class="values-container">
            <div class="value-item">
              <i class="fas fa-leaf"></i>
              <h3>Sustentabilidade</h3>
              <p>Promover práticas conscientes em todas as etapas.</p>
            </div>
            <div class="value-item">
              <i class="fas fa-lightbulb"></i>
              <h3>Inovação</h3>
              <p>Unir tecnologia e natureza de forma criativa.</p>
            </div>
            <div class="value-item">
              <i class="fas fa-check-circle"></i>
              <h3>Qualidade</h3>
              <p>Garantir uma experiência confiável ao usuário.</p>
            </div>
            <div class="value-item">
              <i class="fas fa-universal-access"></i>
              <h3>Acessibilidade</h3>
              <p>Oferecer um site prático e inclusivo para todos.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- NOVA SEÇÃO: Benefícios -->
      <section class="benefits-section">
        <div class="container">
          <h2 class="section-title">Benefícios</h2>
          <div class="benefits-grid">
            <div class="benefit-card">
              <h3><i class="fas fa-truck"></i> Frete grátis</h3>
              <p>
                Receba suas plantas no conforto da sua casa sem custo adicional
                em compras acima de um determinado valor.
              </p>
            </div>
            <div class="benefit-card">
              <h3><i class="fas fa-credit-card"></i> Parcelamento</h3>
              <p>
                Facilitamos sua compra com opções de parcelamento flexíveis no
                cartão de crédito para você decorar seu espaço sem pesar no
                bolso.
              </p>
            </div>
            <div class="benefit-card">
              <h3><i class="fas fa-shield-alt"></i> Compra segura</h3>
              <p>
                Nossa plataforma utiliza tecnologia de ponta para garantir que
                seus dados e sua compra estejam sempre protegidos.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- NOVA SEÇÃO: Avaliações -->
      <section class="testimonials-section">
        <div class="container">
          <h2 class="section-title">Avaliações</h2>
          <div class="testimonial-carousel">
            <div class="testimonial-wrapper">
              <!-- Avaliação 1 -->
              <div class="testimonial-slide">
                <p class="testimonial-text">
                  "Minha Monstera chegou perfeita e muito bem embalada! O
                  cuidado da Edenshop é visível em cada detalhe. Super
                  recomendo!"
                </p>
                <p class="testimonial-author">- Ana Clara R.</p>
              </div>
              <!-- Avaliação 2 -->
              <div class="testimonial-slide">
                <p class="testimonial-text">
                  "Nunca imaginei que comprar plantas online seria tão fácil. O
                  site é lindo, intuitivo e a entrega foi super rápida. Virei
                  cliente!"
                </p>
                <p class="testimonial-author">- Marcos V.</p>
              </div>
              <!-- Avaliação 3 -->
              <div class="testimonial-slide">
                <p class="testimonial-text">
                  "A qualidade das plantas é incrível. Comprei uma Jiboia e ela
                  está linda e saudável. O suporte ao cliente também foi muito
                  atencioso."
                </p>
                <p class="testimonial-author">- Beatriz L.</p>
              </div>
            </div>
            <button class="carousel-btn prev" id="prevBtn">&#10094;</button>
            <button class="carousel-btn next" id="nextBtn">&#10095;</button>
          </div>
        </div>
      </section>

      <!-- NOVA SEÇÃO: Newsletter -->
      <section class="newsletter-section">
        <div class="container">
          <h2 class="section-title">Receba ofertas exclusivas</h2>
          <form class="newsletter-form" id="newsletterForm">
            <label for="email" class="sr-only">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Digite seu melhor e-mail"
              required
            />
            <button type="submit" class="btn">Assinar</button>
          </form>
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
        <div class="login-box-modal">
        <div class="login-header-text">
        <h2>Bem-vindo de volta!</h2>
        <p>Faça login para continuar</p>
      </div>
      <form id="loginForm" method="POST" action="php/login.php">
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
          <form id="registerForm" method="POST" action="php/register.php">
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
              <p>
                Já tem uma conta? <a href="#" id="switchToLogin">Faça login</a>
              </p>
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
    <script src="homepage.js"></script>
    <script src="search.js"></script>
  </body>
</html>

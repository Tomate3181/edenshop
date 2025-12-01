<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nós - Edenshop</title>
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="critical-fixes.css" />
  <link rel="stylesheet" href="search-dropdown.css" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include 'php/header.php'; ?>
  <main>
    <!-- Seção Hero da Página Sobre -->
    <section class="about-hero">
      <div class="hero-content">
        <h1>Nossa Essência é Verde</h1>
        <p>Mais que uma loja, somos um movimento para reconectar pessoas e natureza.</p>
      </div>
    </section>

    <div class="container page-padding">
      <!-- Seção Missão e Visão -->
      <section class="mission-vision-section">
        <div class="info-card">
          <i class="fas fa-rocket"></i>
          <h2>Nossa Missão</h2>
          <p>Oferecer uma plataforma intuitiva e acessível para a venda de plantas online. Buscamos criar um ambiente
            digital que valorize a natureza, promovendo bem-estar, sustentabilidade e a conexão entre pessoas e o verde
            no dia a dia.</p>
        </div>
        <div class="info-card">
          <i class="fas fa-eye"></i>
          <h2>Nossa Visão</h2>
          <p>Transformar o EdenShop em referência no comércio digital de plantas, sendo reconhecido pela experiência de
            compra simples, pelo design inovador e pela preocupação com a sustentabilidade.</p>
        </div>
      </section>

      <!-- Seção de Valores (reutilizando o estilo da home) -->
      <section class="values-section about-page-values">
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
      </section>

      <!-- Seção Compromisso Ambiental -->
      <section class="commitment-section">
        <div class="commitment-text">
          <h2 class="section-title" style="text-align: left;">Nosso Compromisso com o Planeta</h2>
          <p>Vivemos em um momento de grandes desafios climáticos. O aquecimento global, a redução da biodiversidade e
            os eventos extremos são realidades que não podemos ignorar. Na Edenshop, acreditamos que cada planta
            cultivada é um pequeno passo na direção certa.</p>
          <p>Nosso compromisso com a <strong>sustentabilidade</strong> vai além das palavras. Buscamos fornecedores
            locais, utilizamos embalagens recicláveis e promovemos ativamente a conscientização sobre a importância do
            verde em nossas vidas e cidades. Fazer parte da Edenshop é apoiar um futuro mais verde e saudável.</p>
        </div>
        <div class="commitment-image">
          <img
            src="https://img.freepik.com/fotos-premium/uma-pessoa-segurando-uma-planta-na-terra-imagem-generativa-de-ia-plantando-arvores-para-um-futuro-verde-e-sustentavel_87646-11969.jpg"
            alt="Mãos segurando uma pequena planta com terra">
        </div>
      </section>
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
        <div id="cart-empty-message-modal" class="cart-empty" style="display: none">
          <h2>Seu carrinho está vazio.</h2>
          <p>Adicione algumas plantas para vê-las aqui!</p>
          <a href="products.php" class="btn">Ver Produtos</a>
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
        <form id="loginForm" method="POST" action="php/login.php">
          <!-- O ID importante que seu JS já usa -->
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
            <input type="text" id="register-name" name="name" placeholder="Seu nome completo" required />
          </div>
          <!-- Campo Email -->
          <div class="input-group">
            <label for="register-email">Email</label>
            <input type="email" id="register-email" name="email" placeholder="seuemail@exemplo.com" required />
          </div>
          <!-- Campo Senha -->
          <div class="input-group">
            <label for="register-password">Senha</label>
            <input type="password" id="register-password" name="password" placeholder="Crie uma senha forte" required />
          </div>
          <!-- Campo Confirmar Senha -->
          <div class="input-group">
            <label for="confirm-password">Confirmar Senha</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Digite a senha novamente"
              required />
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
  <script src="checkout-auth.js"></script>
</body>

</html>
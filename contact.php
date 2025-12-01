<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contato - Edenshop</title>
  <link rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="critical-fixes.css" />
  <link rel="stylesheet" href="search-dropdown.css" />
  <link rel="stylesheet" href="spacing-fixes.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <?php include 'php/header.php'; ?>
  <main class="container page-padding">
    <h1 class="page-title">Fale Conosco</h1>
    <p class="page-subtitle">Tem alguma dúvida, sugestão ou apenas quer dizer um oi? Use o formulário abaixo ou nossos
      outros canais de atendimento.</p>

    <div class="contact-layout">
      <!-- Formulário de Contato -->
      <form id="contactForm" class="contact-form">
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" id="name" name="name" placeholder="Seu nome completo" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="seu.email@exemplo.com" required>
        </div>
        <div class="form-group">
          <label for="subject">Assunto</label>
          <input type="text" id="subject" name="subject" placeholder="Sobre o que você quer falar?" required>
        </div>
        <div class="form-group">
          <label for="message">Mensagem</label>
          <textarea id="message" name="message" rows="6" placeholder="Escreva sua mensagem aqui..." required></textarea>
        </div>
        <button type="submit" class="btn">Enviar Mensagem</button>
      </form>

      <!-- Informações de Contato -->
      <div class="contact-info">
        <h3>Nossos Canais</h3>
        <p><i class="fas fa-envelope"></i> <strong>Email:</strong><br> <a
            href="mailto:contato@edenshop.com">contato@edenshop.com</a></p>
        <p><i class="fas fa-phone-alt"></i> <strong>Telefone:</strong><br> (11) 99999-8888</p>
        <p><i class="fas fa-map-marker-alt"></i> <strong>Endereço:</strong><br> Av. das Plantas, 123<br>São Paulo, SP -
          Brasil</p>

        <h3 class="social-title">Siga-nos</h3>
        <div class="social-icons-contact">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
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
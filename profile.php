<?php
// 1. INICIA A SESSÃO
session_start();

// 2. VERIFICAÇÃO DE SEGURANÇA (GUARDA DE ROTA)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?error=notloggedin");
    exit();
}

// 3. RECUPERA OS DADOS DA SESSÃO PARA EXIBIÇÃO
$nome_usuario = htmlspecialchars($_SESSION['usuario_nome']);
$email_usuario = htmlspecialchars($_SESSION['usuario_email']);
$inicial_usuario = mb_strtoupper(mb_substr($nome_usuario, 0, 1));
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Minha Conta - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="profile.css" />
    <link rel="stylesheet" href="critical-fixes.css" />
    <link rel="stylesheet" href="search-dropdown.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <?php include 'php/header.php'; ?>

  <!-- Alertas no canto superior direito -->
  <div class="alert-container">
    <?php
    // Exibir mensagens de sucesso
    if (isset($_GET['success'])) {
        $success_message = '';
        $icon = 'fa-check-circle';
        switch ($_GET['success']) {
            case 'nameupdated':
                $success_message = 'Nome atualizado com sucesso!';
                break;
            case 'passwordupdated':
                $success_message = 'Senha alterada com sucesso!';
                break;
        }
        if ($success_message) {
            echo '<div class="alert alert-success"><i class="fas ' . $icon . '"></i>' . htmlspecialchars($success_message) . '</div>';
        }
    }
    
    // Exibir mensagens de erro
    if (isset($_GET['error'])) {
        $error_message = '';
        $icon = 'fa-exclamation-circle';
        switch ($_GET['error']) {
            case 'emptyname':
                $error_message = 'O nome não pode estar vazio.';
                break;
            case 'shortname':
                $error_message = 'O nome deve ter pelo menos 3 caracteres.';
                break;
            case 'emptyfields':
                $error_message = 'Todos os campos são obrigatórios.';
                break;
            case 'passwordmismatch':
                $error_message = 'A nova senha e a confirmação não coincidem.';
                break;
            case 'shortpassword':
                $error_message = 'A nova senha deve ter pelo menos 6 caracteres.';
                break;
            case 'wrongpassword':
                $error_message = 'A senha atual está incorreta.';
                break;
            case 'updatefailed':
                $error_message = 'Erro ao atualizar. Tente novamente.';
                break;
        }
        if ($error_message) {
            echo '<div class="alert alert-error"><i class="fas ' . $icon . '"></i>' . htmlspecialchars($error_message) . '</div>';
        }
    }
    ?>
  </div>

    <main class="container page-padding profile-page-container">
      <h1 class="page-title">Minha Conta</h1>

      <div class="profile-grid">
        <!-- Card principal do usuário - à esquerda -->
        <div class="profile-main-card">
          <div class="profile-avatar"><?= $inicial_usuario ?></div>
          <h2 id="profile-name"><?= $nome_usuario ?></h2>
          <p id="profile-email"><?= $email_usuario ?></p>
          <a href="php/logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </div>

        <!-- Seções do lado direito -->
        <div class="profile-sections">
          <!-- Formulário de Edição de Nome -->
          <div class="profile-section">
            <h2><i class="fas fa-user"></i> Editar Nome</h2>
            <form method="POST" action="php/update_name.php" class="profile-form">
              <div class="input-group">
                <label for="nome">Nome Completo</label>
                <input 
                  type="text" 
                  id="nome" 
                  name="nome" 
                  value="<?= $nome_usuario ?>" 
                  required 
                  minlength="3"
                  placeholder="Digite seu nome completo"
                />
              </div>
              <button type="submit" class="btn"><i class="fas fa-save"></i> Salvar Nome</button>
            </form>
          </div>

          <!-- Formulário de Alteração de Senha -->
          <div class="profile-section">
            <h2><i class="fas fa-lock"></i> Alterar Senha</h2>
            <form method="POST" action="php/update_password.php" class="profile-form">
              <div class="input-group">
                <label for="senha_atual">Senha Atual</label>
                <input 
                  type="password" 
                  id="senha_atual" 
                  name="senha_atual" 
                  required 
                  placeholder="Digite sua senha atual"
                />
              </div>
              <div class="input-group">
                <label for="nova_senha">Nova Senha</label>
                <input 
                  type="password" 
                  id="nova_senha" 
                  name="nova_senha" 
                  required 
                  minlength="6"
                  placeholder="Digite a nova senha (mínimo 6 caracteres)"
                />
              </div>
              <div class="input-group">
                <label for="confirmar_senha">Confirmar Nova Senha</label>
                <input 
                  type="password" 
                  id="confirmar_senha" 
                  name="confirmar_senha" 
                  required 
                  minlength="6"
                  placeholder="Digite a nova senha novamente"
                />
              </div>
              <button type="submit" class="btn"><i class="fas fa-key"></i> Alterar Senha</button>
            </form>
          </div>

          <!-- Outras Opções da Conta - largura total -->
          <div class="profile-section full-width">
            <h2><i class="fas fa-cog"></i> Outras Opções</h2>
            <div class="profile-options">
              <div class="option-item">
                <i class="fas fa-box"></i>
                <span>Meus Pedidos</span>
                <i class="fas fa-chevron-right"></i>
              </div>
              <div class="option-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Meus Endereços</span>
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
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

    <!-- Modal de Cadastro -->
    <div id="registerModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="login-box-modal">
          <div class="login-header-text">
            <h2>Crie sua conta</h2>
            <p>É rápido e fácil!</p>
          </div>
          <form id="registerForm" method="POST" action="php/register.php">
            <div class="input-group">
              <label for="register-name">Nome</label>
              <input type="text" id="register-name" name="name" placeholder="Seu nome completo" required />
            </div>
            <div class="input-group">
              <label for="register-email">Email</label>
              <input type="email" id="register-email" name="email" placeholder="seuemail@exemplo.com" required />
            </div>
            <div class="input-group">
              <label for="register-password">Senha</label>
              <input type="password" id="register-password" name="password" placeholder="Crie uma senha forte" required />
            </div>
            <div class="input-group">
              <label for="confirm-password">Confirmar Senha</label>
              <input type="password" id="confirm-password" name="confirm_password" placeholder="Digite a senha novamente" required />
            </div>
            <button type="submit" class="btn">Cadastrar</button>
            <div class="login-footer">
              <p>Já tem uma conta? <a href="#" id="switchToLogin">Faça login</a></p>
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

    <script src="script.js"></script>
    <script src="navbar.js"></script>
    <script src="search.js"></script>
</body>
</html>
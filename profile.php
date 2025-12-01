<?php
// 1. INICIA A SESSÃO
// Deve ser a primeira linha do arquivo, antes de qualquer HTML.
session_start();

// 2. VERIFICAÇÃO DE SEGURANÇA (GUARDA DE ROTA)
// Se a variável de sessão 'usuario_id' não existir, significa que o usuário não está logado.
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona o usuário para a página inicial com uma mensagem de erro.
    header("Location: index.php?error=notloggedin");
    // Garante que o restante do script não seja executado após o redirecionamento.
    exit();
}

// 3. RECUPERA OS DADOS DA SESSÃO PARA EXIBIÇÃO
// Usamos htmlspecialchars() como uma medida de segurança para prevenir ataques XSS
// caso os nomes/emails contenham caracteres maliciosos.
$nome_usuario = htmlspecialchars($_SESSION['usuario_nome']);
$email_usuario = htmlspecialchars($_SESSION['usuario_email']);
$inicial_usuario = mb_strtoupper(mb_substr($nome_usuario, 0, 1)); // Pega a primeira letra do nome

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Minha Conta - Edenshop</title>
    <link rel="stylesheet" href="style.css" />

    <link rel="stylesheet" href="critical-fixes.css" />
    <link rel="stylesheet" href="search-dropdown.css" />
    
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
</head>
<body>
  <?php include 'php/header.php'; ?>

    <main class="container page-padding">
      <h1 class="page-title">Minha Conta</h1>

      <!-- Card de Informações do Usuário COM DADOS DO PHP -->
      <div class="profile-card">
        <!-- O PHP preenche a inicial, o nome e o email -->
        <div id="profile-avatar" class="profile-avatar"><?= $inicial_usuario ?></div>
        <h2 id="profile-name"><?= $nome_usuario ?></h2>
        <p id="profile-email"><?= $email_usuario ?></p>
        
        <!-- O botão de logout agora é um link direto para o script de logout -->
        <a href="php/logout.php" class="btn btn-danger">Sair (Logout)</a>
      </div>

      <div class="profile-layout">
        <?php
        // Exibir mensagens de sucesso
        if (isset($_GET['success'])) {
            $success_message = '';
            switch ($_GET['success']) {
                case 'nameupdated':
                    $success_message = 'Nome atualizado com sucesso!';
                    break;
                case 'passwordupdated':
                    $success_message = 'Senha alterada com sucesso!';
                    break;
            }
            if ($success_message) {
                echo '<div class="alert alert-success">' . htmlspecialchars($success_message) . '</div>';
            }
        }
        
        // Exibir mensagens de erro
        if (isset($_GET['error'])) {
            $error_message = '';
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
                echo '<div class="alert alert-error">' . htmlspecialchars($error_message) . '</div>';
            }
        }
        ?>
        
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
            <button type="submit" class="btn">Salvar Nome</button>
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
            <button type="submit" class="btn">Alterar Senha</button>
          </form>
        </div>

        <!-- Outras Opções da Conta -->
        <div class="profile-section">
          <h2>Outras Opções</h2>
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
    <script src="search.js"></script>
</body>
</html>
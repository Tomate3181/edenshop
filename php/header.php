<?php
// Inicia a sessão aqui para que esteja disponível em todas as páginas
session_start();
?>
<header>
    <nav class="navbar">
      <div class="logo">
        <a href="index.php"> <!-- Alterado para .php -->
          <img src="./assets/logo2.png" alt="Edenshop Logo" />
        </a>
      </div>

      <ul class="nav-links">
        <li><a href="index.php">Home</a></li> <!-- Alterado para .php -->
        <li><a href="products.php">Produtos</a></li> <!-- Alterado para .php -->
        <li><a href="about.php">Sobre Nós</a></li> <!-- Alterado para .php -->
        <li><a href="contact.php">Contato</a></li> <!-- Alterado para .php -->
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

        <!-- ======================================================= -->
        <!-- ====== AQUI COMEÇA A LÓGICA DE LOGIN/DROPDOWN ========= -->
        <!-- ======================================================= -->
        <div class="user-menu-container">
        <?php if (isset($_SESSION['usuario_id'])): 
            // Usamos htmlspecialchars para segurança ao exibir dados do usuário
            $nome_usuario_logado = htmlspecialchars($_SESSION['usuario_nome']);
        ?>
            <!-- SE O USUÁRIO ESTIVER LOGADO: Mostra o ícone que ativa o dropdown -->
            <a href="#" id="user-menu-button" aria-label="Menu do usuário">
                <i class="fas fa-user"></i>
            </a>

            <!-- NOVO DROPDOWN COM ESTILO GITHUB -->
            <div id="user-dropdown" class="dropdown-menu dropdown-github-style">
                <div class="dropdown-header">
                    <p>Logado como</p>
                    <strong><?= $nome_usuario_logado ?></strong>
                </div>
                <hr class="dropdown-divider">
                <a href="profile.php" class="dropdown-item">
                    <i class="fas fa-user-circle"></i>
                    <span>Minha Conta</span>
                </a>
                <hr class="dropdown-divider">
                <a href="php/logout.php" class="dropdown-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </div>

        <?php else: ?>
            <!-- SE NÃO ESTIVER LOGADO: Mostra o ícone que abre o modal de login -->
            <a href="#" id="user-action-icon" aria-label="Login ou Cadastro">
                <i class="fas fa-user"></i>
            </a>
        <?php endif; ?>
        </div>
        <!-- ======================================================= -->
        <!-- ============ FIM DA LÓGICA DE LOGIN/DROPDOWN ============ -->
        <!-- ======================================================= -->
      </div>
    </nav>
</header>
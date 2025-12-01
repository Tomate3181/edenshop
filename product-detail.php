<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
  // Incluir script de produtos
  require_once 'php/get_products.php';

  // Verificar se o ID foi fornecido na URL
  if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirecionar para a página de produtos se não houver ID
    header("Location: products.php");
    exit();
  }

  // Capturar e validar o ID do produto
  $produto_id = (int) $_GET['id'];

  // Buscar dados do produto
  $produto = getProductById($produto_id);

  // Verificar se o produto existe
  if (!$produto) {
    // Redirecionar para a página de produtos se o produto não existir
    header("Location: products.php?error=productnotfound");
    exit();
  }

  // Preparar dados do produto
  $nome = htmlspecialchars($produto['nome_planta']);
  $preco_formatado = number_format($produto['preco'], 2, ',', '.');
  $descricao = htmlspecialchars($produto['descricao']);
  $imagem = htmlspecialchars($produto['imagem_url']);
  $categoria = htmlspecialchars($produto['nome_categoria'] ?? 'Sem categoria');

  // Dados de especificações
  $nome_cientifico = htmlspecialchars($produto['nomeCientifico'] ?? 'Não disponível');
  $familia = htmlspecialchars($produto['familia'] ?? 'Não disponível');
  $origem = htmlspecialchars($produto['origem'] ?? 'Não disponível');
  $altura_media = htmlspecialchars($produto['alturaMedia'] ?? 'Não disponível');
  $pet_friendly = htmlspecialchars($produto['pet'] ?? 'Não disponível');

  // Dados de cuidados
  $luz = htmlspecialchars($produto['luz'] ?? 'Informação não disponível');
  $agua = htmlspecialchars($produto['agua'] ?? 'Informação não disponível');
  $humidade = htmlspecialchars($produto['humidade'] ?? 'Informação não disponível');
  $solo = htmlspecialchars($produto['solo'] ?? 'Informação não disponível');
  ?>
  <title><?= $nome ?> - Edenshop</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="products-enhancements.css" />
  <link rel="stylesheet" href="critical-fixes.css" />
  <link rel="stylesheet" href="search-dropdown.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php include 'php/header.php'; ?>

  <main class="container page-padding">
    <div class="product-detail-layout">
      <!-- Galeria de Imagens do Produto -->
      <div class="product-image-gallery">
        <img src="<?= $imagem ?>" alt="<?= $nome ?> - Vista Principal" id="mainProductImage" class="main-image"
          onerror="this.src='https://via.placeholder.com/600x600?text=Sem+Imagem'" />
      </div>

      <!-- Informações do Produto -->
      <div class="product-info" data-id="p<?= $produto_id ?>" data-name="<?= $nome ?>"
        data-price="<?= $produto['preco'] ?>" data-image="<?= $imagem ?>" data-category="<?= $categoria ?>">
        <h1><?= $nome ?></h1>
        <p class="product-price">R$ <?= $preco_formatado ?></p>
        <p class="short-description">
          <?= $descricao ?>
        </p>

        <div class="quantity-selector">
          <label for="quantity">Quantidade:</label>
          <div class="quantity-wrapper-styled">
            <button type="button" class="quantity-btn" id="decreaseQuantity" aria-label="Decrease quantity">-</button>
            <span class="quantity-display" id="quantityDisplay">1</span>
            <input type="hidden" id="quantity" value="1" min="1" max="<?= $produto['quantidade_estoque'] ?>" />
            <button type="button" class="quantity-btn" id="increaseQuantity" aria-label="Increase quantity">+</button>
          </div>
          <p class="stock-info">Estoque: <?= $produto['quantidade_estoque'] ?> unidades</p>
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
          <?= nl2br($descricao) ?>
        </p>
      </div>
      <div id="care" class="tab-content">
        <ul>
          <li>
            <strong>Luz:</strong> <?= $luz ?>
          </li>
          <li>
            <strong>Água:</strong> <?= $agua ?>
          </li>
          <li>
            <strong>Umidade:</strong> <?= $humidade ?>
          </li>
          <li>
            <strong>Solo:</strong> <?= $solo ?>
          </li>
        </ul>
      </div>
      <div id="specs" class="tab-content">
        <ul>
          <li>
            <strong>Nome Científico:</strong> <em><?= $nome_cientifico ?></em>
          </li>
          <li><strong>Família:</strong> <?= $familia ?></li>
          <li>
            <strong>Origem:</strong> <?= $origem ?>
          </li>
          <li><strong>Altura Média:</strong> <?= $altura_media ?></li>
          <li>
            <strong>Pet-Friendly:</strong> <?= $pet_friendly ?>
          </li>
        </ul>
      </div>
    </div>

    <!-- Produtos Relacionados -->
    <section class="related-products">
      <h2 class="section-title">Você também pode gostar</h2>
      <div class="products-grid">
        <?php
        // Incluir script de produtos relacionados
        require_once 'php/get_related_products.php';

        // Buscar produtos relacionados (máximo 3)
        $produtos_relacionados = getRelatedProducts($produto_id, $produto['id_categoria'], 3);

        // Verificar se há produtos relacionados
        if (!empty($produtos_relacionados)) {
          foreach ($produtos_relacionados as $produto_rel) {
            // Formatar o preço
            $preco_rel_formatado = number_format($produto_rel['preco'], 2, ',', '.');

            // Escapar dados para segurança
            $id_rel = htmlspecialchars($produto_rel['id_planta']);
            $nome_rel = htmlspecialchars($produto_rel['nome_planta']);
            $imagem_rel = htmlspecialchars($produto_rel['imagem_url']);
            $preco_rel = htmlspecialchars($preco_rel_formatado);
            $categoria_rel = htmlspecialchars($produto_rel['nome_categoria'] ?? '');

            // Renderizar card do produto relacionado
            echo <<<HTML
          <div
            class="product-card"
            data-id="p{$id_rel}"
            data-name="{$nome_rel}"
            data-price="{$produto_rel['preco']}"
            data-image="{$imagem_rel}"
            data-category="{$categoria_rel}"
          >
            <a href="product-detail.php?id={$id_rel}" class="product-link">
              <img
                src="{$imagem_rel}"
                alt="{$nome_rel}"
                onerror="this.src='https://via.placeholder.com/300x300?text=Sem+Imagem'"
              />
              <div class="product-card-content">
                <h3>{$nome_rel}</h3>
                <p class="price">R$ {$preco_rel}</p>
              </div>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
          </div>
HTML;
          }
        } else {
          echo '<p class="no-products">Nenhum produto relacionado encontrado.</p>';
        }
        ?>
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
        <form id="loginForm">
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
  <script src="product-quantity.js"></script>
  <script src="checkout-auth.js"></script>
</body>

</html>
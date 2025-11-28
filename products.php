<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nossos Produtos - Edenshop</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>

  <body>
    <?php 
    // Incluir header e scripts de produtos
    include 'php/header.php'; 
    require_once 'php/get_products.php';
    
    // Verificar se há filtro de categoria
    $categoria_filtro = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;
    
    // Buscar categorias e produtos
    $categorias = getAllCategories();
    $produtos = getAllProducts($categoria_filtro);
    ?>

    <main class="container page-padding">
      <h1 class="page-title">Nossas Plantas</h1>
      <div class="shop-layout">
        <!-- Barra Lateral de Filtros -->
        <aside class="filters-sidebar">
          <h3>Filtros</h3>
          <div class="filter-group">
            <h4>Categorias</h4>
            <ul class="filter-list">
              <li>
                <label>
                  <input type="radio" name="category" value="" <?= $categoria_filtro === null ? 'checked' : '' ?> 
                         onclick="window.location.href='products.php'"/> 
                  Todas as Categorias
                </label>
              </li>
              <?php
              // Renderizar categorias dinamicamente
              foreach ($categorias as $categoria) {
                  $id = htmlspecialchars($categoria['id_categoria']);
                  $nome = htmlspecialchars($categoria['nome_categoria']);
                  $checked = ($categoria_filtro == $id) ? 'checked' : '';
                  
                  echo <<<HTML
              <li>
                <label>
                  <input type="radio" name="category" value="{$id}" {$checked}
                         onclick="window.location.href='products.php?categoria={$id}'"/> 
                  {$nome}
                </label>
              </li>
HTML;
              }
              ?>
            </ul>
          </div>
        </aside>

        <!-- Grade de Produtos -->
        <section class="products-grid-full">
          <?php
          // Verificar se há produtos
          if (!empty($produtos)) {
              foreach ($produtos as $produto) {
                  // Formatar o preço
                  $preco_formatado = number_format($produto['preco'], 2, ',', '.');
                  
                  // Escapar dados para segurança
                  $id = htmlspecialchars($produto['id_planta']);
                  $nome = htmlspecialchars($produto['nome_planta']);
                  $imagem = htmlspecialchars($produto['imagem_url']);
                  $preco = htmlspecialchars($preco_formatado);
                  $categoria = htmlspecialchars($produto['nome_categoria'] ?? '');
                  
                  // Renderizar card do produto
                  echo <<<HTML
          <!-- Produto {$id} -->
          <div
            class="product-card"
            data-id="p{$id}"
            data-name="{$nome}"
            data-price="{$produto['preco']}"
            data-image="{$imagem}"
            data-category="{$categoria}"
          >
            <a href="product-detail.php?id={$id}" class="product-link">
              <img
                src="{$imagem}"
                alt="{$nome}"
                onerror="this.src='https://via.placeholder.com/300x300?text=Sem+Imagem'"
              />
              <div class="product-card-content">
                <h3>{$nome}</h3>
                <p class="price">R$ {$preco}</p>
              </div>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
          </div>
HTML;
              }
          } else {
              // Mensagem caso não haja produtos
              echo '<p class="no-products">Nenhum produto encontrado nesta categoria.</p>';
          }
          ?>
        </section>
      </div>
    </main>
          <!-- Produto 1 -->
          <!-- Produto 1 -->
          <div
            class="product-card"
            data-id="p1"
            data-name="Jiboia (Epipremnum aureum)"
            data-price="49.90"
            data-image="https://www.shutterstock.com/image-photo/epipremnum-aureum-species-flowering-plant-600nw-2557759849.jpg"
            data-category="interna pendente"
            data-care="facil"
          >
            <a href="product-detail.html" class="product-link">
              <img
                src="https://www.shutterstock.com/image-photo/epipremnum-aureum-species-flowering-plant-600nw-2557759849.jpg"
                alt="Planta Jiboia"
              />
              <div class="product-card-content">
                <h3>Jiboia (Epipremnum aureum)</h3>
                <p class="price">R$ 49,90</p>
              </div>
            </a>
            <button class="btn add-to-cart-btn">Adicionar ao Carrinho</button>
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

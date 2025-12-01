<?php
// Proteção de rota - apenas admins podem acessar
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?error=notloggedin");
    exit();
}

// Verifica se o usuário é admin
if ($_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: index.php?error=accessdenied");
    exit();
}

// Inclui a conexão com o banco de dados
require_once 'php/db_connect.php';

// Buscar estatísticas do dashboard
try {
    // Total de vendas
    $stmt = $pdo->query("SELECT COALESCE(SUM(valor_total), 0) as total_vendas FROM pedidos WHERE status_pedido = 'finalizado'");
    $total_vendas = $stmt->fetch(PDO::FETCH_ASSOC)['total_vendas'];

    // Total de pedidos
    $stmt = $pdo->query("SELECT COUNT(*) as total_pedidos FROM pedidos");
    $total_pedidos = $stmt->fetch(PDO::FETCH_ASSOC)['total_pedidos'];

    // Novos clientes (últimos 30 dias)
    $stmt = $pdo->query("SELECT COUNT(*) as novos_clientes FROM usuarios WHERE tipo = 'cliente' AND data_cadastro >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $novos_clientes = $stmt->fetch(PDO::FETCH_ASSOC)['novos_clientes'];

    // Vendas dos últimos 6 meses para o gráfico
    $stmt = $pdo->query("
        SELECT 
            DATE_FORMAT(data_pedido, '%Y-%m') as mes,
            SUM(valor_total) as total
        FROM pedidos 
        WHERE data_pedido >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
        AND status_pedido = 'finalizado'
        GROUP BY DATE_FORMAT(data_pedido, '%Y-%m')
        ORDER BY mes ASC
    ");
    $vendas_mensais = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Categorias mais vendidas
    $stmt = $pdo->query("
        SELECT 
            c.nome_categoria,
            COUNT(ip.id_item_pedido) as total_vendas
        FROM item_pedido ip
        JOIN plantas p ON ip.id_planta = p.id_planta
        JOIN categorias c ON p.id_categoria = c.id_categoria
        JOIN pedidos ped ON ip.id_pedido = ped.id_pedido
        WHERE ped.status_pedido = 'finalizado'
        GROUP BY c.id_categoria
        ORDER BY total_vendas DESC
        LIMIT 5
    ");
    $categorias_vendidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Em caso de erro, define valores padrão
    $total_vendas = 0;
    $total_pedidos = 0;
    $novos_clientes = 0;
    $vendas_mensais = [];
    $categorias_vendidas = [];
}

$nome_admin = htmlspecialchars($_SESSION['usuario_nome']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edenshop - Painel Administrativo</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="index.php" class="logo-link">
                    <img src="./assets/logo2.png" alt="Edenshop Logo" class="sidebar-logo">
                    <h2>Admin</h2>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#dashboard" class="active" data-section="dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="#users" data-section="users"><i class="fas fa-users"></i> Usuários</a></li>
                    <li><a href="#products" data-section="products"><i class="fas fa-leaf"></i> Novo Produto</a></li>
                    <li><a href="php/logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header Mobile -->
            <header class="admin-header">
                <button id="sidebar-toggle" class="sidebar-toggle"><i class="fas fa-bars"></i></button>
                <div class="user-info">
                    <span>Olá, <strong><?= $nome_admin ?></strong></span>
                    <div class="avatar"><i class="fas fa-user-circle"></i></div>
                </div>
            </header>

            <!-- Section: Dashboard -->
            <section id="dashboard" class="admin-section active">
                <h1 class="page-title">Dashboard de Vendas</h1>
                
                <div class="stats-cards">
                    <div class="card stat-card">
                        <div class="stat-icon" style="background-color: rgba(107, 142, 35, 0.1); color: var(--primary-green);">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Vendas Totais</h3>
                            <p class="stat-number">R$ <?= number_format($total_vendas, 2, ',', '.') ?></p>
                            <span class="stat-trend positive"><i class="fas fa-arrow-up"></i> Dados reais</span>
                        </div>
                    </div>
                    <div class="card stat-card">
                        <div class="stat-icon" style="background-color: rgba(218, 165, 32, 0.1); color: var(--gold-accent);">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Pedidos</h3>
                            <p class="stat-number"><?= $total_pedidos ?></p>
                            <span class="stat-trend positive"><i class="fas fa-arrow-up"></i> Total</span>
                        </div>
                    </div>
                    <div class="card stat-card">
                        <div class="stat-icon" style="background-color: rgba(47, 79, 79, 0.1); color: var(--dark-text);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Novos Clientes</h3>
                            <p class="stat-number"><?= $novos_clientes ?></p>
                            <span class="stat-trend"><i class="fas fa-calendar"></i> Últimos 30 dias</span>
                        </div>
                    </div>
                </div>

                <div class="charts-grid">
                    <div class="card chart-container">
                        <h3>Vendas nos Últimos 6 Meses</h3>
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="card chart-container">
                        <h3>Categorias Mais Vendidas</h3>
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </section>

            <!-- Section: Users -->
            <section id="users" class="admin-section">
                <h1 class="page-title">Gerenciar Usuários</h1>
                <div class="card table-card">
                    <div class="table-header">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="user-search" placeholder="Buscar usuário...">
                        </div>
                        <button class="btn small-btn" id="add-user-btn"><i class="fas fa-plus"></i> Novo Usuário</button>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo</th>
                                    <th>Data Cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                <!-- Será preenchido via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Section: Add Product -->
            <section id="products" class="admin-section">
                <h1 class="page-title">Cadastrar Nova Planta</h1>
                <form class="product-form" id="addProductForm" method="POST" action="php/admin_add_product.php">
                    <div class="form-grid">
                        <!-- Informações Básicas -->
                        <div class="card form-section">
                            <h3><i class="fas fa-info-circle"></i> Informações Básicas</h3>
                            <div class="input-group">
                                <label for="plantName">Nome da Planta</label>
                                <input type="text" id="plantName" name="plantName" placeholder="Ex: Monstera Deliciosa" required>
                            </div>
                            <div class="row">
                                <div class="input-group half">
                                    <label for="plantCategory">Categoria</label>
                                    <select id="plantCategory" name="plantCategory" required>
                                        <option value="">Selecione...</option>
                                        <option value="1">Suculentas</option>
                                        <option value="2">Samambaias</option>
                                        <option value="3">Plantas de Sombra</option>
                                        <option value="4">Plantas de Sol Pleno</option>
                                        <option value="5">Plantas Pendentes</option>
                                        <option value="6">Frutíferas (Pequeno Porte)</option>
                                        <option value="7">Flores e Ornamentais</option>
                                    </select>
                                </div>
                                <div class="input-group half">
                                    <label for="plantPrice">Preço (R$)</label>
                                    <input type="number" id="plantPrice" name="plantPrice" step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group half">
                                    <label for="plantStock">Quantidade em Estoque</label>
                                    <input type="number" id="plantStock" name="plantStock" placeholder="0" required>
                                </div>
                                <div class="input-group half">
                                    <label for="plantImage">URL da Imagem</label>
                                    <input type="url" id="plantImage" name="plantImage" placeholder="img/..." required>
                                </div>
                            </div>
                            <div class="input-group">
                                <label for="plantDescription">Descrição</label>
                                <textarea id="plantDescription" name="plantDescription" rows="4" placeholder="Descreva a planta..." required></textarea>
                            </div>
                        </div>

                        <!-- Especificações Técnicas -->
                        <div class="card form-section">
                            <h3><i class="fas fa-list-ul"></i> Especificações</h3>
                            <div class="input-group">
                                <label for="scientificName">Nome Científico</label>
                                <input type="text" id="scientificName" name="scientificName" placeholder="Ex: Monstera deliciosa">
                            </div>
                            <div class="row">
                                <div class="input-group half">
                                    <label for="plantFamily">Família</label>
                                    <input type="text" id="plantFamily" name="plantFamily" placeholder="Ex: Araceae">
                                </div>
                                <div class="input-group half">
                                    <label for="plantOrigin">Origem</label>
                                    <input type="text" id="plantOrigin" name="plantOrigin" placeholder="Ex: México">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group half">
                                    <label for="plantHeight">Altura Média</label>
                                    <input type="text" id="plantHeight" name="plantHeight" placeholder="Ex: 1m - 3m">
                                </div>
                                <div class="input-group half">
                                    <label for="petFriendly">Pet Friendly?</label>
                                    <select id="petFriendly" name="petFriendly">
                                        <option value="Não tóxica">Sim</option>
                                        <option value="Tóxica">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Cuidados (Categorias) -->
                        <div class="card form-section full-width">
                            <h3><i class="fas fa-hand-holding-water"></i> Guia de Cuidados</h3>
                            <div class="care-grid">
                                <div class="input-group">
                                    <label for="careLight"><i class="fas fa-sun"></i> Luz</label>
                                    <input type="text" id="careLight" name="careLight" placeholder="Ex: Sol pleno ou luz brilhante">
                                </div>
                                <div class="input-group">
                                    <label for="careWater"><i class="fas fa-tint"></i> Água</label>
                                    <input type="text" id="careWater" name="careWater" placeholder="Ex: Rega moderada">
                                </div>
                                <div class="input-group">
                                    <label for="careHumidity"><i class="fas fa-cloud-rain"></i> Umidade</label>
                                    <input type="text" id="careHumidity" name="careHumidity" placeholder="Ex: Média">
                                </div>
                                <div class="input-group">
                                    <label for="careSoil"><i class="fas fa-seedling"></i> Solo</label>
                                    <input type="text" id="careSoil" name="careSoil" placeholder="Ex: Drenado, rico em matéria orgânica">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn secondary-btn">Cancelar</button>
                        <button type="submit" class="btn primary-btn">Cadastrar Planta</button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script>
        // Dados para os gráficos vindos do PHP
        const vendasMensais = <?= json_encode($vendas_mensais) ?>;
        const categoriasVendidas = <?= json_encode($categorias_vendidas) ?>;
    </script>
    <script src="admin.js"></script>
</body>
</html>

<?php
/**
 * API para busca de produtos em tempo real
 */

header('Content-Type: application/json');

// Incluir conexão com o banco de dados
require_once 'db_connect.php';

// Verificar se o termo de busca foi fornecido
if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    echo json_encode(['success' => false, 'products' => []]);
    exit;
}

$searchTerm = trim($_GET['q']);

try {
    // Preparar query com LIKE para busca parcial
    $stmt = $pdo->prepare("
        SELECT 
            p.id_planta,
            p.nome_planta,
            p.preco,
            p.imagem_url,
            c.nome_categoria
        FROM plantas p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        WHERE p.nome_planta LIKE :search
        AND p.quantidade_estoque > 0
        ORDER BY p.nome_planta ASC
        LIMIT 10
    ");
    
    // Bind do parâmetro com % para busca parcial
    $searchPattern = '%' . $searchTerm . '%';
    $stmt->bindValue(':search', $searchPattern, PDO::PARAM_STR);
    $stmt->execute();
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formatar os resultados
    $formattedProducts = array_map(function($product) {
        return [
            'id' => (int)$product['id_planta'],
            'name' => htmlspecialchars($product['nome_planta']),
            'price' => number_format($product['preco'], 2, ',', '.'),
            'image' => htmlspecialchars($product['imagem_url']),
            'category' => htmlspecialchars($product['nome_categoria'] ?? '')
        ];
    }, $products);
    
    echo json_encode([
        'success' => true,
        'products' => $formattedProducts,
        'count' => count($formattedProducts)
    ]);
    
} catch (PDOException $e) {
    error_log("Erro na busca de produtos: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => 'Erro ao buscar produtos',
        'products' => []
    ]);
}
?>

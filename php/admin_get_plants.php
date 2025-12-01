<?php
// Endpoint para buscar todas as plantas
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

try {
    // Busca todas as plantas com suas categorias usando prepared statement
    $stmt = $pdo->prepare("
        SELECT 
            p.id_planta,
            p.nome_planta,
            p.preco,
            p.quantidade_estoque,
            c.nome_categoria,
            p.imagem_url
        FROM plantas p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        ORDER BY p.id_planta DESC
    ");

    $stmt->execute();
    $plantas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($plantas);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar plantas']);
}
?>
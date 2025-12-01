<?php
// Endpoint para buscar dados de uma planta específica para edição
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

// Verifica se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID não fornecido']);
    exit();
}

$id_planta = (int) $_GET['id'];

try {
    // Busca dados completos da planta usando prepared statement
    $stmt = $pdo->prepare("
        SELECT 
            p.*,
            c.nome_categoria,
            e.nomeCientifico, e.familia, e.origem, e.alturaMedia, e.pet,
            cu.luz, cu.agua, cu.humidade, cu.solo
        FROM plantas p
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
        LEFT JOIN especificacoes e ON p.id_planta = e.id_planta
        LEFT JOIN cuidados cu ON p.id_planta = cu.id_planta
        WHERE p.id_planta = :id_planta
    ");

    $stmt->execute([':id_planta' => $id_planta]);
    $planta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$planta) {
        http_response_code(404);
        echo json_encode(['error' => 'Planta não encontrada']);
        exit();
    }

    echo json_encode($planta);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar planta']);
}
?>
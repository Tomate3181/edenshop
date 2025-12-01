<?php
session_start();

// Proteção: apenas admins podem acessar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

// Buscar todos os usuários
try {
    $stmt = $pdo->query("
        SELECT id, nome, email, tipo, ativo, DATE_FORMAT(data_cadastro, '%d/%m/%Y') as data_cadastro
        FROM usuarios
        ORDER BY data_cadastro DESC
    ");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($usuarios);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar usuários']);
}
?>
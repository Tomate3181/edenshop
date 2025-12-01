<?php
// Endpoint para alternar status (ativo/inativo) de uma planta
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

// Obtém o ID da planta do corpo da requisição (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$id_planta = isset($data['id']) ? (int) $data['id'] : 0;

if ($id_planta <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit();
}

try {
    // Verifica o status atual
    $stmt = $pdo->prepare("SELECT ativo FROM plantas WHERE id_planta = :id");
    $stmt->execute([':id' => $id_planta]);
    $planta = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$planta) {
        http_response_code(404);
        echo json_encode(['error' => 'Planta não encontrada']);
        exit();
    }

    // Alterna o status
    $novo_status = ($planta['ativo'] == 1) ? 0 : 1;
    $mensagem = ($novo_status == 1) ? 'Planta ativada com sucesso' : 'Planta inativada com sucesso';

    $stmt = $pdo->prepare("UPDATE plantas SET ativo = :status WHERE id_planta = :id");
    $stmt->execute([':status' => $novo_status, ':id' => $id_planta]);

    echo json_encode(['success' => true, 'message' => $mensagem, 'novo_status' => $novo_status]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao alterar status da planta: ' . $e->getMessage()]);
}
?>
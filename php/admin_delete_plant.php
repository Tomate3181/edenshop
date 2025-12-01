<?php
// Endpoint para deletar uma planta
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
    // Verifica se a planta existe
    $stmt = $pdo->prepare("SELECT id_planta FROM plantas WHERE id_planta = :id");
    $stmt->execute([':id' => $id_planta]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Planta não encontrada']);
        exit();
    }

    // Deleta a planta
    // Nota: Se houver restrições de chave estrangeira (como em item_pedido), 
    // isso pode falhar se não houver CASCADE ou se a planta já foi comprada.
    // O ideal seria marcar como inativo, mas o pedido foi "deletar".
    // Vou tentar deletar, e se falhar, retorno o erro.

    $stmt = $pdo->prepare("DELETE FROM plantas WHERE id_planta = :id");
    $stmt->execute([':id' => $id_planta]);

    echo json_encode(['success' => true, 'message' => 'Planta removida com sucesso']);

} catch (PDOException $e) {
    // Verifica erro de integridade referencial (código 23000 geralmente)
    if ($e->getCode() == '23000') {
        http_response_code(400);
        echo json_encode(['error' => 'Não é possível excluir esta planta pois ela está vinculada a pedidos existentes.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao deletar planta: ' . $e->getMessage()]);
    }
}
?>
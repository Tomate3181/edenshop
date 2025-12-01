<?php
// Endpoint para alternar status (ativo/inativo) de um usuário
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

// Obtém o ID do usuário do corpo da requisição (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$id_usuario = isset($data['id']) ? (int) $data['id'] : 0;

if ($id_usuario <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit();
}

// Impede que o admin delete a si mesmo
if ($id_usuario == $_SESSION['usuario_id']) {
    http_response_code(400);
    echo json_encode(['error' => 'Você não pode inativar sua própria conta.']);
    exit();
}

try {
    // Verifica o status atual
    $stmt = $pdo->prepare("SELECT ativo FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        http_response_code(404);
        echo json_encode(['error' => 'Usuário não encontrado']);
        exit();
    }

    // Alterna o status
    $novo_status = ($usuario['ativo'] == 1) ? 0 : 1;
    $mensagem = ($novo_status == 1) ? 'Usuário ativado com sucesso' : 'Usuário inativado com sucesso';

    $stmt = $pdo->prepare("UPDATE usuarios SET ativo = :status WHERE id = :id");
    $stmt->execute([':status' => $novo_status, ':id' => $id_usuario]);

    echo json_encode(['success' => true, 'message' => $mensagem, 'novo_status' => $novo_status]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao alterar status do usuário: ' . $e->getMessage()]);
}
?>
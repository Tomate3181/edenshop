<?php
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

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['nome']) || !isset($data['email']) || !isset($data['tipo'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados incompletos']);
    exit();
}

$id = (int) $data['id'];
$nome = trim($data['nome']);
$email = trim($data['email']);
$tipo = $data['tipo'];

// Validação básica
if (empty($nome) || empty($email)) {
    echo json_encode(['error' => 'Nome e email são obrigatórios']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Email inválido']);
    exit();
}

if ($tipo !== 'admin' && $tipo !== 'cliente') {
    echo json_encode(['error' => 'Tipo de usuário inválido']);
    exit();
}

try {
    // Verifica se o email já está em uso por outro usuário
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
    $stmt->execute([':email' => $email, ':id' => $id]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => 'Este email já está em uso por outro usuário']);
        exit();
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id");
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':tipo' => $tipo,
        ':id' => $id
    ]);

    echo json_encode(['success' => true, 'message' => 'Usuário atualizado com sucesso']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao atualizar usuário: ' . $e->getMessage()]);
}
?>
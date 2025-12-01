<?php
session_start();

// Proteção: apenas admins podem acessar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    
    // Validação
    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        http_response_code(400);
        echo json_encode(['error' => 'Todos os campos são obrigatórios']);
        exit();
    }
    
    if (!in_array($tipo, ['cliente', 'admin'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Tipo de usuário inválido']);
        exit();
    }
    
    // Verifica se o email já existe
    try {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        
        if ($stmt->fetch()) {
            http_response_code(400);
            echo json_encode(['error' => 'Email já cadastrado']);
            exit();
        }
        
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        // Insere o novo usuário
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, senha_hash, tipo)
            VALUES (:nome, :email, :senha_hash, :tipo)
        ");
        
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => $senha_hash,
            ':tipo' => $tipo
        ]);
        
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Usuário criado com sucesso']);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao criar usuário']);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}
?>

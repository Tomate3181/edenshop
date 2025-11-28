<?php
// Script para alterar a senha do usuário
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php?error=notloggedin");
    exit();
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../profile.php?error=invalidrequest");
    exit();
}

// Incluir conexão com o banco de dados
require_once 'db_connect.php';

// Capturar os dados do formulário
$senha_atual = $_POST['senha_atual'] ?? '';
$nova_senha = $_POST['nova_senha'] ?? '';
$confirmar_senha = $_POST['confirmar_senha'] ?? '';

// Validação 1: Verificar se todos os campos foram preenchidos
if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
    header("Location: ../profile.php?error=emptyfields");
    exit();
}

// Validação 2: Verificar se a nova senha e a confirmação são iguais
if ($nova_senha !== $confirmar_senha) {
    header("Location: ../profile.php?error=passwordmismatch");
    exit();
}

// Validação 3: Verificar se a nova senha tem pelo menos 6 caracteres
if (strlen($nova_senha) < 6) {
    header("Location: ../profile.php?error=shortpassword");
    exit();
}

try {
    // Buscar a senha atual do usuário no banco de dados
    $stmt = $pdo->prepare("SELECT senha_hash FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        header("Location: ../profile.php?error=usernotfound");
        exit();
    }
    
    // Validação 4: Verificar se a senha atual está correta
    if (!password_verify($senha_atual, $usuario['senha_hash'])) {
        header("Location: ../profile.php?error=wrongpassword");
        exit();
    }
    
    // Gerar hash da nova senha
    $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    
    // Atualizar a senha no banco de dados
    $stmt = $pdo->prepare("UPDATE usuarios SET senha_hash = :senha_hash WHERE id = :id");
    $stmt->execute([
        ':senha_hash' => $nova_senha_hash,
        ':id' => $_SESSION['usuario_id']
    ]);
    
    // Redirecionar com mensagem de sucesso
    header("Location: ../profile.php?success=passwordupdated");
    exit();
    
} catch (PDOException $e) {
    // Em caso de erro, redirecionar com mensagem de erro
    error_log("Erro ao atualizar senha: " . $e->getMessage());
    header("Location: ../profile.php?error=updatefailed");
    exit();
}
?>

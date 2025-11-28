<?php
// Script para atualizar o nome do usuário
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

// Capturar e validar o novo nome
$novo_nome = trim($_POST['nome'] ?? '');

// Validação: nome não pode ser vazio
if (empty($novo_nome)) {
    header("Location: ../profile.php?error=emptyname");
    exit();
}

// Validação: nome deve ter pelo menos 3 caracteres
if (strlen($novo_nome) < 3) {
    header("Location: ../profile.php?error=shortname");
    exit();
}

try {
    // Preparar a query de atualização
    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome WHERE id = :id");
    
    // Executar a query
    $stmt->execute([
        ':nome' => $novo_nome,
        ':id' => $_SESSION['usuario_id']
    ]);
    
    // Atualizar a sessão com o novo nome
    $_SESSION['usuario_nome'] = $novo_nome;
    
    // Redirecionar com mensagem de sucesso
    header("Location: ../profile.php?success=nameupdated");
    exit();
    
} catch (PDOException $e) {
    // Em caso de erro, redirecionar com mensagem de erro
    error_log("Erro ao atualizar nome: " . $e->getMessage());
    header("Location: ../profile.php?error=updatefailed");
    exit();
}
?>

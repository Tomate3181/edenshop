<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $confirm_senha = $_POST['confirm_password'];

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha) || empty($confirm_senha)) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
        exit;
    }

    if ($senha !== $confirm_senha) {
        echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
        exit;
    }

    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Este email já está cadastrado.'); window.history.back();</script>";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco
    try {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, tipo, data_cadastro) VALUES (:nome, :email, :senha_hash, 'cliente', NOW())";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha_hash', $senha_hash);
        
        $stmt->execute();

        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '../index.php';</script>";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

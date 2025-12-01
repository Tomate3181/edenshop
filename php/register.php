<?php
require_once 'db_connect.php';

function showAlert($title, $text, $icon, $redirect = null)
{
    $script_action = $redirect ? "window.location.href = '$redirect';" : "window.history.back();";
    echo "
    <!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Aviso</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            body { 
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                background-color: #f0f2f5; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
                margin: 0; 
            }
        </style>
    </head>
    <body>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '$title',
                    text: '$text',
                    icon: '$icon',
                    confirmButtonColor: '#2e8b57',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $script_action
                });
            });
        </script>
    </body>
    </html>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';
    $confirm_senha = $_POST['confirm_password'] ?? '';

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha) || empty($confirm_senha)) {
        showAlert('Atenção', 'Por favor, preencha todos os campos.', 'warning');
    }

    if ($senha !== $confirm_senha) {
        showAlert('Erro', 'As senhas não coincidem.', 'error');
    }

    // Verificar se o email já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        showAlert('Erro', 'Este email já está cadastrado.', 'error');
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

        showAlert('Sucesso!', 'Cadastro realizado com sucesso!', 'success', '../index.php');
    } catch (PDOException $e) {
        showAlert('Erro no Sistema', 'Erro ao cadastrar: ' . $e->getMessage(), 'error');
    }
}
?>
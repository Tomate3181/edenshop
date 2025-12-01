<?php
// 1. Inicia a sessão
session_start();

// 2. Inclui o arquivo de conexão com o banco de dados
require_once 'db_connect.php';

// 3. Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Pega os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // 5. Validação básica dos campos
    if (empty($email) || empty($senha)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    }

    // 6. Prepara a consulta para evitar SQL Injection
    // IMPORTANTE: Agora também buscamos o campo 'tipo' para verificar se é admin ou cliente
    // E também o campo 'ativo'
    $sql = "SELECT id, nome, email, senha_hash, tipo, ativo FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // 7. Associa o valor do email ao placeholder
    $stmt->bindValue(':email', $email);

    // 8. Executa a consulta
    $stmt->execute();

    // 9. Busca o usuário no banco de dados
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 10. Verifica se o usuário existe E se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {

        // Verifica se a conta está ativa
        if (isset($usuario['ativo']) && $usuario['ativo'] == 0) {
            header("Location: ../index.php?error=accountinactive");
            exit();
        }

        // Sucesso no Login!

        // 11. Regenera o ID da sessão para prevenir ataques de Session Fixation
        session_regenerate_id(true);

        // 12. Armazena os dados do usuário na sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_tipo'] = $usuario['tipo']; // Armazena o tipo do usuário

        // 13. Redireciona o usuário baseado no tipo
        // Se for admin, vai para o painel administrativo
        // Se for cliente, vai para a página inicial
        if ($usuario['tipo'] === 'admin') {
            header("Location: ../admin.php");
        } else {
            header("Location: ../index.php");
        }
        exit();

    } else {
        // Falha no Login!
        header("Location: ../index.php?error=wrongcredentials");
        exit();
    }

} else {
    // Se não for um POST, redireciona para a página inicial
    header("Location: ../index.php");
    exit();
}
?>
<?php
// 1. Inicia a sessão
// Deve ser a primeira coisa no seu script para gerenciar o estado de login do usuário.
session_start();

// 2. Inclui o arquivo de conexão com o banco de dados.
require_once 'db_connect.php';

// 3. Verifica se a requisição é do tipo POST
// Isso impede que o script seja acessado diretamente pela URL.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Pega os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // 5. Validação básica dos campos
    if (empty($email) || empty($senha)) {
        // Se algum campo estiver vazio, redireciona de volta com uma mensagem de erro.
        // Usar parâmetros na URL é uma forma simples de passar status para o front-end.
        header("Location: ../index.html?error=emptyfields");
        exit();
    }

    // 6. Prepara a consulta para evitar SQL Injection
    // Usar prepared statements é a regra de ouro para segurança de banco de dados.
    // O PDO substitui os placeholders (?) por valores de forma segura.
    $sql = "SELECT id, nome, email, senha_hash FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    
    // 7. Associa o valor do email ao placeholder
    $stmt->bindValue(':email', $email);
    
    // 8. Executa a consulta
    $stmt->execute();

    // 9. Busca o usuário no banco de dados
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 10. Verifica se o usuário existe E se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
        // A função password_verify() compara a senha digitada com o hash salvo no banco.
        // Esta é a maneira segura e correta de verificar senhas. NUNCA compare senhas em texto plano.

        // Sucesso no Login!

        // 11. Regenera o ID da sessão para prevenir ataques de Session Fixation
        session_regenerate_id(true);

        // 12. Armazena os dados do usuário na sessão
        // Agora, em qualquer página do site, podemos verificar $_SESSION['usuario_id'] para saber se o usuário está logado.
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        // 13. Redireciona o usuário para a página de perfil
        header("Location: ../profile.html");
        exit(); // Garante que nenhum código a mais seja executado após o redirecionamento.

    } else {
        // Falha no Login!
        // Redireciona de volta para a página inicial com uma mensagem de erro genérica.
        // É uma boa prática de segurança não informar se foi o email ou a senha que errou.
        header("Location: ../index.html?error=wrongcredentials");
        exit();
    }

} else {
    // Se não for um POST, redireciona para a página inicial.
    header("Location: ../index.html");
    exit();
}
?>
<?php
// Inicia a sessão para poder acessá-la.
session_start();

// 1. Limpa todas as variáveis da sessão.
$_SESSION = array();

// 2. Destrói a sessão do lado do servidor.
session_destroy();

// 3. Redireciona o usuário para a página inicial.
// O parâmetro 'status=loggedout' pode ser usado no futuro para mostrar uma mensagem de "Você saiu com sucesso!".
header("Location: ../index.php?status=loggedout");
exit();
?>
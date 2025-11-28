<?php
$host = 'localhost';
$dbname = 'bd_eden';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Habilitar emulação de prepared statements como false para maior segurança (usa prepared statements reais)
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    // Em produção, não exiba detalhes do erro para o usuário
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>

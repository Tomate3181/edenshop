<?php
require_once 'db_connect.php';

try {
    // Verifica se a coluna 'ativo' já existe na tabela usuarios
    $stmt = $pdo->query("SHOW COLUMNS FROM usuarios LIKE 'ativo'");
    $exists = $stmt->fetch();

    if (!$exists) {
        // Adiciona a coluna 'ativo'
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN ativo TINYINT(1) DEFAULT 1");
        echo "Coluna 'ativo' adicionada com sucesso na tabela usuarios.\n";
    } else {
        echo "Coluna 'ativo' já existe na tabela usuarios.\n";
    }

} catch (PDOException $e) {
    echo "Erro ao adicionar coluna: " . $e->getMessage() . "\n";
}
?>
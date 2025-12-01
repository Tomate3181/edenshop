<?php
require_once 'db_connect.php';

try {
    // Verifica se a coluna 'ativo' já existe
    $stmt = $pdo->query("SHOW COLUMNS FROM plantas LIKE 'ativo'");
    $exists = $stmt->fetch();

    if (!$exists) {
        // Adiciona a coluna 'ativo'
        $pdo->exec("ALTER TABLE plantas ADD COLUMN ativo TINYINT(1) DEFAULT 1");
        echo "Coluna 'ativo' adicionada com sucesso.\n";
    } else {
        echo "Coluna 'ativo' já existe.\n";
    }

    // Opcional: Atualizar registros existentes para ativo=1 se estiverem NULL (embora o DEFAULT cuide de novos, existentes podem precisar)
    // Na verdade, ao adicionar com DEFAULT 1, os registros existentes ganham o valor 1 automaticamente no MySQL.

} catch (PDOException $e) {
    echo "Erro ao adicionar coluna: " . $e->getMessage() . "\n";
}
?>
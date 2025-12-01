<?php
session_start();

// Proteção: apenas admins podem acessar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header("Location: ../index.php?error=accessdenied");
    exit();
}

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação dos dados
    $nome = trim($_POST['plantName']);
    $categoria = intval($_POST['plantCategory']);
    $preco = floatval($_POST['plantPrice']);
    $estoque = intval($_POST['plantStock']);
    $imagem = trim($_POST['plantImage']);
    $descricao = trim($_POST['plantDescription']);
    
    // Especificações
    $nomeCientifico = trim($_POST['scientificName'] ?? '');
    $familia = trim($_POST['plantFamily'] ?? '');
    $origem = trim($_POST['plantOrigin'] ?? '');
    $altura = trim($_POST['plantHeight'] ?? '');
    $petFriendly = trim($_POST['petFriendly'] ?? 'Não tóxica');
    
    // Cuidados
    $luz = trim($_POST['careLight'] ?? '');
    $agua = trim($_POST['careWater'] ?? '');
    $umidade = trim($_POST['careHumidity'] ?? '');
    $solo = trim($_POST['careSoil'] ?? '');
    
    // Validação básica
    if (empty($nome) || empty($descricao) || $preco <= 0 || $estoque < 0) {
        header("Location: ../admin.php?error=invaliddata#products");
        exit();
    }
    
    try {
        // Inicia transação
        $pdo->beginTransaction();
        
        // 1. Insere a planta
        $stmt = $pdo->prepare("
            INSERT INTO plantas (id_categoria, nome_planta, descricao, preco, quantidade_estoque, imagem_url)
            VALUES (:categoria, :nome, :descricao, :preco, :estoque, :imagem)
        ");
        
        $stmt->execute([
            ':categoria' => $categoria,
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':preco' => $preco,
            ':estoque' => $estoque,
            ':imagem' => $imagem
        ]);
        
        $id_planta = $pdo->lastInsertId();
        
        // 2. Insere as especificações
        $stmt = $pdo->prepare("
            INSERT INTO especificacoes (id_planta, nomeCientifico, familia, origem, alturaMedia, pet)
            VALUES (:id_planta, :nomeCientifico, :familia, :origem, :altura, :pet)
        ");
        
        $stmt->execute([
            ':id_planta' => $id_planta,
            ':nomeCientifico' => $nomeCientifico,
            ':familia' => $familia,
            ':origem' => $origem,
            ':altura' => $altura,
            ':pet' => $petFriendly
        ]);
        
        // 3. Insere os cuidados
        $stmt = $pdo->prepare("
            INSERT INTO cuidados (id_planta, luz, agua, humidade, solo)
            VALUES (:id_planta, :luz, :agua, :umidade, :solo)
        ");
        
        $stmt->execute([
            ':id_planta' => $id_planta,
            ':luz' => $luz,
            ':agua' => $agua,
            ':umidade' => $umidade,
            ':solo' => $solo
        ]);
        
        // Commit da transação
        $pdo->commit();
        
        header("Location: ../admin.php?success=productadded#products");
        exit();
        
    } catch (PDOException $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        header("Location: ../admin.php?error=dberror#products");
        exit();
    }
    
} else {
    header("Location: ../admin.php");
    exit();
}
?>

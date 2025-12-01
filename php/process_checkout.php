<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php?error=notloggedin");
    exit();
}

require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do cliente
    $id_usuario = $_SESSION['usuario_id'];
    $nome_completo = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['address']);
    $cidade = trim($_POST['city']);
    $estado = trim($_POST['state']);
    $cep = trim($_POST['zip']);
    
    // Dados de pagamento
    $metodo_pagamento = $_POST['paymentMethod'];
    $carrinho = json_decode($_POST['cartData'], true);
    
    // Validação básica
    if (empty($nome_completo) || empty($email) || empty($endereco) || empty($metodo_pagamento) || empty($carrinho)) {
        header("Location: ../checkout.php?error=emptyfields");
        exit();
    }
    
    // Calcula o valor total
    $valor_total = 0;
    foreach ($carrinho as $item) {
        $valor_total += $item['price'] * $item['quantity'];
    }
    
    try {
        // Inicia transação
        $pdo->beginTransaction();
        
        // 1. Cria o pedido
        $stmt = $pdo->prepare("
            INSERT INTO pedidos (id_usuario, data_pedido, status_pedido, valor_total)
            VALUES (:id_usuario, NOW(), 'finalizado', :valor_total)
        ");
        
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':valor_total' => $valor_total
        ]);
        
        $id_pedido = $pdo->lastInsertId();
        
        // 2. Adiciona os itens do pedido
        $stmt = $pdo->prepare("
            INSERT INTO item_pedido (id_pedido, id_planta, quantidade, preco_unitario)
            VALUES (:id_pedido, :id_planta, :quantidade, :preco_unitario)
        ");
        
        foreach ($carrinho as $item) {
            $stmt->execute([
                ':id_pedido' => $id_pedido,
                ':id_planta' => $item['id'],
                ':quantidade' => $item['quantity'],
                ':preco_unitario' => $item['price']
            ]);
            
            // Atualiza o estoque
            $stmtEstoque = $pdo->prepare("
                UPDATE plantas 
                SET quantidade_estoque = quantidade_estoque - :quantidade 
                WHERE id_planta = :id_planta
            ");
            $stmtEstoque->execute([
                ':quantidade' => $item['quantity'],
                ':id_planta' => $item['id']
            ]);
        }
        
        // Commit da transação
        $pdo->commit();
        
        // Redireciona para página de confirmação
        header("Location: ../order-confirmation.php?order_id=" . $id_pedido);
        exit();
        
    } catch (PDOException $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        header("Location: ../checkout.php?error=processingerror");
        exit();
    }
    
} else {
    header("Location: ../checkout.php");
    exit();
}
?>

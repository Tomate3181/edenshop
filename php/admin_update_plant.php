<?php
// Endpoint para atualizar dados de uma planta
session_start();

// Verifica se o usuário é admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado']);
    exit();
}

require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit();
}

// Validação dos dados
$id_planta = isset($_POST['id_planta']) ? (int) $_POST['id_planta'] : 0;
$nome_planta = isset($_POST['plantName']) ? trim($_POST['plantName']) : '';
$id_categoria = isset($_POST['plantCategory']) ? (int) $_POST['plantCategory'] : 0;
$preco = isset($_POST['plantPrice']) ? (float) $_POST['plantPrice'] : 0;
$quantidade_estoque = isset($_POST['plantStock']) ? (int) $_POST['plantStock'] : 0;
$imagem_url = isset($_POST['plantImage']) ? trim($_POST['plantImage']) : '';
$descricao = isset($_POST['plantDescription']) ? trim($_POST['plantDescription']) : '';

// Dados opcionais
$nome_cientifico = isset($_POST['scientificName']) ? trim($_POST['scientificName']) : null;
$familia = isset($_POST['plantFamily']) ? trim($_POST['plantFamily']) : null;
$origem = isset($_POST['plantOrigin']) ? trim($_POST['plantOrigin']) : null;
$altura_media = isset($_POST['plantHeight']) ? trim($_POST['plantHeight']) : null;
$pet_friendly = isset($_POST['petFriendly']) ? trim($_POST['petFriendly']) : null;
$luz = isset($_POST['careLight']) ? trim($_POST['careLight']) : null;
$agua = isset($_POST['careWater']) ? trim($_POST['careWater']) : null;
$humidade = isset($_POST['careHumidity']) ? trim($_POST['careHumidity']) : null;
$solo = isset($_POST['careSoil']) ? trim($_POST['careSoil']) : null;

// Validação básica
if ($id_planta <= 0 || empty($nome_planta) || $id_categoria <= 0 || $preco <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados inválidos']);
    exit();
}

try {
    // Atualiza a planta usando prepared statement
    $stmt = $pdo->prepare("
        UPDATE plantas SET
            nome_planta = :nome_planta,
            id_categoria = :id_categoria,
            preco = :preco,
            quantidade_estoque = :quantidade_estoque,
            imagem_url = :imagem_url,
            descricao = :descricao,
            nomeCientifico = :nome_cientifico,
            familia = :familia,
            origem = :origem,
            alturaMedia = :altura_media,
            pet = :pet_friendly,
            luz = :luz,
            agua = :agua,
            humidade = :humidade,
            solo = :solo
        WHERE id_planta = :id_planta
    ");

    $stmt->execute([
        ':nome_planta' => $nome_planta,
        ':id_categoria' => $id_categoria,
        ':preco' => $preco,
        ':quantidade_estoque' => $quantidade_estoque,
        ':imagem_url' => $imagem_url,
        ':descricao' => $descricao,
        ':nome_cientifico' => $nome_cientifico,
        ':familia' => $familia,
        ':origem' => $origem,
        ':altura_media' => $altura_media,
        ':pet_friendly' => $pet_friendly,
        ':luz' => $luz,
        ':agua' => $agua,
        ':humidade' => $humidade,
        ':solo' => $solo,
        ':id_planta' => $id_planta
    ]);

    echo json_encode(['success' => true, 'message' => 'Planta atualizada com sucesso']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao atualizar planta: ' . $e->getMessage()]);
}
?>
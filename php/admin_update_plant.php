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

// Dados opcionais (agora obrigatórios conforme pedido)
$nome_cientifico = isset($_POST['scientificName']) ? trim($_POST['scientificName']) : '';
$familia = isset($_POST['plantFamily']) ? trim($_POST['plantFamily']) : '';
$origem = isset($_POST['plantOrigin']) ? trim($_POST['plantOrigin']) : '';
$altura_media = isset($_POST['plantHeight']) ? trim($_POST['plantHeight']) : '';
$pet_friendly = isset($_POST['petFriendly']) ? trim($_POST['petFriendly']) : '';
$luz = isset($_POST['careLight']) ? trim($_POST['careLight']) : '';
$agua = isset($_POST['careWater']) ? trim($_POST['careWater']) : '';
$humidade = isset($_POST['careHumidity']) ? trim($_POST['careHumidity']) : '';
$solo = isset($_POST['careSoil']) ? trim($_POST['careSoil']) : '';

// Validação rigorosa: Todos os campos devem estar preenchidos
if (
    $id_planta <= 0 || empty($nome_planta) || $id_categoria <= 0 || $preco <= 0 ||
    empty($imagem_url) || empty($descricao) ||
    empty($nome_cientifico) || empty($familia) || empty($origem) || empty($altura_media) ||
    empty($pet_friendly) || empty($luz) || empty($agua) || empty($humidade) || empty($solo)
) {

    http_response_code(400);
    echo json_encode(['error' => 'Todos os campos são obrigatórios. Por favor, preencha todas as informações.']);
    exit();
}

try {
    $pdo->beginTransaction();

    // 1. Atualiza a planta
    $stmt = $pdo->prepare("
        UPDATE plantas SET
            nome_planta = :nome_planta,
            id_categoria = :id_categoria,
            preco = :preco,
            quantidade_estoque = :quantidade_estoque,
            imagem_url = :imagem_url,
            descricao = :descricao
        WHERE id_planta = :id_planta
    ");

    $stmt->execute([
        ':nome_planta' => $nome_planta,
        ':id_categoria' => $id_categoria,
        ':preco' => $preco,
        ':quantidade_estoque' => $quantidade_estoque,
        ':imagem_url' => $imagem_url,
        ':descricao' => $descricao,
        ':id_planta' => $id_planta
    ]);

    // 2. Atualiza ou Insere Especificações
    // Verifica se já existe
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM especificacoes WHERE id_planta = ?");
    $stmtCheck->execute([$id_planta]);
    $existsSpec = $stmtCheck->fetchColumn() > 0;

    if ($existsSpec) {
        $stmt = $pdo->prepare("
            UPDATE especificacoes SET
                nomeCientifico = :nome_cientifico,
                familia = :familia,
                origem = :origem,
                alturaMedia = :altura_media,
                pet = :pet_friendly
            WHERE id_planta = :id_planta
        ");
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO especificacoes (id_planta, nomeCientifico, familia, origem, alturaMedia, pet)
            VALUES (:id_planta, :nome_cientifico, :familia, :origem, :altura_media, :pet_friendly)
        ");
    }

    $stmt->execute([
        ':nome_cientifico' => $nome_cientifico,
        ':familia' => $familia,
        ':origem' => $origem,
        ':altura_media' => $altura_media,
        ':pet_friendly' => $pet_friendly,
        ':id_planta' => $id_planta
    ]);

    // 3. Atualiza ou Insere Cuidados
    // Verifica se já existe
    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM cuidados WHERE id_planta = ?");
    $stmtCheck->execute([$id_planta]);
    $existsCare = $stmtCheck->fetchColumn() > 0;

    if ($existsCare) {
        $stmt = $pdo->prepare("
            UPDATE cuidados SET
                luz = :luz,
                agua = :agua,
                humidade = :humidade,
                solo = :solo
            WHERE id_planta = :id_planta
        ");
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO cuidados (id_planta, luz, agua, humidade, solo)
            VALUES (:id_planta, :luz, :agua, :humidade, :solo)
        ");
    }

    $stmt->execute([
        ':luz' => $luz,
        ':agua' => $agua,
        ':humidade' => $humidade,
        ':solo' => $solo,
        ':id_planta' => $id_planta
    ]);

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Planta atualizada com sucesso']);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao atualizar planta: ' . $e->getMessage()]);
}
?>
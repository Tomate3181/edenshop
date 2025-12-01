<?php
/**
 * Script para buscar todos os produtos e categorias do banco de dados
 */

// Incluir conexão com o banco de dados
require_once 'db_connect.php';

/**
 * Busca todas as categorias do banco de dados
 * @return array Array de categorias
 */
function getAllCategories()
{
    global $pdo;

    try {
        $stmt = $pdo->query("
            SELECT 
                id_categoria,
                nome_categoria,
                desc_categoria
            FROM categorias
            ORDER BY nome_categoria ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar categorias: " . $e->getMessage());
        return [];
    }
}

/**
 * Busca todos os produtos do banco de dados
 * @param int|null $categoria_id ID da categoria para filtrar (opcional)
 * @return array Array de produtos
 */
function getAllProducts($categoria_id = null)
{
    global $pdo;

    try {
        $sql = "
            SELECT 
                p.id_planta,
                p.nome_planta,
                p.descricao,
                p.preco,
                p.quantidade_estoque,
                p.imagem_url,
                c.nome_categoria,
                c.id_categoria
            FROM plantas p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.quantidade_estoque > 0 AND p.ativo = 1
        ";

        // Adicionar filtro de categoria se fornecido
        if ($categoria_id !== null) {
            $sql .= " AND p.id_categoria = :categoria_id";
        }

        $sql .= " ORDER BY p.nome_planta ASC";

        $stmt = $pdo->prepare($sql);

        if ($categoria_id !== null) {
            $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar produtos: " . $e->getMessage());
        return [];
    }
}

/**
 * Busca um produto específico pelo ID
 * @param int $id ID do produto
 * @return array|null Dados do produto ou null se não encontrado
 */
function getProductById($id)
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("
            SELECT 
                p.id_planta,
                p.nome_planta,
                p.descricao,
                p.preco,
                p.quantidade_estoque,
                p.imagem_url,
                c.nome_categoria,
                c.id_categoria,
                e.nomeCientifico,
                e.familia,
                e.origem,
                e.alturaMedia,
                e.pet,
                cu.luz,
                cu.agua,
                cu.humidade,
                cu.solo
            FROM plantas p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            LEFT JOIN especificacoes e ON p.id_planta = e.id_planta
            LEFT JOIN cuidados cu ON p.id_planta = cu.id_planta
            WHERE p.id_planta = :id AND p.ativo = 1
        ");

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar produto: " . $e->getMessage());
        return null;
    }
}
?>
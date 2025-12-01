<?php
/**
 * Script para buscar produtos em destaque do banco de dados
 * Retorna um array de produtos limitado a um número específico
 */

// Incluir conexão com o banco de dados
require_once 'db_connect.php';

/**
 * Busca produtos em destaque do banco de dados
 * @param int $limit Número máximo de produtos a retornar (padrão: 8)
 * @return array Array de produtos em destaque
 */
function getFeaturedProducts($limit = 8)
{
    global $pdo;

    try {
        // Query para buscar produtos em destaque
        // Ordenamos por quantidade em estoque (produtos mais disponíveis primeiro)
        // e limitamos ao número especificado
        $stmt = $pdo->prepare("
            SELECT 
                p.id_planta,
                p.nome_planta,
                p.descricao,
                p.preco,
                p.quantidade_estoque,
                p.imagem_url,
                c.nome_categoria
            FROM plantas p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.quantidade_estoque > 0 AND p.ativo = 1
            ORDER BY p.quantidade_estoque DESC, p.id_planta ASC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erro ao buscar produtos em destaque: " . $e->getMessage());
        return [];
    }
}
?>
<?php
/**
 * Script para buscar produtos relacionados baseados na categoria
 */

// Incluir conexão com o banco de dados
require_once 'db_connect.php';

/**
 * Busca produtos relacionados baseados na categoria
 * @param int $produto_id ID do produto atual (para excluir da lista)
 * @param int $categoria_id ID da categoria para buscar produtos relacionados
 * @param int $limit Número máximo de produtos a retornar (padrão: 3)
 * @return array Array de produtos relacionados
 */
function getRelatedProducts($produto_id, $categoria_id, $limit = 3) {
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
                c.id_categoria
            FROM plantas p
            LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
            WHERE p.id_categoria = :categoria_id
            AND p.id_planta != :produto_id
            AND p.quantidade_estoque > 0
            ORDER BY RAND()
            LIMIT :limit
        ");
        
        $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindValue(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        error_log("Erro ao buscar produtos relacionados: " . $e->getMessage());
        return [];
    }
}
?>

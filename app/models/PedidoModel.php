<?php
class PedidoModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Cria um novo pedido no banco de dados
     * @param array $dados [id_cliente, itens[id_produto, quantidade, preco]]
     * @return int ID do pedido criado
     */
    public function criarPedido(array $dados): int {
        $this->db->beginTransaction();

        try {
            // Calcular total
            $total = array_reduce($dados['itens'], function($sum, $item) {
                return $sum + ($item['preco'] * $item['quantidade']);
            }, 0);

            // Inserir o pedido principal
            $queryPedido = "INSERT INTO pedido (
                id_cliente, 
                data_pedido, 
                total
            ) VALUES (
                :id_cliente, 
                NOW(), 
                :total
            )";

            $stmtPedido = $this->db->prepare($queryPedido);
            $stmtPedido->execute([
                ':id_cliente' => $dados['id_cliente'],
                ':total' => $total
            ]);

            $pedidoId = $this->db->lastInsertId();

            // Inserir os itens do pedido (como registros individuais)
            foreach ($dados['itens'] as $item) {
                $this->adicionarItemPedido($pedidoId, $item);
            }

            $this->db->commit();
            return $pedidoId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw new RuntimeException("Erro ao criar pedido: " . $e->getMessage());
        }
    }

    /**
     * Adiciona um item ao pedido
     */
    private function adicionarItemPedido(int $pedidoId, array $item): void {
        $query = "INSERT INTO pedido (
            id_cliente,
            id_produto,
            data_pedido,
            total
        ) VALUES (
            :id_cliente,
            :id_produto,
            NOW(),
            :subtotal
        )";

        $subtotal = $item['preco'] * $item['quantidade'];
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':id_cliente' => $this->getClienteDoPedido($pedidoId),
            ':id_produto' => $item['id_produto'],
            ':subtotal' => $subtotal
        ]);
    }

    /**
     * Busca o ID do cliente associado a um pedido
     */
    private function getClienteDoPedido(int $pedidoId): int {
        $query = "SELECT id_cliente FROM pedido WHERE id_pedido = :id_pedido LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_pedido' => $pedidoId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            throw new RuntimeException("Pedido não encontrado");
        }
        
        return (int)$result['id_cliente'];
    }

    /**
     * Busca um pedido pelo ID
     */
    public function buscarPorId(int $idPedido): ?array {
        // Buscar dados básicos do pedido
        $query = "SELECT 
                p.id_pedido,
                p.data_pedido,
                p.total,
                c.id_cliente,
                c.nome as cliente_nome
            FROM pedido p
            JOIN cliente c ON p.id_cliente = c.id_cliente
            WHERE p.id_pedido = :id_pedido";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_pedido' => $idPedido]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            return null;
        }

        // Buscar itens do pedido (todos os registros com mesmo id_cliente e data_pedido)
        $queryItens = "SELECT 
                p.id_produto,
                pr.nome as produto_nome,
                pr.descricao as produto_descricao,
                p.total as subtotal,
                p.total/pr.preco as quantidade,
                pr.preco as preco_unitario
            FROM pedido p
            JOIN produto pr ON p.id_produto = pr.id_produto
            WHERE p.id_cliente = :id_cliente 
            AND p.data_pedido = :data_pedido";

        $stmtItens = $this->db->prepare($queryItens);
        $stmtItens->execute([
            ':id_cliente' => $pedido['id_cliente'],
            ':data_pedido' => $pedido['data_pedido']
        ]);
        
        $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

        // Formatar os itens
        $pedido['itens'] = array_map(function($item) {
            return [
                'id_produto' => $item['id_produto'],
                'nome' => $item['produto_nome'],
                'descricao' => $item['produto_descricao'],
                'quantidade' => (int)$item['quantidade'],
                'preco' => (float)$item['preco_unitario'],
                'subtotal' => (float)$item['subtotal']
            ];
        }, $itens);

        return $pedido;
    }

    /**
     * Lista pedidos de um cliente
     */
    public function listarPorCliente(int $idCliente): array {
        // Agrupa por data_pedido para formar pedidos completos
        $query = "SELECT 
                MIN(id_pedido) as id_pedido,
                id_cliente,
                data_pedido,
                SUM(total) as total,
                COUNT(id_produto) as total_itens
            FROM pedido
            WHERE id_cliente = :id_cliente
            GROUP BY data_pedido
            ORDER BY data_pedido DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id_cliente' => $idCliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
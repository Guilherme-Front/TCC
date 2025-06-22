<?php
class Pedido {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function criarPedido(array $dados): int {
        $stmt = $this->pdo->prepare("
            INSERT INTO pedidos 
            (cliente_id, status, data_pedido, valor_total) 
            VALUES (:cliente_id, :status, :data_pedido, 0)
        ");
        
        $stmt->execute([
            ':cliente_id' => $dados['cliente_id'],
            ':status' => $dados['status'],
            ':data_pedido' => $dados['data_pedido']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function adicionarItem(int $pedidoId, array $item): void {
        $stmt = $this->pdo->prepare("
            INSERT INTO pedido_itens 
            (pedido_id, produto_id, quantidade, preco_unitario, subtotal) 
            VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario, :subtotal)
        ");
        
        $stmt->execute([
            ':pedido_id' => $pedidoId,
            ':produto_id' => $item['id_produto'],
            ':quantidade' => $item['quantidade'],
            ':preco_unitario' => $item['preco_unitario'],
            ':subtotal' => $item['subtotal']
        ]);
        
        // Atualizar valor total do pedido
        $this->atualizarTotalPedido($pedidoId);
    }

    private function atualizarTotalPedido(int $pedidoId): void {
        $stmt = $this->pdo->prepare("
            UPDATE pedidos p
            SET valor_total = (
                SELECT SUM(subtotal) 
                FROM pedido_itens 
                WHERE pedido_id = :pedido_id
            )
            WHERE id = :pedido_id
        ");
        
        $stmt->execute([':pedido_id' => $pedidoId]);
    }
    
    // Método opcional para atualizar estoque
    public function atualizarEstoque(int $produtoId, int $quantidade): void {
        $stmt = $this->pdo->prepare("
            UPDATE produtos 
            SET estoque = estoque + :quantidade 
            WHERE id = :produto_id
        ");
        
        $stmt->execute([
            ':produto_id' => $produtoId,
            ':quantidade' => $quantidade
        ]);
    }
}
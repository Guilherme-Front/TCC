<?php
require_once __DIR__ . '/../config/mercado_pago.php';

class PagamentoModel {
    private $db;
    private $mpConfig;

    public function __construct($db) {
        $this->db = $db;
        $this->mpConfig = include __DIR__ . '/../config/mercado_pago.php';
    }

    /**
     * Registra um novo pagamento no banco de dados
     */
    public function registrarPagamento($dadosPagamento) {
        $query = "INSERT INTO pagamentos (
            mercadopago_id,
            external_reference,
            status,
            valor,
            metodo_pagamento,
            data_criacao,
            data_atualizacao,
            cliente_id,
            pedido_id
        ) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $dadosPagamento['mercadopago_id'],
            $dadosPagamento['external_reference'],
            $dadosPagamento['status'],
            $dadosPagamento['valor'],
            $dadosPagamento['metodo_pagamento'],
            $dadosPagamento['cliente_id'],
            $dadosPagamento['pedido_id']
        ]);
    }

    /**
     * Atualiza o status de um pagamento
     */
    public function atualizarStatus($paymentId, $novoStatus) {
        $query = "UPDATE pagamentos SET 
            status = ?,
            data_atualizacao = NOW()
            WHERE mercadopago_id = ?";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$novoStatus, $paymentId]);
    }

    /**
     * Busca um pagamento pelo ID do Mercado Pago
     */
    public function buscarPorMpId($paymentId) {
        $query = "SELECT * FROM pagamentos WHERE mercadopago_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$paymentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cria uma preferência de pagamento no Mercado Pago
     */
    public function criarPreferencia($itens, $cliente, $pedidoId) {
        MercadoPago\SDK::setAccessToken($this->mpConfig['access_token']);

        $preference = new MercadoPago\Preference();

        // Configura itens
        $mpItens = [];
        foreach ($itens as $item) {
            $mpItem = new MercadoPago\Item();
            $mpItem->title = $item['nome'];
            $mpItem->quantity = $item['quantidade'];
            $mpItem->unit_price = $item['preco'];
            $mpItem->description = $item['descricao'] ?? '';
            $mpItem->picture_url = $item['imagem'] ?? '';
            $mpItens[] = $mpItem;
        }
        $preference->items = $mpItens;

        // Configura pagador
        $payer = new MercadoPago\Payer();
        $payer->name = $cliente['nome'];
        $payer->email = $cliente['email'];
        $payer->phone = [
            "area_code" => substr($cliente['telefone'], 0, 2),
            "number" => substr($cliente['telefone'], 2)
        ];
        $preference->payer = $payer;

        // URLs de retorno
        $preference->back_urls = [
            "success" => "https://seusite.com/pagamento/sucesso",
            "failure" => "https://seusite.com/pagamento/erro",
            "pending" => "https://seusite.com/pagamento/pendente"
        ];

        $preference->auto_return = "approved";
        $preference->notification_url = "https://seusite.com/api/notificacoes";
        $preference->external_reference = $pedidoId;

        $preference->save();

        return $preference;
    }

    /**
     * Processa notificação do Mercado Pago
     */
    public function processarNotificacao($topic, $id) {
        MercadoPago\SDK::setAccessToken($this->mpConfig['access_token']);

        if ($topic === 'payment') {
            $payment = MercadoPago\Payment::find_by_id($id);
            
            // Atualiza no banco de dados
            $this->atualizarStatus($payment->id, $payment->status);
            
            // Retorna dados atualizados
            return $this->buscarPorMpId($payment->id);
        }
        
        return false;
    }
}
?>
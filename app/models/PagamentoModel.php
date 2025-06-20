<?php
require_once __DIR__ . '/../config/mercado_pago.php';

class PagamentoModel {
    private PDO $db;
    private array $mpConfig;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->mpConfig = include __DIR__ . '/../config/mercado_pago.php';
        MercadoPago\SDK::setAccessToken($this->mpConfig['access_token']);
    }

    public function registrarPagamento(array $dados): bool {
        $query = "INSERT INTO pagamentos (
            mercadopago_id, external_reference, status, valor,
            metodo_pagamento, cliente_id, pedido_id
        ) VALUES (:mp_id, :ext_ref, :status, :valor, :metodo, :cliente_id, :pedido_id)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':mp_id' => $dados['mercadopago_id'],
            ':ext_ref' => $dados['external_reference'],
            ':status' => $dados['status'],
            ':valor' => $dados['valor'],
            ':metodo' => $dados['metodo_pagamento'] ?? null,
            ':cliente_id' => $dados['cliente_id'],
            ':pedido_id' => $dados['pedido_id']
        ]);
    }

    public function atualizarStatus(string $paymentId, string $status): bool {
        $query = "UPDATE pagamentos SET 
            status = :status,
            data_atualizacao = NOW()
            WHERE mercadopago_id = :mp_id";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':status' => $status,
            ':mp_id' => $paymentId
        ]);
    }

    public function buscarPorId(int $id): ?array {
        $query = "SELECT * FROM pagamentos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function buscarPorMpId(string $mpId): ?array {
        $query = "SELECT * FROM pagamentos WHERE mercadopago_id = :mp_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':mp_id' => $mpId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function criarPreferencia(array $itens, array $cliente, int $pedidoId): MercadoPago\Preference {
        $preference = new MercadoPago\Preference();

        // Configura itens
        $mpItems = array_map(function($item) {
            $mpItem = new MercadoPago\Item();
            $mpItem->title = substr($item['nome'], 0, 255);
            $mpItem->quantity = (int)$item['quantidade'];
            $mpItem->unit_price = (float)$item['preco'];
            $mpItem->description = substr($item['descricao'] ?? '', 0, 255);
            $mpItem->picture_url = filter_var($item['imagem'] ?? '', FILTER_VALIDATE_URL) ? $item['imagem'] : null;
            return $mpItem;
        }, $itens);

        $preference->items = $mpItems;

        // Configura pagador
        $payer = new MercadoPago\Payer();
        $payer->name = substr($cliente['nome'], 0, 50);
        $payer->surname = substr($cliente['sobrenome'] ?? '', 0, 50);
        $payer->email = filter_var($cliente['email'], FILTER_VALIDATE_EMAIL);
        $payer->phone = [
            "area_code" => substr(preg_replace('/\D/', '', $cliente['telefone']), 0, 2),
            "number" => substr(preg_replace('/\D/', '', $cliente['telefone']), 2)
        ];
        $preference->payer = $payer;

        // URLs de retorno
        $preference->back_urls = $this->mpConfig['back_urls'];
        $preference->auto_return = "approved";
        $preference->notification_url = $this->mpConfig['notification_url'];
        $preference->external_reference = (string)$pedidoId;

        $preference->save();
        return $preference;
    }

    public function processarNotificacao(string $topic, string $id): ?array {
        if ($topic !== 'payment') {
            return null;
        }

        $payment = MercadoPago\Payment::find_by_id($id);
        $this->atualizarStatus($payment->id, $payment->status);
        
        return $this->buscarPorMpId($payment->id);
    }
}
?>
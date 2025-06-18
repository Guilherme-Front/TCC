<?php
require_once __DIR__.'/../config/mercado_pago.php';
require_once __DIR__.'/../models/PagamentoModel.php';
require_once __DIR__.'/../models/PedidoModel.php'; // Novo include

class PagamentoController {
    private PagamentoModel $model;
    private PedidoModel $pedidoModel;

    public function __construct(PDO $db) {
        $this->model = new PagamentoModel($db);
        $this->pedidoModel = new PedidoModel($db); // Inicializa modelo de pedido
    }

    /**
     * Exibe página de sucesso de pagamento
     * @param string $paymentId ID do pagamento no Mercado Pago
     */
    public function sucesso(string $paymentId): void {
        try {
            if (empty($paymentId)) {
                throw new InvalidArgumentException("ID de pagamento inválido");
            }

            $pagamento = $this->model->buscarPorMpId($paymentId);
            
            if (!$pagamento) {
                throw new RuntimeException("Pagamento não encontrado no sistema");
            }

            $pedido = $this->pedidoModel->buscarPorId($pagamento['pedido_id']);

            if (!$pedido) {
                throw new RuntimeException("Pedido associado não encontrado");
            }

            // Sanitiza dados para view
            $data = [
                'pagamento' => [
                    'id' => htmlspecialchars($pagamento['mercadopago_id']),
                    'valor' => number_format($pagamento['valor'], 2, ',', '.'),
                    'data' => date('d/m/Y H:i', strtotime($pagamento['data_criacao']))
                ],
                'pedido' => [
                    'id' => (int)$pedido['id'],
                    'itens' => array_map(function($item) {
                        return [
                            'nome' => htmlspecialchars($item['nome']),
                            'quantidade' => (int)$item['quantidade'],
                            'preco' => number_format($item['preco'], 2, ',', '.')
                        ];
                    }, $pedido['itens'])
                ]
            ];

            // Verifica se a view existe
            $viewPath = __DIR__.'/../views/pagamento/sucesso.php';
            if (!file_exists($viewPath)) {
                throw new RuntimeException("View de sucesso não encontrada");
            }

            require $viewPath;
            
        } catch (Exception $e) {
            error_log("Erro no sucesso do pagamento: " . $e->getMessage());
            $this->erro(
                "Pagamento aprovado, mas ocorreu um erro no sistema",
                'SYSTEM_ERROR',
                $pagamento['pedido_id'] ?? null
            );
        }
    }

    /**
     * Exibe página de erro de pagamento
     * @param string $mensagem Mensagem de erro amigável
     * @param string|null $codigoErro Código técnico do erro
     * @param int|null $pedidoId ID do pedido relacionado
     */
    public function erro(string $mensagem, ?string $codigoErro = null, ?int $pedidoId = null): void {
        try {
            // Sanitiza dados para view
            $data = [
                'erro' => htmlspecialchars($mensagem),
                'codigo_erro' => $codigoErro ? htmlspecialchars($codigoErro) : null,
                'pedido_id' => $pedidoId
            ];

            // Verifica se a view existe
            $viewPath = __DIR__.'/../views/pagamento/erro.php';
            if (!file_exists($viewPath)) {
                throw new RuntimeException("View de erro não encontrada");
            }

            require $viewPath;
            
        } catch (Exception $e) {
            // Fallback crítico se até a view de erro falhar
            error_log("FALHA CRÍTICA: " . $e->getMessage());
            http_response_code(500);
            echo "<h1>Erro no sistema</h1>";
            echo "<p>Por favor, entre em contato com o suporte técnico.</p>";
            if (ini_get('display_errors')) {
                echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            }
            exit;
        }
    }
}
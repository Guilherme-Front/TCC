<?php
require_once __DIR__.'/../models/PagamentoModel.php';
require_once __DIR__.'/../models/PedidoModel.php';
require_once __DIR__.'/../models/ClienteModel.php';

class PagamentoController {
    private PagamentoModel $pagamentoModel;
    private PedidoModel $pedidoModel;
    private ClienteModel $clienteModel;

    public function __construct(PDO $db) {
        $this->pagamentoModel = new PagamentoModel($db);
        $this->pedidoModel = new PedidoModel($db);
        $this->clienteModel = new ClienteModel();
    }

    /**
     * Inicia o processo de checkout para um pedido
     * @param int $idPedido ID do pedido
     */
    public function iniciarCheckout(int $idPedido): void {
        try {
            // Validar ID do pedido
            if ($idPedido <= 0) {
                throw new InvalidArgumentException("ID do pedido inválido");
            }

            // Buscar dados do pedido
            $pedido = $this->pedidoModel->buscarPorId($idPedido);
            if (!$pedido) {
                throw new RuntimeException("Pedido não encontrado");
            }

            // Buscar dados do cliente
            $cliente = $this->clienteModel->buscarPorId($pedido['id_cliente']);
            if (!$cliente) {
                throw new RuntimeException("Cliente não encontrado");
            }

            // Preparar itens para o Mercado Pago
            $itensMP = array_map(function($item) {
                return [
                    'id' => $item['id_produto'],
                    'nome' => $item['nome'],
                    'preco' => (float)$item['preco'],
                    'quantidade' => (int)$item['quantidade'],
                    'descricao' => $item['descricao'] ?? '',
                    'imagem' => $item['imagem'] ?? null
                ];
            }, $pedido['itens']);

            // Criar preferência de pagamento no Mercado Pago
            $preferencia = $this->pagamentoModel->criarPreferencia(
                $itensMP,
                [
                    'nome' => $cliente['nome'],
                    'email' => $cliente['email'],
                    'telefone' => $cliente['telefone'] ?? '',
                    'cpf' => $cliente['cpf'] ?? '',
                    'endereco' => $this->formatarEnderecoCliente($cliente)
                ],
                $idPedido
            );

            // Registrar o pagamento no banco de dados
            $this->pagamentoModel->registrarPagamento([
                'mercadopago_id' => $preferencia->id,
                'external_reference' => $preferencia->external_reference,
                'status' => 'pending',
                'valor' => (float)$pedido['total'],
                'cliente_id' => $cliente['id_cliente'],
                'pedido_id' => $idPedido
            ]);

            // Redirecionar para o checkout
            header('Location: /checkout?preference_id=' . $preferencia->id);
            exit;

        } catch (Exception $e) {
            error_log("Erro no checkout (Pedido ID: $idPedido): " . $e->getMessage());
            $this->erro(
                "Erro ao iniciar o pagamento: " . $e->getMessage(),
                'CHECKOUT_ERROR',
                $idPedido
            );
        }
    }

    /**
     * Exibe a página de checkout
     * @param string $preferenceId ID da preferência do Mercado Pago
     */
    public function exibirCheckout(string $preferenceId): void {
        try {
            if (empty($preferenceId)) {
                throw new InvalidArgumentException("ID de preferência inválido");
            }

            $viewPath = __DIR__.'/../views/pagamento/checkout.php';
            if (!file_exists($viewPath)) {
                throw new RuntimeException("Página de checkout não encontrada");
            }

            require $viewPath;

        } catch (Exception $e) {
            error_log("Erro ao exibir checkout: " . $e->getMessage());
            $this->erro(
                "Erro ao carregar a página de pagamento",
                'CHECKOUT_PAGE_ERROR'
            );
        }
    }

    /**
     * Exibe a página de sucesso após pagamento
     * @param string $paymentId ID do pagamento no Mercado Pago
     */
    public function sucesso(string $paymentId): void {
        try {
            if (empty($paymentId)) {
                throw new InvalidArgumentException("ID de pagamento inválido");
            }

            // Buscar dados do pagamento
            $pagamento = $this->pagamentoModel->buscarPorMpId($paymentId);
            if (!$pagamento) {
                throw new RuntimeException("Pagamento não encontrado");
            }

            // Buscar dados do pedido
            $pedido = $this->pedidoModel->buscarPorId($pagamento['pedido_id']);
            if (!$pedido) {
                throw new RuntimeException("Pedido associado não encontrado");
            }

            // Atualizar status do pedido para "pago"
            $this->pedidoModel->atualizarStatus($pedido['id_pedido'], 'pago');

            // Preparar dados para a view
            $data = [
                'pagamento' => [
                    'id' => $pagamento['mercadopago_id'],
                    'valor' => number_format($pagamento['valor'], 2, ',', '.'),
                    'data' => date('d/m/Y H:i', strtotime($pagamento['data_criacao'])),
                    'metodo' => $pagamento['metodo_pagamento'] ?? 'Cartão de crédito'
                ],
                'pedido' => [
                    'id_pedido' => $pedido['id_pedido'],
                    'itens' => $pedido['itens'],
                    'total' => number_format($pedido['total'], 2, ',', '.')
                ]
            ];

            $this->renderView('sucesso', $data);

        } catch (Exception $e) {
            error_log("Erro na página de sucesso: " . $e->getMessage());
            $this->erro(
                "Pagamento aprovado, mas ocorreu um erro: " . $e->getMessage(),
                'SUCCESS_PAGE_ERROR',
                $pagamento['pedido_id'] ?? null
            );
        }
    }

    /**
     * Exibe a página de erro no pagamento
     * @param string $mensagem Mensagem de erro amigável
     * @param string|null $codigoErro Código técnico do erro
     * @param int|null $idPedido ID do pedido relacionado
     */
    public function erro(string $mensagem, ?string $codigoErro = null, ?int $idPedido = null): void {
        try {
            $data = [
                'erro' => $mensagem,
                'codigo_erro' => $codigoErro,
                'pedido_id' => $idPedido
            ];

            $this->renderView('erro', $data);

        } catch (Exception $e) {
            // Fallback crítico se até a página de erro falhar
            error_log("FALHA CRÍTICA: " . $e->getMessage());
            $this->mostrarErroCritico($e->getMessage());
        }
    }

    /**
     * Processa notificações do Mercado Pago (Webhook)
     */
    public function processarNotificacao(): void {
        try {
            $topic = $_GET['topic'] ?? '';
            $id = $_GET['id'] ?? '';

            if (empty($topic) || empty($id)) {
                throw new InvalidArgumentException("Parâmetros de notificação inválidos");
            }

            // Processar notificação
            $pagamento = $this->pagamentoModel->processarNotificacao($topic, $id);

            if ($pagamento) {
                // Atualizar status do pedido conforme o pagamento
                $novoStatus = $this->mapearStatusPedido($pagamento['status']);
                $this->pedidoModel->atualizarStatus($pagamento['pedido_id'], $novoStatus);
            }

            http_response_code(200);
            echo "Notificação processada com sucesso";

        } catch (Exception $e) {
            error_log("Erro ao processar notificação: " . $e->getMessage());
            http_response_code(400);
            echo "Erro ao processar notificação";
        }
    }

    /**
     * Formata o endereço do cliente para o Mercado Pago
     */
    private function formatarEnderecoCliente(array $cliente): array {
        return [
            'zip_code' => $cliente['endereco_cep'] ?? '',
            'street_name' => $cliente['endereco_rua'] ?? '',
            'street_number' => $cliente['endereco_numero'] ?? '',
            'neighborhood' => $cliente['endereco_bairro'] ?? '',
            'city' => $cliente['endereco_cidade'] ?? '',
            'federal_unit' => $cliente['endereco_estado'] ?? ''
        ];
    }

    /**
     * Mapeia status do Mercado Pago para status do pedido
     */
    private function mapearStatusPedido(string $statusMP): string {
        $map = [
            'approved' => 'pago',
            'pending' => 'pendente',
            'in_process' => 'processando',
            'rejected' => 'recusado',
            'refunded' => 'reembolsado',
            'cancelled' => 'cancelado',
            'in_mediation' => 'em_mediacao',
            'charged_back' => 'estornado'
        ];

        return $map[strtolower($statusMP)] ?? 'pendente';
    }

    /**
     * Renderiza uma view
     */
    private function renderView(string $viewName, array $data = []): void {
        $viewPath = __DIR__."/../views/pagamento/{$viewName}.php";
        if (!file_exists($viewPath)) {
            throw new RuntimeException("View {$viewName} não encontrada");
        }

        extract($data);
        require $viewPath;
        exit;
    }

    /**
     * Mostra erro crítico quando tudo mais falha
     */
    private function mostrarErroCritico(string $mensagem): void {
        http_response_code(500);
        header('Content-Type: text/html; charset=utf-8');
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Erro no Sistema</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; color: #333; }
                .error-container { max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px; }
                h1 { color: #d32f2f; }
                .contact { margin-top: 20px; font-size: 0.9em; color: #666; }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>Erro no Sistema</h1>
                <p>Ocorreu um erro crítico no processamento do seu pedido.</p>
                <p>Por favor, entre em contato com nosso suporte informando o código abaixo:</p>
                <pre>' . htmlspecialchars($mensagem) . '</pre>
                <div class="contact">
                    <p><strong>Suporte:</strong> suporte@seusite.com<br>
                    <strong>Telefone:</strong> (XX) XXXX-XXXX</p>
                </div>
            </div>
        </body>
        </html>';
        exit;
    }
}
<?php
require_once __DIR__ . '/../controllers/conn.php';

class PerfilController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function exibirPerfil()
    {
        session_start();
        
        // Verificação inicial da sessão
        if (!isset($_SESSION['id_cliente'])) {
            header('Location: ../views/Login.html');
            exit();
        }

        $id_cliente = $_SESSION['id_cliente'];
        
        // Consulta ao banco de dados
        $query = "SELECT nome, email, telefone, datNasc FROM cliente WHERE id_cliente = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_cliente);
        
        if (!$stmt->execute()) {
            die("Erro ao executar a consulta: " . $stmt->error);
        }
        
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            die("Cliente não encontrado!");
        }

        $cliente = $result->fetch_assoc();

        // Formatar data
        $dataNascFormatada = 'Não informada';
        if (!empty($cliente['datNasc']) && $cliente['datNasc'] != '0000-00-00') {
            $data = DateTime::createFromFormat('Y-m-d', $cliente['datNasc']);
            if ($data) {
                $dataNascFormatada = $data->format('d/m/Y');
            }
        }

        // Garantir que todos campos existam
        $cliente = array_merge([
            'nome' => 'Não informado',
            'email' => 'Não informado',
            'telefone' => 'Não informado',
            'datNasc' => null
        ], $cliente);

        // Passar os dados para a view
        require_once __DIR__ . '/../views/telaPerfil.php';
    }
}

// Uso:
$controller = new PerfilController();
$controller->exibirPerfil();
?>
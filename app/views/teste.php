<?php 
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "teste";           

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar se o nome do produto foi enviado
    if (isset($_POST['nome']) && !empty($_POST['nome'])) {
        $nome_produto = $_POST['nome'];

        // Usar prepared statement para proteger contra SQL injection
        $stmt_produto = $conn->prepare("INSERT INTO produto (nome) VALUES (?)");
        $stmt_produto->bind_param("s", $nome_produto);

        if ($stmt_produto->execute()) {
            $produto_id = $conn->insert_id; // Pega o ID do produto inserido
            echo "Produto cadastrado com sucesso!<br>";

            // Função para fazer o upload da imagem
            function upload_imagem($imagem, $produto_id, $conn) {
                // Definir o diretório de uploads baseado no produto_id
                $target_dir = "../../public/uploads/{$produto_id}/"; // Criar uma pasta com o ID do produto

                // Criar a pasta de uploads se não existir
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true); // Cria a pasta com permissões adequadas
                }

                $target_file = $target_dir . basename($imagem["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Validar tipo de imagem (apenas JPG, PNG, GIF)
                $allowed_types = ["jpg", "jpeg", "png", "gif"];
                if (!in_array($imageFileType, $allowed_types)) {
                    echo "Somente arquivos JPG, PNG e GIF são permitidos.<br>";
                    return;
                }

                // Limitar o tamanho do arquivo (max 5MB)
                if ($imagem["size"] > 5000000) {
                    echo "O arquivo é muito grande. O limite é 5MB.<br>";
                    return;
                }

                // Verificar se o arquivo é uma imagem
                if (getimagesize($imagem["tmp_name"])) {
                    if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
                        // Inserir no banco de dados
                        $stmt_imagem = $conn->prepare("INSERT INTO imagem_produto (produto_id, imagem) VALUES (?, ?)");
                        $stmt_imagem->bind_param("is", $produto_id, $target_file);
                        if ($stmt_imagem->execute()) {
                            echo "Imagem carregada com sucesso!<br>";
                        } else {
                            echo "Erro ao inserir imagem no banco: " . $conn->error . "<br>";
                        }
                    } else {
                        echo "Erro ao fazer o upload da imagem.<br>";
                    }
                } else {
                    echo "O arquivo não é uma imagem válida.<br>";
                }
            }

            // Processar as imagens (máximo de 3 imagens)
            if (isset($_FILES['imagens']) && count($_FILES['imagens']['name']) > 0) {
                $total_imagens = count($_FILES['imagens']['name']);
                $max_imagens = 3;

                for ($i = 0; $i < $total_imagens && $i < $max_imagens; $i++) {
                    // Criar um array temporário para os arquivos
                    $imagem = [
                        "name" => $_FILES['imagens']['name'][$i],
                        "tmp_name" => $_FILES['imagens']['tmp_name'][$i],
                        "size" => $_FILES['imagens']['size'][$i]
                    ];
                    upload_imagem($imagem, $produto_id, $conn);
                }
            }

        } else {
            echo "Erro ao cadastrar produto: " . $conn->error . "<br>";
        }
    } else {
        echo "Nome do produto não foi fornecido.<br>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <h1>Cadastrar Produto e Imagens</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="imagens">Imagens do Produto (até 3):</label>
        <input type="file" id="imagens" name="imagens[]" accept="image/*" multiple><br><br>

        <input type="submit" value="Cadastrar Produto">
    </form>
</body>
</html>

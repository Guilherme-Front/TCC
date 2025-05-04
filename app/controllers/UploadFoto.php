<?php
class UploadFotoController {
    public function upload() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_usuario'])) {
            header('Location: /perfil');
            exit();
        }

        // Verificar CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['erro'] = 'Token de segurança inválido';
            header('Location: /perfil');
            exit();
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            
            if (in_array($extensao, $extensoesPermitidas)) {
                $pastaUpload = __DIR__ . '/../../public/uploads/';
                $nomeArquivo = 'perfil_' . $_SESSION['id_usuario'] . '.' . $extensao;
                $caminhoCompleto = $pastaUpload . $nomeArquivo;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
                    // Atualizar no banco de dados (implementar no ClienteModel)
                    $_SESSION['foto_perfil'] = '/uploads/' . $nomeArquivo;
                    $_SESSION['sucesso'] = 'Foto atualizada com sucesso!';
                } else {
                    $_SESSION['erro'] = 'Erro ao salvar a foto';
                }
            } else {
                $_SESSION['erro'] = 'Formato de arquivo não permitido';
            }
        } else {
            $_SESSION['erro'] = 'Nenhuma foto enviada ou erro no upload';
        }

        header('Location: /perfil');
        exit();
    }
}
?>
<?php
// lista usuários do CSV e retorna JSON

$usuarios = [];
if (($handle = fopen("../usuarios.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $usuarios[] = [
            "usuario" => $data[0],
            "email" => $data[1],
            "senha" => $data[2]
        ];
    }
    fclose($handle);<?php
    header("Content-Type: application/json; charset=UTF-8");
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['usuario'], $data['email'], $data['senha'])) {
        echo json_encode(["status" => "error", "mensagem" => "Dados incompletos"]);
        exit;
    }
    
    $usuario = trim($data['usuario']);
    $email = trim($data['email']);
    $senha = trim($data['senha']);
    
    $arquivoCSV = "usuarios.csv";
    
    if (!file_exists($arquivoCSV)) {
        echo json_encode(["status" => "error", "mensagem" => "Arquivo de usuários não encontrado"]);
        exit;
    }
    
    $usuarios = [];
    $handle = fopen($arquivoCSV, "r");
    if ($handle) {
        while (($linha = fgetcsv($handle, 1000, ";")) !== false) {
            if (count($linha) >= 3) {
                $usuarios[] = [
                    "usuario" => $linha[0],
                    "email" => $linha[1],
                    "senha" => $linha[2]
                ];
            }
        }
        fclose($handle);
    } else {
        echo json_encode(["status" => "error", "mensagem" => "Erro ao abrir arquivo de usuários"]);
        exit;
    }
    
    $usuarioEncontrado = null;
    foreach ($usuarios as $u) {
        if ($u["usuario"] === $usuario) {
            $usuarioEncontrado = $u;
            break;
        }
    }
    
    if (!$usuarioEncontrado) {
        echo json_encode(["status" => "nao_cadastrado", "mensagem" => "Usuário não cadastrado"]);
        exit;
    }
    
    if ($usuarioEncontrado["email"] !== $email) {
        echo json_encode(["status" => "erro_email", "mensagem" => "Email incorreto"]);
        exit;
    }
    
    if ($usuarioEncontrado["senha"] !== $senha) {
        echo json_encode(["status" => "erro_senha", "mensagem" => "Senha incorreta"]);
        exit;
    }
    
    // Login OK
    echo json_encode(["status" => "sucesso", "mensagem" => "Login realizado com sucesso"]);
    exit;
    ?>
    
}

header('Content-Type: application/json');
echo json_encode($usuarios);
?>

<?php
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

$usuarios = [];
if (file_exists($arquivoCSV)) {
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
    }
}

// Verifica duplicados
foreach ($usuarios as $u) {
    if ($u['usuario'] === $usuario) {
        echo json_encode(["status" => "erro", "mensagem" => "Usuário já cadastrado"]);
        exit;
    }
    if ($u['email'] === $email) {
        echo json_encode(["status" => "erro", "mensagem" => "Email já cadastrado"]);
        exit;
    }
}

// Adiciona novo usuário no CSV
$handle = fopen($arquivoCSV, "a");
if ($handle) {
    fputcsv($handle, [$usuario, $email, $senha], ";");
    fclose($handle);
    echo json_encode(["status" => "sucesso", "mensagem" => "Usuário cadastrado com sucesso"]);
} else {
    echo json_encode(["status" => "error", "mensagem" => "Erro ao abrir arquivo para salvar"]);
}

exit;
?>

<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

$usuario = $_POST['usuario'] ?? '';
$email = $_POST['email'] ?? '';
$senhaNova = $_POST['senhaNova'] ?? '';

if (!$usuario || !$email || !$senhaNova) {
  http_response_code(400);
  echo "Preencha todos os campos";
  exit;
}

$linhas = file("../usuarios.csv", FILE_IGNORE_NEW_LINES);
$achou = false;

foreach ($linhas as $i => $linha) {
  $dados = str_getcsv($linha, ";");
  if ($dados[0] === $usuario && $dados[1] === $email) {
    $dados[2] = $senhaNova;
    $linhas[$i] = implode(";", $dados);
    $achou = true;
    break;
  }
}

if (!$achou) {
  http_response_code(404);
  echo "Usuário ou email não encontrados";
  exit;
}

file_put_contents("../usuarios.csv", implode("\n", $linhas));
echo "ok";
?>

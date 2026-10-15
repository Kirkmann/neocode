<?php
require_once "config.php";

// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");

// Inicia a sessão para verificar autenticação
session_start();
if (!isset($_SESSION['user']['id'])) {
    exit(json_encode(["status" => "erro", "mensagem" => "Não autenticado. Faça login novamente."]));
}

// Recebe e valida os dados enviados
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["id"]) || !isset($data["codigo"])) {
    exit(json_encode(["status" => "erro", "mensagem" => "Dados inválidos. Selecione um desafio e insira um código."]));
}

$desafio_id = intval($data["id"]);
$codigo = trim($data["codigo"]);
$utilizador_id = $_SESSION['user']['id'];

// Verifica se o Node.js está instalado
$node_version = shell_exec("node --version 2>&1");
if (strpos($node_version, "command not found") !== false || empty($node_version)) {
    exit(json_encode(["status" => "erro", "mensagem" => "Node.js não    está instalado."]));
}

// Busca dados do desafio
$stmt = $conn->prepare("SELECT codigo_base, resposta_esperada, tipo_resposta FROM desafios WHERE id = ?");
$stmt->execute([$desafio_id]);
$desafio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$desafio) {
    exit(json_encode(["status" => "erro", "mensagem" => "Desafio não encontrado."]));
}

// Prepara o código final
$codigo_base = $desafio["codigo_base"];
$codigo_final = $codigo_base;

// Substitui o placeholder pelo código submetido
$codigo_final = preg_replace('/\/\/\s*return\s*/', $codigo . ';', $codigo_final);

// Extrai o nome da função
preg_match('/function\s+(\w+)\s*\(/', $codigo_base, $matches);
$nome_funcao = $matches[1] ?? null;

// Adiciona chamada de teste
if ($desafio["tipo_resposta"] === "resultado" && $nome_funcao) {
    if ($desafio_id === 2 || $desafio_id === 7) {
        $codigo_final .= "\nconsole.log({$nome_funcao}(2, 3));";
    } else {
        $argumento_teste = match ($desafio_id) {
            3, 8 => "4",
            4, 9 => '"hello"',
            5, 10 => "5",
            6, 11 => "7",
            default => '"hello"'
        };
        $codigo_final .= "\nconsole.log({$nome_funcao}($argumento_teste));";
    }
}

// Registra no debug.txt
$temp_dir = sys_get_temp_dir();
file_put_contents('debug.txt', "Código Submetido: $codigo\n", FILE_APPEND);
file_put_contents('debug.txt', "Código Final:\n$codigo_final\n", FILE_APPEND);
file_put_contents('debug.txt', "Caminho Temporário: $temp_dir\n", FILE_APPEND);

// Cria e executa o arquivo temporário
$file = tempnam($temp_dir, "code_") . ".js";
if ($file === false) {
    exit(json_encode(["status" => "erro", "mensagem" => "Falha ao criar arquivo temporário. Verifique as permissões de $temp_dir."]));
}
file_put_contents($file, $codigo_final);
$output = shell_exec("node " . escapeshellarg($file) . " 2>&1");
unlink($file);

file_put_contents('debug.txt', "Output: $output\n", FILE_APPEND);

// Trata erros de execução
if (strpos($output, "Error") !== false || empty($output)) {
    $error_message = (strpos($output, "ReferenceError") !== false)
        ? "Erro: Variável não definida. Use 'num' ou 'str' conforme o desafio."
        : "Erro na execução. Verifique a sintaxe.";
    exit(json_encode(["status" => "erro", "mensagem" => $error_message, "resultado" => $output, "esperado" => $desafio["resposta_esperada"]]));
}

// Normaliza resultados
$resultado = trim($output);
$esperado = trim($desafio["resposta_esperada"]);

// Ajusta para booleanos
if (in_array($esperado, ["true", "false"])) {
    $resultado = ($resultado === "true" || $resultado === "1") ? "true" : "false";
}

file_put_contents('debug.txt', "Resultado: $resultado\nEsperado: $esperado\n", FILE_APPEND);

// Verifica e registra a submissão
$correto = ($resultado === $esperado);
$stmt = $conn->prepare("INSERT INTO submissoes (utilizador_id, desafio_id, codigo_enviado, status, pontuacao, tempo_execucao) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$utilizador_id, $desafio_id, $codigo, $correto ? "correto" : "errado", $correto ? 100 : 0, 0]);

// Retorna resposta
echo json_encode([
    "status" => $correto ? "sucesso" : "erro",
    "mensagem" => $correto ? "Correto! 🎉" : "Errado. Tenta outra vez!",
    "resultado" => $resultado,
    "esperado" => $esperado
]);
?>
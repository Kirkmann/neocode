<?php
require_once "config.php";

// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");

// Seleciona um desafio aleatório da tabela desafios
$stmt = $conn->query("SELECT id, titulo, descricao, codigo_base FROM desafios ORDER BY RAND() LIMIT 1");
$desafio = $stmt->fetch(PDO::FETCH_ASSOC);

// Retorna o desafio como JSON
echo json_encode($desafio);
?>
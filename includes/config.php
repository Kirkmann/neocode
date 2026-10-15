<?php
$host = "localhost"; // Endereço do servidor da base de dados
$dbname = "neocode"; // Nome da base de dados
$username = "root"; // Nome de usuário da base de dados
$password = ""; // Senha da base de dados (não existe   )

// Tenta estabelecer uma conexão com a base de dados usando PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Define o modo de erro do PDO para lançar exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se houver erro na conexão, exibe a mensagem de erro e encerra o script
    die("Erro de conexão: " . $e->getMessage());
}
?>  
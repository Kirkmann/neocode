<?php
session_start();
require_once __DIR__ . "/config.php";

// Função para o login do utilizador
function login($email, $senha) {
    // Acessa a conexão com a base de dados definida em config.php
    global $conn;
    // Prepara uma consulta para buscar o utilizador pelo e-mail
    $stmt = $conn->prepare("SELECT * FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);
    // Obtém os dados do utilizador como um array associativo
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o utilizador existe e se a senha está correta
    if ($user && password_verify($senha, $user["senha"])) {
        // Armazena informações do utilizador na sessão
        $_SESSION["user"] = ["id" => $user["id"], "nome" => $user["nome"]];
        
        // Retorna sucesso com a página de redirecionamento
        return [
            "status" => "sucesso",
            "redirect" => "../pages/jogo.php"
        ];
    } else {
        // Retorna erro se as credenciais estiverem incorretas
        return [
            "status" => "erro",
            "mensagem" => "E-mail ou senha incorretos!"
        ];
    }
}

// Função para registrar um novo utilizador
function registar($nome, $email, $senha) {
    // Acessa a conexão com a base de dados
    global $conn;
    // Verifica se o e-mail já está registrado
    $stmt = $conn->prepare("SELECT * FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);

    // Se o e-mail já existe, define uma mensagem de erro
    if ($stmt->rowCount() > 0) {
        $_SESSION["erro_registo"] = "E-mail já registado!";
        header("Location: ../auth/registo.php");
        exit();
    }

    // Criptografa a senha usando o algoritmo padrão
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    // Prepara a inserção dos dados do novo utilizador
    $stmt = $conn->prepare("INSERT INTO utilizadores (nome, email, senha) VALUES (?, ?, ?)");

    // Se a inserção for bem-sucedida, redireciona para a página de login
    if ($stmt->execute([$nome, $email, $senhaHash])) {
        $_SESSION["sucesso_registo"] = "Registo realizado com sucesso! Faça login.";
        header("Location: ../auth/login.php");
        exit();
    } else {
        // Se houver erro na inserção, define uma mensagem de erro
        $_SESSION["erro_registo"] = "Erro ao registar!";
        header("Location: ../auth/registo.php");
        exit();
    }
}

// Função para verificar se o utilizador está logado
function verificarLogin() {
    // Se não houver um utilizador na sessão, redireciona para a página de login
    if (!isset($_SESSION["user"])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

// Função para encerrar a sessão do utilizador
function logout() {
    // Destrói todos os dados da sessão
    session_destroy();
    // Redireciona para a página inicial
    header("Location: ../pages/index.php");
    exit();
}
?>
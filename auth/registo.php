<?php
require_once "../includes/auth.php";

// Verifica se o método da requisição é POST (formulário enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém e limpa os dados do formulário
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    // Chama a função de registro para criar um novo usuário
    registar($nome, $email, $senha); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="../img/neocode.ico">
    <title>Registo</title>
    <link rel="stylesheet" href="../css/style_auth.css">
</head>
<body>
<div class="container">
    <h1>Registar</h1>

    <!-- Exibe mensagem de erro ou sucesso do registro, se houver -->
    <?php
    if (isset($_SESSION["erro_registo"])) {
        // Exibe mensagem de erro em vermelho
        echo "<p style='color: red;'>" . $_SESSION["erro_registo"] . "</p>";
        // Remove a mensagem de erro da sessão
        unset($_SESSION["erro_registo"]);
    }
    if (isset($_SESSION["sucesso_registo"])) {
        // Exibe mensagem de sucesso em verde
        echo "<p style='color: green;'>" . $_SESSION["sucesso_registo"] . "</p>";
        // Remove a mensagem de sucesso da sessão
        unset($_SESSION["sucesso_registo"]);
    }
    ?>

    <form method="POST">

        <label for="nome">Nome:</label> <br>
        <input type="text" name="nome" required>
        <br><br>

        <label for="email">E-mail:</label> <br>
        <input type="email" name="email" required>
        <br><br>

        <label for="senha">Senha:</label> <br>
        <input type="password" name="senha" required>
        <br><br>

        <button type="submit">Registar</button>

        <button onclick="window.location.href='../pages/index.php'">Menu</button>
    </form>

    <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
</div>
</body>
</html>
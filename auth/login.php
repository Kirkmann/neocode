<?php
require_once "../includes/auth.php";

// Inicializa uma variável para armazenar mensagens de erro
$erro = "";

// Verifica se o método da requisição é POST (formulário enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtém e limpa os dados de e-mail e senha do formulário
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    
    // Chama a função login para autenticar o utilizador
    $resposta = login($email, $senha);

    // Se o login for bem-sucedido, redireciona para a página jogo.php
    if ($resposta["status"] === "sucesso") {
        header("Location: " . $resposta["redirect"]);
        exit();
    } else {
        // Se houver erro, armazena a mensagem de erro para exibição
        $erro = $resposta["mensagem"];
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="../img/neocode.ico">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style_auth.css">
</head>
<body>
<div class="container">
    <h1>Login</h1>

    <!-- Exibe mensagem de erro, se houver -->
    <?php if (!empty($erro)) { ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php } ?>

    <form method="POST">

        <label for="email">E-mail:</label> <br>
        <input type="email" name="email" required>   
        <br><br>

        <label for="senha">Senha:</label> <br>
        <input type="password" name="senha" required>
        <br><br>

        <button type="submit">Entrar</button>
        <button onclick="window.location.href='../pages/index.php'">Menu</button>
    </form>
    
    <p>Não tem uma conta? <a href="registo.php">Faça registo</a></p>
</div>
</body>
</html>
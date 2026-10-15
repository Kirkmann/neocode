<?php
// Inicia a sessão para verificar o utilizador logado
session_start();
$logado = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="../img/neocode.ico">
    <title>NeoCode</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
    <div class="header">
        <h1>NeoCode</h1>
        <div>
            <!-- Exibe informações do utilizador logado ou links de login/registo -->
            <?php if ($logado): ?>
                <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user']['nome']); ?>!</span>
                <a href="../auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="../auth/registo.php">Registo</a> | <a href="../auth/login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <!-- Descrição do site -->
        <p>Responde a desafios de programação e ganha pontos pela tua eficiência e rapidez.</p>
        <!-- Links para as páginas principais -->
        <a href="<?php echo $logado ? 'jogo.php' : '../auth/login.php'; ?>" class="btn">Começar o Desafio</a>
        <a href="ranking.php" class="btn">Ver Ranking</a>
        <a href="testar.php" class="btn">Teste JS</a>
    </div>

    <!-- Inclui o JavaScript para efeitos visuais -->
    <script src="../js/script.js"></script>
    <script>
        window.onload = function() {
            createBinaryRain();
        };
    </script>
</body>
</html>
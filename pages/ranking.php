<?php
// Inicia a sessão para gerir o estado do utilizador logado
session_start();
// Inclui o ficheiro de configuração com a conexão à base de dados
require_once "../includes/config.php";

// Executa uma consulta SQL para obter o ranking dos utilizadores, somando os pontos das submissões
$stmt = $conn->query("
    SELECT u.nome, SUM(s.pontuacao) as total_pontos
    FROM utilizadores u
    LEFT JOIN submissoes s ON u.id = s.utilizador_id
    GROUP BY u.id, u.nome
    ORDER BY total_pontos DESC
");
// Armazena todos os resultados da consulta num array associativo
$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica se existe um utilizador logado, armazenando o estado numa variável
$logado = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../img/neocode.ico">
    <title>Ranking - Neocode</title>
    <link rel="stylesheet" href="../css/style_ranking.css">
    <script src="../js/script.js"></script>
</head>
<body>
    <div class="container">
        <h1>Ranking - Coding Battle</h1>
        
        <table class="ranking-table">
            <thead>
                <tr>
                    <th>Posição</th>
                    <th>Nome</th>
                    <th>Pontos</th>
                </tr>
            </thead>
            <!-- Corpo da tabela com os dados do ranking -->
            <tbody>
                <?php foreach ($ranking as $index => $row): ?>
                    <!-- Linha para cada utilizador no ranking -->
                    <tr>
                        <!-- Exibe a posição (índice + 1) -->
                        <td><?php echo $index + 1; ?>º</td>
                        <!-- Exibe o nome do utilizador, protegido contra XSS -->
                        <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        <!-- Exibe a pontuação total, com 0 como padrão se nula -->
                        <td><?php echo $row['total_pontos'] ?? 0; ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($ranking)): ?>
                    <!-- Mensagem exibida se não houver dados no ranking -->
                    <tr>
                        <td colspan="3" style="text-align: center;">Ainda não há pontuações registadas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Link para voltar à página inicial -->
        <a href="../pages/index.php" class="back-link">Voltar ao Menu</a>
        
        <!-- Exibe informações do utilizador ou links de autenticação -->
        <?php if ($logado): ?>
            <!-- Caso o utilizador esteja logado, mostra o nome e link de logout -->
            <p>Está logado como: <?php echo htmlspecialchars($_SESSION['user']['nome']); ?> | <a href="../auth/logout.php">Logout</a></p>
        <?php else: ?>
            <!-- Caso não esteja logado, mostra links para login e registo -->
            <p><a href="../auth/login.php">Login</a> | <a href="../auth/registo.php">Registo</a></p>
        <?php endif; ?>
    </div>
</body>
</html>
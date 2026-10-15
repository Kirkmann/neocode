<?php
require_once "../includes/auth.php";
// Verifica se o utilizador está logado
verificarLogin();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="../img/neocode.ico">
    <title>Jogo - Coding Battle</title>
    <link rel="stylesheet" href="../css/style2.css">
    <!-- Inclui o Monaco Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.36.1/min/vs/loader.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Neocode</h1>
        <div id="desafio">
            <!-- Exibe o desafio -->
            <h2>Desafio:</h2>
            <p id="descricaoDesafio">Carregando desafio...</p>
            <!-- Instruções para o utilizador -->
            <p><strong>Instruções:</strong> Escreva seu código apagando todo o texto que tiver no editor. Apaga o "function" se não, não irá funcionar. Usa a função "return" para enviares o teu desafio.</p>
            <!-- Link para tutorial de JavaScript -->
            <p><strong>Alguma dúvida sobre JS?</strong> entre neste link do w3schools: <a href="https://www.w3schools.com/js/" target="_blank"> Tutorial de JavaScript </a></p>
        </div>
        
        <!-- Contêiner para o editor de código -->
        <div id="editorContainer" style="height: 300px;"></div>
        
        <button onclick="enviarCodigo()">Enviar Código</button>
        <button onclick="location.reload()">Outro desafio</button>
        <button onclick="window.location.href='index.php'">Menu</button>
        
        <!-- Exibe o resultado da submissão -->
        <p id="resultado"></p>
    </div>
    
    <!-- Inclui o JavaScript para o editor e efeitos -->
    <script src="../js/script.js"></script>
    <script>
        window.onload = function() {
            createBinaryRain();
        };
    </script>
</body>
</html>
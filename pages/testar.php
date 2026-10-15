<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="imagex/png" href="../img/neocode.ico">
    <title>Testador de Scripts JavaScript</title>
    <link rel="stylesheet" href="../css/style2.css">
    <!-- Inclui o Monaco Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.36.1/min/vs/loader.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Testador de Scripts JavaScript</h1>
        
        <!-- Instruções para o utilizador -->
        <p>Instruções: Escreva seu código no lugar do comentário. De seguida clique no botão "Executar".</p>
        
        <!-- Contêiner para o editor de código -->
        <div id="editorContainer" style="height: 300px;"></div>
        
        <button onclick="runCode()">Executar</button>
        <button onclick="window.location.href='index.php'">Menú</button>
        
        <!-- Exibe a saída do código -->
        <p>Resultado: <span id="output"></span></p>
        <!-- Exibe erros do código -->
        <p id="error" style="color: red;"></p>
    </div>
    
    <!-- Inclui o JavaScript para o editor e efeitos -->
    <script src="../js/scriptteste.js"></script>
    <script>
        window.onload = function() {
            createBinaryRain();
        };
    </script>
</body>
</html>
function createBinary() {
    // Cria um elemento span para exibir um dígito binário (0 ou 1)
    const binary = document.createElement("span");
    binary.classList.add("binary");
    binary.textContent = Math.random() > 0.5 ? "1" : "0";
    binary.style.setProperty("--x", Math.random());
    binary.style.setProperty("--duration", `${Math.random() * 3 + 2}s`);
    document.body.appendChild(binary);
    
    // Remove o elemento após 5 segundos
    setTimeout(() => binary.remove(), 5000);
}
// Executa createBinary a cada 100ms para criar efeito de chuva binaria
setInterval(createBinary, 100);

// Configura o caminho para o Monaco Editor
require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.36.1/min/vs' }});

let desafioAtual = {}; // Armazena o desafio atual carregado

function iniciarEditor(codigoBase) {
    // Inicializa o Monaco Editor com o código base do desafio
    require(['vs/editor/editor.main'], function() {
        window.editor = monaco.editor.create(document.getElementById('editorContainer'), {
            value: codigoBase || "// return...",
            language: "javascript",
            theme: "vs-dark",
            automaticLayout: true
        });
    });
}

function carregarDesafio() {
    // Faz uma requisição para obter um desafio aleatório
    fetch("../includes/obter_desafio.php")
        .then(response => response.json())
        .then(data => {
            if (!data.id) throw new Error("Desafio inválido!");
            
            desafioAtual = data; // Armazena os dados do desafio
            // Exibe o título e descrição do desafio
            document.getElementById("descricaoDesafio").textContent = `${data.titulo}: ${data.descricao}`;
            
            // Inicializa o editor com o código base
            iniciarEditor(data.codigo_base); 
        })
        .catch(error => console.error("Erro ao carregar o desafio:", error));
}

function enviarCodigo() {
    // Verifica se há um desafio carregado
    if (!desafioAtual.id) {
        console.error("Nenhum desafio carregado!");
        return;
    }

    // Obtém o código do editor
    const codigo = window.editor.getValue();

    // Envia o código para validação
    fetch("../includes/validar_codigo.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: desafioAtual.id, codigo: codigo })
    })
    .then(response => response.json())
    .then(data => {
        // Exibe a mensagem de resultado
        document.getElementById("resultado").textContent = data.mensagem;
    })
    .catch(error => console.error("Erro ao enviar código:", error));
}

// Carrega o desafio quando a página é carregada
document.addEventListener("DOMContentLoaded", carregarDesafio);
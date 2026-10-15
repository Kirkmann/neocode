// Configura o caminho para o Monaco Editor
require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.36.1/min/vs' } });
// Inicializa o Monaco Editor
require(['vs/editor/editor.main'], function() {
    window.editor = monaco.editor.create(document.getElementById('editorContainer'), {
        value: '// Escreve o teu código aqui',
        language: 'javascript',
        theme: 'vs-dark',
        automaticLayout: true
    });

    // Obtém elementos para exibir saída e erros
    const outputElement = document.getElementById('output');
    const errorElement = document.getElementById('error');
    // Redefine console.log para exibir no elemento de saída
    console.log = function(message) {
        outputElement.textContent += message + '\n';
    };

    // Função para executar o código no editor
    window.runCode = function() {
        outputElement.textContent = '';
        errorElement.textContent = '';
        const code = window.editor.getValue();
        try {
            eval(code); // Executa o código
        } catch (error) {
            errorElement.textContent = 'Erro: ' + error.message; // Exibe erros
        }
    };
});

// Cria um elemento span para exibir um dígito binário (0 ou 1)
function createBinary() {
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
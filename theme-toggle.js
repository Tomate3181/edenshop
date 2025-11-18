document.addEventListener('DOMContentLoaded', () => {
    const themeToggleButton = document.getElementById('theme-toggle-btn');
    const body = document.body;
    
    // Verifica se o botão de tema realmente existe na página
    if (themeToggleButton) {
        const themeIcon = themeToggleButton.querySelector('i');

        // Função para aplicar o tema (seja no carregamento da página ou na troca)
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                body.classList.remove('dark-mode');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        };

        // Verifica o tema salvo no localStorage quando a página carrega
        // Usa 'light' como padrão se nada for encontrado
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        // Adiciona o evento de clique ao botão
        themeToggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Verifica qual tema está ativo no momento e define o novo tema
            const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Aplica o novo tema visualmente
            applyTheme(newTheme);

            // Salva a preferência do usuário no localStorage para persistir a escolha
            localStorage.setItem('theme', newTheme);
        });
    }
});
// search.js

document.addEventListener('DOMContentLoaded', () => {
    const searchIconBtn = document.getElementById('search-icon-btn');
    const searchBar = document.getElementById('search-bar');

    // Verifica se os elementos da busca existem na página atual
    if (searchIconBtn && searchBar) {
        
        // 1. Evento de clique no ícone da lupa
        searchIconBtn.addEventListener('click', (event) => {
            event.preventDefault(); // Impede a navegação padrão do link

            // Ativa a classe 'active', que fará o input aparecer via CSS
            searchBar.classList.toggle('active');

            // Se a barra de busca se tornou ativa, foca nela para o usuário digitar
            if (searchBar.classList.contains('active')) {
                searchBar.focus();
            }
        });

        // 2. (Opcional, mas recomendado) Fechar a busca ao clicar fora dela
        document.addEventListener('click', (event) => {
            const isClickInsideSearch = event.target.closest('.search-container');
            
            // Se o clique NÃO foi dentro do container da busca e a busca está ativa, esconde ela.
            if (!isClickInsideSearch && searchBar.classList.contains('active')) {
                searchBar.classList.remove('active');
            }
        });

        // 3. Funcionalidade de busca (preparação para o back-end)
        // Quando o usuário pressionar "Enter" na barra de busca...
        searchBar.addEventListener('keyup', (event) => {
            if (event.key === 'Enter') {
                const searchTerm = searchBar.value.trim(); // Pega o valor e remove espaços extras

                if (searchTerm) {
                    // Redireciona para a página de produtos com o termo como um parâmetro de URL
                    // Exemplo: products.html?search=monstera
                    // Isso permitirá que seu PHP (futuramente) leia o que foi buscado.
                    window.location.href = `products.html?search=${encodeURIComponent(searchTerm)}`;
                }
            }
        });
    }
});
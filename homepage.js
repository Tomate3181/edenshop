document.addEventListener('DOMContentLoaded', () => {

    // Lógica da Animação de Scroll
    // Seleciona todos os elementos que devem ser animados
    const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');

    // Cria um "observador" que reage quando um elemento entra na tela
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // Se o elemento estiver 10% visível na tela...
            if (entry.isIntersecting) {
                // ...adiciona a classe 'visible', que ativa a animação do CSS
                entry.target.classList.add('visible');
                // Opcional: para a animação acontecer só uma vez, paramos de "observar" o elemento
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1 // A animação começa quando 10% do elemento estiver visível
    });

    // Pede ao observador para "observar" cada um dos elementos selecionados
    elementsToAnimate.forEach(element => {
        observer.observe(element);
    });

});
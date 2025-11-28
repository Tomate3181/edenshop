document.addEventListener('DOMContentLoaded', () => {

    // Lógica da Animação de Scroll
    const elementsToAnimate = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.03
    });

    elementsToAnimate.forEach(element => {
        observer.observe(element);
    });

});
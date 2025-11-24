document.addEventListener('DOMContentLoaded', function () {
    // === Sidebar Toggle (Mobile) ===
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mainContent = document.querySelector('.main-content');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        }
    });

    // === Navigation (SPA Feel) ===
    const navLinks = document.querySelectorAll('.sidebar-nav a[data-section]');
    const sections = document.querySelectorAll('.admin-section');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();

            // Remove active class from all links and sections
            navLinks.forEach(l => l.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));

            // Add active class to clicked link
            link.classList.add('active');

            // Show target section
            const targetId = link.getAttribute('data-section');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
            }

            // Close sidebar on mobile after selection
            if (window.innerWidth <= 992) {
                sidebar.classList.remove('active');
            }
        });
    });

    // === Charts Configuration ===

    // Colors
    const primaryGreen = '#6B8E23';
    const lightGreen = '#AEC670';
    const darkText = '#2F4F4F';
    const goldAccent = '#DAA520';

    // Sales Chart (Line)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: ['Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'],
            datasets: [{
                label: 'Vendas (R$)',
                data: [8500, 9200, 10500, 9800, 11200, 12450],
                borderColor: primaryGreen,
                backgroundColor: 'rgba(107, 142, 35, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: primaryGreen,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Categories Chart (Doughnut)
    const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(ctxCategories, {
        type: 'doughnut',
        data: {
            labels: ['Interior', 'Exterior', 'Suculentas', 'Flores'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: [
                    primaryGreen,
                    lightGreen,
                    goldAccent,
                    darkText
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // === Form Handling (Simulation) ===
    const addProductForm = document.getElementById('addProductForm');
    if (addProductForm) {
        addProductForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Simulate processing
            const submitBtn = addProductForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;

            submitBtn.innerText = 'Salvando...';
            submitBtn.disabled = true;

            setTimeout(() => {
                alert('Produto cadastrado com sucesso! (Simulação)');
                addProductForm.reset();
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }
});

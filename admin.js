document.addEventListener('DOMContentLoaded', function () {
    // === Sidebar Toggle (Mobile) ===
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

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

            navLinks.forEach(l => l.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));

            link.classList.add('active');

            const targetId = link.getAttribute('data-section');
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
            }

            if (window.innerWidth <= 992) {
                sidebar.classList.remove('active');
            }
        });
    });

    // === Charts Configuration ===
    const primaryGreen = '#6B8E23';
    const lightGreen = '#AEC670';
    const darkText = '#2F4F4F';
    const goldAccent = '#DAA520';

    // Processar dados de vendas mensais do PHP
    const mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    let labelsVendas = [];
    let dadosVendas = [];

    if (typeof vendasMensais !== 'undefined' && vendasMensais.length > 0) {
        vendasMensais.forEach(item => {
            const [ano, mes] = item.mes.split('-');
            labelsVendas.push(mesesNomes[parseInt(mes) - 1]);
            dadosVendas.push(parseFloat(item.total));
        });
    } else {
        // Dados padrão se não houver vendas
        labelsVendas = ['Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'];
        dadosVendas = [0, 0, 0, 0, 0, 0];
    }

    // Sales Chart (Line)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: labelsVendas,
            datasets: [{
                label: 'Vendas (R$)',
                data: dadosVendas,
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

    // Processar dados de categorias do PHP
    let labelsCategorias = [];
    let dadosCategorias = [];

    if (typeof categoriasVendidas !== 'undefined' && categoriasVendidas.length > 0) {
        categoriasVendidas.forEach(item => {
            labelsCategorias.push(item.nome_categoria);
            dadosCategorias.push(parseInt(item.total_vendas));
        });
    } else {
        // Dados padrão se não houver vendas
        labelsCategorias = ['Sem dados'];
        dadosCategorias = [1];
    }

    // Categories Chart (Doughnut)
    const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(ctxCategories, {
        type: 'doughnut',
        data: {
            labels: labelsCategorias,
            datasets: [{
                data: dadosCategorias,
                backgroundColor: [
                    primaryGreen,
                    lightGreen,
                    goldAccent,
                    darkText,
                    '#8FBC8F'
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

    // === Carregar Usuários do Banco de Dados ===
    function loadUsers() {
        fetch('php/admin_get_users.php')
            .then(response => response.json())
            .then(users => {
                const tbody = document.getElementById('users-table-body');
                tbody.innerHTML = '';

                users.forEach(user => {
                    const inicial = user.nome.charAt(0).toUpperCase();
                    const badgeClass = user.tipo === 'admin' ? 'badge-admin' : 'badge-cliente';

                    const row = `
                        <tr>
                            <td>#${String(user.id).padStart(3, '0')}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar-sm">${inicial}</div>
                                    ${user.nome}
                                </div>
                            </td>
                            <td>${user.email}</td>
                            <td><span class="badge ${badgeClass}">${user.tipo}</span></td>
                            <td>${user.data_cadastro}</td>
                            <td>
                                <button class="action-btn edit" onclick="editUser(${user.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" onclick="deleteUser(${user.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Erro ao carregar usuários:', error);
            });
    }

    // Carregar usuários quando a seção de usuários for aberta
    const usersLink = document.querySelector('a[data-section="users"]');
    if (usersLink) {
        usersLink.addEventListener('click', loadUsers);
    }

    // === Adicionar Novo Usuário ===
    const addUserBtn = document.getElementById('add-user-btn');
    if (addUserBtn) {
        addUserBtn.addEventListener('click', () => {
            const nome = prompt('Nome do usuário:');
            if (!nome) return;

            const email = prompt('Email do usuário:');
            if (!email) return;

            const senha = prompt('Senha do usuário:');
            if (!senha) return;

            const tipo = confirm('É administrador? (OK = Sim, Cancelar = Não)') ? 'admin' : 'cliente';

            const formData = new FormData();
            formData.append('nome', nome);
            formData.append('email', email);
            formData.append('senha', senha);
            formData.append('tipo', tipo);

            fetch('php/admin_add_user.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Sucesso!', text: 'Usuário criado com sucesso!', confirmButtonColor: '#6b8e23' });
                        loadUsers();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro: ' + data.error, confirmButtonColor: '#6b8e23' });
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao criar usuário', confirmButtonColor: '#6b8e23' });
                });
        });
    }

    // === Busca de Usuários ===
    const userSearch = document.getElementById('user-search');
    if (userSearch) {
        userSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#users-table-body tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    // Carregar plantas quando a seção for aberta
    const managePlantsLink = document.querySelector('a[data-section="manage-plants"]');
    if (managePlantsLink) {
        managePlantsLink.addEventListener('click', loadPlants);
    }

    // Busca de plantas
    const plantSearch = document.getElementById('plant-search');
    if (plantSearch) {
        plantSearch.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#plants-table-body tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // === Cancelar Edição / Limpar Formulário ===
    const cancelBtn = document.getElementById('cancel-edit-btn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            const form = document.getElementById('addProductForm');

            // Limpar campos do formulário
            form.reset();

            // Remover ID oculto se existir (sair do modo edição)
            const hiddenId = document.getElementById('edit-plant-id');
            if (hiddenId) {
                hiddenId.remove();
            }

            // Resetar ação do formulário
            form.action = 'php/admin_add_product.php';

            // Resetar texto do botão de submit
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.textContent = 'Cadastrar Planta';

            Swal.fire({
                icon: 'success',
                title: 'Formulário Limpo',
                text: 'Modo de edição cancelado. Você agora está no modo de cadastro.',
                timer: 2000,
                showConfirmButton: false,
                confirmButtonColor: '#6b8e23'
            });
        });
    }
});

// Funções globais para editar e deletar usuários
function editUser(id) {
    Swal.fire({ icon: 'info', title: 'Em Desenvolvimento', text: 'Funcionalidade de edição em desenvolvimento. ID: ' + id, confirmButtonColor: '#6b8e23' });
}

function deleteUser(id) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        Swal.fire({ icon: 'info', title: 'Em Desenvolvimento', text: 'Funcionalidade de exclusão em desenvolvimento. ID: ' + id, confirmButtonColor: '#6b8e23' });
    }
}


// ===== GERENCIAMENTO DE PLANTAS =====

// Carregar plantas
async function loadPlants() {
    try {
        const response = await fetch('php/admin_get_plants.php');
        const plants = await response.json();

        const tbody = document.getElementById('plants-table-body');
        if (!tbody) return;

        tbody.innerHTML = plants.map(plant => `
            <tr>
                <td>${plant.id_planta}</td>
                <td>${plant.nome_planta}</td>
                <td>${plant.nome_categoria || 'Sem categoria'}</td>
                <td>R$ ${parseFloat(plant.preco).toFixed(2).replace('.', ',')}</td>
                <td>${plant.quantidade_estoque}</td>
                <td>
                    <button class="action-btn edit-btn" onclick="editPlant(${plant.id_planta})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error('Erro ao carregar plantas:', error);
    }
}

// Editar planta
async function editPlant(id) {
    try {
        const response = await fetch(`php/admin_get_plant.php?id=${id}`);
        const plant = await response.json();

        if (plant.error) {
            Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar planta', confirmButtonColor: '#6b8e23' });
            return;
        }

        // Preencher formulário de edição
        document.getElementById('plantName').value = plant.nome_planta || '';
        document.getElementById('plantCategory').value = plant.id_categoria || '';
        document.getElementById('plantPrice').value = plant.preco || '';
        document.getElementById('plantStock').value = plant.quantidade_estoque || '';
        document.getElementById('plantImage').value = plant.imagem_url || '';
        document.getElementById('plantDescription').value = plant.descricao || '';
        document.getElementById('scientificName').value = plant.nomeCientifico || '';
        document.getElementById('plantFamily').value = plant.familia || '';
        document.getElementById('plantOrigin').value = plant.origem || '';
        document.getElementById('plantHeight').value = plant.alturaMedia || '';
        document.getElementById('petFriendly').value = plant.pet || 'Não tóxica';
        document.getElementById('careLight').value = plant.luz || '';
        document.getElementById('careWater').value = plant.agua || '';
        document.getElementById('careHumidity').value = plant.humidade || '';
        document.getElementById('careSoil').value = plant.solo || '';

        // Adicionar campo hidden com ID
        let hiddenId = document.getElementById('edit-plant-id');
        if (!hiddenId) {
            hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.id = 'edit-plant-id';
            hiddenId.name = 'id_planta';
            document.getElementById('addProductForm').appendChild(hiddenId);
        }
        hiddenId.value = id;

        // Mudar ação do formulário
        const form = document.getElementById('addProductForm');
        form.action = 'php/admin_update_plant.php';

        // Navegar para a seção de produtos
        const productsLink = document.querySelector('a[data-section="products"]');
        if (productsLink) productsLink.click();

        // Mudar texto do botão
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.textContent = 'Atualizar Planta';

        // Scroll para o topo do formulário
        form.scrollIntoView({ behavior: 'smooth' });

    } catch (error) {
        console.error('Erro ao editar planta:', error);
        Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar dados da planta', confirmButtonColor: '#6b8e23' });
    }
}

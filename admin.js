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

                    // Verifica se está ativo (se undefined, assume 1 para compatibilidade)
                    const isInactive = (user.ativo !== undefined && user.ativo == 0);
                    const rowStyle = isInactive ? 'style="opacity: 0.7; background-color: #f0f0f0;"' : '';
                    const statusBadge = isInactive ? '<span style="color: red; font-size: 0.8em; margin-left: 5px;">(Inativo)</span>' : '';
                    const toggleIcon = isInactive ? 'fa-check' : 'fa-ban';
                    const toggleTitle = isInactive ? 'Ativar Usuário' : 'Inativar Usuário';
                    const toggleColor = isInactive ? 'style="color: green;"' : 'style="color: red;"';

                    const row = `
                        <tr ${rowStyle}>
                            <td>#${String(user.id).padStart(3, '0')}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar-sm">${inicial}</div>
                                    ${user.nome} ${statusBadge}
                                </div>
                            </td>
                            <td>${user.email}</td>
                            <td><span class="badge ${badgeClass}">${user.tipo}</span></td>
                            <td>${user.data_cadastro}</td>
                            <td>
                                <button class="action-btn edit" onclick="editUser(${user.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" onclick="toggleUserStatus(${user.id}, ${isInactive})" title="${toggleTitle}" ${toggleColor}>
                                    <i class="fas ${toggleIcon}"></i>
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
            Swal.fire({
                title: 'Novo Usuário',
                html: `
                    <input id="swal-input-nome" class="swal2-input" placeholder="Nome">
                    <input id="swal-input-email" class="swal2-input" placeholder="Email" type="email">
                    <input id="swal-input-senha" class="swal2-input" placeholder="Senha" type="password">
                    <div style="margin-top: 15px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <input type="checkbox" id="swal-input-admin" style="width: auto; margin: 0;">
                        <label for="swal-input-admin" style="margin: 0;">É administrador?</label>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Criar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#6b8e23',
                cancelButtonColor: '#d33',
                preConfirm: () => {
                    const nome = document.getElementById('swal-input-nome').value;
                    const email = document.getElementById('swal-input-email').value;
                    const senha = document.getElementById('swal-input-senha').value;
                    const isAdmin = document.getElementById('swal-input-admin').checked;

                    if (!nome || !email || !senha) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos');
                        return false;
                    }

                    return { nome: nome, email: email, senha: senha, tipo: isAdmin ? 'admin' : 'cliente' };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { nome, email, senha, tipo } = result.value;

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
                }
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

    // === Interceptar Envio do Formulário de Produto (Update) ===
    const addProductForm = document.getElementById('addProductForm');
    if (addProductForm) {
        addProductForm.addEventListener('submit', function (e) {
            // Validação de Preço e Estoque Negativos
            const priceInput = document.getElementById('plantPrice');
            const stockInput = document.getElementById('plantStock');

            if (priceInput && parseFloat(priceInput.value) < 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Preço Inválido',
                    text: 'O preço do produto não pode ser negativo.',
                    confirmButtonColor: '#6b8e23'
                });
                return;
            }

            if (stockInput && parseInt(stockInput.value) < 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Estoque Inválido',
                    text: 'A quantidade em estoque não pode ser negativa.',
                    confirmButtonColor: '#6b8e23'
                });
                return;
            }

            // Se for atualização (admin_update_plant.php), usar AJAX
            if (this.action.includes('admin_update_plant.php')) {
                e.preventDefault();

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: data.message,
                                confirmButtonColor: '#6b8e23'
                            }).then(() => {
                                // Resetar formulário e recarregar lista
                                if (cancelBtn) cancelBtn.click(); // Usa o click do cancelar para limpar tudo
                                loadPlants();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.error || 'Erro ao atualizar planta',
                                confirmButtonColor: '#6b8e23'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Erro de conexão',
                            confirmButtonColor: '#6b8e23'
                        });
                    });
            }
        });
    }
    // === Check for URL Parameters (Success/Error) ===
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    const errorParam = urlParams.get('error');

    if (successParam === 'productadded') {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: 'Produto cadastrado com sucesso!',
            confirmButtonColor: '#6b8e23'
        });
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (errorParam === 'invaliddata') {
        Swal.fire({
            icon: 'error',
            title: 'Dados Inválidos',
            text: 'Por favor, verifique os dados preenchidos (preço ou estoque inválidos).',
            confirmButtonColor: '#6b8e23'
        });
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (errorParam === 'dberror') {
        Swal.fire({
            icon: 'error',
            title: 'Erro no Banco',
            text: 'Ocorreu um erro ao salvar no banco de dados.',
            confirmButtonColor: '#6b8e23'
        });
        window.history.replaceState({}, document.title, window.location.pathname);
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
// Carregar plantas
async function loadPlants() {
    try {
        const response = await fetch('php/admin_get_plants.php');
        const plants = await response.json();

        const tbody = document.getElementById('plants-table-body');
        if (!tbody) return;

        tbody.innerHTML = plants.map(plant => {
            const isInactive = plant.ativo == 0;
            const rowStyle = isInactive ? 'style="opacity: 0.7; background-color: #f0f0f0;"' : '';
            const statusBadge = isInactive ? '<span style="color: red; font-size: 0.8em; margin-left: 5px;">(Inativo)</span>' : '';
            const toggleIcon = isInactive ? 'fa-check' : 'fa-ban';
            const toggleTitle = isInactive ? 'Ativar Planta' : 'Inativar Planta';
            const toggleColor = isInactive ? 'style="color: green;"' : 'style="color: red;"';

            return `
            <tr ${rowStyle}>
                <td>${plant.id_planta}</td>
                <td>${plant.nome_planta} ${statusBadge}</td>
                <td>${plant.nome_categoria || 'Sem categoria'}</td>
                <td>R$ ${parseFloat(plant.preco).toFixed(2).replace('.', ',')}</td>
                <td>${plant.quantidade_estoque}</td>
                <td>
                    <button class="action-btn edit-btn" onclick="editPlant(${plant.id_planta})" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="action-btn delete-btn" onclick="togglePlantStatus(${plant.id_planta}, ${isInactive})" title="${toggleTitle}" ${toggleColor}>
                        <i class="fas ${toggleIcon}"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
    } catch (error) {
        console.error('Erro ao carregar plantas:', error);
    }
}

// Funções globais para editar e deletar usuários
function editUser(id) {
    // Buscar dados do usuário atual (simulação, ideal seria um endpoint get_user)
    // Como os dados já estão na tabela, podemos pegar de lá ou fazer um fetch.
    // Vamos fazer um fetch para garantir dados atualizados.

    // Nota: Precisaríamos de um endpoint admin_get_user.php?id=X
    // Como não temos, vamos pegar da linha da tabela por enquanto ou implementar o endpoint.
    // O ideal é implementar o endpoint. Vou assumir que vamos criar admin_get_user.php ou passar os dados via parametro.
    // Para simplificar e atender o pedido rápido, vou pegar os dados do DOM se possível, mas o ideal é o endpoint.
    // Vou criar o endpoint admin_get_user.php rapidinho depois.

    fetch(`php/admin_get_user.php?id=${id}`)
        .then(response => response.json())
        .then(user => {
            if (user.error) {
                Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar usuário' });
                return;
            }

            Swal.fire({
                title: 'Editar Usuário',
                html: `
                    <input id="swal-edit-nome" class="swal2-input" placeholder="Nome" value="${user.nome}">
                    <input id="swal-edit-email" class="swal2-input" placeholder="Email" type="email" value="${user.email}">
                    <div style="margin-top: 15px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <input type="checkbox" id="swal-edit-admin" style="width: auto; margin: 0;" ${user.tipo === 'admin' ? 'checked' : ''}>
                        <label for="swal-edit-admin" style="margin: 0;">É administrador?</label>
                    </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Salvar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#6b8e23',
                preConfirm: () => {
                    const nome = document.getElementById('swal-edit-nome').value;
                    const email = document.getElementById('swal-edit-email').value;
                    const isAdmin = document.getElementById('swal-edit-admin').checked;

                    if (!nome || !email) {
                        Swal.showValidationMessage('Por favor, preencha todos os campos');
                        return false;
                    }

                    return { id: id, nome: nome, email: email, tipo: isAdmin ? 'admin' : 'cliente' };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = result.value;

                    fetch('php/admin_update_user.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire({ icon: 'success', title: 'Sucesso', text: 'Usuário atualizado!', confirmButtonColor: '#6b8e23' });
                                // Recarregar tabela de usuários
                                const usersLink = document.querySelector('a[data-section="users"]');
                                if (usersLink) usersLink.click();
                            } else {
                                Swal.fire({ icon: 'error', title: 'Erro', text: response.error || 'Erro ao atualizar' });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro de conexão' });
                        });
                }
            });
        })
        .catch(error => {
            console.error('Erro ao buscar usuário:', error);
            Swal.fire({ icon: 'error', title: 'Erro', text: 'Erro ao carregar dados do usuário' });
        });
}

function deleteUser(id) {
    if (confirm('Tem certeza que deseja excluir este usuário?')) {
        Swal.fire({ icon: 'info', title: 'Em Desenvolvimento', text: 'Funcionalidade de exclusão em desenvolvimento. ID: ' + id, confirmButtonColor: '#6b8e23' });
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

// Deletar planta
// Alternar status do usuário (Ativar/Inativar)
function toggleUserStatus(id, isInactive) {
    const action = isInactive ? 'ativar' : 'inativar';
    const confirmText = isInactive ? 'O usuário poderá fazer login novamente.' : 'O usuário não poderá mais fazer login.';

    Swal.fire({
        title: `Tem certeza que deseja ${action}?`,
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: isInactive ? '#6b8e23' : '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: `Sim, ${action}!`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('php/admin_toggle_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.message,
                            confirmButtonColor: '#6b8e23'
                        });
                        loadUsers();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: data.error || 'Erro ao alterar status',
                            confirmButtonColor: '#6b8e23'
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro de conexão',
                        confirmButtonColor: '#6b8e23'
                    });
                });
        }
    });
}

// Alternar status da planta (Ativar/Inativar)
function togglePlantStatus(id, isInactive) {
    const action = isInactive ? 'ativar' : 'inativar';
    const confirmText = isInactive ? 'A planta voltará a aparecer na loja.' : 'A planta não aparecerá mais na loja.';

    Swal.fire({
        title: `Tem certeza que deseja ${action}?`,
        text: confirmText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: isInactive ? '#6b8e23' : '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: `Sim, ${action}!`,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('php/admin_toggle_plant.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.message,
                            confirmButtonColor: '#6b8e23'
                        });
                        loadPlants();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: data.error || 'Erro ao alterar status',
                            confirmButtonColor: '#6b8e23'
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Erro de conexão',
                        confirmButtonColor: '#6b8e23'
                    });
                });
        }
    });
}

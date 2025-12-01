# Script para substituir alerts por SweetAlert2

# script.js
$content = Get-Content "script.js" -Raw

$content = $content -replace "alert\('Por favor, preencha todos os campos.'\);", "Swal.fire({icon: 'warning', title: 'Atenção', text: 'Por favor, preencha todos os campos.', confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('Mensagem enviada com sucesso! Entraremos em contato em breve.'\);", "Swal.fire({icon: 'success', title: 'Mensagem Enviada!', text: 'Entraremos em contato em breve.', confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\(`Obrigado por se inscrever! Fique de olho em seu e-mail \$\{emailInput.value\} para receber nossas ofertas.`\);", "Swal.fire({icon: 'success', title: 'Inscrição Confirmada!', text: ``Fique de olho em seu e-mail `${emailInput.value} para receber nossas ofertas.``, confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('As senhas não coincidem. Por favor, tente novamente.'\);", "Swal.fire({icon: 'error', title: 'Erro', text: 'As senhas não coincidem. Por favor, tente novamente.', confirmButtonColor: '#6b8e23'});"

$content = $content -replace "setTimeout\(\(\) => alert\(errorMessage\), 100\);", "setTimeout(() => Swal.fire({icon: 'error', title: 'Erro no Login', text: errorMessage, confirmButtonColor: '#6b8e23'}), 100);"

Set-Content "script.js" $content

# checkout.js
$content = Get-Content "checkout.js" -Raw
$content = $content -replace "alert\('Seu carrinho está vazio!'\);", "Swal.fire({icon: 'warning', title: 'Carrinho Vazio', text: 'Seu carrinho está vazio!', confirmButtonColor: '#6b8e23'});"
Set-Content "checkout.js" $content

# admin.js
$content = Get-Content "admin.js" -Raw

$content = $content -replace "alert\('Usuário criado com sucesso!'\);", "Swal.fire({icon: 'success', title: 'Sucesso!', text: 'Usuário criado com sucesso!', confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('Erro: ' \+ data.error\);", "Swal.fire({icon: 'error', title: 'Erro', text: 'Erro: ' + data.error, confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('Erro ao criar usuário'\);", "Swal.fire({icon: 'error', title: 'Erro', text: 'Erro ao criar usuário', confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('Funcionalidade de edição em desenvolvimento. ID: ' \+ id\);", "Swal.fire({icon: 'info', title: 'Em Desenvolvimento', text: 'Funcionalidade de edição em desenvolvimento. ID: ' + id, confirmButtonColor: '#6b8e23'});"

$content = $content -replace "alert\('Funcionalidade de exclusão em desenvolvimento. ID: ' \+ id\);", "Swal.fire({icon: 'info', title: 'Em Desenvolvimento', text: 'Funcionalidade de exclusão em desenvolvimento. ID: ' + id, confirmButtonColor: '#6b8e23'});"

Set-Content "admin.js" $content

Write-Host "Substituições concluídas!"

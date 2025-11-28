# 🌿 Edenshop - E-commerce de Plantas

## 📖 Guia Rápido de Uso

### 🎯 Funcionalidades Implementadas

#### 1️⃣ **Perfil do Usuário** (`profile.php`)
**Como usar:**
- Faça login no sistema
- Clique no ícone de usuário no menu
- Acesse "Minha Conta"

**O que você pode fazer:**
- ✏️ **Editar Nome**: Altere seu nome de exibição
- 🔒 **Alterar Senha**: Mude sua senha de forma segura
  - Digite sua senha atual
  - Digite a nova senha
  - Confirme a nova senha

---

#### 2️⃣ **Página Inicial** (`index.php`)
**Produtos em Destaque:**
- 🌟 Veja até 8 produtos selecionados automaticamente
- 📦 Produtos com maior disponibilidade em estoque aparecem primeiro
- 🖱️ Clique em qualquer produto para ver detalhes
- 🛒 Adicione produtos ao carrinho diretamente

---

#### 3️⃣ **Página de Produtos** (`products.php`)
**Navegação:**
- 📋 Veja todos os produtos disponíveis
- 🔍 Filtre por categoria usando a barra lateral
- 🏷️ Categorias disponíveis:
  - Suculentas
  - Samambaias
  - Plantas de Sombra
  - Plantas de Sol Pleno
  - Plantas Pendentes
  - Frutíferas (Pequeno Porte)
  - Flores e Ornamentais

**Como filtrar:**
1. Selecione uma categoria na barra lateral
2. A página recarrega automaticamente com os produtos filtrados
3. Clique em "Todas as Categorias" para remover o filtro

---

#### 4️⃣ **Detalhes do Produto** (`product-detail.php`)
**Informações Disponíveis:**
- 📸 Imagem do produto
- 💰 Preço
- 📝 Descrição completa
- 📊 Quantidade em estoque

**Abas de Informação:**
1. **Descrição**: Informações gerais sobre a planta
2. **Cuidados**: Como cuidar da planta
   - ☀️ Luz necessária
   - 💧 Frequência de rega
   - 💨 Nível de umidade
   - 🌱 Tipo de solo
3. **Especificações**: Dados técnicos
   - 🔬 Nome científico
   - 🌿 Família botânica
   - 🌍 Origem
   - 📏 Altura média
   - 🐾 Toxicidade para pets

**Seletor de Quantidade:**
- Use os botões **+** e **-** para ajustar a quantidade
- O máximo é limitado pelo estoque disponível

---

## 🔧 Configuração Inicial

### Pré-requisitos:
1. ✅ XAMPP instalado e rodando
2. ✅ Apache e MySQL ativos
3. ✅ Banco de dados `bd_eden` criado
4. ✅ Arquivo `DB/bd_eden.sql` importado

### Passos para Configurar:

#### 1. Importar o Banco de Dados
```bash
# Acesse o phpMyAdmin
http://localhost/phpmyadmin

# Crie o banco de dados (se não existir)
CREATE DATABASE bd_eden;

# Importe o arquivo SQL
# Vá em: Importar > Escolher arquivo > DB/bd_eden.sql
```

#### 2. Verificar Conexão
Abra o arquivo `php/db_connect.php` e confirme:
```php
$host = 'localhost';
$dbname = 'bd_eden';
$username = 'root';
$password = '';  // Deixe vazio se não tiver senha
```

#### 3. Acessar o Sistema
```
http://localhost/edenshop/
```

---

## 👤 Testando o Sistema

### Criar uma Conta:
1. Acesse a página inicial
2. Clique em "Login" no menu
3. Clique em "Cadastre-se"
4. Preencha os dados e crie sua conta

### Fazer Login:
1. Clique em "Login" no menu
2. Digite seu email e senha
3. Clique em "Entrar"

### Navegar pelos Produtos:
1. Clique em "Produtos" no menu
2. Explore as categorias
3. Clique em um produto para ver detalhes

### Editar Perfil:
1. Faça login
2. Clique no ícone de usuário
3. Selecione "Minha Conta"
4. Edite seu nome ou senha

---

## 🐛 Solução de Problemas

### Problema: "Erro na conexão com o banco de dados"
**Solução:**
- Verifique se o MySQL está rodando no XAMPP
- Confirme que o banco `bd_eden` existe
- Verifique as credenciais em `php/db_connect.php`

### Problema: "Nenhum produto em destaque"
**Solução:**
- Verifique se o banco de dados foi importado corretamente
- Confirme que há produtos com `quantidade_estoque > 0`
- Execute: `SELECT * FROM plantas WHERE quantidade_estoque > 0;`

### Problema: Imagens não aparecem
**Solução:**
- Verifique se as URLs das imagens estão corretas no banco
- As imagens devem estar acessíveis online ou no servidor
- Verifique a coluna `imagem_url` na tabela `plantas`

### Problema: Não consigo alterar a senha
**Solução:**
- Certifique-se de digitar a senha atual corretamente
- A nova senha deve ter pelo menos 6 caracteres
- A nova senha e a confirmação devem ser idênticas

---

## 📊 Estrutura de Dados

### Produtos no Banco:
O banco contém **100 plantas** divididas em 7 categorias:
- 🌵 Suculentas e Cactos
- 🌿 Samambaias
- 🏠 Plantas de Sombra
- ☀️ Plantas de Sol Pleno
- 🪴 Plantas Pendentes
- 🍇 Frutíferas
- 🌺 Flores e Ornamentais

### Informações de Cada Produto:
- Nome comum e científico
- Preço
- Descrição
- Cuidados necessários
- Especificações botânicas
- Toxicidade para pets

---

## 🔐 Segurança

### Medidas Implementadas:
- ✅ Senhas criptografadas com `password_hash()`
- ✅ Proteção contra SQL Injection (PDO Prepared Statements)
- ✅ Proteção contra XSS (`htmlspecialchars()`)
- ✅ Validação de sessão em páginas protegidas
- ✅ Validação de inputs do usuário

---

## 📝 Notas Importantes

1. **Sessões**: Mantenha o navegador aberto para permanecer logado
2. **Estoque**: Produtos sem estoque não aparecem nas listagens
3. **Imagens**: URLs externas podem demorar para carregar
4. **Categorias**: Filtros são aplicados via URL (`?categoria=X`)
5. **Segurança**: Nunca compartilhe suas credenciais de acesso

---

## 🆘 Suporte

Em caso de dúvidas ou problemas:
1. Consulte a documentação completa em `DOCUMENTACAO_IMPLEMENTACAO.md`
2. Verifique os logs de erro do PHP
3. Confirme que o XAMPP está rodando corretamente

---

**Desenvolvido com ❤️ para o Edenshop**
**Versão**: 1.0
**Data**: 28 de Novembro de 2025

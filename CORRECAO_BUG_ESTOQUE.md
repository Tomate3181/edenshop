# Correção do Bug de Limite de Estoque no Carrinho

## Problema
Atualmente, o modal de carrinho não tem limite de quantos itens podem ser adicionados, mesmo que exista um estoque limitado no banco de dados.

## Solução Implementada

Para corrigir este bug, precisamos fazer 3 modificações:

### 1. Adicionar o atributo `data-stock` aos cards de produtos

**Arquivo: `products.php` (linha 100)**

Adicionar `data-stock="{$produto['quantidade_estoque']}"` ao div do product-card:

```php
<div
  class="product-card"
  data-id="p{$id}"
  data-name="{$nome}"
  data-price="{$produto['preco']}"
  data-image="{$imagem}"
  data-category="{$categoria}"
  data-stock="{$produto['quantidade_estoque']}"
>
```

**Arquivo: `product-detail.php` (linha 73-74)**

Adicionar `data-stock="<?= $produto['quantidade_estoque'] ?>"` ao div product-info:

```php
<div class="product-info" data-id="p<?= $produto_id ?>" data-name="<?= $nome ?>"
  data-price="<?= $produto['preco'] ?>" data-image="<?= $imagem ?>" data-category="<?= $categoria ?>"
  data-stock="<?= $produto['quantidade_estoque'] ?>">
```

### 2. Modificar o JavaScript para capturar e validar o estoque

**Arquivo: `script.js`**

#### a) Modificar a função `addToCart` (linhas 20-31):

```javascript
const addToCart = (product, quantity = 1) => {
    const cart = getCart();
    const existingItem = cart.find(item => item.id === product.id);
    
    // Calcular quantidade total que seria adicionada
    const currentQuantity = existingItem ? existingItem.quantity : 0;
    const newTotalQuantity = currentQuantity + quantity;
    
    // Verificar se há estoque disponível
    const availableStock = product.stock || Infinity;
    
    if (newTotalQuantity > availableStock) {
        // Mostrar alerta com SweetAlert2
        Swal.fire({
            icon: 'warning',
            title: 'Estoque Insuficiente',
            text: `Desculpe, temos apenas ${availableStock} unidade(s) disponível(is) deste produto.`,
            confirmButtonColor: '#2d5016'
        });
        return;
    }
    
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({ ...product, quantity });
    }
    saveCart(cart);
    updateCartIcon();
    openCartModal();
};
```

#### b) Modificar o event listener "Adicionar ao Carrinho" (linhas 288-307):

```javascript
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        const card = e.target.closest('.product-card, .product-info');
        const quantity = card.querySelector('#quantity') ? parseInt(card.querySelector('#quantity').value) : 1;
        const product = {
            id: card.dataset.id,
            name: card.dataset.name || card.querySelector('h1').textContent,
            price: parseFloat(card.dataset.price),
            image: card.dataset.image || card.querySelector('.main-image').src,
            stock: parseInt(card.dataset.stock) || Infinity, // ADICIONAR ESTA LINHA
        };
        addToCart(product, quantity);
        const originalText = button.textContent;
        button.textContent = 'Adicionado!';
        button.style.backgroundColor = '#DAA520';
        setTimeout(() => {
            button.textContent = originalText;
            button.style.backgroundColor = 'var(--primary-green)';
        }, 1500);
    });
});
```

#### c) Modificar a função `addCartEventListeners` (linhas 205-226):

```javascript
const addCartEventListeners = () => {
    cartItemsContainerModal.querySelectorAll('.remove-from-cart-btn').forEach(b => b.addEventListener('click', e => {
        let cart = getCart().filter(item => item.id !== e.target.dataset.id);
        saveCart(cart);
        displayCartItems();
        updateCartIcon();
    }));
    
    cartItemsContainerModal.querySelectorAll('.change-quantity-btn').forEach(b => b.addEventListener('click', e => {
        let cart = getCart();
        const item = cart.find(item => item.id === e.target.dataset.id);
        const change = parseInt(e.target.dataset.change);
        
        if (item) {
            const newQuantity = item.quantity + change;
            
            // Se estiver aumentando, verificar estoque
            if (change > 0 && item.stock) {
                if (newQuantity > item.stock) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Estoque Insuficiente',
                        text: `Desculpe, temos apenas ${item.stock} unidade(s) disponível(is) deste produto.`,
                        confirmButtonColor: '#2d5016'
                    });
                    return;
                }
            }
            
            item.quantity = newQuantity;
        }
        
        if (item.quantity < 1) {
            let newCart = getCart().filter(cartItem => cartItem.id !== item.id);
            saveCart(newCart);
        } else {
            saveCart(cart);
        }
        displayCartItems();
        updateCartIcon();
    }));
};
```

## Resultado

Após essas modificações:
- ✅ O sistema captura o estoque disponível do banco de dados
- ✅ Ao adicionar produtos ao carrinho, valida se há estoque suficiente
- ✅ No modal do carrinho, o botão "+" verifica o estoque antes de aumentar a quantidade
- ✅ Exibe um alerta amigável (SweetAlert2) quando o limite de estoque é atingido
- ✅ O usuário não pode adicionar mais itens do que o disponível em estoque

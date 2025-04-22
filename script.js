document.addEventListener('DOMContentLoaded', function() {
    // Menu page functionality
    if (document.querySelector('.menu-items')) {
        initializeMenuPage();
    }
    
    // Order form validation
    if (document.querySelector('.order-form')) {
        initializeOrderForm();
    }
});


function initializeMenuPage() {
    // Initialize cart from session
    updateCartDisplay();
    
    // Quantity controls
    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity');
            input.value = parseInt(input.value) + 1;
        });
    });
    
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
    
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            const itemId = menuItem.dataset.id;
            const itemName = menuItem.querySelector('h3').textContent;
            const itemPrice = parseFloat(menuItem.querySelector('.price').textContent.replace('$', ''));
            const quantity = parseInt(menuItem.querySelector('.quantity').value);
            
            addToCart(itemId, itemName, itemPrice, quantity);
            updateCartDisplay();
        });
    });
}

function addToCart(id, name, price, quantity) {
    // Send data to server using fetch
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&name=${encodeURIComponent(name)}&price=${price}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart display
            updateCartDisplay();
        } else {
            alert('Error adding item to cart');
        }
    });
}

function updateCartDisplay() {
    // Fetch cart data from server
    fetch('get_cart.php')
    .then(response => response.json())
    .then(cart => {
        const cartItemsContainer = document.querySelector('.cart-items');
        const totalAmountElement = document.getElementById('total-amount');
        
        // Clear existing items
        cartItemsContainer.innerHTML = '';
        
        let total = 0;
        
        // Add each item to the cart display
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <span class="item-name">${item.name}</span>
                <span class="item-quantity">x${item.quantity}</span>
                <span class="item-price">$${itemTotal.toFixed(2)}</span>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
        
        // Update total
        totalAmountElement.textContent = total.toFixed(2);
        
        // Toggle checkout button
        const checkoutBtn = document.querySelector('.checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.style.display = cart.length > 0 ? 'block' : 'none';
        }
    });
}

function initializeOrderForm() {
    const form = document.querySelector('.order-form');
    
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        // Validate name
        const name = document.getElementById('name');
        if (!name.value.trim()) {
            valid = false;
            name.style.borderColor = 'red';
        } else {
            name.style.borderColor = '#ddd';
        }
        
        // Validate email
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            valid = false;
            email.style.borderColor = 'red';
        } else {
            email.style.borderColor = '#ddd';
        }
        
        // Validate phone
        const phone = document.getElementById('phone');
        if (!phone.value.trim()) {
            valid = false;
            phone.style.borderColor = 'red';
        } else {
            phone.style.borderColor = '#ddd';
        }
        
        // Validate address
        const address = document.getElementById('address');
        if (!address.value.trim()) {
            valid = false;
            address.style.borderColor = 'red';
        } else {
            address.style.borderColor = '#ddd';
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
        }
    });
}
<?php


$menuCategories = [
    'Appetizers' => [
        [
            'id' => 1,
            'name' => 'Bruschetta',
            'description' => 'Toasted bread topped with tomatoes, garlic, and fresh basil',
            'price' => 8.99,
            'image' => 'images/bruschetta.jpg'
        ],
        // ... rest of menu items
    ]
];

// Initialize cart only if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
// Menu data array (first code block)
$menuCategories = [
    'Appetizers' => [
        [
            'id' => 1,
            'name' => 'Bruschetta',
            'description' => 'Toasted bread topped with tomatoes, garlic, and fresh basil',
            'price' => 8.99,
            'image' => 'burres.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Calamari',
            'description' => 'Fried squid served with marinara sauce',
            'price' => 12.99,
            'image' => 'calamri.jpg'
        ]
    ],
    'Main Courses' => [
        [
            'id' => 3,
            'name' => 'Spaghetti Carbonara',
            'description' => 'Classic pasta with eggs, cheese, pancetta, and pepper',
            'price' => 16.99,
            'image' => 'carabor.jpg'
        ],
        [
            'id' => 4,
            'name' => 'Grilled Salmon',
            'description' => 'Fresh salmon with lemon butter sauce and vegetables',
            'price' => 22.99,
            'image' => 'salmon.jpg'
        ]
    ],
    'Desserts' => [
        [
            'id' => 5,
            'name' => 'Tiramisu',
            'description' => 'Coffee-flavored Italian dessert with mascarpone cheese',
            'price' => 7.99,
            'image' => 'tiramisu.jpg'
        ],
        [
            'id' => 6,
            'name' => 'Chocolate Lava Cake',
            'description' => 'Warm chocolate cake with a molten center, served with ice cream',
            'price' => 8.99,
            'image' => 'lava-cake.jpg'
        ]
    ]
];

// Initialize session and orders array
session_start();
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

// HTML output begins here (second code block)
include 'includes/header.php';
?>

<div class="menu-container">
    <h1>Our Menu</h1>
    
    <?php foreach ($menuCategories as $category => $items): ?>
    <div class="menu-category">
        <h2><?= htmlspecialchars($category) ?></h2>
        <div class="menu-items">
            <?php foreach ($items as $item): ?>
            <div class="menu-item" data-id="<?= $item['id'] ?>">
                <div class="item-image">
                    <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                </div>
                <div class="item-details">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="description"><?= htmlspecialchars($item['description']) ?></p>
                    <p class="price">$<?= number_format($item['price'], 2) ?></p>
                    <div class="item-controls">
                        <button class="btn minus-btn">-</button>
                        <input type="number" class="quantity" value="1" min="1">
                        <button class="btn plus-btn">+</button>
                        <button class="btn add-to-cart">Add to Order</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="cart-summary">
        <h3>Your Order</h3>
        <div class="cart-items">
            <!-- Cart items will be added dynamically -->
        </div>
        <div class="cart-total">
            <p>Total: $<span id="total-amount">0.00</span></p>
        </div>
        <a href="order.php" class="btn checkout-btn">Proceed to Checkout</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
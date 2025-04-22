<?php
include 'includes/header.php';

// Process form submission BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process order data
    
    $_SESSION['orders'][] = [
        'customer_name' => htmlspecialchars($_POST['name']),
        // ... other order data
    ];
    
    header('Location: confirmation.php');
    exit;
}

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}
?>

<!-- HTML content after processing -->
<div class="order-container">
    <!-- Your order form HTML -->
</div>


<?php



// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order = [
        'customer_name' => htmlspecialchars($_POST['name']),
        'email' => htmlspecialchars($_POST['email']),
        'phone' => htmlspecialchars($_POST['phone']),
        'address' => htmlspecialchars($_POST['address']),
        'items' => $_SESSION['cart'] ?? [],
        'total' => array_reduce($_SESSION['cart'] ?? [], function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0),
        'order_time' => date('Y-m-d H:i:s')
    ];
    
    $_SESSION['orders'][] = $order;
    $_SESSION['last_order'] = $order;
    $_SESSION['cart'] = [];
    header('Location: confirmation.php');
    exit;
   
}

// If cart is empty, redirect to menu
if (empty($_SESSION['cart'])) {
    header('Location: menu.php');
    exit;
}
?>

<div class="order-container">
    <h1>Place Your Order</h1>
    
    <div class="order-summary">
        <h3>Order Summary</h3>
        <?php foreach ($_SESSION['cart'] as $item): ?>
        <div class="order-item">
            <span class="item-name"><?= $item['name'] ?></span>
            <span class="item-quantity">x<?= $item['quantity'] ?></span>
            <span class="item-price">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
        </div>
        <?php endforeach; ?>
        <div class="order-total">
            <strong>Total:</strong> $<?= number_format(array_reduce($_SESSION['cart'], function($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0), 2) ?>
        </div>
    </div>
    
    <form method="POST" class="order-form">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Delivery Address</label>
            <textarea id="address" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="instructions">Special Instructions</label>
            <textarea id="instructions" name="instructions"></textarea>
        </div>
        <button type="submit" class="btn">Place Order</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>


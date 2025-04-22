<?php
include 'includes/header.php';
session_start();

if (!isset($_SESSION['last_order'])) {
    header('Location: menu.php');
    exit;
}

$order = $_SESSION['last_order'];
?>

<div class="confirmation-container">
    <h1>Order Confirmation</h1>
    <div class="confirmation-message">
        <i class="fas fa-check-circle"></i>
        <h2>Thank you for your order, <?= $order['customer_name'] ?>!</h2>
        <p>Your order has been received and is being prepared.</p>
    </div>
    
    <div class="order-details">
        <h3>Order Details</h3>
        <p><strong>Order Time:</strong> <?= $order['order_time'] ?></p>
        <p><strong>Delivery to:</strong> <?= $order['address'] ?></p>
        <p><strong>Contact:</strong> <?= $order['phone'] ?> | <?= $order['email'] ?></p>
        
        <div class="ordered-items">
            <h4>Your Items:</h4>
            <?php foreach ($order['items'] as $item): ?>
            <div class="ordered-item">
                <span><?= $item['name'] ?></span>
                <span>x<?= $item['quantity'] ?></span>
                <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="order-total">
            <strong>Total:</strong> $<?= number_format($order['total'], 2) ?>
        </div>
    </div>
    
    <a href="menu.php" class="btn">Back to Menu</a>
</div>

<?php include 'includes/footer.php'; ?>
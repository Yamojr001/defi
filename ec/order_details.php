<?php
session_start();

// Database connection
include'../includes/config.php';

// Get the order_id from the URL
if (isset($_GET['order_id'])) {
    $orderId = intval($_GET['order_id']);

    // Query to fetch order details
    $query = "SELECT * FROM payments WHERE id = $orderId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        die("Order not found.");
    }
} else {
    die("Order ID is required.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .order-detail-row {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .order-status {
            font-weight: bold;
        }

        .order-status.waiting {
            color: #f39c12;
        }

        .order-status.accepted {
            color: #2ecc71;
        }

        .order-status.declined {
            color: #e74c3c;
        }

        .order-status.on-delivery {
            color: #3498db;
        }

        .back-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Order #<?php echo $order['id']; ?> Details</h2>

    <div class="order-detail-row">
        <p><strong>Product Name:</strong> <?php echo $order['item_name']; ?></p>
        <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($order['unit_price'], 2); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
        <p class="order-status <?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
            <strong>Status:</strong> <?php echo $order['status']; ?>
        </p>
    </div>

    <button class="back-btn" onclick="window.location.href='order.php'">Back to Orders</button>
</div>

<?php  include'../includes/footer.php'  ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>

<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
}

include'../includes/config.php';

$userId = $_SESSION['user_id']; 


$stmt = $conn->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY time DESC");
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .order-row {
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

        .order-details-btn {
            background-color: #030366;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .order-details-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include'../includes/navuserec.php'; ?>
<div class="container">
    <h2>Your Orders</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <div class="order-row">
                <h4>Order #<?php echo $order['id']; ?></h4>
                <p><strong>Product Name:</strong> <?php echo $order['item_name']; ?></p>
                <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($order['unit_price'], 2); ?></p>
                <p><strong>Total:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
                <p class="order-status <?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
                    <strong>Status:</strong> <?php echo $order['status']; ?>
                </p>
                <button class="order-details-btn" onclick="window.location.href='order_details.php?order_id=<?php echo $order['id']; ?>'">
                    View Details
                </button>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You don't have any orders yet.</p>
    <?php endif; ?>

</div>

<?php include'../includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>

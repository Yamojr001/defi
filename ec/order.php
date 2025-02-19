<?php
function generateRandomKey() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $key = '';
    for ($i = 0; $i < 30; $i++) {
        if ($i > 0 && $i % 5 == 0) {
            $key .= '-';
        }
        $key .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $key;
}

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../includes/config.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY time DESC");
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_key'])) {
    $orderId = $_POST['order_id'];
    $stmt = $conn->prepare("SELECT status, quantity FROM payments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    $order = $res->fetch_assoc();

    if ($order && $order['status'] === 'approved') {
        $quantity = $order['quantity'];
        $stmt = $conn->prepare("INSERT INTO `keys` (user_id, `key`) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        
        for ($i = 0; $i < $quantity; $i++) {
            $key = generateRandomKey();
            $stmt->bind_param("is", $userId, $key);
            $stmt->execute();
        }
        $stmt->close();

        $stmt = $conn->prepare("UPDATE payments SET status = 'used' WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/navuserec.php'; ?>
<div class="container">
    <h2>Your Orders</h2>

    <?php while ($order = $result->fetch_assoc()): ?>
    <div class="order-row">
        <h4>Order #<?php echo htmlspecialchars($order['id']); ?></h4>
        <p><strong>Product Name:</strong> <?php echo htmlspecialchars($order['item_name']); ?></p>
        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($order['unit_price'], 2); ?></p>
        <p><strong>Total:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
        <p class="order-status <?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
            <strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?>
        </p>
        <?php if ($order['status'] === 'approved'): ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                <button type="submit" name="generate_key" class="order-details-btn">Generate Key</button>
            </form>
        <?php elseif ($order['status'] === 'used'): ?>
            <button class="order-details-btn" disabled>Generate Key</button>
        <?php endif; ?>
        <button class="order-details-btn" onclick="window.location.href='order_details.php?order_id=<?php echo htmlspecialchars($order['id']); ?>'">
            View Details
        </button>
    </div>
   <?php endwhile; ?> 

</div>

<?php include '../includes/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>

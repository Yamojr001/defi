<?php
session_start(); 

// Database connection settings
include'../includes/config.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cartItems = [];
} else {
    $cartItems = $_SESSION['cart'];
}

if (isset($_GET['delete'])) {
    $itemIndex = intval($_GET['delete']);
    if (isset($_SESSION['cart'][$itemIndex])) {
        unset($_SESSION['cart'][$itemIndex]); 
        $_SESSION['cart'] = array_values($_SESSION['cart']); 
    }
    header("Location: view_cart.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            padding: 20px;
        }
        h1 {
            color: #fff;
        }
        .item-image {
            width: 50px; 
            height: auto;
        }
        .delete-button, .pay-button {
            background-color: #030366; 
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }
        .delete-button:hover, .pay-button:hover {
            background-color: #020244; 
        }
        h1 {
            color: #fff;
            border-radius: 5px;
            background-color: #030366;
        
        }
        thead {
            background-color: #030366;
            color: white;
        }
    </style>
</head>
<body>
    
    <!-- Navigation -->
    <?php include'../includes/navuserec.php' ?>
    <div class="container my-3">
        <h1 class="container-fluid py-2 text-center">Your Cart</h1>

        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead class="">
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalAmount = 0;
                    foreach ($cartItems as $index => $item):
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalAmount += $itemTotal;
                    ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image"></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?> USD</td>
                            <td><?php echo number_format($itemTotal, 2); ?> USD</td>
                            <td><a href="view_cart.php?delete=<?php echo $index; ?>"><button class="delete-button">Delete</button></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total font-weight-bold">Total Amount: <?php echo number_format($totalAmount, 2); $_SESSION['total'] = $totalAmount; ?> USD</div>
        <?php endif; ?>

        <p><a href="../user.php" class="btn btn-link">Continue Shopping</a></p>
        
        <?php if (!empty($cartItems)): ?>
            <form action="../pay/pay1.php" method="POST">
                <input type="hidden" name="total" value="<?php echo number_format($totalAmount, 2); ?>"> 
                <button type="submit" class="pay-button">Pay</button>
            </form>
        <?php endif; ?>
    </div>
    
</body>
</html>
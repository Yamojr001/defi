<?php
session_start();

// Database connection
include'../includes/config.php';

// Handle the form submission (I have made a payment)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $userId = $_SESSION['user_id'];
        $status = 'waiting for approval'; 
        

        // Loop through the cart and insert each item into the orders table
        foreach ($_SESSION['cart'] as $item) {
            $productName = $conn->real_escape_string($item['name']);
            $quantity = $item['quantity'];
            $price = $item['price'];
            $total = $quantity * $price;

            // Insert the item into the orders table
            $query = "INSERT INTO orders (user_id, product_name, quantity, price, total, status) 
                      VALUES ($userId, '$productName', $quantity, $price, $total, '$status')";
            if (!$conn->query($query)) {
                die("Error: " . $conn->error);
            }
        }

        // Clear the cart after successful payment insertion
        unset($_SESSION['cart']);
        header("Location: upload.php"); 
        exit();
    }
}
<?php
// Database connection settings

include'../includes/config.php';



// Check if product_id is set
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    $stmt->bind_param("i", $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: dashboard.php?deleted=true"); // Redirect to your dashboard with a query parameter
        exit();
    } else {
        // Show error message
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<?php
header('Content-Type: application/json'); // Set JSON response type
include '../includes/config.php';

// Check request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

// Get raw POST data
parse_str(file_get_contents("php://input"), $_POST);

// Check if product_id is received
if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
    echo json_encode(["success" => false, "message" => "Product ID is missing"]);
    exit();
}

$product_id = intval($_POST['product_id']); // Convert to integer for safety

// Prepare DELETE query
$stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting record: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>

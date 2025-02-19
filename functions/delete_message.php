<?php
session_start();
include '../includes/config.php'; 

// Check if the admin is logged in
include '../includes/adminsession.php';

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare a statement to delete the message
    $stmt = $conn->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Message deleted successfully!'); window.location.href='../admin/viewm.php';</script>";
    } else {
        echo "<script>alert('Error deleting message: " . $stmt->error . "'); window.location.href='../admin/viewm.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='../admin/viewm.php';</script>";
}

$conn->close();
?>

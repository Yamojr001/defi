<?php
session_start();

include'../includes/config.php';

$user_id = $_SESSION['user_id'];
$receiver_id = isset($_POST['receiver_id']) ? (int)$_POST['receiver_id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message']) && $receiver_id) {
    $message = $conn->real_escape_string($_POST['message']);
    $sent_at = date("Y-m-d H:i:s");

    $sql = "INSERT INTO messages (message, sender_id, receiver_id, sent_at) VALUES ('$message', '$user_id', '$receiver_id', '$sent_at')";
    $conn->query($sql);
}

$conn->close();
?>
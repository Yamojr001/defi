<?php
session_start();

include'../includes/config.php';

$user_id = $_SESSION['user_id']; 
$receiver_id = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : 0;

$sql = "SELECT * FROM messages WHERE (sender_id = '$user_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$user_id') ORDER BY sent_at ASC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo '<div class="message ' . (($row['sender_id'] == $user_id) ? 'sent' : 'received') . '">';
    echo '<strong>' . (($row['sender_id'] == $user_id) ? 'You' : 'User ' . $row['sender_id']) . ':</strong>';
    echo htmlspecialchars($row['message']);
    echo '<br><small>' . $row['sent_at'] . '</small>';
    echo '</div>';
}

$conn->close();
?>
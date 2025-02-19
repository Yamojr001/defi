<?php
session_start();

// Database connection
include '../includes/config.php';

$user_id = $_SESSION['user_id']; // Assume user_id is stored in session

// Query to fetch admin users
$sql = "SELECT name, id FROM users WHERE role = 'admin'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>List of Admin Users</h2>";
   
    
    while ($row = $result->fetch_assoc()) {
        echo "<a href='chat.php?receiver_id=" . $row['id'] . "' onclick='setReceiver(" . $row['id'] . ")'>" . htmlspecialchars($row['name']) . "</a>";
    }
    
    echo "</table>";
} else {
    echo "No admin users found.";
}

$conn->close();
?>

<script>
function setReceiver(receiverId) {
    fetch('set_receiver.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'receiver_id=' + receiverId
    });
}
</script>
</body>
</html>
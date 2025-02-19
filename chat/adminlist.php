<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "defi";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Assume user_id is stored in session
$receiver_id = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : 0; // Fetch receiver_id from URL

// Function to fetch all unique senders where receiver_id is the session user_id
function getMessageSenders($conn, $user_id) {
    $sql = "SELECT DISTINCT users.name, users.id FROM messages 
            JOIN users ON messages.sender_id = users.id 
            WHERE messages.receiver_id = '$user_id'";
    $result = $conn->query($sql);
    
    $senders = [];
    while ($row = $result->fetch_assoc()) {
        $senders[] = $row;
    }
    return $senders;
}

// Fetch senders
$senders = getMessageSenders($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        .chat-container { width: 50%; margin: auto; }
        .message { padding: 10px; margin: 5px; border-radius: 5px; }
        .sent { background-color: #d1e7dd; text-align: left; }
        .received { background-color: #f8d7da; text-align: right; }
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Message Senders</h2>
        <ul>
            <?php foreach ($senders as $sender): ?>
                <li><a href="chat.php?receiver_id=<?php echo $sender['id']; ?>"><?php echo htmlspecialchars($sender['name']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

<?php $conn->close(); ?>

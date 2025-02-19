<?php
session_start();

// Database connection
include '../includes/config.php';

$user_id = $_SESSION['user_id']; // Assume user_id is stored in session

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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Senders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sender-list a {
            display: block;
            padding: 10px;
            background-color: #030366;
            color: white;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
            text-align: center;
        }
        .sender-list a:hover {
            background-color: white;
            color: #030366;
            border: 1px solid #030366;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-white text-center" style="background-color: #030366;">
                        <h4>Message Senders</h4>
                    </div>
                    <div class="card-body sender-list">
                        <?php if (!empty($senders)): ?>
                            <?php foreach ($senders as $sender): ?>
                                <a href='chat.php?receiver_id=<?php echo $sender['id']; ?>'>
                                    <?php echo htmlspecialchars($sender['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-center">No messages received.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
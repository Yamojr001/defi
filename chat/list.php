<?php
session_start();
include '../includes/config.php';

// Fetch distinct senders
$query = "
    SELECT DISTINCT users.id, users.name 
    FROM chats
    JOIN users ON chats.user_id = users.id
    ORDER BY users.name ASC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Senders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        .sender-box {
            padding: 10px;
            margin: 5px 0;
            background-color: #e9ecef;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }
        .sender-box a {
            text-decoration: none;
            color: black;
            display: block;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Message Senders</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="sender-box">
                    <a href="reply.php?receiver_id=<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No senders found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

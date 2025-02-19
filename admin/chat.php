<?php
session_start();

// Database connection
include'../includes/config.php';

$user_id = $_SESSION['user_id']; 
$receiver_id = isset($_GET['receiver_id']) ? (int)$_GET['receiver_id'] : 0; 

// Fetch messages
$sql = "SELECT * FROM messages WHERE (sender_id = '$user_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$user_id') ORDER BY sent_at ASC";
$result = $conn->query($sql);
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const receiverId = <?php echo json_encode($receiver_id); ?>;

            function fetchMessages() {
                $.ajax({
                    url: 'fetch_messages.php',
                    method: 'GET',
                    data: { receiver_id: receiverId },
                    success: function(data) {
                        $('.chat-box').html(data);
                    }
                });
            }

            setInterval(fetchMessages, 2000);

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        $('#message').val('');
                        fetchMessages();
                    }
                });
            });
        });
    </script>
    <style>
        .chat-box {
            height: 400px;
            overflow-y: scroll;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }
        .message {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        .sent {
            background-color: #d1e7dd;
            text-align: left;
        }
        .received {
            background-color: #f8d7da;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header  text-white text-center" style="background-color: #030366;">
                        <h4>Chat Messages</h4>
                    </div>
                    <div class="card-body chat-box">
                        <?php foreach ($messages as $row): ?>
                            <div class="message <?php echo ($row['sender_id'] == $user_id) ? 'sent' : 'received'; ?>">
                                <strong><?php echo ($row['sender_id'] == $user_id) ? 'You' : 'User ' . $row['sender_id']; ?>:</strong>
                                <?php echo htmlspecialchars($row['message']); ?>
                                <br><small><?php echo $row['sent_at']; ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <form id="messageForm" class="d-flex">
                            <textarea id="message" name="message" class="form-control me-2" required placeholder="Type your message..."></textarea>
                            <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
                            <button type="submit" class="btn text-white" style="background-color:#030366;">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

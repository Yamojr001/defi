<?php
session_start();

include'../includes/usersession.php';

// Database connection
include '../includes/config.php';

$user_id = $_SESSION['user_id']; // Assume user_id is stored in session

// Query to fetch admin users
$sql = "SELECT name, id FROM users WHERE role = 'admin'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-list a {
            display: block;
            padding: 10px;
            background-color: #030366;
            color: white;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
            text-align: center;
        }
        .admin-list a:hover {
            background-color: white;
            color: #030366;
            border: 1px solid #030366;
        }
    </style>
</head>
<body>
    <?php include'../includes/navother.php';  ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-white text-center" style="background-color: #030366;">
                        <h4>List of Admin Users</h4>
                    </div>
                    <div class="card-body admin-list">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <a href='chat.php?receiver_id=<?php echo $row['id']; ?>' onclick='setReceiver(<?php echo $row['id']; ?>)'>
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-center">No admin users found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setReceiver(receiverId) {
            fetch('set_receiver.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'receiver_id=' + receiverId
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
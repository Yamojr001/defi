<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Database connection settings

include'includes/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; 
    $username = $_SESSION['username'];
    $message = $conn->real_escape_string($_POST['comment']); 

    // Insert comment into the database
    $insertQuery = "INSERT INTO comment (userid, username, message, created_at) VALUES ('$user_id', '$username', '$message', NOW())";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Comment added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch existing comments
$commentsQuery = "SELECT username, message, created_at FROM comment ORDER BY created_at DESC";
$commentsResult = $conn->query($commentsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .comment-section {
            border: 1px solid #ccc;
            padding: 10px;
            max-width: 600px;
            margin: auto;
        }
        .comment {
            margin-bottom: 10px;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .comment-input {
            width: calc(100% - 50px);
            padding: 10px;
            margin-right: 10px;
        }
        .send-button {
            padding: 10px;
        }
        footer {
            margin-top: 60px;
        }
    </style>
</head>
    <?php include'includes/navuser2.php' ?>
    <body>
        

        <div class="comment-section mb-6">
            <h2>Comments</h2>
            
            <!-- Display previous comments -->
            <?php if ($commentsResult && $commentsResult->num_rows > 0): ?>
                <?php while ($row = $commentsResult->fetch_assoc()): ?>
                    <div class="comment">
                        <?php echo htmlspecialchars($row['username']); ?>: <br> <strong> <?php echo htmlspecialchars($row['message']); ?></strong>
                        <br><small><?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No comments yet. Be the first to comment!</p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" id="commentInput" name="comment" class="form-control comment-input" placeholder="Write a comment..." required />
                    <div class="input-group-append">
                        <button class="btn btn-primary send-button" type="submit">Send</button>
                    </div>
                </div>
            </form>
        </div>
        <?php  include'./includes/footer.php'; ?>
 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php
// Close the database connection
$conn->close();
?>
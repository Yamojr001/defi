<?php
session_start();
include '../includes/config.php'; // Include your database connection file

// Check if the admin is logged in
//include '../includes/adminsession.php';

// Fetch messages from the database
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM `keys` WHERE user_id = $user_id ORDER BY id ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user - View Keys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <!-- navbar -->
  <?php include '../includes/navadd.php'; ?>

  <!-- mainbody -->
    <div class="container mt-5" style="font-size: xx-small;">
        <h2 class="text-center">User Keys</h2>
        <table class="table table-bordered table-responsive-sm mt-3">
            <thead class="table-dark">
                <tr>
                    <th>KEY_ID</th>
                    <th>KEY</th>
                    <th>STATUS</th>
                    <th>CREATED_AT</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['key']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- footer -->
    <?php include '../includes/footeradd.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

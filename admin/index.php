<?php

// Start the session
session_start();

// Check if user is logged in and is an admin
include'../includes/adminsession.php';

// Database connection settings

include'../includes/config.php';

// Fetch relevant data
$reportQuery = "SELECT * FROM reports";
$reportResult = $conn->query($reportQuery);

// Handle deletion of staff or customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_id = (int)$_POST['report_id'];
    $deleteQuery = "DELETE FROM reports WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Handle marking a report as done
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_done'])) {
    $report_id = (int)$_POST['report_id'];
    $updateQuery = "UPDATE reports SET status = 'done' WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chairman Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/nav.css">
    <style>
        body {
            background-color: #f0f0f0; /* Light grey background */
            padding: 20px;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #030366; 
            color: white;
            border-radius: 8px; 
        }
        main {
            padding: 20px;
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        section {
            margin-bottom: 30px;
        }
        h2 {
            color: #003366;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #030366; 
            color: white;
            margin-top: 20px;
        }
    </style>
</head>
<body>
   
   <!-- navbar -->
    <?php include'../includes/navadd.php' ?>
    
    <header>
        <h1>Welcome, Chairman!</h1>
    </header>

    <main class="container py-3 my-5">
        <section id="staff py-3">
            <h2 class="my-5">Scam Reports</h2>
            <div class="list-group">
                <?php while ($row = $reportResult->fetch_assoc()): ?>
                    <div class="list-group-item">
                        <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                        <p><strong>Scam Type:</strong> <?php echo htmlspecialchars($row['scam']); ?></p>
                        <p><strong>Details:</strong> <?php echo htmlspecialchars($row['details']); ?></p>
                        <div class="text-center">
                            <?php echo '<img src="../sr/' . htmlspecialchars($row['image_path']) . '" class="img-fluid" alt="' . htmlspecialchars($row['name']) . '">'; ?>
                        </div>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_user" class="btn btn-sm m-3" style = "background-color: #030366; color: #ffffff;" onclick="return confirm('Are you sure you want to delete this report?');">Delete</button>
                        </form>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="mark_done" class="btn btn-sm m-3" style = "background-color: #030366; color: #ffffff;" onclick="return confirm('Are you sure you want to mark this report as done?');">Done</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    
    <!-- footer -->

   <?php include'../includes/footeradd.php' ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
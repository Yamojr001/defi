<?php
session_start();

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

include '../includes/config.php';

// Handle approval
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $payment_id = $_POST['payment_id'];

    // Update query
    $update_query = "UPDATE `payments` SET `status` = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($update_query);

    if ($stmt) {
        $stmt->bind_param("i", $payment_id);
        $execute_result = $stmt->execute();
        $stmt->close();

        if ($execute_result) {
            echo '<script>
                    alert("Payment approved successfully!");
                    window.location.href = "approve.php";
                  </script>';
            exit();
        } else {
            echo '<script>alert("Failed to approve payment. Try again.");</script>';
        }
    } else {
        echo '<script>alert("Database error: ' . $conn->error . '");</script>';
    }
}

// Fetch pending payments
$query = "SELECT p.id, u.name, p.amount, p.proof_of_payment, p.status, p.time, p.coin
          FROM payments p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.status = 'Pending'";
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include'../includes/navadd.php';  ?>

    <div class="container mt-5">
        <h2 class="mb-4">Pending Payment Approvals</h2>

        <div class="row">
            <?php if ($result->num_rows == 0): ?>
                <div class="alert alert-info">No Pending Payments</div>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Payment from <?php echo htmlspecialchars($row['name']); ?></h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Amount Paid</th>
                                        <td><?php echo htmlspecialchars($row['amount']); ?> <?php echo htmlspecialchars($row['coin']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Evidence</th>
                                        <td>
                                            <img src="../pay/<?php echo htmlspecialchars($row['proof_of_payment']); ?>" class="img-fluid" alt="Payment Evidence">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-warning"><?php echo htmlspecialchars($row['status']); ?></span>
                                        </td>
                                    </tr>
                                </table>

                                <form method="POST">
                                    <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include'../includes/footeradd.php'; ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

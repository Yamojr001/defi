<?php
session_start();
//admin Session


// Database connection settings
include '../includes/config.php';
$coin=$_SESSION["coin"];
$quantity = floatval($_SESSION['quantity']);
$itemname = $_SESSION['itemname'];
$price =floatval($_SESSION['price']); 
$totalprice = $quantity * $price;

// Check if the connection is valid
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount_paid = filter_var($_POST['amountp'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $coin1 = strtoupper($coin);
    $user_id = intval($_SESSION['user_id']);
    $status = "Pending";
    $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, coin, proof_of_payment, status, item_name, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }
   

    $stmt->bind_param("idssssidd", $user_id, $amount_paid, $coin, $target_file, $status, $itemname, $quantity, $price, $totalprice);
    // Set upload directory
    $target_dir = "uploads/";

    // Ensure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, recursive: true);
    }

    // Check if file is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $original_file_name = basename($_FILES["image"]["name"]);
        $sanitized_file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $original_file_name);
        $target_file = $target_dir . $sanitized_file_name;
        $uploadOk = 1;

        // Validate file type and size
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);

        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        } elseif ($_FILES["image"]["size"] > 5000000) {
            echo "File size exceeds 5MB.";
            $uploadOk = 0;
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert into database
                $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, coin, proof_of_payment, status, item_name, quantity, unit_price, total_price ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                if (!$stmt) {
                    die("SQL error: " . $conn->error);
                }

                $stmt->bind_param("idssssidd", $user_id, $amount_paid, $coin, $target_file, $status, $itemname, $quantity, $price, $totalprice);

                if ($stmt->execute()) {
                    $upload_status = "Payment uploaded successfully. Awaiting approval.";
                } else {
                    echo "Database error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "File upload failed.";
            }
        }
    } else {
        echo "No file uploaded or an error occurred.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Payment Evidence</title>
    <link rel="shortcut icon" href="account/wha.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Navbar -->
    <?php include '../includes/navother.php'; ?>

    <div class="container">
        <div class="fs-4 p-4">Amount to be paid: <?php echo $_SESSION['total']; ?> USD</div>
        
        <?php if (!empty($upload_status)) : ?>
            <div class="alert alert-info"><?php echo $upload_status; ?></div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="fs-4 my-3 p-4">
            <label for="amount">Amount Paid (<?php echo $coin; ?>)</label>
            <input type="text" name="amountp" id="amount" class="form-control" required>

            <label for="image">Upload Payment Evidence</label>
            <input type="file" name="image" id="image" class="form-control" required>

            <button type="submit" class="btn btn-primary mt-3">Upload</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>

</body>
</html>

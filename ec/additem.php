<?php
//session to verify role

include'../includes/adminsession.php';

// Database connection settings
include'../includes/config.php';

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    $target_dir = "uploads/"; 

    // Create the uploads directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); 
    }

    $original_file_name = basename($_FILES["image"]["name"]);
    $sanitized_file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $original_file_name);
    $target_file = $target_dir . $sanitized_file_name; 
    $uploadOk = 1;

    // Check if image file is a valid image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (5MB limit)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO product (name, price, description, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $name, $price, $description, $target_file);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "The product has been added successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0; 
            padding: 20px;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #030366;
            color: white;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box input,
        .input-box textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #030366;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%; 
        }
        button:hover {
            background-color: #030322;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg bg-dark mb-4" style="border: 1px solid blue; border-radius: 15px;">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Defi Scam Recovery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="adduser.php">Add Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../pay/uploadacc.php">Add Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../trial/admin.html">Staff Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../trial/admin.html">Approve Payment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../../trial/admin.html">View Scam Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <h1>Add New Product</h1>
    </header>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="input-box">
                <input type="text" name="name" class="form-control" placeholder="Product Name" required>
            </div>
            <div class="input-box">
                <input type="number" name="price" class="form-control" placeholder="Price (USD)" step="0.01" required>
            </div>
            <div class="input-box">
                <textarea name="description" class="form-control" placeholder="Product Description" rows="4" required></textarea>
            </div>
            <div class="input-box">
                <input type="file" name="image" accept="image/*" class="form-control" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
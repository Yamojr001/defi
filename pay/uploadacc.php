<?php

// Start the session
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page or show an error
    header('Location: ../login.php'); 
    exit();
}

if($_SESSION['role']===!'admin'){
    header("Location: login.php");
}
// Database connection settings
include"../includes/config.php";

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['coin'];
    $address = $_POST['address'];
    $network = $_POST['network'];
    

    // Handle image upload
    $target_dir = "Account/"; 

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
            $stmt = $conn->prepare("INSERT INTO accounts (coin, address, network, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $address, $network,  $target_file);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>
                alert('Account uploaded succesfully ')
                </script>";
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
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Document</title>
  <style>
    .navbar-toggler {
        border-color: #030366;
        background-color: #ffffff;
      }
  </style>
</head>
<body>


  <?php include'../includes/navaddpay.php' ?>
  
  <form action="" method="POST" enctype="multipart/form-data" class="container m-auto p-3">
    <div class="mb-3">
        <label for="Coin" class="form-label"> Coin/currency Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter the coin/currency name" name="coin">
    </div>
    <div class="mb-3">
        <label for="Network" class="form-label">Network</label>
        <input type="text" class="form-control" id="Network" placeholder="Enter the Network" name="network">
    </div>
    <div class="mb-3">
      <label for="walletaddress" class="form-label">Wallet address</label>
      <input type="text" class="form-control" id="address" name="address">
    </div>

    <div class="mb-3">
      <label for="qr" class="form-label" >upload QR</label>
      <input type="file" class="form-control" id="qre" name="image">
    </div>

     
    <button type="submit" class="btn d-block m-auto" style="background-color: #030366; color: #ffffff;  width: 50%; min-width: 5cm;">Submit</button>
  </form>
  

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>






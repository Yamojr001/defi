<?php

session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    // Redirect to login page or show an error
    header('Location: ../login.php'); // Change 'login.php' to your login page
    exit();
}


// Database connection settings
include'../includes/config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $scam = $_POST['scam'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];
    // Handle image upload
    $target_dir = "ScamEvidence/"; 

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
            $stmt = $conn->prepare("INSERT INTO reports (user_id, name, email, phone, scam, details, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $user_id, $name, $email, $phone, $scam, $details, $target_file);
            
            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>
                alert('Complain submited successfully please wait for the recovery process this would take about 2 weeks')
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
  
</head>
<body>


<?php include'../includes/navusersr.php';  ?>

  
  <form action="" method="POST" enctype="multipart/form-data" class="container m-auto p-3">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter Your Fullname" name="name">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="tel" class="form-control" id="phone" placeholder="Enter Your phone number" name="phone">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>

    
    <select class="form-select" aria-label="Default select example" name="scam">
      <option selected>Select The Scam type</option>
      <option value="cryptocurrency">Cryptocurrency</option>
      <option value="romance">Romance</option>
      <option value="investiment">investment</option>
      <option value="other">Other</option>
    </select>

    <div class="mb-3">
      <label for="scamEvidence" class="form-label" >upload a scam evidence</label>
      <input type="file" class="form-control" id="scamEvidence" name="image">
    </div>


      <div class="form-floating mt-2">
        <p class="mb-0">More Scam Details</p>
        <textarea class="form-control" placeholder="Describe you scam vividly" id="floatingTextarea2" style="height: 100px" name="details"></textarea>
        
      </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="exampleCheck1">
      <label class="form-check-label" for="exampleCheck1">I agree with <a href="">Terms and conditions</a></label>
    </div>
    <button type="submit" class="btn d-block m-auto" style="background-color: #030366; color: #ffffff;  width: 50%; min-width: 5cm;">Submit</button>
  </form>
  
  
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>






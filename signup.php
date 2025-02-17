<?php
// Database connection
include'includes/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize user input
    $name = $conn->real_escape_string($_POST['Full_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = "user"; 
    $phone_number = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);

    // Insert into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO users (email, name, password, role, phone ) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $name, $password, $role, $phone_number);
    
    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!-- Navigation -->
    <?php include'includes/navacc.php' ?>

    
    <form style="color: #030366; " class="m-5 p-3" action="" method="POST" >
      <h1 class="text-center m-3 mb-5" style="color: #030366;">Sign up Page</h1>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="Text" class="form-control" id="fullname" aria-describedby="emailHelp" name="Full_name">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone </label>
            <input type="tel" class="form-control" id="phone" aria-describedby="emailHelp" name ="phone">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1" checked>
          <label class="form-check-label" for="exampleCheck1">I agree with <a href="">Terms & Conditions</a></label>
        </div>
        <p>Already have an account ? <a href="login.php">log in</a></p>
        <button type="submit" class="btn m-auto d-block text-center" style="background-color: #030366; color: #ffffff; align-self: center; width: 50%; min-width: 2cm;">Submit</button>
        
      </form>

      <!-- footer -->
      
      <?php  include'includes/footer.php'  ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
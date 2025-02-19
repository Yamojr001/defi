<?php
// Start session for user authentication
session_start();

// Database connection

include'includes/config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // User authentication
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect based on user role
            switch (strtolower($user['role'])) {
                case 'admin':
                    $_SESSION['role'] = 'admin';
                    header("Location: ./admin/index.php");
                    exit();
                case 'user':
                    $_SESSION["role"] = 'user';
                    header("Location: home.php");
                    exit();
                default:
                    echo "Unauthorized access!";
                    exit();
            }
        } else {
            echo "<script>alert('Invalid email or .');</script>";
        }
    } else {
        echo "<script>alert('Invalid e or password.');</script>";
    }
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

  <!-- navbars     -->
   <?php include'includes/navacc.php'  ?>

    <form style="color: #030366; " class="m-5 p-3" action="" method="POST">
        <h1 class="text-center m-3 mb-5" style="color: #030366;">Login Page</h1>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name = "email" placeholder = "Enter Your email" aria-describedby="emailHelp">
        </div>
        
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name = "password" placeholder = " Emter your Password">
        </div>
        <p>Do not have the account? <a href="signup.php">Sign up</a></p>
        <button type="submit" class="btn mx-auto d-block text-center" style="background-color: #030366; color: #ffffff; width: 50%; min-width: 2cm;">Submit</button>
      </form>

      <!-- footer -->

      <?php include'includes/footer.php' ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
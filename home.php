<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}


$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <!-- navbar      -->

    <?php include'includes/navuser2.php'  ?>

    <div class="container mt-5">
        <h1 class="text-center">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <p class="text-center">Your Email: <?php echo htmlspecialchars($email); ?></p>
        <div class="text-center d-block m-auto">
            <a href="sr/index.php" class="btn m-4 " style="background-color:#030366; color: #ffffff; width: 80%">Report Scam</a>
        
            <a href="ec/index.php" class="btn m-4 " style="background-color:#030366; color: #ffffff; width: 80%">Buy a key</a>
        </div>
    </div>

    <!-- footer -->

    <?php  include'includes/footer.php';  ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
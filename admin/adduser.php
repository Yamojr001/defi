<?php
// Start the session
session_start();

// Check if user is logged in and is an admin

include'../includes/adminsession.php';

// Database connection

include'../includes/config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect and sanitize user input
    $staff_name = $conn->real_escape_string($_POST['staff_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $conn->real_escape_string($_POST['role']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Insert into the database
    $insertQuery = "INSERT INTO users (email, name, password, role, phone) VALUES ('$email', '$staff_name', '$password', '$role', '$phone_number')";
    
    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('User registered successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch existing users (optional for displaying)
$usersQuery = "SELECT * FROM users";
$usersResult = $conn->query($usersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            border-radius: 8px; 
        }
        main {
            padding: 20px;
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto; 
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box input,
        .input-box select {
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
        }
        button:hover {
            background-color: #030399; 
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

     <!-- navbar     -->

     <?php  include'../includes/navadd.php' ?>

    <header>
        <h1>User Registration</h1>
    </header>
    
    <main class="my-3">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="input-box">
                <input type="text" name="staff_name" class="form-control" placeholder="Name" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="input-box">
                <select id="role" name="role" class="form-control"  required>
                    <option value="" disabled selected>---- Select the role for the user you want to create ----</option>
                    <option value="customer care">customer care</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div class="input-box">
                <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="input-box">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <button type="submit" style="width: 100%;">Submit</button>
        </form>
    </main>
    
    <!-- footer -->
     <?php include'../includes/footeradd.php'; ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
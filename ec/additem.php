<?php

session_start();

// Database connection settings
include'../includes/config.php';
//session to verify role
 include'../includes/adminsession.php';



// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

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
           
        }
        button:hover {
            background-color: #030322;
        }
    </style>
</head>
<body>


<?php include'../includes/navadd.php'; ?>

    <header>
        <h3>Add New Product</h3>
    </header>
    <div class="container my-3">
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
            <button type="submit" style=" width: 100%; ">Submit</button>
        </form>
    </div>
    <?php include'../includes/footeradd.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
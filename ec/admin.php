<?php
// Database connection settings
include '../includes/config.php';

// Fetch products from the database
$productQuery = "SELECT * FROM product";
$productResult = $conn->query($productQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        body {
            background-color: #f0f0f0;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #030366; 
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <?php include '../includes/navaddec.php'; ?>

    <header>
        <h1>Welcome, Staff Member!</h1>
    </header>
    
    <main class="container py-4">
        <section id="products" class="text-center">
            <h2 class="text-primary">Products</h2>
            <div class="row">
                <?php while ($row = $productResult->fetch_assoc()) { ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?= htmlspecialchars($row['image_path']) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($row['name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                                <p class="card-text"><strong>$<?= number_format($row['price'], 2) ?> USD</strong></p>
                                <button class="btn btn-danger" onclick="deleteProduct(<?= $row['id'] ?>)">Delete</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
    
    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'product_id=' + encodeURIComponent(productId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Refresh the page to update product list
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

<?php
$conn->close();
?>

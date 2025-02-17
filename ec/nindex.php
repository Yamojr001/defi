<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

// Database connection settings
include '../includes/config.php';

if (isset($_POST['button'])) {
    $itemname = $_POST['name'];
    $quantity = (int) $_POST['quantity'];
    $price = (float) $_POST['price'];
    $totalprice = $quantity * $price;
    
    $_SESSION['itemname'] = $itemname;
    $_SESSION['quantity'] = $quantity;
    $_SESSION['price'] = $price;
    $_SESSION['total'] = $totalprice;

    header("Location: ../pay/index.php");
    exit();
}

// Fetch items from database based on search term
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT name, price, description, image_path FROM product WHERE name LIKE ? ORDER BY name ASC"; 
$stmt = $conn->prepare($sql);
$searchWildcard = "%" . $searchTerm . "%"; 
$stmt->bind_param('s', $searchWildcard);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0; 
        }
        .logo {
            width: 150px; 
            height: 150px; 
            border-radius: 50%; 
            object-fit: cover; 
        }
        #item img {
            max-width: 100%; 
            height: auto;
            border-radius: 4px;
        }
        footer {
            background-color: #030366;
            color: white;
            border: 1px solid black;
            border-radius: 7px;
        }
    </style>
</head>
<body>

<?php include '../includes/navuserec.php'; ?>

<header class="text-center my-4">
    <img src="omologo.jpg" class="logo">
    <h1 class="mt-3">Defi Shopping Site</h1>
</header>

<section class="product-search text-center mb-4">
    <div class="container-fluid">
        <form action="" method="GET" class="form-inline justify-content-center container-fluid">
            <input type="search" name="search" class="form-control mr-2" placeholder="Search for product.." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section id="home" class="container">
    <ul id="item" class="list-unstyled row">
        <?php
        if ($result->num_rows > 0) {
            $index = 0;
            while ($row = $result->fetch_assoc()) {
                ?>
                <li class="col-sm-6 col-md-4 mb-4 d-block m-auto">
                    <div class="card d-block m-auto">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-body d-block m-auto">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="price"><?php echo htmlspecialchars($row['price']); ?> USD</p>

                            <div class="quantity-control mb-2">
                                <button type="button" class="btn btn-sm" style="background-color: #030366; color: #ffffff;" onclick="changeQuantity(<?php echo $index; ?>, -1)">-</button>
                                <input type="number" id="quantity-<?php echo $index; ?>" name="quantity" data-price="<?php echo htmlspecialchars($row['price']); ?>" value="0" min="0" class="form-control d-inline-block w-25 mx-2" readonly>
                                <button type="button" class="btn btn-sm" style="background-color: #030366; color: #ffffff;" onclick="changeQuantity(<?php echo $index; ?>, 1)">+</button>
                            </div>

                            <form action="" method="post" onsubmit="updateHiddenInputs(<?php echo $index; ?>)">
                                <input type="hidden" name="name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                <input type="hidden" name="quantity" id="hidden-quantity-<?php echo $index; ?>" value="0">
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
                                <input type="hidden" name="totalp" id="hidden-totalp-<?php echo $index; ?>" value="0">
                                <button type="submit" name="button" class="btn btn-primary">Pay</button>
                            </form>

                            <div id="total-price-<?php echo $index; ?>" class="mb-2">0.00 USD</div>
                        </div>
                    </div>
                </li>
                <?php
                $index++;
            }
        } else {
            echo "<li>No products found.</li>";
        }
        ?>
    </ul>
</section>

<?php include '../includes/footer.php'; ?>

<script>
    function changeQuantity(index, delta) {
        let quantityInput = document.getElementById('quantity-' + index);
        let newQuantity = Math.max(0, parseInt(quantityInput.value) + delta);
        quantityInput.value = newQuantity;
        updatePrice(index);
    }

    function updatePrice(index) {
        let quantityInput = document.getElementById('quantity-' + index);
        let price = parseFloat(quantityInput.dataset.price);
        let totalPrice = (price * quantityInput.value).toFixed(2);
        document.getElementById('total-price-' + index).textContent = totalPrice + ' USD';
    }

    function updateHiddenInputs(index) {
        let quantityInput = document.getElementById('quantity-' + index);
        let hiddenQuantity = document.getElementById('hidden-quantity-' + index);
        let hiddenTotal = document.getElementById('hidden-totalp-' + index);
        
        hiddenQuantity.value = quantityInput.value;
        hiddenTotal.value = (parseFloat(quantityInput.dataset.price) * quantityInput.value).toFixed(2);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>

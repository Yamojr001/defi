<?php
session_start();

// Database connection
include'../includes/config.php';     

$tolalAmount = $_SESSION['total'];
$price = $_SESSION['price'];
// Get all unique coins from the database
$coins_query = "SELECT DISTINCT coin FROM accounts";
$coins_result = $conn->query($coins_query);

// Get networks based on selected coin
$networks = [];
if (isset($_POST['coin'])) {
    $selected_coin = $_POST['coin'];
    $networks_query = "SELECT DISTINCT network FROM accounts WHERE coin = '$selected_coin'";
    $networks_result = $conn->query($networks_query);
    while ($row = $networks_result->fetch_assoc()) {
        $networks[] = $row['network'];
    }
}

// Get account data based on selected coin and network
$account_data = [];
if (isset($_POST['coin']) && isset($_POST['network'])) {
    $selected_coin = $_POST['coin'];
    $selected_network = $_POST['network'];
    $data_query = "SELECT coin, network, address, image_path FROM accounts WHERE coin = '$selected_coin' AND network = '$selected_network'";
    $data_result = $conn->query($data_query);
    $_SESSION['coin'] =$selected_coin;
    while ($row = $data_result->fetch_assoc()) {
        $account_data[] = $row;
    }
    $_SESSION['coin'] = $selected_coin;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .row {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 20px auto;
        }
        .row img {
            max-width: 100%;
            max-height: 300px;
            margin-bottom: 20px;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
        }
        .copy-btn {
            background-color: #f1f1f1;
            padding: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        .payment-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>
<body>
<?php include'../includes/navother.php'; ?>
<div class="container">
    <h2>Select Coin and Network</h2>

    <form method="POST" action="index.php">
        <div class="form-group">
            <label for="coin">Select Coin:</label>
            <select name="coin" id="coin" class="form-control" required>
                <option value="">Select Coin</option>
                <?php while ($row = $coins_result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['coin']; ?>" <?php if (isset($_POST['coin']) && $_POST['coin'] == $row['coin']) echo 'selected'; ?>>
                        <?php echo $row['coin']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <?php if (isset($_POST['coin'])): ?>
            <div class="form-group">
                <label for="network">Select Network:</label>
                <select name="network" id="network" class="form-control" required>
                    <option value="">Select Network</option>
                    <?php foreach ($networks as $network): ?>
                        <option value="<?php echo $network; ?>" <?php if (isset($_POST['network']) && $_POST['network'] == $network) echo 'selected'; ?>>
                            <?php echo $network; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Show Data</button>
    </form>

    <?php if (isset($_POST['coin']) && isset($_POST['network'])): ?>
        <h3 class = "text-center">Account Information</h3>
        <?php foreach ($account_data as $data): ?>
            <div class="row">
                <img src="<?php echo $data['image_path']; ?>" alt="QR Code" class = "image-fluid">
                <div class="info">
                    <h3>Coin: <?php echo $data['coin']; ?></h3>
                    <h2>Amount: <?php echo $tolalAmount;?> USDT </h2>
                    <p><strong>Network:</strong> <?php echo $data['network']; ?></p>
                    <p><strong>Wallet Address:</strong> <span id="wallet-address"><?php echo $data['address']; ?></span></p>
                    <form method="get" action="upload.php">
                        <button type="submit" class="payment-button">I have made a payment</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include'../includes/footer.php'  ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

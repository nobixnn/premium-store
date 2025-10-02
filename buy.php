<?php
session_start();
require 'config.php';

// Check if product id is passed
if (!isset($_GET['id'])) {
    die("❌ Product not found.");
}

// Load products
$products = json_decode(file_get_contents("products.json"), true);
$product_id = intval($_GET['id']);
$product = null;

foreach ($products as $p) {
    if ($p['id'] === $product_id) {
        $product = $p;
        break;
    }
}

if (!$product) {
    die("❌ Invalid product.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy <?= htmlspecialchars($product['title']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin:0; padding:20px; }
        .box { max-width:500px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        h2 { margin-top:0; }
        .qr img { width:250px; }
        .btn { display:inline-block; background:#28a745; color:white; padding:10px 20px; border-radius:5px; text-decoration:none; }
        input, textarea { width:100%; padding:10px; margin-top:10px; border:1px solid #ccc; border-radius:5px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Buy: <?= htmlspecialchars($product['title']) ?></h2>
        <p><?= htmlspecialchars($product['desc']) ?></p>
        <p><b>Price:</b> ₹<?= $product['discount_price'] ?? $product['price'] ?></p>

        <div class="qr">
            <p>👇 Scan this QR to pay:</p>
            <img src="<?= $product['qr_code'] ?>" alt="QR Code">
        </div>

        <form action="verify.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <label>Enter Transaction ID (UPI/Paytm Ref. No.)</label>
            <input type="text" name="txn_id" required>

            <label>Your Telegram Username</label>
            <input type="text" name="telegram_username" placeholder="@yourusername" required>

            <button type="submit" class="btn">Submit Payment</button>
        </form>
    </div>
</body>
</html>

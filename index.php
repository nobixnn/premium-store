<?php
session_start();

// Agar login nahi hai to login page bhej do
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Products.json load karo
$products = json_decode(file_get_contents("products.json"), true);

// Unique categories nikal lo
$categories = array_unique(array_column($products, "category"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>💎 My Premium Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { 
      font-family: 'Segoe UI', Arial, sans-serif; 
      margin: 0; padding: 20px;
      min-height: 100vh;
      background: linear-gradient(270deg, #1a1a2e, #16213e, #0f3460, #53354a);
      background-size: 600% 600%;
      animation: gradientBG 20s ease infinite;
      color: white;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    header { text-align: center; margin-bottom: 30px; }
    header h1 { font-size: 32px; }

    .categories {
      text-align: center;
      margin-bottom: 20px;
    }
    .categories button {
      background: #ff416c;
      border: none;
      color: white;
      padding: 10px 18px;
      border-radius: 6px;
      margin: 5px;
      cursor: pointer;
    }

    .grid {
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); 
      gap: 25px; max-width: 1100px; margin: auto;
    }
    .card {
      background: white;
      color: black;
      border-radius: 12px;
      padding: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.3);
    }
    .card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
    }
    .card h3 { margin: 10px 0 5px; }
    .price { font-weight: bold; margin: 10px 0; }
    .discount { color: red; text-decoration: line-through; margin-right: 10px; }
    .buy {
      display: block;
      text-align: center;
      background: #ff4b2b;
      color: white;
      padding: 10px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>
  <script>
    function filterCategory(category) {
      let cards = document.querySelectorAll(".card");
      cards.forEach(card => {
        if (category === "all" || card.dataset.category === category) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    }
  </script>
</head>
<body>
  <header>
    <h1>💎 My Premium Store</h1>
    <p>Welcome! Choose your product below</p>
  </header>

  <!-- Categories -->
  <div class="categories">
    <button onclick="filterCategory('all')">All</button>
    <?php foreach ($categories as $cat): ?>
      <button onclick="filterCategory('<?php echo $cat; ?>')"><?php echo $cat; ?></button>
    <?php endforeach; ?>
  </div>

  <!-- Products Grid -->
  <div class="grid">
    <?php foreach ($products as $p): ?>
      <div class="card" data-category="<?php echo $p['category']; ?>">
        <img src="<?php echo $p['images'][0]; ?>" alt="<?php echo $p['title']; ?>">
        <h3><?php echo $p['title']; ?></h3>
        <p><?php echo $p['desc']; ?></p>
        <div class="price">
          <?php if (!empty($p['discount_price'])): ?>
            <span class="discount">₹<?php echo $p['price']; ?></span>
            ₹<?php echo $p['discount_price']; ?>
          <?php else: ?>
            ₹<?php echo $p['price']; ?>
          <?php endif; ?>
        </div>
        <a href="buy.php?id=<?php echo $p['id']; ?>" class="buy">Buy Now</a>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>

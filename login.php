<?php
session_start();

// users.json read
$users_file = __DIR__ . "/users.json";
$users = json_decode(file_get_contents($users_file), true);

// agar form submit hua
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $found = false;
    foreach ($users as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $user["username"];
            $_SESSION["telegram_id"] = $user["telegram_id"];

            // Redirect to home page
            header("Location: index.php");
            exit;
        }
    }
    $error = "❌ Invalid username or password!";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - My Premium Store</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(270deg, #1a1a2e, #16213e, #0f3460, #53354a);
      background-size: 600% 600%;
      animation: gradientBG 20s ease infinite;
      height: 100vh; display: flex; align-items: center; justify-content: center;
      color: #fff;
    }
    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .login-box {
      background: rgba(255,255,255,0.1);
      padding: 25px; border-radius: 12px;
      width: 300px; text-align: center;
    }
    input {
      width: 100%; padding: 10px; margin: 10px 0;
      border-radius: 8px; border: none;
    }
    button {
      width: 100%; padding: 10px;
      background: #ff416c; border: none; border-radius: 8px;
      color: #fff; font-weight: bold;
      cursor: pointer;
    }
    button:hover { background: #ff4b2b; }
    .error { color: #ffb3b3; margin: 10px 0; }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>🔐 Login</h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p style="margin-top:15px;font-size:14px;">
      👉 Account chahiye? Admin se contact karein.
    </p>
  </div>
</body>
</html>

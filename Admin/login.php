<?php
session_start();

$admin_username = 'admin';
$admin_password = 'qweqwe';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: Adminpage.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right,rgb(245, 174, 130),rgb(228, 222, 221)); 
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: rgb(95, 88, 77); 
      padding: 30px;
      border-radius: 10px;
      width: 300px;
      color: #fff;
      box-shadow: 0 0 15px rgba(112, 104, 104, 0.5);
      text-align: center;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #ffa500;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 93%;
      padding: 10px;
      margin: 10px 0 20px 0;
      border: none;
      border-radius: 5px;
    }

    .login-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #ffa500;
      border: none;
      color: #000;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-container input[type="submit"]:hover {
      background-color: #ff8c00;
    }

    .error {
      color: red;
      margin-bottom: 15px;
    }

    #logo {
      height: 100px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <img src="/niyaw/images/Logo.png" id="logo">
    <h2></h2>

    <?php if (isset($error)) : ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>

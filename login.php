<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'farmer') {
            header('Location: farmer_dashboard.php');
        } elseif ($user['role'] == 'retailer') {
            header('Location: retailer_dashboard.php');
        } elseif ($user['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        }
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5 col-md-4">
  <div class="card shadow p-4">
    <h3 class="text-center text-success">🐄 Smart Livestock Logger</h3>
    <form method="POST">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Login</button>
      <?php if(isset($error)) echo "<p class='text-danger mt-3 text-center'>$error</p>"; ?>
    </form>
  </div>
</div>
</body>
</html>

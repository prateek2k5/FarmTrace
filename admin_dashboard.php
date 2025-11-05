<?php
session_start();
include('db_connect.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Handle Add/Edit Drug
if (isset($_POST['add_drug'])) {
    $name = $_POST['drug_name'];
    $days = $_POST['withdrawal_period'];
    $conn->query("INSERT INTO drugs (drug_name, withdrawal_period) VALUES ('$name', '$days')");
}
$drugs = $conn->query("SELECT * FROM drugs");
?>
<!DOCTYPE html>
<html>
<head>
    <head>
  <meta charset="UTF-8">
  <title>Smart Livestock Logger</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e3fdfd, #e8f5e9);
      color: #333;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      border-bottom: 3px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .navbar-brand {
      font-weight: 600;
      font-size: 22px;
      letter-spacing: 0.5px;
    }

    /* Main Card */
    .dashboard-card {
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(12px);
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      transition: all 0.3s ease;
    }
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.25);
    }

    /* Buttons */
    .btn-modern {
      border-radius: 10px;
      font-weight: 500;
      letter-spacing: 0.3px;
      transition: all 0.3s ease;
    }
    .btn-modern:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Tables */
    .table {
      border-radius: 10px;
      overflow: hidden;
    }
    th {
      background-color: #4caf50;
      color: white;
    }
    tr:hover {
      background-color: #f1f8e9;
    }

    /* Titles */
    h4, h5 {
      font-weight: 600;
      color: #2e7d32;
    }

    /* Animated fade-in */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
      animation: fadeIn 0.6s ease;
    }

    /* Footer */
    footer {
      text-align: center;
      color: #555;
      font-size: 14px;
      padding: 15px;
      margin-top: 40px;
    }

  </style>
</head>

<title>Admin Dashboard</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <span class="navbar-brand">🧑‍💼 Admin Dashboard</span>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-6">
      <div class="card shadow p-3">
        <h5>Add / Update Drug</h5>
        <form method="POST">
          <input type="text" name="drug_name" class="form-control mb-2" placeholder="Drug Name" required>
          <input type="number" name="withdrawal_period" class="form-control mb-2" placeholder="Withdrawal Period (Days)" required>
          <button class="btn btn-success" name="add_drug">Save</button>
        </form>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow p-3">
        <h5>Existing Drugs</h5>
        <table class="table table-bordered">
          <tr><th>ID</th><th>Name</th><th>Withdrawal Days</th></tr>
          <?php while($row = $drugs->fetch_assoc()) { ?>
            <tr><td><?=$row['drug_id']?></td><td><?=$row['drug_name']?></td><td><?=$row['withdrawal_period']?></td></tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>

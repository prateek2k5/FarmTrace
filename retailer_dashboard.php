<?php
session_start();
include('db_connect.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'retailer') {
    header('Location: login.php');
    exit;
}

$result = null;
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $sql = "SELECT t.*, d.drug_name, u.username AS farmer_name
            FROM treatments t
            JOIN drugs d ON t.drug_id = d.drug_id
            JOIN users u ON t.farmer_id = u.user_id
            WHERE t.qr_filename = '$file'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Retailer Verification</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <span class="navbar-brand">🛒 Retailer Dashboard</span>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-5 col-md-6">
  <div class="card shadow p-4 text-center">
    <h4>Enter QR Code Filename</h4>
    <form method="GET">
      <input type="text" name="file" class="form-control mb-3" placeholder="e.g. qrcode_1730835234.png" required>
      <button type="submit" class="btn btn-success">Verify</button>
    </form>
  </div>

  <?php if ($result && $result->num_rows > 0) { 
      $row = $result->fetch_assoc();
      $today = date('Y-m-d');
      $is_safe = ($today >= $row['safe_date']);
  ?>
  <div class="card shadow p-4 mt-4">
    <h4 class="text-center <?= $is_safe ? 'text-success' : 'text-danger' ?>">
      <?= $is_safe ? '✅ SAFE for Consumption' : '⚠️ NOT SAFE Yet' ?>
    </h4>
    <table class="table mt-3">
      <tr><th>Animal ID</th><td><?= $row['animal_id'] ?></td></tr>
      <tr><th>Farmer</th><td><?= $row['farmer_name'] ?></td></tr>
      <tr><th>Drug</th><td><?= $row['drug_name'] ?></td></tr>
      <tr><th>Treatment Date</th><td><?= $row['treatment_date'] ?></td></tr>
      <tr><th>Safe Date</th><td><?= $row['safe_date'] ?></td></tr>
      <tr><th>QR File</th><td><?= $row['qr_filename'] ?></td></tr>
    </table>
  </div>
  <?php } elseif (isset($_GET['file'])) { ?>
  <div class="card shadow p-3 mt-4">
    <p class="text-danger text-center">❌ No record found for this QR file.</p>
  </div>
  <?php } ?>
</div>

</body>
</html>

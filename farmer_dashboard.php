<?php
session_start();
include('db_connect.php');

// Check if farmer is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'farmer') {
    header("Location: login.php");
    exit;
}

// Fetch drug list for dropdown
$drugResult = $conn->query("SELECT * FROM drugs");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <span class="navbar-brand">👨‍🌾 Farmer Dashboard</span>
    <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h4 class="text-success">Add Treatment Record</h4>
  <form action="" method="POST">
    <div class="row">
      <div class="col-md-4">
        <label>Animal ID</label>
        <input type="text" name="animal_id" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label>Drug</label>
        <select id="drug_id" name="drug_id" class="form-select" required>
          <option value="">--Select Drug--</option>
          <?php while($row=$drugResult->fetch_assoc()){ ?>
          <option value="<?=$row['drug_id']?>"><?=$row['drug_name']?></option>
          <?php } ?>
        </select>
      </div>

      <div class="col-md-4">
        <label>Withdrawal Period (Days)</label>
        <input type="text" id="withdrawal_period" class="form-control" readonly>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-4">
        <label>Treatment Date</label>
        <input type="date" name="treatment_date" class="form-control" required>
      </div>
    </div>

    <button class="btn btn-success mt-3" name="submit">Save & Generate QR</button>
  </form>
</div>

<script>
// Auto-fetch withdrawal period when drug selected
$("#drug_id").on("change", function(){
    var did = $(this).val();
    $.get("get_withdrawal.php", { id: did }, function(data){
        $("#withdrawal_period").val(data);
    });
});
</script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    require_once 'phpqrcode/qrlib.php';

    $username       = $_SESSION['username'];
    $animal_id      = $_POST['animal_id'];
    $drug_id        = (int)$_POST['drug_id'];
    $treatment_date = $_POST['treatment_date'];

    // get farmer_id
    $farmerRes = $conn->query("SELECT user_id FROM users WHERE username='{$conn->real_escape_string($username)}'");
    $farmer_id = $farmerRes->fetch_assoc()['user_id'];

    // get drug details
    $drugRes  = $conn->query("SELECT drug_name, withdrawal_period FROM drugs WHERE drug_id={$drug_id}");
    $drugRow  = $drugRes->fetch_assoc();
    $drug_name = $drugRow['drug_name'];
    $wdays     = (int)$drugRow['withdrawal_period'];

    // safe date
    $safe_date = date('Y-m-d', strtotime($treatment_date . " + {$wdays} days"));

    // insert treatment
    $ins = "INSERT INTO treatments (farmer_id, animal_id, drug_id, treatment_date, safe_date)
            VALUES ({$farmer_id}, '{$conn->real_escape_string($animal_id)}', {$drug_id},
                    '{$conn->real_escape_string($treatment_date)}', '{$safe_date}')";
    $conn->query($ins);

    // ALWAYS capture the id here
    $treatment_id = $conn->insert_id;   // << this replaces your undefined $tid

    // generate QR
    $qr_text     = "Animal ID: {$animal_id} | Drug: {$drug_name} | Safe on: {$safe_date}";
    $qr_filename = "qrcode_{$treatment_id}.png";
    $qr_path     = "qrcodes/{$qr_filename}";
    if (!is_dir('qrcodes')) { mkdir('qrcodes', 0777, true); }
    QRcode::png($qr_text, $qr_path);

    // save file name & path back to DB
    // (Run the ALTER TABLE once to add qr_filename if you haven't already)
    // ALTER TABLE treatments ADD COLUMN qr_filename VARCHAR(255);
    $upd = "UPDATE treatments SET qr_code_path='{$conn->real_escape_string($qr_path)}',
                                 qr_filename='{$conn->real_escape_string($qr_filename)}'
            WHERE treatment_id={$treatment_id}";
    $conn->query($upd);

    // redirect to viewer
    header("Location: ./qr_code.php?file=" . urlencode($qr_filename));
    exit;
}
?>


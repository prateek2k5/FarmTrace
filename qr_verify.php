<?php
include('db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>QR Code Verification</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
body {
    background: #f8fbff;
}
.result-card {
    max-width: 600px;
    margin: 40px auto;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    background: white;
    padding: 30px;
    text-align: center;
}
.safe {
    color: green;
    font-weight: bold;
}
.unsafe {
    color: red;
    font-weight: bold;
}
</style>
</head>
<body>

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <span class="navbar-brand">🧾 QR Code Verification</span>
    <a href="index.html" class="btn btn-light btn-sm">Home</a>
  </div>
</nav>

<div class="container mt-4 text-center">
    <h4>Enter or Scan QR Code Data</h4>
    <form method="POST">
        <input type="text" name="qr_text" class="form-control w-75 mx-auto mt-3" placeholder="Paste QR code data here" required>
        <button class="btn btn-success mt-3" type="submit">Check Safety</button>
    </form>
</div>

<?php
if(isset($_POST['qr_text'])){
    $qr_text = $_POST['qr_text'];

    // extract Treatment ID if included
    preg_match('/Treatment ID: (\d+)/', $qr_text, $match);
    if(isset($match[1])){
        $tid = intval($match[1]);
        $res = $conn->query("SELECT t.*, d.drug_name FROM treatments t JOIN drugs d ON t.drug_id=d.drug_id WHERE treatment_id=$tid");
        if($res->num_rows > 0){
            $row = $res->fetch_assoc();
            $today = date('Y-m-d');
            echo "<div class='result-card'>";
            echo "<h5>Animal ID: {$row['animal_id']}</h5>";
            echo "<p>Drug Used: <b>{$row['drug_name']}</b></p>";
            echo "<p>Treatment Date: {$row['treatment_date']}</p>";
            echo "<p>Safe Date: {$row['safe_date']}</p>";

            if($today >= $row['safe_date']){
                echo "<h4 class='safe'>✅ Product is SAFE for sale or consumption</h4>";
            } else {
                echo "<h4 class='unsafe'>⚠️ Product is NOT YET SAFE. Wait till {$row['safe_date']}.</h4>";
            }
            echo "</div>";
        } else {
            echo "<div class='alert alert-danger text-center mt-3'>Invalid QR data or treatment not found.</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center mt-3'>Unable to read treatment ID from QR data.</div>";
    }
}
?>
</body>
</html>

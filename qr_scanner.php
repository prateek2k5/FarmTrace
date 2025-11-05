<?php
include('db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Scanner | Product Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body {
            background: linear-gradient(to right, #e6f0ff, #f7fbff);
            font-family: 'Poppins', sans-serif;
        }
        .scanner-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
        }
        #reader {
            width: 100%;
            border-radius: 10px;
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
    <span class="navbar-brand">📷 Live QR Code Scanner</span>
    <a href="index.html" class="btn btn-light btn-sm">Home</a>
  </div>
</nav>

<div class="scanner-container">
    <h4>Scan QR Code to Check Product Safety</h4>
    <div id="reader"></div>
    <div id="result" class="mt-4"></div>
</div>

<script>
function onScanSuccess(decodedText, decodedResult) {
    document.getElementById("result").innerHTML = "<b>Scanned:</b> " + decodedText + "<br>Checking in database...";
    // send scanned data to server
    fetch('qr_verify.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'qr_text=' + encodeURIComponent(decodedText)
    })
    .then(res => res.text())
    .then(html => {
        document.open();
        document.write(html);
        document.close();
    });
}

function onScanFailure(error) {
    // Ignore errors or log to console
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", 
    { fps: 10, qrbox: { width: 250, height: 250 } }
);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

</body>
</html>

<?php
// qr_view.php
// This page allows retailers/consumers to view or scan QR details

$animal_id = isset($_GET['animal_id']) ? $_GET['animal_id'] : '';

if ($animal_id == '') {
    echo "<h2>No Animal ID provided.</h2>";
    exit;
}

$filename = "qrcodes/qrcode_" . $animal_id . ".png";

if (file_exists($filename)) {
    echo "<h2>QR Code for Animal ID: $animal_id</h2>";
    echo "<img src='$filename' alt='QR Code'><br><br>";
    echo "<p>Scan this QR code to verify product authenticity.</p>";
} else {
    echo "<h2>QR Code not found for Animal ID: $animal_id</h2>";
}
?>

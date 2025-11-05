<?php
session_start();

// If opened directly without QR generation
if (!isset($_GET['file'])) {
    echo "<h3 style='color:red; text-align:center;'>No QR file specified in URL.</h3>";
    exit;
}

$file = basename($_GET['file']); // only filename (safe)
$path = __DIR__ . "/qrcodes/" . $file; // full path in your PC
$webPath = "qrcodes/" . $file;         // web path (for <img src>)

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generated</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container text-center mt-5">
    <div class="card shadow p-4">
        <h3 class="text-success mb-4">✅ QR Code Generated Successfully!</h3>

        <?php
        if (file_exists($path)) {
            echo "<p><strong>File stored at:</strong> $path</p>";
            echo "<img src='$webPath' alt='QR Code' class='img-thumbnail shadow' width='200' height='200'><br><br>";
        } else {
            echo "<p class='text-danger'>QR file not found in folder! (Checked: $path)</p>";
        }
        ?>

        <a href="farmer_dashboard.php" class="btn btn-success mt-3">⬅ Back to Dashboard</a>
    </div>
</div>
</body>
</html>

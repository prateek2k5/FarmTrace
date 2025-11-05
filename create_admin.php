<?php
include('db_connect.php');

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$role = 'admin';

$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
if ($conn->query($sql)) {
    echo "✅ Admin user created successfully!<br>";
    echo "Username: admin<br>Password: admin123<br>Role: admin";
} else {
    echo "❌ Error: " . $conn->error;
}
?>

<?php
include('db_connect.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT withdrawal_period FROM drugs WHERE drug_id=$id");
    if($row = $result->fetch_assoc()){
        echo $row['withdrawal_period'];
    }
}
?>

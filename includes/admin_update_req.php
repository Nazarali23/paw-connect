<?php
include 'db_connect.php';

if (isset($_GET['id']) && isset($_GET['status']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $type = $_GET['type'];

    if ($type == 'adoption') {
        $sql = "UPDATE adoption_requests SET status='$status' WHERE id=$id";
        if ($status == 'approved') {
            $res = $conn->query("SELECT pet_id FROM adoption_requests WHERE id=$id");
            $row = $res->fetch_assoc();
            $pid = $row['pet_id'];
            $conn->query("UPDATE pets SET status='adopted' WHERE id=$pid");
        }

    } elseif ($type == 'surrender') {
        $sql = "UPDATE surrender_requests SET status='$status' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        header("location: ../pages/admin.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
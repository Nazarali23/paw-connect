<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['shelter_id'];
    $shelter_name = $_POST['shelter_name'];
    $shelter_type = $_POST['shelter_type'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $admin_name = $_POST['admin_name'];
    $admin_surname = $_POST['admin_surname'];
    $admin_email = $_POST['admin_email'];
    $phone = $_POST['phone'];

    $new_pass = $_POST['new_password'];

    if (!empty($new_pass)) {
        $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE shelters SET 
                shelter_name=?, shelter_type=?, address=?, country=?, city=?, 
                admin_name=?, admin_surname=?, admin_email=?, phone=?, password=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $shelter_name, $shelter_type, $address, $country, $city, $admin_name, $admin_surname, $admin_email, $phone, $hashed, $id);
    } else {
        $sql = "UPDATE shelters SET 
                shelter_name=?, shelter_type=?, address=?, country=?, city=?, 
                admin_name=?, admin_surname=?, admin_email=?, phone=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $shelter_name, $shelter_type, $address, $country, $city, $admin_name, $admin_surname, $admin_email, $phone, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['shelter_name'] = $shelter_name;
        $_SESSION['admin_name'] = $admin_name;

        echo "<script>alert('Profile updated successfully!'); window.location.href='../pages/admin.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['login-password'];

    $sql = "SELECT id, shelter_name, password, admin_name, profile_picture, country, city, address, phone  FROM shelters WHERE login_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $shelter_name, $hashed_pass, $admin_name, $pic, $country, $city, $address, $phone);
        $stmt->fetch();

        if (password_verify($password, $hashed_pass)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["shelter_id"] = $id;
            $_SESSION["shelter_name"] = $shelter_name;
            $_SESSION["admin_name"] = $admin_name;
            $_SESSION["shelter_pic"] = $pic;
            $_SESSION["country"] = $country;
            $_SESSION["city"] = $city;
            $_SESSION["address"] = $address;
            $_SESSION["phone"] = $phone;
            header("location: ../pages/admin.php");
        } else {
            echo "<script>alert('Wrong Password!'); window.location.href='../pages/login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='../pages/login.php';</script>";
    }
}
?>
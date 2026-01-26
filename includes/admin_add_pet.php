<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../pages/login.php");
    exit;
}
$country = $_SESSION['country'];
$city = $_SESSION['city'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $shelter_id = $_SESSION['shelter_id'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $age_value = $_POST['age'];
    $age_unit = $_POST['unit'];
    $gender = $_POST['gender'];
    $description = isset($_POST['desc']) ? $_POST['desc'] : '';

    $is_vaccinated = isset($_POST['is_vaccinated']) ? 1 : 0;
    $is_neutered = isset($_POST['is_neutered']) ? 1 : 0;
    $target_dir = "../public/uploads/shelters/" . $country . "/" . $city . "/pets/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($_FILES["pet_image"]["name"], PATHINFO_EXTENSION);
    $new_filename = "pet_" . time() . "_" . uniqid() . "." . $file_extension;
    $target_file = $target_dir . $new_filename;

    $db_image_path = "public/uploads/shelters/" . $country . "/" . $city . "/pets/" . $new_filename;

    if (move_uploaded_file($_FILES["pet_image"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO pets (
            shelter_id, 
            name, 
            type, 
            age_value, 
            age_unit, 
            gender, 
            description, 
            main_image, 
            is_vaccinated, 
            is_neutered,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ississssii",
            $shelter_id,
            $name,
            $type,
            $age_value,
            $age_unit,
            $gender,
            $description,
            $db_image_path,
            $is_vaccinated,
            $is_neutered
        );

        if ($stmt->execute()) {
            echo "<script>alert('New pet added successfully!'); window.location.href='../pages/admin.php';</script>";
        } else {
            echo "Database Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        echo "<script>alert('Error uploading image.'); window.location.href='../pages/admin.php';</script>";
    }

    $conn->close();
}
?>
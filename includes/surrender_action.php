<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ref_code = "SUR-" . rand(100000, 999999);

    $shelter_id = $_POST['shelter_id'];
    $owner_name = $_POST['owner_name'];
    $owner_email = $_POST['owner_email'];
    $owner_phone = $_POST['owner_phone'];

    $owner_country = $_POST['country'];
    $owner_city = $_POST['city'];

    $pet_name = $_POST['pet_name'];
    $pet_type = $_POST['pet_type'];
    $pet_age = $_POST['pet_age'];
    $pet_breed = $_POST['pet_breed'];
    $description = $_POST['pet_desc'];

    $target_dir = "../public/uploads/surrenders/" . $owner_country . "/" . $owner_city . "/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = pathinfo($_FILES["pet_photo"]["name"], PATHINFO_EXTENSION);
    $new_filename = "surrender_" . time() . "." . $file_extension;
    $target_file = "../public/uploads/surrenders/" . $owner_country . "/" . $owner_city . "/" . $new_filename;

    $db_photo_path = "public/uploads/surrenders/" . $owner_country . "/" . $owner_city . "/" . $new_filename;

    if (move_uploaded_file($_FILES["pet_photo"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO surrender_requests (
            ref_code, 
            shelter_id, 
            owner_name, 
            owner_email, 
            owner_phone, 
            owner_country, 
            owner_city, 
            pet_name, 
            pet_type, 
            pet_age, 
            pet_breed, 
            description, 
            pet_photo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sisssssssisss",
            $ref_code,
            $shelter_id,
            $owner_name,
            $owner_email,
            $owner_phone,
            $owner_country,
            $owner_city,
            $pet_name,
            $pet_type,
            $pet_age,
            $pet_breed,
            $description,
            $db_photo_path
        );

        if ($stmt->execute()) {
            echo "<script>alert('Application Successful! Reference Code: $ref_code'); window.location.href='../pages/index.php';</script>";
        } else {
            echo "Database Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        echo "Error uploading image.";
    }

    $conn->close();
}
?>
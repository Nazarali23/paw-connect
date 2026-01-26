<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $shelter_name = $_POST['sheltername'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $shelter_type = $_POST['sheltertype'];

    $admin_name = $_POST['adminname'];
    $admin_surname = $_POST['adminsurname'];
    $admin_email = $_POST['adminemail'];
    $login_email = $_POST['loginemail'];
    $verification_code = $_POST['verificationcode'];

    $raw_password = $_POST['sign-up-password'];
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);


    $target_dir_img = "../public/uploads/shelters/" . $country . "/" . $city . "/images/";
    $target_dir_doc = "../public/uploads/shelters/" . $country . "/" . $city . "/documents/";

    if (!file_exists($target_dir_img))
        mkdir($target_dir_img, 0777, true);
    if (!file_exists($target_dir_doc))
        mkdir($target_dir_doc, 0777, true);


    $profile_picture_path = "";
    if (isset($_FILES['shelterpicture']) && $_FILES['shelterpicture']['error'] == 0) {
        $ext = pathinfo($_FILES['shelterpicture']['name'], PATHINFO_EXTENSION);
        $new_name = "shelter_" . time() . "." . $ext;
        $profile_picture_path = $target_dir_img . $new_name;
        move_uploaded_file($_FILES['shelterpicture']['tmp_name'], $profile_picture_path);
    }

    $document_path = "";
    if (isset($_FILES['shelterdocument']) && $_FILES['shelterdocument']['error'] == 0) {
        $ext = pathinfo($_FILES['shelterdocument']['name'], PATHINFO_EXTENSION);
        $new_name = "doc_" . time() . "." . $ext;
        $document_path = $target_dir_doc . $new_name;
        move_uploaded_file($_FILES['shelterdocument']['tmp_name'], $document_path);
    }


    $sql = "INSERT INTO shelters (
        shelter_name, phone, country, city, address, shelter_type, 
        admin_name, admin_surname, admin_email, login_email, password,
        profile_picture, official_document, verification_code
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssssssssss",
        $shelter_name,
        $phone,
        $country,
        $city,
        $address,
        $shelter_type,
        $admin_name,
        $admin_surname,
        $admin_email,
        $login_email,
        $hashed_password,
        $profile_picture_path,
        $document_path,
        $verification_code
    );

    if ($stmt->execute()) {
        header("refresh:3;url=../pages/login.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
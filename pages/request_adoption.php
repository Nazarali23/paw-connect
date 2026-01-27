<?php
include '../includes/db_connect.php';

$pet_id = isset($_GET['pet_id']) ? $_GET['pet_id'] : '';
$shelter_id = '';
$pet_name = 'Unknown Pet';
$pet_image = 'assets/images/icons/paw.png';

if ($pet_id) {
    $pid = intval($pet_id);
    $sql_shelter = "SELECT shelter_id, name, main_image, type, age_value, age_unit FROM pets WHERE id = $pid";
    $res = $conn->query($sql_shelter);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $shelter_id = $row['shelter_id'];
        $pet_name = $row['name'];
        $pet_image = "../" . $row['main_image'];
        $pet_details = ucfirst($row['type']) . " • " . $row['age_value'] . " " . $row['age_unit'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ref_code = "REQ-" . rand(100000, 999999);

    $pet_id = $_POST['pet_id'];
    $shelter_id = $_POST['shelter_id'];
    $name = $_POST['applicant_name'];
    $email = $_POST['applicant_email'];
    $phone = $_POST['applicant_phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $msg = $_POST['message'];

    $sql = "INSERT INTO adoption_requests (ref_code, pet_id, shelter_id, applicant_name, applicant_email, applicant_phone, applicant_country, applicant_city, message) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissssss", $ref_code, $pet_id, $shelter_id, $name, $email, $phone, $country, $city, $msg);

    if ($stmt->execute()) {
        echo "<script>alert('Application sent successfully! Ref Code: $ref_code'); window.location.href='adopt.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawConnect - Adopt <?php echo htmlspecialchars($pet_name); ?></title>
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/adopt.css">

    <script src="../assets/js/main.js" defer></script>
    <script src="../assets/js/locations.js" defer></script>

</head>

<body>
    <?php include '../includes/nav.php'; ?>

    <main class="adoption-request-page">
        <div class="adoption-container">

            <div class="pet-image-side">
                <img src="<?php echo htmlspecialchars($pet_image); ?>" alt="<?php echo htmlspecialchars($pet_name); ?>">
                <div class="pet-image-overlay">
                    <h2><?php echo htmlspecialchars($pet_name); ?></h2>
                    <p>
                        <?php echo isset($pet_details) ? $pet_details : ''; ?>
                    </p>
                </div>
            </div>

            <div class="form-side">
                <h2>Adoption Application</h2>
                <p>
                    Apply to adopt <b><?php echo htmlspecialchars($pet_name); ?></b>
                </p>

                <form method="POST">
                    <input type="hidden" name="pet_id" value="<?php echo $pet_id; ?>">
                    <input type="hidden" name="shelter_id" value="<?php echo $shelter_id; ?>">

                    <input type="text" name="applicant_name" placeholder="Your Full Name" required class="input-info">
                    <input type="email" name="applicant_email" placeholder="Your Email" required class="input-info">
                    <input type="tel" name="applicant_phone" placeholder="Phone Number" required class="input-info">

                    <div class="location-group">
                        <select name="country" id="country" required class="input-info">
                            <option value="">Select Country</option>
                        </select>
                        <select name="city" id="city" required class="input-info">
                            <option value="">Select City</option>
                        </select>
                    </div>

                    <textarea name="message"
                        placeholder="Why do you want to adopt this pet? (Housing, experience, etc.)" required rows="4"
                        class="input-info"></textarea>

                    <button type="submit" class="search-button">Send Request</button>
                    <a href="adopt.php" class="cancel-link">Cancel</a>
                </form>
            </div>

        </div>
    </main>

    <?php include_once '../includes/footer.php'; ?>
</body>

</html>
<?php
include 'db_connect.php';

if (isset($_GET['country']) && isset($_GET['city'])) {
    $country = $_GET['country'];
    $city = $_GET['city'];

    $sql = "SELECT id, shelter_name, address FROM shelters WHERE country = ? AND city = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $country, $city);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<label class="shelter-option">
                    <input type="radio" name="shelter_id" value="' . $row["id"] . '" required> 
                    <b>' . htmlspecialchars($row["shelter_name"]) . '</b> 
                    <span>(' . htmlspecialchars($row["address"]) . ')</span>
                  </label>';
        }
    } else {
        echo '<p>No shelters found in this location. Please try another city.</p>';
    }
    $stmt->close();
}
?>
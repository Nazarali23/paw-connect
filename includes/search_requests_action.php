<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['user_name'];
    $phone = $_POST['user_phone'];

    if (empty($name) || empty($phone)) {
        echo '<p class="error-text">Please fill in all fields.</p>';
        exit;
    }

    $found = false;

    $sql_adopt = "SELECT ar.*, p.name as pet_name, s.shelter_name, s.phone as shelter_phone 
                  FROM adoption_requests ar 
                  JOIN pets p ON ar.pet_id = p.id 
                  JOIN shelters s ON ar.shelter_id = s.id 
                  WHERE ar.applicant_name LIKE ? AND ar.applicant_phone = ? 
                  ORDER BY ar.request_date DESC";

    $stmt = $conn->prepare($sql_adopt);
    $search_name = "%" . $name . "%";
    $stmt->bind_param("ss", $search_name, $phone);
    $stmt->execute();
    $res_adopt = $stmt->get_result();

    if ($res_adopt->num_rows > 0) {
        $found = true;
        while ($row = $res_adopt->fetch_assoc()) {
            $statusClass = $row['status'];

            echo '<div class="request-card adoption-card">
                    <div class="card-header">
                        <h4 class="req-title adoption-text">Adoption Request</h4>
                        <span class="status ' . $statusClass . '">' . ucfirst($row['status']) . '</span>
                    </div>
                    <p><strong>Ref Code:</strong> #' . $row['ref_code'] . '</p>
                    <p><strong>Pet:</strong> ' . $row['pet_name'] . '</p>
                    <p><strong>Shelter:</strong> ' . $row['shelter_name'] . '</p>
                    <div class="card-footer">
                        <p class="helper-text">Need to contact shelter?</p>
                        <a href="tel:' . $row['shelter_phone'] . '" class="contact-shelter-btn btn-orange">Call Shelter: ' . $row['shelter_phone'] . '</a>
                    </div>
                  </div>';
        }
    }

    $sql_surrender = "SELECT sr.*, s.shelter_name, s.phone as shelter_phone 
                      FROM surrender_requests sr 
                      JOIN shelters s ON sr.shelter_id = s.id 
                      WHERE sr.owner_name LIKE ? AND sr.owner_phone = ? 
                      ORDER BY sr.created_at DESC";

    $stmt2 = $conn->prepare($sql_surrender);
    $stmt2->bind_param("ss", $search_name, $phone);
    $stmt2->execute();
    $res_surrender = $stmt2->get_result();

    if ($res_surrender->num_rows > 0) {
        $found = true;
        while ($row = $res_surrender->fetch_assoc()) {
            $statusClass = strtolower($row['status']);

            echo '<div class="request-card surrender-card">
                    <div class="card-header">
                        <h4 class="req-title surrender-text">Surrender Request</h4>
                        <span class="status ' . $statusClass . '">' . ucfirst($row['status']) . '</span>
                    </div>
                    <p><strong>Ref Code:</strong> #' . $row['ref_code'] . '</p>
                    <p><strong>Pet:</strong> ' . $row['pet_name'] . ' (' . $row['pet_type'] . ')</p>
                    <p><strong>Target Shelter:</strong> ' . $row['shelter_name'] . '</p>
                    <div class="card-footer">
                        <p class="helper-text">Need to contact shelter?</p>
                        <a href="tel:' . $row['shelter_phone'] . '" class="contact-shelter-btn btn-blue">Call Shelter: ' . $row['shelter_phone'] . '</a>
                    </div>
                  </div>';
        }
    }

    if (!$found) {
        echo '<div class="empty-state">
                <img src="../assets/images/icons/search.png" class="empty-icon" alt="search">
                <p>No requests found for this name and phone number.</p>
              </div>';
    }
}
?>
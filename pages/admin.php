<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
include '../includes/db_connect.php';

$shelter_id = $_SESSION['shelter_id'];
$myShelter = $conn->query("SELECT * FROM shelters WHERE id = $shelter_id")->fetch_assoc();
$profilePic = !empty($myShelter["profile_picture"]) ? "../" . $myShelter["profile_picture"] : "../assets/images/icons/user.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PawConnect - Admin Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/adopt.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">
    <script src="../assets/js/main.js" defer></script>
    <script src="../assets/js/admin.js" defer></script>
</head>

<body id="admin-page">
    <nav class="header">
        <img src="../assets/images/icons/logo.png" alt="logo" class="logo">
        <h3 class="site-name">PawConnect</h3>
    </nav>
    <div class="admin-container">

        <aside class="sidebar glass-panel">
            <div class="nav-menu">
                <div class="profile-section">
                    <div class="profile-icon">
                        <img src="<?php echo $profilePic; ?>" alt="profile-icon">
                    </div>
                    <div class="profile-text">
                        <h3><?php echo htmlspecialchars($myShelter["admin_name"]); ?></h3>
                        <p class="shelter-name"><?php echo htmlspecialchars($myShelter["shelter_name"]); ?></p>
                    </div>
                </div>
                <ul class="nav-links">
                    <li><a href="#" id="nav-dashboard" class="nav-item active">Dashboard</a></li>
                    <li><a href="#" id="nav-pets-list" class="nav-item">Pet Listings</a></li>
                    <li><a href="#" id="nav-requests" class="nav-item">Requests</a></li>
                    <li><a href="#" id="nav-history" class="nav-item">History</a></li>
                    <li><a href="#" id="nav-settings" class="nav-item">Settings</a></li>
                    <li><a href="../includes/logout.php" id="nav-logout" class="nav-item">Logout</a></li>
                </ul>
                <div class="hamburger"><span></span><span></span><span></span></div>
            </div>
        </aside>

        <main class="main-content">

            <?php
            $stats = $conn->query("SELECT 
                (SELECT COUNT(*) FROM pets WHERE shelter_id=$shelter_id AND status='available') as av,
                (SELECT COUNT(*) FROM pets WHERE shelter_id=$shelter_id AND status='adopted') as ad,
                (SELECT COUNT(*) FROM adoption_requests WHERE shelter_id=$shelter_id AND status='pending') as req_a,
                (SELECT COUNT(*) FROM surrender_requests WHERE shelter_id=$shelter_id AND status='pending') as req_s
            ")->fetch_assoc();
            ?>
            <section class="stats-row">
                <h2 class="admin-section-header">Statistics</h2>
                <div class="stat-card glass-panel border-blue">
                    <p class="stat-label">AVAILABLE</p>
                    <h3 class="stat-number"><?php echo $stats['av']; ?></h3>
                </div>
                <div class="stat-card glass-panel border-green">
                    <p class="stat-label">ADOPTED</p>
                    <h3 class="stat-number"><?php echo $stats['ad']; ?></h3>
                </div>
                <div class="stat-card glass-panel border-orange">
                    <p class="stat-label">PENDING ADOPTIONS</p>
                    <h3 class="stat-number"><?php echo $stats['req_a']; ?></h3>
                </div>
                <div class="stat-card glass-panel border-red">
                    <p class="stat-label">PENDING SURRENDERS</p>
                    <h3 class="stat-number"><?php echo $stats['req_s']; ?></h3>
                </div>
            </section>

            <section class="pets-section hidden">
                <h2 class="admin-section-header">Pets Management</h2>

                <div class="glass-panel">
                    <h4>Add New Pet</h4>
                    <form action="../includes/admin_add_pet.php" method="POST" enctype="multipart/form-data"
                        class="add-pet-form">
                        <input type="text" name="name" placeholder="Name" required class="input-info form-input-flex">

                        <select name="type" class="input-info form-select-auto" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="bird">Bird</option>
                            <option value="fish">Fish</option>
                            <option value="rabbit">Rabbit</option>
                            <option value="other">Other</option>
                        </select>

                        <input type="number" name="age" placeholder="Age" required class="input-info form-input-small">

                        <select name="unit" class="input-info form-select-auto">
                            <option value="years">Years</option>
                            <option value="months">Months</option>
                        </select>

                        <select name="gender" class="input-info form-select-auto">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>

                        <input type="file" name="pet_image" required class="input-info form-input-flex">

                        <div class="checkbox-group">
                            <label><input type="checkbox" name="is_vaccinated" value="1"> Vaccinated</label>
                            <label><input type="checkbox" name="is_neutered" value="1"> Neutered</label>
                            <label><input type="checkbox" name="is_microchipped" value="1"> Microchipped</label>
                            <label><input type="checkbox" name="is_house_trained" value="1"> House Trained</label>
                            <label><input type="checkbox" name="has_special_needs" value="1"> Special Needs</label>
                        </div>

                        <button type="submit" class="pets-edit-button">Add Pet</button>
                    </form>
                </div>

                <div class="pets-control">
                    <div class="pets-section-content">
                        <?php
                        $res = $conn->query("SELECT * FROM pets WHERE shelter_id=$shelter_id");

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $imgSrc = "../" . $row['main_image'];
                                echo '
                                <div class="pet-card">
                                    <img src="' . $imgSrc . '" alt="pet">
                                    <div class="pet-card-info">
                                        <h4>' . $row["name"] . '</h4>
                                        <div class="pet-properties">
                                            <p>' . $row["age_value"] . ' ' . $row["age_unit"] . '</p>
                                            <p>' . ucfirst($row["gender"]) . '</p>
                                            <p>' . $row["status"] . '</p>
                                            <a href="../includes/admin_delete_pet.php?id=' . $row["id"] . '" class="delete-link">Delete</a>
                                        </div>
                                    </div>
                                </div>';
                            }
                        } else {
                            echo "<p>No pets added yet.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <section class="requests-section hidden">
                <div class="requests-header-group">
                    <h2 class="admin-section-header">Incoming Requests</h2>
                    <div class="request-tabs">
                        <button class="tab-btn active" data-target="req-adoption"><i class="fa fa-paw"></i>
                            Adoptions</button>
                        <button class="tab-btn" data-target="req-surrender"><i class="fa fa-home"></i>
                            Surrenders</button>
                    </div>
                </div>

                <div id="req-adoption" class="request-tab-content active">
                    <div class="requests-grid">
                        <?php
                        $reqsA = $conn->query("SELECT ar.*, p.name as pname, p.main_image FROM adoption_requests ar JOIN pets p ON ar.pet_id=p.id WHERE ar.shelter_id=$shelter_id AND ar.status='pending' ORDER BY ar.request_date DESC");
                        if ($reqsA->num_rows > 0) {
                            while ($r = $reqsA->fetch_assoc()) {
                                $imgSrc = "../" . $r['main_image'];
                                echo '<div class="request-card glass-panel border-orange">
                                    <div class="req-header"><span class="req-id">#' . $r["ref_code"] . '</span></div>
                                    <div class="req-body">
                                        <div class="req-pet-info">
                                            <img src="' . $imgSrc . '">
                                            <div class="req-pet-text">
                                                <h4>' . htmlspecialchars($r["applicant_name"]) . '</h4>
                                                <p>Wants: <b>' . htmlspecialchars($r["pname"]) . '</b></p>
                                            </div>
                                        </div>
                                        <p>From: ' . htmlspecialchars($r["applicant_city"]) . ', ' . htmlspecialchars($r["applicant_country"]) . '</p>
                                        <p>Phone: ' . htmlspecialchars($r["applicant_phone"]) . '</p>
                                        <p><i>"' . htmlspecialchars($r["message"]) . '"</i></p>
                                        <span class="badge pending">Pending</span>
                                    </div>
                                    <div class="req-actions">
                                        <a href="../includes/admin_update_req.php?id=' . $r["id"] . '&type=adoption&status=approved" class="btn-action approve">Approve</a>
                                        <a href="../includes/admin_update_req.php?id=' . $r["id"] . '&type=adoption&status=rejected" class="btn-action reject">Reject</a>
                                    </div>
                                  </div>';
                            }
                        } else {
                            echo "<p>No pending adoption requests.</p>";
                        }
                        ?>
                    </div>
                </div>

                <div id="req-surrender" class="request-tab-content">
                    <div class="requests-grid">
                        <?php
                        $reqsS = $conn->query("SELECT * FROM surrender_requests WHERE shelter_id=$shelter_id AND status='pending' ORDER BY created_at DESC");
                        if ($reqsS->num_rows > 0) {
                            while ($s = $reqsS->fetch_assoc()) {
                                $imgSrc = "../" . $s['pet_photo'];
                                echo '<div class="request-card glass-panel border-blue">
                                    <div class="req-header"><span class="req-id">#' . $s["ref_code"] . '</span></div>
                                    <div class="req-body">
                                        <div class="req-pet-info">
                                            <img src="' . $imgSrc . '">
                                            <div class="req-pet-text">
                                                <h4>' . $s["owner_name"] . '</h4>
                                                <p>Pet: <b>' . $s["pet_name"] . '</b> (' . $s["pet_type"] . ')</p>
                                            </div>
                                        </div>
                                        <p>From: ' . $s["owner_city"] . '</p>
                                        <p>Reason: "' . $s["description"] . '"</p>
                                    </div>
                                    <div class="req-actions">
                                        <a href="../includes/admin_update_req.php?id=' . $s["id"] . '&type=surrender&status=accepted" class="btn-action approve">Accept</a>
                                        <a href="../includes/admin_update_req.php?id=' . $s["id"] . '&type=surrender&status=declined" class="btn-action reject">Decline</a>
                                    </div>
                                  </div>';
                            }
                        } else {
                            echo "<p>No pending surrender requests.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>
            <section class="history-section hidden">
                <div class="requests-header-group">
                    <h2 class="admin-section-header">Request History</h2>
                    <div class="request-tabs">
                        <button class="tab-btn active" data-target="hist-adoption"><i class="fa fa-paw"></i>
                            Adoptions</button>
                        <button class="tab-btn" data-target="hist-surrender"><i class="fa fa-home"></i>
                            Surrenders</button>
                    </div>
                </div>

                <div id="hist-adoption" class="request-tab-content active">
                    <div class="requests-grid">
                        <?php
                        $histA = $conn->query("SELECT ar.*, p.name as pname FROM adoption_requests ar JOIN pets p ON ar.pet_id=p.id WHERE ar.shelter_id=$shelter_id AND ar.status IN ('approved', 'rejected') ORDER BY ar.request_date DESC");

                        if ($histA->num_rows > 0) {
                            while ($h = $histA->fetch_assoc()) {
                                $statusClass = ($h['status'] == 'approved') ? 'border-green' : 'border-red';
                                $statusBadge = ($h['status'] == 'approved')
                                    ? '<span class="badge">Approved</span>'
                                    : '<span class="badge">Rejected</span>';

                                echo '<div class="request-card glass-panel ' . $statusClass . '">
                                    <div class="req-header">
                                        <span class="req-id">#' . $h["ref_code"] . '</span>
                                        ' . $statusBadge . '
                                    </div>
                                    <div class="req-body">
                                        <h4>' . htmlspecialchars($h["applicant_name"]) . '</h4>
                                        <p>Requested: <b>' . htmlspecialchars($h["pname"]) . '</b></p>
                                        <p>Date: ' . date("d M Y", strtotime($h["request_date"])) . '</p>
                                        <p><i>"' . htmlspecialchars($h["message"]) . '"</i></p>
                                    </div>
                                  </div>';
                            }
                        } else {
                            echo "<p>No adoption history found.</p>";
                        }
                        ?>
                    </div>
                </div>

                <div id="hist-surrender" class="request-tab-content">
                    <div class="requests-grid">
                        <?php
                        $histS = $conn->query("SELECT * FROM surrender_requests WHERE shelter_id=$shelter_id AND status IN ('accepted', 'declined') ORDER BY created_at DESC");

                        if ($histS->num_rows > 0) {
                            while ($hs = $histS->fetch_assoc()) {
                                $statusClass = ($hs['status'] == 'accepted') ? 'border-green' : 'border-red';
                                $statusBadge = ($hs['status'] == 'accepted')
                                    ? '<span class="badge">Accepted</span>'
                                    : '<span class="badge">Declined</span>';
                                $imgSrc = "../" . $hs['pet_photo'];

                                echo '<div class="request-card glass-panel ' . $statusClass . '">
                                    <div class="req-header">
                                        <span class="req-id">#' . $hs["ref_code"] . '</span>
                                        ' . $statusBadge . '
                                    </div>
                                    <div class="req-body">
                                        <div class="req-pet-info">
                                            <img src="' . $imgSrc . '">
                                            <div class="req-pet-text">
                                                <h4>' . htmlspecialchars($hs["owner_name"]) . '</h4>
                                                <p>Pet: <b>' . htmlspecialchars($hs["pet_name"]) . '</b></p>
                                            </div>
                                        </div>
                                        <p>Processed Date: ' . date("d M Y", strtotime($hs["created_at"])) . '</p>
                                    </div>
                                  </div>';
                            }
                        } else {
                            echo "<p>No surrender history found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <section class="profile-settings hidden">
                <h2 class="admin-section-header">Shelter Settings</h2>
                <div class="profile-settings-card glass-panel">
                    <div class="profile-header">
                        <div class="profile-icon-large"><img src="<?php echo $profilePic; ?>" alt="Profile"></div>
                        <div class="edit-profile-buttons">
                            <button id="editBtn" class="edit-btn" onclick="enableEditing()"><i class="fa fa-pencil"></i>
                                Edit Profile</button>
                        </div>
                    </div>
                    <form id="profileForm" class="profile-form" action="../includes/update_profile.php" method="POST">
                        <div class="form-group"><label>Shelter Name</label><input type="text" name="shelter_name"
                                value="<?php echo htmlspecialchars($myShelter['shelter_name']); ?>" disabled required>
                        </div>
                        <div class="form-group"><label>Shelter Type</label>
                            <select name="shelter_type" disabled required>
                                <option value="public" <?php if ($myShelter['shelter_type'] == 'public')
                                    echo 'selected'; ?>>Municipal</option>
                                <option value="private" <?php if ($myShelter['shelter_type'] == 'private')
                                    echo 'selected'; ?>>Private</option>
                            </select>
                        </div>
                        <div class="form-group"><label>Address</label><input type="text" name="address"
                                value="<?php echo htmlspecialchars($myShelter['address']); ?>" disabled required></div>
                        <div class="form-group"><label>Country</label><input type="text" name="country"
                                value="<?php echo htmlspecialchars($myShelter['country']); ?>" disabled required></div>
                        <div class="form-group"><label>City</label><input type="text" name="city"
                                value="<?php echo htmlspecialchars($myShelter['city']); ?>" disabled required></div>
                        <div class="form-group"><label>Admin Name</label><input type="text" name="admin_name"
                                value="<?php echo htmlspecialchars($myShelter['admin_name']); ?>" disabled required>
                        </div>
                        <div class="form-group"><label>Admin Surname</label><input type="text" name="admin_surname"
                                value="<?php echo htmlspecialchars($myShelter['admin_surname']); ?>" disabled required>
                        </div>
                        <div class="form-group"><label>Contact Email</label><input type="email" name="admin_email"
                                value="<?php echo htmlspecialchars($myShelter['admin_email']); ?>" disabled required>
                        </div>
                        <div class="form-group"><label>Phone</label><input type="tel" name="phone"
                                value="<?php echo htmlspecialchars($myShelter['phone']); ?>" disabled required></div>
                        <div class="form-group"><label>New Password</label><input type="password" name="new_password"
                                placeholder="Change password" disabled></div>
                        <div class="form-group"><button type="submit" id="saveProfileBtn" class="edit-btn save-btn">Save
                                Changes</button></div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
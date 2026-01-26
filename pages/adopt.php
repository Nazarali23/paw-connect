<!DOCTYPE html>
<html lang="en">

<head>
    <title>PawConnect - Pet Adoption</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/adopt.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">
    <script src="../assets/js/main.js" defer></script>
    <script src="../assets/js/locations.js" defer></script>
</head>

<body id="adopt-page">
    <?php include '../includes/nav.php'; ?>
    <main>
        <section class="search-pets-section">
            <div class="search-pets-section-title">
                <h2>Search for a Pet</h2>
            </div>

            <form class="search-pets-section-content" action="adopt.php" method="GET">

                <div class="search-pets-item">
                    <select name="country" id="country" required>
                        <option value="">Select Country</option>
                    </select>
                </div>
                <div class="search-pets-item">
                    <select name="city" id="city" required>
                        <option value="">Select City</option>
                    </select>
                </div>

                <div class="search-pets-item">
                    <select name="pet_type" id="pet-type">
                        <option value="">All pets</option>
                        <option value="dog" <?php if (isset($_GET['pet_type']) && $_GET['pet_type'] == 'dog')
                            echo 'selected'; ?>>Dog</option>
                        <option value="cat" <?php if (isset($_GET['pet_type']) && $_GET['pet_type'] == 'cat')
                            echo 'selected'; ?>>Cat</option>
                        <option value="bird" <?php if (isset($_GET['pet_type']) && $_GET['pet_type'] == 'bird')
                            echo 'selected'; ?>>Bird</option>
                        <option value="fish" <?php if (isset($_GET['pet_type']) && $_GET['pet_type'] == 'fish')
                            echo 'selected'; ?>>Fish</option>
                        <option value="other" <?php if (isset($_GET['pet_type']) && $_GET['pet_type'] == 'other')
                            echo 'selected'; ?>>Other</option>
                    </select>
                </div>

                <div class="filter-search search-pets-item">
                    <div class="filters">

                        <div class="filter-item">
                            <input type="checkbox" id="vaccinated" name="vaccinated" value="1" <?php if (isset($_GET['vaccinated']))
                                echo 'checked'; ?>>
                            <label for="vaccinated">Vaccinated</label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="neutered" name="neutered" value="1" <?php if (isset($_GET['neutered']))
                                echo 'checked'; ?>>
                            <label for="neutered">Neutered / Spayed</label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="microchipped" name="microchipped" value="1" <?php if (isset($_GET['microchipped']))
                                echo 'checked'; ?>>
                            <label for="microchipped">Microchipped</label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="house_trained" name="house_trained" value="1" <?php if (isset($_GET['house_trained']))
                                echo 'checked'; ?>>
                            <label for="house_trained">House Trained</label>
                        </div>

                        <div class="filter-item">
                            <input type="checkbox" id="special_needs" name="special_needs" value="1" <?php if (isset($_GET['special_needs']))
                                echo 'checked'; ?>>
                            <label for="special_needs">Special Needs</label>
                        </div>

                        <div class="filter-group-title">Gender:</div>
                        <div class="filter-row">
                            <div class="filter-item">
                                <input type="radio" id="male" name="gender" value="male" <?php if (isset($_GET['gender']) && $_GET['gender'] == 'male')
                                    echo 'checked'; ?>>
                                <label for="male">Male</label>
                            </div>
                            <div class="filter-item">
                                <input type="radio" id="female" name="gender" value="female" <?php if (isset($_GET['gender']) && $_GET['gender'] == 'female')
                                    echo 'checked'; ?>>
                                <label for="female">Female</label>
                            </div>
                        </div>

                        <div class="filter-item">
                            <label for="age">Age:</label>
                            <select name="age" id="age">
                                <option value="any">Any</option>
                                <option value="puppy" <?php if (isset($_GET['age']) && $_GET['age'] == 'puppy')
                                    echo 'selected'; ?>>Puppy / Kitten (< 1 year)</option>
                                <option value="adult" <?php if (isset($_GET['age']) && $_GET['age'] == 'adult')
                                    echo 'selected'; ?>>Adult (1-7 years)</option>
                                <option value="senior" <?php if (isset($_GET['age']) && $_GET['age'] == 'senior')
                                    echo 'selected'; ?>>Senior (7+ years)</option>
                            </select>
                        </div>
                    </div>

                    <div class="filter-menu">
                        <img src="../assets/images/icons/filter.png" alt="">
                    </div>
                    <button class="search-button" type="submit">Search</button>
                </div>
            </form>
        </section>

        <section class="pets-section">
            <div class="pets-section-content">
                <?php
                include '../includes/db_connect.php';

                if (empty($_GET['country']) || empty($_GET['city'])) {
                    echo '<div style="grid-column: 1/-1; text-align:center; padding:40px; background:#fff; border-radius:10px; border:1px solid #ddd;">
                            <h3 style="color:#e58e26;">Select Your Location</h3>
                            <p style="color:#666;">Please select a <b>Country</b> and <b>City</b> above to see available pets near you.</p>
                          </div>';
                } else {

                    $sql = "SELECT pets.*, shelters.city, shelters.country 
                            FROM pets 
                            JOIN shelters ON pets.shelter_id = shelters.id 
                            WHERE pets.status = 'available'";

                    $country = $conn->real_escape_string($_GET['country']);
                    $city = $conn->real_escape_string($_GET['city']);

                    $sql .= " AND shelters.country = '$country' AND shelters.city = '$city'";

                    if (!empty($_GET['pet_type']) && $_GET['pet_type'] != 'all') {
                        $type = $conn->real_escape_string($_GET['pet_type']);
                        $sql .= " AND pets.type = '$type'";
                    }

                    if (isset($_GET['vaccinated']))
                        $sql .= " AND is_vaccinated = 1";
                    if (isset($_GET['neutered']))
                        $sql .= " AND is_neutered = 1";
                    if (isset($_GET['microchipped']))
                        $sql .= " AND is_microchipped = 1";
                    if (isset($_GET['house_trained']))
                        $sql .= " AND is_house_trained = 1";
                    if (isset($_GET['special_needs']))
                        $sql .= " AND has_special_needs = 1";

                    if (!empty($_GET['gender'])) {
                        $g = $conn->real_escape_string($_GET['gender']);
                        $sql .= " AND gender = '$g'";
                    }

                    if (!empty($_GET['age']) && $_GET['age'] != 'any') {
                        if ($_GET['age'] == 'puppy') {
                            $sql .= " AND ( (age_unit='months') OR (age_unit='years' AND age_value < 1) )";
                        } elseif ($_GET['age'] == 'adult') {
                            $sql .= " AND (age_unit='years' AND age_value >= 1 AND age_value <= 7)";
                        } elseif ($_GET['age'] == 'senior') {
                            $sql .= " AND (age_unit='years' AND age_value > 7)";
                        }
                    }

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imgSrc = "../" . $row['main_image'];

                            $vaxStatus = $row["is_vaccinated"] ? "Vaccinated" : "Not Vaccinated";

                            echo '
                            <div class="pet-card">
                                <img src="' . $imgSrc . '" alt="pet">
                                <div class="pet-card-info">
                                    <h4>' . $row["name"] . '</h4>
                                    <div class="pet-properties">
                                        <p id="pet-age">' . $row["age_value"] . ' ' . $row["age_unit"] . '</p>
                                        <p id="pet-gender">' . ucfirst($row["gender"]) . '</p>
                                        <p id="pet-location">' . $row["city"] . ', ' . $row["country"] . '</p>
                                        <p id="pet-vaccine-status">' . $vaxStatus . '</p>
                                    </div>
                                    <a href="request_adoption.php?pet_id=' . $row["id"] . '" class="btn" style="width:100%; display:block; text-align:center; margin-top:10px; background:#e58e26; color:white; padding:8px; border-radius:5px; text-decoration:none;">Adopt Me</a>
                                </div>
                            </div>';
                        }
                    } else {
                        echo '<p style="grid-column: 1/-1; text-align:center; padding:20px;">No pets found in this area matching your criteria.</p>';
                    }
                }
                ?>
            </div>

            <?php if (!empty($_GET['country']) && !empty($_GET['city'])): ?>
                <div class="pagination-controls">
                    <button id="prevBtn" disabled>Previous</button>
                    <span id="pageIndicator">Page 1</span>
                    <button id="nextBtn">Next</button>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include_once '../includes/footer.php'; ?>
</body>

</html>
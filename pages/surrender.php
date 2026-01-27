<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawConnect - Surrender an Animal</title>
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/surrender.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">
    <script src="../assets/js/main.js" defer></script>
    <script src="../assets/js/locations.js" defer></script>
</head>

<body id="surrender-page">

    <?php include_once '../includes/nav.php'; ?>

    <main>
        <section class="search-pets-section">
            <div class="search-pets-section-title">
                <h2>Surrender an Animal</h2>
                <p>Fill in the form below to donate a pet to a shelter.</p>
            </div>

            <form class="search-pets-section-content" id="surrender-form" action="../includes/surrender_action.php"
                method="POST" enctype="multipart/form-data">

                <div class="search-pets-item">
                    <input type="text" name="owner_name" class="input-info" placeholder="Your Name" required>
                </div>
                <div class="search-pets-item">
                    <input type="email" name="owner_email" class="input-info" placeholder="Your Email" required>
                </div>
                <div class="search-pets-item">
                    <input type="tel" name="owner_phone" class="input-info" placeholder="Your Phone"
                        pattern="[0-9]{10,15}" required>
                </div>

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
                    <input type="text" name="pet_name" class="input-info" placeholder="Pet Name" required>
                </div>
                <div class="search-pets-item">
                    <select name="pet_type" id="pet-type" required>
                        <option value="">Pet Type</option>
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="fish">Fish</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="search-pets-item">
                    <input type="number" name="pet_age" class="input-info" placeholder="Pet Age (years)" min="0"
                        required>
                </div>
                <div class="search-pets-item">
                    <input type="text" name="pet_breed" class="input-info" placeholder="Pet Breed (optional)">
                </div>
                <div class="search-pets-item">
                    <textarea name="pet_desc" class="input-info"
                        placeholder="Describe your pet (health, temperament, etc.)" rows="2" required></textarea>
                </div>
                <div class="search-pets-item">
                    <label>Pet Photo:</label>
                    <input type="file" name="pet_photo" accept="image/*" required>
                </div>

                <div class="search-pets-item" id="shelter-select">
                    <label><b>Select Shelter to Send Request:</b></label>
                    <div id="shelter-list" class="shelters">
                        <p id="shelter-placeholder">
                            Please select a <b>Country</b> and <b>City</b> above to see available shelters.
                        </p>
                    </div>
                </div>

                <div class="search-pets-item">
                    <button type="submit" class="search-button">Send Surrender Request</button>
                </div>
            </form>
        </section>
    </main>

    <?php include_once '../includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const countrySelect = document.getElementById('country');
            const citySelect = document.getElementById('city');
            const shelterList = document.getElementById('shelter-list');

            citySelect.addEventListener('change', function () {
                const country = countrySelect.value;
                const city = this.value;

                if (country && city) {
                    shelterList.innerHTML = '<p>Loading shelters...</p>';

                    fetch(`../includes/get_shelters.php?country=${encodeURIComponent(country)}&city=${encodeURIComponent(city)}`)
                        .then(response => response.text())
                        .then(data => {
                            shelterList.innerHTML = data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            shelterList.innerHTML = '<p>Error loading shelters.</p>';
                        });
                } else {
                    shelterList.innerHTML = '<p>Please select a Country and City above to see available shelters.</p>';
                }
            });

            countrySelect.addEventListener('change', function () {
                shelterList.innerHTML = '<p>Please select a City.</p>';
            });
        });
    </script>

</body>

</html>
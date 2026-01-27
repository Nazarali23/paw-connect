<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawConnect - My Requests</title>
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">

    <script src="../assets/js/main.js" defer></script>
</head>

<body id="requests-page">
    <?php include_once '../includes/nav.php'; ?>

    <main>
        <section class="requests-section">
            <div class="requests-section-title">
                <h2>My Requests</h2>
                <p>Track your surrender and adoption requests. Enter your name and phone number to view your requests.
                </p>
            </div>

            <form id="request-search-form" class="request-search-form">
                <input type="text" name="user_name" id="user_name" class="search-input" placeholder="Your Full Name"
                    required>
                <input type="tel" name="user_phone" id="user_phone" class="search-input" placeholder="Your Phone Number"
                    pattern="[0-9]{10,15}" required>
                <button type="submit" class="search-submit-btn">Search</button>
            </form>

            <div class="requests-list" id="requests-list">
                <div class="empty-state">
                    <p class="helper-text">Enter your details above to see your history.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once '../includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('request-search-form');
            const resultsDiv = document.getElementById('requests-list');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                resultsDiv.innerHTML = '<p>Searching...</p>';

                const formData = new FormData(form);

                fetch('../includes/search_requests_action.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        resultsDiv.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultsDiv.innerHTML = '<p class="error-text">An error occurred. Please try again.</p>';
                    });
            });
        });
    </script>
</body>

</html>
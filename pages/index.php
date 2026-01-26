<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="PawConnect connects loving pets with caring families through safe and easy adoption.">
    <meta name="keywords" content="pet adoption, animal shelter, adopt a pet, PawConnect">
    <title>PawConnect - Pet Adoption Platform</title>
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">
    <script src="../assets/js/home.js" defer></script>
    <script src="../assets/js/main.js"></script>
</head>

<body id="home-page">
    <?php include_once '../includes/nav.php'; ?>
    <main>
        <section class="hero">
            <div class="hero-back">
                <img src="../assets/images/home/pet-back.png" alt="Happy pets" class="hero-image">
            </div>
            <div class="hero-content">
                <h1>Welcome to PawConnect</h1>
                <p>Your trusted platform for pet adoption, donations, and volunteering.</p>
                <a href="adopt.php" class="btn">Adopt a Pet</a>
            </div>
            <div class="hero-front">
                <img src="../assets/images/home/pet-front.png" alt="Paw Print" class="paw-print">
            </div>
        </section>

        <section class="pets-section">
            <div class="pets-section-title">
                <img src="../assets/images/home/dog-judgy-eye.png" alt="dog">
                <h2>Still waiting? Check out these cute
                    friends and be their forever home!</h2>
            </div>
            <?php
            function pets($pet, $pet_text)
            {
                $img_path = "../assets/images/home/" . $pet . "-card.jpg";
                $url = "adopt.php";

                echo '
                    <div class="pet-card">
                        <a href="' . htmlspecialchars($url) . '">
                            <img src="' . htmlspecialchars($img_path) . '" alt="">
                            <p>' . htmlspecialchars($pet_text) . '</p>
                        </a>
                    </div>';
            }

            ?>
            <div class="carousel">
                <div class="pet-cards">
                    <?php pets('dog', 'Looking for a loyal companion?'); ?>
                    <?php pets('cat', 'Cats are waiting to purr in your lap!'); ?>
                    <?php pets('bird', 'Brighten your home with a chirpy friend!'); ?>
                    <?php pets('rabbit', 'Hop into happiness with a cuddly rabbit!'); ?>
                    <?php pets('fish', 'A fishy friend to keep you company!'); ?>
                    <?php pets('more-pets', 'Explore more pets waiting for you!'); ?>
                    <?php pets('dog', 'Looking for a loyal companion?'); ?>
                    <?php pets('cat', 'Cats are waiting to purr in your lap!'); ?>
                    <?php pets('bird', 'Brighten your home with a chirpy friend!'); ?>
                    <?php pets('rabbit', 'Hop into happiness with a cuddly rabbit!'); ?>
                    <?php pets('fish', 'A fishy friend to keep you company!'); ?>
                    <?php pets('more-pets', 'Explore more pets waiting for you!'); ?>
                </div>
            </div>
        </section>

        <section class="about-section">
            <div class="about-section-title">
                <h2>How it works?</h2>
                <span class="role-change">
                    <p id="role-change-text" class="active">For Users</p>
                </span>
            </div>

            <div class="info-for-users">
                <div class="about-section-steps">
                    <div class="step foruser-bg">
                        <img src="../assets/images/icons/search.png" alt="">
                        <h4>1. Explore Pets</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Browse through a wide variety of pets available for adoption from shelters around you.
                        </p>
                    </div>
                    <div class="step foruser-bg">
                        <img src="../assets/images/icons/form.png" alt="">
                        <h4>2. Submit Application</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Fill out a simple adoption application form to express your interest in a pet.
                        </p>
                    </div>
                    <div class="step foruser-bg">
                        <img src="../assets/images/icons/confirm.png" alt="">
                        <h4>3. Confirmation</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Once your application is approved, you'll receive a email from the shelter.
                        </p>
                    </div>
                    <div class="step foruser-bg">
                        <img src="../assets/images/icons/visit.png" alt="">
                        <h4>4. Visit Shelter</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                        </div>
                        <p>Schedule a visit to the shelter to meet your potential new furry friend.
                        </p>
                    </div>
                </div>
            </div>

            <div class="info-for-shelters hidden">
                <div class="about-section-steps">
                    <div class="step forsehlter-bg">
                        <img src="../assets/images/icons/register.png" alt="">
                        <h4>1. Register Shelter</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Create a shelter profile to start listing pets available for adoption.</p>
                    </div>

                    <div class="step forsehlter-bg">
                        <img src="../assets/images/icons/add.png" alt="">
                        <h4>2. Add Pets</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Upload pet details, photos, and important information to attract adopters.</p>
                    </div>

                    <div class="step forsehlter-bg">
                        <img src="../assets/images/icons/review.png" alt="">
                        <h4>3. Review Applications</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                            <div class="step-line"></div>
                        </div>
                        <p>Receive and review adoption applications submitted by interested users.</p>
                    </div>

                    <div class="step forsehlter-bg">
                        <img src="../assets/images/icons/time.png" alt="">
                        <h4>4. Arrange Visit</h4>
                        <div class="step-indicator">
                            <div class="step-dot"></div>
                        </div>
                        <p>Contact approved applicants and schedule a shelter visit to complete adoption.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="info-section">
            <div class="statistics">
                <div class="statistics-card">
                    <img src="../assets/images/icons/pet.png" alt="">
                    <div>
                        <h2>1000+</h2>
                        <p>Pets Available</p>
                    </div>
                </div>
                <div class="statistics-card">
                    <img src="../assets/images/icons/rate.png" alt="">
                    <div>
                        <h2>98%</h2>
                        <p>Success Rate</p>
                    </div>
                </div>
                <div class="statistics-card">
                    <img src="../assets/images/icons/24-hours-support.png" alt="">
                    <div>
                        <h2>24/7</h2>
                        <p>Support</p>
                    </div>
                </div>
                <div class="statistics-card">
                    <img src="../assets/images/icons/dog-house.png" alt="">
                    <div>
                        <h2>850</h2>
                        <p>Shelters</p>
                    </div>
                </div>
            </div>
            <div class="info-section-content">
                <div class="info-section-info">
                    <h2 class="section-title">Why Choose PawConnect?</h2>
                    <p class="section-description">At PawConnect, we are dedicated to connecting loving pets with caring
                        families. Our platform offers a seamless experience for adopting pets, donating to shelters, and
                        volunteering your time to make a difference.</p>
                </div>
                <div class="features">
                    <ul class="features-list">
                        <li>
                            <h3>🐾 Extensive Pet Listings:</h3>
                            <p>Browse through a wide variety of pets looking for their forever
                                homes.</p>
                        </li>
                        <li>
                            <h3>❤️ Easy Donation Process:</h3>
                            <p>Support shelters and rescue organizations with just a few clicks.</p>
                        </li>
                        <li>
                            <h3>🤝 Volunteer Opportunities:</h3>
                            <p>Find local shelters where you can volunteer and help care for
                                animals
                                in need.</p>
                        </li>
                        <li>
                            <h3>🔒 Secure and Trustworthy:</h3>
                            <p>We prioritize the safety and well-being of both pets and adopters.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

        </section>

        <section class="shelter-register-section">
            <h2>Are you a shelter?</h2>
            <div class="shelter-register-content">
                <img src="../assets/images/home/shelter.png" alt="" class="shelter-register-image"
                    id="shelter-image-back">
                <img src="../assets/images/home/shelter-front.png" alt="" class="shelter-register-image"
                    id="shelter-image-front"></img>
                <div class="shelter-register-info">
                    <p class="section-description">Join PawConnect today and expand your reach to find loving homes for
                        your
                        animals. Register your shelter with us and become part of a compassionate community dedicated to
                        animal welfare.</p>
                </div>
                <a href="login.php" class="btn">Register Your Shelter</a>
            </div>
        </section>

        <section class="testimonials-section">
            <?php
            function comment($name, $comment, $stars)
            {
                $stars = (int) $stars;
                $stars = max(0, min(5, $stars));

                echo '
                    <div class="testimonial-card">
                        <div class="testimonial-card-profile">
                            <img src="../assets/images/icons/user.png" alt="">
                            <h5>' . htmlspecialchars($name) . '</h5>
                        </div>
                        <p>' . htmlspecialchars($comment) . '</p>
                        <div class="testimonials-stars">';
                for ($i = 0; $i < $stars; $i++) {
                    echo '<img src="../assets/images/icons/star.png" alt="star">';
                }
                echo '
                        </div>
                    </div>';
            }

            ?>
            <h2>What Our Users Say</h2>
            <div class="testimonials">
                <?php comment('Sarah M.', 'Thanks to PawConnect, we adopted our dog Luna in just a few days. The process was easy and transparent.', 5); ?>
                <?php comment('Green Paws Shelter', 'PawConnect helped our shelter reach more loving families.
                        It truly makes a difference.', 4); ?>
                <?php comment('Jane D.', 'Thanks to PawConnect, I found my new best friend. The process was
                        smooth and easy.', 5); ?>
            </div>
        </section>

        <section class="final-cta-section">
            <h2>Ready to Make a Difference?</h2>
            <p>
                Whether you want to adopt a pet, support shelters, or register your organization,
                PawConnect is here to help.
            </p>

            <div class="final-cta-buttons">
                <a href="adopt.php" class="btn">Adopt a Pet</a>
                <a href="login.php" class="btn">Register a Shelter</a>
            </div>
        </section>
    </main>
    <?php include_once '../includes/footer.php'; ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PawConnect - Admin Login</title>
    <link rel="icon" type="image/png" href="../assets/images/icons/logo.png">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="../assets/css/hidden.css">
    <script src="../assets/js/locations.js" defer></script>
    <script src="../assets/js/login.js" defer></script>
</head>

<body id="login-page">
    <div class="admin-login">

        <div class="login-screen">
            <div class="login-form">
                <h2>Welcome Back!</h2>
                <form action="../includes/login_action.php" method="POST" id="login-form-form">
                    <input type="email" name="email" class="input-info" placeholder="Email" required>
                    <input type="password" class="input-info" name="login-password" placeholder="Password" required>
                    <a href="#" id="forgot-password-link">Forgot Password?</a>
                    <button type="submit" class="input-info">Sign In</button>
                    <p>Don't have an account? <a id="no_accaunt">Sign Up</a></p>
                </form>
                <form action="../includes/reset_password.php" method="POST" class="hidden" id="reset-password-form">
                    <button type="button" id="back-to-login" onclick="prevStep()" class="prevBtn"></button>
                    <h4>Reset Password</h4>
                    <input type="email" name="reset-email" class="input-info" placeholder="Enter your email" required>
                    <button type="submit" class="input-info">Send Reset Link</button>
                </form>
            </div>
            <div class="login-img">
                <div>
                    <img src="../assets/images/login/login.png" alt="">
                </div>
            </div>
        </div>

        <div class="sign-up-screen hidden">
            <div class="sign-up-img">
                <div>
                    <img src="../assets/images/login/signup.png" alt="">
                </div>
            </div>

            <div class="sign-up-form">
                <h2>Welcome to Join PawConnect</h2>
                <div class="sign-up-stepper">
                    <div class="progress-track"></div>
                    <div class="progress-fill" id="progress-bar"></div>
                    <div class="step-circle active">1</div>
                    <div class="step-circle">2</div>
                    <div class="step-circle">3</div>
                    <div class="step-circle">4</div>
                </div>
                <form action="../includes/register_shelter.php" method="POST" enctype="multipart/form-data">
                    <div class="sign-up-step active" data-step="1">
                        <h4>Shelter Information</h4>
                        <input type="text" name="sheltername" class="input-info" placeholder="Shelter Name" required>
                        <input type="tel" name="phone" class="input-info" placeholder="Shelter Phone Number" required
                            pattern="[0-9]{10,15}">
                        <div class="shelter-reg-country">
                            <select name="country" id="country" required>
                                <option value="">Select Country</option>
                            </select>
                            <select name="city" id="city" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <input type="text" name="address" class="input-info" placeholder="Shelter Address" required>
                        <select name="sheltertype" id="sheltertype" class="input-info" required>
                            <option value="" disabled selected>Select Shelter Type</option>
                            <option value="public">Municipal</option>
                            <option value="private">Private</option>
                        </select>
                        <button type="button" onclick="nextStep()" class="input-info">Next</button>
                    </div>
                    <div class="sign-up-step" data-step="2">
                        <div class="step-header">
                            <button type="button" onclick="prevStep()" class="prevBtn"></button>
                            <h4>Shelter Admin</h4>
                        </div>
                        <input type="text" name="adminname" class="input-info" placeholder="Admin Name" required>
                        <input type="text" name="adminsurname" class="input-info" placeholder="Admin Surname">
                        <input type="email" name="adminemail" class="input-info" placeholder="Admin Email" required>
                        <input type="tel" name="admintel" class="input-info" id="admintel"
                            placeholder="Admin Phone (Optional)" pattern="[0-9]{10,15}">
                        <button type="button" onclick="nextStep()" class="input-info">Next</button>
                    </div>
                    <div class="sign-up-step" data-step="3">
                        <div class="step-header">
                            <button type="button" onclick="prevStep()" class="prevBtn"></button>
                            <h4>Account Information</h4>
                        </div>
                        <input type="email" name="loginemail" class="input-info" placeholder="Email for Login" required>
                        <input type="password" name="sign-up-password" class="input-info" placeholder="Password"
                            required minlength="8">
                        <input type="password" name="repeatpassword" class="input-info" placeholder="Confirm Password"
                            required minlength="8">
                        <button type="button" onclick="nextStep()" class="input-info">Next</button>
                    </div>
                    <div class="sign-up-step" data-step="4">
                        <div class="step-header">
                            <button type="button" onclick="prevStep()" class="prevBtn"></button>
                            <h4>Other Details & Verification</h4>
                        </div>
                        <label for="shelterpicture">Shelter Picture(Optional)</label>
                        <input type="file" id="shelterpicture" name="shelterpicture" class="input-info"
                            placeholder="Shelter Picture" accept=".pdf,.jpg,.png">
                        <label for="shelterdocument">Official Documents about Shelter</label>
                        <input type="file" name="shelterdocument" class="input-info" placeholder="Official Documents"
                            accept=".pdf,.jpg,.png" required id="shelterdocument">
                        <input type="text" name="verificationcode" class="input-info" placeholder="Verification Code">
                        <button type="submit" class="input-info">Complete registration!</button>
                    </div>
                    <p>Already have an account? <a id="have_accaunt">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
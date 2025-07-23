<?php
session_start();
$email = $err_msg = "";
require 'functions/dbcon.php';
$errors = array('name' => '', 'email' => '', 'pass' => '', 'cpass' => '', 'pnum' => '', 'homeadd' => '', 'bdate' => '', 'gender' => '', 'verify' => '');

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateUserID($conn)
{
    $year = date("Y");
    $qry = "SELECT COUNT(*) AS total FROM account_details";
    $result = $conn->query($qry);
    if ($result) {
        $data = $result->fetch_assoc();
        $count = $data['total'] + 1;
        if ($count < 10) {
            return $year . "00" . $count;
        } elseif ($count < 100) {
            return $year . "0" . $count;
        } else {
            return $year . $count;
        }
    }
    return $year . "001"; // Default if no records or fail
}

$verification_code = null; // Store the verification code

// Handle Verify Email button click
if (isset($_POST['verify_email'])) {
    if (empty(trim($_POST['email'])) || !validateEmail($_POST['email'])) {
        $errors['email'] = 'A valid email is required to send a verification code.';
    } else {
        // Generate verification code
        $verification_code = rand(100000, 999999);
        $_SESSION['verification_code'] = $verification_code; // Store code in session
        $_SESSION['email'] = $_POST['email']; // Store email for sending

        // Send email
        if (sendVerificationEmail($_POST['email'], $verification_code)) {
            $_SESSION['message'] = "Verification code sent to your email.";
        } else {
            $_SESSION['message'] = "Failed to send verification email.";
        }
    }
}

// Handle Registration process
if (isset($_POST['btn-register'])) {
    // Input Validation
    if (empty(trim($_POST['name']))) {
        $errors['name'] = 'Name is required.';
    }

    if (empty(trim($_POST['email'])) || !validateEmail($_POST['email'])) {
        $errors['email'] = 'A valid email is required.';
    }

    if (empty(trim($_POST['pass'])) || strlen(trim($_POST['pass'])) < 8) {
        $errors['pass'] = 'Password must be at least 8 characters.';
    }

    if (trim($_POST['pass']) != trim($_POST['cpass'])) {
        $errors['cpass'] = 'Passwords do not match.';
    }

    if (empty(trim($_POST['pnum'])) || !preg_match('/^(0\d{10}|9\d{9})$/', trim($_POST['pnum']))) {
        $errors['pnum'] = 'A valid phone number is required.';
    }

    if (empty(trim($_POST['homeadd']))) {
        $errors['homeadd'] = 'Home address is required.';
    }

    if (empty(trim($_POST['bdate']))) {
        $errors['bdate'] = 'Birth date is required.';
    }

    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Please select a gender.';
    }

    // Check if verification code matches
    if (empty(trim($_POST['verifycode']))) {
        $errors['verify'] = 'Verification code is required.';
    } elseif ($_POST['verifycode'] != $_SESSION['verification_code']) {
        $errors['verify'] = 'Invalid verification code.';
    }

    // Check if there are no errors before proceeding with registration
    if (!array_filter($errors)) {
        $user_ID = generateUserID($conn);
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = password_hash($conn->real_escape_string($_POST['pass']), PASSWORD_DEFAULT); // Hash the password
        $pnum = $conn->real_escape_string($_POST['pnum']);
        $homeadd = $conn->real_escape_string($_POST['homeadd']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $bdate = $conn->real_escape_string($_POST['bdate']);

        $query = "INSERT INTO account_details (user_ID, name, email, pass, phonenum, homeadd, gender, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $user_ID, $name, $email, $password, $pnum, $homeadd, $gender, $bdate);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Account created successfully";
            header("Location: login.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Account not created. Error: " . $stmt->error;
        }
    }
}

// Function to send verification email
function sendVerificationEmail($email, $code) {
    $subject = "Email Verification Code";
    $message = "Your verification code is: $code";
    $headers = "From: marckanthonymangue22@gmail.com";

    return mail($email, $subject, $message, $headers);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="all.css/input.css">
    <link rel="stylesheet" href="all.css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Register | DSSNP Portal</title>
</head>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle password visibility
        function togglePasswordVisibility(buttonId, inputId) {
            const toggleButton = document.getElementById(buttonId);
            const passwordInput = document.getElementById(inputId);
            if (!toggleButton || !passwordInput) {
                console.warn('Toggle button or input not found!', { buttonId, inputId });
                return; // Exit if elements are not found
            }
            const passwordIcon = toggleButton.querySelector('i');

            toggleButton.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                // Toggle the eye/eye-slash icon
                passwordIcon.classList.toggle('bi-eye');
                passwordIcon.classList.toggle('bi-eye-slash');
            });
        }

        // Initialize toggle for password
        togglePasswordVisibility('togglePassword', 'pass');

        // Initialize toggle for confirm password
        togglePasswordVisibility('toggleConfirmPassword', 'cpass');
    });
</script>

<body>
    <a href="index.php" onclick="window.history.back();" class="back-arrow">
        <i class="bi bi-arrow-left"></i> back
    </a>
    <div class="row-login">
        <div class="col-login" data-bs-spy="scroll" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
            <?php include 'functions/message.php'; ?>
            <img src="images/h-logo.png" alt="">
            <form action="<?php $_PHP_SELF ?>" method="POST">
                <p>Register</p>
                <span class="fs-6 text-start text-dark " style="font-weight:lighter;">Please register to obtain our
                    services!</span>
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="inputGroup">
                            <input type="text" required="" autocomplete="off" name="name" id="name"
                                value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            <label for="name">Full name</label>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['name']; ?></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="inputGroup">
                            <input type="email" required="" autocomplete="off" name="email" id="em"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                            <label for="em">Email address</label>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['email']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="inputGroup position-relative">
                            <input type="password" required="" autocomplete="off" name="pass" id="pass"
                                value="<?php echo htmlspecialchars($_POST['pass'] ?? ''); ?>">
                            <label for="pass">Password</label>
                            <button type="button" id="togglePassword" class="btn position-absolute top-0 end-0"
                                style="height:100%; border: none; background: transparent;">
                                <i class="bi bi-eye-slash" aria-hidden="true"></i>
                            </button>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['pass']; ?></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="inputGroup position-relative">
                            <input type="password" required="" autocomplete="off" name="cpass" id="cpass"
                                value="<?php echo htmlspecialchars($_POST['cpass'] ?? ''); ?>">
                            <label for="cpass">Confirm Password</label>
                            <button type="button" id="toggleConfirmPassword" class="btn position-absolute top-0 end-0"
                                style="height:100%; border: none; background: transparent;">
                                <i class="bi bi-eye-slash" aria-hidden="true"></i>
                            </button>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['cpass']; ?></span>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="inputGroup">
                        <input type="text" required="" autocomplete="off" name="homeadd" id="homeadd"
                            value="<?php echo htmlspecialchars($_POST['homeadd'] ?? ''); ?>">
                        <label for="homeadd">Home Address/Location</label>
                        <span class="sub-ex" style="color: red;"><?php echo $errors['homeadd']; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="inputGroup">
                            <input type="text" required="" autocomplete="off" name="pnum" id="phone"
                                value="<?php echo htmlspecialchars($_POST['pnum'] ?? ''); ?>">
                            <label for="phone">Phone Number</label>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['pnum']; ?></span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="fs-5 col-sm-12">
                                <span>Birth Date : </span>
                            </div>
                            <div class="col-sm-12">
                                <div class="inputGroup">
                                    <input type="date" required="" autocomplete="off" name="bdate" id="bdate"
                                        value="<?php echo htmlspecialchars($_POST['bdate'] ?? ''); ?>">
                                    <span class="sub-ex">(ex.25/12/2000)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="inputGroup">
                            <input type="text" autocomplete="off" name="verifycode" id="verifycode"
                                value="<?php echo htmlspecialchars($_POST['verifycode'] ?? ''); ?>">
                            <label for="verifycode">Email Verification Code</label>
                            <span class="sub-ex" style="color: red;"><?php echo $errors['verify']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="text-end">
                        <button type="submit" name="verify_email" class="btn btn-primary">Send Code</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col my-3">
                        <span>Select Gender : </span>
                        <div class="btn-group <?php echo !empty($errors['gender']) ? 'radio-error' : ''; ?>"
                            role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="gender" value="Male" id="btnradio1"
                                autocomplete="off" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'checked' : ''; ?>>
                            <label class="btn btn-outline-primary" for="btnradio1" id="genderm"><i
                                    class="bi bi-gender-male"></i> Male</label>

                            <input type="radio" class="btn-check" name="gender" value="Female" id="btnradio2"
                                autocomplete="off" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'checked' : ''; ?>>
                            <label class="btn btn-outline-primary" for="btnradio2" id="genderf"><i
                                    class="bi bi-gender-female"></i> Female</label>
                        </div>
                        <?php if (!empty($errors['gender'])): ?>
                            <div class="error-message"><?php echo $errors['gender']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <span>By signing up for DSSNP Portal you acknowledge that you agree to DSSNP Portal's <a href="#"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">terms and conditions.</a></span>

                    <button type="submit" name="btn-register" class="btn btn-danger w-100 fs-5 mt-5">Register</button>
                <div class="span-log mt-2">
                    <span>Already have an account? <a href="login.php">Log in here!</a></span>
                </div>
            </form>

        </div>

        <div class="col-img">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="2000">
                        <img src="images/img1login.jpg" class="d-block"  alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/img2login.jpg" class="d-block" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="images/img3login.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Terms and Conditions</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>1. By signing up for an account on this church website, you agree to abide by all terms and
                    conditions outlined herein.<br></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
            </div>
        </div>
    </div>
</div>

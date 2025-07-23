<?php
session_start();
require 'functions/dbcon.php';

if (isset($_POST['login'])) {
    $email = trim($_POST['useremail']);  // Correcting the name according to the form input name
    $password = trim($_POST['pass']);

    // Prepare SQL to fetch the user data
    $qry = "SELECT * FROM account_details WHERE email=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Check if the password in the database is hashed
            $isHashed = preg_match('/^\$2[ayb]\$.{56}$/', $row['pass']);
            $passwordMatch = $isHashed ? password_verify($password, $row['pass']) : $password === $row['pass'];

            if ($passwordMatch) {
                // If the password is not hashed and matches, consider hashing it for security
                if (!$isHashed) {
                    // Update password to hashed version
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $updateQuery = "UPDATE account_details SET pass=? WHERE email=?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("ss", $hashedPassword, $email);
                    $updateStmt->execute();
                }

                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];

                // Check the domain of the email to determine user role
                $domain = substr(strrchr($email, "@"), 1);
                if ($domain == "admin.com") {
                    header("location: admin/dashboard.php"); // Redirect to an admin-specific page
                } else if ($domain == "socom.com") {
                    header('Location: socom/dashboard.php');
                } else {
                    header("location: index.php"); // Redirect to a general user page
                }
                exit();
            } else {
                $_SESSION['message'] = "Invalid password";
                header("location: login.php"); // Redirect back to login page to show the message
                exit();
            }
        } else {
            $_SESSION['message'] = "Email not found";
            header("location: login.php"); // Redirect back to login page to show the message
            exit();
        }
    } else {
        $_SESSION['message'] = "Login error";
        header("location: login.php"); // Redirect back to login page to show the message
        exit();
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Login | DSSNP Portal</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    .row-login {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .col-login img {
        width: 200px;
    }

    .col-login {
        padding: 3rem;
        width: 40%;
        height: 100vh;
    }

    .or-symbol {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .horizontal-line {
        width: 100%;
        /* Adjust width as needed */
        height: 1px;
        /* Adjust height as needed */
        background-color: black;
    }

    .col-login p {
        font-size: 2rem;
        color: #C4110C;
        font-weight: bolder;
    }

    .text {
        font-weight: lighter;
        margin: 0 10px;
        font: 0.5rem;
        /* Adjust spacing between lines and text */
    }

    .col-login form {
        margin-top: 2rem;
    }

    #togglePassword {
        right: 10px;
        /* Adjust as needed */
        padding: 0 12px;
        color: #555;
        border: none;
        background-color: transparent;
        cursor: pointer;
        outline: none;
    }

    .col-img {
        width: 60%;
    }

    .col-img img {
        width: 100%;
        height: 100vh;
    }

    .back-arrow {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1000;
        text-decoration: none;
        color: black;
    }

    /* Media Query for Mobile Devices */
    @media (max-width: 992px) and (min-width: 768px) {
        .col-login {
            width: 50%;
            padding: 2rem;
        }

        .col-img {
            width: 50%;
        }
    }

    /* Mobile Devices */
    @media (max-width: 768px) {
        .col-login {
            width: 100%;
            /* Full width */
            padding: 1rem;
            /* Reduced padding */
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .col-img {
            display: none;
            /* Hide the carousel */
        }

        body,
        html {
            overflow-x: hidden;
            /* Remove horizontal scroll */
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#pass');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye/eye-slash icon
            this.children[0].classList.toggle('bi-eye');
            this.children[0].classList.toggle('bi-eye-slash');
        });
    });
</script>

<body>
    <a href="index.php" onclick="window.history.back();" class="back-arrow">
        <i class="bi bi-arrow-left"></i> back
    </a>
    <div class="row-login">
        <div class="col-login">
            <?php include 'functions/message.php'; ?>
            <img src="images/h-logo.png" alt="">
            <form action="<?php $_PHP_SELF ?>" method="POST">
                <p>Login</p>
                <div class="inputGroup mt-3">
                    <input type="email" required autocomplete="off" name="useremail" id="useremail">
                    <label for="useremail">Email</label>
                </div>
                <div class="inputGroup position-relative">
                    <input type="password" required="" autocomplete="off" name="pass" id="pass">
                    <label for="pass">Password</label>
                    <button type="button" id="togglePassword" class="btn position-absolute top-0 end-0"
                        style="height:100%; border: none; background: transparent;">
                        <i class="bi bi-eye-slash" aria-hidden="true"></i>
                    </button>
                </div>

                <span>By signing up for DSSNP Portal you acknowledge that you agree to DSSNP Portal's <a href="#"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">terms and conditions.</a></span>
                <button type="submit" name="login" class="btn btn-light w-100 fs-5 mt-5">Login</button>
                <div class="or-symbol mt-5">
                    <span class="horizontal-line"></span>
                    <span class="text">OR</span>
                    <span class="horizontal-line"></span>
                </div>


            </form>
            <a href="register.php" class="btn btn-danger w-100 fs-5 mt-5">Register</a>
        </div>
        <div class="col-img">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="2000">
                        <img src="images/img1login.jpg" class="d-block" alt="...">
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
                    conditions outlined herein.<br>
                    2. You must provide accurate and truthful information during the sign-up process, especially if it
                    involves participation in church activities, events, or programs.<br>
                    3. You are responsible for maintaining the confidentiality of your account credentials, including
                    your username and password, to ensure the security of your personal information and
                    communications within the church community.<br>
                    4. You agree not to share your account credentials with any third party to protect the integrity of
                    your interactions within the church community and safeguard sensitive information shared
                    through the website.<br>
                    5. You acknowledge that the purpose of this website is to foster communication, collaboration,
                    and participation within the church community, and you agree to use the website for these
                    intended purposes.<br>
                    6. You agree not to use the website for any unlawful, inappropriate, or unauthorized purpose,
                    including but not limited to activities that violate the principles and teachings of the church or
                    infringe upon the rights of others.<br>
                    7. You agree to conduct yourself in a manner consistent with the values, beliefs, and standards
                    of the church community when interacting with other members, posting content, or participating
                    in discussions on the website.<br>
                    8. You agree not to engage in any activity that could harm, disrupt, or detract from the positive
                    atmosphere and mission of the church community as facilitated through the website.<br>
                    9. You agree not to misuse or abuse any features or functionalities of the website, including but
                    not limited to spamming, hacking, or distributing malware, to maintain the integrity and security
                    of the website for all users.<br>
                    10. You acknowledge that the website may contain links to third-party websites or resources for
                    informational purposes, and you agree to exercise caution and discretion when accessing
                    external sites or resources.<br>
                    11. You agree to indemnify and hold harmless the church, its affiliates, and their respective
                    leaders, volunteers, and staff from and against any claims, liabilities, damages, losses, and
                    expenses arising out of or in any way connected with your use of the website.<br>
                    12. We reserve the right to terminate or suspend your account at any time without prior notice if
                    we believe that you have violated any of these terms and conditions or if such action is deemed
                    necessary to protect the interests of the church community.<br>
                    13. We reserve the right to modify or update these terms and conditions at any time without
                    prior notice. It is your responsibility to review these terms periodically for changes.<br>
                    14. By continuing to use the website after any modifications to these terms and conditions, you
                    agree to be bound by the updated terms and to uphold the values and principles of the church
                    community.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
            </div>
        </div>
    </div>
</div>
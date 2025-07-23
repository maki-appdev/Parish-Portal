<?php
session_start();
include ("functions/dbcon.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="all.css/profile.css">
  <script
    type="text/javascript">window.$crisp = []; window.CRISP_WEBSITE_ID = "b522d5df-c014-42f7-abe0-e7f089e76499"; (function () { d = document; s = d.createElement("script"); s.src = "https://client.crisp.chat/l.js"; s.async = 1; d.getElementsByTagName("head")[0].appendChild(s); })();</script>
  <style>
    .logo {
      width: 150px;
    }
    
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a href="index.php"><img class="logo" src="./images/h-logo.png"></a>
      
      <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon "></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav " style="cursor:pointer;">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="index.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-cloud icon"></i> Home
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php">Home</a></li>
              <li><a class="dropdown-item" href="socomarea/about.php">About Sto. Nino</a></li>
              <li><a class="dropdown-item" href="socomarea/program.php">Program</a></li>
              <li><a class="dropdown-item" href="socomarea/prayers.php">Prayers</a></li>
              <li><a class="dropdown-item" href="donations.php">Donations</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <?php if (isset($_SESSION['name'])) { ?>
              <a class="nav-link" href="services.php"><i class="bi bi-ui-radios"></i> Services</a>

            <?php } else { ?>
              <a class="nav-link disabled" href="services.php"><i class="bi bi-ui-radios"></i> Services</a>
            <?php } ?>
          </li>
          <li class="nav-item">
            <?php if (isset($_SESSION['name'])) {
              ?>
              <a class="nav-link " href="documentrequest.php"><i class="bi bi-file-earmark-text"></i> Documment
                Request</a>
              <?php
            } else {
              ?>
              <a class="nav-link disabled" href="documentrequest.php"><i class="bi bi-file-earmark-text"></i> Documment Request</a>
              <?php
            } ?>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php"><i class="bi bi-telephone"></i> Contact Us</a>
          </li>
          <?php if (isset($_SESSION['name'])) { ?>
            <li class="nav-item">
              <a class="nav-link">
                <h style="cursor:pointer;"><span class="text-danger bold">Welcome! </span>
                  <?= $_SESSION['name'] ?>
                </h>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#profile" aria-controls="profile"><i
                  class="bi bi-person-circle"></i> Account</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="register.php"><i class="bi bi-person-add"></i> Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  if (isset($_SESSION['name'])) {
    $account = $_SESSION['name'];
    $qry = "SELECT * FROM `account_details` WHERE name='$account'";
    if ($res = mysqli_query($conn, $qry)) {
      if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
          $_SESSION["user_id"] = $row["user_ID"];
          $_SESSION["name"] = $row["name"];
          $_SESSION["email"] = $row["email"];
          $_SESSION["phonenum"] = $row["phonenum"];
          $_SESSION["homeadd"] = $row["homeadd"];
          $_SESSION["gender"] = $row["gender"];
          $_SESSION["birthdate"] = $row["birthdate"];
        }
        mysqli_free_result($res);
        ?>
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="profile" aria-labelledby="proflielabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="proflielabel">Account Profile</h5>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <div class="profile-content">
              <div class="profile-image">
                <img src="images/user.png" alt="">
              </div>
              <div class="account-details">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["user_id"]; ?>" disabled>
                  <label for="floatingInput">User ID</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["name"]; ?>" disabled>
                  <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="floatingInput" value="<?= $_SESSION["email"]; ?>" disabled>
                  <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["phonenum"]; ?>" disabled>
                  <label for="floatingInput">Contact Number</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["homeadd"]; ?>" disabled>
                  <label for="floatingInput">Home Address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["gender"]; ?>" disabled>
                  <label for="floatingInput">Gender</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" value="<?= $_SESSION["birthdate"]; ?>" disabled>
                  <label for="floatingInput">Birthdate</label>
                </div>
              </div>
              <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout
              </a>
            </div>

          </div>
        </div>

        <?php
      }
    }
  } ?>

</body>

</html>

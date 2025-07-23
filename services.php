<?php
include_once 'header.php';
include ("functions/dbcon.php");
$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <title>Services | DSSNP Portal</title>
    <script type="text/javascript">
        function EnableDisableTB() {
            var others = document.getElementById("others");
            var otherlan = document.getElementById("other");
            otherlan.disabled = others.checked ? false : true;
            otherlan.value = "";
            if (!otherlan.disabled) {
                otherlan.focus();
            }
        }
        function confirmCancellation(serviceType, id) {
            swal({
                title: "Are you sure?",
                text: "Once cancelled, you will not be able to recover this appointment!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willCancel) => {
                    if (willCancel) {
                        // Set form values dynamically
                        document.getElementById('cancelForm').elements['serviceType'].value = serviceType;
                        document.getElementById('cancelForm').elements['id'].value = id;
                        document.getElementById('cancelForm').submit();
                    } else {
                        swal("Your appointment is safe!");
                    }
                });
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
        html,
        body {
            width: 100%;
            overflow-x: hidden;
            /* Temporary fix to cut off outlying parts */
            max-width: 100%;
            /* Ensures that the body doesn't exceed the viewport width */
        }

        .container,
        .response-display-area,
        #services .container,
        #requestDetails {
            width: 100%;
            /* Ensures that containers are not causing the overflow */
            padding-left: 15px;
            padding-right: 15px;
            margin: auto;
            /* Centers the container */
        }

        img {
            max-width: 100%;
            /* Ensures images are not causing overflow */
            height: auto;
            /* Maintain aspect ratio */
        }

        .card,
        .card img {
            width: 100%;
            /* Adjust card image to be responsive */
        }

        .logo {
            width: 150px;
        }

        .h-background {
            min-height: 89vh;
            color: white;
            margin: 0 5% 0 5%;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .title-h1::before {
            position: absolute;
            content: "";
            width: 4px;
            height: 50px;
            background-color: #C4110C;
            transform: translateY(-10%);
            transform: translateX(-300%);
        }

        .services {
            background: white;
        }

        .services .card {
            border: none;
            cursor: pointer;
        }

        .services .card img {
            font-size: 80px;
            text-align: center;
            color: black;
            width: 150px;
        }

        .services .card .card-body h3 {
            font-weight: 600;
        }

        .title-h1 {
            color: #C4110C;
        }

        .services .card .card-body {
            text-align: center;
        }

        #aots,
        #blessing {
            --bs-modal-width: 60%;

        }

        #aots,
        #blessing,
        #defunctorum,
        #communion,
        #confirmation label {
            font-weight: bold;
        }

        #defunctorum {
            --bs-modal-width: 80%;
        }

        #communion,
        #marriage,
        #baptismal {
            --bs-modal-width: 50%;
        }

        #confession {
            --bs-modal-width: 40%;
        }

        .card {
            padding: 10px;
            box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
            transition: all 0.5s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
        }

        .response-display-area {
            background-color: #f8f9fa;
            /* Light grey background for the display area */
            border: 1px solid #dee2e6;
            /* Slight border for definition */
            border-radius: 5px;
            /* Rounded corners for the container */
            padding: 20px;
            /* Padding for spacing inside the container */
        }

        #requestDetails {
            background-color: #fff;
            /* White background for the details section */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
        }

        .admin-area {
            padding: 5px;
            border: 1px solid #ccc;
            font-size: 0.9rem;
            background-color: #f8f9fa;
        }

        .input-field {
            margin-bottom: 3px;
        }

        .input-text,
        .input-small {
            width: 100%;
        }

        .form-control {
            font-size: 0.7rem;
            cursor: pointer;
        }

        .center-text {
            text-align: center;
        }

        .top-right {
            text-align: right;
        }

        .form-check-label {
            margin-right: 20px;
        }

        .download-button {
            position: relative;
            border-width: 0;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border-radius: 4px;
            z-index: 1;
        }

        .download-button .docs {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 40px;
            padding: 0 10px;
            border-radius: 4px;
            z-index: 1;
            background-color: #242a35;
            border: solid 1px #e8e8e82d;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover {
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        }

        .download {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 90%;
            margin: 0 auto;
            z-index: -1;
            border-radius: 4px;
            transform: translateY(0%);
            background-color: #01e056;
            border: solid 1px #01e0572d;
            transition: all .5s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .download-button:hover .download {
            transform: translateY(100%)
        }

        .download svg polyline,
        .download svg line {
            animation: docs 1s infinite;
        }

        @keyframes docs {
            0% {
                transform: translateY(0%);
            }

            50% {
                transform: translateY(-15%);
            }

            100% {
                transform: translateY(0%);
            }
        }

        .cta {
            border: none;
            background: none;
            cursor: pointer;
        }

        .cta span {
            padding-bottom: 7px;
            letter-spacing: 4px;
            font-size: 14px;
            padding-right: 15px;
            text-transform: uppercase;
        }

        .cta svg {
            transform: translateX(-8px);
            transition: all 0.3s ease;
        }

        .cta:hover svg {
            transform: translateX(0);
        }

        .cta:active svg {
            transform: scale(0.9);
        }

        .hover-underline-animation {
            position: relative;
            color: black;
            padding-bottom: 20px;
        }

        .hover-underline-animation:after {
            content: "";
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #000000;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .cta:hover .hover-underline-animation:after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        #footer .container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #footer .brand h1 {
            font-size: 2rem;
            text-transform: uppercase;
            color: black;
        }

        #footer .brand h1 span {
            color: crimson;
        }

        #footer {
            background-color: #eee;
        }

        #footer .footer {
            min-height: 100px;
            flex-direction: column;
            padding-top: 20px;
            padding-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        #footer p {
            color: black;
            font-size: 1rem;
            font-family: 'Montserrat', sans-serif;
        }

        @media (max-width: 375px) {
            .services .card {
                padding: 5px;
                /* Reduces padding on smaller screens */
            }

            .download-button,
            .cta {
                width: 100%;
                /* Ensures buttons fit within the smaller screens */
                margin-top: 10px;
                /* Adds a bit more space on top for clarity */
            }
            

            .h-background {
                margin: 0 2%;
                /* Reduces margin for h-background class */
            }
        }

        /* General media queries adjustment if needed for extra small devices */
        @media (max-width: 480px) {

            .card-body h3,
            .content-area h1,
            .content-area h2 {
                font-size: smaller;
                /* Adjust font size for better fit */
            }
        }
    </style>
</head>


<body>

    <div class="h-background" style="color:black;">
        <section class="services" id="services">
            <div class="container">
                <div class="project-title pb-2 position-relative">
                    <h1 class="text-uppercase title-h1">Services</h1>
                    <span class="text-dark position-absolute top-0 end-0">&nbsp&nbsp&nbsp
                        <?php echo date("D, M d,") ?>
                        <?php echo date("Y"); ?>
                    </span>
                </div>
                <?php include 'functions/message.php'; ?>
                <div class="row" style="margin: auto auto;">
                    <div class="col-lg-4 col-md-6 py-3 ">
                        <div class="card" id="service1" data-bs-toggle="modal" data-bs-target="#baptismal">
                            <img class="mx-auto" src="images/jug.png" alt="">
                            <div class="card-body">
                                <label for="service1">
                                    <h3>Baptism</h3>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#marriage">
                            <img class="mx-auto" src="images/wedding-rings.png" alt="">
                            <div class="card-body">
                                <h3>Marriage</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#communion">
                            <img class="mx-auto" src="images/eucharist.png" alt="">
                            <div class="card-body">
                                <h3>First Holy Communion</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#aots">
                            <img class="mx-auto" src="images/priest.png" alt="">
                            <div class="card-body">
                                <h3>Annointing of the sick</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#defunctorum">
                            <img class="mx-auto" src="images/black-ribbon.png" alt="">
                            <div class="card-body">
                                <h3>Defunctorum</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#blessing">
                            <img class="mx-auto" src="images/bless.png" alt="">
                            <div class="card-body">
                                <h3>Blessing</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#confession">
                            <img class="mx-auto" src="images/church.png" alt="">
                            <div class="card-body">
                                <h3>Confession</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 py-3">
                        <div class="card" data-bs-toggle="modal" data-bs-target="#firstconfirmation">
                            <img class="mx-auto" src="images/cross.png" alt="">
                            <div class="card-body">
                                <h3>Confirmation</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container my-5">
        <div class="control-area d-flex justify-content-end">
            <button class="download-button" id="dl-pdf">
                <div class="docs"><i class="bi bi-file-earmark-text"></i>Download RS</div>
                <div class="download">
                    <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2"
                        stroke="currentColor" height="24" width="24" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line y2="3" x2="12" y1="15" x1="12"></line>
                    </svg>
                </div>
            </button>
        </div>
        <form action="<?php $_PHP_SELF ?>" method="POST">
            <div class="response-display-area" id="content_to_pdf">
                <h2 class="text-center mb-4">Request Summary</h2>
                <div id="requestDetails" class="p-3 border rounded">
                    <?php
                    // Ensure session start if not already started
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    $client_name = $_SESSION['name'];
                    // Prepared statement to avoid SQL injection
                    $query = "SELECT * FROM appointment_transaction WHERE req_by = ? 
                        UNION ALL 
                        SELECT * FROM completed_transaction WHERE req_by = ?";

                    if ($stmt = mysqli_prepare($conn, $query)) {
                        // Bind the same $client_name variable twice to the two placeholders in the SQL
                        mysqli_stmt_bind_param($stmt, 'ss', $client_name, $client_name);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result) > 0) {
                            while ($details = mysqli_fetch_assoc($result)) {
                                $serviceType = $details['service_type'];
                                $id = $details['ID'];
                                if ($details['service_type'] === "Communion" || $details['service_type'] === "Confirmation") {
                                    $md = mysqli_query($conn, "SELECT * FROM appointment_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        ?>
                                        <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                        <span><b>Requested By:</b> <?php echo $details['req_by']; ?></span><br>
                                        <span><b>Contact:</b> <?php echo $fetch['contact']; ?></span><br>
                                        <span><b>School:</b> <?php echo $fetch['school_name']; ?></span><br>
                                        <span><b>Date of Appointment:</b> <?php echo $fetch['date']; ?></span><br>
                                        <span><b>Time of Appointment:</b> <?php echo $fetch['time']; ?></span><br>
                                        <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                        <?php
                                        if ($details['status'] == "Canceled") {
                                            ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                        } else {
                                            ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                        }
                                        ?>
                                        <br>
                                        <hr><br>
                                        <span><b>REMINDERS:</b> <br></BR><?php echo $details['comment']; ?></span><br>
                                        <?php
                                    }
                                } else if ($details['service_type'] === "Marriage") {
                                    $md = mysqli_query($conn, "SELECT * FROM appointment_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        ?>
                                            <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                            <span><b>Requested By:</b> <?php echo $details['req_by']; ?></span><br>
                                            <span><b>Contact:</b> <?php echo $fetch['contact']; ?></span><br>
                                            <span><b>Date of Appointment:</b> <?php echo $fetch['date']; ?></span><br>
                                            <span><b>Time of Appointment:</b> <?php echo $fetch['time']; ?></span><br>
                                            <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                            <?php
                                            if ($details['status'] == "Canceled") {
                                                ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            } else {
                                                ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            }
                                            ?>
                                            <br>
                                            <hr>
                                            <span><b>REMINDERS:</b> <br><?php echo $details['comment']; ?></span><br>
                                        <?php
                                    }
                                } else if ($details['service_type'] === "Confession") {
                                    $md = mysqli_query($conn, "SELECT * FROM appointment_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        ?>
                                                <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                                <span><b>Requested By:</b> <?php echo $details['req_by']; ?></span><br>
                                                <span><b>Contact:</b> <?php echo $fetch['contact']; ?></span><br>
                                                <span><b>Date of Confession:</b> <?php echo $fetch['date']; ?></span><br>
                                                <span><b>Time of Confession:</b> <?php echo $fetch['time']; ?></span><br>
                                                <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                            <?php
                                            if ($details['status'] == "Canceled") {
                                                ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            } else {
                                                ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            }
                                            ?>
                                                <br>
                                                <hr>
                                                <span><b>REMINDERS:</b><br> <?php echo $details['comment']; ?></span><br>
                                        <?php
                                    }
                                } else if ($details['service_type'] === "Blessing") {
                                    $md = mysqli_query($conn, "SELECT * FROM service_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        ?>
                                                    <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                                    <span><b>Requested By:</b> <?php echo $details['req_by']; ?></span><br>
                                                    <span><b>Contact:</b> <?php echo $fetch['contact']; ?></span><br>
                                                    <span><b>Date of Confession:</b> <?php echo $fetch['date']; ?></span><br>
                                                    <span><b>Time of Confession:</b> <?php echo $fetch['time']; ?></span><br>
                                                    <span><b>Address:</b> <?php echo $fetch['address']; ?></span><br>
                                                    <span><b>Blessing Type:</b> <?php echo $fetch['blessing_type']; ?></span><br>
                                                    <span><b>Officiaing Priest: Rev. Fr.:</b> <?php echo $fetch['priest']; ?></span><br>

                                            <?php
                                            if ($details['status'] == "Canceled") {
                                                ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            } else {
                                                ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            }
                                            ?>
                                                    <span><b>Date:</b> <?php echo $details['approv_date']; ?></span><br>
                                                    <span><b>OR#:</b> <?php echo $fetch['or_number']; ?></span><br>
                                                    <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                            <?php
                                            if ($details['status'] == "Canceled") {
                                                ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            } else {
                                                ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            }
                                            ?>
                                                    <br>
                                                    <hr>
                                                    <span><b>REMINDERS:</b><br> <?php echo $details['comment']; ?></span><br>
                                        <?php
                                    }
                                } else if ($details['service_type'] === "Annointing") {
                                    $md = mysqli_query($conn, "SELECT * FROM service_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        ?>
                                                        <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                                        <span><b>Requested By:</b> <?php echo $details['req_by']; ?></span><br>
                                                        <span><b>Contact:</b> <?php echo $fetch['contact']; ?></span><br>
                                                        <span><b>Name of Sick Person:</b> <?php echo $fetch['name']; ?></span><br>
                                                        <span><b>Status / Remarks:</b> <?php echo $fetch['remarks']; ?></span><br>
                                                        <span><b>Date of Annointing:</b> <?php echo date('F d, Y', strtotime($fetch['date'])); ?></span><br>
                                                        <span><b>Time of Annointing:</b> <?php echo date("g:i a", strtotime($fetch['time'])); ?></span><br>
                                                        <span><b>Time of Annointing:</b> <?php echo $fetch['remarks']; ?></span><br>
                                                        <span><b>Address:</b> <?php echo $fetch['address']; ?></span><br>
                                                        <span><b>Officiaing Priest: Rev. Fr.:</b> <?php echo $fetch['priest']; ?></span><br>
                                                        <span><b>Received By:</b> <?php echo $details['admin_name']; ?></span><br>
                                                        <span><b>Date:</b> <?php echo $details['approv_date']; ?></span><br>
                                                        <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                            <?php
                                            if ($details['status'] == "Canceled") {
                                                ?><span><b>Canceled By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            } else {
                                                ?><span><b>Approved By:</b>
                                                <?php echo $details['admin_name']; ?></span><br><?php
                                            }
                                            ?>
                                                        <br>
                                                        <hr>
                                                        <span><b>REMINDERS:</b><br> <?php echo $details['comment']; ?></span><br>
                                        <?php
                                    }
                                } else if ($details['service_type'] === "Defunctorum") {
                                    $md = mysqli_query($conn, "SELECT * FROM service_details WHERE ID = '$id'");
                                    if ($md->num_rows > 0) {
                                        $fetch = $md->fetch_assoc();
                                        $dd = mysqli_query($conn, "SELECT * FROM defuntorum_details WHERE ID = '$id'");
                                        if ($dd->num_rows > 0) {
                                            $defde = $dd->fetch_assoc();
                                            ?>
                                                                <span><b>DECEASED INFORMATION</b></span><br>
                                                                <span><b>Service Type:</b> <?php echo $details['service_type']; ?></span><br>
                                                                <span><b>Name of Deceased:</b> <?php echo $fetch['name']; ?></span><br>
                                                                <span><b>Age as of last birthday:</b> <?php echo $defde['age_deceased']; ?></span><br>
                                                                <span><b>Date of Birth:</b> <?php echo $defde['date_birth']; ?></span><br>
                                                                <span><b>Date of Death:</b> <?php echo $defde['date_death']; ?></span><br>
                                                                <span><b>Place of Interment (Cemetery):</b> <?php echo $defde['cemetery']; ?></span><br>
                                                                <span><b>Date of Interment:</b> <?php echo $defde['date_interment']; ?></span><br>
                                                                <span><b>Civil Status:</b> <?php echo $defde['civil_status']; ?></span><br>
                                                                <span><b>Spouse/Parents:</b> <?php echo $defde['spo_par']; ?></span><br>
                                                                <span><b>Present Address of the Deceased:</b> <?php echo $defde['address_deceased']; ?></span><br>
                                                                <span><b>Last Sacrament Receives:</b> <?php echo $defde['last_sac']; ?></span><br>
                                                                <span><b>Cause of Death:</b> <?php echo $defde['cause_death']; ?></span><br><br>
                                                                <span><b>RELATIVES INFORMATION</b></span><br>
                                                                <span><b>Name of requesting party:</b> <?php echo $details['req_by']; ?></span><br>
                                                                <span><b>Relation to the deceased:</b> <?php echo $defde['relationto_deceased']; ?></span><br>
                                                                <span><b>Address:</b> <?php echo $fetch['address']; ?></span><br>
                                                                <span><b>Contact Numbers:</b> <?php echo $fetch['contact']; ?></span><br>
                                                                <span><b>Kind of Services Being Requested:</b> <?php echo $defde['kind_serv']; ?> <b>where:
                                                                    </b><?php echo $defde['where_serv']; ?></span><br>
                                                                <br><br>
                                                                <span><b>Officiaing Priest: Rev. Fr.:</b> <?php echo $fetch['priest']; ?></span><br>
                                                                <span><b>Received By:</b> <?php echo $details['admin_name']; ?></span><br>
                                                                <span><b>Date:</b> <?php echo $details['approv_date']; ?></span><br>
                                                                <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                                <?php
                                                if ($details['status'] == "Canceled") {
                                                    ?><span><b>Canceled By:</b>
                                                    <?php echo $details['admin_name']; ?></span><br><?php
                                                } else {
                                                    ?><span><b>Approved By:</b>
                                                    <?php echo $details['admin_name']; ?></span><br><?php
                                                }
                                                ?>



                                                                <br>
                                                                <hr>
                                                                <span><b>REMINDERS:</b><br> <?php echo $details['comment']; ?></span><br>
                                            <?php
                                        }
                                    }
                                } else if ($details['service_type'] === "Baptism") {
                                    $chil = mysqli_query($conn, "SELECT * FROM service_details WHERE ID = '$id'");
                                    if ($chil->num_rows > 0) {
                                        $fetch1 = $chil->fetch_assoc();
                                        $parent = mysqli_query($conn, "SELECT * FROM bap_parent_info WHERE ID = '$id'");
                                        if ($parent->num_rows > 0) {
                                            $fetch2 = $parent->fetch_assoc();
                                            $spo = mysqli_query($conn, "SELECT * FROM bap_spon_info WHERE ID = '$id'");
                                            if ($spo->num_rows > 0) {
                                                $fetch3 = $spo->fetch_assoc();
                                                ?> <span><b>Parish Office</b></span><br>
                                                                        <span><b>Status:</b> <?php echo $details['status']; ?></span><br>
                                                    <?php
                                                    if ($details['status'] == "Canceled") {
                                                        ?><span><b>Canceled By:</b>
                                                        <?php echo $details['admin_name']; ?></span><br><?php
                                                    } else {
                                                        ?><span><b>Approved By:</b>
                                                        <?php echo $details['admin_name']; ?></span><br><?php
                                                    }
                                                    ?>
                                                                        <span><b>Baptism Type:</b> <?php echo $fetch3['type_baptism']; ?></span><br>
                                                                        <span><b>Book No:</b> <?php echo $fetch3['book']; ?></span>
                                                                        <span><b>Page No:</b> <?php echo $fetch3['page']; ?></span>
                                                                        <span><b>Line No:</b> <?php echo $fetch3['line']; ?></span><br>
                                                                        <span><b>Line No:</b> <?php echo $fetch1['priest']; ?></span><br>
                                                                        <span><b>Officiating Priest: Rev. Fa.:</b> <?php echo $fetch1['priest']; ?></span><br>
                                                                        <span><b>OR#:</b> <?php echo $fetch1['or_number']; ?></span><br>
                                                                        <span><b>Date of Baptism:</b> <?php echo date('F d, Y', strtotime($fetch1['date'])); ?></span><br>
                                                                        <span><b>Time of Baptism:</b> <?php echo date("g:i a", strtotime($fetch1['time'])); ?></span><br>
                                                                        <span><b>Contact:</b> <?php echo $fetch1['contact']; ?></span><br>
                                                                        <span><b>Requested By:</b> <?php echo $fetch1['req_by']; ?></span><br><br>

                                                                        <span><b>CHILD'S INFORMATION</b></span><br>
                                                                        <span><b>Name of Child:</b> <?php echo $fetch1['name']; ?></span><br>
                                                                        <span><b>Age:</b> <?php echo $fetch1['age']; ?></span><br>
                                                                        <span><b>Gender:</b> <?php echo $fetch1['gender']; ?></span><br>
                                                                        <span><b>Home Address:</b> <?php echo $fetch1['address']; ?></span><br>
                                                                        <span><b>Place of Birth (Hospital Name and Complete Address):</b>
                                                    <?php echo $fetch1['address']; ?></span><br>
                                                                        <b></b>
                                                                        <span><b>PARENT'S INFORMATION</b></span><br>
                                                                        <span><b>Father's Name:</b> <?php echo $fetch2['Father_Name']; ?></span><br>
                                                                        <span><b>Place of Birth:</b> <?php echo $fetch2['Father_fob']; ?></span><br>
                                                                        <span><b>Mother's Maiden Name:</b> <?php echo $fetch2['Mother_Maiden']; ?></span><br>
                                                                        <span><b>Place of Birth:</b> <?php echo $fetch2['Mother_fob']; ?></span><br>
                                                                        <span><b>Home Address:</b> <?php echo $fetch2['address']; ?></span><br>
                                                                        <span><b>Legitimacy:</b> <?php echo $fetch2['Legitimacy']; ?></span><br>
                                                                        <br>
                                                                        <span><b>PRINCIPAL SPONSORS INFORMATION</b></span><br>
                                                                        <span><b>Godfather:</b> <?php echo $fetch3['Godfather']; ?></span><br>
                                                                        <span><b>Age:</b> <?php echo $fetch3['Godfather_age']; ?></span><br>
                                                                        <span><b>Address:</b> <?php echo $fetch3['Godfather_address']; ?></span><br>
                                                                        <span><b>Godmother:</b> <?php echo $fetch3['Godmother']; ?></span><br>
                                                                        <span><b>Age:</b> <?php echo $fetch3['Godmother_age']; ?></span><br>
                                                                        <span><b>Address:</b> <?php echo $fetch3['Godmother_address']; ?></span><br>
                                                                        <span><b>Additional Godfather:</b> <?php echo $fetch3['add_godfather']; ?></span><br>
                                                                        <span><b>Additional Godmother:</b> <?php echo $fetch3['add_godmother']; ?></span><br>


                                                                        <br>
                                                                        <hr>
                                                                        <span class="fst-light"><b>REMINDERS:</b><br> <?php echo $details['comment']; ?></span><br>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    echo "--------";
                                }
                            }
                        } else {
                            echo "--------";
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Error preparing statement: " . mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </form>
        <div class="control-area d-flex justify-content-end">
            <button class="cta" type="button" name="cancel_appointment"
                onclick="confirmCancellation('<?php echo $serviceType; ?>', '<?php echo $id; ?>')">
                <span class="hover-underline-animation"> Cancel Appointment </span>
                <svg id="arrow-horizontal" xmlns="http://www.w3.org/2000/svg" width="30" height="10"
                    viewBox="0 0 46 16">
                    <path id="Path_10" data-name="Path 10"
                        d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z"
                        transform="translate(30)">
                    </path>
                </svg>
            </button>
        </div>
    </div>
    <form id="cancelForm" method="POST" action="functions/cancel_appointment.php">
        <input type="hidden" name="serviceType" value="<?php echo $details['service_type']; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="client_name" value="<?php echo $client_name; ?>">
        <input type="hidden" name="action" value="cancel">
    </form>
    <!---------------------------- FOOTER ---------------------------------->


    <section id="footer" class="footercontact">
        <div class="footer container">
            <div class="brand">
                <h1><span>D</span>SSNP <span>P</span>ORTAL</h1>
            </div>
            <p>Copyright © 2024 Diocesan Shrine of Sto. Niño Parish</p>
        </div>
    </section>
    <!--------------------------------------------------Modal Area------------------------------------------------->

    <!------------------------------------Annointing of the sick------------------------------------->
    <div class="modal fade" id="aots" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content p-3">
                <img src="images/services-logo.png" alt="" style="width:500px;">
                <h4 style="border:2px solid; border-radius:10px;" class="text-center">ANNOINTING OF THE SICK <br>
                    REQUEST FORM
                </h4>
                <div class="modal-body">
                    <form action="functions/appointmentcode.php" method="post">
                        <div class="mb-3">
                            <label for="annname" class="form-label">Name of Sick Person:</label>
                            <input type="text" class="form-control" name="annname" id="annname" placeholder="Full name"
                                required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="anndate" class="form-label">Date of Annointing:</label>
                                    <input type="date" class="form-control" name="anndate" id="anndate"
                                        placeholder="enter date" required>
                                    <span id="error-blessdate" class="text-danger">
                                        <?= $errors['anndate'] ?? '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="anntime" class="form-label">Time:</label>
                                    <input type="time" class="form-control" name="anntime" id="anntime"
                                        placeholder="enter time" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="status" class="mb-2">Status / Remarks:</label>
                                    <select class="form-select" id="inputGroupSelect02" required name="annremarks">
                                        <option selected>Choose...</option>
                                        <option value="Asymptomatic">Asymptomatic</option>
                                        <option value="Mild">Mild</option>
                                        <option value="Moderate">Moderate</option>
                                        <option value="Severe">Severe</option>
                                        <option value="Critical">Critical</option>
                                        <option value="Stable">Stable</option>
                                        <option value="Improving">Improving</option>
                                        <option value="Deteriorating">Deteriorating</option>
                                        <option value="Recovered/Discharged">Recovered/Discharged</option>
                                    </select>
                                </div>
                                <span id="error-blessdate" class="text-danger">
                                    <?= $errors['annremarks'] ?? '' ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="annreqby" class="form-label">Requested By:</label>
                                    <input type="text" class="form-control" name="annreqby" id="annreqby"
                                        value="<?= $_SESSION['name'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="annnumber" class="form-label">Contact Number:</label>
                                    <input type="text" class="form-control" value="<?= $_SESSION['phonenum'] ?>"
                                        disabled>
                                    <input type="text" class="form-control" name="annnumber2" id="annnumber2"
                                        placeholder="include another active contact number" required>
                                    <span id="error-blessdate" class="text-danger">
                                        <?= $errors['annnumber2'] ?? '' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="annlocation" class="form-label">Locaion / Address:</label>
                            <input type="text" class="form-control" name="annlocation" id="annlocation"
                                placeholder="enter location/address" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            **********************************************************</div>
                        <div>
                            <h6><br>(for parish office use only)</h6>
                            <div class="my-3">
                                <label for="annrevfa" class="form-label">Officiaing Priest: Rev. Fr.</label>
                                <input type="text" class="form-control" name="annrevfa" id="annrevfa" disabled>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="annrecby" class="form-label">Received By:</label>
                                        <input type="text" class="form-control" name="annrecby" id="annrecby" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="annrecdate" class="form-label">Date:</label>
                                        <input type="date" class="form-control" name="annrecdate" id="annrecdate"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            **********************************************************</div>
                        <div class="">
                            <h6>REMINDER:</h6>
                            <h5 class="text-center fst-italic">Please be on time. Kindly fetch the Priest and bring him
                                back
                                at<br> the
                                parish before and after the Annointing.</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="btn-annointing">Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!--------------------------------------------Blessing---------------------------------------------->
    <div class="modal fade" id="blessing" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h1 class="modal-title fs-6 fw-bold" id="exampleModalLabel">Blessing Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="d-flex justify-content-center">
                    <img src="images/services-logo.png" alt="" style="width:400px;">
                </div>
                <h4 style="border:2px solid; border-radius:10px;" class="text-center p-2">BLESSING REQUEST FORM
                </h4>

                <div class="modal-body">
                    <form action="functions/appointmentcode.php" method="post">
                        <div class="radio-inputs d-flex justify-content-around mt-3">
                            <label>
                                <input class="radio-input" type="radio" name="type" required value="House" checked
                                    onclick="EnableDisableTB()">
                                <span class="radio-tile">
                                    <span class="radio-icon">
                                        <i class="bi bi-house-heart"></i>
                                    </span>
                                    <span class="radio-label">HOUSE</span>
                                </span>
                            </label>
                            <label>
                                <input class="radio-input" type="radio" name="type" required value="Office/Store"
                                    onclick="EnableDisableTB()">
                                <span class="radio-tile">
                                    <span class="radio-icon">
                                        <i class="bi bi-buildings"></i>
                                    </span>
                                    <span class="radio-label">OFFICE/STORE</span>
                                </span>
                            </label>
                            <label>
                                <input class="radio-input" type="radio" name="type" id="others" value="others" required
                                    onclick="EnableDisableTB()">
                                <span class="radio-tile">
                                    <span class="radio-icon">
                                    </span>
                                    <span class="radio-label">Others:</span>
                                    <input type="text" disabled="disabled" id="other" name="others" required>
                                </span>
                            </label>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="blessdate" class="form-label">Date of Blessing:</label>
                                    <input type="date" class="form-control" name="blessdate" id="blessdate"
                                        placeholder="enter time" required>
                                    <span id="error-blessdate" class="text-danger">
                                        <?= $errors['blessdate'] ?? '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="blesstime" class="form-label">Time:</label>
                                    <input type="time" class="form-control" name="blesstime" id="blesstime"
                                        placeholder="enter date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="blessreqby" class="form-label">Requested By:</label>
                                    <input type="text" class="form-control" name="blessreqby" id="blessreqby"
                                        value="<?= $_SESSION['name'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="input-group-text" class="form-label">Contact Number:</label>
                                    <input type="text" class="form-control" value="<?= $_SESSION['phonenum'] ?>"
                                        disabled>
                                    <input type="text" class="form-control" name="blessnumber2" id="blessnumber2"
                                        placeholder="contact number" required>
                                    <span id="error-blessnumber2" class="text-danger">
                                        <?= $errors['blessnumber2'] ?? '' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="blessloc" class="form-label">Location / Address:</label>
                            <input type="text" class="form-control" name="blessloc" id="blessloc"
                                placeholder="enter location/address" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            **********************************************************</div>
                        <div class="my-3">
                            <label for="revfa" class="form-label">Officiaing Priest: Rev. Fr.</label>
                            <input type="text" class="form-control" name="revfa" id="revfa" disabled>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recby" class="form-label">Received By:</label>
                                    <input type="text" class="form-control" name="recby" id="recby" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="recdate" class="form-label">Date:</label>
                                    <input type="date" class="form-control" name="recdate" id="recdate" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="blessor" class="form-label">OR#:</label>
                            <input type="text" class="form-control" name="blessor" id="blessor" disabled>
                        </div>
                        <div class="d-flex justify-content-center">
                            **********************************************************</div>
                        <div class="">
                            <h6>REMINDER:</h6>
                            <h5 class="text-center fst-italic">Please be on time. Kindly fetch the Priest and bring
                                him
                                back
                                at<br> the
                                parish before and after the Blessing.</h5>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="btn-blessing" class="btn btn-primary">Request</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
    <!--------------------------------------------Defuncturum---------------------------------------------->
    <form action="functions/appointmentcode.php" method="post">
        <div class="modal fade" id="defunctorum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">DEFUNCTORUM FORM</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <img src="images/services-logo.png" alt="" style="width:500px;">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <span class="fs-5 fw-bold">DECEASED INFORMATION</span>
                                <div class="row mb-3 mt-3">
                                    <div class="col">
                                        <div class="">
                                            <label for="deceasedname" class="form-label">Name of Deceased :</label>
                                            <input type="text" class="form-control" name="deceasedname"
                                                id="deceasedname" placeholder="Full name" required>
                                            <span class="text-danger"><?= $errors['deceasedname'] ?? '' ?></span>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="">
                                            <label for="deceasedage" class="form-label">Age as of last birthday
                                                :</label>
                                            <input type="text" class="form-control" name="deceasedage" id="deceasedage"
                                                placeholder="age as of last birthday" required>
                                            <span class="text-danger"><?= $errors['deceasedage'] ?? '' ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedbob" class="form-label">Date of Birth :</label>
                                            <input type="date" class="form-control" name="deceasedbob" id="deceasedbob"
                                                placeholder="date of birth" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceaseddod" class="form-label">Date of Death :</label>
                                            <input type="date" class="form-control" name="deceaseddod" id="deceaseddod"
                                                placeholder="date of death" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedcemetery" class="form-label">Place of Interment
                                                (Cemetery)
                                                :</label>
                                            <input type="text" class="form-control" name="deceasedcemetery"
                                                id="deceasedcemetery" placeholder="location of cemetery" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceaseddoi" class="form-label">Date of Interment :</label>
                                            <input type="date" class="form-control" name="deceaseddoi" id="deceaseddoi"
                                                placeholder="date of interment" required>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="fw-bold">Civil Status :</span>
                                    <label class="fw-normal">
                                        <input class="radio-input" type="radio" name="type" value="Single" required>
                                        <span class="radio-tile">
                                            <span class="radio-label">Single</span>
                                        </span>
                                    </label>
                                    <label class="fw-normal">
                                        <input class="radio-input" type="radio" name="type" value="Married" required>
                                        <span class="radio-tile">
                                            <span class="radio-label">Married</span>
                                        </span>
                                    </label>
                                    <label class="fw-normal">
                                        <input class="radio-input" type="radio" name="type" value="Widow/er" required>
                                        <span class="radio-tile">
                                            <span class="radio-label">Widow/er</span>
                                        </span>
                                    </label>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="deceasedsp" class="form-label">Spouse/Parents :</label>
                                    <input type="text" class="form-control" name="deceasedsp" id="deceasedsp"
                                        placeholder="spouse/parents" required>
                                    <span class="text-danger"><?= $errors['deceasedsp'] ?? '' ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="deceasedpadd" class="form-label">Present Address of the Deceased
                                        :</label>
                                    <input type="text" class="form-control" name="deceasedpadd" id="deceasedpadd"
                                        placeholder="present address" required>
                                    <span class="text-danger"><?= $errors['deceasedpadd'] ?? '' ?></span>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedlsr" class="form-label">Last Sacrament Receives
                                                :</label>
                                            <input type="text" class="form-control" name="deceasedlsr" id="deceasedlsr"
                                                placeholder="last sacrament receives" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedcod" class="form-label">Cause of Death :</label>
                                            <input type="text" class="form-control" name="deceasedcod" id="deceasedcod"
                                                placeholder="couse of death" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col">
                                <span class="fs-5 fw-bold mt-4">RELATIVES INFORMATION</span>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedreqp" class="form-label">Name of requesting party
                                                :</label>
                                            <input type="text" class="form-control" name="deceasedreqp"
                                                id="deceasedreqp" value="<?= $_SESSION['name'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="deceasedrelation" class="form-label">Relation to the
                                                deceased
                                                :</label>
                                            <input type="text" class="form-control" name="deceasedrelation"
                                                id="deceasedrelation" placeholder="relation to the deceased" required>
                                            <span class="text-danger"><?= $errors['deceasedrelation'] ?? '' ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedriadd" class="form-label">Address :</label>
                                            <input type="text" class="form-control" name="deceasedriadd"
                                                id="deceasedriadd" value="<?= $_SESSION['homeadd'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedricn" class="form-label">Contact Numbers :</label>
                                            <input type="text" class="form-control" name="deceasedricn"
                                                id="deceasedricn" value="<?= $_SESSION['phonenum'] ?>" readonly>
                                            <input type="text" class="form-control" id="deceasedcn2" name="deceasedcn2">
                                            <span class="text-danger"><?= $errors['deceasedcn2'] ?? '' ?></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div>
                                        <span class="fw-bold">Kind of Services Being Requested :</span>
                                        <label class="fw-normal">
                                            <input class="radio-input" type="radio" name="decser_type"
                                                value="Funeral Mass" required>
                                            <span class="radio-tile">
                                                <span class="radio-label">Funeral Mass</span>
                                            </span>
                                        </label>
                                        <label class="fw-normal">
                                            <input class="radio-input" type="radio" name="decser_type"
                                                value="Blessing Only" required>
                                            <span class="radio-tile">
                                                <span class="radio-label">Blessing Only; </span>
                                            </span>
                                        </label>
                                        <span>where</span>
                                        <label class="fw-normal">
                                            <input class="radio-input" type="radio" name="where" value="House" required>
                                            <span class="radio-tile">
                                                <span class="radio-label">House</span>
                                            </span>
                                        </label>
                                        <label class="fw-normal">
                                            <input class="radio-input" type="radio" name="where" value="Church"
                                                required>
                                            <span class="radio-tile">
                                                <span class="radio-label">Church</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceaseddateser" class="form-label">Date :</label>
                                            <input type="date" class="form-control" name="deceaseddateser"
                                                id="deceaseddateser" placeholder="contact numbers" required>
                                            <span class="text-danger"><?= $errors['deceaseddateser'] ?? '' ?></span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="deceasedtimeser" class="form-label">Time :</label>
                                            <input type="time" class="form-control" name="deceasedtimeser"
                                                id="deceasedtimeser" placeholder="contact numbers" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deceasedop" class="form-label">Officiaing Priest :</label>
                                    <input type="text" class="form-control disabled" placeholder="" disabled>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btn-defunctorum" class="btn btn-primary">Request</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--------------------------------------------Communion---------------------------------------------->
    <div class="modal fade" id="communion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-3">
                <form action="functions/appointmentcode.php" method="post">
                    <?php
                    $_SESSION['user_id'];
                    $_SESSION['name'];
                    $_SESSION['phonenum'];
                    ?>
                    <div class="modal-body">
                        <img src="images/services-logo.png" alt="" style="width:500px;">
                        <h4 style="border:2px solid; border-radius:10px;" class="text-center p-2">FIRST HOLY COMMUNION
                            <br>
                            REQUEST FORM
                        </h4>
                        <span class="fw-bold">Note:</span>
                        <p class="fst-italic">
                            - schedule quarterly and plaese stand by the announcements<br>
                            - for the schools who wants to schedule an confirmation you can schedule an Appoinment with
                            the
                            parish office<br>
                        </p>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Name of School</span>
                            <input type="text" placeholder="(complete school name)" name="confe_school"
                                class="form-control">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Contact Number</span>
                            <input type="text" value="<?php echo $_SESSION['phonenum']; ?>" name="confe_con1"
                                class="form-control" readonly>
                            <input type="text" placeholder="(please include 2 contact number)" name="confe_con2"
                                class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Date</span>
                                    <input type="date" name="confe_date" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Time</span>
                                    <select name="confe_time" class="form-select" required>
                                        <?php
                                        // Define the time ranges for 8 AM to 12 PM and 2 PM to 5 PM
                                        $times = array_merge(
                                            range(8, 11),  // 8 AM to 11 AM (no 12 PM)
                                            range(14, 17)  // 2 PM to 5 PM (using 24-hour format for PM times)
                                        );
                                        $interval = 20; // 20-minute interval
                                        
                                        foreach ($times as $hour) {
                                            // Handling AM times (8 AM to 11 AM)
                                            if ($hour < 12) {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    $formatted_time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " AM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                            // Handling PM times (2 PM to 5 PM)
                                            else {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    if ($hour == 17 && $minute == 20) {
                                                        break;  // Stop at 5:00 PM, no 5:20 PM
                                                    }
                                                    // Convert 24-hour time to 12-hour time format for PM
                                                    $hour_12 = $hour - 12; // Convert hour to 12-hour format
                                                    $formatted_time = str_pad($hour_12, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " PM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btn-communion" class="btn btn-primary">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--------------------------------------------Confirmation---------------------------------------------->
    <div class="modal fade" id="firstconfirmation" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><span class="fw-bold">Instruction</span> and
                        <span class="fw-bold">Requirements</span> for Confirmation
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="fw-bold">Note:</span>
                    <p class="fst-italic">
                        - schedule quarterly and plaese stand by the announcements<br>
                        - for the schools who wants to schedule an confirmation you can schedule an Appoinment with the
                        parish office<br>
                    </p>
                    <img src="images/confirmation.jpg" alt="" style="width:100%;">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#confirmation" data-bs-toggle="modal">Go to request
                        form</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3">

                <form action="functions/appointmentcode.php" method="post">
                    <?php
                    $_SESSION['user_id'];
                    $_SESSION['name'];
                    $_SESSION['phonenum'];
                    ?>
                    <img src="images/services-logo.png" alt="" style="width:500px;">
                    <h4 style="border:2px solid; border-radius:10px;" class="text-center p-2">KUMPILYANG PAROKYA<br>
                        APPOINMENT FORM
                    </h4>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Name of School</span>
                            <input type="text" placeholder="(complete school name)" name="confirm_school"
                                class="form-control" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Contact Number</span>
                            <input type="text" value="<?php echo $_SESSION['phonenum']; ?>" name="confirm_con1"
                                class="form-control" readonly>
                            <input type="text" placeholder="(please include 2 contact number)" name="confirm_con2"
                                class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Date</span>
                                    <input type="date" name="confirm_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Time</span>
                                    <select name="confirm_time" class="form-select" required>
                                        <?php
                                        // Define the time ranges for 8 AM to 12 PM and 2 PM to 5 PM
                                        $times = array_merge(
                                            range(8, 11),  // 8 AM to 11 AM (no 12 PM)
                                            range(14, 17)  // 2 PM to 5 PM (using 24-hour format for PM times)
                                        );
                                        $interval = 20; // 20-minute interval
                                        
                                        foreach ($times as $hour) {
                                            // Handling AM times (8 AM to 11 AM)
                                            if ($hour < 12) {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    $formatted_time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " AM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                            // Handling PM times (2 PM to 5 PM)
                                            else {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    if ($hour == 17 && $minute == 20) {
                                                        break;  // Stop at 5:00 PM, no 5:20 PM
                                                    }
                                                    // Convert 24-hour time to 12-hour time format for PM
                                                    $hour_12 = $hour - 12; // Convert hour to 12-hour format
                                                    $formatted_time = str_pad($hour_12, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " PM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btn-confirmation" class="btn btn-primary">Submit</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!--------------------------------------------Baptismal---------------------------------------------->
    <form action="functions/appointmentcode.php" method="post">
        <?php
        $_SESSION['user_id'];
        $_SESSION['phonenum'];
        $_SESSION['name'];

        ?>
        <div class="modal fade" id="baptismal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
            tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="images/baptism.jpg" alt="" style="width:100%;">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#baptismalmodal" data-bs-toggle="modal">Go to
                            request
                            form</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="baptismalmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">BAPTISMAL REGISTRATION FORM</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div
                                    class="modal--img d-flex justify-content-center align-items-center justify-content-center">
                                    <img src="images/services-logo.png" alt="" style="width:450px;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="admin-area">
                                    <div class="row">
                                        <div class="col-12 center-text">
                                            <span class="fst-italic fw-bold">(this portion to be filled up by the parish
                                                office staff)</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-field">
                                                <label for="bookNo" class="form-label">Baptism Type:&nbsp</label>
                                                <input type="text" id="bookNo" name="bap_type"
                                                    class="form-control w-50 input-group-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-field">
                                                <label for="bookNo" class="form-label">Book No:&nbsp</label>
                                                <input type="text" id="bookNo" name="bap_book"
                                                    class="form-control w-50 input-group-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-field">
                                                <label for="pageNo" class="form-label">Page No:&nbsp</label>
                                                <input type="text" id="pageNo" name="bap_page"
                                                    class="form-control w-50 input-group-sm" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-field">
                                                <label for="lineNo" class="form-label">Line No:&nbsp</label>
                                                <input type="text" id="lineNo" name="bap_line"
                                                    class="form-control w-50 input-group-sm" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-field">
                                                <label for="priest" class="form-label">Officiating Priest: Rev.
                                                    Fa.&nbsp</label>
                                                <input type="text" id="priest"
                                                    class="form-control w-90 input-group-sm mb-2" name="bap_priest"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-field">
                                                <label for="order" class="form-label">OR#&nbsp</label>
                                                <input type="text" id="order" name="bap_ornum"
                                                    class="form-control input-group-sm mb-2" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-area mt-2">
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="date-baptism">Date of Baptism</span>
                                        <input type="date" class="form-control" placeholder="Date of Baptism"
                                            aria-label="Date of Baptism" name="bap_date" aria-describedby="date-baptism"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="time-baptism">Time</span>
                                        <input type="time" class="form-control" placeholder="Time of Baptism"
                                            aria-label="Time of Baptism" name="bap_time" aria-describedby="time-baptism"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <span class="input-group-text" id="contact-baptism">Contact #</span>
                                        <input type="text" class="form-control" placeholder="Contact of Baptism"
                                            aria-label="Contact of Baptism" value="<?= $_SESSION['phonenum']; ?>"
                                            readonly aria-describedby="contact-baptism">
                                        <input type="text" class="form-control" placeholder="Contact of Baptism"
                                            aria-label="Contact of Baptism" name="bap_contact2"
                                            aria-describedby="contact-baptism" required>
                                    </div>
                                </div>
                            </div>

                            <span class="fs-5 fw-bold mt-2 text-decoration-underline">CHILD'S INFORMATION</span>
                            <div class="input-group mb-3">
                                <span class="input-group-text">Name of Child</span>
                                <input type="text" aria-label="First name" name="bap_fn" class="form-control"
                                    placeholder="First Name" required>
                                <input type="text" aria-label="Middle name" name="bap_md" class="form-control"
                                    placeholder="Middle Name" required>
                                <input type="text" aria-label="Surname" name="bap_sn" class="form-control"
                                    placeholder="Surname" required>
                                <span class="text-danger"><?= $errors['bap_childname'] ?? '' ?></span>
                            </div>

                            <div class="row ">
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="age-baptism">Age</span>
                                        <input type="text" class="form-control" name="bap_age"
                                            placeholder="Age of Baptism" aria-label="Age of Baptism"
                                            aria-describedby="age-baptism" required>
                                        <span class="input-group-text" id="age-baptism">yr./s old</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="radio-inputs mt-2">
                                        <span>Gender:&nbsp&nbsp&nbsp</span>
                                        <label>
                                            <input class="radio-input" type="radio" name="gender-bap" required
                                                value="Male">
                                            <span class="radio-tile">
                                                <span class="radio-icon"></span>
                                                <span class="radio-label">Male</span>
                                            </span>
                                        </label>&nbsp&nbsp&nbsp
                                        <label>
                                            <input class="radio-input" type="radio" name="gender-bap" required
                                                value="Female">
                                            <span class="radio-tile">
                                                <span class="radio-icon"></span>
                                                <span class="radio-label">Female</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="pob-baptism">Place of Birth</span>
                                <input type="text" class="form-control" name="bap_pobHN"
                                    placeholder="(Complete Hospital Name)" aria-label="(Complete Hospital Name)"
                                    aria-describedby="pob-baptism" required>
                            </div>
                            <input type="text" class="form-control mb-2" name="bap_pobHADD"
                                placeholder="(Complete Address)" aria-label="(Complete Address)"
                                aria-describedby="pob-baptism" required>
                            <span class="fs-5 fw-bold text-decoration-underline">PARENT'S
                                INFORMATION</span>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Father's Name</span>
                                        <input type="text" aria-label="FN" name="bap_faFN" class="form-control"
                                            placeholder="First Name" required>
                                        <input type="text" aria-label="MN" name="bap_faMN" class="form-control"
                                            placeholder="Middle Name" required>
                                        <input type="text" aria-label="SN" name="bap_faSN" class="form-control"
                                            placeholder="Surname" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Place of Birth</span>
                                        <input type="text" class="form-control" name="bap_fapob"
                                            placeholder="(City / Municipality)" aria-label="(City / Municipality)"
                                            aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Mother's Maiden Name</span>
                                        <input type="text" aria-label="FN" name="bap_MaFN" class="form-control"
                                            placeholder="First Name" required>
                                        <input type="text" aria-label="MN" name="bap_MaMN" class="form-control"
                                            placeholder="Middle Name" required>
                                        <input type="text" aria-label="SN" name="bap_MaSN" class="form-control"
                                            placeholder="Surname" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Place of Birth</span>
                                        <input type="text" class="form-control" name="bap_Mapob"
                                            placeholder="(City / Municipality)" aria-label="(City / Municipality)"
                                            aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="address-baptism">Home Address</span>
                                <input type="text" class="form-control" name="bap_parentsadd"
                                    placeholder="(current address)" aria-label="(current address)"
                                    aria-describedby="pob_baptism" required>
                            </div>
                            <p class="fst-italic"><span class="fw-bold">Legitimacy:</span> (if married, kindly
                                check appropriate box)</p>
                            <div class="radio-inputs d-flex justify-content-around mt-3">
                                <label>
                                    <input class="radio-input" type="radio" name="reli_baptism" required
                                        value="Catholic" checked onclick="EnableDisableLeg()">
                                    <span class="radio-tile">
                                        <span class="radio-label">Catholic</span>
                                    </span>
                                </label>
                                <label>
                                    <input class="radio-input" type="radio" name="reli_baptism" required value="Civil"
                                        onclick="EnableDisableLeg()">
                                    <span class="radio-tile">
                                        <span class="radio-label">Civil</span>
                                    </span>
                                </label>
                                <label>
                                    <input class="radio-input" type="radio" name="reli_baptism" required value="Aglipay"
                                        onclick="EnableDisableLeg()">
                                    <span class="radio-tile">
                                        <span class="radio-label">Aglipay</span>
                                    </span>
                                </label>
                                <label>
                                    <input class="radio-input" type="radio" name="reli_baptism" required
                                        value="Not Married" onclick="EnableDisableLeg()">
                                    <span class="radio-tile">
                                        <span class="radio-label">Not Married</span>
                                    </span>
                                </label>
                                <label>
                                    <input class="radio-input" type="radio" name="reli_baptism" id="legs" value="others"
                                        required onclick="EnableDisableLeg()">
                                    <span class="radio-tile">
                                        <span class="radio-label">Others:</span>
                                        <input type="text" disabled="disabled" id="leg" name="leg" required>
                                    </span>
                                </label>
                            </div>
                            <span class="fs-5  mt-3 fw-bold text-decoration-underline">PRINCIPAL SPONSORS
                                INFORMATION</span>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Godfather</span>
                                        <input type="text" aria-label="FN" name="bap_psfFN" class="form-control"
                                            placeholder="First Name" required>
                                        <input type="text" aria-label="MN" name="bap_psfMN" class="form-control"
                                            placeholder="Middle Name" required>
                                        <input type="text" aria-label="SN" name="bap_psfSN" class="form-control"
                                            placeholder="Surname" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Age</span>
                                        <input type="text" class="form-control" name="bap_psgfage"
                                            aria-label="(City / Municipality)" aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Address</span>
                                        <input type="text" class="form-control" name="bap_psgfadd"
                                            placeholder="(City / Municipality)" aria-label="(City / Municipality)"
                                            aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Godmother</span>
                                        <input type="text" aria-label="FN" name="bap_psgmFN" class="form-control"
                                            placeholder="First Name" required>
                                        <input type="text" aria-label="MN" name="bap_psgmMN" class="form-control"
                                            placeholder="Middle Name" required>
                                        <input type="text" aria-label="SN" name="bap_psgmSN" class="form-control"
                                            placeholder="Surname" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Age</span>
                                        <input type="text" class="form-control" name="bap_psgmage"
                                            aria-label="(City / Municipality)" aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="pobf-baptism">Address</span>
                                        <input type="text" class="form-control" name="bap_psgmadd"
                                            placeholder="(City / Municipality)" aria-label="(City / Municipality)"
                                            aria-describedby="pobf-baptism" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <span class="fs-5 fw-bold text-decoration-underline">ADDITIONAL
                                SPONSORS INFORMATIOM</span>
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-12">
                                <div class="col fs-6 fw-bold d-flex justify-content-center">
                                    <span>Godfather</span>
                                </div>
                                    <div class="form-floating mb-5">
                                        <textarea class="form-control" id="floatingComplain1" placeholder="Complain"
                                            style="height: 150px;" name="addgodfather"
                                            onkeydown="handleKeyPress(event, 'floatingComplain1')"
                                            onfocus="initializeOnFocus('floatingComplain1')" required></textarea>
                                        <label for="floatingComplain1" class="fst-italic">First Name/Middle
                                            Name/Surname</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                <div class="col fs-6 fw-bold d-flex justify-content-center">
                                    <span>Godmother</span>
                                </div>
                                    <div class="form-floating mb-5">
                                        <textarea class="form-control" id="floatingComplain2" placeholder="Complain"
                                            style="height: 150px;" name="addgodmother"
                                            onkeydown="handleKeyPress(event, 'floatingComplain2')"
                                            onfocus="initializeOnFocus('floatingComplain2')" required></textarea>
                                        <label for="floatingComplain2" class="fst-italic">
                                            First Name/Middle Name/Surname
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btn-baptism" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--------------------------------------------Marriage---------------------------------------------->
    <div class="modal fade" id="marriage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><span class="fw-bold">Instruction</span> and
                        <span class="fw-bold">Requirements</span> for Marriage
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="fw-bold">Note:</span>
                    <p class="fst-italic">- reservation and further inquiry kindly proceed and coordinate with parish
                        office<br>- you can schedule an aoppoinment to discuss with the parish office<br>
                        - you can dowload the file here and fill up before you go to the parish <a
                            href="Downloadable File/DATA INFORMATION SHEET.pdf" download="OptionalNewFileName.pdf">click
                            me</a>
                    </p>
                    <img src="images/marriage.jpg" alt="" style="width:100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#marriageappoinment">Schedule an Appoinment</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="marriageappoinment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content p-3">
                <form action="functions/appointmentcode.php" method="post">
                    <?php
                    $_SESSION['user_id'];
                    $_SESSION['name'];
                    $_SESSION['phonenum'];
                    ?>
                    <img src="images/services-logo.png" alt="" style="width:500px;">
                    <h4 style="border:2px solid; border-radius:10px;" class="text-center p-2">MARRIAGE<br>
                        APPOINMENT FORM
                    </h4>
                    <div class="modal-body">
                        <p class="fst-italic">- reservation and further inquiry kindly proceed and coordinate with
                            parish
                            office<br>- you can schedule an aoppoinment to discuss with the parish office<br>
                            - you can dowload the file here and fill up before you go to the parish
                        </p>
                        <span class="fw-bold">DATA INFORMATION SHEET :</span>
                        <a href="Downloadable File/DATA INFORMATION SHEET.pdf" download="OptionalNewFileName.pdf">click
                            me
                            to download the file</a>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Name</span>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>"
                                name="mar_name" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Contact Number</span>
                            <input type="text" value="<?php echo $_SESSION['phonenum']; ?>" name="mar_con1"
                                class="form-control" readonly>
                            <input type="text" placeholder="(please include 2 contact number)" name="mar_con2"
                                class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Date</span>
                                    <input type="date" class="form-control" name="mar_date" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Time</span>
                                    <select name="mar_time" class="form-select" required>
                                        <?php
                                        // Define the time ranges for 8 AM to 12 PM and 2 PM to 5 PM
                                        $times = array_merge(
                                            range(8, 11),  // 8 AM to 11 AM (no 12 PM)
                                            range(14, 17)  // 2 PM to 5 PM (using 24-hour format for PM times)
                                        );
                                        $interval = 20; // 20-minute interval
                                        
                                        foreach ($times as $hour) {
                                            // Handling AM times (8 AM to 11 AM)
                                            if ($hour < 12) {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    $formatted_time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " AM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                            // Handling PM times (2 PM to 5 PM)
                                            else {
                                                for ($minute = 0; $minute < 60; $minute += $interval) {
                                                    if ($hour == 17 && $minute == 20) {
                                                        break;  // Stop at 5:00 PM, no 5:20 PM
                                                    }
                                                    // Convert 24-hour time to 12-hour time format for PM
                                                    $hour_12 = $hour - 12; // Convert hour to 12-hour format
                                                    $formatted_time = str_pad($hour_12, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT) . " PM";
                                                    echo "<option value='$formatted_time'>$formatted_time</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button type="submit" name="btn-marriage" class="btn btn-primary">Sumbit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--------------------------------------------confession---------------------------------------------->
    <div class="modal fade" id="confession" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="functions/appointmentcode.php" method="post">
                    <?php
                    $_SESSION['user_id'];
                    $_SESSION['name'];
                    $_SESSION['phonenum'];
                    ?>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="images/services-logo.png" alt="" style="width:400px;"><br>
                        </div>
                        <span class="fw-normal">Regular schedule:</span>
                        <p class="fst-italic"><span class="fw-bold fst-normal">Wednesday, Firday, Saturday </span>
                            - From <span class="fw-bold">5:30</span> pm to <span class="fw-bold">6:30 </span>pm
                        </p>
                        <span class="fw-normal mt-4">For special schedule:<br></span>
                        <span class="fst-italic mt-4">&nbsp&nbsp&nbsp&nbsp&nbsp(kindly fill up this form)</span>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="confes_name">Name</span>
                            <input type="text" class="form-control" name="confes_name"
                                value="<?php echo $_SESSION['name']; ?>" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Contact Number</span>
                            <input type="text" value="<?php echo $_SESSION['phonenum']; ?>" name="confes_name1"
                                class="form-control" readonly>
                            <input type="text" placeholder="(please include 2 contact number)" name="confes_name2"
                                class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="confes_date">Date</span>
                                    <input type="date" class="form-control" name="confes_date" required>
                                </div>

                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="confes_time">Time</span>
                                    <input type="time" class="form-control" name="confes_time" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="btn-confession" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<script>
    function EnableDisableLeg() {
        var others = document.getElementById("legs");
        var otherlan = document.getElementById("leg");
        otherlan.disabled = others.checked ? false : true;
        otherlan.value = "";
        if (!otherlan.disabled) {
            otherlan.focus();
        }
    }

</script>
<script>
    var initialized = {};  // Object to track initialization status for each textarea

    function handleKeyPress(event, textareaId) {
        var textarea = document.getElementById(textareaId);
        if (event.keyCode === 13) { // Check if Enter key is pressed
            event.preventDefault(); // Prevent default behavior of Enter key
            var currentValue = textarea.value;
            if (currentValue[currentValue.length - 1] === '\n' || currentValue === "") {
                return; // Do nothing if there's already a newline at the end or if it's completely empty
            }
            var lines = currentValue.split('\n');
            var lastLine = lines[lines.length - 1];
            var lastNumber = lastLine.match(/^\d+/); // Extract the number from the last line
            var nextNumber = lastNumber ? parseInt(lastNumber[0]) + 1 : 1;
            textarea.value += "\n" + nextNumber + ". "; // Add the next number and a dot
        }
    }

    function initializeOnFocus(textareaId) {
        var textarea = document.getElementById(textareaId);
        if (!initialized[textareaId]) {  // Only initialize if it hasn't been done yet
            textarea.value = "1. ";  // Add "1. " when the textarea is focused
            textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            initialized[textareaId] = true;  // Prevent re-initialization
        }
    }

</script>
<script src="js/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script type="text/javascript">
    window.onload = function () {
        document.getElementById('dl-pdf').addEventListener('click', function () {
            var element = document.getElementById('content_to_pdf');
            var opt = {
                margin: 1,
                filename: 'RequestSummary.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });
    };
</script>
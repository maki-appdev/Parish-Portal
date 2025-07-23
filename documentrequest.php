<?php
include_once 'header.php';
include 'functions/dbcon.php';
$errors = [];
$documentType = '';
$requestingParty = '';
$relation = '';
$type = '';
$phonenum = '';
$deliveryAddress = '';
$consentFile = '';
$validID = '';
if (isset($_POST['submit_request'])) {
    $phonenum = $_SESSION['phonenum'];
    $documentType = $_POST['document_type'] ?? '';
    $requestingParty = $_POST['requesting_party'] ?? '';
    $relation = $_POST['relation'] ?? '';
    $type = $_POST['wherefrom'] ?? '';
    $deliveryAddress = $_POST['where_deliver'] ?? '';
    $contactNumber = trim($_POST['contact_number'] ?? '');
    $fullname=  $_POST['fname']. " ".  $_POST['mname']." ". $_POST['lname'];
    $date_baptism = $_POST['date_baptism'];
    // Validate document type
    if (empty($documentType)) {
        $errors['document_type'] = 'Document type is required.';
    }

    // Validate requesting party
    if (empty($requestingParty)) {
        $errors['requesting_party'] = 'Requesting party name is required.';
    }

    // Validate relation
    if (empty($relation)) {
        $errors['relation'] = 'Relation is required.';
    }

   if (!preg_match('/^(0\d{10}|9\d{9})$/', $contactNumber)) {
        $errors['contact_number'] = 'Contact number must start with 0 and be 11 digits long.';
    }

    // Validate delivery address if delivery is selected
    if ($type === 'YES' && empty($deliveryAddress)) {
        $errors['where_deliver'] = 'Delivery address is required when delivery is selected.';
    }


    // Check for valid ID upload
    if ($_FILES['validID']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors['validID'] = 'Uploading a valid ID is required.';
    }

    $uploadDir = 'uploads/'; // Adjust the path to where you want to store your files

    // Ensure the upload directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory with read/write/execute permissions
    }

    // Process validID file upload
    $validIDPath = NULL;
    if ($_FILES['validID']['error'] != UPLOAD_ERR_NO_FILE) {
        $validIDPath = $uploadDir . basename($_FILES['validID']['name']); // Construct the full path for the new file
        if (!move_uploaded_file($_FILES['validID']['tmp_name'], $validIDPath)) {
            echo "Failed to move uploaded file.";
            $validIDPath = NULL; // Reset path to NULL in case of failure
        }
    }

    // Process consent form file upload
    $consentFormPath = NULL;
    if ($_FILES['consent']['error'] != UPLOAD_ERR_NO_FILE) {
        $consentFormPath = $uploadDir . basename($_FILES['consent']['name']);
        if (!move_uploaded_file($_FILES['consent']['tmp_name'], $consentFormPath)) {
            echo "Failed to move uploaded file.";
            $consentFormPath = NULL; // Reset path to NULL in case of failure
        }
    }
    $types = $type === "YES" ? "International" : "Local";
    $new_contact = $phonenum . " " . $contactNumber;
    $insertionSuccess = false;
    if (count($errors) === 0) {
         $stmt = $conn->prepare("INSERT INTO documentrequests (document_type, requesting_party, docu_details, date_bap, relation_to_owner, contact, req_from, valid_id_path, consent_form_path, delivery_address, date_requested) VALUES (?, ?,?,?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssssssss", $documentType, $requestingParty, $fullname, $date_baptism, $relation, $new_contact, $types, $validIDPath, $consentFormPath, $deliveryAddress);

        if ($stmt->execute()) {
            $insertionSuccess = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document Request | DSSNP Portal</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

        body,
        html {
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            /* Consistent font throughout the document */
            overflow-x: hidden;
            /* Prevents horizontal scroll */
        }

        /* Main background and alignment adjustments */
        .document_request {
            padding: 1rem;
            min-height: 100vh;
            /* Full height */
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("images/img3login.jpg");
            background-size: cover;
            background-position: center;
        }

        /* Styling for form container */
        .request_form {
            background: #fff;
            /* Light background with a slight transparency */
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            /* Full width on small screens */
            max-width: 800px;
            /* Max width for larger screens */
        }

        /* Responsive images */
        img {
            width: 100%;
            /* Full width of its parent */
            height: auto;
            /* Maintain aspect ratio */
        }

        /* Responsive input fields and labels */
        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating label {
            margin-left: 0.5rem;
        }

        .form-select,
        .form-control {
            width: 100%;
            /* Ensures control stretches to container width */
            padding: 0.8rem;
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 0.8rem;
            padding-left: 0.5rem;
        }

        /* Adjustments for footer */
        #footer {
            background-color: #eee;
            color: black;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Media Queries for Responsive Breakpoints */
        @media (max-width: 600px) {
            .request_form {
                padding: 10px;
            }
            .imghead{
            }
        }

        @media (min-width: 601px) {
            .request_form {
                padding: 15px;
            }
        }

        @media (min-width: 768px) {
            .request_form {
                padding: 20px;
            }
        }

        @media (min-width: 992px) {
            .request_form {
                padding: 25px;
            }
        }

        @media (min-width: 1200px) {
            .request_form {
                padding: 30px;
            }
        }
        
    </style>
</head>

<body>
    <div class="container-fluid document_request">

        <div class="request_form">
            <form id="documentrequestform" action="documentrequest.php" method="POST" enctype="multipart/form-data">
                <div class="d-flex justify-content-center">
                    <img class="imghead" src="images/services-logo.png" alt="">
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="document_type" name="document_type">
                        <option value="" disabled <?= empty($documentType) ? 'selected' : '' ?>>Select document type
                        </option>
                        <option value="Baptismal" <?= $documentType == 'Baptismal' ? 'selected' : '' ?>>Baptismal</option>
                        <option value="First Communion" <?= $documentType == 'First Communion' ? 'selected' : '' ?>>First
                            Communion</option>
                        <option value="Confirmation" <?= $documentType == 'Confirmation' ? 'selected' : '' ?>>Confirmation
                        </option>
                        <option value="Marriage" <?= $documentType == 'Marriage' ? 'selected' : '' ?>>Marriage</option>
                    </select>
                    <label for="document_type">Document to request</label>
                    <span class="error"><?= $errors['document_type'] ?? ''; ?></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="requesting_party" name="requesting_party"
                                value="<?= $_SESSION['name'] ?>" readonly>
                            <label for="requesting_party">Name of requesting party</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                        <select class="form-select" id="relation" name="relation">
                            <option value="" disabled <?= empty($relation) ? 'selected' : '' ?>>Select relation</option>
                            <option value="My Child" <?= $relation == 'My Child' ? 'selected' : '' ?>>My Child</option>
                            <option value="My Mother" <?= $relation == 'My Mother' ? 'selected' : '' ?>>My Mother</option>
                            <option value="My Father" <?= $relation == 'My Father' ? 'selected' : '' ?>>My Father</option>
                            <option value="Spouse" <?= $relation == 'Spouse' ? 'selected' : '' ?>>Spouse</option>
                            <option value="My Self" <?= $relation == 'My Self' ? 'selected' : '' ?>>My Self</option>
                            <option value="none of the above" <?= $relation == 'none of the above' ? 'selected' : '' ?>>None of the above</option>
                        </select>
                        <label for="relation">Relation to the owner of the document</label>
                        <span class="error"><?= $errors['relation'] ?? ''; ?></span>
                    </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text">Full Name</span>
                            <input type="text" placeholder="First Name" name="fname" class="form-control" required>
                            <input type="text" placeholder="Middle Name" name="mname" class="form-control" required>
                            <input type="text" placeholder="Last Name" name="lname" class="form-control" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date_input" name="date_baptism" required>
                            <label for="date_input">Date of Baptism</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="phonenum" name="phonenum"
                                value="<?= $_SESSION['phonenum'] ?>" readonly>
                            <label for="phonenum">Contact Number</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="contact_number" name="contact_number"
                                placeholder="">
                            <label for="contact_number">Contact Number</label>
                            <span class="error"><?= $errors['contactNumber'] ?? ''; ?></span>
                        </div>
                    </div>
                </div>
                <div class="radio-inputs mb-3">
                    <span class="fst-italic">Please click yes if your requesting from other country &nbsp;</span>
                    <label>
                        <input class="radio-input" type="radio" name="wherefrom" value="YES" <?= $type == 'YES' ? 'checked' : '' ?> onclick="toggleAddressField()">
                        <span class="radio-label">YES</span>
                    </label>
                    <label>
                        <input class="radio-input" type="radio" checked name="wherefrom" value="NO" <?= $type == 'NO' ? 'checked' : '' ?> onclick=" toggleAddressField()">
                        <span class="radio-label">NO</span>
                    </label>
                </div>
                <span>Please take a picture of your valid ID for the validation</span>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="validID" name="validID">
                </div>
                <span class="error"><?= $errors['validID'] ?? ''; ?></span>

                <div class="d-flex d-inline">
                    <div class="mb-3 me-3" id="consentForm"
                        style="display: <?= $relation == 'none of the above' ? 'inline' : 'none'; ?>">
                        <label for="consent" class="form-label">Consent Form</label>
                        <input type="file" class="form-control" id="consent" name="consent">
                        <span class="error"><?= $errors['consentFile'] ?? ''; ?></span>
                    </div>

                    <div class="mb-3 w-100" id="deliveryAddress"
                        style="display: <?= $type == 'Deliver' ? 'inline' : 'none'; ?>">
                        <label for="where_deliver" class="form-label">Where to deliver</label>
                        <input type="text" class="form-control" id="where_deliver" name="where_deliver"
                            value="<?= htmlspecialchars($deliveryAddress) ?>">
                        <span class="error"><?= $errors['where_deliver'] ?? ''; ?></span>
                    </div>
                </div>
                <br>
                <hr>
                <div class="remiders_note" id="content_to_pdf">
                    <span class="area fw-bold">Document Request Details: </span><br>
                    <?php
                    $client_name = $_SESSION['name'];
                    $qry_run = mysqli_query($conn, "SELECT * FROM documentrequests WHERE requesting_party ='$client_name'");
                    if ($qry_run->num_rows > 0) {
                        $fetch = $qry_run->fetch_assoc();
                        ?>
                        <span><b>Document Type:</b> <?php echo $fetch['document_type']; ?></span><br>
                        <span><b>Requested By:</b> <?php echo $fetch['requesting_party']; ?></span><br>
                        <span><b>Document Details:</b><br>Name: <?php echo $fetch['docu_details']; ?> <br> Date of Baptism: <?php echo date("F j, Y", strtotime($fetch['date_bap'])); ?></span><br>
                        <?php
                        if ($fetch['relation_to_owner'] == "none of the above") {
                            ?>
                            <span><b>Relation to the owner of the document:</b> Relatives</span><br>
                            <?php
                        } else {
                            ?>
                            <span><b>Relation to the owner of the document:</b>
                                <?php echo $fetch['relation_to_owner']; ?></span><br>
                            <?php
                        }
                        ?>
                        <span><b>Contact Number:</b> <?php echo $fetch['contact']; ?></span><br>
                        <span><b>Status:</b> <?php echo $fetch['comment']; ?></span><br>
                        <?php
                    }
                    ?>
                </div>
                <hr>
                <div class="button_area d-flex justify-content-between mt-3">
                    <button type="button" id="dl-pdf" class="btn btn-success" <?= $qry_run->num_rows > 0 ? '' : 'disabled'; ?>><i class="bi bi-download"></i>
                        Download</button>
                    <button type="submit" name="submit_request" class="btn btn-primary">Request</button>
                </div>
            </form>
        </div>
        <hr>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var relationSelect = document.getElementById("relation");
            var consentForm = document.getElementById("consentForm");
            var wherefromRadios = document.querySelectorAll('input[name="wherefrom"]');
            var deliveryAddress = document.getElementById("deliveryAddress");

            function toggleConsentForm() {
                consentForm.style.display = relationSelect.value === "none of the above" ? "inline" : "none";
            }

            function toggleAddressField() {
                // Check if the 'YES' radio is selected to decide whether to show or hide the deliveryAddress
                var isDeliverySelected = Array.from(wherefromRadios).some(radio => radio.checked && radio.value === "YES");
                deliveryAddress.style.display = isDeliverySelected ? "inline" : "none";
            }

            relationSelect.addEventListener('change', toggleConsentForm);
            wherefromRadios.forEach(radio => radio.addEventListener('change', toggleAddressField));

            // Initialize forms based on current selections
            toggleConsentForm();
            toggleAddressField();
        });
    </script>
    <section id="footer" class="footercontact">
        <div class="footer container">
            <div class="brand">
                <h1><span>D</span>SSNP <span>P</span>ORTAL</h1>
            </div>
            <p>Copyright © 2024 Diocesan Shrine of Sto. Niño Parish</p>
        </div>
    </section>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Existing code for form handling

        <?php if ($insertionSuccess): ?>
            Swal.fire({
                title: 'Success!',
                text: 'Your document request has been successfully submitted.',
                icon: 'success',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Clear all input fields in the form
                    document.getElementById('documentrequestform').reset();
                }
            });
        <?php endif; ?>
    });
    function validation() {

        var username = 'user';
        var password = 'pass';
        var user = document.getElementById('user').value;
        var pass = document.getElementById('pass').value;
        if ((username == user) && (password == pass)) {
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success"
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: '<a href="#">Why do I have this issue?</a>'
            });
        }
    }
</script>

</html>
<script src="js/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script type="text/javascript">
    window.onload = function () {
        document.getElementById('dl-pdf').onclick = function () {
            var element = document.getElementById('content_to_pdf');
            var opt = {
                margin: 1,
                filename: 'RequestSummary.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        };
    };
</script>
<?php
include_once 'header.php';
include("functions/dbcon.php");
$name = "";
$email = "";
$message = "";
$errors = []; // Initialize an array to store error messages

if (isset($_POST['btndonate'])) {
    // Get and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));
    $status = "pending";

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Handle file upload
    $targetDir = "uploads/receipt/";
    $targetFile = $targetDir . basename($_FILES["receipt"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES["receipt"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check file size (increased to 10MB)
    if ($_FILES["receipt"]["size"] > 10000000) {
        $errors[] = "Sorry, your file is too large. Maximum file size is 10MB.";
        $uploadOk = 0;
    }

    // Proceed with file upload if no errors
    if ($uploadOk && empty($errors)) {
        if (move_uploaded_file($_FILES["receipt"]["tmp_name"], $targetFile)) {
            // Store only the filename in the database
            $receiptName = basename($_FILES["receipt"]["name"]);
            
            // Corrected INSERT statement
            $stmt = $conn->prepare("INSERT INTO donors (name, email, message, receipt_path, date, status) VALUES (?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("sssss", $name, $email, $message, $receiptName, $status);
            
            if ($stmt->execute()) {
                $_SESSION['donation_success'] = true; // Set session variable for success
                // Clear form data
                $name = "";
                $email = "";
                $message = "";
        
                // Redirect to the same page to prevent form resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit; // Ensure script execution stops here
            } else {
                $errors[] = "Database error: " . $stmt->error;
            }
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }

    // Store errors in session if there are any
    if (!empty($errors)) {
        $_SESSION['message'] = implode(', ', $errors); // Combine errors into a single message
    }
} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png" style="border-radius: 50%;">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Donation | Sto. Niño</title>
    <style>
        
        .container-fluid {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 89vh;
            background-color: #f9f9f9; /* Light background for the page */
        }

        .form-donation {
            width: 100%;
            max-width: 700px;
            padding: 0;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        /* Title Section (Top - White Background) */
        .title-section {
            background-color: #ffffff;
            padding: 30px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
            font-style: italic;
        }

        /* Middle Section (Gray Background) */
        .middle-section {
            background-color: #f4f4f4;
            padding: 30px 50px 60px; /* Extra bottom padding for floating button */
            position: relative;
        }

        /* Form */
        form .form-group {
            margin-bottom: 15px;
        }
        form .form-group input[type="text"],
        form .form-group input[type="email"],
        form .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            background-color: #fff; /* White background for inputs */
        }
        
        /* Textarea Style */
        form .form-group textarea {
            resize: none;
            height: 80px;
        }

        /* File Input */
        .file-upload {
            margin-bottom: 20px;
        }
        .file-upload input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            cursor: pointer;
            font-size: 14px;
        }

        /* Submit Button */
        .submit-btn {
            background-color: #ff5c5c;
            color: #fff;
            padding: 15px 40px;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: absolute;
            left: 50%;
            transform: translate(-50%, 0); /* Center horizontally */
            bottom: -25px; /* Position halfway over gray and white sections */
            z-index: 1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .submit-btn:hover {
            background-color: #e94e4e;
        }

        /* Footer Section (Bottom - White Background) */
        .footer-section {
            background-color: #ffffff;
            padding: 50px 50px 20px; /* Extra top padding for button overlay */
            font-size: 12px;
            color: #555;
            line-height: 1.5;
            position: relative;
            z-index: 0;
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
    text-align: center;
}
/* Adjust the .donors section to use Flexbox for responsiveness */
.donors {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Cards will take a minimum width of 300px and automatically fill the space */
    gap: 20px;
    margin: 5% 5%;
    justify-items: center; /* Center the cards in the grid */
}

.card {
    width: 100%; /* Ensure card takes full width in the grid */
    max-width: 700px; /* Limit the max width of the cards */
    box-sizing: border-box;
}

.card-header {
    background-color: #ff5c5c;
}

.card-body p {
    font-size: 1rem;
}

/* Add media queries to adjust card size for smaller viewports */
@media (max-width: 768px) {
    .card {
        width: 100%; /* Full width for smaller screens */
    }
}

@media (max-width: 480px) {
    .card {
        width: 100%; /* Full width for very small screens */
        margin: 0 10px; /* Add some padding to the sides */
    }
    .title-section {
        font-size: 18px; /* Adjust title size for small screens */
    }
    .submit-btn {
        font-size: 16px; /* Make submit button text smaller */
    }
}

    </style>
</head>
<body>
<?php include 'functions/message.php'; ?>
<div class="container-fluid">
    <div class="form-donation">
        <div class="title-section">“ Be the Blessing ”</div>
        <div class="middle-section">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name (Optional)" value="<?php echo htmlspecialchars($name); ?>">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Message (Optional)"><?php echo htmlspecialchars($message); ?></textarea>
                </div>
                <div class="file-upload">
                    <input type="file" name="receipt" required>
                </div>
                <button type="submit" name="btndonate" class="submit-btn">Donate</button>
            </form>

            <!-- Display errors if there are any -->
            <?php if (!empty($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="footer-section">
            Your donations directly support parish initiatives, including community outreach, maintenance of church facilities, religious education programs, and services for those in need, helping us build a stronger, faith-filled community together.
        </div>
    </div>
</div>
<?php

// Fetch donors from the database
$query = "SELECT name, message, date FROM donors WHERE status = 'posted' ORDER BY date DESC;"; // Adjust the query as necessary
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="donors">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <div class="card-header text-white">
                    Special thanks to: <?php echo htmlspecialchars($row['name']); ?>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p><span class="fw-bold">Message:</span> <?php echo htmlspecialchars($row['message']); ?></p>
                        <footer class="blockquote-footer">Date: <?php echo htmlspecialchars($row['date']); ?></footer>
                    </blockquote>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="card">
            <div class="card-header text-white">
                Special thanks to:
            </div>
            <div class="card-body">
                <p>No donations recorded.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$stmt->close();
$conn->close(); // Close the database connection
?>

      <!---------------------------- FOOTER ---------------------------------->
      <section id="footer" class="footercontact">
        <div class="footer container">
            <div class="brand">
                <h1><span>D</span>SSNP <span>P</span>ORTAL</h1>
            </div>
            <p>Copyright © 2024 Diocesan Shrine of Sto. Niño Parish</p>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_SESSION['donation_success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Thank you!',
                text: 'Donation details successfully saved.',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['donation_success']); // Clear the session variable ?>
        <?php endif; ?>

        // Display errors from session
        <?php if (!empty($errors)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '<?php echo implode('\\n', $errors); ?>',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    });
</script>
</body>
</html>
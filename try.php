<?php
include "functions/dbcon.php"; // Ensure this file connects to your database

// Query to check if a live link exists
$sql = "SELECT live_link FROM live_videos WHERE live_status = 1 ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);
$liveLink = null;

if ($result->num_rows > 0) {
    // Fetch the link if there is one
    $row = $result->fetch_assoc();
    $liveLink = $row['live_link'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="images/logo.png" style="border-radius: 50%;">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <style>
     /* Floating live video player style */
    #floatingLivePlayer {
        position: fixed;
        bottom: 20px; /* Adjusted for position at the bottom */
        left: 20px; /* Adjusted for position on the left */
        width: 300px;
        height: 200px;
        background-color: #000;
        z-index: 1050; /* Lower z-index to stay beneath navbar */
        border-radius: 10px;
        overflow: hidden;
        display: none; /* Initially hidden */
    }

    #floatingLivePlayer iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Close button style */
    #closeLivePlayerBtn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #f44336; /* Red color */
        color: white;
        border: none;
        padding: 5px 10px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
    }

    /* Live button style */
    #liveButton {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background-color: #f44336; /* Red color */
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        display: none; /* Initially hidden */
        cursor: pointer;
        z-index: 1049; /* Ensure it's below navbar but above other elements */
    }

    /* Bolder text for icons */
    .bi {
        font-weight: bolder;
    }
    </style>
</head>
<body>

<!-- Floating Video Player Container -->
<div id="floatingLivePlayer">
    <?php if ($liveLink): ?>
        <button id="closeLivePlayerBtn">Close</button>
        <iframe id="liveIframe" src="<?= htmlspecialchars($liveLink) ?>" allow="autoplay" frameborder="0" allowfullscreen></iframe>
    <?php endif; ?>
</div>

<!-- Live Button -->
<button id="liveButton"><i class="bi bi-dot"></i>Live Mass</button>

<script>
    // Check if the PHP variable $liveLink is set, and show the floating video if it is
    <?php if ($liveLink): ?>
        $(document).ready(function() {
            $('#floatingLivePlayer').fadeIn(); // Show the floating live player when page loads
            $('#liveButton').fadeOut(); // Hide the "Live" button initially
        });

        // Close the video player and show the "Live" button
        $('#closeLivePlayerBtn').click(function() {
            $('#floatingLivePlayer').fadeOut(); // Hide the floating player
            $('#liveButton').fadeIn(); // Show the "Live" button
        });

        // Show the floating player again when clicking the "Live" button
        $('#liveButton').click(function() {
            $('#floatingLivePlayer').fadeIn(); // Show the floating player
            $('#liveButton').fadeOut(); // Hide the "Live" button
        });

        // Stop the video when the modal closes and hide the floating player
        $(window).on('beforeunload', function() {
            $('#floatingLivePlayer').fadeOut(); // Hide the floating player when the page is about to be unloaded
            $('#liveIframe').attr('src', ''); // Stop the video by clearing the iframe src
        });
    <?php endif; ?>
</script>

</body>
</html>

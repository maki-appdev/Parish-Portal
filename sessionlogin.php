<?php
session_start();

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "dssnp - portal"; // Ensure the database name is correct and does not contain spaces

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function clean($str) {
    global $conn;
    $str = trim($str);
    return mysqli_real_escape_string($conn, $str);
}

$login = isset($_POST['email']) ? clean($_POST['email']) : '';
$password = isset($_POST['pass']) ? clean($_POST['pass']) : '';

if (empty($login) || empty($password)) {
    // Redirect back to login with error message
    header("Location: login.php?error=emptyfields");
    exit();
}

$qry = $conn->prepare("SELECT * FROM account_details WHERE email=?");
$qry->bind_param("s", $login);
$qry->execute();
$result = $qry->get_result();

if ($result->num_rows > 0) {
    $member = $result->fetch_assoc();

    if (password_verify($password, $member['pass'])) {
        // Initialize session array for users if not already set
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [];
        }

        // Add or update the user session information
        $_SESSION['users'][$member['email']] = [
            'SESS_MEMBER_ID' => $member['user_ID'],
            'SESS_FIRST_NAME' => $member['name'],
            'email' => $member['email']
        ];

        // Redirect based on the type of user logged in
        switch ($member['email']) {
            case 'dssnpportal@socom.com':
                header("Location: socom/dashboard.php");
                break;
            case 'dssnpportal@admin.com':
                header("Location: admin/dashboard.php");
                break;
            default:
                header("Location: index.php");
                break;
        }
        exit();
    } else {
        header("Location: login.php?error=invalidpassword");
        exit();
    }
} else {
    header("Location: login.php?error=nouser");
    exit();
}

?>

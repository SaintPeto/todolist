<?php
session_start();

error_reporting(E_ALL); // Report all errors and warning
ini_set('display_errors', 1); // Fix typo in ini_set

$dbhostname = 'sql8.freesqldatabase.com';
$dbdatabase = 'sql8768322';
$dbuser = 'sql8768322';
$dbpass = 'Ww4g9YhH1k';
$port = '3306';

// Connect to the database
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase, $port);

// Check connection
if ($conn->connect_error) {
    die("❌ Could not connect to DB server: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check for empty fields inside the request check
    if (empty($username) || empty($password)) {
        exit("⚠️ Username and password cannot be empty.");
    }

    // Sanitize username to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT password FROM tblusers WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION["username"] = $username;
                header("Location: todo.html"); // Redirect immediately
                exit();
            } else {
                exit("❌ Invalid password!");
            }
        } else {
            exit("❌ No user found!");
        }

        $stmt->close();
    } else {
        exit("❌ Error preparing SQL statement: " . $conn->error);
    }
}

$conn->close();
?>

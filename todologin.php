<?php
session_start();

error_reporting(E_ALL); // Report all errors and warning
ini_set('display_erros', 1); //Display errors on the screen

$dbhostname = 'sql8.freesqldatabase.com';
$dbdatabase = 'sql8768322';
$dbuser = 'sql8768322';
$dbpass = 'Ww4g9YhH1k';

// Connect to the database
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase);

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
        die("⚠️ Username and password cannot be empty.");
    }

    // Sanitize username to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT password FROM tblusers WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // DEBUG: Print the stored hashed password
            echo "Stored Hashed Password: " . $hashed_password . "<br>";

            // Verify password
            if (password_verify($password, $hashed_password)) {
                echo "✅ Password matches! Redirecting...";
                $_SESSION["username"] = $username;
                header("refresh:2; url=todo.html"); // Redirect to display page after 2 seconds
                exit();
            } else {
                echo "❌ Invalid password!";
            }
        } else {
            echo "❌ No user found!";
        }

        $stmt->close();
    } else {
        echo "❌ Error preparing SQL statement: " . $conn->error;
    }
}

$conn->close();
?>

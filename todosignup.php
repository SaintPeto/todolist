<?php
//session_start();

// Database connection details
$dbhostname = 'sql8.freesqldatabase.com';
$dbdatabase = 'sql8768322';
$dbuser = 'sql8768322';
$dbpass = 'Ww4g9YhH1k';

// Connect to the database
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase);

// Check connection
if ($conn->connect_error) {
    die("Could not connect to DB server on $dbhostname: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($name) || empty($phone) || empty($email) || empty($username) || empty($password)) {
        die("All fields are required.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // DEBUG: Print the hashed password to verify
    //echo "Hashed Password: " . $hashed_password . "<br>";

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO tblusers (name, phone, email, username, password) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('sssss',$name, $phone, $email, $username, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration Successful! <br>";
        echo "<a href='todologin.html'>Click here to Login</a>"; // Redirect to login page
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

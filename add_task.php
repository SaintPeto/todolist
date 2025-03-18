<?php
//session_start();

// Database connection details
$dbhostname = 'localhost';
$dbdatabase = 'db_todolist';
$dbuser = 'root';
$dbpass = '';

// Connect to the database
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase);

// Check connection
if ($conn->connect_error) {
    die("Could not connect to DB server on $dbhostname: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim inputs
    $no = trim($_POST['no']);
    $task = trim($_POST['task']);

    // Validate required fields
    if (empty($no) || empty($task)) {
        die("All fields are required.");
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO tbllist (no, task) VALUES (?, ?)");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('is',$no, $task);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Task Added Successful! <br>";
        echo "<a href='todo.html'>Add again</a>"; // Redirect to login page
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

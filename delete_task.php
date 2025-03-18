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
if (isset($_GET["no"])) {
    $no = $_GET["no"];
    $task = $_GET["task"];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE no = ?");
    $stmt->bind_param("is", $no, $task);

    if ($stmt->execute()) {
        echo "Task Deleted Successful! <br>";
        echo "<a href='todo.html'>Add again</a>"; // Redirect to login page
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->execute();
    $stmt->close();
}

$conn->close();

?>




<?php

$dbhostname = 'sql8.freesqldatabase.com';
$dbdatabase = 'sql8768322';
$dbuser = 'sql8768322';
$dbpass = 'Ww4g9YhH1k';
$port = '3306';

// Connect to the database
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase);

// Add Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"]) && isset($_POST["category"])) {
    $task = $conn->real_escape_string($_POST["task"]);
    $category = $conn->real_escape_string($_POST["category"]);
    $sql = "INSERT INTO tasks (task, category) VALUES ('$task', '$category')";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Mark as Completed
if (isset($_GET["complete"])) {
    $id = intval($_GET["complete"]);
    $conn->query("UPDATE tasks SET completed = 1 WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Delete Task
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM tasks WHERE id = $id");
    header("Location: index.php");
    exit();
}

$conn->close();
?>

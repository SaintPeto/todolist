<?php
$conn = new mysqli('localhost', 'root', '', 'todo_db');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - View Tasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        h2 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        .delete-btn {
            color: red;
            cursor: pointer;
            float: right;
            border: none;
            background: none;
        }
    </style>
</head>
<body>

    <h2>Your To-Do List</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");

        while ($row = $result->fetch_assoc()) {
            echo "<li>" . nl2br(htmlspecialchars($row['task'])) . 
                 " <button class='delete-btn' onclick='deleteTask(" . $row['id'] . ")'>❌</button></li>";
        }

        $conn->close();
        ?>
    </ul>

    <script>
        function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                fetch("delete_task.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + taskId
                })
                .then(response => response.text())
                .then(() => location.reload()); // Reload to update list
            }
        }
    </script>

</body>
</html>

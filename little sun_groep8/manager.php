<?php
include_once("managerhome.php"); // Inclusief de manager startpagina

// Databaseverbinding
include_once("db_conn.php");

// Controleer of er een formulier is ingediend om een taak toe te voegen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvang gegevens van het formulier
    $user_id = $_POST['user_id'];
    $task_date = $_POST['task_date'];
    $task_description = $_POST['task_description'];
    $task_start_time = $_POST['task_start_time'];
    $task_end_time = $_POST['task_end_time'];

    // Voeg de taak toe aan de database
    $sql = "INSERT INTO taken (user_id, task_date, task_description, task_start_time, task_end_time) 
            VALUES ('$user_id', '$task_date', '$task_description', '$task_start_time', '$task_end_time')";

    if ($conn->query($sql) === TRUE) {
        echo "Taak succesvol toegewezen!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Haal gebruikers op uit de database
$sql_users = "SELECT id, user_name FROM users";
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Task</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="assign-task">
        <h2>Assign Task</h2>
        <form action="manager.php" method="post">
            <label>Select User:</label>
            <select name="user_id">
                <?php
                // Itereer door de gebruikers en genereer de opties voor de selectbox
                if ($result_users->num_rows > 0) {
                    while ($row = $result_users->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['user_name'] . "</option>";
                    }
                }
                ?>
            </select><br>

            <label>Task Date:</label>
            <input type="date" name="task_date" required><br>

            <label>Task Start Time:</label>
            <input type="time" name="task_start_time" required><br>

            <label>Task End Time:</label>
            <input type="time" name="task_end_time" required><br>

            <label>Task Description:</label>
            <textarea name="task_description" rows="4" cols="50" required></textarea><br>

            <button type="submit">Assign Task</button>
        </form>
    </div>

    <!-- Toegevoegde sectie om toegewezen taken weer te geven -->
    <div class="assigned-tasks">
        <h2>Assigned Tasks</h2>
        <table>
            <tr>
                <th>User</th>
                <th>Task Date</th>
                <th>Task Description</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php
            // Voeg de logica toe om de taken op te halen uit de database
            $sql_tasks = "SELECT * FROM taken";
            $result_tasks = $conn->query($sql_tasks);

            // Itereer door de resultaten en toon de taken in de tabel
            if ($result_tasks->num_rows > 0) {
                while ($row = $result_tasks->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row["task_date"] . "</td>";
                    echo "<td>" . $row["task_description"] . "</td>";
                    echo "<td>" . $row["task_start_time"] . "</td>";
                    echo "<td>" . $row["task_end_time"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No tasks assigned</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>


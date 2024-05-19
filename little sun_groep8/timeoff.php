<?php
// Databaseverbinding
include_once ("db_conn.php");
include_once ("managerhome.php");


// Process the submitted time-off request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clock_action'])) {
        $user_name = $_POST['user'];
        $action = $_POST['clock_action'];
        $timestamp = date('Y-m-d H:i:s');

        // Voeg de gegevens toe aan de database
        $sql = "INSERT INTO clock (user_name, action, timestamp) VALUES ('$user_name', '$action', '$timestamp')";

        if ($conn->query($sql) === TRUE) {
            if ($action == "clock_in") {
                echo "Klok ingedrukt!";
            } elseif ($action == "clock_out") {
                echo "Klok uitgedrukt!";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($_POST["reason"]) {
        $user_name = $_POST['user'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $reason = $_POST['reason'];

        // Query to get the user_id based on the entered user name
        $sql_user_id = "SELECT id FROM users WHERE name = '$user_name'";
        $result_user_id = $conn->query($sql_user_id);

        if ($result_user_id->num_rows > 0) {
            $row = $result_user_id->fetch_assoc();
            $user_id = $row['id'];

            // Insert the time-off into the database
            $sql_insert_time_off = "INSERT INTO time_off (user_id, date, start_time, end_time, reason) VALUES ('$user_id', '$date', '$start_time', '$end_time', '$reason')";
            if ($conn->query($sql_insert_time_off) === TRUE) {
                echo "Time-off is toegevoegd!";
                // Refresh the page to reflect the updated time-off data
                echo '<meta http-equiv="refresh" content="0">';
            } else {
                echo "Error: " . $sql_insert_time_off . "<br>" . $conn->error;
            }
        } else {
            echo "Gebruiker niet gevonden!";
        }
    } else {
        echo "Ongeldige formulieractie.";
    }
}
?>



<!DOCTYPE html>
<html>


<link rel="stylesheet" type="text/css" href="CSS/kalender.css">

<body>

    <header>
        <nav class="vertical-nav">
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <ul>
                <li><a href="home.php">Kalender</a></li>
                <li><a href="timeoff.php">Time-off</a></li>
            </ul>
            <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </header>

    <div class="week-navigation">
        <!-- navigatieknoppen -->
    </div>

    <!-- Formulier voor het toevoegen van time-off -->
    <form action="" method="post">
        <h2>Agenda Punt</h2>
        <label for="user">Naam:</label>
        <input type="text" id="user" name="user" required><br>
        <label for="date">Datum:</label>
        <input type="date" id="date" name="date" required><br>
        <label for="start_time">Begintijd:</label>
        <input type="time" id="start_time" name="start_time" required><br>
        <label for="end_time">Eindtijd:</label>
        <input type="time" id="end_time" name="end_time" required><br>
        <label for="reason">Reden:</label>
        <input type="text" id="reason" name="reason" required><br>
        <button class="button" type="submit">Voeg Time-Off Toe</button>

    </form>




    <footer>
        <!-- footer content -->
    </footer>

    <?php
    // Sluit de databaseverbinding
    $conn->close();
    ?>

</body>

</html>
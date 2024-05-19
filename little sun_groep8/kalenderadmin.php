<?php
// Databaseverbinding
include_once ("db_conn.php");


// Bereken de start- en einddatum van de huidige week
$current_date = date('Y-m-d');
$start_date = date('Y-m-d', strtotime('last monday', strtotime($current_date)));
$end_date = date('Y-m-d', strtotime('next sunday', strtotime($current_date)));

// Query om taken op te halen voor de huidige week
$sql_tasks = "SELECT * FROM taken WHERE task_date BETWEEN '$start_date' AND '$end_date'";
$result_tasks = $conn->query($sql_tasks);

// Array om taken per dag op te slaan
$tasks_per_day = [];

// Initialiseer array met lege arrays voor elke dag
$current_date = $start_date;
while ($current_date <= $end_date) {
    $tasks_per_day[$current_date] = [];
    $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
}

// Vul de array met taken per dag
if ($result_tasks->num_rows > 0) {
    while ($row = $result_tasks->fetch_assoc()) {
        $tasks_per_day[$row['task_date']][] = $row;
    }
}

// Fetch time-off data from the database
$sql_time_off = "SELECT * FROM time_off";
$result_time_off = $conn->query($sql_time_off);

// Create an array to store time-off dates
$time_off_dates = [];
$total_time_off_hours = 0; // Variable to store the total time-off hours

if ($result_time_off->num_rows > 0) {
    while ($row = $result_time_off->fetch_assoc()) {
        if (!isset($time_off_dates[$row['date']])) {
            $time_off_dates[$row['date']] = [];
        }
        $time_off_dates[$row['date']][] = $row;

        // Calculate the duration of the time-off and add it to the total
        $start_time = strtotime($row['start_time']);
        $end_time = strtotime($row['end_time']);
        $duration = ($end_time - $start_time) / 3600; // Convert seconds to hours

        $total_time_off_hours += $duration;
    }
}

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

<head>
    <title>Task Calendar</title>
    <link rel="stylesheet" type="text/css" href="CSS/kalender.css">
    <style>
        .week-calendar {
            display: flex;
            flex-wrap: wrap;
        }

        .day {
            width: 14%;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 5px;
        }

        .day h3 {
            margin-top: 0;
        }

        .task {
            margin-bottom: 5px;
        }

        .time-off {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <header>
        <header>
            <nav class="vertical-nav">
                <div class="logo">
                    <img src="images/logo.png" alt="Logo">
                </div>
                <ul>
                    <li><a href="accounts.php">Admin</a></li>
                    <li><a href="admin.php">Create Hub location</a></li>
                    <li><a href="managers.php">Create Hub Managers</a></li>
                    <li><a href="test.php">test</a></li>
                    <li><a href="admintask.php">task allocator</a></li>
                    <li><a href="kalenderadmin.php">kalender</a></li>
                </ul>
                <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
            </nav>
        </header>
    </header>

    <div class="week-navigation">
        <!-- navigatieknoppen -->
    </div>

    <div class="week-calendar">
        <?php
        // Loop through each day of the week
        $current_date = $start_date;
        while ($current_date <= $end_date) {
            // Check if the current date is in the time-off dates array
            if (isset($time_off_dates[$current_date])) {
                // Display time-off with reason and times
                echo "<div class='day time-off'>";
                echo "<h3>Time-off - " . $current_date . "</h3>";
                foreach ($time_off_dates[$current_date] as $time_off) {
                    echo "<p>Reden: " . $time_off['reason'] . "</p>";
                    echo "<p>Begintijd: " . $time_off['start_time'] . "</p>";
                    echo "<p>Eindtijd: " . $time_off['end_time'] . "</p>";
                }
                echo "</div>";
            } else {
                // Display regular day with tasks
                echo "<div class='day'>";
                echo "<h3>" . date('l', strtotime($current_date)) . " - " . $current_date . "</h3>";

                // Display tasks for the current day
                foreach ($tasks_per_day[$current_date] as $task) {
                    echo "<div class='task'>";
                    echo "<strong>User:</strong> " . $task["user_id"] . "<br>";
                    echo "<strong>Task:</strong> " . $task["task_description"] . "<br>";
                    echo "<strong>Time:</strong> " . $task["task_start_time"] . " - " . $task["task_end_time"];
                    echo "</div>";
                }

                // Display message if there are no tasks for the day
                if (empty($tasks_per_day[$current_date])) {
                    echo "Geen taken";
                }

                echo "</div>";
            }

            // Move to the next day
            $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
        }
        ?>
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
        <br><br><br>
        <label for="user">Naam:</label>
        <input type="text" id="user" name="user" required><br>
        <button class="button2" type="submit" name="clock_action" value="clock_in">Klok In</button>
        <button type="submit" name="clock_action" value="clock_out">Klok Uit</button>
    </form>

    <footer>
        <!-- footer content -->
    </footer>

    <div>
        <h2>Total Time-Off Hours</h2>
        <p><?php echo $total_time_off_hours; ?> uur</p>
    </div>

</body>

</html>

<?php
// Sluit de databaseverbinding
$conn->close();
?>
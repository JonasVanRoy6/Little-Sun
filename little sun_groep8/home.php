<?php
// Start de sessie
session_start();

// Databaseverbinding
include_once ("db_conn.php");

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_name'])) {
     die("U moet ingelogd zijn om deze pagina te bekijken.");
}

$user_name = $_SESSION['user_name'];

// Verkrijg de user_id van de ingelogde gebruiker
$sql_user_id = "SELECT id FROM users WHERE name = '$user_name'";
$result_user_id = $conn->query($sql_user_id);
if ($result_user_id->num_rows > 0) {
     $row = $result_user_id->fetch_assoc();
     $user_id = $row['id'];
} else {
     die("Gebruiker niet gevonden.");
}

// Bereken de start- en einddatum van de huidige week
$current_date = date('Y-m-d');
$start_date = date('Y-m-d', strtotime('last monday', strtotime($current_date)));
$end_date = date('Y-m-d', strtotime('next sunday', strtotime($current_date)));

// Query om taken op te halen voor de huidige week van de ingelogde gebruiker
$sql_tasks = "SELECT * FROM taken WHERE user_id = $user_id AND task_date BETWEEN '$start_date' AND '$end_date'";
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

// Fetch time-off data for the logged-in user
$sql_time_off = "SELECT * FROM time_off WHERE user_id = $user_id";
$result_time_off = $conn->query($sql_time_off);

// Create an array to store time-off dates
$time_off_dates = [];
if ($result_time_off->num_rows > 0) {
     while ($row = $result_time_off->fetch_assoc()) {
          if (!isset($time_off_dates[$row['date']])) {
               $time_off_dates[$row['date']] = [];
          }
          $time_off_dates[$row['date']][] = $row;
     }
}

// Process the submitted time-off request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST['clock_action'])) {
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
          $date = $_POST['date'];
          $start_time = $_POST['start_time'];
          $end_time = $_POST['end_time'];
          $reason = $_POST['reason'];

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
          echo "Ongeldige formulieractie.";
     }
}
?>
<!DOCTYPE html>
<html>

<head>
     <title>Task Calendar</title>
     <link rel="stylesheet" type="text/css" href="CSS/kalender.css">
     <link rel="stylesheet" type="text/css" href="CSS/home.css">
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

     <form action="" method="post">
          <label for="user">Naam:</label>
          <input type="text" id="user" name="user" required><br>
          <button type="submit" name="clock_action" value="clock_in">Klok In</button>
          <button type="submit" name="clock_action" value="clock_out">Klok Uit</button>
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
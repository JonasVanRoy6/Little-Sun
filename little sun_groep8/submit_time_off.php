<?php
include_once("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $reason = $_POST['reason'];

    // Voeg time-off toe aan de database
    $sql = "INSERT INTO time_off (date, reason) VALUES ('$date', '$reason')";
    if ($conn->query($sql) === TRUE) {
        echo "Time-off is succesvol toegevoegd!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

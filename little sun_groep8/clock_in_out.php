<?php
// Databaseverbinding
include_once("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['clock_in'])) {
        // Klok in actie
        $user_name = $_POST['user'];
        $action = "clock_in";
        $timestamp = date('Y-m-d H:i:s');

        // Voeg de gegevens toe aan de database
        $sql = "INSERT INTO clock (user_name, action, timestamp) VALUES ('$user_name', '$action', '$timestamp')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Klok ingedrukt!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['clock_out'])) {
        // Klok uit actie
        $user_name = $_POST['user_out'];
        $action = "clock_out";
        $timestamp = date('Y-m-d H:i:s');

        // Voeg de gegevens toe aan de database
        $sql = "INSERT INTO clock (user_name, action, timestamp) VALUES ('$user_name', '$action', '$timestamp')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Klok uitgedrukt!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Ongeldige formulieractie.";
    }
} else {
    echo "Geen POST-verzoek ontvangen.";
}
?>

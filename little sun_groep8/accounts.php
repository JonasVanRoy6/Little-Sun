<?php

include "db_conn.php";
include_once ("adminhome.php");

?>

<?php
// Stap 2: Haal de gegevens van de accounts op uit de database
$sql = "SELECT id, user_name, password, name FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Toon de gegevens van elk account
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - name: " . $row["user_name"] . " - password: " . $row["password"] . "<br>";
        // Voeg een verwijderknop toe voor elk account
        echo "<form method='post' action='deleteaccounts.php'>";
        echo "<input type='hidden' name='users' value='" . $row["id"] . "'>";
        echo "<input type='submit' value='Verwijder'>";
        echo "</form>";
    }
} else {
    echo "Geen accounts gevonden";
}

$conn->close();
?>
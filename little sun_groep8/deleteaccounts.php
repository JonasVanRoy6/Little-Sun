<?php
session_start(); // Zorg ervoor dat sessies correct worden gestart

// Controleer of de gebruiker ingelogd is
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Als de gebruiker niet ingelogd is, stuur door naar de loginpagina
    header("Location: login.php");
    exit();
}

// Zorg ervoor dat de verbinding met de database correct is
include "db_conn.php";

// Controleer of de vereiste invoer is ontvangen
if (isset($_POST['users_id'])) {
    $users_id = intval($_POST['users_id']); // Zet de ID om in een integer om SQL-injectie te voorkomen

    // Verwijder de gebruiker met prepared statements voor veiligheid
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $users_id); // "i" staat voor integer

    if ($stmt->execute()) {
        // Als de bewerking slaagt, geef feedback
        echo "Account succesvol verwijderd";
    } else {
        // Als de bewerking mislukt, toon foutbericht
        echo "Fout bij het verwijderen van het account: " . $stmt->error;
    }

    $stmt->close(); // Sluit de prepared statement
} else {
    // Als er geen gebruikers-ID is opgegeven
    echo "Gebruikers-ID is niet opgegeven";
}

// Sluit de databaseverbinding
$conn->close();
?>
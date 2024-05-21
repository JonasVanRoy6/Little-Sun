<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    // Verwijder de gebruiker uit de database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "Gebruiker succesvol verwijderd.";
    } else {
        echo "Fout bij het verwijderen van de gebruiker: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect terug naar de accounts pagina
    header("Location: accounts.php");
    exit();
}
?>
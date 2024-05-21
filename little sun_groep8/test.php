<?php
session_start();
include "db_conn.php";

// Controleer of de gebruiker is ingelogd en haal de rol op
if (!isset($_SESSION['user_name'])) {
    die("U moet ingelogd zijn om deze pagina te bekijken.");
}

$user_name = $_SESSION['user_name'];
$role = $_SESSION['role'];

// Zorg dat foutmeldingen zijn ingeschakeld voor debugging tijdens ontwikkeling
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Haal locaties op uit de database
$locationsQuery = $conn->query("SELECT id, name FROM locations");

if (!$locationsQuery) {
    die("Database error while fetching locations: " . $conn->error);
}

// Gebruikers toevoegen aan locatie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of de knop voor het toevoegen van een gebruiker is ingedrukt
    if (isset($_POST['add_user'])) {
        // Haal de POST-gegevens op en controleer of ze geldig zijn
        $locationId = $_POST['location_id'] ?? null;
        $username = $_POST['username'] ?? null;

        if ($locationId && $username) { // Controleer of beide waarden aanwezig zijn
            // Voeg de gebruiker toe aan de database met prepared statements
            $statement = $conn->prepare("INSERT INTO location_users (location_id, username) VALUES (?, ?)");

            if ($statement) {
                // Bind de parameters om SQL-injectie te voorkomen
                $statement->bind_param("is", $locationId, $username);

                // Probeer de gebruiker toe te voegen
                if ($statement->execute()) {
                    // Als succesvol, redirect naar de juiste pagina
                    header("Location: user_per_locatie.php?location_id=" . $locationId);
                    exit();
                } else {
                    // Als er een fout is tijdens de uitvoer, geef de foutmelding weer
                    die("Database error during insertion: " . $statement->error);
                }

                $statement->close(); // Vergeet niet de statement te sluiten
            } else {
                die("Error preparing statement: " . $conn->error);
            }
        } else {
            // Als de invoer niet geldig is, geef een foutmelding weer
            die("Invalid input: location ID and username are required.");
        }
    }

    // Controleer of de knop voor het verwijderen van een locatie is ingedrukt
    elseif (isset($_POST['delete_location'])) {
        $locationId = $_POST['location_id'] ?? null;
        if ($locationId) {
            // Verwijder eerst de gerelateerde records in location_users
            $deleteUsersStatement = $conn->prepare("DELETE FROM location_users WHERE location_id = ?");
            if ($deleteUsersStatement) {
                $deleteUsersStatement->bind_param("i", $locationId);
                if ($deleteUsersStatement->execute()) {
                    // Nadat de gerelateerde records zijn verwijderd, verwijder de locatie zelf
                    $deleteLocationStatement = $conn->prepare("DELETE FROM locations WHERE id = ?");
                    if ($deleteLocationStatement) {
                        $deleteLocationStatement->bind_param("i", $locationId);
                        if ($deleteLocationStatement->execute()) {
                            // Als de locatie succesvol is verwijderd, herlaad de pagina om de wijzigingen weer te geven
                            header("Refresh:0");
                            exit();
                        } else {
                            die("Database error during location deletion: " . $deleteLocationStatement->error);
                        }
                    } else {
                        die("Error preparing location delete statement: " . $conn->error);
                    }
                } else {
                    die("Database error during user deletion: " . $deleteUsersStatement->error);
                }
            } else {
                die("Error preparing user delete statement: " . $conn->error);
            }
        } else {
            die("Invalid input: location ID is required.");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
    <link rel="stylesheet" type="text/css" href="CSS/test.css">
</head>

<body>
    <?php
    // Include de juiste navigatiebalk op basis van de rol
    if ($role === 'admin') {
        include_once("adminhome.php");
    } elseif ($role === 'manager') {
        include_once("managerhome.php");
    }
    ?>
    <ul>
        <?php
        // Toon de lijst van locaties
        foreach ($locationsQuery as $location) {
            ?>
            <li>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <!-- Zorg voor de juiste actie -->
                    <h2><?php echo $location['name']; ?></h2>
                    <input type="hidden" name="location_id" value="<?php echo $location['id']; ?>">
                    <label>User Name</label> <!-- Locatienaam binnen het formulier -->

                    <input type="text" name="username" placeholder="User Name"> <!-- Zorg voor invoer -->
                    <button type="submit" name="add_user">Add User</button> <!-- Button binnen het formulier -->

                    <!-- Voeg een knop toe om locatie te verwijderen -->
                    <button type="submit" name="delete_location">Verwijder Locatie</button>
                </form>
            </li>
            <?php
        }
        ?>
    </ul>
</body>

</html>

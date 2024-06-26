<?php
session_start();
include "db_conn.php";
include_once ("adminhome.php");

// Locaties ophalen uit de database
$locations = array();
$locationsQuery = $conn->query("SELECT * FROM locations");
if ($locationsQuery) {
    while ($row = $locationsQuery->fetch_assoc()) {
        $locations[] = $row;
    }
    $locationsQuery->free();
} else {
    // Query foutafhandeling
    echo 'Error: ' . $conn->error;
}

// Gebruikers toevoegen aan locatie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['location_name'])) {
        $locationName = $_POST['location_name'];

        // Voeg de locatie toe aan de database
        $insertLocationStmt = $conn->prepare("INSERT INTO locations (name) VALUES (?)");
        $insertLocationStmt->bind_param("s", $locationName);
        $insertLocationStmt->execute();
        $insertLocationStmt->close();
        header("Location: test.php");
        exit();
    } else {
        echo "Location name is required.";
    }
}

// Sluit de databaseverbinding
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <link rel="stylesheet" href="css/kalender.css">
</head>

<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <h2>Add Location</h2>
        <label for="location_name">Location Name:</label>
        <input type="text" id="location_name" name="location_name" required>
        <button type="submit">Add Location</button>
    </form>


</body>

</html>
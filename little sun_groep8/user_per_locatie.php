<?php
// Verbinding maken met de database met mysqli
include "db_conn.php";
include_once ("adminhome.php");



// Haal locatiegegevens op
$locationId = $_GET['location_id'] ?? null;
var_dump($locationId);
if ($locationId === null) {
    die('Invalid location ID');
}

// Haal locatiegegevens op
$locationQuery = $conn->prepare("SELECT name FROM locations WHERE id = ?");
$locationQuery->bind_param("i", $locationId);
$locationQuery->execute();
$locationResult = $locationQuery->get_result();
$locationData = $locationResult->fetch_assoc();
$locationQuery->close();

// Haal gebruikersgegevens op
$usersQuery = $conn->prepare("SELECT * FROM location_users WHERE location_id = ?");
$usersQuery->bind_param("i", $locationId);
$usersQuery->execute();
$usersResult = $usersQuery->get_result();
$users = $usersResult->fetch_all(MYSQLI_ASSOC);
$usersQuery->close();

// Sluit de databaseverbinding
$conn->close();
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users at <?php echo $locationData['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Users at <?php echo $locationData['name']; ?></h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <!-- Voeg meer kolommen toe indien nodig -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <!-- Voeg meer kolommen toe indien nodig -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
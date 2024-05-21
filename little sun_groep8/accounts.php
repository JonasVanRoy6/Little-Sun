<!DOCTYPE html>
<html>

<head>
    <title>Accounts</title>
    <link rel="stylesheet" type="text/css" href="CSS/accounts.css">
</head>

<body>

    <div class="container">
        <h2>Accounts</h2>
        <?php
        include "db_conn.php";
        include_once ("adminhome.php");

        // Stap 2: Haal de gegevens van de accounts op uit de database
        $sql = "SELECT id, user_name, password, name FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Toon de gegevens van elk account
            while ($row = $result->fetch_assoc()) {
                echo "<div class='account'>";
                echo "<div class='account-info'>";
                echo "ID: " . $row["id"] . " - Naam: " . $row["user_name"] . " - Wachtwoord: " . $row["password"];
                echo "</div>";
                echo "<div class='account-actions'>";
                // Voeg een verwijderknop toe voor elk account
                echo "<form method='post' action='deleteaccounts.php'>";
                echo "<input type='hidden' name='user_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' value='Verwijder'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Geen accounts gevonden";
        }

        $conn->close();
        ?>
    </div>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Accounts</title>
    <style>
        /* CSS om de inhoud van de pagina te centreren */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">

        <?php
        include "db_conn.php";
        include_once ("adminhome.php");

        // Stap 2: Haal de gegevens van de accounts op uit de database
        $sql = "SELECT id, user_name, password, name FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Toon de gegevens van elk account
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Naam: " . $row["user_name"] . " - Wachtwoord: " . $row["password"] . "<br>";
                // Voeg een verwijderknop toe voor elk account
                echo "<form method='post' action='deleteaccounts.php' style='display:inline;'>";
                echo "<input type='hidden' name='user_id' value='" . $row["id"] . "'>";
                echo "<input type='submit' value='Verwijder'>";
                echo "</form>";
                echo "<br>";
            }
        } else {
            echo "Geen accounts gevonden";
        }

        $conn->close();
        ?>

    </div>

</body>

</html>
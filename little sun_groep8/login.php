<?php
session_start();
include "db_conn.php";

// Controleer of de gebruikersnaam en het wachtwoord zijn ingediend
if (isset($_POST['uname']) && isset($_POST['password'])) {
    // Functie om invoer te valideren
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Valideer en verkrijg de gebruikersnaam en het wachtwoord
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    // Controleer of de gebruikersnaam leeg is
    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        // Hash het wachtwoord
        $pass = md5($pass);

        // Selecteer de gebruiker uit de database
        $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            // Gebruiker gevonden
            $row = mysqli_fetch_assoc($result);

            // Zet sessievariabelen
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['rol']; // Zorg dat de rol wordt opgeslagen in de sessie

            // Doorsturen naar de juiste pagina op basis van de rol
            if ($row['rol'] === 'admin') {
                header("Location: accounts.php");
                exit();
            } elseif ($row['rol'] === 'manager') {
                header("Location: manager.php");
                exit();
            } else {
                header("Location: home.php");
                exit();
            }
        } else {
            // Gebruiker niet gevonden, doorsturen naar inlogpagina met foutmelding
            header("Location: index.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    // Als gebruikersnaam en wachtwoord niet zijn ingediend, doorsturen naar inlogpagina
    header("Location: index.php");
    exit();
}

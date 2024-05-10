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

			// Controleer of het wachtwoord "admin" is
			if ($row['password'] === md5('admin')) {
				$_SESSION['user_name'] = $row['user_name'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['id'] = $row['id'];
				// Als het wachtwoord "admin" is, doorsturen naar de admin-pagina
				header("Location: accounts.php");
				exit();
			} elseif ($row['password'] === md5('manager')) {
				$_SESSION['user_name'] = $row['user_name'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['id'] = $row['id'];
				// Als het wachtwoord "admin" is, doorsturen naar de admin-pagina
				header("Location: accounts.php");
				exit();
			} else {
				// Anders doorsturen naar de normale homepagina
				$_SESSION['user_name'] = $row['user_name'];
				$_SESSION['name'] = $row['name'];
				$_SESSION['id'] = $row['id'];
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

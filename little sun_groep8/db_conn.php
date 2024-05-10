<?php

$sname = "localhost";
$uname = "root";
$password = "root";

$db_name = "little sun";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

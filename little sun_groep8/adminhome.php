<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/adminhome.css">

</head>

<body>
    <header>
        <nav class="vertical-nav">
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>
            <ul>
                <li><a href="accounts.php">Admin</a></li>
                <li><a href="manager.php">Assign Tasks</a></li>
                <li><a href="location-add.php">Create Hub location</a></li>
                <li><a href="managers.php">Create Accounts</a></li>
                <li><a href="test.php">Locations</a></li>

                <li><a href="kalenderadmin.php">kalender</a></li>
            </ul>
            <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </header>

    <!-- Plaats hier de rest van je inhoud -->

    <script>
        // JavaScript om het menu te laten verschijnen/verdwijnen wanneer de checkbox wordt aangevinkt/uitgevinkt
        document.getElementById("menu-toggle").addEventListener("change", function () {
            var menu = document.querySelector('.menu');
            if (this.checked) {
                menu.classList.add('show');
            } else {
                menu.classList.remove('show');
            }
        });
    </script>
</body>

</html>
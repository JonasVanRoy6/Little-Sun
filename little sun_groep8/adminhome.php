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
                    <li><a href="admin.php">Create Hub location</a></li>
                    <li><a href="managers.php">Create Hub Managers</a></li>
                    <li><a href="test.php">test</a></li>
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
<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <header>

        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-toggle-label">&#9776;</label>
        <nav class="menu">
            <a href="accounts.php">Admin</a>
            <a href="logout.php">Logout</a>
            <a href="admin.php">Create Hub location</a>
            <a href="managers.php">Create Hub Managers</a>
            <a href="test.php">test</a>



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
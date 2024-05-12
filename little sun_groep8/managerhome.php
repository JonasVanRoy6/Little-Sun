<!DOCTYPE html>
<html>

<head>
    <title>Manager Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <header>
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="menu-toggle-label">&#9776;</label>
        <nav class="menu">
            <a href="manager.php">Manager</a>
            <a href="kalender.php">Kalender</a>
            <a href="logout.php">Logout</a>
            <a href="test.php">test</a>
        </nav>
    </header>

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

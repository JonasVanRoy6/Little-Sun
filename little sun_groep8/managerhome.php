<!DOCTYPE html>
<html>

<head>
    <title>Manager Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/managerhome.css">
</head>

<body>
    <nav class="vertical-nav">
        <div class="logo">
            <img src="images/logo.png" alt="Logo">
        </div>
        <ul>
            <li><a href="manager.php">Assign Task</a></li>
            <li><a href="kalender.php">Kalender</a></li>
            <li><a href="test.php">Locations</a></li>
        </ul>
        <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
    </nav>

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
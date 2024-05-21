<!DOCTYPE html>
<html>

<head>
    <title>Manager Home</title>
    <link rel="stylesheet" type="text/css" href="CSS/managerhome.css">
</head>

<body>
    <header>
        <section class="top-navigation">
            <div class="menu-toggle-label" onclick="toggleMenu()">&#9776;</div>
            <div class="logo">
                <img src="images/logo.png" alt="Logo">
            </div>
        </section>
        <nav class="menu">
            <a href="manager.php">Assign Task</a>
            <a href="kalender.php">Kalender</a>
            <a href="test.php">Locations</a>
            <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        </nav>
    </header>

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
        function toggleMenu() {
            var menu = document.querySelector('.menu');
            menu.classList.toggle('show');
        }
    </script>
</body>

</html>
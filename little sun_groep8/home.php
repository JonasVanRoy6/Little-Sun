<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

     ?>
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
                    <a href="home.php">Home</a>
                    <a href="accounts.php"><?php echo $_SESSION['name']; ?></a>
                    <a href="logout.php">Logout</a>



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


     <?php
} else {
     header("Location: index.php");
     exit();
}
?>
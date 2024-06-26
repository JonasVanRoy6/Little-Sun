<!DOCTYPE html>
<html>

<head>
     <title>SIGN UP</title>
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



          </nav>


     </header>


     <div class="signup">
          <form action="signup-check.php" method="post">
               <h2>Created</h2>
               <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
               <?php } ?>

               <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
               <?php } ?>

               <label>Name</label>
               <?php if (isset($_GET['name'])) { ?>
                    <input type="text" name="name" placeholder="Name" value="<?php echo $_GET['name']; ?>"><br>
               <?php } else { ?>
                    <input type="text" name="name" placeholder="Name"><br>
               <?php } ?>

               <label>User Name</label>
               <?php if (isset($_GET['uname'])) { ?>
                    <input type="text" name="uname" placeholder="User Name" value="<?php echo $_GET['uname']; ?>"><br>
               <?php } else { ?>
                    <input type="text" name="uname" placeholder="User Name"><br>
               <?php } ?>


               <label>Password</label>
               <input type="password" name="password" placeholder="Password"><br>

               <label>Re Password</label>
               <input type="password" name="re_password" placeholder="Re_Password"><br>

               <button type="submit">Sign Up</button>

          </form>
     </div>



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
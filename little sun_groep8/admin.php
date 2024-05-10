<?php


include_once ("adminhome.php");


?>

<!DOCTYPE html>
<html>

<head>
    <title>SIGN UP</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <div class="signup">
        <form action="location-add.php" method="post">
            <h2>Create Hub Location</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>

            <label>Location</label>
            <?php if (isset($_GET['name'])) { ?>
                <input type="text" name="name" placeholder="Location" value="<?php echo $_GET['name']; ?>"><br>
            <?php } else { ?>
                <input type="text" name="name" placeholder="Location"><br>
            <?php } ?>

            <label>User Name</label>
            <?php if (isset($_GET['uname'])) { ?>
                <input type="text" name="uname" placeholder="User Name" value="<?php echo $_GET['uname']; ?>"><br>
            <?php } else { ?>
                <input type="text" name="uname" placeholder="User Name"><br>
            <?php } ?>

            <div class="radio">
                <input type="radio" id="html" name="fav_language" value="Location">
                <p>Hub Locations</p>
                <input type="radio" id="css" name="fav_language" value="Manager">
                <p>Hub Managers</p>
            </div>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password"><br>

            <label>Re Password</label>
            <input type="password" name="re_password" placeholder="Re_Password"><br>

            <button type="submit">Add</button>

        </form>
    </div>
</body>



</html>
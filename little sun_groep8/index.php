<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="CSS/index.css">
	<div class="black-bar">
	<img src="images/logo.png" alt="Logo" class="logo">
	</div>
</head>

<body>
	<div class="signup">
		<form action="login.php" method="post">
			<h2>Login</h2>
			<?php if (isset($_GET['error'])) { ?>
				<p class="error"><?php echo $_GET['error']; ?></p>
			<?php } ?>
			<label>User Name</label>
			<input type="text" name="uname" placeholder="User Name"><br>

			<label>Password</label>
			<input type="password" name="password" placeholder="Password"><br>

			<button type="submit">Login</button>

		</form>
	</div>
</body>

</html>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>SIGN OUT</title>
	</head>
		<?php
			session_start();
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			session_destroy();

			header("Location: signin.php");
			exit;
		?>
	<body>
	</body>
</html>
<?php
	session_start();
?>
<!doctype html>

<html>
	<head>
	<meta charset="utf-8">
	<title>signin</title>
		<style>
			.container
			{
				margin: 150px 300px 150px 300px;
				background-color: #08596bff;
				color: white;
				border:  solid 3px;
				border-radius: 20px;
				padding-bottom: 50px;
			}
			.container h1
			{
				margin-top: 30px;
				text-align: center;
			}
			.container label
			{
				margin-left: 20px;
			}
			.container p
			{
				color: black;
				margin-top: 30px;
				text-align: center;

			}
			.container .sign{
				margin-top: 0px;

			}
			.container .sign a 
			{
				text-decoration: none;
				color: red;
			}
			.container .sign a:hover
			{
				text-decoration: underline;
			}
			
			.container .submit 
			{
				margin-top: 20px;
				text-align: center;
			}
			.container .error
			{
				color: red;
			}
			.form_error span 
			{
				width: 80%;
				height: 35px;
				margin: 3px 10%;
				font-size: 1.1em;
				color: #D83D5A;
			}
			input[type=text],[type=password]
			{
				margin-left: 20px;
				margin-bottom: 20px;
				border: 1px solid #CCCCCC;
				border-radius: 4px;
				padding: 15px;
				display: inline-block;
				width: 80%;
				margin-bottom: 20px;
			}
			input[type=submit]
			{
				color: white;
				background-color: #78979dff;
				padding: 14px 20px;
				border-radius: 4px;
				border: solid 0px #78979dff;
			}

			input[type=submit]:hover
			{
				background-color:  #566c71ff;
			}
			
		</style>
	</head>
	<?php
		$usernameErr = $passwordErr = "";
		$username_error = $password_error = "";
		$_SESSION["username"] = $_SESSION["password"] = "";
	
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			if(empty($_POST["username"]))
			{
				$usernameErr = "*username is required";
			}	
			else 
			{
				$_SESSION["username"] = $_POST["username"];
			}
			echo "usernameErr :" .$usernameErr."<br>";
			echo "[username] :".$_SESSION["username"]."<br>";
			if(empty($_POST["password"]))
			{
				$passwordErr = "*password is required";
			}	
			else 
			{
				$_SESSION["password"] = $_POST["password"];
			}
		}
		echo $_POST["password"];
		echo $usernameErr;
		echo $_SESSION["password"];
	
		if( $usernameErr != "*username is required" ) 
		{
				//Initial value
			$username = $_SESSION["username"];
			$password = $_SESSION["password"];
			$database = 'test';
			$table	  = 'signup';
			$conn = new MySQLi('localhost','root','wecandoit',$database);
				
			if($conn->connect_error)
				{
					die("Connection error:" .$conn->connect_error);
				}
				//Check username
				$sql_username = "SELECT username FROM $table WHERE username = '$username'";
				$result_username = $conn->query($sql_username);
			
				//Check password
				$sql_password = "SELECT password FROM $table WHERE password = '$password'";
				$result_password = $conn->query($sql_password);
			
				//
				if($result_username->num_rows > 0)
				{
					$username_error = "Invalid username";
				}
			
				else
				{
					$username_error = "true";
				}
			
				if($result_password->num_rows > 0)
				{
					$password_error = "Invalid password";
				}
			
				else
				{
					$password_error = "true";
				}

				if($username_error = "true" and $password_error = "true"){
					header("Location : index.php");
					die();
				}
			}
		echo $username_error;
	?>
	<body>

		<div class="container">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<h1>SIGH IN</h1>
				<label> USERNAME </label>
				<span class="error"><?php echo $usernameErr;?></span>
				<div <?php if (isset($username_error)): ?> class="form_error" <?php endif ?> >
				<br/>
				<input type="text" name="username"><br/>
				<label> PASSWORD </label>
				<span class="error"><?php echo $passwordErr;?></span>
					
				<div <?php if (isset($password_error)): ?> class="form_error" <?php endif ?> >
				<br/>
				<input type="password" name="password"><br/>
				<div class="submit">
					<input type="submit" value="SING IN">
				</div>
			</form>
				<p>If you don't have any account. </p>
				<p class="sign">please  <a href="signup2.php"> sign up here.</a></p>
		</div>
	</body>
</html>
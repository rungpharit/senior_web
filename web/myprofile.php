<?php

	#$username = $_SESSION["username"];
	$username 	= "may";
	$database 	= "test2";
	$table 		= "signup_doctor";
	$conn 		= new MySQLi('localhost','root','',$database);

	if($conn->connect_error)
	{
		die("Connection error:" .$conn->connect_error);
	}
	$result 			= $conn->query("SELECT * FROM $table WHERE username =  '$username'  ");
	$firstname 			= "";
	$lastname 			= "";
	$username_doctor 	= "";
	$password 			= "";
	$email 				= "";

	if ($result-> num_rows >0)
	{
		while($row = $result->fetch_array())
		{			
			$firstname 			= $row['firstname'];
			$lastname 			= $row['lastname'];
			$username_doctor 	= $row['username'];
			$password 			= $row['password'];
			$email 				= $row['email'];
						
		}
				
	}
	else 
	{
		echo "There are no images";
	}	
	

?>
<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>UV MONITORING SYSTEM</</title>
	<nav>
		<?php include('header.php'); ?>
	</nav>
	<link rel="stylesheet" type="text/css" href="css/myprofile.css" >
	</head>
		
		<div id="myprofile">
			<p class="profile">MY PROFILE</p>
			<form action="#" method="post">
				<!-- recieve info from user-->
				<input type="text" 		name="firstname" 	value="<?php echo $firstname ?>"><br>
				<input type="text" 		name="lastname" 	value="<?php echo $lastname ?>"><br>
				<input type="text" 		name="username" 	value="<?php echo $username_doctor?>"><br>
				<input type="email" 	name="email" 		value="<?php echo $email ?>"><br>
				<input type="submit" 	name="save" 		value="SAVE">
			</form>
		</div>
	<body>
	</body>
</html>
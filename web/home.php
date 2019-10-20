<?php
	//Check id
	if(!empty($_POST['id'])){

	$id 		= $_POST['id'];
	$database 	= "test2";
	$table 		= "signup_user";
	$conn 		= new MySQLi('localhost','root','',$database);

	if($conn->connect_error)
	{
		die("Connection error:" .$conn->connect_error);
	}
		$result 	= $conn->query("SELECT * FROM $table WHERE id = $id ");
		$name 		= '';
		$username 	= '';

		if ($result-> num_rows >0)
		{
				while($row = $result->fetch_array())
				{
					$name	   	= 	$row['name'] ;
					$username   = 	$row['username'] ;
				}			
			}
			else 
			{
				echo "There are no id";
			}		
		}
	//Check username
	if(!empty($username))
	{
		$database 	= "test2";
		$table 		= $username.'_'.'data';
		$from 		= $_POST['from'];
		$to 		= $_POST['to'];
		
		//Check before date
		if($from == 'first'  )
		{
			$conn = new MySQLi('localhost','root','',$database);
			if($conn->connect_error)
			{
				die("Connection error:" .$conn->connect_error);
			}

				$result = $conn->query("SELECT date  FROM $table WHERE count = 1");	

				if ($result-> num_rows >0)
				{
						while($row = $result->fetch_array())
						{
							$from = $row['date'];
						}

				}
				else 
					{
					echo "There are no date";
					}	
		}
		//Check  date
		if($to == 'last'  )
		{
			$conn = new MySQLi('localhost','root','',$database);
			if($conn->connect_error)
			{
				die("Connection error:" .$conn->connect_error);
			}
				$result = $conn->query("SELECT date  FROM $table ");

				if ($result-> num_rows >0)
				{
						while($row = $result->fetch_array())
						{
							$to = $row['date'];
						}

				}
				else 
					{
					echo "There are no date";
					}	
		}
		
		
		$conn = new MySQLi('localhost','root','',$database);
		if($conn->connect_error)
		{
			die("Connection error:" .$conn->connect_error);
		}

		$result 	= $conn->query("SELECT * FROM $table WHERE date BETWEEN '$from' AND  '$to'  ");
		$date 		= [];
		$intensity 	= [];
		$cumulative = [];
		if ($result-> num_rows >0)
		{
				while($row = $result->fetch_array())
				{
					$date []		= $row['date'];
					$intensity[] 	= $row['intensity'];
					$cumulative[] 	= $row['cumulative'];	
				}

		}
		else 
		{
			echo "There are no username";
		}

	}

?>

<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>UV MONITORING SYSTEM</title>	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	
	<link rel="stylesheet" style="text/css" href="css/home.css">

		<nav>
			<!--Navigation bar -->
			<?php include('header.php');?>
		</nav>

	</head>
   
	<body>

		<div class="form">
			<form action="home.php" method="post">
				<label>ID    :</label>
				<input type="text" name="id" placeholder=" ID's patience"></br>
				<label>FROM :</label>
				<input type="text" name="from" placeholder=" fisrt or YYYY/MM/DD"></br>
				<label>TO :</label>
				<input type="text" name="to" placeholder=" last or YYYY/MM/DD">
				<input type="submit" value="SEARCH">
			</form>

		</div>

		<div class="container_chart">

			<h1>
				<?php
				if(!empty($name))
					{
					echo $name;
					}
				?>
			</h1>	

			<div id="container_intensity">
				<!-- UV Intensity -->
				<?php include('intensity.php');  ?>
			</div>

			<div id="container_cumulative">
				<!-- UV Cumulative -->
				 <?php include('cumulative.php'); ?>
			</div>

		</div>

	</body>
</html>
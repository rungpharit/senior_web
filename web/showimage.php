<?php

	if(!empty($_POST['id']))
	{
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
			echo $id;
			echo "There are no id";
		}	
	}

	if(!empty($username))
	{
		$database 	= "test2";
		$table 		= $username . "_" . "images";
		$from 		= $_POST['from'];
		$to 		= $_POST['to'];

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
				echo "There are no date1";
			}	
		}
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
				}else 
				{
					echo "There are no date2";
				}	
			}

			$conn = new MySQLi('localhost','root','',$database);
		
			if($conn->connect_error)
			{
			die("Connection error:" .$conn->connect_error);
			}
		
			$result 	= $conn->query("SELECT * FROM $table WHERE date BETWEEN '$from' AND '$to'  ");
			$date 		= [];
			$imagename 	= [];

			if ($result-> num_rows >0)
			{
				while($row = $result->fetch_array())
				{
					$date []	= $row['date'];
					$imagename[]=  $row['imagename'];
				}

			}
			else 
			{
				echo "There are no images";
			}	
	}

?>

<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>UV MONITORING SYSTEM</</title>
		<link rel="stylesheet" type="text/css" href="css/showimage.css" >
		
			<nav>
				<?php include('header.php');?>
			</nav>

	</head>

	<body>
		<div class="form">
			<form action="showimage.php" method="post">
				<label>ID :</label>
				<input type="text" name="id" >
				<label>FROM :</label>
				<input type="text" name="from" placeholder=" fisrt or YYYY/MM/DD">
				<label>TO :</label>
				<input type="text" name="to" placeholder=" last or YYYY/MM/DD">
				<input type="submit" value="SEARCH">
			</form>
		</div>

		<div id = "container"></div>
			<script type = "text/javascript">
				//convert array php to array js
				var ima  = JSON.parse('<?php echo json_encode($imagename); ?>');
				var date = JSON.parse('<?php echo json_encode($date); ?>');
				var c = 0;
			
			//Check date
			for(i=0;i<=date.length -1 ; i++)
			{
				for(j=0 ; j<= date.length -1 ; j++)
				{
					//Check date at index 0
					if(date[i]==date[j] && i== 0 && j== 0 )
					{
						var contain 	= document.getElementById("container");
						var div 		= document.createElement("div");
						var p			= document.createElement("p");
						var p_img		= document.createElement("p");
						var d 			= document.createTextNode(date[i]);
						var img			= document.createElement("img");
						var src			= document.createAttribute("src");
						var link 		= "img/patient/"

						div.className = 'image';
						contain.appendChild(div); //Create div in contain

						var image	= document.getElementsByClassName("image")[c]; //macy add

						p.appendChild(d);
						image.appendChild(p);
						src.value = link + ima[i]
						img.setAttributeNode(src);
						image.appendChild(img);
						contain.appendChild(image);

					}

					if(date[i] == date[j] && i == j && i != 0 && j !=0)
					{
						//if previous day is the same as current day
						if(date[i-1] == date[j])
						{

							var img		= document.createElement("img");
							var src		= document.createAttribute("src");
							var link 	= "img/patient/"
							var image	= document.getElementsByClassName("image")[c]; //macy add

							src.value 	= link + ima[i]
							img.setAttributeNode(src);
							image.appendChild(img);
							contain.appendChild(image);
						}
						// if previous day is not the same as current day
						if(date[i-1] != date[j])
						{
							c = c + 1;	
							var contain = document.getElementById("container");
							var div 	= document.createElement("div");
							var p		= document.createElement("p");
							var d 		= document.createTextNode(date[i]);
							var img		= document.createElement("img");
							var src		= document.createAttribute("src");
							var link 	= "img/patient/"

							div.className = 'image';
							contain.appendChild(div); //Create div in contain

							var image	= document.getElementsByClassName("image")[c]; //macy add
							p.appendChild(d);
							image.appendChild(p);
							src.value 	= link + ima[i]
							img.setAttributeNode(src);
							image.appendChild(img);
							contain.appendChild(image);

						}
					}

				}
			}
			</script>
		</div>
	</body>
</html>

<?php

	if(!empty($_POST['id']))
	{
		$id = $_POST['id'];
		$database = "test2";
		$table = "signup_user";
		$conn = new MySQLi('localhost','root','',$database);
		
		if($conn->connect_error)
		{
			die("Connection error:" .$conn->connect_error);
		}
		$result = $conn->query("SELECT * FROM $table WHERE id = $id ");
		$name = '';
		$username = '';
		if ($result-> num_rows >0)
		{
			while($row = $result->fetch_array())
			{
				$name	    = 	$row['name'] ;
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
		$database = "test2";
		$table = $username . "_" . "specific_symptom";
		$from = $_POST['from'];
		$to = $_POST['to'];

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

				}
			else 
			{
				echo "There are no date2";
			}	
		}

		$conn = new MySQLi('localhost','root','',$database);
		if($conn->connect_error)
		{
			die("Connection error:" .$conn->connect_error);
		}
		$result = $conn->query("SELECT * FROM $table WHERE date BETWEEN '$from' AND '$to'  ");
		$date = [];
		$symptom = [];

		if ($result-> num_rows >0)
		{
			while($row = $result->fetch_array())
			{
				$date []	= $row['date'];
				$symptom[]	=  $row['symptom'];
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
	<title>UV MONITORING SYSTEM</title>
	<link rel="stylesheet" style="text/css" href="css/symptom.css">
		
		<nav>
			<?php include('header.php');?>
		</nav>
		
	</head>

	<body>
		<div class="form">
			<form action="specific.php" method="post">
				<label>ID :</label>
				<input type="text" name="id" placeholder=" ID's patience" ></br>
				<label>FROM :</label>
				<input type="text" name="from" placeholder=" fisrt or YYYY/MM/DD"></br>
				<label>TO :</label>
				<input type="text" name="to" placeholder=" last or YYYY/MM/DD">
				<input type="submit" value="SEARCH">
			</form>
		</div>

		<div id="container">


		</div>

		<script type="text/javascript">
			var symptom = JSON.parse('<?php echo json_encode($symptom); ?>');
			var	datee	=  JSON.parse('<?php echo json_encode($date); ?>');
			var c = 0; //macy add

			for(i=0;i<=datee.length -1 ; i++)
			{
				for(j=0 ; j<= datee.length -1 ; j++)
				{
					if(datee[i]==datee[j] && i== 0 && j== 0 )
					{
						var contain = document.getElementById("container");
						var div 	= document.createElement("div");
						var p		= document.createElement("p");
						var d 		= document.createTextNode(datee[i]);
						var sympt 	= symptom[i].split(",");

						p.appendChild(d);
						div.appendChild(p);
						contain.appendChild(div);
						div.className = "symp";

						for(var y = 0; y <= sympt.length -1 ; y++)
						{
							var contain = document.getElementById("container");
							//var symp	= document.getElementsByClassName("symp")[i];
							var symp	= document.getElementsByClassName("symp")[c]; //macy add
							var ul		= document.createElement("UL");
							var li		= document.createElement("LI");
							var t 		= document.createTextNode(sympt[y]);


							li.appendChild(t);
							ul.appendChild(li);
							symp.appendChild(ul);
							contain.appendChild(symp);
						}
					}

					if(datee[i] == datee[j] && i == j && i != 0 && j !=0)
					{
						if(datee[i-1] == datee[j])
						{
							var sympt = symptom[j].split(",");
							for(var y = 0; y <= sympt.length -1 ; y++)
							{
								var contain = document.getElementById("container");
								//var symp	= document.getElementsByClassName("symp")[i-1];
								var symp	= document.getElementsByClassName("symp")[c]; //macyadd
								var ull		= document.createElement("UL");
								var lii		= document.createElement("LI");
								var t 		= document.createTextNode(sympt[y]);
								console.log(j);

								lii.appendChild(t);
								ull.appendChild(lii);
								symp.appendChild(ull);
								contain.appendChild(symp);
							}
						}

						if(datee[i-1] != datee[j])
						{
							var sympt 	= symptom[j].split(",");
							var contain = document.getElementById("container");
							var div 	= document.createElement("div");
							var p		= document.createElement("p");
							var d 		= document.createTextNode(datee[i]);
							
							p.appendChild(d);
							div.appendChild(p);
							contain.appendChild(div);
							div.className = "symp";
							c = c+1; //macy add

							for(var y = 0; y <= sympt.length -1 ; y++)
							{
								var contain 	= document.getElementById("container");
								//var symp		= document.getElementsByClassName("symp")[i-1];
								var symp		= document.getElementsByClassName("symp")[c]; //macy add
								var ul			= document.createElement("UL");
								var li			= document.createElement("LI");
								var t 			= document.createTextNode(sympt[y]);

								li.appendChild(t);
								ul.appendChild(li);
								symp.appendChild(ul);
								contain.appendChild(symp);
							}
						}
					}
				}
			}
		</script>
	</body>
</html>

			
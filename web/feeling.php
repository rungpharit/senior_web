<?php
	//Check id
	if(!empty($_POST['id']))
	{
		$id 		= $_POST['id'];
		$database 	= "test2";
		$table 		= "signup_user";
		$conn 		= new MySQLi('localhost','root','',$database);
		if($conn->connect_error){
			die("Connection error:" .$conn->connect_error);
		}
			$result 	= $conn->query("SELECT * FROM $table WHERE id = $id ");
			$name 		= '';
			$username 	= '';
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
				echo "There are no id";
			}	

	}
	//Check username
	if(!empty($username))
	{
		$database = "test2";
		$table = $username . "_" . "feeling";
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
			// Set value
			$database 	= "test2";
			$table 		= $username . "_" . "feeling";
			$conn 		= new MySQLi('localhost','root','',$database);
			
			if($conn->connect_error)
			{
			die("Connection error:" .$conn->connect_error);
			}	

			$result = $conn->query(" SELECT * FROM $table WHERE date BETWEEN '$from' AND '$to'  ");

			$datee 		= [];
			$symptom 	= [];
			$timee  	= [];
			$informtext	= [];
			$level		= [];
			if ($result-> num_rows >0)
			{
				while($row = $result->fetch_array())
				{
					$datee []		= $row['date'];
					$timee [] 		= $row['timee'];
					$informtext[] 	= $row['informtext'];
					$symptom[]		=  $row['symp'];
					$level[] 		= $row['level'];
				}

			}
			else 
			{
				echo "There are no images77";
			}	

		}
?>

<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>UV MONITORING SYSTEM</title>
	
	<link rel="stylesheet" style="text/css" href="css/feeling.css">

	<nav>
		<?php include('header.php');?>
	</nav>
		
	</head>
	<body>

		<div class="form">
			<form action="feeling.php" method="post">
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
			
			var	datee	=  JSON.parse('<?php echo json_encode($datee); ?>');
			var	timee	=  JSON.parse('<?php echo json_encode($timee); ?>');
			var inform	=  JSON.parse('<?php echo json_encode($informtext); ?>');	
			var	symp	=  JSON.parse('<?php echo json_encode($symptom); ?>');
			var	level	=  JSON.parse('<?php echo json_encode($level); ?>');
			var head 	= ["TIME","FEELING","DETAIL","LEVEL"];  
			var c 		= 0; //macy add

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

						p.appendChild(d);
						div.appendChild(p);
						contain.appendChild(div);
						div.className = "feeling";

						var table 			= document.createElement("table");
						var tr_head			= document.createElement("tr");
						tr_head.className 	= "title"
						table.className 	= "feel";
						contain.appendChild(table);//You have to do this before using getElementsByClassName("feel")

						for( var x = 0 ; x <=1 ; x++)
						{								
							if(x==0)
							{
								for(var y = 0 ; y <= head.length - 1 ; y++)
								{
									var contain 	= document.getElementById("container");	
									var feeling		= document.getElementsByClassName("feeling")[c]; //macy add
									var feel		= document.getElementsByClassName("feel")[c];
									var	th			= document.createElement("th");	
									var h			= document.createTextNode(head[y]);

									th.appendChild(h);										
									tr_head.appendChild(th);
									feel.appendChild(tr_head);
									feeling.appendChild(feel);
									contain.appendChild(feeling);

								}

							}
							else
							{
								var contain 		= document.getElementById("container");	
								var feeling			= document.getElementsByClassName("feeling")[c]; //macy add
								var feel			= document.getElementsByClassName("feel")[c];
								var tr_text			= document.createElement("tr");
								var td_t			= document.createElement("td");
								var td_n			= document.createElement("td");
								var td_f			= document.createElement("td");
								var td_r			= document.createElement("td");
								var t		 		= document.createTextNode(timee[0]);
								var	f				= document.createTextNode(symp[0]);
								var	n				= document.createTextNode(inform[0]);
								var r				= document.createTextNode(level[0]);
								
								tr_text.className 	= "info";
								
								var info			= document.getElementsByClassName("info")[c];

								td_t.appendChild(t);
								td_f.appendChild(f);
								td_n.appendChild(n);
								td_r.appendChild(r);
								tr_text.appendChild(td_t);
								tr_text.appendChild(td_f);
								tr_text.appendChild(td_n);
								tr_text.appendChild(td_r);
								feel.appendChild(tr_text);
								feeling.appendChild(feel);
								contain.appendChild(feeling);

							}
						}
					}
					
					if(datee[i] == datee[j] && i == j && i != 0 && j !=0)
					{
						
						if(datee[i-1] == datee[j])
						{
							var contain 		= document.getElementById("container");	
							var feeling			= document.getElementsByClassName("feeling")[c]; //macy add
							var feel			= document.getElementsByClassName("feel")[c];
							var tr_text			= document.createElement("tr");
							var td_t			= document.createElement("td");
							var td_n			= document.createElement("td");
							var td_f			= document.createElement("td");
							var td_r			= document.createElement("td");
							var t		 		= document.createTextNode(timee[j]);
							var n				= document.createTextNode(inform[j]);
							var	f				= document.createTextNode(symp[j]);
							var r				= document.createTextNode(level[j]);

							td_t.appendChild(t);
							td_f.appendChild(f);
							td_n.appendChild(n);
							td_r.appendChild(r);
							tr_text.appendChild(td_t);			
							tr_text.appendChild(td_f);
							tr_text.appendChild(td_n);
							tr_text.appendChild(td_r);
							feel.appendChild(tr_text);
							feeling.appendChild(feel);
							contain.appendChild(feeling);

						}
						
						if(datee[i-1] != datee[j])
						{
							c = c+1;
							var contain 	= document.getElementById("container");
							var div 		= document.createElement("div");
							var p			= document.createElement("p");
							var d 			= document.createTextNode(datee[i]);

							p.appendChild(d);
							div.appendChild(p);
							contain.appendChild(div);
							div.className = "feeling";

							var table 			= document.createElement("table");
							var tr_head			= document.createElement("tr");
							tr_head.className 	= "title";
							table.className 	= "feel";
							contain.appendChild(table);//You have to do this before using getElementsByClassName("feel")

							for(var y = 0 ; y <= head.length - 1 ; y++)
							{
								var contain 	= document.getElementById("container");	
								var feeling		= document.getElementsByClassName("feeling")[c]; //macy add
								var feel		= document.getElementsByClassName("feel")[c];
								var	th			= document.createElement("th");	
								var h			= document.createTextNode(head[y]);

								th.appendChild(h);										
								tr_head.appendChild(th);
								feel.appendChild(tr_head);
								feeling.appendChild(feel);
								contain.appendChild(feeling);
							}
								var contain 		= document.getElementById("container");	
								var feeling			= document.getElementsByClassName("feeling")[c]; //macy add
								var feel			= document.getElementsByClassName("feel")[c];
								var tr_text			= document.createElement("tr");
								var td_t			= document.createElement("td");
								var td_n			= document.createElement("td");
								var td_f			= document.createElement("td");
								var td_r			= document.createElement("td");
								var t		 		= document.createTextNode(timee[j]);
								var	n				= document.createTextNode(inform[j]);
								var	f				= document.createTextNode(symp[j]);
								var r				= document.createTextNode(level[j]);
								tr_text.className 	= "info";
								var info			= document.getElementsByClassName("info")[c];

								td_t.appendChild(t);
								td_f.appendChild(f);
								td_n.appendChild(n);
								td_r.appendChild(r);
								tr_text.appendChild(td_t);
								tr_text.appendChild(td_f);
								tr_text.appendChild(td_n);
								tr_text.appendChild(td_r);
								feel.appendChild(tr_text);
								feeling.appendChild(feel);
								contain.appendChild(feeling);

						}

					}

				}
			}
		</script>
	</body>
</html>

			
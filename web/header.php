<!doctype html>
<html>
<head>
<meta charset="utf-8">
	
	<link rel="stylesheet" style="text/css" href="css/header.css">
	
</head>

<body>
	<div id="head">
		
		<div class="navigation">
			
			<div class="logo"> <a href ="index.php"><img src="img/logo/RAMA.png"></a></div>
			<ul>
				<!-- Navigation Bar -->
				<li><a href="home.php">HOME</a></li>
				<li><a href="feeling.php">FEELING</a></li>
				<li><a href="symptom.php">SYMPTOM</a></li>
				<li><a href="myprofile.php">MY PROFILE</a></li>
				<li><a href="signout.php">SIGN OUT</a></li>
			</ul>
		</div>
		
		<div class="date-patient">
			<p id="date"></p>
		</div>
		
	</div>
	
		<script type="text/javascript">
			//create date
			var d = new Date(); 
			document.getElementById("date").innerHTML = d.toDateString();
		</script>
		
</body>
</html>
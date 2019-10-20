

<!doctype html>
<html>
	
	<head>
		<meta charset="utf-8">
		<title>UV MONITORING SYSTEM</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
	</head>

	<body>
		<div class="container_intensity">
			<canvas id="intensity"></canvas>
		</div>

		<script id="test">
			//Converts array php to array js
			var inten 	= JSON.parse('<?php echo json_encode($intensity); ?>');
			var datee 	= JSON.parse('<?php echo json_encode($date); ?>');
			var intens 	= [];
			var dates 	= [];
			var x = 0;
			var y = 0;
			for (i = 0 ; i < inten.length ; i=i+1)
			{ 
				//Converts every 1 second intensity to every 20 second intensity
				console.log(i);
				intens[x] = inten[i];
				x=x+1;

			}
			for (i = 0 ; i < datee.length ; i=i+1)
			{ 
				//Converts every 1 second date to every 20 second date
				console.log(i);
				dates[y] = datee[i];
				y=y+1;

			}
			console.log(intens);
			console.log(dates);
			let intensity = document.getElementById('intensity').getContext('2d'); 

			//Global Options
			Chart.defaults.global.defaultFontFamily = 'Lato';
			Chart.defaults.global.defaultFontFamily = 18;
			Chart.defaults.global.defaultFontColor = '#777';

			intensity.canvas.parentNode.style.height='400px';
			intensity.canvas.parentNode.style.width='500px';

			let test = new Chart(intensity,{
				type:'line', //bar,horizontal,pie,line
				data:{
					labels:dates,
					datasets:[{
						label:"Intensity",
						data:
							intens
						,
						//backgroundColor:'green'
						backgroundColor:[
							'rgba(255,99,132,0.6)',

						],
						borderWidth:1,
						borderColor:'#777',
						hoverBorderWidth:3,
						HoverBorderColor:'#000',
						fill:false
					}]
				},
				options:{
					resposive:true,
					maintainAspectRatio:false,

					title:{
						display:true,
						text:'INTENSITY GRAPH ',
						fontSize:25
					},

					legend:{
						display:false, //hide legend
						position:'right',
						labels:{
							fontColor:'#000'
						}
					},

					tooltips:{
						enabled:true //label when mouse over chart
					}

				}
			});

		</script>
	</body>
</html>
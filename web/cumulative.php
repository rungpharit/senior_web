
<!doctype html>
<html>
	<head>
		
	<meta charset="utf-8">
	<title>cumulative</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

	</head>

	<body>

		<div class="container_cumulative">
			<canvas id="myChart"></canvas>
		</div>

		<script id="test">
			//Converts array php to array js
			var cumu 	= JSON.parse('<?php echo json_encode($cumulative); ?>');
			var datee 	= JSON.parse('<?php echo json_encode($date); ?>');
			var cumula 	= [];
			var dates 	= [];
			var x = 0;
			var y = 0;

			for (i = 0 ; i < cumu.length ; i=i+1)
			{ 
				//Converts every 1 second cumulative to every 20 second cumulative
				cumula[x] = cumu[i];
				x=x+1;
			}
			for (i = 0 ; i < datee.length ; i=i+1)
			{	
				//Converts every 1 second date to every 20 second date
				console.log(i);
				dates[y] = datee[i];
				y=y+1;

			}
			let myChart = document.getElementById('myChart').getContext('2d'); 

				//Global Options
				Chart.defaults.global.defaultFontFamily = 'Lato';
				Chart.defaults.global.defaultFontFamily = 18;
				Chart.defaults.global.defaultFontColor = '#777';

				myChart.canvas.parentNode.style.height='400px';
				myChart.canvas.parentNode.style.width='500px';

			let massPopChart = new Chart(myChart,{
				type:'line', //bar,horizontal,pie,line
				data:{
					labels:dates,
					datasets:[{
						label:"Cumulative",
						data: cumula	
						,
						//backgroundColor:'green'
						backgroundColor:[

							'rgba(54,162,235,0.6)',

						],
						borderWidth:1,
						borderColor:'#777',
						hoverBorderWidth:3,
						HoverBorderColor:'#000',

					}]
				},
				options:{
					resposive:true,
					maintainAspectRatio:false,

					title:{
						display:true,
						text:'CUMULATIVE GRAPH ',
						fontSize:25
					},

					legend:{
						display:false , //hide legend
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
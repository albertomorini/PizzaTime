<?php
session_start();
if(empty($_SESSION["upiz"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE HTML>
<html lang="it">
<head>
	<?php 

	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$buffer=$_SESSION["upiz"];

	$q = "SELECT `nome`,`bought` FROM `pizze` WHERE IDpiz= '$buffer' ORDER BY bought DESC;";
	$result = $conn->query($q);


	echo '
	<script>
//Uscita
	function esci(){
		var r = confirm("Sei sicuro di voler uscire?");

		if (r == true) {

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					    //nothing, esce	
				}
			};
			
			xmlhttp.open("GET", "../uscita.php?r=" + r, false);
			xmlhttp.send();
			location.reload();
		}		
	}

	window.onload = function () {

		var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,

			exportEnabled: true,
			backgroundColor: "#EDEDED",
			
			title:{
				text: "Le 10 pizze più prenotate"
			},	
			axisY: {
				title: "Ordinazioni",
				titleFontColor: "#3a7aad",
				lineColor: "#3a7aad",
				labelFontColor: "#2b699b",
				tickColor: "#2b699b"
			},
			toolTip: {
				shared: true
			},
			data: [{
				type: "column",
				name: "Pizza",
				color: "#2B2B2B",
				dataPoints:[
					';
					
					if ($result->num_rows > 0) {
						$count=0;
						while($row = $result->fetch_array()){
							if($row["bought"]!=NULL && $count<10){
								echo "{ label: ";
								echo '"'.$row["nome"].'"'.",y: $row[bought] },";
								$count++;
							}

						}
					}
					$conn->close();


					echo ']
				}]
			});
			chart.render();



		}

		</script>
		';

		?>



		<title>Grafico pizzeria</title>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>



		<link href="../css/ordini.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-dark justify-content-between" id="titolo">

			<a class="navbar-brand" href="orders.php">Ordini della pizzeria</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="orario.php">Orario pizzeria</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="graph.php" style="color: #2b699b">Grafico pizzeria</a>
					</li>
					<li> <div class="dropdown-divider"></div></li>
					<li class="nav-item dropdown" >
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Account
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="pizzeria.php">La sua pizzeria</a>
							<a class="dropdown-item" onclick="esci();">Esci</a>
						</div>
					</li>

				</ul>
			</div>
		</nav>
		<br>
		<br>
		<div id="chartContainer" style="height: 400px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


		<?php 


		$conn = new mysqli("localhost","root","","my_buffersito");

		if ($conn->connect_error){
			die("nr-".$conn->connect_errno." - ". $conn->connect_error);
		}
		$buffer=$_SESSION["upiz"];

		$q = "SELECT COUNT($buffer) FROM ordini";
		$result = $conn->query($q);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			echo "<h3>Totale di ordini pari: ".$row[0]."</h3>";

		}
		$q = "SELECT SUM(prezzoTot) FROM ordini WHERE IDpiz='$buffer'";
		$result = $conn->query($q);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			echo "<h3>Fatturato totale: €".$row[0]."</h3>";

		}



		?>



	</body>

	</html>
<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["psw"])) {
	header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
	<title>Pizza's Time</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">

	
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<style>
	
	body{

		background-color: #fff;

		font-family: 'Open Sans', sans-serif;
		
		position: relative;

		margin: 0;		
	}
	#titolo{
		background-color: #2b2b2b;
		margin-bottom: 50px;
	}

	.pizzeria{
		padding: 6px 7px 0px 16px;
		background-color: #EDEDED;

		border-radius: 9px;
		font-size: 17px;
		margin-bottom: 30px;

	}
	.pizzeria h3{
		text-decoration: underline;
	}
	a:link{
		color: #2b2b2b;
	}
	a:visited{
		color:  #2b2b2b;
	}
	a:hover{
		color: #474040;
	}
	@media screen and (max-width: 600px){

		#titolo{

			margin-bottom: 10px;
		}
		
	}

	h3{

		font-size: 28px;
		font-weight: bold;
		line-height: 34px;
		font-weight: bold;
	}
</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark justify-content-between" id="titolo">
		
		<a class="navbar-brand" href="main.php" style="color: #2b699b">Lista pizzerie</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="maps.php">Mappa pizzerie</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="selfOrder.php">I tuoi ordini</a>
				</li>
				<li><div class="dropdown-divider"></div></li>
				<li class="nav-item dropdown" >
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Account
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="account.php">Il tuo profilo</a>
						<a class="dropdown-item" onclick="esci();">Esci</a>
					</div>
				</li>

			</ul>
		</div>
	</nav>
	
	<br>
	<script>
		
		function esci(){
			var r = confirm("Sei sicuro di voler uscire?");
			
			if (r == true) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						
					}
				};
				
				xmlhttp.open("GET", "../uscita.php?r=" + r, false);
				xmlhttp.send();
				location.reload();
			}		
		}
		
	</script>


	<div class="container">
		<div class="row">

			<?php

			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);
			}
			$conn->select_db("my_buffersito") or die("die");

			$q = "SELECT * FROM `pizzerie` ;";


			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {

					echo'
					<div class="col-sm-4">
					<nav class="pizzeria">
					

					<h3><a href="base.php?pizzeria=';
					echo $row["IDpiz"];
					echo '
					"> ';
					echo $row["nome"];
					echo '</a></h3>
					<p><strong>In via: </strong>';
					echo $row["via"]."  ".$row["numCivico"]." (".$row["CAP"].")";
					echo '</p>
					<p>Numero di telefono: ';
					echo $row["telefono"];
					echo '</p>

					</nav>
					</div>
					';
				}
			}
			$conn->close();


			?>
		</div>
	</div>
</body>
</html>
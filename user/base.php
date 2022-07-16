<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["psw"])) {
	header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
	<title>Ordina la tua pizza</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="../css/base.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

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



	<div  class="col-sm-12" id="main">

		<?php

		$idpizzeria= $_GET["pizzeria"];


		$conn = new mysqli("localhost","root","","my_buffersito");

		if ($conn->connect_error){
			die("nr-".$conn->connect_errno." - ". $conn->connect_error);
		}
		$conn->select_db("my_buffersito") or die("die");

		$q = "SELECT * FROM `pizzerie` WHERE IDpiz= '$idpizzeria';";


		$result = $conn->query($q);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();

			//INFO BASE
			echo"
			<h1>$row[nome]</h1>
			<br>
			<div class='row'>
			<div class='col-sm-8'>
			<h3>Informazioni:</h3>
			<p><strong>In via:</strong> $row[via]    $row[numCivico] ($row[CAP])</p>
			<p><strong>Telefono:</strong> $row[telefono]</p>
			</div>

			<div class='col-sm-4' id='contdrop'>
			<div class='dropdown'>

			<button type='button' class='btn btn-dark dropdown-toggle' data-toggle='dropdown' id='dropper'>Orari</button>

			<div class='dropdown-menu pull-left'>

			<ul class='nav nav-tabs'>

			<li class='nav-item'>
			<a class='nav-link active' onclick='showPranzo()' id='lblPranzo'><strong>Pranzo</strong></a>
			</li>
			<li class='nav-item'>
			<a class='nav-link ' onclick='showCena()' id='lblCena'><strong>Cena</strong></a>
			</li>
			</ul>


			";
			//ORARI PRANZO
			$q = "SELECT * FROM orari WHERE IDpiz= '$idpizzeria' AND orario= 'pr' ;";

			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){

					echo "
					<div id='pranzo'>
					<table class='table'>
					<thead class='intTabella'>
					<tr>
					<th>Lunedì</th>
					<th>Martedì</th>
					<th>Mercoledì</th>
					<th>Giovedì</th>

					</tr>
					</thead>
					<tbody>
					<tr>
					<td>$row[monday]</td>
					<td>$row[tuesday]</td>
					<td>$row[wednesday]</td>
					<td>$row[thursday]</td>
					</tr>
					</tbody>
					</table>

					<table class='table' >

					<thead class='intTabella'>
					<tr>
					<th>Venerdì</th>
					<th>Sabato</th>
					<th>Domenica</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td>$row[friday]</td>
					<td>$row[saturday]</td>
					<td>$row[sunday]</td>

					</tr>

					</tbody>
					</table>
					</div>

					";
				}
			}
			//ORARI CENA
			$q = "SELECT * FROM orari WHERE IDpiz= '$idpizzeria' AND orario= 'cn' ;";

			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){

					echo "
					<div id='cena'>
					<table class='table'>
					<thead class='intTabella'>
					<tr>
					<th>Lunedì</th>
					<th>Martedì</th>
					<th>Mercoledì</th>
					<th>Giovedì</th>

					</tr>
					</thead>
					<tbody>
					<tr>
					<td>$row[monday]</td>
					<td>$row[tuesday]</td>
					<td>$row[wednesday]</td>
					<td>$row[thursday]</td>
					</tr>
					</tbody>
					</table>

					<table class='table' >

					<thead class='intTabella'>
					<tr>
					<th>Venerdì</th>
					<th>Sabato</th>
					<th>Domenica</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td>$row[friday]</td>
					<td>$row[saturday]</td>
					<td>$row[sunday]</td>

					</tr>

					</tbody>
					</table>
					</div>

					";
				}
			}

			echo "

			</div>

			</div>
			</div>

			";
		}

		$conn->close();
		?>
	</div>
</div>
<!--***************************************************************************************************************************************-->


<div class="table-responsive">
	<form action="recapOrdine.php" method="post">
		<table class="table table-hover" id="listino">
			<thead class="thead-dark ">
				<tr>
					<th><img src="../img/choose.png" alt="choose" style="margin-left: 10px;"></th>
					<th>Nome</th>
					<th>Ingredienti</th>
					<th>Prezzo</th>
				</tr>
			</thead>
			<tbody>

				<?php


				$x= $_GET["pizzeria"];

				$conn = new mysqli("localhost","root","","my_buffersito");

				if ($conn->connect_error){
					die("nr-".$conn->connect_errno." - ". $conn->connect_error);
				}
				$conn->select_db("my_buffersito") or die("die");


				$q = "SELECT * FROM `pizze` WHERE IDpiz= '$x';";
				$result = $conn->query($q);

				$i=0;
				if ($result->num_rows > 0) {
					while($row = $result->fetch_array()) {

						echo"

						<tr>

						<td style='width:57px;'><input type='number' name='qntp[$i]' class='qnt' min='0' max='20'></td>
						<td><strong><input type='hidden' name='pizza[$i]' value='$row[nome]'>$row[nome]</strong></td>
						<td>$row[ingredienti]</td>
						<td><strong> $row[prezzo]€</strong></td>

						</tr>
						";
						$i++;
					}
				}
				$conn->close();


				$_SESSION['IDpizORD'] = "$idpizzeria";
				?>

			</tbody>
		</table>

		<hr>
		<button id="btnProsegui" class="btn btn-secondary">Prosegui</button>
	</form>
</div>

<script>

	$(document).ready(function() {

		$("#cena").hide();
	});

	function showPranzo(){
		$("#cena").hide();
		$("#pranzo").show();
		$('#lblPranzo').attr('class', 'nav-link active');
		$('#lblCena').attr('class', 'nav-link');
	}
	function showCena(){
		$("#pranzo").hide();
		$("#cena").show();
		$('#lblCena').attr('class', 'nav-link active');
		$('#lblPranzo').attr('class', 'nav-link');
	}

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

</script>

</body>
</html>

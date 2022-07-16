<?php
session_start();
if(empty($_SESSION["upiz"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<title>Orari pizzeria</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

	<link href="../css/orario.css" rel="stylesheet" type="text/css">
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
					<a class="nav-link" href="orario.php" style="color: #2b699b">Orario pizzeria</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="graph.php">Grafico pizzeria</a>
				</li>
				<li><div class="dropdown-divider"></div></li>
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

	<h2 style="text-align: center; text-decoration: underline;">Tabella degli orari</h2>
	<br>
	
	<?php
	$ap=0;
	$cl=0;
	?>
	
	<div id="all">

		<!--*/////////////////////////////////////////////////////////////////////////////////////////////*/////////-->
		<!--PRANZO-->
		<!--*/////////////////////////////////////////////////////////////////////////////////////////////*/////////-->
		<nav class="subtitolo">
			
			<h4>Pranzo</h4>
			<div>
				<label class="switch">				
					<input type="checkbox" id="pranzoCK">
					<span class="slider round"></span>
				</label>
			</div>
		</nav>

		<div style="overflow-x:auto;">
			<table class="table"  id="pranzo">
				<thead>
					<tr>
						<th></th>
						<th>Lunedì</th>
						<th>Martedì</th>
						<th>Mercoledì </th>
						<th>Giovedì </th>
						<th>Venerdì </th>
						<th>Sabato</th>
						<th>Domenica</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<?php 
						for($i=0;$i<7;$i++){
							echo "
							<td>
							<div class=form-group>
							<form action=";

							echo $_SERVER['PHP_SELF'];

							echo " method=post>
							<select class='selezionatore' id=ap$ap >
							<option>chiuso</option>
							<option>11:15</option>
							<option>11:30</option>
							<option>12:30</option>
							<option>12:45</option>
							</select>

							</form>
							</div>
							</td>
							";
							$ap++;
						}
						?>

					</tr>
					<tr>
						<td></td>
						<?php 
						for($i=0;$i<7;$i++){
							echo "
							<td>
							<div class=form-group>
							<form action=";

							echo $_SERVER['PHP_SELF'];

							echo " method=post>
							<select class='selezionatore' id=cl$cl >
							<option>chiuso</option>
							<option>14:30</option>
							<option>14:45</option>
							<option>15:00</option>
							</select>
							</form>
							</div>
							</td>
							";
							$cl++;
						}
						?>
					</tr>
				</tbody>
			</table>
		</div>
		<!--*/////////////////////////////////////////////////////////////////////////////////////////////*/////////-->
		<!--CENA-->
		<!--*/////////////////////////////////////////////////////////////////////////////////////////////*/////////-->
		
		<nav class="subtitolo">
			
			<h4>Cena</h4>
			<div>
				<label class="switch">				
					
					<input type="checkbox" id="cenaCK" checked>
					<span class="slider round"></span>
				</label>
			</div>
		</nav>

		<div style="overflow-x:auto;">
			<table class="table" id="cena">
				<thead>
					<tr>
						<th></th>
						<th>Lunedì</th>
						<th>Martedì</th>
						<th>Mercoledì </th>
						<th>Giovedì </th>
						<th>Venerdì </th>
						<th>Sabato</th>
						<th>Domenica</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<?php 
						for($i=0;$i<7;$i++){
							echo "
							<td>
							<div class=form-group>
							<form action=";

							echo $_SERVER['PHP_SELF'];

							echo " method=post>
							<select class='selezionatore' id=ap$ap >
							<option>chiuso</option>
							<option>18:00</option>
							<option>18:15</option>
							<option>18:30</option>
							<option>18:45</option>
							<option>19:00</option>
							<option>19:15</option>
							</select>
							</form>
							</div>
							</td>
							";
							$ap++;
						}

						?>
					</tr>
					<tr>
						<td></td>
						<?php 
						for($i=0;$i<7;$i++){
							echo "
							<td>
							<div class=form-group>
							<form action=";

							echo $_SERVER['PHP_SELF'];

							echo " method=post>
							<select class='selezionatore' id=cl$cl >
							<option>chiuso</option>
							<option>23:45</option>
							<option>00:00</option>
							<option>00:15</option>
							<option>00:30</option>
							<option>00:45</option>
							<option>01:00</option>
							<option>01:15</option>
							<option>01:30</option>
							</select>
							</form>
							</div>
							</td>
							";
							$cl++;
						}

						?>
					</tr>
				</tbody>
			</table>
		</div>
		<button id="sender" class="btn btn-secondary" onclick="checkOrari()">Invia</button>
	</div>

	<script>
		//false = hide, non ho quegli orari
		var cn=true;
		var pr=false;

		$(document).ready(function() {
			
			$("#pranzo").hide();
			init();
		});
		//Invio gli orari della cena
		function sendCena(){
			var strbuffer='';
			<?php

			for($i=7;$i<14;$i++){
				echo "

				strbuffer += $('#ap$i').val() +'-' + $('#cl$i').val() + '||';

				";

				if($i==13){
					echo "
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							alert('Inserimento orari della cena eseguito con successo!');
						}
					};
					xmlhttp.open('GET', 'backPizz.php?cn= '+ strbuffer, true);
					xmlhttp.send();

					";
				}
			}
			?>
		}
		//Invio gli orari del pranzo
		function sendPranzo(){
			var strbuffer='';
			<?php

			for($i=0;$i<7;$i++){
				echo "

				strbuffer += $('#ap$i').val() +'-' + $('#cl$i').val() + '||';
				
				";

				if($i==6){
					echo "
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							alert('Inserimento orari del pranzo eseguito con successo!');
						}
					};
					xmlhttp.open('GET', 'backPizz.php?pr= '+ strbuffer, true);
					xmlhttp.send();

					";
				}
			}
			?>
		}
		//Controllo quand'è aperto
		function checkOrari(){
            //SOLO CENA
            if(cn==true && pr==false){
            	sendCena();
            }
			//SOLO PRANZO
			if(pr==true && cn==false){
				sendPranzo();
			}
            //Sia pranzo che cena 
            if(pr ==true && cn ==true){
            	<?php

            	
            	echo 'sendPranzo();';
            	
            	echo 'sendCena();';
            	
            	?>
            }
        }
        //Abilito la sezione cena
        function cenavar(){
        	if(cn==true){

        		$("#cena").hide();
        		cn=false;
        	}else{
        		$("#cena").show();
        		cn=true;
        	}
        }
        //Abilito la sezione pranzo
        function pranzovar(){
        	if(pr==false){

        		$("#pranzo").show();
        		pr=true;
        	}else{
        		$("#pranzo").hide();
        		pr=false;
        	}
        }
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
		function init(){
			$("#cenaCK").click(cenavar);
			$("#pranzoCK").click(pranzovar);
		}
	</script>
</body>
</html>
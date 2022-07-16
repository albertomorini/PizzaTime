<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["psw"])) {
	header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
	<title>Riepilogo ordine</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" type="text/css" href="../css/riepilogo.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>

<body>
	<!--MENU-->
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

	<!--ALL-->
	<div  class="col-sm-12" id="main">
		<h3 style="text-align: center;">Ordine per la pizzeria: <br>

			<?php 
			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);
			}
			$conn->select_db("my_buffersito") or die("die");

			$idpizzeria= $_SESSION["IDpizORD"];

			$q = "SELECT * FROM `pizzerie` WHERE IDpiz= '$idpizzeria';";
			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				echo $row["nome"];
			}

			$conn->close();
			?>
		</h3>
		<h4 style="font-size: 22px; color: #3a3a3a; padding-bottom: 15px;">Registrato come: <br><?php echo $_SESSION["user"]; ?></h4>

	</div>
	<!--RIEPILOGO TABLE-->
	<div >
		<?php

		///////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////
		//CREA IL RIEPILOGO
		////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////

		$IDpiz= $_SESSION['IDpizORD'];
		$qntnull=true; //verifica se il vettore è stato inviato vuoto
	    //echo "$IDpiz";

		if(!empty($_POST["qntp"]) && !empty($_POST["pizza"])){

			$arrqnt=$_POST["qntp"];
			$arrnome=$_POST["pizza"];

			for ($i=0; $i <count($arrqnt) ; $i++) { 
				if($arrqnt[$i]!==""){
					
					$qntnull=false;
				}
			}

			if($qntnull==false){

				echo '
				<div class="table-responsive">
				<table class="table table-hover " id="tabRiepilogoOrdine">
				<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Quantità</th>
				<th scope="col">Nome</th>
				<th scope="col">Prezzo singola</th>
				</tr>
				</thead>
				<tbody>

				';


				$conn = new mysqli("localhost","root","","my_buffersito");

				if ($conn->connect_error){
					die("nr-".$conn->connect_errno." - ". $conn->connect_error);
				}
				$conn->select_db("my_buffersito") or die("die");



				$j=1; 
				$tot=0;
				$strbuffer ="";
				for ($i=0; $i <count($arrqnt) ; $i++) { 
					if($arrqnt[$i] != "" && $arrqnt[$i] != "0"){
						echo "
						<tr>
						<td><strong>$j)</strong></td>

						<td><strong>$arrqnt[$i]</strong></td>
						<td><strong>$arrnome[$i]</strong></td>
						
						";
						$strbuffer .=$arrqnt[$i]."-".$arrnome[$i]."||";
						$j++;
						$q = "SELECT prezzo FROM `pizze` WHERE IDpiz= '$idpizzeria' AND nome= '$arrnome[$i]';";

						$result = $conn->query($q);

						if ($result->num_rows > 0) {
							$row = $result->fetch_assoc();
							echo "<td>"
							."<strong>".$row["prezzo"]."€"."</strong>"."</td>";
							$tot += ($row["prezzo"] * $arrqnt["$i"]);
						}

						echo "
						</tr>
						";
					}
				}
				$_SESSION["TotPrez"]=$tot;
				$_SESSION["runner"]=$strbuffer;
				echo "
				<tr>
				<td><strong>Totale:</strong></td>
				<td></td>
				<td></td>
				<td><strong> $tot"."€</strong></td>
				</tr>
				";
				echo '
				
				</tbody>
				</table>
				</div>

				<form method="post" action="sender.php" id="scelta" >
				<div style="padding-left: 15px;">



				<label for="asporto">Asporto</label>
				<input type="checkbox" id="asporto" name="idk" checked>

				<label for="tavolo">Tavolo</label>
				<input type="checkbox" id="tavolo" name="idk">

				<label for="domicilio">Domicilio</label>
				<input type="checkbox" id="domicilio" name="idk" > 
				<hr>

				<div id="inpNumPersone" style="overflow-x:auto;">
				<label for="numPers">Numero persone: </label>
				<br>
				<input type="number" name="numPers" id="numPers" placeholder="Numero persone">
				</div>

				<div id="infoPiz" >
				';

				$q = "SELECT via, numCivico, CAP FROM `pizzerie` WHERE IDpiz= '$idpizzeria'";

				$result = $conn->query($q);

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					echo "<h4><strong>In via: </strong>".$row["via"]." ".$row["numCivico"]." (".$row["CAP"].")</h4>";
				}
				echo '
				</div>

				<div id="location">
				<label for="via">Indirizzo: </label>
				<input type="text" name="viadest" id="via" placeholder="Via" > 
				<br>
				<label for="numero">numero civico: </label>
				<input type="number" name="numcivico" id="numero" placeholder="Numero">
				<br>
				<label for="cap">CAP: </label>
				<input type="number" name="cap" id="cap" placeholder="CAP" >
				</div>
				
				<hr >
				<label for="myTime" style>Orario:</label>
				<br>

				<input type="time" name="orario" id="myTime" min="00:00" style="font-size: 30px; border-radius: 5px;" required>
				<br>
				</div>
				<input type="submit" class="btn btn-secondary" name="sender" id="btnsender" value="Invia"> 
				</form>

				';
				
				$conn->close();
			}else{
				echo "
				<div style='text-align: center'>
				<h2>Nessun ordine qui.</h2><br>
				<h5>Seleziona la pizza che vuoi..</h5><br>
				<h5><strong><a href=main.php>Torna alla lista pizzerie</a></strong></h5>
				</div>";
			}
		}else{
			echo "
			<div style='text-align: center'>
			<h2>Nessun ordine qui.</h2><br>
			<h5>Seleziona la pizza che vuoi..</h5><br>
			<h5><strong><a href=main.php>Torna alla lista pizzerie</a></strong></h5>
			</div>";
		}

		?>

	</div>

	<script>


		$("input:checkbox").on('click', function() {
            // in the handler, 'this' refers to the box clicked on
            var $box = $(this);
            if ($box.is(":checked")) {

            	var group = "input:checkbox[name='" + $box.attr("name") + "']";

            	$(group).prop("checked", false);
            	$box.prop("checked", true);
            } else {
            	$box.prop("checked", false);
            }
        });
		$(document).ready(function() {

			var d = new Date();
			var hour = parseInt(d.getHours());
			var min = parseInt(d.getMinutes())+20;

            //se i minuti sono più id 59
            //aggiuno un'ora e sottraggo i minuti aggiunti
            if(min > 59){
            	hour++;
            	min -= 50;
            }
			//converto in string
			var posticipo= hour.toString()+":"+min.toString();

            //inserisco il valore e imposto il minimo
            document.getElementById("myTime").value = posticipo;
            document.getElementById("myTime").min = posticipo;
            
            mngOther();

            init();
        });


		function mngOther(){
			$("#inpNumPersone").hide();
			$("#location").hide();
			$("#other").hide();
			$("#infoPiz").show();

			$("#numPers").val(0);
			$("#location").hide();
			$("#via").val("");
			$("#numero").val("");
			$("#cap").val("");

		}


		function mngTavoli(){
			$("#inpNumPersone").show();

			$("#location").hide();
			$("#via").val("");
			$("#numero").val("");
			$("#cap").val("");


			$("#infoPiz").hide();
		}
		function mngDomicilio(){
			$("#inpNumPersone").hide();
			$("#numPers").val(0);
			$("#location").show();

			$("#infoPiz").hide();
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

		function init(){
			$("#asporto").click(mngOther);
			$("#tavolo").click(mngTavoli);
			$("#domicilio").click(mngDomicilio);
			
		}
	</script>

</body>
</html>
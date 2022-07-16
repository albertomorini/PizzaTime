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
	<link rel="stylesheet" type="text/css" href="../css/ordini.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta HTTP-EQUIV="refresh" CONTENT="45">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>

<body>
	<!--MENU-->
	<nav class="navbar navbar-expand-lg navbar-dark justify-content-between" id="titolo">
		
		<a class="navbar-brand" href="main.php">Lista pizzerie</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="maps.php">Mappa pizzerie</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="selfOrder.php" style="color: #2b699b">I tuoi ordini</a>
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
	

	<div id="main">
		<h2>I tuoi ordini:</h2>
	</div>

	<div id="tab">

		<?php 

		$conn = new mysqli("localhost","root","","my_buffersito");

		if ($conn->connect_error){
			die("nr-".$conn->connect_errno." - ". $conn->connect_error);
		}
		$conn->select_db("my_buffersito") or die("die");

		$email = $_SESSION["user"];
    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////
    ///////////////////////////////////////////////////    

		$q = "SELECT `ID` FROM `user` WHERE email = '$email' ;";


		$result = $conn->query($q);
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();

			getOrdiniAttesa($row["ID"],$conn);
			getOrdiniMod($row["ID"],$conn);

			getOrdiniAccettati($row["ID"],$conn);
			getOrdiniDeleted($row["ID"],$conn);


		}
        
		function getOrdiniAttesa($bfr,$conn){

			$q = "SELECT * FROM `ordini` WHERE IDuser = '$bfr' AND status='waiting' ;";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {

				echo "<h4>Ordini in attesa:</h4>";
				echo '<div style="overflow-x:auto;">';
				echo '<table class="table table-hover">
				<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nome</th>
				<th scope="col">Prezzo totale</th>
				<th scope="col">Orario</th>
				<th scope="col">Pizzeria</th>
				<th scope="col">Modalità</th>
				</tr>
				</thead>
				<tbody>';

				$j=0;
				while($row = $result->fetch_assoc()) {
					echo "
					<tr class='table-primary'>
					<td>$j)</td>
					<td>";
					echo str_replace("||","<br>",$row["nomePiz"]);
					echo "</td>
					<td>$row[prezzoTot]€</td>
					<td>$row[orario]</td>
					<td>";

				//NOME DELLA PIZZERIA
					$bfr=$row["IDpiz"];

					$q = "SELECT `nome` FROM `pizzerie` WHERE IDpiz = '$bfr' ;";
					$res = $conn->query($q);
					if ($res->num_rows > 0) {
						$riga = $res->fetch_assoc();
						echo $riga["nome"];
					}

                //MODALITA' 
					echo "</td>
					<td>";
					if($row["via"]== "-" && $row["tavolo"]=="0"){
						echo "Asporto";
					}else if($row["via"] != "-" && $row["tavolo"]=="0"){
						echo "Domicilo";
					}else if($row["via"] == "-" && $row["tavolo"] !="0"){
						echo "Tavolo";
					}

					echo "</td>
					</tr>
					";
					$j++;
				}
				echo "</tbody>
				</table>
				</div>
				<hr>";
			}
		}

		function getOrdiniMod($bfr,$conn){
			$q = "SELECT * FROM `ordini` WHERE IDuser = '$bfr' AND status='modify' ;";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {

				echo "<h4>Ordini modificati dalle pizzerie:</h4>";
				echo '<div style="overflow-x:auto;">';
				echo '<table class="table table-hover">
				<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nome</th>
				<th scope="col">Prezzo totale</th>
				<th scope="col">Orario</th>
				<th scope="col">Pizzeria</th>
				<th scope="col">Modalità</th>
				<th scope="col">Accetta</th>
				</tr>
				</thead>
				<tbody>';

				$j=0;
				while($row = $result->fetch_assoc()) {


					echo "
					<tr class='table-info'>
					<td>$j)</td>
					<td>";
					echo str_replace("||","<br>",$row["nomePiz"]);
					echo "</td>
					<td>$row[prezzoTot]€</td>
					<td>$row[orario]</td>
					<td>";

				//NOME DELLA PIZZERIA
					$bfr=$row["IDpiz"];

					$q = "SELECT `nome` FROM `pizzerie` WHERE IDpiz = '$bfr' ;";
					$res = $conn->query($q);
					if ($res->num_rows > 0) {
						$riga = $res->fetch_assoc();
						echo $riga["nome"];
					}

                //MODALITA' 
					echo "</td>
					<td>";
					if($row["via"]== "-" && $row["tavolo"]=="0"){
						echo "Asporto";
					}else if($row["via"] != "-" && $row["tavolo"]=="0"){
						echo "Domicilo";
					}else if($row["via"] == "-" && $row["tavolo"] !="0"){
						echo "Tavolo";
					}


					echo '

					</td>
					<td>
					<input type="image" name="decline" src="../img/decline.png" alt="decline" onclick="ordDecline('; 
					echo $row["ID"];
					echo 
					')">
					<input type="image" name="accept" src="../img/accept.png" alt="accept" onclick="ordAccept(';
					echo $row["ID"];
					echo ')" style="margin-left: 20px;">

					</td>
					</tr>

					';
					$j++;
				}
				echo "</tbody>
				</table>
				</div>
				<hr>";
			}
		}

		function getOrdiniAccettati($bfr,$conn){

			$q = "SELECT * FROM `ordini` WHERE IDuser = '$bfr' AND status='accept' ;";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {

				echo "<h4>Ordini accettati:</h4>";
				echo '<div style="overflow-x:auto;">';
				echo '<table class="table table-hover">
				<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nome</th>
				<th scope="col">Prezzo totale</th>
				<th scope="col">Orario</th>
				<th scope="col">Pizzeria</th>
				<th scope="col">Modalità</th>
				</tr>
				</thead>
				<tbody>';

				$j=0;
				while($row = $result->fetch_assoc()) {
					echo "
					<tr class='table-success'>
					<td>$j)</td>
					<td>";
					echo str_replace("||","<br>",$row["nomePiz"]);
					echo "</td>
					<td>$row[prezzoTot]€</td>
					<td>$row[orario]</td>
					<td>";

				//NOME DELLA PIZZERIA
					$bfr=$row["IDpiz"];

					$q = "SELECT `nome` FROM `pizzerie` WHERE IDpiz = '$bfr' ;";
					$res = $conn->query($q);
					if ($res->num_rows > 0) {
						$riga = $res->fetch_assoc();
						echo $riga["nome"];
					}

                //MODALITA' 
					echo "</td>
					<td>";
					if($row["via"]== "-" && $row["tavolo"]=="0"){
						echo "Asporto";
					}else if($row["via"] != "-" && $row["tavolo"]=="0"){
						echo "Domicilo";
					}else if($row["via"] == "-" && $row["tavolo"] !="0"){
						echo "Tavolo";
					}

					echo "</td>
					</tr>
					";
					$j++;
				}
				echo "</tbody>
				</table>
				</div>
				<hr>
				";
			}
		}
		function getOrdiniDeleted($bfr,$conn){

			$q = "SELECT * FROM `ordini` WHERE IDuser = '$bfr' AND status='deleted' ;";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {

				echo "<h4>Ordini rifiutati/terminati:</h4>";
				echo '<div style="overflow-x:auto;">';
				echo '<table class="table table-hover">
				<thead class="thead-dark">
				<tr>
				<th scope="col">#</th>
				<th scope="col">Nome</th>
				<th scope="col">Prezzo totale</th>
				<th scope="col">Orario</th>
				<th scope="col">Pizzeria</th>
				<th scope="col">Modalità</th>
				</tr>
				</thead>
				<tbody>';

				$j=0;
				while($row = $result->fetch_assoc()) {
					echo "
					<tr class='table-active'>
					<td>$j)</td>
					<td>";
					echo str_replace("||","<br>",$row["nomePiz"]);
					echo "</td>
					<td>$row[prezzoTot]€</td>
					<td>$row[orario]</td>
					<td>";

				//NOME DELLA PIZZERIA
					$bfr=$row["IDpiz"];

					$q = "SELECT `nome` FROM `pizzerie` WHERE IDpiz = '$bfr' ;";
					$res = $conn->query($q);
					if ($res->num_rows > 0) {
						$riga = $res->fetch_assoc();
						echo $riga["nome"];
					}

                //MODALITA' 
					echo "</td>
					<td>";
					if($row["via"]== "-" && $row["tavolo"]=="0"){
						echo "Asporto";
					}else if($row["via"] != "-" && $row["tavolo"]=="0"){
						echo "Domicilo";
					}else if($row["via"] == "-" && $row["tavolo"] !="0"){
						echo "Tavolo";
					}

					echo "</td>
					</tr>
					";
					$j++;
				}
				echo "</tbody>
				</table>
				</div>
				";
			}
		}


		$conn->close();
		?>

	</div>

	<script>
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
		function ordAccept(numID){
			var r = confirm("Sicuro di accettare l'ordine?");

			if (r == true) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						//nothing, esce
					}
				};

				xmlhttp.open("GET", "../mngOrder.php?acpt=" + numID, false);
				xmlhttp.send();
				location.reload();
			}		

		}
		function ordDecline(numID){

			var r = confirm("Sicuro di eliminare l'ordine?");

			if (r == true) {

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						//nothing, esce
					}
				};

				xmlhttp.open("GET", "../mngOrder.php?del=" + numID, false);
				xmlhttp.send();
				location.reload();
			}		
		}
	</script>
</body>
</html>
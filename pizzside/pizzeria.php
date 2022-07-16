<?php
session_start();
if(empty($_SESSION["upiz"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<title>La tua pizzeria</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<link href="../css/account.css" rel="stylesheet" type="text/css">
</head>
<body>
	<!--*******************************NAV BAR****************************************************-->
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
					<a class="nav-link" href="graph.php">Grafico pizzeria</a>
				</li>
				<li><div class="dropdown-divider"></div></li>
				<li class="nav-item dropdown" >
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #2b699b">
						Account
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="pizzeria.php" >La sua pizzeria</a>
						<a class="dropdown-item" onclick="esci();">Esci</a>
					</div>
				</li>

			</ul>
		</div>
	</nav>

	<div id="all">

		<!--***************************     NOME PIZZERIA        **************************************-->
		<h3>Pizzeria: 
			<?php
			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);

			}
			$buffer = $_SESSION["upiz"];

			$q = "SELECT `Nome` FROM `pizzerie` WHERE IDpiz= '$buffer';";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {
				while($row = $result->fetch_array()) {

					echo $row["Nome"];
				}
			}
			$conn->close();
			?>
		</h3>
		<hr>


		<!--***************************     RIEPILOGO     **************************************-->
		<div id="riepilogo" style="overflow-x:auto;">

			<?php

			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);
			}
			$conn->select_db("my_buffersito") or die("die");

			$nome=$_SESSION["upiz"];
			$psw=$_SESSION["psw"];

			$q = "SELECT * FROM `pizzerie` WHERE IDpiz = '$nome' AND password = '$psw' ;";


			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {

					echo"
					<table class='table'>
					<thead class='thead-light'>
					<tr>
					<th scope='col'>Le tue informazioni</th>
					<th></th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td>Nome</td>
					<td>$row[nome]</td>
					</tr>
					<tr>
					<td>Via</td>
					<td>$row[via]</td>
					</tr>
					<tr>
					<td>Numero di telefono</td>
					<td>$row[telefono]</td>
					</tr>
					<tr>
					<td>Email</td>
					<td>$row[email]</td>
					</tr>


					</tbody>
					</table>
					";

				}
			}
			$conn->close();
			?>
		</div>

		<!--***************************     MODIFICATORE     **************************************-->
		<div id="modificatore">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

				<div class="form-group">
					<label for="newnome">Nome: </label>
					<input type="text" class="form-control" name="newnome" id="newnome" placeholder="Inserisci il nuovo nome" >
				</div>

				<div class="form-group">
					<label for="newaddress">Via: </label>
					<input type="text" class="form-control" name="newaddress" id="newaddress" placeholder="Inserisci la nuova via"  >
				</div>
				<nav class="form-inline" >

					<div class="form-group mb-2" style="margin-right: 60px">

						<input type="number" class="form-control" name="numCivico" id="numCivico" placeholder="Num civico" >

					</div>

					<div class="form-group mb-2">

						<input type="number" class="form-control" name="CAP" id="CAP" placeholder="CAP" >
					</div>

				</nav>
				<hr>

				<div class="form-group">
					<label for="numeroTel">Telefono: </label>
					<input type="number" class="form-control" name="numeroTel" id="numeroTel" placeholder="Inserisci il nuovo numero di telefono"  >
				</div>

				<div class="form-group">
					<label for="newemail">Indirizzo email: </label>
					<input type="email" class="form-control" name="newemail" id="newemail" placeholder="Inserisci la nuova email" >
				</div>

				<div class="form-group">
					<label for="oldpass">Vecchia password: </label>
					<input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Inserisci la vecchia password" >
				</div>

				<div class="form-group">
					<label for="newpass">Nuova password: </label>
					<input type="password" class="form-control" name="newpass" id="newpass" placeholder="Inserisci la nuova password" >
				</div>

				<div class="form-group">
					<label for="reppass">Ripeti password: </label>
					<input type="password" class="form-control" name="reppass" id="reppass" placeholder="Ripeti la nuova password" >
				</div>

				<button type="submit" class="btn btn-primary" style="background-color: #006abc; height: 28px; line-height: 10px; width: 100%">Modifica</button>
			</form>
			<?php
			updater();
			?>
		</div>


		<!--***************************     MENU     **************************************-->
		<div id="menu" style="overflow-x:auto;">
			<h2>Il menù</h2>
			<table class="table table-hover">
				<thead class="thead-dark">
					<tr>
						<th>Nome pizza</th>
						<th>Ingredienti</th>
						<th>Prezzo</th>
						<th>Cancella</th>
					</tr>
				</thead>
				<tbody>	
					<?php
					$conn = new mysqli("localhost","root","","my_buffersito");

					if ($conn->connect_error){
						die("nr-".$conn->connect_errno." - ". $conn->connect_error);
					}
					$conn->select_db("my_buffersito") or die("die");

					$buffer=$_SESSION["upiz"];
					$q = "SELECT * FROM `pizzerie` WHERE IDpiz= '$buffer';";
					$result = $conn->query($q);

					if ($result->num_rows > 0) {
						while($row = $result->fetch_array()) {

							$idpizzeria=$row["IDpiz"];
						}
					}

					$q = "SELECT * FROM `pizze` WHERE IDpiz = '$idpizzeria' ;";


					$result = $conn->query($q);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo"
							<tr> 
							<td><label for=$row[IDpizza]>$row[nome]</label></td>
							<td><label for=$row[IDpizza]>$row[ingredienti]</label></td>
							<td><label for=$row[IDpizza]>$row[prezzo]</label></td>

							<td><input type='image' src='../img/decline.png' alt='delete' onclick='cancella($row[IDpizza])' id='$row[IDpizza]'></td>
							</tr>
							
							";
						}
					}

					$conn->close();
					?>
				</tbody>
			</table>

			<hr>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

				<input type="text" name="addpizza" placeholder="Inserisci una nuova pizza" class="adder">			
				<input type="text" name="addingriedenti" placeholder="Inserisci gli ingriedenti" class="adder">
				<input type="number" name="addprezzo" placeholder="Inserisci il prezzo" class="adder">
				<button type="submit" class="btn btn-success" id="btnadd">Aggiungi</button>
				<?php adder() ?>
			</form>

		</div>

		<button type="button" class="btn btn-secondary" id="mod">Modifica i dati</button>

		<button  type="button" class="btn btn-secondary" id="btnmenu">Visualizza o modifica il menù </button>
	</div>


	<!-- //////////////////////////// SCRIPT ||||||||||||||||||||||||||||||||||||| -->
	<!-- //////////////////////////// SCRIPT ||||||||||||||||||||||||||||||||||||| -->
	<!-- //////////////////////////// SCRIPT ||||||||||||||||||||||||||||||||||||| -->
	<!-- //////////////////////////// SCRIPT ||||||||||||||||||||||||||||||||||||| -->

	<script>

		var i = false;
		var j = false;


		$(document).ready(function() {
			init();
			$("#modificatore").hide();
			$("#menu").hide();

		});
		//mostra modificatore
		function moddon(){

			if(i== false){

				$("#riepilogo").hide();
				$("#modificatore").show();
				$("#btnmenu").hide();
				$("#mod").html("Annulla");

				i=true;

			}else{
				$("#riepilogo").show();
				$("#modificatore").hide();
				$("#btnmenu").show();
				$("#mod").html("Modifica i dati");
				i=false;
			}
		}
		//mostra menù
		function showmenu(){
			if(j== false){
				$("#riepilogo").hide();
				$("#modificatore").hide();
				$("#mod").hide();
				$("#menu").show();
				$("#btnmenu").html("Annulla");

				j=true;
			}else{
				$("#riepilogo").show();
				$("#mod").show();
				$("#modificatore").hide();
				$("#menu").hide();
				$("#btnmenu").html("Visualizza o modifica il menù");
				j=false;
			}
		}
        //ajax
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
		//ajax too
		function cancella(IDpizza){
			var r = confirm("Sicuro di cancellare la pizza?");

			if(r==true){

				scelta=IDpizza;

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {


					}
				};
				xmlhttp.open("GET", "backPizz.php?ca=" + scelta, false);
				xmlhttp.send();
			}
		}

		function init() {
			$("#mod").click(moddon);
			$("#btnmenu").click(showmenu);

		}
	</script>

	<?php
	//Modifica i dati anagrafici
	function updater(){
		$conn = new mysqli("localhost","root","","my_buffersito");

		if ($conn->connect_error){
			die("nr-".$conn->connect_errno." - ". $conn->connect_error);

		}
		$conn->select_db("my_buffersito") or die("die");


		$buffer = $_SESSION["upiz"];
        //nome
		if(!empty($_POST["newnome"])){

			$bfr= strip_tags($_POST["newnome"]);

			$q="UPDATE pizzerie SET Nome= '$bfr' WHERE IDpiz = '$buffer' ;";

			$conn->query($q);
		}
		//INDIRIZZO
		if(!empty($_POST["newaddress"]) && !empty($_POST["numCivico"]) && !empty($_POST["CAP"])){


			$newaddress= strip_tags($_POST["newaddress"]);
			$numCivico= strip_tags($_POST["numCivico"]);
			$CAP= strip_tags($_POST["CAP"]);

			$q="UPDATE pizzerie SET Via= '$newaddress', numCivico= '$numCivico', CAP= '$CAP' WHERE IDpiz = '$buffer' ;";
			$conn->query($q);
		}
		//password
		if(!empty($_POST["oldpass"]) && !empty($_POST["newpass"]) && !empty($_POST["reppass"])){


			$bfr= hash("sha512", $_POST["oldpass"]);
			if($_SESSION["psw"] == $bfr){


				if($_POST["newpass"]==$_POST["reppass"]){

					$bfr= hash("sha512", $_POST["newpass"]);

					$q="UPDATE pizzerie SET password= '$bfr' WHERE IDpiz = '$buffer' ;";

					$conn->query($q);

					$_SESSION["psw"]= $bfr;


				}
			}
		}
		//email
		if(!empty($_POST["newemail"])){

			$bfr= strip_tags($_POST["newemail"]);

			$q="UPDATE pizzerie SET Email= '$bfr' WHERE IDpiz = '$buffer' ;";


			$conn->query($q);
		}
		//numerotelefono
		if(!empty($_POST["numeroTel"])){

			$bfr= strip_tags($_POST["numeroTel"]);

			$q="UPDATE pizzerie SET Telefono= '$bfr' WHERE IDpiz = '$buffer' ;";
			$conn->query($q);
		}

		$conn->close();
	}
	//AGGIUNGE PIZZA
	function adder(){

		if(!empty($_POST["addpizza"]) && !empty($_POST["addprezzo"]) && !empty($_POST["addingriedenti"])){

			//nuova pizza dati
			$newPizza=strip_tags($_POST["addpizza"]);            
			$newIng=strip_tags($_POST["addingriedenti"]);
			$newPrezzo=strip_tags($_POST["addprezzo"]);  


			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);
			}
			$conn->select_db("my_buffersito") or die("die");


			$buffer=$_SESSION["upiz"];

            //CONTROLLO PER PIZZA
			$q= "SELECT `nome` FROM `pizze` WHERE IDpiz= '$buffer' AND nome= '$newPizza' ;";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {

			}else{     
				$q = "INSERT INTO pizze (nome, ingredienti, prezzo, IDpiz) VALUES (
				'$newPizza',
				'$newIng',
				'$newPrezzo',
				'$buffer' );";
				$conn->query($q);
			}           


			$conn->close();
		}
	}
	?>
</body>
</html>
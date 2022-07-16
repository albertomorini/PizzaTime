<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<title>Il tuo account</title>
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
					<a class="nav-link" href="selfOrder.php">I tuoi ordini</a>
				</li>
				<li><div class="dropdown-divider"></div></li>
				<li class="nav-item dropdown" >
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #2b699b">
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

	<div id="all">
		
		<h3>Benvenuto nel tuo profilo
			<?php
			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);

			}
			$buffer = $_SESSION["user"];

			$q = "SELECT `Nome` FROM `user` WHERE Email= '$buffer';";
			$result = $conn->query($q);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();

					echo $row["Nome"];
				
			}
			$conn->close();
			?>
		</h3>
		
		<hr>
		
		<div id="riepilogo">

			<?php

			$conn = new mysqli("localhost","root","","my_buffersito");

			if ($conn->connect_error){
				die("nr-".$conn->connect_errno." - ". $conn->connect_error);
			}
			$conn->select_db("my_buffersito") or die("die");

			$nome=$_SESSION["user"];
			$psw=$_SESSION["psw"];

			$q = "SELECT * FROM `user` WHERE email = '$nome' AND password = '$psw' ;";


			$result = $conn->query($q);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {

					echo '
					<table class="table">
					<thead class="thead-light">
					<tr>
					<th scope="col">Le tue informazioni</th>
					<th></th>
					</tr>
					';
					echo "
					</thead>
					<tbody>
					<tr>
					<th scope='row'>Nome</th>
					<td>$row[nome]</td>
					</tr>
					<tr>
					<th scope='row'>Cognome</th>
					<td>$row[cognome]</td>
					</tr>
					<tr>
					<th scope='row'>Numero di telefono</th>
					<td>$row[telefono]</td>
					</tr>
					<tr>
					<th scope='row'>Email</th>
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


		<div id="modificatore">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

				<div class="form-group">
					<label for="newnome">Nome: </label>
					<input type="text" class="form-control" name="newnome" id="newnome" placeholder="Inserisci il nuovo nome" >
				</div>

				<div class="form-group">
					<label for="newsurname">Cognome: </label>
					<input type="text" class="form-control" name="newsurname" id="newsurname" placeholder="Inserisci il nuovo cognome"  >
				</div>

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

				<button type="submit" class="btn btn-primary" style="background-color: #006abc; height: 28px; line-height: 10px;">Modifica</button>
			</form>
			
		</div>


		<button type="button" class="btn btn-secondary" id="mod">Modifica i dati</button>
	</div>
	<script>
		var i= false;



		$(document).ready(function() {
			init();
			$("#modificatore").hide();


		});

		function moddon(){

			if(i== false){

				$("#riepilogo").hide();
				$("#modificatore").show();
				$("#mod").html("Annulla");

				i=true;

			}else{
				$("#riepilogo").show();
				$("#modificatore").hide();
				$("#mod").html("Modifica i dati");
				i=false;
			}

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

		function init() {

			$("#mod").click(moddon);
		}
	</script>

	<?php
	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");


	$buffer = $_SESSION["user"];


        //UPDATE NOME
	if(!empty($_POST["newnome"])){

		$bfr= strip_tags($_POST["newnome"]);


		$q="UPDATE user SET Nome= '$bfr' WHERE Email = '$buffer' ;";

		$conn->query($q);
	}
		//UPDATE COGNOME
	if(!empty($_POST["newsurname"])){


		$bfr= strip_tags($_POST["newsurname"]);

		$q="UPDATE user SET Cognome= '$bfr' WHERE Email = '$buffer' ;";
		$conn->query($q);
	}
		//UPDATE EMAIL
	if(!empty($_POST["newemail"])){



		$bfr= strip_tags($_POST["newemail"]);

		$q="SELECT `email` FROM `user` WHERE email='$bfr' ;";

		if ($result->num_rows > 0) {
			echo "email già esistente";
		}else{
			$q="UPDATE user SET Email= '$bfr' WHERE Email = '$buffer' ;";

			$_SESSION["user"]= $bfr;



			$conn->query($q);
		}



	}
		//UPDATE PASSWORD
	if(!empty($_POST["oldpass"]) && !empty($_POST["newpass"]) && !empty($_POST["reppass"])){


		$bfr= hash("sha512", $_POST["oldpass"]);
		if($_SESSION["psw"] == $bfr){


			if($_POST["newpass"]==$_POST["reppass"]){

				$bfr= hash("sha512", $_POST["newpass"]);

				$q="UPDATE user SET password= '$bfr' WHERE Email = '$buffer' ;";

				$conn->query($q);

				$_SESSION["psw"]= $bfr;


			}
		}
	}

	if(!empty($_POST["numeroTel"])){

		$bfr= strip_tags($_POST["numeroTel"]);

		$q="UPDATE user SET Telefono= '$bfr' WHERE Email = '$buffer' ;";
		$conn->query($q);
	}

	$conn->close();
	


	?>


</body>
</html>
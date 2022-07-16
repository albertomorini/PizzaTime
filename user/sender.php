<?php
session_start();

$carrello = $_SESSION["runner"]; //nome pizze + quantità
$total = $_SESSION["TotPrez"];
$IDpiz= $_SESSION['IDpizORD'];
$orario = $_POST["orario"];
$email = $_SESSION["user"];


////////////////////

$conn = new mysqli("localhost","root","","my_buffersito");

if ($conn->connect_error){
	die("nr-".$conn->connect_errno." - ". $conn->connect_error);

}
$conn->select_db("my_buffersito") or die("die");

////////////////////////////////////////////////////////////
//ANALISI

$bfr= explode("||", $carrello);

for($i=0; $i<sizeof($bfr)-1; $i++){

	$n=explode("-", $bfr[$i]);

	$nome=$n[1];
	$q="SELECT `bought` FROM `pizze` WHERE nome='$nome' AND IDpiz=$IDpiz";

	$result = $conn->query($q);

	if ($result->num_rows > 0) {
		$row = $result->fetch_array();

		$somma= $row[0]+$n[0];

		$t="UPDATE `pizze` SET `bought`=$somma WHERE IDpiz=$IDpiz AND nome='$nome'";

		$conn->query($t);
	}
}




/////////////////////////////////////////////////////////////
$q = "SELECT `ID`, `telefono` FROM `user` where email= '$email' ";
$result = $conn->query($q);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
}



//DOMICILIO
if(!empty($_POST["viadest"]) && !empty($_POST["numcivico"]) && !empty($_POST["cap"]) && !empty($_POST["orario"])){

	$via=$_POST["viadest"];
	$numCivico= $_POST["numcivico"];
	$CAP= $_POST["cap"];

	$q = "INSERT INTO ordini (nomePiz, orario, prezzoTot, IDpiz, IDuser, telUser, tavolo, via, numCivico, CAP, status) VALUES (
	'$carrello',
	'$orario',
	'$total',
	'$IDpiz',
	'$row[ID]',
	'$row[telefono]',
	'0',
	'$via',
	'$numCivico',
	'$CAP',
	'waiting'
);";
$conn->query($q);


//TAVOLO
}else if(!empty($_POST["numPers"]) && !empty($_POST["orario"])){

	$buffer=$_POST["numPers"];

	$q = "INSERT INTO ordini (nomePiz, orario, prezzoTot, IDpiz, IDuser, telUser, tavolo, via, numCivico, CAP, status) VALUES (
	'$carrello',
	'$orario',
	'$total',
	'$IDpiz',
	'$row[ID]',
	'$row[telefono]',
	'$buffer',
	'-',
	'0',
	'0',
	'waiting'
);";

$conn->query($q);

//ASPORTO
}else if(!empty($_POST["orario"])){

	$q = "INSERT INTO ordini (nomePiz, orario, prezzoTot, IDpiz, IDuser, telUser, tavolo, via, numCivico, CAP, status) VALUES (
	'$carrello',
	'$orario',
	'$total',
	'$IDpiz',
	'$row[ID]',
	'$row[telefono]',
	'0',
	'-',
	'0',
	'0',
	'waiting'
);";

$conn->query($q);


}

header("location: selfOrder.php")
?>

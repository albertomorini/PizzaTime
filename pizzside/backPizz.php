<?php
session_start();
if(empty($_SESSION["user"])|| empty($_SESSION["upiz"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}

//cena
$cn = $_REQUEST["cn"];
if(!empty($cn)){

	cena($cn);

}


//pranzo
$pr = $_REQUEST["pr"];

if(!empty($pr)){
	pranzo($pr);

}


$canc = $_REQUEST["ca"];
if(!empty($canc)){
	cancella($canc);


}

function cena($cn){



	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");

	$buffer=$_SESSION["upiz"];

	$q= "SELECT * FROM orari WHERE IDpiz= '$buffer' AND orario= 'cn' ;";

	$result = $conn->query($q);

	$vetOrari=explode("||", $cn);

	if ($result->num_rows > 0) {

		$q= "UPDATE orari SET monday='$vetOrari[0]', tuesday='$vetOrari[1]', wednesday='$vetOrari[2]',thursday='$vetOrari[3]',friday='$vetOrari[4]',saturday='$vetOrari[5]',sunday='$vetOrari[6]' WHERE IDpiz='$buffer' AND orario= 'cn' ;";
		$conn->query($q);
	}else{

		$q= "INSERT INTO `orari` (`IDpiz`, `orario`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES ('$buffer','cn',";


		for ($i=0; $i <7 ; $i++) {

			if($i != 6){

				$q .="'". $vetOrari[$i]."'".",";
			}else{
				$q .="'". $vetOrari[$i]."'";
			}

		}
		$q.=');';
		$conn->query($q);
	}





	$conn->close();

}
function pranzo($pr){


	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");

	$buffer=$_SESSION["upiz"];

	$q= "SELECT * FROM orari WHERE IDpiz= '$buffer' AND orario= 'pr' ;";

	$result = $conn->query($q);

	$vetOrari=explode("||", $pr);

	if ($result->num_rows > 0) {

		$q= "UPDATE orari SET monday='$vetOrari[0]', tuesday='$vetOrari[1]', wednesday='$vetOrari[2]',thursday='$vetOrari[3]',friday='$vetOrari[4]',saturday='$vetOrari[5]',sunday='$vetOrari[6]' WHERE IDpiz='$buffer' AND orario= 'pr' ;";

		$conn->query($q);
	}else{


		$q= "INSERT INTO `orari`(`IDpiz`, `orario`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES ('$buffer','pr',";

		for ($i=0; $i <7 ; $i++) {

			if($i != 6){

				$q .="'". $vetOrari[$i]."'".",";
			}else{
				$q .="'". $vetOrari[$i]."'";
			}

		}
		$q.=');';
		$conn->query($q);
	}


	$conn->close();
}

function cancella($canc){
	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");



	$q= "DELETE FROM `pizze` WHERE IDpizza='$canc';";
	$conn->query($q);


	$conn->close();
}



?>

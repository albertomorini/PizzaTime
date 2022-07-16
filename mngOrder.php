<?php

$del = $_REQUEST["del"];
$acpt = $_REQUEST["acpt"];
$modf = $_REQUEST["modf"];

if(!empty($del)){
	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");

	$q= " UPDATE `ordini` SET `status` = 'deleted' WHERE ID='$del'; ";
	$conn->query($q);

}

if(!empty($acpt)){
	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");

	$q= " UPDATE `ordini` SET `status` = 'accept' WHERE ID='$acpt'; ";
	$conn->query($q);
}

if(!empty($modf)){
	$conn = new mysqli("localhost","root","","my_buffersito");

	if ($conn->connect_error){
		die("nr-".$conn->connect_errno." - ". $conn->connect_error);
	}
	$conn->select_db("my_buffersito") or die("die");


	$words = explode('||', $modf);
	$IDorder = array_pop($words);
	$newTime = implode(' ', $words);

	$q= "UPDATE `ordini` SET `status` = 'modify', `orario` = '$newTime'  WHERE ID='$IDorder'; ";
	$conn->query($q);
}

header("location: index.php");

?>
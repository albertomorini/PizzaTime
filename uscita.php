<?php 
session_start();


$r = $_REQUEST["r"];

if(!empty($r)){
	svuota();
	svuota();
	svuota();
}
function svuota(){

	session_unset();
	session_destroy();
}



header("location: index.php");





?>
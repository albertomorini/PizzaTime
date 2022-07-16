
<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["upiz"]) || empty($_SESSION["psw"])) {
  header("location: index.php");
}

$conn = new mysqli("localhost","root","","my_buffersito");

if ($conn->connect_error){
  die("nr-".$conn->connect_errno." - ". $conn->connect_error);
}
$conn->select_db("my_buffersito") or die("die");


  //login
if(!empty($_POST["emailogin"]) && !empty($_POST["pswlog"])){

  $emailuser= strip_tags($_POST["emailogin"]);
  $pswuser= strip_tags($_POST["pswlog"]);
  $pswuser = hash("sha512", $pswuser);

  identify($emailuser,$pswuser,$conn);
}

//REGISTRAZIONE
if(!empty($_POST["nameregister"]) && !empty($_POST["surnameregister"]) && !empty($_POST["numeroTel"]) && !empty($_POST["emailregister"]) && !empty($_POST["passwordregister"])){

  $nome= strip_tags($_POST["nameregister"]);
  $cognome= strip_tags($_POST["surnameregister"]);
  $telefono= strip_tags($_POST["numeroTel"]);
  $email= strip_tags($_POST["emailregister"]);
  $password= strip_tags($_POST["passwordregister"]);
  $password = hash("sha512", $password);

  $q = "SELECT * FROM `user` WHERE email= '$email' AND password = '$password' ;";
  $result = $conn->query($q);

  if ($result->num_rows > 0) {
    identify($email,$password,$conn);
  }else{

    $q = "INSERT INTO `user`(nome, cognome, telefono, email, password) VALUES (
    '$nome',
    '$cognome',
    '$telefono',
    '$email',
    '$password' );";

    $conn->query($q);
    identify($email,$password,$conn);

  }
}

//REGISTRAZIONE PIZZERIE
if(!empty($_POST["nomepizzeria"]) && !empty($_POST["viapizzeria"]) && !empty($_POST["numeroTelPiz"]) && !empty($_POST["emailpizzeria"]) && !empty($_POST["passwordpizzeria"]) && !empty($_POST["numeroIVA"])){



  $nome= strip_tags($_POST["nomepizzeria"]);
  $via= strip_tags($_POST["viapizzeria"]);
  $numCivico= strip_tags($_POST["numCivico"]);
  $CAP= strip_tags($_POST["CAP"]);
  $telefono= strip_tags($_POST["numeroTelPiz"]);
  $email= strip_tags($_POST["emailpizzeria"]);
  $password= strip_tags($_POST["passwordpizzeria"]);
  $password = hash("sha512", $password);
  $iva = strip_tags($_POST["numeroIVA"]);

  $q = "SELECT * FROM `pizzerie` WHERE email= '$email' AND password = '$password' ;";
  $result = $conn->query($q);
  if ($result->num_rows > 0) {
    identify($email,$password,$conn);
  }else{
    $q="INSERT INTO pizzerie (nome, via, numCivico, CAP, telefono, email, password, iva) VALUES (
    '$nome',
    '$via',
    '$numCivico',
    '$CAP',
    '$telefono',
    '$email',
    '$password',
    '$iva' );";
    $conn->query($q);
    identify($email,$password,$conn);

  }
}

/*************************************************************************************************************************/

function identify($email,$password,$conn){



  $q = "SELECT * FROM `user` WHERE email= '$email' AND password = '$password' ;";
  $result = $conn->query($q);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION["user"]=$row["email"];
    $_SESSION["psw"]=$row["password"];
    header("location: user/main.php");

  }else{

    $q = "SELECT * FROM `pizzerie` WHERE email= '$email' AND password = '$password' ;";
    $result = $conn->query($q);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION["upiz"]=$row["IDpiz"];
      $_SESSION["psw"]=$row["password"];
      header("location: pizzside/orders.php");
    }

  }
}
$conn->close();

?>

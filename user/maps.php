<?php
session_start();
if(empty($_SESSION["user"]) || empty($_SESSION["psw"])) {
	header("location:../index.php");
}
?>
<html lang="it">
<head>
	<title>Mappa delle pizzerie</title>
	<style>
 #titolo{
  background-color: #2b2b2b;
  margin-bottom: 0px;
}
</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="icon" href="../img/pizza.png" type="image/png" sizes="16x16">
<link rel="stylesheet" type="text/css" href="../css/base.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!--INSERT PRIVATE KEY FOR GOOGLE API, after key=... removed for privacy-->
<script src="https://maps.googleapis.com/maps/api/js?key="></script>

<?php

$conn = new mysqli("localhost","root","","my_buffersito");

if ($conn->connect_error){
  die("nr-".$conn->connect_errno." - ". $conn->connect_error);
}
$conn->select_db("my_buffersito") or die("die");

$q = "SELECT * FROM `pizzerie` ;";    
$result = $conn->query($q);

$i=0;
$address = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $nome[$i]= $row["nome"];
    $address[$i]= "via ".$row["via"].",".$row["numCivico"].",".$row["CAP"];
    $i++;
  }
}
?>

<script>
	var geocoder;
	var map;
	var address= "Clicca per info";
  var icon = {
    url: '../img/self.png', // url
    scaledSize: new google.maps.Size(40, 40), // scaled size  
  };
  


  function showPosition(position){

    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    map.setCenter(latlng);
    map.setZoom(15);

    
    var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title:address,
      icon: icon
    });

    var infowindow = new google.maps.InfoWindow(
      { content: '<b>'+'Yourself'+'</b>',
      size: new google.maps.Size(150,50)
    });
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
    google.maps.event.addListener(marker,'click',function() {
      map.setZoom(17);
      map.setCenter(marker.getPosition());
    });
  }


  //inizializza mappa
  function initialize() {
    
    geocoder = new google.maps.Geocoder();

    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
    	zoom: 14,
      center: latlng,
      mapTypeControl: true,
      mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU, },
      navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

    <?php
    for ($j=0; $j <$i ; $j++) { 

    	echo "
      if (geocoder) {
       geocoder.geocode( { 'address': '$address[$j]' }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
         if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {

          

          var infowindow = new google.maps.InfoWindow(
            { content: '<b>'+'$nome[$j]'+'</b>',
            size: new google.maps.Size(150,50)
          });

          var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map, 
            title:address
          });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
          });
          google.maps.event.addListener(marker,'click',function() {
            map.setZoom(17);
            map.setCenter(marker.getPosition());
          });

        }
      }
    });
  }
  ";
}

?>
if (navigator.geolocation) {

  navigator.geolocation.getCurrentPosition(showPosition);
}
  }//end inizialize

    //USCITA
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
 </script>


</head>

<body style="margin:0px; padding:0px;" onload="initialize()">

  <nav class="navbar navbar-expand-lg navbar-dark justify-content-between" id="titolo">
    
    <a class="navbar-brand" href="main.php">Lista pizzerie</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="maps.php" style="color: #2b699b">Mappa pizzerie</a>
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



  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
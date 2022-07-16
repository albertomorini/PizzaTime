<?php

session_start();

?>

<!DOCTYPE html>

<html lang="it">



<head>
  <title>Pizza Time</title>
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <link href="css/accesso.css" rel="stylesheet" type="text/css">
  <link rel="icon" href="img/pizza.png" type="image/png" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</head>



<body>



  <header>

    <h1>Pizza Time</h1>

  </header>



  <div id="contenitorebtn">

    <button type="button" class="btn btn-light" id="btnaccedi">Accedi</button>

    <button type="button" class="btn btn-light" id="btnregistrati">Registrati</button>

  </div>



  <!--/***********ACCESSO***************\-->

  <div class="conenuto" id="accedi">

    <h3>Accedi</h3>

    <hr>

    <form action="prendi.php" method="POST">

      <div class="form-group">

        <label for="emailogin">Indirizzo email: </label>

        <input type="email" class="form-control" name="emailogin" id="emailogin" placeholder="Inserisci la email" required>



      </div>

      <div class="form-group">

        <label for="pswlog">Password: </label>

        <input type="password" class="form-control" name="pswlog" id="pswlog" placeholder="Inserisci la password" required>

      </div>



      <button type="submit" class="btn btn-primary" style="background-color: #365482; width: 100%">Accedi</button>

    </form>

  </div>



  <!--/***********REGISTRAZIONE UTENTE & PIZZERIA***************\-->



  <div class="conenuto" id="registrati">



    <h3>Registrati</h3>

    <hr>

    <!--SWITCHING-->

    <label id="pizzeria">Sei una pizzeria?</label>

    <div>



      <label class="switch">

        <input type="checkbox" id="checkpizzeria">

        <span class="slider round"></span>

      </label>

    </div>

    <!--FORM REGISTRAZIONE UTENTE-->

    <nav>

      <form action="prendi.php" method="post" id="RegUtente">



        <div class="form-group">

          <label for="nameregister">Nome: </label>

          <input type="text" class="form-control" name="nameregister" id="nameregister" placeholder="Inserisci il nome" required>

        </div>

        <div class="form-group">

          <label for="surnameregister">Cognome: </label>

          <input type="text" class="form-control" name="surnameregister" id="surnameregister" placeholder="Inserisci il cognome" required >



        </div>

        <div class="form-group">

          <label for="numeroTel">Telefono: </label>

          <input type="number" class="form-control" name="numeroTel" id="numeroTel" placeholder="Inserisci il numero di telefono" required >



        </div>

        <div class="form-group">

          <label for="emailregister">Indirizzo email: </label>

          <input type="email" class="form-control" name="emailregister" id="emailregister" placeholder="Inserisci la email" required>



        </div>

        <div class="form-group">

          <label for="passwordregister">Password: </label>

          <input type="password" class="form-control" name="passwordregister" id="passwordregister" placeholder="Inserisci la password" required>

        </div>





        <button type="submit" class="btn btn-primary" style="background-color: #365482; width: 100%; ">Registrati</button>

      </form>

    </nav>

    <!--FORM REGISTRAZIONE PIZZERIA-->

    <nav>

      <form action="prendi.php" method="post" id="RegPizzeria">
        <div class="form-group">

          <label for="nomepizzeria">Nome della pizzeria: </label>

          <input type="text" class="form-control" name="nomepizzeria" id="nomepizzeria" placeholder="Nome della pizzeria" required>

        </div>

        <div class="form-group">

          <label for="viapizzeria">Via in cui si trova: </label>

          <input type="text" class="form-control" name="viapizzeria" id="viapizzeria" placeholder="Via" required >



        </div>

        <div class="col-xs-6" style="margin-left: -15px;">

          <input type="number" class="form-control" name="numCivico" id="numCivico" placeholder="Num civico" required >
        </div>

        <div class="col-xs-6">
         <input type="number" class="form-control" name="CAP" id="CAP" placeholder="CAP"  required>

       </div>

       <br>
       <hr>



       <div class="form-group">

        <label for="numeroTelPiz">Telefono: </label>

        <input type="number" class="form-control" name="numeroTelPiz" id="numeroTelPiz" placeholder="Numero di telefono" required >

      </div>

      <div class="form-group">

        <label for="emailpizzeria">Indirizzo email: </label>

        <input type="email" class="form-control" name="emailpizzeria" id="emailpizzeria" placeholder="Inserisci la email" required>
      </div>


      <div class="form-group">

        <label for="passwordpizzeria">Password: </label>

        <input type="password" class="form-control" name="passwordpizzeria" id="passwordpizzeria" placeholder="Inserisci la tua password" required>

      </div>



      <div class="form-group">

        <label for="numeroIVA">Numero partita IVA: </label>

        <input type="number" class="form-control" name="numeroIVA" id="numeroIVA" placeholder="Inserisci il numero di partita IVA" required >

      </div>





      <button type="submit" class="btn btn-primary" style="background-color: #365482; width: 100%">Registrati</button>

    </form>

  </nav>



</div>

<footer>

  <p> Developed by Morini Alberto ||

    <a href="mailto:alberto.morini@iisvittorioveneto.it">alberto.morini@iisvittorioveneto.it</a>

  </p>

</footer>


<script>

  var i = false;



  $(document).ready(function() {

    $("#registrati").hide();

    document.getElementById('btnaccedi').style.color = "#6a85ba";

    $("#RegPizzeria").hide();

    init();

  });



  function reg() {



    $("#registrati").show();



    $("#accedi").hide();



    document.getElementById('btnregistrati').style.color = "#6a85ba";

    document.getElementById('btnaccedi').style.color = "black";

  }



  function acc() {

    $("#registrati").hide();

    $("#accedi").show();





    document.getElementById('btnregistrati').style.color = "black";

    document.getElementById('btnaccedi').style.color = "#6a85ba";

  }



  function piz() {



    if (i == false) {

      $("#RegUtente").hide();

      $("#RegPizzeria").show();

      i = true;

    } else {

      $("#RegUtente").show();

      $("#RegPizzeria").hide();

      i = false;

    }



  }





  function init() {

    $("#btnaccedi").click(acc);

    $("#btnregistrati").click(reg);

    $("#checkpizzeria").click(piz);



  }

</script>

</body>

</html>

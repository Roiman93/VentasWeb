<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página sistema facturacion">

    <!--framework semantic-->
    <link rel="preload" href="css/semantic.min.css" as="style">
    <link rel="stylesheet" href="css/semantic.min.css">
    
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
    <script src="css/semantic.min.js"></script>
    <!--fin-->

    <!--  Hojas de estylo-->
    <link rel="preload" href="css/styl.css" as="style">
    <link rel="stylesheet" href="css/styl.css">
    <!--fin-->

    <!--Fuentes-->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap"  crossorigin="crossorigin" as="font">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!--fin-->  
    <title>Sistema de Facturacion</title>
    
</head>
<body>
  
<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<p></p>

<div class="ui fluid three button stackable">
  
  <button class="massive red ui button">
    <i class="shopping black cart icon"></i>
    Ventas Dia $: <?php 

     print( number_format(($dato[0]->total), 2, ".", ".")
     );


       ?>
    

  </button> 
  
  <button class="massive red ui button">
  <i class="tags black icon"></i>
    Productos Registrados <?php print($dt[0]->numero)   ?>
  </button> 

  <button class="massive red ui button">
  <i class="handshake black icon"></i>
    Provedores <?php print($prv[0]->numero)  ?>
  </button> 


</div>
<p></p>
<p></p>
<p></p>
<div class="ui segmen">
    <h2 class="ui centered header">Bienvenido!</h2>
    <h3 class="ui centered header">Esperamos que ésta empresa
        se convierta en tu hogar durante
        muchos años y nos veas a todos como
        una segunda familia.<h3/>
</div>


</body>

<!-- <script type="text/javascript" src="js/fx.js" ></script> -->
<script type="text/javascript" src="js/Configuracion.js"></script>


</html>
<?php

include "modelo/cn.php";

 ?>


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

   
    <title>Listado Facturas</title>

</head>
<body >

  <?php include 'recursos/menu1.php'; ?>
  <?php include 'recursos/menu.php';  ?>  
  <div class="ui hidden divider"></div>



<div class="ui very relax container m-a-70-m-b-70 ">

    <div class="ui  segmen">
        <h4 class="ui  header">Listado de Facturas</h4>
    </div>
    <div class="ui secondary segment">
      <div class="ui stackable  form">
        <div class="fields">
          <div class="field">
            <label>No Factura</label>
            <div class="ui icon input">
              <input type="text"   name="nofactura" id="txt_nofact" placeholder="Buscar..." onkeypress="return valideKey(event);" >
              <i class="inverted circular search link icon" type="submit" onclick="Buscar();" id="btn_buscar_fact" ></i>
            </div>
          </div>

          <div class="field">
            <label>Fecha Inicial </label>
            <input type="date" name="fecha_de" id="fecha_de" required>   
          </div>

          <div class="field">
            <label>Fecha Final</label>
            <input type="date" name="fecha_a" id="fecha_a" required> 
          </div>

          <div class="field">
          
            <button style="margin-top: 26px;"   id="btn_buscar_fecha" type="submit" class="ui green button"><i class="inverted search link icon"></i></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- style="margin-top: 22px;" -->


      <!-- tabla de Registros -->
      <div id="div1">
        <table class="ui very compact  small  table">
          <thead>
            <tr class="ui inverted table">
              <th> <h5 class=" ui header" style="color:#ffff" scope="col">Factura No</h5></th>
              <th> <h5 class=" ui header" style="color:#ffff" scope="col">fecha / Hora</h5></th>
              <th> <h5 class=" ui header" style="color:#ffff" scope="col">Cliente</h5></th>
              <th> <h5 class=" ui header" style="color:#ffff" scope="col">Vendedor</h5></th>
              <th> <h5 class=" ui header" style="color:#ffff" scope="col">Estado</h5></th>
              <th class="textright"> <h5 class=" ui header" style="color:#ffff" scope="col">Total Factura</h5></th>
              <th class="textright"> <h5 class=" ui header" style="color:#ffff" scope="col">Acciones</h5></th>
            </tr>
          </thead>
          <tbody id="detalle_factura">
          <!-- Tabla ajax -->
        </tbody>
        </table>
      </dive>

      
              
      <!-- fin -->
      <div class="ui hidden divider"></div>



</body>
<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_LIista_Ventas.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>





</html>    
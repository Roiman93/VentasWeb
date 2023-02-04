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

   
    <title>Registros de Compras</title>



</head>

<body >

  <?php include 'recursos/menu1.php'; ?>
  <?php include 'recursos/menu.php';  ?>  
  <div class="ui hidden divider"></div>

  <div class="ui very relax container m-a-70-m-b-70 ">

    <div class="ui segmen">
        <h3 class="ui header"> Listado de Compras</h3>
    </div>
    <div class="ui secondary segment">
      <div class="ui stackable  form">
        <div class="fields">
          <div class="field">
            <label>No Factura</label>
            <div class="ui icon input">
              <input type="text"   name="nofactura" id="txt_nofact" placeholder="Buscar..." >
              <i class="inverted circular search link icon" type="submit" onclick="Buscar();" id="btn_buscar_fact" ></i>
            </div>
          </div>

            <div class="field">
              <label>Fecha Inicial</label>
              <input type="date" name="fecha_de" id="fecha_de" required>   
            </div>

            <div class="field">
              <label>Fecha Final</label>
              <input type="date" name="fecha_a" id="fecha_a" required> 
            </div>

          <div class="field">
          
          <button style="margin-top: 26px;" onclick="Buscar_Fecha();"  id="btn_buscar_compra_fecha" type="submit" class="ui green button"><i class="inverted search link icon"></i></button>
          </div>
        </div>
      </div>
    </div>
    <!-- fin -->

 

      <!-- tabla de Registros -->
      <div id="div1">
      <table class="ui small table">
        <thead>
          <tr class="ui inverted table">
            <th>No</th>
            <th>fecha / Hora</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th>Estado</th>
            <th class="textright">Total Factura</th>
            <th class="textright">Acciones</th>
          </tr>
        </thead>
        <tbody id="detalle_compras">
        <!-- Tabla ajax -->
        </tbody>
      </table>     
      <!-- fin -->
      </div>
      <div class="ui hidden divider"></div>
     
      
</div>


</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_Compras.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>





</html>    
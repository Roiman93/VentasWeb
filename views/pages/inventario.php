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
    <title>Formulario Inventario</title>
    
</head>
<body>


<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>


<div class="ui very relax container m-a-70-m-b-70 ">


  <!-- Formulario buesqueda inventario -->

  <div class="ui secondary segment">
  <h4 class="ui dividing header">Informe Inventario</h4> 
        <div class="ui stackable  form">
          <div class="fields">
            <div class="field">

              <label>Buscar</label>
              <div class="ui  icon input">
                <input type="text" id="txt_buscar" placeholder="Buscar...">
                <i id="btn_buscar" onclick=" Buscar_inventario();" class=" circular search link icon"></i>
              </div>
            
            </div>

            <div class="field">
              <label>Filtro</label>
              <select class="ui fluid search dropdown" id="filtro" name="">
                  <option value="1">Codigo</option>
                  <option value="2">Nombre</option>
              </select>
            </div>

          </div>
        </div>
  </div>

<!-- fin -->



<!-- Registros -->
<div id="div1">
  <table class="ui striped table">
    <thead>
      <tr class="ui inverted table">
        <th><h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5></th>
        <th><h5 class=" ui header" style="color:#ffff" scope="col">Nombre</h5></th>
        <th><h5 class=" ui header" style="color:#ffff" scope="col">Precio venta</h5></th>
        <th  class="center aligned" ><h5 class=" ui header" style="color:#ffff" scope="col">Entrada</h5></th>
        <th class="center aligned" ><h5 class=" ui header" style="color:#ffff" scope="col">Salida</h5></th>
        <th class="center aligned" ><h5 class=" ui header" style="color:#ffff" scope="col">Stock</h5></th>
      </tr>
    </thead>
    <tbody id="detalle_invent">
    <!-- ajax -->
    </tbody>
  </table>
</div>      
<!-- fin -->

<div class="ui divider"></div>
 




</div>
</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_Inventario.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>


</html>
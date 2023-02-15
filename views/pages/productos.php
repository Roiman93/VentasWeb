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
    <title>Formulario Productos</title>
    
</head>
<body>

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">
     

   

    <!-- Formulario  -->
  
    <div class="ui secondary segment">  
    <div class="ui form">
          <h4 class="ui dividing header">Registro de Productos</h4> 
          
            <div class="equal width  fields">
          
              <div class="field">
                <label>Codigo</label>
                <!-- <input  onkeypress="return valideKey(event);"   id="codigo" name="codigo"  type="number" placeholder="Codigo del Producto" > -->
                <input type="text" id="codigo" name="codigo" placeholder="Codigo del Producto" onkeypress="return valideKey(event);" >
              </div>

              <div class="field">
                <label> Nombre</label>
                <input name="nombre" id="nombre" placeholder="Nombre del producto" type="text">
              </div>

              <div class="field">
                <label>Tipo</label>

                <select name="tipo" id="tipo" class="ui fluid search dropdown" name="">
                        <option value="1">Und</option>
                        <option value="2">Caja</option>       
                </select>
              </div>

              <div class="field">
                <label>Precio de Compra</label> 
                <input name="precio_c" id="precio_c" placeholder="Precio de Compra" type="text" onkeypress="return valideKey(event);">
              </div>

              <div class="field">
                <label>Precio de Venta</label>
                <input name="precio_v" id="precio_v" placeholder="Precio de venta por unidad" type="text" onkeypress="return valideKey(event);">
              </div>

            </div>
            <input class="ui green button" onclick="Guardar();" type="submit" id="btn_mod_cliente" value="Guardar">
            <a class="ui blue button" href="?opcion=List_Producto"><i class="search icon"></i><label>Buscar</label></a>
            <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="cancelar" >

    </div>
    </div>





        
<!-- fin -->
<div class="ui divider"></div>
 




</div>
</body>


<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_Productos.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>


</html>
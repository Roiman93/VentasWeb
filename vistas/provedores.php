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
    <title>Formulario Provedores</title>
    
</head>
<body>


<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>


  <div class="ui very relax container m-a-70-m-b-70 ">

    <!-- Formulario Provedores -->

    <div class="ui secondary segment">  
    
        <div class="ui form">
                    <h4 class="ui dividing header">Registro Proveedores</h4> 
                  
                      <div class="equal width  fields">
                    
                        <div class="eight wide field">
                          <label>Nit</label>
                          <input  type="text" id="nit" placeholder=" Ingrese su Nit"  onkeypress="return valideKey(event);">
                          
                        </div>
                        
                        <div  class="two wide field">
                        <label>#</label>
                          <input type="text"  id="digito" minlength="1" maxlength="1" onkeypress="return valideKey(event);">
                          
                        </div>

                        <div  class="field">
                          <label>Razon social</label>
                          <input type="text" name="nombre" id="nombre" placeholder="Nombre de la Empresa" >
                        </div>

                        <div class="field">
                          <label>Direccion</label>
                          <input type="text" id="direccion"  name="direccion"  placeholder="Direccion cll # 0 - 0 br." type="text" >
                        </div>

                        <div class="eight wide field">
                          <label>Telefono</label>
                          <input type="text" id="telefono" name="telefono" placeholder="Telefono" type="text" onkeypress="return valideKey(event);">
                        </div>
                      
                      </div>
                      <input class="ui green button" onclick="Guardar();" type="submit"  value="Guardar">
                      <a style="cursor:pointer" class="ui blue button" href="?opcion=List_Proveedor"><i class="search icon"></i><label>Buscar</label></a>
                      <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >

        </div> 

    </div>

    <div class="ui hidden divider"></div>
  

  </div>

</body>
<script type="text/javascript" src="js/Configuracion.js"></script>
<script type="text/javascript" src="js/Funciones_Proveedor.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>
<script>
  $('.ui.icon')
  .popup({
    inline: true
  });
</script>



</html>
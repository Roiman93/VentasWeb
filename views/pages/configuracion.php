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

    <title>Configuracion</title>
    
</head>
<body>

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 

<div class="ui very relax stackable container m-a-70-m-b-70 ">
<div class="ui hidden divider"></div>


<!-- Formulario clientes -->

  <?php if(isset($_GET['edit'])){?>


    <div class="ui secondary segment">  
    <div class="ui  form">
          <h4 class="ui dividing header">Datos de la Empresa</h4> 
          <input type="hidden" id="id" name="id" value="<?php print $datoE[0]->id_config;?>">
            <div class="equal width  fields">
          
              <div class="ui field">
                    <label>Nit</label>
                    <input  type="text" id="nit" placeholder=" Ingrese su Nit" value="<?php print $datoE[0]->nit;?>" onkeypress="return valideKey(event);">
                    
               </div>

              <div  class="five wide field">
                  <label>#</label>
                    <input type="text"  id="digito" minlength="1" maxlength="1" value="<?php print $datoE[0]->dg;?>" onkeypress="return valideKey(event);"> 
              </div>

              <div class=" field">
                <label>Razon social</label>
                <input placeholder="Razon Social" id="nombre" name="nombre" type="text" value="<?php print $datoE[0]->nombre; ?>"> 
              </div>

              <div class="field">
                <label>Direcciòn</label>
                <input placeholder="Calle 00 # 1-00 br.---" id="direccion" type="text" value="<?php print $datoE[0]->direccion; ?>">
              </div>

              <div class=" field">
              <label>Telefono</label>
              <input placeholder="Telefono" id="telefono" type="text" value="<?php print $datoE[0]->telefono; ?>" onkeypress="return valideKey(event);">
              </div>
              <div class=" field">
                <label>Email</label>
                <input placeholder="Email" id="email" type="text" value="<?php print $datoE[0]->email; ?>">
              </div>

              <div class="field">
                <label>Iva %</label>
                <input placeholder="Iva 19% " type="text" id="iva" name="iva"  value="<?php print $datoE[0]->iva; ?>" onkeypress="return valideKey(event);">
              </div>
            </div>
           
                        
            <input class="ui green button" onclick="Modificar();" type="submit" id="btn_mod_cliente" value="Modificar">
            <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >

    </div>
 </div>      

<!-- fin -->
 
 <!-- <form class="ui form" name="x32" method="post" enctype="multipart/form-data" action="?opcion=hidden">
    <input type="hidden" name="Modelo" value= "configuracion">
    <input type="hidden" name="opcion" value= "mod_config">
    <input type="hidden" name="goto" value="?opcion=vista_config"> -->
 




<?php }else{?>


  <div class="ui secondary segment">  
    <div class="ui form">
          <h4 class="ui dividing header">Datos de la Empresa</h4> 
          
            <div class="equal width  fields">
          
              <div class="ui field">
                <label>Nit</label>
                <input type="text" name="nit" id="nit"  placeholder="Nit"  onkeypress="return valideKey(event);" >
              </div>

              <div  class="five wide field">
                <label>#</label>
                <input type="text"  id="digito" minlength="1" maxlength="1" onkeypress="return valideKey(event);">
                    
              </div>

              <div class="field">
                <label>Razon social</label>
                <input placeholder="Razon Social" id="nombre" name="nombre" type="text" > 
              </div>

              <div class="field">
                <label>Direcciòn</label>
                <input placeholder="Calle 00 # 1-00 br.---" id="direccion" type="text" >
              </div>

              <div class="field">
                <label>Telefono</label>
                <input placeholder="Telefono" id="telefono" type="text"  onkeypress="return valideKey(event);">
              </div>

              <div class="field">
                <label>Email</label>
                <input placeholder="Email" id="email" type="text" >
              </div>
              <div class="field">
                <label>Iva %</label>
                <input placeholder="Iva 19% " type="text" id="iva" name="iva" onkeypress="return valideKey(event);">
              </div>

            </div>
          
             
           

           
            <input class="ui green button" onclick="Guardar();" type="submit" id="btn_mod_cliente" value="Guardar">
            <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >

    </div>
 </div>      

<!-- fin -->

<!-- <form class="ui form" name="x32" style="margin: auto 50px auto 50px;" method="post" enctype="multipart/form-data" action="?opcion=hidden">
    <input type="hidden" name="Modelo" value="configuracion">
    <input type="hidden" name="opcion" value="guardar">
    <input type="hidden" name="goto" value="?opcion=vista_config">


</form> -->

<!-- fin -->

<?php }?>


<!-- Registros -->
<table class="ui small table">
  <thead>
    <tr class="ui inverted table">
      <th>Nit</th>
      <th>Razon social</th>
      <th>Direcciòn</th>
      <th>Telefono</th>
      <th>Correo Electronico</th>
      
      <th>Iva</th>
     
      <th>Acciones</th>


    </tr>
  </thead>
  <tbody>
    <tr>

       <?php
          $x = 1;
             # ciclo para mostar contenido
              foreach ($dato as $dt): 

               ?>
      <td><?php print"".$dt->nit."-".$dt->dg."</td>";?>
      <td><?php print"".$dt->nombre."</td>";?>
      <td><?php print"".$dt->direccion."</td>";?>
      <td><?php print"".$dt->telefono."</td>";?>
      <td><?php print"".$dt->email."</td>";?>
      <td><?php print"".$dt->iva."</td>";?>
      <td> <?php print"  <a onclick=validarEdit('?opcion=vista_config&edit=".$dt->id_config."')>"?>
      <div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>

      <?php print " <a onclick=validarDel('?opcion=delconfig&edit=".$dt->id_config."') >"?>
      <div class="ui small icon button" data-content="Eliminar"><i class=" red trash icon"></i></div></a></td>


    </tr>
   
  </tbody>
     <?php
           endforeach;
           ?>
</table>
        
<!-- fin -->
<div class="ui divider"></div>
 




</div>
</body>

<!-- <script type="text/javascript" src="js/fx.js" ></script> -->
<script type="text/javascript" src="js/Funciones_Configuracion.js"></script>
<script type="text/javascript" src="js/Configuracion.js"></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>
<script>
  $('.ui.icon')
  .popup({
    inline: true
  });
</script>


</html>
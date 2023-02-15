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
    <title>Usuarios</title>
    
</head>
<body >

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>


<div class="ui very relax container m-a-70-m-b-70 ">
<!-- Formulario clientes -->

   <?php if(isset($_GET['edit'])){?>


    <div class="ui secondary segment">  
   
   <div class="ui form">
               <h4 class="ui dividing header">Registro Usuario</h4> 
               <input type="hidden" name="id_usuario" id="id_usuario" value="<?php print $datoE[0]->id_usuario; ?>">
             
                 <div class="equal width  fields">
               
                   <div class="eight wide field">
                     <label>Cedula</label>
                     <input  type="text" id="cedula" placeholder="Identificaciòn" value="<?php print $datoE[0]->identificacion; ?>"  onkeypress="return valideKey(event);">
                     
                   </div>
                   
                   <div  class="field">
                   <label>Nombre</label>
                     <input type="text"  id="nombre" placeholder="Nombres" value="<?php print $datoE[0]->nombre;?>">
                     
                   </div>
 
                   <div  class="field">
                     <label>Apellidos</label>
                     <input type="text" name="apellido" id="apellido" placeholder="Apellidos" value="<?php print $datoE[0]->apellido;?>" >
                   </div>
 
                   <div class="field">
                     <label>Correo</label>
                     <input type="text" id="correo"  name="correo"  placeholder="Correo Electronico" type="text" value="<?php print $datoE[0]->email; ?>" >
                   </div>
 
                 
                   <div class="eight wide field">
                     <label>Rol</label>

                      <select class="ui fluid search dropdown" id="id_tipo"  name="id_tipo">
                        <?php 
                              foreach($tipo as $tp){
                                print "<option value='".$tp->usuario_tipo."'>".$tp->tipo."</option>";
                              }
                            ?>
                      </select>
                     
                   </div>
                   <div class="field">
                     <label>Contraseña</label>
                     <input type="text" id="pass" name="pass" placeholder="Telefono" type="text" >
                   </div>
                 
                 </div>
                 <input class="ui green button" onclick="Modificar();" type="submit"  value="Modificar">
                 <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >
 
      </div> 
 
   </div>


<!-- fin -->

     
  

   <?php }else{?>

  <div class="ui secondary segment">  
   
   <div class="ui form">
               <h4 class="ui dividing header">Registro Usuario</h4> 
             
                 <div class="equal width  fields">
               
                   <div class="eight wide field">
                     <label>Cedula</label>
                     <input  type="text" id="cedula" placeholder="Identificaciòn"  onkeypress="return valideKey(event);">
                     
                   </div>
                   
                   <div  class="field">
                   <label>Nombre</label>
                     <input type="text"  id="nombre" placeholder="Nombres">
                     
                   </div>
 
                   <div  class="field">
                     <label>Apellidos</label>
                     <input type="text" name="apellido" id="apellido" placeholder="Apellidos" >
                   </div>
 
                   <div class="field">
                     <label>Correo</label>
                     <input type="text" id="correo"  name="correo"  placeholder="Correo Electronico" type="text" >
                   </div>
 
                   <div class="eight wide field">
                     <label>Telefono</label>
                     <input type="text" id="telefono" name="telefono" placeholder="Telefono" type="text" onkeypress="return valideKey(event);">
                   </div>
                   <div class="eight wide field">
                     <label>Rol</label>

                      <select class="ui fluid search dropdown" id="id_tipo"  name="id_tipo">
                        <?php 
                              foreach($tipo as $tp){
                                print "<option value='".$tp->usuario_tipo."'>".$tp->tipo."</option>";
                              }
                            ?>
                      </select>
                     
                   </div>
                   <div class="field">
                     <label>Contraseña</label>
                     <input type="text" id="pass" name="pass" placeholder="Digite una Contraseña" type="text" onkeypress="return valideKey(event);">
                   </div>
                 
                 </div>
                 <input class="ui green button" onclick="Guardar();" type="submit"  value="Guardar">
                 <input onclick="cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >
 
      </div> 
 
   </div>

<!-- fin -->


   <?php }?>


<!-- Tabla de Registros -->
<table class="ui striped table">
  <thead>
    <tr class="ui inverted table">
      <th>Identificacion</th>
      <th>Correo</th>
      <th>Nombre Completo</th>
      <th>Rol</th>
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
      <td><?php print"".$dt->identificacion."</td>";?>
      <td><?php print"".$dt->email."</td>";?>
      <td><?php print"".$dt->nombre." ".$dt->apellido."</td>";?>
      <td><?php print"".$dt->tipo."</td>";?>
      <td> <?php print"  <a onclick=validarEdit('?opcion=usuarios&edit=".$dt->id_usuario."')>"?>
      <div class="ui small icon button" data-content="Editar"><i class=" blue edit icon"></i></div></a>
      <?php print " <a onclick=validarDel('?opcion=delusuario&edit=".$dt->id_usuario."') >"?>
      <div class="ui small icon button" data-content="Eliminar Resolucion"><i class=" red trash icon"></i></div></a></td>

    </tr>
   
  </tbody>
  <?php
         endforeach;
         ?>
</table>
        
<!-- fin -->
<div class="ui divider"></div>
  
  <?php if(isset($_SESSION['error'])){ ?>
   <div class="ui visible message">
    <p> <?php print $_SESSION['error'];  unset($_SESSION['error']); ?></p>
   </div>
  <?php } ?>




  </div>
</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>  
<script type="text/javascript" src="js/Funciones_Usuario.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>
<script>
  $('.ui.icon')
  .popup({
    inline: true
  });
</script>


</html>
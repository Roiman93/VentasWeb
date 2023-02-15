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
    <title>Resolucion de facturaciòn</title>
    
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
               <h4 class="ui dividing header">Resolucion de Facturaciòn</h4> 
               <input type="hidden"  id="id" value="<?php print $datoE[0]->id; ?>">
             
                 <div class="equal width  fields">
               
                   <div class=" field">
                     <label>Prefijo</label>
                     <input  type="text" id="prefijo" placeholder="FACT" value="<?php print $datoE[0]->prefijo; ?>" >
                     
                   </div>
                   
                   <div  class="field">
                   <label>Numero de Inicio</label>
                     <input type="text"  id="n_inicio" placeholder=" Ejemplo 1 " value="<?php print $datoE[0]->n_inicio;?>" onkeypress="return valideKey(event);">
                     
                   </div>
 
                   <div  class="field">
                     <label>Numero Final</label>
                     <input type="text" name="n_final" id="n_final" placeholder="Numero Final" value="<?php print $datoE[0]->n_final;?>"onkeypress="return valideKey(event);" >
                   </div>
 
                   <div class="field">
                     <label>Numero de Resoluciòn</label>
                     <input type="text" id="resolucion"  name="resolucion"  placeholder="Numero de Resoluciòn" type="text" value="<?php print $datoE[0]->n_resolucion; ?>" >
                   </div>

                   <div class="field">
                     <label>Fecha de Resoluciòn</label>
                     <input type="date" id="fecha"  name="resolucion"  type="text" value="<?php print $datoE[0]->fecha_resolucion; ?>" >
                   </div>
 
                 
                   <div class="field">
                     <label>Tipo de Docuemnto</label>

                      <select class="ui fluid search dropdown" id="id_tipo"  name="id_tipo">
                        <option value="1">Factura Venta</option>
                        <!-- <option value="2">Factura Compra</option> -->
                      </select>
                     
                   </div>
            
                 
                 </div>
                 <input class="ui green button" onclick="Modificar();" type="submit"  value="Modificar">
                 <input onclick="Cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >
 
      </div> 
 
   </div>


<!-- fin -->

   <?php }else{?>

  <div class="ui secondary segment">  
   
    <div class="ui form">
               <h4 class="ui dividing header">Resolucion de Facturaciòn</h4> 
             
                 <div class="equal width  fields">
               
                   <div class="field">
                     <label>Prefijo</label>
                     <input  type="text" id="prefijo" placeholder="FACT">
                     
                   </div>
                   
                   <div  class="field">
                   <label>Numero de Inicio</label>
                     <input type="text"  id="n_inicio" placeholder="1"  onkeypress="return valideKey(event);">
                     
                   </div>
 
                   <div  class="field">
                     <label>Numero Final</label>
                     <input type="text" name="n_final" id="n_final" placeholder="1500" onkeypress="return valideKey(event);" >
                   </div>
 
                   <div class="field">
                     <label>Numero de Resoluciòn</label>
                     <input type="text" id="resolucion"  name="resolucion"  placeholder="001122334455" type="text" >
                   </div>

                   <div class="field">
                     <label>Fecha de Resoluciòn</label>
                     <input type="date" id="fecha"    type="text">
                   </div>
 
                 
                   <div class="field">
                     <label>Tipo de Docuemnto</label>

                      <select class="ui fluid search dropdown" id="id_tipo"  name="id_tipo">
                        <option value="1">Factura Venta</option>
                        <!-- <option value="2">Factura Compra</option> -->
                      </select>
                     
                   </div>
            
                 
                 </div>
                 <input class="ui green button" onclick="Guardar();" type="submit"  value="Guardar">
                 <input onclick="Cancelar();" class="ui  button" type="submit" id="btn_cancelar" value="Cancelar" >
 
    </div> 
   </div>

<!-- fin -->


   <?php }?>


<!-- Tabla de Registros -->
<table class="ui striped table">
  <thead>
    <tr class="ui small inverted table">
      <th>Tipo Documento</th>
      <th>Prefijo</th>
      <th>Numero Inicio</th>
      <th>Numero Final</th>
      <th>Numero de Resoluciòn</th>
      <th>Fecha de Resoluciòn</th>
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
      <td>
          <?php

            if ($dt->tipo_documento == 1){
                $estado = '<span class="pagada">Factura Venta</span>';
            }else if($dt->tipo_documento == 2){
                $estado = '<span class="Fcompra">Factura Compra</span>';
            }

       print $estado;
          ?> </td>        
      <td><?php print"".$dt->prefijo."</td>";?>
      <td><?php print"".$dt->n_inicio."</td>";?>
      <td><?php print"".$dt->n_final."</td>";?>
      <td><?php print"".$dt->n_resolucion."</td>";?>
      <td><?php print"".$dt->fecha_resolucion."</td>";?>
      <td> 
          <?php print"  <a  style='cursor: pointer;' onclick=validarEdit('?opcion=Resolucion&edit=".$dt->id."')>"?>
          <div class="ui small icon button" data-content="Editar Resolucion"><i class=" blue edit icon"></i></div></a> 
          <?php print " <a  style='cursor: pointer;' onclick=ValidarRemove(fac=".$dt->id.") >"?> 
          <div class="ui small icon button" data-content="Eliminar Resolucion"><i class=" red trash icon"></i></div></a>
        <?php 
            if ($dt->estado == 1){
                    $est = '<a style="cursor: pointer;" onclick=ValidarDesact(fac="'.$dt->id.'")>
                    <div class="ui small icon button" data-content="Desactivar Resolucion"><i class="eye  red slash icon"></i></div></a>'; 
                    
                }else if($dt->estado == 2){
                    $est ='<a style="cursor: pointer;" onclick=ValidarAct(fac="'.$dt->id.'") > 
                    <div class="ui small icon button" data-content="Ativar Resolucion"><i class="eye  blue icon" ></i></div></a>'; 
                }else{
                    $est ='<a style="cursor: pointer;"  onclick=ValidarAct(fac="'.$dt->id.'")>
                    <div class="ui small icon button" data-content="Ativar Resolucion"><i class="eye  blue icon" ></i></div></a>'; 
                }
             print $est;   
        ?>
        
        
         
          
          
      </td>
         
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

<script type="text/javascript" src="js/Configuracion.js" ></script>  
<script type="text/javascript" src="js/Funciones_Resolucion.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>
<script>
  $('.ui.icon')
  .popup({
    inline: true
  })
;
</script>


</html>
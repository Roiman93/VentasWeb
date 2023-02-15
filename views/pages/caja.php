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

    <title>Formulario Caja</title>
    
</head>
<body>

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>

<div class="ui very relax container m-a-70-m-b-70 ">

 <h4 class="ui  header">Cuadre de Caja Diario</h4>

   <!-- Formulario clientes -->
  <div class="ui  stackable large form ">
    <div class="ui secondary segment">
    <input type="hidden" name="" id="txt_id" value="<?php echo ($_SESSION['ih_id']); ?>">
      <div class="ui form">
      
          <div class="equal width  fields">
          
            <div class="six wide  field">
            <label>Selecione la Fecha</label>
              <input type="date" id="start" name="trip-start">
            </div>
             
            <div class="field">
            <div id="btn_buscar_cadre" style="margin-top: 25px;" onclick="BuscarCuadre();" class="ui green submit button"><i class="search icon"></i></div>
              
            </div>

            <div class="field">
              <label></label>
              <input type="hidden" id="txt_id" name="txt_id" value="<?php echo($_SESSION['ih_id']); ?>">
            </div>


            <div class="field">
              <label></label>
              <input type="hidden" id="tlt" name="txt_total">
            </div>

            <div class="field">
              <label>Saldo Total</label>
              <h2 name="total" id="lbl_total"></h2>
            </div>

          </div>
          
        </div>
    </div>

      <!-- <div class="ui  form">
          <div class="two fields">
            <div class="field">
              <label>Selecione la Fecha</label>
              <input type="date" id="start" name="trip-start">
            </div>
          </div>
          <div id="btn_buscar_cadre" class="ui green submit button">Buscar<i class="search icon"></i></div>
      </div> -->
      <!-- fin -->


      <div class="ui left floated green tertiary  compact segment">
        <h3 class="ui centered header">Acciones</h3>
        <div class="ui small basic icon buttons">
        
          <button id="btn_Cuadre_Caja" onclick="cuadre();" style="display:none;"  class="ui  button ">Generar Cuadre <i class="file  alternate icon"></i></button>
          <button id= "btn_cancelar" onclick="cancelar();" class="ui button">Cancelar <i class="window red close icon"></i></button>
              
        </div>
      </div>

      <div class="ui hidden divider"></div>

     
        <!-- <form class="ui form" name="x32" method="post" enctype="multipart/form-data" action="?opcion=hidden">
                  <input type="hidden" name="Modelo" value="caja">
                  <input type="hidden" name="opcion" value="registro_cuadre">
                  <input type="hidden" name="goto" value="?opcion=caja"> -->
        
            
     
          <!-- <button id="guardar_cuadre" class="ui green submit button" >Guardar</button>
          <button class="ui button" id= "btn_cancelar" >Cancelar</button> -->
        
       </div>
     
 
  <!-- fin -->



  <!-- Registros -->
  
  <table class="ui striped table" style="display: none;" >
    <thead>
      <tr class="ui inverted table">
        <th>No</th>
        <th>Fecha</th>
        <th>Valor</th>
        <th>Usuario</th>
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
              <td><?php print"$x";?></td>
              <td><?php print"".$dt->fecha."</td>";?></td>
              <td><?php print"".$dt->valor."</td>";?></td>
              <td><?php print"".$dt->usuario."</td>";?></td>
              <td><?php print " <a onclick=validarDel('?opcion=delcaja&edit=".$dt->id_caja."') >"?><i class="window big red close icon"></i></a></td>
      </tr>
    
    </tbody>
    <?php
            $x=$x+1;
            endforeach;
          ?>
  </table>        
  <!-- fin -->

 </div>  
</body>

<script type="text/javascript" src="js/Funciones_Caja.js" ></script>
<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>


</html>
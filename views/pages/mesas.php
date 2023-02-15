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
    <title>Mesas</title>
    
</head>
<body>

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>


<div class="ui very relax container m-a-70-m-b-70 ">
  <div class="ui segmen">
      <h3 class="ui  header">Mesas</h3>
      
  </div>

    <!-- Formulario mesas tmp -->

    <!-- <form>

           

                <h4 class="ui dividing header">Datos</h4> 
                <div class="two fields">
                </div>

                <div class="two fields">
                 
                  <div class="field">
                    <label>Cedula Cliente</label>
                    <input id="c_cliente" placeholder="No Cedula" type="text" onkeypress="return valideKey(event);" >
                  </div>
                  <input type="hidden" id="idcliente"   placeholder="id">

                </div>

                <div class="ui green submit button" onclick="BuscarCliente();">Buscar</div>



       
       <div class="ui  segmen">
        <h2 class="ui centered header">Acciones</h2>
      </div>
      <div class="ui hidden divider"></div>
     
    </form>   -->
        
        <!-- fin -->

    <!-- Formulario clientes -->
    <div class="ui  stackable large form " >
    <div class="ui secondary segment">
          <div class="ui form">
          <h4 class="ui dividing header">Datos del cliente</h4> 
            <div class="equal width  fields">
            <input type="hidden" id="idcliente"   placeholder="id">
              
              <div class="field">
                <label>Cedula</label>
                <input type="number" id="c_cliente" placeholder="Cedula" required onkeypress="return valideKey(event);">
              </div>

              <div class="field">
                <label>Primer Nombre</label>
                <input placeholder="Primer Nombre" id="nom_cliente" type="text" required onkeypress="return lettersOnly(event);"> 
              </div>

              <div class="field">
                <label>Segundo Nombre</label>
                <input placeholder="Segundo Nombre" id="nom2_cliente" type="text"  onkeypress="return lettersOnly(event);">
              </div>

              <div class="field">
              <label>Primer Apellido</label>
              <input placeholder="Primer Apellido" id="ap_cliente" type="text" required onkeypress="return lettersOnly(event);">
              </div>
              <div class="field">
              <label>Segundo Apellido</label>
              <input placeholder="Segundo Apellido" id="ap2_cliente" type="text" required onkeypress="return lettersOnly(event);">
              </div>
            </div>
            <input class="ui green button" onclick="BuscarCliente();" type="submit" id="btn_new_cliente" value="Nuevo cliente">
          </div>

      <!-- <input type="hidden" name="action" value="addCliente">  -->
      <input type="hidden" id="idcliente"   placeholder="id"> 

    </div>    

    <!-- 
    <button class="fluid ui green button" style="display:none;" id="btn_facturar_venta">Facturar Mesa</button> 
    <button class="fluid ui  button" onclick="validarAnularMesa();">Cancelar Mesa</button>-->

    <div class="ui left floated green tertiary  compact segment">
      <h3 class="ui centered header">Acciones</h3>
      <div class="ui small basic icon buttons">
      
        <button id="btn_facturar_venta" style="display:none;"  class="ui  button ">Facturar Mesa <i class="save green icon"></i></button>
        <button  onclick="validarAnularMesa();" class="ui button">Cancelar Mesa<i class="window red close icon"></i></button>
            
      </div>
    </div>


        <!-- tabla de facturacion -->
        <selection >
        <table class="ui very compact  small  table">
          <thead>
            <tr class="ui inverted table" >
              <th width="100px"><h5 class=" ui header" style="color:#ffff" scope="col">Mesa</h5></th>
              <th width="100px"><h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5</th>
              <th><h5 class=" ui header" style="color:#ffff" scope="col">Descripcion</h5></th>
              <th><h5 class=" ui header" style="color:#ffff" scope="col">Existencia</h5></th>
              <th class="center aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Cantidad</h5></th>
              <th class="right aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Precio</h5></th>
              <th class="right aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Precio Total</h5</th>
              <th><h5 class=" ui header" style="color:#ffff" scope="col">Accion</h5></th>
            </tr>
            <!-- busqueda de productos -->
            <tr>
              <td><input type="text" value="1" name="txt_cod_mesa" id="txtmesa"></td>
              <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
              <td style="display:none;"id="id" ></td>
              <td id="txt_descripcion">-</td>
              <td id="txt_existencia">-</td>
              <td class="center aligned"><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>

              <input type="hidden" name="" id="txt_id" value="<?php echo md5($_SESSION['ih_id']); ?>">
              <input type="hidden" name="" id="txt_usuario" value="<?php echo $_SESSION['ih_tipo']; ?>">
              

              <td id="txt_precio" class="right aligned">0.00</td>
              <td id="txt_precio_total" class="right aligned">0.00</td>
              <td> <a href="#" id="add_product_venta" class="link_add" style="display:none;"><i class="plus square icon"></i> Agregar</a></td>
            </tr>
            <!-- fin -->
            
            <!-- tabla detalle factura -->
            <tr class="ui inverted table">
              <th width="100px"><h5 class=" ui header" style="color:#ffff" scope="col">Mesa</h5></th>
              <th width="100px"><h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5</th>
              <th colspan="2"><h5 class=" ui header" style="color:#ffff" scope="col">Descripcion</h5></th>
              <th class="center aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Cantidad</h5></th>
              <th class="right aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Precio</h5></th>
              <th class="right aligned"><h5 class=" ui header" style="color:#ffff" scope="col">Precio Total</h5</th>
              <th><h5 class=" ui header" style="color:#ffff" scope="col">Accion</h5></th>
            </tr>
            <!-- fin -->

          </thead>
            <tbody id="detalle_mesas">
             <!-- ajax -->
            </tbody>
            <!-- fin -->
             
             <!-- Tabla resumen factura -->
            <tfoot id="detelle_totales_mesa">
            <!-- ajax -->
            </tfoot>
        </table>
        </selection>
     
        <!-- fin -->

</div>
</div>

</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_Mesas.js" ></script>
  <!-- <script type="text/javascript" src="js/funciones.js" ></script> -->
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>
<script type="text/javascript">
  // mostrar detalle tabla temporal
    function Detallemesas(id){
    var action = 'Detalletmp';
    var user = $('#txt_id').val();
    var mesa = $('#txtmesa').val();

      $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, user:user,mesa:mesa },
            success: function (response) {
            
              
            if(response != 'error')
            {
              
            //console.log('agrego los datos')
            var info = JSON.parse(response);
            console.log(info);
            $('#detalle_mesas').html(info.detalle);
            $('#detelle_totales_mesa').html(info.totales);
            viewProcesar();

            }else{
              $('#detalle_mesas').html('');
              $('#detelle_totales_mesa').html('');
            }
            
          },
          error: function (error) {
          }
      });
  }

  Detallemesas();





</script>


</html>


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
    <title>Formulario Ingreso</title>
    
</head>
<body>

<?php include 'recursos/menu1.php'; ?>
<?php include 'recursos/menu.php'; ?> 
    
<div class="ui hidden divider"></div>
<div class="ui very relax container m-a-70-m-b-70 ">
<h2 class="ui header">Factura Compras</h2>
<div class="ui secondary segment">

<input type="hidden" name="" id="txt_id" value="<?php echo md5($_SESSION['ih_id']); ?>">
<input type="hidden" name="" id="txt_usuario" value="<?php echo $_SESSION['ih_tipo']; ?>">
<!-- Formulario provedor -->
  <div class="ui  stackable form ">
  <h5>Numero de Factura</h5>
  <div class="ui input">
    <input placeholder="" id="numero" type="text">
  </div>
   
        <h4 class="ui dividing header">Datos del Proveedor</h4> 
        <div class="equal width  fields">
        <input type="hidden" id="id_provedor"  placeholder="id"> 

          <div class="eight wide field">
            <label>Nit<label/>
            <div class="ui icon input">
              <input type="text" id="nit_provedor"  id="txt_nofact" placeholder="Ingrese el Nit" onkeypress="return valideKey(event);" >
              <div class="ui small icon button" data-content="Buscar" id="btn_lupa"><i class="inverted circular search link icon" type="submit"   ></i></div>
            </div>
            
          </div>

          <div  class="three wide field">
               <label>#</label>
               <input type="text"  id="dg" minlength="1" maxlength="1" onkeypress="return valideKey(event);" disabled>               
          </div>

          <div class="field">
            <label>Razon Social</label>
            <input placeholder="Nombre" id="nombre" type="text"  disabled>
          </div>

          <div class="field">
            <label>Direccion</label>
            <input placeholder="Direccion" id="direccion" type="text" disabled>
          </div>
      
          <div class="field">
            <label>Telefono</label>
            <input placeholder="Telefono" id="telefono" type="text" onkeypress="return valideKey(event);" disabled >
          </div>
          
       
        </div>
      
  
  </div>
</div>

<div class="ui left floated green tertiary  compact segment">
      <h3 class="ui centered header">Acciones</h3>
      <div class="ui small basic icon buttons">
      
        <button id="btn_facturar" onclick="facturar_compra();" style="display:none;"  class="ui  button ">Guardar <i class="save green icon"></i></button>
        <button id="cancelar" onclick="validarCancelarFacturaCompra();"  class="ui button">Cancelar  <i class="window red close icon"></i></button>
            
      </div>
  </div>



<!-- fin -->


 
 <!-- tabla de factura compra -->
  <selection>
    <table class="ui striped table" id="tbl_venta">
      <thead>
        <tr class="ui inverted table" >
          <th width="100px">Codigo</th>
          <th>Descripcion</th>
          <th>Stock</th>
          <th class="center aligned">Cantidad</th>
          <th class="right aligned">Precio</th>
          <th class="right aligned">Precio Total</th>
          <th>Accion</th>
        </tr>
        <!-- busqueda de productos -->
        <tr>
          <td><input type="text" name="txt_cod_producto" id="txt_cod"  onkeypress="return valideKey(event);" tabindex="-1"></td>
          <td style="display:none;"id="id" ></td>
          <td id="txt_descripcion">-</td>
          <td id="txt_existencia">-</td>
          <td class="center aligned"><input type="text" name="txt_cant_producto" id="txt_cant" value="0" min="1" disabled onkeypress="return valideKey(event);"></td>
          
          <input type="hidden" name="" id="txt_id" value="<?php echo md5($_SESSION['ih_id']); ?>">
          <input type="hidden" name="" id="txt_usuario" value="<?php echo $_SESSION['ih_tipo']; ?>">

          <td id="txt_precio" class="right aligned">0.00</td>
          <td id="txt_precio_total" class="right aligned">0.00</td>
          <td> <a href="#" id="add_product_fact" class="link_add"style="display:none;"><i class="plus square icon"></i> Agregar</a></td>
        </tr>
        <!-- fin -->
        
        <!-- tabla detalle factura -->
        <tr class="ui inverted table">
          <th>Codigo</th>
          <th colspan="2">Descripcion</th>
          <th class="center aligned">Cantidad</th>
          <th class="right aligned">Precio</th>
          <th class="right aligned">Precio Total</th>
          <th>Accion</th>
        </tr>
        <!-- fin -->

      </thead>
        <tbody id="detalle_fact">
          <!-- Tabla ajax -->
        </tbody>
        <!-- fin -->
        
        <!-- Tabla resumen factura -->
        <tfoot id="detalle_tlt_fact">
          <!-- Tabla ajax -->
        </tfoot>
    </table>
  </selection>
<!-- fin -->

<!-- modal Registro -->
  <div class="ui modal registro">
            <div class="ui secondary segment">  
                <div class="ui form">
                    <h4 class="ui dividing header">Datos del Prodeedor</h4> 
                    <input type="hidden" id="id_prov">
                    <div class="equal width  fields">
              
                        <div class="eight wide field">
                            <label>Nit</label>
                            <input  type="text" id="nit" placeholder=" Ingrese su Nit"  onkeypress="return valideKey(event);">
                            
                        </div>
                        
                        <div  class="three wide field">
                        <label>#</label>
                            <input type="text"  id="digito" minlength="1" maxlength="1" >
                            
                        </div>

                        <div  class="field">
                            <label>Razon social</label>
                            <input type="text" name="nombre" id="M_nombre" placeholder="Nombre de la Empresa" >
                        </div>

                        <div class="field">
                            <label>Direccion</label>
                            <input type="text" id="M_direccion"  name="M_direccion"  placeholder="Direccion cll # 0 - 0 br." type="text" >
                        </div>

                        <div class="eight wide field">
                            <label>Telefono</label>
                            <input type="text" id="M_telefono" name="M_telefono" placeholder="Telefono" type="text" onkeypress="return valideKey(event);">
                        </div>
                        
                    </div>
                        
                        <div class="actions">
                            <div class="ui green approve button" onclick="Guardar_Modal();" id="btn_Guardar">Guardar</div>
                            <div class="ui red button" id="Btn_Limpiar">Limpiar</div>
                            <div class="ui cancel button">Cancelar</div>
                            
                        </div>

                </div>
            </div> 
  </div>
  <!-- fin -->

<!-- modal  buscar lupa -->
  <div style="width: auto; height:auto;" class="ui modal tabla">
     <!-- tabla de Registros -->
     <div id="div1">
       <table id='tbl' class="ui selectable collapsing celled  table tbl">
          <thead>
            <tr id="row" class="ui inverted table">
                 <th style="display: none;">id</th>
                <th style="display: none;">Nit</th>
                <th>Nit</th>
                <th style="display: none;">dg</th>
                <th>Razon social</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th style="display: none;">Acciones</th>
            
            </tr>
            </thead>
            <tbody id="Tbl_RegistroM">
              <!-- Tabla ajax -->
            </tbody>
      </table>
    </div>  
    <div class="actions">
        <div class="ui cancel button">Cancelar</div>                       
    </div>
  </div>
  <!-- fin -->





<div class="ui hidden divider"></div>
<div class="ui hidden divider"></div>
</div>
</body>
<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_Facturas_Compra.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>

</html>
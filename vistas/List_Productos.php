
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
    <title>Listado de Prodructos</title>

    
</head>

<body>

  <?php include 'recursos/menu1.php'; ?>
  <?php include 'recursos/menu.php';  ?>  
  <div class="ui hidden divider"></div>



    <div class="ui very relax container m-a-70-m-b-70 ">

        <div class="ui  segmen">
            <h4 class="ui header">Listado de Productos</h4>
        </div>
        <div class="ui secondary segment">
        <div class="ui stackable  form">
            <div class="fields">
            <div class="field">
                <label>Buscar</label>
                <div class="ui icon input">
                <input type="text"  id="txt_numero" placeholder="Buscar...">
                <i class="inverted circular search link icon" type="submit" onclick="Buscar();" id="btn_buscar_fact" ></i>
                </div>
            </div>

            <div class="field">
                <label>Filtro</label>
                <select class="ui fluid search dropdown" id="filtro">
                    <option value="1">Codigo</option>
                    <option value="2">Nombre</option>
                </select>
                </div>

            
            </div>
            </div>
        </div>

        <!-- tabla de Registros -->
        <div id="div1">
            <table class="ui very compact  small  table">
                <thead>
                <tr class="ui inverted table">
                    
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Codigo</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Nombre</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Tipo</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Precio Compra</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Precio Venta</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Fecha de Registro</h5></th>
                <th><h5 class=" ui header" style="color:#ffff" scope="col">Acciones</h5></th>
                
                </tr>
                </thead>
                <tbody id="Tbl_Registro_Producto">
                <!-- Tabla ajax -->
            </tbody>
            </table>
        </div>
        <!-- fin -->
        
                
        <!-- fin -->
        <div class="ui divider"></div>

        <div class="ui modal">
            <div class="ui secondary segment">  
            <div class="ui form">
                <h4 class="ui dividing header">Datos</h4>  
                <input type="hidden" id="id">            
                  <div class="equal width  fields">
                    <div class="field">
                        <label>Codigo</label>
                        <input type="text" id="codigo" name="codigo" placeholder="Codigo del Producto" onkeypress="return valideKey(event);" >
                    </div>

                    <div class="field">
                        <label> Nombre</label>
                        <input name="nombre" id="nombre" placeholder="Nombre del producto" type="text">
                    </div>

                    <div class="five wide field">
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

                  <div class="actions">
                            <div class="ui green approve button" onclick="Modificar();" id="btn_mod_cliente">Modificar</div>
                            <div class="ui cancel button">Cancel</div>
                            
                  </div>

            </div>
            </div> 
        </div>
        


    </div>
</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_List_Productos.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>






</html>    
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
    <title>Registro de Proveedores</title>

    
</head>

<body>

  <?php include 'recursos/menu1.php'; ?>
  <?php include 'recursos/menu.php';  ?>  
  <div class="ui hidden divider"></div>

    <div class="ui very relax container m-a-70-m-b-70 ">

        <div class="ui  segmen">
            <h4 class="ui header">Listado de Proveedores</h4>
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
                    <option value="1">Nit</option>
                    <option value="2">Nombre</option>
                </select>
                </div>

            
            </div>
            </div>
        </div>
        <!-- fin -->

        <!-- tabla de Registros -->
      <div id="div1">
        <table class="ui small table">
            <thead>
            <tr class="ui inverted table">
                
                <th>Nit</th>
                <th>Razon social</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Acciones</th>
            
            </tr>
            </thead>
            <tbody id="Tbl_Registro">
              <!-- Tabla ajax -->
            </tbody>
        </table>
      </div>
        <!-- fin -->
        
        <!-- modal para modificar Registro -->
        <div class="ui modal">
            <div class="ui secondary segment">  
                <div class="ui form">
                    <h4 class="ui dividing header">Datos del Proveedor</h4> 
                    <input type="hidden" id="id_prov">
                    <div class="equal width  fields">
              
                        <div class="eight wide field">
                            <label>Nit</label>
                            <input  type="text" id="nit" placeholder=" Ingrese su Nit"  onkeypress="return valideKey(event);">
                            
                        </div>
                        
                        <div  class="three wide field">
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
                        
                        <div class="actions">
                            <div class="ui green approve button" onclick="Modificar();" id="btn_mod_cliente">Modificar</div>
                            <div class="ui cancel button">Cancela</div>
                            
                        </div>

                </div>
            </div> 
        </div>
        <!-- fin -->
        


    </div>
</body>

<script type="text/javascript" src="js/Configuracion.js" ></script>
<script type="text/javascript" src="js/Funciones_List_Proveedores.js" ></script>
<script type="text/javascript" src="js/Sweetalert.min.js" ></script>






</html>    
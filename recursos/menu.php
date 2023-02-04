
	<?php

  if($_SESSION['ih_tipo'] == 1){?>

    <div class= "ui main fluid three menu inverted" style="margin: 0 auto 0 auto;">
    <!-- contenido del menu--> 
    <div class="ui item" style="margin: 0 auto 0 auto;"> 
 
      <div class="ui dropdown item"><i class="shopping  cart icon"></i>Modulo Venta <i class="dropdown icon"></i> 
        <div class="menu">
         <a class="item" href="?opcion=ventas" > <i class="shopping  cart icon"></i><label>Facturacion</label></a>
         <a class="ui item"href="?opcion=mesas"><i class="box icon"></i><label>Mesas</label></a>
         <a class="ui item"href="?opcion=clientes"><i class="id badge icon"></i><label>Registro de Clientes</label> </a>
         <!-- <a class="ui item"href="?opcion=List_Cliente"><i class="file alternate icon"></i><label>Listado de Clientes</label></a> -->
         <a class="ui item"href="?opcion=list_ventas"><i class="file alternate icon"></i><label>Listado de Facturas</label></a>
        </div>
      </div>
      <div class="ui dropdown item"><i class="money bill alternate icon"></i>Modulo Caja <i class="dropdown icon"></i> 
        <div class="menu">
         <a class="ui item"href="?opcion=caja"><i class="money bill alternate icon"></i><label>Cuadre Caja Diario</label></a>
        </div>
 
       </div>
       <div class="ui dropdown item"><i class="boxes icon"></i>Modulo Inventario<i class="dropdown icon"></i> 
        <div class="menu">
        <a class="ui item"href="?opcion=productos"><i class="tags  icon"></i><label>Productos</label> </a>
        <a class="ui item"href="?opcion=inventario"><i class="boxes icon"></i><label>Inventario</label></a>
        <!-- <a class="ui item"href="?opcion=List_Producto"><i class="file alternate icon"></i><label>Listado de Productos</label></a> -->
        </div>
       </div>
    
       <div class="ui dropdown item"><i class="file alternate icon"></i>Facturas Compra <i class="dropdown icon"></i> 
        <div class="menu">
        <a class="ui item"href="?opcion=ingresofact"><i class="shopping  cart icon"></i><label>Compras</label></a>
        <a class="ui item"href="?opcion=provedores"><i class="handshake  icon"></i><label>Provedores</label></a>
        <a class="ui item"href="?opcion=list_compras"><i class="file alternate icon"></i><label>Listado de Compras</label></a>
        <!-- <a class="ui item"href="?opcion=List_Proveedor"><i class="file alternate icon"></i><label>Listado de Proveedores</label></a> -->
        </div>
       </div>
       
 
       <div class="ui dropdown item"><i class="cogs icon"></i>Configuración<i class="dropdown icon"></i> 
        <div class="menu">
        <a class="ui item"href="?opcion=vista_config"><i class="cogs icon"></i><label>Configuracion</label></a>
        <a class="ui item"href="?opcion=Resolucion"><i class="pencil alternate icon"></i><label>Resolucion de Facturacion</label></a>
        <a class="ui item"href="?opcion=usuarios"><i class="user icon"></i><label>Usuarios</label></a>
        </div>
       </div>
      
     </div>
 </div>

  

 <div id="xed"class="ui centered mobile only   padded stackable grid">
    <div class="ui top  borderless fluid  huge menu">
        
        <div class="right menu">
          <div class="item">
            <button class="ui icon toggle basic button">
              <i class="content icon"></i>
            </button>
          </div>
        </div>
          <div class="ui vertical borderless inverted fluid menu" style="display: none;">
             <div class="item"> 
                   
                      <h4><i class="shopping  cart icon"></i>Modulo Ventas</h4>
                   
                      <a class="item" href="?opcion=ventas" > <i class="shopping  cart icon"></i><label>Facturacion</label></a>
                      <a class="ui item"href="?opcion=mesas"><i class="box icon"></i><label>Mesas</label></a>
                      <a class="ui item"href="?opcion=clientes"><i class="id badge icon"></i><label>Registro de Clientes</label> </a>
                      <a class="ui item"href="?opcion=List_Cliente"><i class="file alternate icon"></i><label>Listado de Clientes</label></a>
                      <a class="ui item"href="?opcion=list_ventas"><i class="file alternate icon"></i><label>Listado de Facturas</label></a>
                    
                      <h4><i class="money bill alternate icon"></i>Modulo Caja</h4>
                   
                      <a class="ui item"href="?opcion=caja"><i class="money bill alternate icon"></i><label>Cuadre Caja Diario</label></a>
                   
                      <h4><i class="boxes icon"></i>Modulo Inventario</h4>
                      <a class="ui item"href="?opcion=productos"><i class="tags  icon"></i><label>Productos</label> </a>
                      <a class="ui item"href="?opcion=inventario"><i class="boxes icon"></i><label>Inventario</label></a>
                      <a class="ui item"href="?opcion=List_Producto"><i class="file alternate icon"></i><label>Listado de Productos</label></a>

                  
                      <h4><i class="file alternate icon"></i>Facturas Compra</h4>
                      <a class="ui item"href="?opcion=ingresofact"><i class="shopping  cart icon"></i><label>Compras</label></a>
                      <a class="ui item"href="?opcion=provedores"><i class="handshake  icon"></i><label>Provedores</label></a>
                      <a class="ui item"href="?opcion=list_compras"><i class="file alternate icon"></i><label>Listado de Compras</label></a>
                      <a class="ui item"href="?opcion=List_Proveedor"><i class="file alternate icon"></i><label>Listado de Proveedores</label></a>

                      <h4><i class="cogs icon"></i>Configuración</h4>
                      <a class="ui item"href="?opcion=vista_config"><i class="cogs icon"></i><label>Configuracion</label></a>
                      <a class="ui item"href="?opcion=Resolucion"><i class="pencil alternate icon"></i><label>Resolucion de Facturacion</label></a>
                      <a class="ui item"href="?opcion=usuarios"><i class="user icon"></i><label>Usuarios</label></a>

              </div>
          </div>
    </div>
</div>






    
  
 <?php }else{ ?>

  <div class= "ui main fluid three menu inverted" style="margin: 0 auto 0 auto;">
    <!-- contenido del menu--> 
    <div class="ui item" style="margin: 0 auto 0 auto;"> 
 
      <div class="ui dropdown item"><i class="shopping  cart icon"></i>Modulo Ventas <i class="dropdown icon"></i> 
        <div class="menu">
         <a class="item" href="?opcion=ventas" > <i class="shopping  cart icon"></i><label>Facturacion</label></a>
         <a class="ui item"href="?opcion=mesas"><i class="box icon"></i><label>Mesas</label></a>
         <a class="ui item"href="?opcion=clientes"><i class="id badge icon"></i><label>Clientes</label> </a>
         <a class="ui item"href="?opcion=list_ventas"><i class="file alternate icon"></i><label>Registro Facturas</label></a>
        </div>
      </div>
      
      <div class="ui dropdown item"><i class="money bill alternate icon"></i>Modulo Caja <i class="dropdown icon"></i> 
        <div class="menu">
         <a class="ui item"href="?opcion=caja"><i class="money bill alternate icon"></i><label>Cuadre Caja Diario</label></a>
      </div>
     </div>
     
  </div>
 </div>

 

 <div id="xed"class="ui centered mobile only   padded stackable grid">
    <div class="ui top  borderless fluid  huge menu">
        
        <div class="right menu">
          <div class="item">
            <button class="ui icon toggle basic button">
              <i class="content icon"></i>
            </button>
          </div>
        </div>
          <div class="ui vertical borderless inverted fluid menu" style="display: none;">
             <div class="item"> 
                   
                      <h4><i class="shopping  cart icon"></i>Modulo Ventas</h4>
                   
                      <a class="item" href="?opcion=ventas" > <i class="shopping  cart icon"></i><label>Facturacion</label></a>
                      <a class="ui item"href="?opcion=mesas"><i class="box icon"></i><label>Mesas</label></a>
                      <a class="ui item"href="?opcion=clientes"><i class="id badge icon"></i><label>Clientes</label> </a>
                      <a class="ui item"href="?opcion=list_ventas"><i class="file alternate icon"></i><label>Registro Facturas</label></a>
                    
                      <h4><i class="money bill alternate icon"></i>Modulo Caja</h4>
                   
                      <a class="ui item"href="?opcion=caja"><i class="money bill alternate icon"></i><label>Cuadre Caja Diario</label></a>
  

              </div>
          </div>
    </div>
</div>






  <?php } ?>








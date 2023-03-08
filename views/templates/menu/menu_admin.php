<!-- menu vertical general -->
<div class="ui vertical stackable inverted sidebar menu">
    <div class="item">
        <a class="ui logo icon image" href="">
            <img src="build/img/inicio.webp" width="35%">
        </a>
        <a href="/"><b>Ventas Web</b></a>

    </div>

    <div class="item">
        <a class="ui logo icon image">
            <i class="user icon"></i>
        </a>
        <a><?php isset($name) ? print $name : print ""; ?></a>

        <a class="ui logo icon image">
            <i class="shield alternate icon"></i>
        </a>
        <a><?php isset($_SESSION["admin"]) && $_SESSION["admin"] == 1
            ? print "Administrador"
            : print "Vendedor"; ?></a>

    </div>

    <div class="item">
        <div class="header">Modulo facturación</div>
        <div class="menu">
            <a class="item" href="/ventas"> <i class="shopping  cart icon"></i><label>Ventas</label></a>
            <a class="item" href=""><i class="box icon"></i><label>Mesas</label></a>
            <a class="item" href=""><i class="id badge icon"></i><label>Registro de
                    Clientes</label> </a>
            <!-- <a class="ui item"href="?opcion=List_Cliente"><i class="file alternate icon"></i><label>Listado de Clientes</label></a> -->
            <a class="item" href=""><i class="file alternate icon"></i><label>Listado de
                    Ventas</label></a>

        </div>
    </div>
    <!-- fin intem -->

    <div class="item">
        <div class="header">Modulo caja</div>
        <div class="menu">

            <a class="ui item" href=""><i class="money bill alternate icon"></i><label>Cuadre Caja
                    Diario</label></a>


        </div>
    </div>

    <div class="item">
        <div class="header">Modulo inventario</div>
        <div class="menu">

            <a class="ui item" href=""><i class="tags  icon"></i><label>Productos</label> </a>
            <a class="ui item" href=""><i class="boxes icon"></i><label>Inventario</label></a>


        </div>
    </div>

    <div class="item">
        <div class="header">Modulo compras</div>
        <div class="menu">

            <a class="ui item" href="?opcion=ingresofact"><i class="shopping  cart icon"></i><label>Compras</label></a>
            <a class="ui item" href="?opcion=provedores"><i class="handshake  icon"></i><label>Provedores</label></a>
            <a class="ui item" href="?opcion=list_compras"><i class="file alternate icon"></i><label>Listado de
                    Compras</label></a>
            <a class="ui item" href="?opcion=List_Proveedor"><i class="file alternate icon"></i><label>Listado de
                    Proveedores</label></a>


        </div>
    </div>

    <div class="item">
        <div class="header">Configuración</div>
        <div class="menu">

            <a class="ui item" href="?opcion=vista_config"><i class="cogs icon"></i><label>Configuracion</label></a>
            <a class="ui item" href="?opcion=Resolucion"><i class="pencil alternate icon"></i><label>Resolucion de
                    Facturacion</label></a>
            <a class="ui item" href="?opcion=usuarios"><i class="user icon"></i><label>Usuarios</label></a>


        </div>
    </div>

    <div class="item">
        <a class="mini ui blue  button" href="/logout">Cerrar Sesión</a>

    </div>

</div>

<!-- menu para mobil -->
<div id="menu_mobil" class="ui black big  launch right attached fixed button" style='display:none;'
    onclick="hide_o_show();">
    <i class="content icon"></i>
    <span class="text">Menu</span>
</div>

<!--  menu tablet -->
<div id="menu_tablet" class="ui fixed inverted main menu">
    <div class="ui container">
        <a class="launch icon item">
            <i onclick="hide_o_show();" class="content icon"></i>
        </a>

        <div class="item"><?php isset($page) ? print $page : ""; ?></div>

        <div class="right menu">
            <div class="vertically stackable fitted borderless item">
                <div class="item">

                    <b>
                        <i class="user icon"></i> <?php isset($name)
                            ? print $name
                            : print ""; ?>

                    </b>
                    <b>&nbsp &nbsp
                        <i class="shield alternate icon"></i> <?php isset(
                            $_SESSION["admin"]
                        ) && $_SESSION["admin"] == 1
                            ? print "Administrador"
                            : print "Vendedor"; ?>
                    </b>
                </div>


                <div class="item">
                    <div class="ui hidden  aligned search input">

                        <a class="mini ui blue  button" href="/logout">Cerrar Sesión</a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
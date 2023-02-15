//ocultar boton nuevo cliente
$('#btn_new_cliente').slideUp();

// bloque campos
$('#idcliente').prop("disabled", true);
$('#nom_cliente').prop("disabled", true);
$('#nom2_cliente').prop("disabled", true);
$('#ap_cliente').prop("disabled", true);
$('#ap2_cliente').prop("disabled", true);
$('#c_cliente').focus();

// buscar clientes por cedula
function BuscarCliente() {
    // e.preventDefault();

    // var cl = $(this).val();
    var cc = $('#c_cliente').val();
    var action = 'searchCliente';

    if ((cc == '' || cc == 0)) {

        swal({
            title: "Oops!",
            text: "Digite un Nuemero de Documento valido",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {

                $('#c_cliente').focus();

            }
        });

    } else {

        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, cliente: cc },

            success: function(response) {
                // console.log(response);

                if (response == 0) {


                    swal({
                            title: "Cedula No Registrada",
                            text: "Desea Registrar el Nuevo Cliente",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {

                                $('#nom_cliente').prop("disabled", false);
                                $('#nom2_cliente').prop("disabled", false);
                                $('#ap_cliente').prop("disabled", false);
                                $('#ap2_cliente').prop("disabled", false);
                                $('#idcliente').val('');
                                $('#nom_cliente').val('');
                                $('#nom2_cliente').val('');
                                $('#ap_cliente').val('');
                                $('#ap2_cliente').val('');
                                $('#nom_cliente').focus();

                                // MOSTRAR BOTON AGREGAR
                                $('#btn_new_cliente').slideDown();

                            } else {
                                // swal("!No se Realizo Ninguna Accion!");
                                $('#c_cliente').focus();
                            }
                        });


                } else {

                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.id_cliente);
                    $('#nom_cliente').val(data.nombre_1);
                    $('#nom2_cliente').val(data.nombre_2);
                    $('#ap_cliente').val(data.apellido_1);
                    $('#ap2_cliente').val(data.apellido_2);

                    //ocultar boton
                    $('#btn_new_cliente').slideUp();
                    // bloque campos
                    $('#idcliente').prop("disabled", true);
                    $('#nom_cliente').prop("disabled", true);
                    $('#nom2_cliente').prop("disabled", true);
                    $('#ap_cliente').prop("disabled", true);
                    $('#ap2_cliente').prop("disabled", true);
                    $('#c_cliente').prop("disabled", true);
                    $('#txtmesa').focus();



                }
            },
            error: function(error) {}
        });
    }
}
// fin 


//buscar productos
function buscar_producto() {

    var pt = $('#txt_cod_producto').val();
    var action = 'infoProducto';


    if (pt != '') {
        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, producto: pt },
            success: function(response) {


                if (response != 'error') {

                    var info = JSON.parse(response);
                    $('#id').html(info.id_producto);
                    $('#txt_descripcion').html(info.nombre);
                    $('#txt_existencia').html(info.stock);
                    $('#txt_cant_producto').val('1');

                    $('#txt_precio').html(info.precio_venta);


                    $('#txt_precio_total').html(formatterPeso.format(info.precio_venta));
                    //$('#txt_precio_total').html(info.precio_venta);

                    if ($('#txt_existencia').html() > 0) {

                        // activar cantidad
                        $('#txt_cant_producto').removeAttr('disabled');

                        $('#txt_cant_producto').focus();
                        $('#add_product_venta').slideDown();

                    } else {

                        // Bloquear cantidad
                        $('#txt_cant_producto').prop("disabled", true);
                        // ocultar agregar
                        $('#add_product_venta').slideUp();
                        $('#txt_cod_producto').focus();

                    }


                } else {
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').html('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');
                    // Bloquear cantidad
                    $('#txt_cant_producto').prop("disabled", true);
                    // ocultar agregar
                    $('#add_product_venta').slideUp();
                    $('#txt_cod_producto').focus();

                }
            },
            error: function(error) {}
        });
    }

}
// fin 

//buscar por mesas
function buscar_mesas() {

    if ($('#txtmesa').val() > 0) {
        var mesa = $('#txtmesa').val();
        var id = $('#txt_id').val();

        var action = 'bucarMesa';


        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, mesa: mesa, token: id },
            success: function(response) {


                if (response != 'error') {

                    //console.log(response);
                    var info = JSON.parse(response);
                    // console.log(info);
                    $('#detalle_mesas').html(info.detalle);
                    $('#detelle_totales_mesa').html(info.totales);


                    // Bloquear cantidad
                    $('#txt_cant_producto').prop("disabled", true);

                    // ocultar agregar
                    $('#add_product_venta').slideUp();

                    $('#txt_cod_producto').focus();
                    viewProcesar();
                    $('#txt_cod_producto').focus();

                } else {
                    $('#detalle_mesas').html('');
                    $('#detelle_totales_mesa').html('');
                    $('#btn_facturar_venta').hide();
                    //$('#txt_cod_producto').focus();

                    $('#txt_cod_producto').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').html('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');

                    // Bloquear cantidad
                    $('#txt_cant_producto').prop("disabled", true);
                    // ocultar agregar
                    $('#add_product_venta').slideUp();
                    viewProcesar();
                    $('#txt_cod_producto').focus();

                }

            },
            error: function(error) {}
        });

    }

}
//fin

// eliminar producto detalle temporal MESA
function del_producto_detalle(correlativo) {

    var action = 'delDetalle';
    var id_detalle = correlativo;
    var id = $('#txt_id').val();
    var mesa = $('#txtmesa').val();

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, id_detalle: id_detalle, token: id, mesa: mesa },
        success: function(response) {
            if (response != 'error') {
                //console.log(response);
                var info = JSON.parse(response);
                // console.log(info);
                $('#detalle_mesas').html(info.detalle);
                $('#detelle_totales_mesa').html(info.totales);

                $('#id').html('');
                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').html('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                // Bloquear cantidad
                $('#txt_cant_producto').prop("disabled", true);
                // ocultar agregar
                $('#add_product_venta').slideUp();
                //$('#txt_cod_producto').focus();
                viewProcesar();


            } else {

                $('#detalle_mesas').html('');
                $('#detelle_totales_mesa').html('');
                $('#btn_facturar_venta').hide();
                //$('#txt_cod_producto').focus();

                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').html('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                // Bloquear cantidad
                $('#txt_cant_producto').prop("disabled", true);
                // ocultar agregar
                $('#add_product_venta').slideUp();




            }

        },
        error: function(error) {

        }
    });
}
//fin


// procesar venta mesa
$('#btn_facturar_venta').click(function(e) {
    e.preventDefault();

    var rows = $('#detalle_mesas tr').length;
    var id = $('#txt_id').val();
    if (rows > 0) {
        var action = 'ProcesarMesa';
        var codcliente = $('#idcliente').val();
        var usuario = $('#txt_usuario').val();
        var mesa = $('#txtmesa').val();

        if ((codcliente == '' || usuario == '' || mesa == '')) {

            swal({
                title: "Oops!",
                text: "Hay Campos Vacios Verifigue y vuelva a intentar ",
                icon: "warning",
                button: "ok",
            })

            .then((willDelete) => {
                if (willDelete) {


                    $('#txtmesa').focus();


                }
            });

        } else {



            $.ajax({
                url: 'modelo/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, codcliente: codcliente, token: id, usuario: usuario, mesa: mesa },
                success: function(response) {
                    console.log(response);


                    if (response != 'error_01') {
                        swal({
                            title: "Facturado",
                            text: "Factura Guardada con Exito.",
                            icon: "success",
                            button: "ok",
                        })

                        .then((willDelete) => {
                            if (willDelete) {


                                var info = JSON.parse(response);

                                generarPDF(info.codcliente, info.nofactura);
                                Reload();



                            }
                        });

                    } else {


                        swal({
                            title: "Oops!",
                            text: "Ha ocurrido un error: " + " Prefijo de facturacion no configurado...",
                            icon: "warning",
                            button: "ok",
                        })

                        .then((willDelete) => {
                            if (willDelete) {



                            }
                        });
                    }

                },
                error: function(error) {}
            });

        }

    }

});
//fin


// validar cantidad antes de agregar
function ValidarCantidad() {

    var precio_total = $(this).val() * $('#txt_precio').html();
    var existencia = parseInt($('#txt_existencia').html());
    var pt = precio_total;
    $('#txt_precio_total').html(formatterPeso.format(pt));
    //$('#txt_precio_total').html(pt);

    // oculta el boton agregar si la cantidad es menor que 1
    if (($('#txt_cant_producto').val() < 1 || isNaN($('#txt_cant_producto').val())) || ($('#txt_cant_producto').val() > existencia)) {

        $('#add_product_venta').slideUp();

    } else {
        $('#add_product_venta').slideDown();
        $('#add_product_venta').focus();
    }

}
//fin   

//agregar producto al detalle MESAS
$('#add_product_venta').click(function(e) {
    e.preventDefault();

    if ($('#txt_cant_producto').val() > 0) {



        var mesa = $('#txtmesa').val();
        var codproducto = $('#txt_cod_producto').val();
        var id_p = $('#id').html();
        var cantidad = $('#txt_cant_producto').val();
        var id = $('#txt_id').val();

        var action = 'addProductoMesa';


        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, producto: id_p, mesa: mesa, cantidad: cantidad, token: id },
            success: function(response) {


                if (response != 'error') {

                    //console.log(response);
                    var info = JSON.parse(response);
                    //console.log(info);
                    $('#detalle_mesas').html(info.detalle);
                    $('#detelle_totales_mesa').html(info.totales);

                    $('#txt_cod_producto').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant_producto').html('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');

                    // Bloquear cantidad
                    $('#txt_cant_producto').prop("disabled", true);

                    // ocultar agregar
                    $('#add_product_venta').slideUp();

                    $('#txt_cod_producto').focus();
                    viewProcesar();

                } else {
                    console.log('no data');
                }

            },
            error: function(error) {}
        });

    }

});
//fin

// validaciones

///validar buscar cliente
var elem = document.getElementById("c_cliente");
elem.onkeyup = function(e) {
        if (e.keyCode == 13) {

            BuscarCliente();

        }
    }
    //fin


// validar enter mesas
var txt_cod = document.getElementById("txtmesa");
txt_cod.onkeyup = function(e) {
        if (e.keyCode == 13) {
            buscar_mesas();
        }
    }
    //fin

// validar enter codigo producto
var txt_cod = document.getElementById("txt_cod_producto");
txt_cod.onkeyup = function(e) {
        if (e.keyCode == 13) {
            buscar_producto();
        }
    }
    //fin

// validar enter cantidad producto
var txt_cod = document.getElementById("txt_cant_producto");
txt_cod.onkeyup = function(e) {
    if (e.keyCode == 13) {
        ValidarCantidad();
    }
}


// validar cantidad antes de agregar
function ValidarCantidad() {


    var precio_total = $('#txt_cant_producto').val() * $('#txt_precio').html();
    var existencia = parseInt($('#txt_existencia').html());
    var pt = precio_total;
    $('#txt_precio_total').html(formatterPeso.format(pt));
    //$('#txt_precio_total').html(pt);

    // oculta el boton agregar si la cantidad es menor que 1
    if (($('#txt_cant_producto').val() < 1 || isNaN($('#txt_cant_producto').val())) || ($('#txt_cant_producto').val() > existencia)) {

        $('#add_product_venta').slideUp();


    } else {
        $('#add_product_venta').slideDown();
        $('#add_product_venta').focus();
    }

}

// mostar/ ocultar boton procesar
function viewProcesar() {
    if ($('#detalle_venta tr').length > 0) {
        $('#btn_facturar_venta').show();
    } else {
        $('#btn_facturar_venta').hide();
    }
}
//fin


//fin------------


//cancelar mesa
function cancelar_mesa() {


    var rows = $('#detalle_mesas tr').length;
    var id = $('#txt_id').val();
    var mesa = $('#txtmesa').val();

    if (rows > 0) {
        var action = 'AnularMensa';

        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, token: id, mesa: mesa },
            success: function(response) {

                if (response == '') {

                    swal({
                        title: "Mesa Cancelada",
                        text: "Se Borro toda la información de la mesa:" + " " + mesa,
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            viewProcesar();
                            Reload();


                        }
                    });



                } else {

                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un " + " " + response,
                        icon: "warning",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {



                        }
                    });


                }

            },
            error: function(error) {}
        });



    } else {

        viewProcesar();
        Reload();


    }

}
// fin

function cancelar() {

    var rows = $('#detalle_mesas tr').length;
    var id = $('#txt_id').val();
    var mesa = $('#txtmesa').val();

    if (rows > 0) {
        var action = 'AnularMensa';

        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, token: id, mesa: mesa },
            success: function(response) {

                if (response != 'error') {

                    swal({
                        title: "Mesa Cancelada",
                        text: "Se Borraran la información.",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            viewProcesar();
                            Reload();


                        }
                    });



                }

            },
            error: function(error) {}
        });

    } else {
        viewProcesar();
        Reload();
        $('#c_cliente').focus();
    }
}

// mostar/ ocultar boton procesar
function viewProcesar() {
    if ($('#detalle_mesas tr').length > 0) {

        $('#btn_facturar_venta').show();

    } else {

        $('#btn_facturar_venta').hide();
    }
}

function Reload() {

    var url = '?opcion=mesas';
    location.href = url;

}
// bloque campos
$('#numero').focus();

/// Funciones de busqueda 

// buscar provedor por nit
function BuscarProv() {


    var cl = $('#nit_provedor').val();
    var action = 'searchProvedor';

    if (isEmpty($('#numero').val())) {

        swal({
            title: "Oops!",
            text: "Ingrese el numero de Factura Compra",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {

                $('#numero').focus();

            }
        });



    } else {

        $('#numero').prop("disabled", true);


        if (isEmpty(cl)) {

            swal({
                title: "Oops!",
                text: "Digite un Nuemero de Documento valido",
                icon: "warning",
                button: "ok",
            })

            .then((willDelete) => {
                if (willDelete) {

                    $('#nit_provedor').focus();

                }
            });

        } else {

            $.ajax({
                url: 'modelo/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, provedor: cl },

                success: function(response) {
                    // console.log(response);

                    if (response == 0) {


                        swal({
                                title: "Nit no Registrado",
                                text: "Desea Registrar un nuevo Proveedor",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete) {

                                    modal_Registro();
                                    $('#nit').val(cl);

                                    // validar el campo nit que no este vacio en el modal
                                    if (isEmpty($('#nit').val())) {
                                        $('#nit').prop("disabled", false);
                                    } else {
                                        $('#nit').prop("disabled", true);

                                    }



                                } else {
                                    // swal("!No se Realizo Ninguna Accion!");
                                    $('#nit_provedor').focus();
                                }
                            });



                    } else {


                        var data = $.parseJSON(response);
                        $('#nombre').val(data.nombre);
                        $('#direccion').val(data.direccion);
                        $('#telefono').val(data.telefono);
                        $('#dg').val(data.dg);
                        $('#id_provedor').val(data.id_provedor);
                        //ocultar boton
                        $('#btn_new_provedor').slideUp();
                        // bloque campos
                        $('#nit_provedor').prop("disabled", true);
                        $('#nombre').prop("disabled", true);
                        $('#direccion').prop("disabled", true);
                        $('#telefono').prop("disabled", true);
                        $('#txt_cod').focus();



                    }
                },
                error: function(error) {}
            });

        }
    }

} // fin 

//buscar productos para factura compra
function BuscarProductos() {


    var pt = $('#txt_cod').val();
    var action = 'SearchProducto';


    if (pt != '') {
        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, producto: pt },
            success: function(response) {
                // console.log(response);

                if (response != 'error') {

                    var info = JSON.parse(response);
                    $('#id').html(info.id_producto);
                    $('#txt_descripcion').html(info.nombre);
                    $('#txt_existencia').html(info.stock);
                    $('#txt_cant').val('1');

                    $('#txt_precio').html(info.precio_compra);


                    $('#txt_precio_total').html(formatterPeso.format(info.precio_compra));
                    //$('#txt_precio_total').html(info.precio_venta);

                    // activar cantidad
                    $('#txt_cant').removeAttr('disabled');

                    $('#txt_cant').focus();
                    //mostrar agregar
                    $('#add_product_venta').slideDown();
                } else {
                    $('#id').html('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant').html('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');
                    // Bloquear cantidad
                    $('#txt_cant').prop("disabled", true);
                    // ocultar agregar
                    $('#add_product_fact').slideUp();
                    $('#txt_cod').focus();

                }
            },
            error: function(error) {}
        });
    }

} // fin 

// buscar lupa 
$('#btn_lupa').click(function(e) {

    $('.ui.modal.tabla')
        .modal('show');

    var action = 'SeachProveedor';

    $.ajax({
        url: 'modelo/ingresofacturas.php',
        type: 'POST',
        async: true,
        data: { action: action, buscar: '', filtro: '' },
        success: function(response) {


            if (response != 'error') {


                var info = JSON.parse(response);
                $('#Tbl_RegistroM').html(info.detalle);
                Iconos();


            } else {

                swal({
                    title: "Oops!",
                    text: "No se Encontro Registro" + " ",
                    icon: "warning",
                    button: "ok",
                })

                .then((willDelete) => {
                    if (willDelete) {

                        $('#Tbl_RegistroM').html('');

                    }
                });

            }

        },
        error: function(error) {}
    });






}); //fin

// leer contenido de la tabla 
function selecionar() {
    var resume_table = document.getElementById("tbl");
    //console.log(resume_table.row);

    for (var i = 1, row; row = resume_table.rows[i]; i++) {


        // console.log(`filas: ${row.innerText}`);
        console.log(i);

        for (var j = 0, col; col = row.cells[j]; j++) {

            console.log(`columna: ${col.innerText}`);
            console.log(j);

            // console.log(`Datos: ${col.innerText} \Columna: ${i} \ Columna1:${row.innerText} \fila: ${j}`);

        }
    }
}


window.onload = function() {
       
    Detallefacturas();

        // creamos los eventos para cada elemento con la clase "tbl"

        let elementos = document.getElementsByClassName("tbl");

        for (let i = 0; i < elementos.length; i++) {
            // cada vez que se haga clic sobre cualquier de los elementos,

            // ejecutamos la función obtenerValores()

            elementos[i].addEventListener("click", obtenerValores);
        }

    } //fin

// funcion que se ejecuta cada vez que se hace clic
function obtenerValores(e) {
    const array = [];
    var x = 0;
    // vamos al elemento padre (<tr>) y buscamos todos los elementos <td>

    // que contenga el elemento padre

    var elementosTD = e.srcElement.parentElement.getElementsByTagName("td");

    // console.log(elementosTR);
    console.log(elementosTD);


    // recorremos cada uno de los elementos del array de elementos <td>


    for (let i = 0; i < 7; i++) {
        switch (x) {

            case x = 0:
                array[x] = { id: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log(' id x = 0');
                break;

            case x = 1:
                array[x] = { nit: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log(' primero x = 1');
                break;
            case x = 2:

                x = x + 1;

                break;

            case x = 3:
                array[x] = { dg: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log(' digito x = 3');
                break;


            case x = 4:
                array[x] = { nombre: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log(' segundo x = 4');
                break;

            case x = 5:
                array[x] = { direccion: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log(' r x=5');
                break;

            case x = 6:
                array[x] = { telefono: elementosTD[i].innerHTML };
                x = x + 1;
                //console.log('resultado x=6');
                break;

            case x = 7:

                // console.log('El kilogramo 7');
                break;

            default:
                // console.log('Lo lamentamos, por el momento no disponemos de ' + x + '.');
        }

    }
    // cerramos el modal y mostramos los datos 
    $('.ui.modal')
        .modal('hide');

    $('#nit_provedor').val(array[1]['nit']);
    $('#dg').val(array[3]['dg']);
    $('#nombre').val(array[4]['nombre']);
    $('#direccion').val(array[5]['direccion']);
    $('#telefono').val(array[6]['telefono']);
    $('#id_provedor').val(array[0]['id']);
    // bloque campos
    $('#nit_provedor').prop("disabled", true);
    $('#nombre').prop("disabled", true);
    $('#direccion').prop("disabled", true);
    $('#telefono').prop("disabled", true);
    $('#txt_cod').focus();



} //fin

/// fin 

/// funciones Generales

//Registro de Provedores
function Guardar_Modal() {

    var nit = $('#nit').val();
    var digito = $('#digito').val();
    var nombre = $('#M_nombre').val();
    var direccion = $('#M_direccion').val();
    var telefono = $('#M_telefono').val();
    var action = 'AddProveedor';

    if (($('#nit').val() == '' || $('#digito').val() == '' || $('#M_nombre') == '' || $('#M_direccion').val() == '' || $('#M_telefono').val() == '')) {

        swal({
            title: "Oops!",
            text: "Llene todos los Campos Requeridos",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {

                $('#nit').focus();

            }
        });

    } else {



        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, nit: nit, dg: digito, nombre: nombre, direccion: direccion, telefono: telefono },


            success: function(response) {
                // console.log(response);
                var data = $.parseJSON(response);

                //console.log(data);

                if (isEmpty(data.error)) {

                    swal({
                        title: "Guardado",
                        text: "Registro Almacenado Exitosamente!",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            $('#dg').val(data.dg);
                            $('#nombre').val(data.nombre);
                            $('#direccion').val(data.direccion);
                            $('#telefono').val(data.telefono);
                            $('#id_provedor').val(data.id_provedor);
                            Limpiar_Modal();

                            // bloque campos
                            $('#nit_provedor').prop("disabled", true);
                            $('#txt_cod').focus();


                        }
                    });

                } else {

                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un Error:" + " " + response,
                        icon: "warning",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            Limpiar_Modal();
                            $('#nit_provedor').focus();





                        }
                    });

                }


            },
            error: function(error) {}
        });
    }
} // fin

//agregar producto al detalle compra faturas
$('#add_product_fact').click(function(e) {
    e.preventDefault();

    if ($('#txt_cant').val() > 0 || isNaN($('#txt_cant').val())) {

        // var codproducto = $('#txt_cod').val();
        var cantidad = $('#txt_cant').val();
        var id = $('#txt_id').val();
        var id_p = $('#id').html();

        var action = 'addProductoFact';


        $.ajax({
            url: 'modelo/ingresofacturas.php',
            type: 'POST',
            async: true,
            data: { action: action, producto: id_p, cantidad: cantidad, token: id },
            success: function(response) {


                if (response != 'error') {

                    var info = JSON.parse(response);
                    $('#detalle_fact').html(info.detalle);
                    $('#detalle_tlt_fact').html(info.totales);


                    $('#txt_cod').val('');
                    $('#txt_descripcion').html('-');
                    $('#txt_existencia').html('-');
                    $('#txt_cant').val('0');
                    $('#txt_precio').html('0.00');
                    $('#txt_precio_total').html('0.00');
                    // Bloquear cantidad
                    $('#txt_cant').prop("disabled", true);
                    // ocultar agregar
                    $('#add_product_venta').slideUp();
                    $('#txt_cod').focus();
                    viewProcesarbtm();



                    // ocultar agregar
                    $('#add_product_venta').slideUp();




                } else {
                    console.log('no data');
                }

            },
            error: function(error) {}
        });

    }

}); //fin

// eliminar producto detalle facturas compra
function del_producto_detalle_facturas(correlativo) {

    var action = 'delDetalle';
    var id_detalle = correlativo;
    var id = $('#txt_id').val();


    $.ajax({
        url: 'modelo/ingresofacturas.php',
        type: 'POST',
        async: true,
        data: { action: action, id_detalle: id_detalle, token: id },
        success: function(response) {
            if (response != '') {

                swal({
                    title: "Oops!",
                    text: "Ha ocurrido un Error:" + " " + response,
                    icon: "warning",
                    button: "ok",
                })

                .then((willDelete) => {
                    if (willDelete) {

                    

                    }
                });


            } else {

                Detallefacturas();
             

                // Bloquear cantidad
                $('#txt_cant').prop("disabled", true);
                // ocultar agregar
                $('#add_product_venta').hide();
                viewProcesarbtm();



            }

        },
        error: function(error) {

        }
    });
} //fin

// procesar compra
function facturar_compra() {


    var rows = $('#detalle_fact tr').length;
    var id = $('#txt_id').val();
    if (rows > 0) {
        var action = 'procesarCompra';
        var codprovedor = $('#id_provedor').val();
        var usuario = $('#txt_usuario').val();
        var numero = $('#numero').val();
        $.ajax({
            url: 'modelo/ingresofacturas.php',
            type: 'POST',
            async: true,
            data: { action: action, numero: numero, provedor: codprovedor, token: id, usuario: usuario },
            success: function(response) {
                //console.log(response);
                if (response == '') {
                    swal({
                        title: "Facturado",
                        text: "Factura Guardada con Exito.",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {




                            Cancelar();



                        }
                    });

                } else {

                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un error: " + " " + response,
                        icon: "warning",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            //console.log('no hay datos');

                        }
                    });
                }

            },
            error: function(error) {}
        });



    }

} //fin

// cancelar compra
function CancelarFacturaCompra() {

    var rows = $('#detalle_fact tr').length;
    var id = $('#txt_id').val();
    if (rows > 0) {
        // var action = 'AnularFacturaCompra';
        var action = 'CancelarFacturaCompra';

        $.ajax({
            url: 'modelo/ingresofacturas.php',
            type: 'POST',
            async: true,
            data: { action: action, token: id },
            success: function(response) {
                // console.log(response);
                if (response != 'error') {
                    swal({
                        title: "Factura Cancelada",
                        text: "Se Borro toda la información.",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            Detallefacturas();
                            Limpiar_Formulario();
                            Limpiar_Modal();
                            $('#numero').focus();





                        }
                    });

                } else {

                    alert('error');

                }

            },
            error: function(error) {}
        });


    } else {

        // location.href = '?opcion=ingresofact';
        Limpiar_Formulario();

    }

} // fin

/// fin


/// funciones procesar botones 

// mostar/ ocultar boton procesar
function viewProcesarbtm() {
    if ($('#detalle_fact tr').length > 0) {

        $('#btn_facturar').show();

    } else {

        $('#btn_facturar').hide();
    }
} //fin

function Cancelar() {

    var url = '?opcion=ingresofact';
    location.href = url;

} //fin

// abrir pmodal
function modal_Registro() {

    $('.ui.modal.registro')
        .modal('show');


} //fin

///fin

/// limpiara form

//limpiar modal
function Limpiar_Modal() {
    $('#nit').val('');
    $('#digito').val('');
    $('#M_nombre').val('');
    $('#M_direccion').val('');
    $('#M_telefono').val('');
} //fin

// limpiar todo el formulario
function Limpiar_Formulario() {

    Limpiar_Modal();
    $('#dg').val('');
    $('#numero').val('');
    $('#nit_provedor').val('');
    $('#nombre').val('');
    $('#direccion').val('');
    $('#telefono').val('');
    $('#id_provedor').val('');

    $('#txt_cod').val('');
    $('#id').html('');
    $('#txt_descripcion').html('-');
    $('#txt_existencia').html('-');
    $('#txt_cant').val('0');
    $('#txt_precio').html('0.00');
    $('#txt_precio_total').html('0.00');

    // Desbloquear
    $('#txt_cant').prop("disabled", true);
    $('#numero').prop("disabled", false);
    $('#nit_provedor').prop("disabled", false);

    $('#numero').focus();

} //fin

// limpiar modal
$('#Btn_Limpiar').click(function(e) {

    e.preventDefault()
    $('#nit').prop("disabled", false);
    $('#nit').val('');
    $('#digito').val('');
    $('#M_nombre').val('');
    $('#M_direccion').val('');
    $('#M_telefono').val('');
    $('#nit').focus();

}); // fin

///fin


/// validaciones 

function Validar_Numero() {

    if (isEmpty($('#numero').val())) {

        swal({
            title: "Oops!",
            text: "Ingrese el numero de Factura Compra",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {

                $('#numero').focus();

            }
        });



    } else {

        $('#nit_provedor').focus();
        $('#numero').prop("disabled", true);

    }


} //fin

function Validar_Provedor() {

    if (isEmpty($('#id_provedor').val())) {

        swal({
            title: "Oops!",
            text: "Ingrese Los datos del Proveedor",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {

                $('#nit_provedor').focus();

            }
        });



    } else {

        $('#nit_provedor').prop("disabled", true);

    }


}

//Validacion de cancelacion de factura compra 
function validarCancelarFacturaCompra() {


    swal({
            title: "¿Realmente deseas Cancelar la Factura Compras?",
            text: "Se Borrara toda la informacion...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                CancelarFacturaCompra();


            } else {
                swal("!No se realizo ninguna Acción!");
            }
        });



} //fin


// validar cantidad antes de agregar compra
function ValidarCantidad() {

    // oculta el boton agregar si la cantidad es menor que 1
    if (($('#txt_cant').val() < 1 || isNaN($('#txt_cant').val()))) {

        $('#add_product_fact').slideUp();
        viewProcesarbtm();

    } else {

        $('#add_product_fact').slideDown();

        var precio_total = $('#txt_cant').val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        var pt = precio_total;
        $('#txt_precio_total').html(formatterPeso.format(pt));
        $('#add_product_fact').focus();
        viewProcesarbtm();
    }

} //fin 

///validar enter buscar por nit
var elem = document.getElementById("nit_provedor");
elem.onkeyup = function(e) {
        if (e.keyCode == 13) {

            BuscarProv();

        }
    } //fin 

///validar  enter buscar productos
var elem = document.getElementById("txt_cod");
elem.onkeyup = function(e) {
        if (e.keyCode == 13) {

            BuscarProductos();

        }
    } //fin 

///validar  enter buscar productos








///validar enter  buscar productos
var elem = document.getElementById("txt_cant");
elem.onkeyup = function(e) {
        if (e.keyCode == 13) {

            ValidarCantidad();

        }
    } //fin 

///validar enter  numero de factura
var elem = document.getElementById("numero");
elem.onkeyup = function(e) {
        if (e.keyCode == 13) {

            Validar_Numero();


        }
    } //fin 

// Mostar mensajes en los iconos
function Iconos() {

    $('.ui.icon')
        .popup({
            inline: true
        });

} //fin


// Mostar mensajes en los iconos
function Iconos() {

    $('.ui.icon')
        .popup({
            inline: true
        });

}
//fin


// mostrar detalle tabla temporal
function Detallefacturas(id) {

    var action = 'Detalletmpfact';
    var user = $('#txt_id').val();

    $.ajax({
        url: 'modelo/ingresofacturas.php',
        type: 'POST',
        async: true,
        data: { action: action, user: user },
        success: function(response) {


            if (response !== 'error') {


                var info = JSON.parse(response);

                $('#detalle_fact').html(info.detalle);
                $('#detalle_tlt_fact').html(info.totales);

                viewProcesarbtm();

            } else {

                //console.log('no se encontro datos');

                $('#detalle_fact').html('');
                $('#detalle_tlt_fact').html('');
            }

        },
        error: function(error) {}
    });
} // fin


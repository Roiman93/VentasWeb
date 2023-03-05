/** @format */

window.addEventListener("load", function () {
    //busquedas
    $("#c_cliente").focus();
    serchForDetalle();

    // ocultar
    $("#btn_new_cliente").slideUp();
});

// buscar clientes por cedula
function BuscarCliente() {
    var cc = $("#c_cliente").val();
    var action = "searchCliente";

    if (cc == "" || cc == 0) {
        swal({
            title: "Oops!",
            text: "Digite un Nuemero de Documento valido",
            icon: "warning",
            button: "ok",
        }).then((willDelete) => {
            if (willDelete) {
                $("#c_cliente").focus();
            }
        });
    } else {
        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: { action: action, cliente: cc },

            success: function (response) {
                if (response == 0) {
                    swal({
                        title: "Cedula No Registrada",
                        text: "Desea Registrar el Nuevo Cliente",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $("#nom_cliente").prop("disabled", false);
                            $("#nom2_cliente").prop("disabled", false);
                            $("#ap_cliente").prop("disabled", false);
                            $("#ap2_cliente").prop("disabled", false);
                            $("#idcliente").val("");
                            $("#nom_cliente").val("");
                            $("#nom2_cliente").val("");
                            $("#ap_cliente").val("");
                            $("#ap2_cliente").val("");
                            $("#nom_cliente").focus();

                            // MOSTRAR BOTON AGREGAR
                            $("#btn_new_cliente").slideDown();
                        } else {
                            // swal("!No se Realizo Ninguna Accion!");
                            $("#c_cliente").focus();
                        }
                    });
                } else {
                    var data = $.parseJSON(response);
                    $("#idcliente").val(data.id_cliente);
                    $("#nom_cliente").val(data.nombre_1);
                    $("#nom2_cliente").val(data.nombre_2);
                    $("#ap_cliente").val(data.apellido_1);
                    $("#ap2_cliente").val(data.apellido_2);

                    //ocultar boton
                    $("#btn_new_cliente").slideUp();
                    // bloque campos
                    $("#c_cliente").prop("disabled", true);
                    $("#idcliente").prop("disabled", true);
                    $("#nom_cliente").prop("disabled", true);
                    $("#nom2_cliente").prop("disabled", true);
                    $("#ap_cliente").prop("disabled", true);
                    $("#ap2_cliente").prop("disabled", true);
                    $("#txt_cod_producto").focus();
                }
            },
            error: function (error) {},
        });
    }
}
// fin

//buscar productos
function buscar_producto() {
    var pt = $("#txt_cod_producto").val();
    var action = "infoProducto";

    if (pt != "") {
        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: { action: action, producto: pt },
            success: function (response) {
                if (response != "error") {
                    var info = JSON.parse(response);
                    $("#id").html(info.id_producto);
                    $("#txt_descripcion").html(info.nombre);
                    $("#txt_existencia").html(info.stock);
                    $("#txt_cant_producto").val("1");
                    $("#txt_precio").html(info.precio_venta);
                    $("#txt_precio_total").html(
                        formatterPeso.format(info.precio_venta)
                    );

                    if ($("#txt_existencia").html() > 0) {
                        // activar cantidad
                        $("#txt_cant_producto").removeAttr("disabled");

                        $("#txt_cant_producto").focus();
                        $("#add_product_venta").slideDown();
                    } else {
                        // Bloquear cantidad
                        $("#txt_cant_producto").prop("disabled", true);
                        // ocultar agregar
                        $("#add_product_venta").slideUp();
                        $("#txt_cod_producto").focus();
                    }
                } else {
                    $("#id_producto").html("");
                    $("#txt_descripcion").html("-");
                    $("#txt_existencia").html("-");
                    $("#txt_cant_producto").html("0");
                    $("#txt_precio").html("0.00");
                    $("#txt_precio_total").html("0.00");

                    // Bloquear cantidad
                    $("#txt_cant_producto").prop("disabled", true);

                    // ocultar agregar
                    $("#add_product_venta").slideUp();
                    $("#txt_cod_producto").focus();
                }
            },
            error: function (error) {},
        });
    }
}
// fin

// fin --------

// validaciones

//validar buscar cliente
var elem = document.getElementById("c_cliente");
elem.onkeyup = function (e) {
    if (e.keyCode == 13) {
        BuscarCliente();
    }
};
//fin

// validar enter codigo producto
var txt_cod = document.getElementById("txt_cod_producto");
txt_cod.onkeyup = function (e) {
    if (e.keyCode == 13) {
        buscar_producto();
    }
};
//fin

// validar enter cantidad producto
var txt_cod = document.getElementById("txt_cant_producto");
txt_cod.onkeyup = function (e) {
    if (e.keyCode == 13) {
        ValidarCantidad();
    }
};

// validar cantidad antes de agregar
function ValidarCantidad() {
    var precio_total = $("#txt_cant_producto").val() * $("#txt_precio").html();
    var existencia = parseInt($("#txt_existencia").html());
    var pt = precio_total;
    $("#txt_precio_total").html(formatterPeso.format(pt));
    //$('#txt_precio_total').html(pt);

    // oculta el boton agregar si la cantidad es menor que 1
    if (
        $("#txt_cant_producto").val() < 1 ||
        isNaN($("#txt_cant_producto").val()) ||
        $("#txt_cant_producto").val() > existencia
    ) {
        $("#add_product_venta").slideUp();
    } else {
        $("#add_product_venta").slideDown();
        $("#add_product_venta").focus();
    }
}

// mostar/ ocultar boton procesar
function viewProcesar() {
    if ($("#detalle_venta tr").length > 0) {
        $("#btn_facturar_venta").show();
    } else {
        $("#btn_facturar_venta").hide();
    }
}
//fin

//fin------------

//Registros de datos

//crear clientes ventas
$("#btn_new_cliente").click(function (e) {
    e.preventDefault();
    var cc = $("#c_cliente").val();
    var nombre1 = $("#nom_cliente").val();
    var nombre2 = $("#nom2_cliente").val();
    var apellido1 = $("#ap_cliente").val();
    var apellido2 = $("#ap2_cliente").val();
    var action = "addCliente";

    if (
        $("#c_cliente").val() == "" ||
        $("#nom_cliente").val() == "" ||
        $("#ap_cliente") == "" ||
        $("#ap2_cliente").val() == ""
    ) {
        swal({
            title: "Oops!",
            text: "Llene todos los Campos Requeridos",
            icon: "warning",
            button: "ok",
        }).then((willDelete) => {
            if (willDelete) {
            }
        });
    } else {
        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: {
                action: action,
                cedula: cc,
                nombre1: nombre1,
                nombre2: nombre2,
                apellido1: apellido1,
                apellido2: apellido2,
            },

            success: function (response) {
                // console.log(response);
                if (response == "") {
                    swal({
                        title: "Guardado",
                        text: "Registro Almacenado Exitosamente!",
                        icon: "success",
                        button: "ok",
                    }).then((willDelete) => {
                        if (willDelete) {
                            //ocultar boton
                            $("#btn_new_cliente").slideUp();
                            // bloque campos
                            $("#idcliente").prop("disabled", true);
                            $("#nom_cliente").prop("disabled", true);
                            $("#nom2_cliente").prop("disabled", true);
                            $("#ap_cliente").prop("disabled", true);
                            $("#ap2_cliente").prop("disabled", true);
                            $("#txt_cod_producto").focus();
                        }
                    });
                } else {
                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un " + " " + response,
                        icon: "warning",
                        button: "ok",
                    }).then((willDelete) => {
                        if (willDelete) {
                            // $('#fecha_de').focus();
                        }
                    });
                }
            },
            error: function (error) {},
        });
    }
});
// fin

//agregar producto al detalle
$("#add_product_venta").click(function (e) {
    e.preventDefault();

    if ($("#txt_cant_producto").val() > 0) {
        var id_p = $("#id").html();
        var codproducto = $("#txt_cod_producto").val();
        var cantidad = $("#txt_cant_producto").val();
        var id = $("#txt_id").val();
        var action = "addProductoDetalle";

        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: {
                action: action,
                producto: id_p,
                cantidad: cantidad,
                token: id,
            },
            success: function (response) {
                if (response != "error") {
                    var info = JSON.parse(response);

                    $("#detalle_venta").html(info.detalle);
                    $("#detalle_totales").html(info.totales);

                    $("#txt_cod_producto").val("");
                    $("#txt_descripcion").html("-");
                    $("#txt_existencia").html("-");
                    $("#txt_cant_producto").html("0");
                    $("#txt_precio").html("0.00");
                    $("#txt_precio_total").html("0.00");

                    // Bloquear cantidad
                    $("#txt_cant_producto").prop("disabled", true);

                    // ocultar agregar
                    $("#add_product_venta").slideUp();

                    $("#txt_cod_producto").focus();
                    viewProcesar();
                } else {
                    console.log("no data");
                }
                viewProcesar();
            },
            error: function (error) {},
        });
    }
});
//fin

// procesar venta
$("#btn_facturar_venta").click(function (e) {
    e.preventDefault();

    var rows = $("#detalle_venta tr").length;
    var id = $("#txt_id").val();
    if (rows > 0) {
        var action = "procesarVenta";
        var codcliente = $("#idcliente").val();
        var usuario = $("#txt_usuario").val();
        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: {
                action: action,
                codcliente: codcliente,
                token: id,
                usuario: usuario,
            },
            success: function (response) {
                if (response != "error") {
                    swal({
                        title: "Facturado",
                        text: "Factura Guardada con Exito.",
                        icon: "success",
                        button: "ok",
                    }).then((willDelete) => {
                        if (willDelete) {
                            var info = JSON.parse(response);

                            generarPDF(info.codcliente, info.nofactura);
                            Limpiar_Formulario();
                            serchForDetalle();
                        }
                    });
                } else {
                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un error " + " " + response,
                        icon: "warning",
                        button: "ok",
                    }).then((willDelete) => {
                        if (willDelete) {
                            console.log("no hay datos");
                        }
                    });
                }
            },
            error: function (error) {},
        });
    }
});

//fin -------------

// cancelar venta
function CancelarVenta() {
    var rows = $("#detalle_venta tr").length;
    var id = $("#txt_id").val();
    if (rows > 0) {
        var action = "anularVenta";

        $.ajax({
            url: "modelo/ajax.php",
            type: "POST",
            async: true,
            data: { action: action, token: id },
            success: function (response) {
                if (response != "error") {
                    swal({
                        title: "Factura Cancelada",
                        text: "Se Borraran la información.",
                        icon: "success",
                        button: "ok",
                    }).then((willDelete) => {
                        if (willDelete) {
                            Limpiar_Formulario();
                            serchForDetalle();
                        }
                    });
                }
            },
            error: function (error) {},
        });
    } else {
        Limpiar_Formulario();
    }
}
// fin

// eliminar producto detalle temporal venta
function del_producto_detalle(correlativo) {
    var action = "delProductoDetalle";
    var id_detalle = correlativo;
    var id = $("#txt_id").val();

    $.ajax({
        url: "modelo/ajax.php",
        type: "POST",
        async: true,
        data: { action: action, id_detalle: id_detalle, token: id },
        success: function (response) {
            if (response != "error") {
                var info = JSON.parse(response);

                $("#detalle_venta").html(info.detalle);
                $("#detalle_totales").html(info.totales);

                $("#txt_cod_producto").val("");
                $("#txt_descripcion").html("-");
                $("#txt_existencia").html("-");
                $("#txt_cant_producto").html("0");
                $("#txt_precio").html("0.00");
                $("#txt_precio_total").html("0.00");
                // Bloquear cantidad
                $("#txt_cant_producto").prop("disabled", true);
                // ocultar agregar
                $("#add_product_venta").slideUp();
            } else {
                $("#detalle_venta").html("");
                $("#detalle_totales").html("");
            }
            viewProcesar();
        },
        error: function (error) {},
    });
}

// mostrar detalle tabla temporal
function serchForDetalle(id) {
    var action = "serchForDetalle";
    var user = $("#txt_id").val();

    $.ajax({
        url: "../models/ajax.php",
        type: "POST",
        async: true,
        data: { action: action, user: user },
        success: function (response) {
            if (response != "error") {
                var info = JSON.parse(response);

                $("#detalle_venta").html(info.detalle);
                $("#detalle_totales").html(info.totales);
            } else {
                console.log("no data");
                $("#detalle_venta").html("");
                $("#detalle_totales").html("");
            }
            viewProcesar();
        },
        error: function (error) {},
    });
}

//mostrar factura
function viwfacturas(e) {
    var no = $("#txt_nofact").val();
    var action = "BuscarFactura";

    $.ajax({
        url: "modelo/ajax.php",
        type: "POST",
        async: true,
        data: { action: action, nofactura: no },
        success: function (response) {
            if (response != "error") {
                //console.log(response);
                var info = JSON.parse(response);
                //console.log(info);
                $("#detalle_factura").html(info.detalle);
            } else {
                console.log("no data");
                $("#detalle_factura").html("");
            }
        },
        error: function (error) {},
    });
}

function Cancelar() {
    var url = "?opcion=ventas";
    location.href = url;
}

// limpiar todo el formulario
function Limpiar_Formulario() {
    //Limpiar_Modal();
    $("#c_cliente").val("");
    $("#nom_cliente").val("");
    $("#nom2_cliente").val("");
    $("#ap_cliente").val("");
    $("#ap2_cliente").val("");

    //tabla
    $("#txt_cod_producto").val("");
    $("#id").html("");
    $("#txt_descripcion").html("-");
    $("#txt_existencia").html("-");
    $("#txt_cant_producto").val("0");
    $("#txt_precio").html("0.00");
    $("#txt_precio_total").html("0.00");
    // ocultar
    $("#btn_new_cliente").slideUp();
    // Desbloquear
    $("#txt_cant_producto").prop("disabled", true);

    $("#c_cliente").prop("disabled", false);

    $("#c_cliente").focus();
} //fin

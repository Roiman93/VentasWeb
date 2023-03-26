/** @format */
/*  Ejecuta  el codigo luego de cargar todo el html */
window.addEventListener("load", function () {
    $("#c_cliente").focus();
});

// fin

// fin --------

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
}

/* nuevo codigo limpio  */

/* consulta un cliente por cedula */
async function consultarAPI_Clientes() {
    /*variabes*/
    var doc_client = $("#c_cliente").val();

    const datos = new FormData();
    datos.append("date", doc_client);

    try {
        /* Petición hacia la api */
        const url = "http://localhost:8888/api/cliente";
        const respuesta = await fetch(url, {
            method: "POST",
            body: datos,
        });
        data = await respuesta.json();

        mostrar_reslutados(data);
    } catch (error) {}
}
/* muestra el resultado de la consulta cliente */
function mostrar_reslutados(data) {
    if (data.resultado == null) {
        console.log("no se encontraron resultados");
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
                $("#txt_cod_producto").prop("disabled", true);
                $("#idcliente").val("");
                $("#nom_cliente").val("");
                $("#nom2_cliente").val("");
                $("#ap_cliente").val("");
                $("#ap2_cliente").val("");
                $("#nom_cliente").focus();

                // MOSTRAR BOTON AGREGAR
                $("#btn_new_cliente").slideDown();
                $("#btn_cancel_cliente").slideDown();
            } else {
                // swal("!No se Realizo Ninguna Accion!");
                $("#c_cliente").focus();
            }
        });
    } else {
        $("#idcliente").val(data.resultado["cedula"]);
        $("#nom_cliente").val(data.resultado["nombre_1"]);
        $("#nom2_cliente").val(data.resultado["nombre_2"]);
        $("#ap_cliente").val(data.resultado["apellido_1"]);
        $("#ap2_cliente").val(data.resultado["apellido_2"]);

        /* ocultar boton */
        $("#btn_new_cliente").slideUp();
        $("#btn_cancel_cliente").slideUp();

        /* habilitar boton codigo productos */
        $("#txt_cod_producto").prop("disabled", false);

        /* bloque campos */
        $("#c_cliente").prop("disabled", true);
        $("#idcliente").prop("disabled", true);
        $("#nom_cliente").prop("disabled", true);
        $("#nom2_cliente").prop("disabled", true);
        $("#ap_cliente").prop("disabled", true);
        $("#ap2_cliente").prop("disabled", true);
        $("#txt_cod_producto").focus();
    }
}

/* busca un producto por el codigo */
async function consultarAPi_productos() {
    /*variabes*/
    var codigo = $("#txt_cod_producto").val();

    const datos = new FormData();
    datos.append("data", codigo);

    try {
        /* Petición hacia la api */
        const url = "http://localhost:8888/api/get_stock_producto";
        const respuesta = await fetch(url, {
            method: "POST",
            body: datos,
        });
        data = await respuesta.json();

        mostrar_resultado_producto(data);
    } catch (error) {}
}

/* muestra el resultado de la consulta producto */
function mostrar_resultado_producto(data) {
    if (data.resultado == null) {
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
    } else {
        $("#id").html(data.resultado["id_producto"]);
        $("#txt_descripcion").html(data.resultado["nombre"]);
        $("#txt_existencia").html(data.resultado["stock"]);
        $("#txt_cant_producto").val("1");
        $("#txt_precio").html(data.resultado["precio_venta"]);
        $("#txt_precio_total").html(
            formatterPeso.format(data.resultado["precio_venta"])
        );

        // if ($("#txt_existencia").html() > 0) {
        //     // activar cantidad
        //     $("#txt_cant_producto").removeAttr("disabled");

        //     $("#txt_cant_producto").focus();
        //     $("#add_product_venta").slideDown();
        // } else {
        //     // Bloquear cantidad
        //     $("#txt_cant_producto").prop("disabled", true);
        //     // ocultar agregar
        //     $("#add_product_venta").slideUp();
        //     $("#txt_cod_producto").focus();
        // }
    }
}

/* agregar producto al detalle de la factura  */
async function agregar_producto() {
    /* captura de datos */
    var id_p = $("#id").html();
    var cantidad = $("#txt_cant_producto").val();
    var pventa = $("#txt_precio").html();
    var token = $("#txt_token").val();
    var valoresAceptados = /^[0-9]+$/;

    if (cantidad.match(valoresAceptados) && cantidad !== "") {
        // alert("Es numérico");

        const datos = new FormData();
        /* datos.append("id", null); */
        datos.append("id_producto", id_p);
        datos.append("cantidad", cantidad);
        datos.append("precio_venta", pventa);
        datos.append("mesa", null);
        datos.append("token_user", token);

        try {
            /* Petición hacia la api */
            const url = "http://localhost:8888/api/get_add_detalle_producto";
            const respuesta = await fetch(url, {
                method: "POST",
                body: datos,
            });
            var data = await respuesta.json();
            mostras_detalle_producto(data);
        } catch (error) {}
    } else {
        alert("No es numérico");
    }
}

function mostras_detalle_producto(data) {
    if (data.resultado == null) {
        alert("no se recibio respuesta");
    } else {
        $("#detalle_venta").html(data.resultado);
        $("#txt_iva").html(" $" + data.resumen.iva);
        $("#txt_subtotal").html(" $" + data.resumen.sub_total);
        $("#txt_total").html(" $" + data.resumen.total);

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
    }
}
//fin

/*  validaciones boton enter */

/* buscar por cedual cuando se presiona enter*/
var elem = document.getElementById("c_cliente");
elem.onkeyup = function (e) {
    if (e.keyCode == 13) {
        consultarAPI_Clientes();
    }
};

/*  busca el producto x codigo cuando se presiona enter  */
var txt_cod = document.getElementById("txt_cod_producto");
txt_cod.onkeyup = function (e) {
    if (e.keyCode == 13) {
        consultarAPi_productos();
    }
};

/* Ingresa la cantidad cuando se preciona enter */
var txt_cod = document.getElementById("txt_cant_producto");
txt_cod.onkeyup = function (e) {
    if (e.keyCode == 13) {
        ValidarCantidad();
    }
};

$("#add_producto").click(function (e) {
    agregar_producto();
});

/* verificaciones  */

/* compara la cantidad con la existencia antes de agregarla */
function ValidarCantidad() {
    var precio_total = $("#txt_cant_producto").val() * $("#txt_precio").html();
    var existencia = parseInt($("#txt_existencia").html());
    var pt = precio_total;
    // $("#txt_precio_total").html(formatterPeso.format(pt));

    // /*  oculta el boton agregar si la cantidad es menor que 1 */
    // if (
    //     $("#txt_cant_producto").val() !== 1 ||
    //     isNaN($("#txt_cant_producto").val()) ||
    //     $("#txt_cant_producto").val() == existencia
    // ) {
    //     $("#add_product_venta").slideUp();
    // } else {
    //     $("#add_product_venta").slideDown();
    //     $("#add_product_venta").focus();
    // }
}

/* muestra el boton procesar si existen registros */
function viewProcesar() {
    if ($("#detalle_venta tr").length > 0) {
        $("#btn_facturar_venta").show();
    } else {
        $("#btn_facturar_venta").hide();
    }
}

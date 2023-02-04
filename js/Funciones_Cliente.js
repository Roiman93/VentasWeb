//Registro de clientes 
$('#btn_new_cliente').click(function(e) {
    e.preventDefault();
    var cc = $('#c_cliente').val();
    var nombre1 = $('#nom_cliente').val();
    var nombre2 = $('#nom2_cliente').val();
    var apellido1 = $('#ap_cliente').val();
    var apellido2 = $('#ap2_cliente').val();
    var action = 'addCliente';

    if (($('#c_cliente').val() == '' || $('#nom_cliente').val() == '' || $('#ap_cliente') == '' || $('#ap2_cliente').val() == '')) {

        swal({
            title: "Oops!",
            text: "Llene todos los Campos Requeridos",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {


            }
        });

    } else {



        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, cedula: cc, nombre1: nombre1, nombre2: nombre2, apellido1: apellido1, apellido2: apellido2 },


            success: function(response) {
                // console.log(response);
                if (response == '') {

                    swal({
                        title: "Guardado",
                        text: "Registro Almacenado Exitosamente!",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            cancelar();



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
                            // $('#fecha_de').focus();

                        }
                    });

                }


            },
            error: function(error) {}
        });
    }
});
// fin 

//modificar de clientes 
$('#btn_mod_cliente').click(function(e) {
    e.preventDefault();
    var id = $('#id_cliente').val();
    var cc = $('#c_cliente').val();
    var nombre1 = $('#nom_cliente').val();
    var nombre2 = $('#nom2_cliente').val();
    var apellido1 = $('#ap_cliente').val();
    var apellido2 = $('#ap2_cliente').val();
    var action = 'updateCliente';

    if (($('#c_cliente').val() == '' || $('#nom_cliente').val() == '' || $('#ap_cliente') == '' || $('#ap2_cliente').val() == '')) {

        swal({
            title: "Oops!",
            text: "Llene todos los Campos Requeridos",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {


            }
        });

    } else {



        $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, id_cliente: id, cedula: cc, nombre1: nombre1, nombre2: nombre2, apellido1: apellido1, apellido2: apellido2 },


            success: function(response) {
                // console.log(response);
                if (response == '') {

                    swal({
                        title: "Actualizado",
                        text: "Registro Almacenado Exitosamente!",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {
                            cancelar();
                            //ocultar boton
                            // $('#btn_new_cliente').slideUp();
                            // // bloque campos
                            // $('#idcliente').prop( "disabled", true );
                            // $('#nom_cliente').prop( "disabled", true );
                            // $('#nom2_cliente').prop( "disabled", true );
                            // $('#ap_cliente').prop( "disabled", true );
                            // $('#ap2_cliente').prop( "disabled", true );
                            // $('#txt_cod_producto').focus();



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
                            // $('#fecha_de').focus();

                        }
                    });

                }


            },
            error: function(error) {}
        });
    }
});
// fin 

function cancelar() {

    var url = '?opcion=clientes';
    location.href = url;
}
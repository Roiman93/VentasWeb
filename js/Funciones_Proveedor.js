//Registro de Provedores
function Guardar() {

    var nit = $('#nit').val();
    var digito = $('#digito').val();
    var nombre = $('#nombre').val();
    var direccion = $('#direccion').val();
    var telefono = $('#telefono').val();
    var action = 'AddProveedor';

    if (($('#nit').val() == '' || $('#digito').val() == '' || $('#nombre') == '' || $('#direccion').val() == '' || $('#telefono').val() == '')) {

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
            data: { action: action, nit: nit, dg: digito, nombre: nombre, direccion: direccion, telefono: telefono },


            success: function(response) {
                // console.log(response);

                var data = $.parseJSON(response);

                if (isEmpty(data.error)) {

                    swal({
                        title: "Guardado",
                        text: "Registro Almacenado Exitosamente!",
                        icon: "success",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            limpiar_Frm();


                        }
                    });

                } else if (isEmpty(data.id_provedor)) {

                    //console.log('nit duplicado');

                    swal({
                        title: "Oops!",
                        text: "Ha ocurrido un Error:" + " " + response,
                        icon: "warning",
                        button: "ok",
                    })

                    .then((willDelete) => {
                        if (willDelete) {

                            limpiar_Frm();
                            $('#nit').focus();



                        }
                    });

                }

            },
            error: function(error) {}
        });
    }
}
// fin 

//modificar de Proveedor
function Modificar() {

    var id = $('#id_prov').val();
    var nit = $('#nit').val();
    var digito = $('#digito').val();
    var nombre = $('#nombre').val();
    var direccion = $('#direccion').val();
    var telefono = $('#telefono').val();
    var action = 'UpdateProveedor';

    if (($('#nit').val() == '' || $('#digito').val() == '' || $('#nombre') == '' || $('#direccion').val() == '' || $('#telefono').val() == '')) {

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
            data: { action: action, nit: nit, dg: digito, nombre: nombre, direccion: direccion, telefono: telefono, id: id },


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
    }
}
// fin 

function cancelar() {

    var url = '?opcion=provedores';
    location.href = url;

}

function limpiar_Frm() {

    $('#nit').val('');
    $('#digito').val('');
    $('#nombre').val('');
    $('#direccion').val('');
    $('#telefono').val('');

}

//fin
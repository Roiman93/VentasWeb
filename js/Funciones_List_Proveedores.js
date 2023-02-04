//buscar cliente con filtro
function Buscar() {

    var buscar = $('#txt_numero').val();
    var filtro = $('#filtro').val();

    var action = 'BuscarProveedor';

    $.ajax({
        url: 'modelo/ingresofacturas.php',
        type: 'POST',
        async: true,
        data: { action: action, buscar: buscar, filtro: filtro },
        success: function(response) {


            if (response != 'error') {


                var info = JSON.parse(response);

                $('#Tbl_Registro').html(info.detalle);
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

                        $('#Tbl_Registro').html('');

                    }
                });

            }

        },
        error: function(error) {}
    });



}
//fin


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
                            Buscar();



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


// validacion para editar
function Validar_Edita_Proveedor(url) {

    var id = $(this).attr('fac');

    swal({
            title: "¿Realmente Deseas Editar el Registro?",
            text: "Se cargara la informacion del Registro Selecionado...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {



                var action = 'GetProveedor';
                // location.href=url;
                // popUp(url);

                $.ajax({
                    url: 'modelo/ingresofacturas.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, cliente: id },

                    success: function(response) {
                        // console.log(response);

                        if (response == '') {




                        } else {

                            $('.ui.modal')
                                .modal('show');

                            var data = $.parseJSON(response);
                            $('#id_prov').val(data.id_provedor);
                            $('#nit').val(data.nit);
                            $('#digito').val(data.dg);
                            $('#nombre').val(data.nombre);
                            $('#direccion').val(data.direccion);
                            $('#telefono').val(data.telefono);
                            //$('#ap2_cliente').val(data.apellido_2);




                        }
                    },
                    error: function(error) {}
                });




            } else {
                swal("!No se realizo ninguna Acción!");
            }
        });



}
//fin

// validaciones  para eliminar 
function ValidarRemove(url) {

    swal({
            title: "¿Seguro que deseas Eliminar el Registro?",
            text: "No podrás deshacer este paso...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var fac = $(this).attr('fac');
                var action = 'RemoveCliente';

                $.ajax({
                    url: 'modelo/ingresofacturas.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, Proveedor: fac },


                    success: function(response) {
                        // console.log(response);
                        if (response == '') {


                            swal({
                                title: "Registro Eliminado",
                                text: "!Exitoso!",
                                icon: "success",
                                button: "ok",
                            })

                            .then((willDelete) => {
                                if (willDelete) {

                                    Buscar();



                                }
                            });

                        } else {

                            swal({
                                title: "Oops!",
                                text: "Ha ocurrido un Error: " + " " + response,
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
                swal("!No se Realizo Ningun Cambio!");
            }
        });


}
//fin


// validar enter buscar
var txt_cod = document.getElementById("txt_numero");
txt_cod.onkeyup = function(e) {
        if (e.keyCode == 13) {
            Buscar();
        }
    }
    //fin

// Mostar mensajes en los iconos
function Iconos() {

    $('.ui.icon')
        .popup({
            inline: true
        });

}


function Cancelar() {

    var url = '?opcion=List_Proveedor';
    location.href = url;

}
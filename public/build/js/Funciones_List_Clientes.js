//buscar cliente con filtro
function Buscar() {


    var buscar = $('#txt_numero').val();
    var filtro = $('#filtro').val();

    var action = 'BuscarCliente';

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, buscar: buscar, filtro: filtro },
        success: function(response) {


            if (response != 'error') {


                var info = JSON.parse(response);

                $('#Tbl_Registro').html(info.detalle);
                Iconos();
                EjecutaX("C:/xampp/htdocs/py/Python/Whatsapp.exe");


            } else {
                $('#Tbl_Registro').html('');


            }

        },
        error: function(error) {}
    });



}
//fin


// validacion para editar
function Validar_Edita_Cliente(url) {

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



                var action = 'GetCliente';
                // location.href=url;
                // popUp(url);

                $.ajax({
                    url: 'modelo/ajax.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, cliente: id },

                    success: function(response) {
                        // console.log(response);

                        if (response == '') {


                            // swal({
                            //   title: "Cedula No Registrada",
                            //   text: "Desea Registrar el Nuevo Cliente",
                            //   icon: "warning",
                            //   buttons: true,
                            //   dangerMode: true,
                            // })
                            // .then((willDelete) => {
                            //   if (willDelete) {


                            //     $('#idcliente').val('');
                            //     $('#nom_cliente').val('');
                            //     $('#nom2_cliente').val('');
                            //     $('#ap_cliente').val('');
                            //     $('#ap2_cliente').val('');
                            //     $('#nom_cliente').focus();



                            //   } else {
                            //     // swal("!No se Realizo Ninguna Accion!");

                            //   }
                            // });


                        } else {

                            $('.ui.modal')
                                .modal('show');

                            var data = $.parseJSON(response);
                            $('#id_cliente').val(data.id_cliente);
                            $('#c_cliente').val(data.cedula);
                            $('#nom_cliente').val(data.nombre_1);
                            $('#nom2_cliente').val(data.nombre_2);
                            $('#ap_cliente').val(data.apellido_1);
                            $('#ap2_cliente').val(data.apellido_2);




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


// modificar 
function Modificar() {

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
                            // $('#fecha_de').focus();

                        }
                    });

                }


            },
            error: function(error) {}
        });
    }



}
// fin

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
                    url: 'modelo/ajax.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, Cliente: fac },


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

function popUp(URL) {
    window.open(URL, 'Admin', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=300,height=200,left = 390,top = 50');
}

function Cancelar() {

    var url = '?opcion=List_Cliente';
    location.href = url;

}


function RunFile() {
    WshShell = new ActiveXObject("WScript.Shell");
    WshShell.Run("C:/xampp/htdocs/py/Python/Whatsapp.exe", 1, false);
}

function EjecutaX(cual) {
    try {
        var ComandoExe;
        ComandoExe = new ActiveXObject("WScript.Shell");
        ComandoExe.Run(cual)
    } catch (e) {
        alert("No dispone del programa necesario para la acción")
    }
}
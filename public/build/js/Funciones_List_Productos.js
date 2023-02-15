//buscar producto con filtro
function Buscar() {


    var buscar = $('#txt_numero').val();
    var filtro = $('#filtro').val();

    var action = 'BuscarProducto';

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, buscar: buscar, filtro: filtro },
        success: function(response) {

            console.log(response);

            if (response != 'error') {


                var info = JSON.parse(response);

                $('#Tbl_Registro_Producto').html(info.detalle);
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

                        $('#Tbl_Registro_Producto').html('');

                    }
                });



            }

        },
        error: function(error) {}
    });



}
//fin

//modificar productos
function Modificar() {
    var id = $('#id').val();
    var codigo = $('#codigo').val();
    var nombre = $('#nombre').val();
    var tipo = $('#tipo').val();
    var precio_compra = $('#precio_c').val();
    var precio_venta = $('#precio_v').val();
    var action = 'UpdateProducto';

    if (($('#codigo').val() == '' || $('#nombre').val() == '' || $('#tipo') == '' || $('#precio_v').val() == '')) {

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
            data: { action: action, codigo: codigo, nombre: nombre, tipo: tipo, precio_compra: precio_compra, precio_venta: precio_venta, id: id },


            success: function(response) {
                // console.log(response);
                if (response == '') {

                    swal({
                        title: "Actualizado",
                        text: "Registro Actualizado Exitosamente!",
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
}
// fin 

// validacion para editar
function Validar_Edit_Producto(url) {

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



                var action = 'GetProducto';


                $.ajax({
                    url: 'modelo/ajax.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, producto: id },

                    success: function(response) {
                        // console.log(response);

                        if (response == '') {





                        } else {

                            $('.ui.modal')
                                .modal('show');

                            var data = $.parseJSON(response);
                            $('#id').val(data.id_producto);
                            $('#codigo').val(data.codigo);
                            $('#nombre').val(data.nombre);
                            $('#tipo').val(data.tipo);
                            $('#precio_c').val(data.precio_compra);
                            $('#precio_v').val(data.precio_venta);







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
function ValidarRemove_P(url) {

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
                var action = 'RemoveProducto';

                $.ajax({
                    url: 'modelo/ajax.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, id: fac },


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

                                    cancelar();



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

// Mostar mensajes en los iconos
function Iconos() {

    $('.ui.icon')
        .popup({
            inline: true
        });

}
//fin

function cancelar() {

    var url = '?opcion=List_Producto';
    location.href = url;
}
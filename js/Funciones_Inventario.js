//buscar inventario por numero
function Buscar_inventario() {


    var buscar = $('#txt_buscar').val();
    var filtro = $('#filtro').val();

    var action = 'Buscarinvent';

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, buscar: buscar, filtro: filtro },
        success: function(response) {


            if (response != 'error') {

                //console.log(response);
                var info = JSON.parse(response);
                //console.log(info);
                $('#detalle_invent').html(info.detalle);


            } else {

                swal({
                    title: "Oops!",
                    text: "No se Encontro Registro" + " ",
                    icon: "warning",
                    button: "ok",
                })

                .then((willDelete) => {
                    if (willDelete) {

                        $('#detalle_invent').html('');

                    }
                });



            }

        },
        error: function(error) {}
    });



}
//fin



// validar enter buscar
var txt_cod = document.getElementById("txt_buscar");
txt_cod.onkeyup = function(e) {
        if (e.keyCode == 13) {
            Buscar_inventario();
        }
    }
    //fin
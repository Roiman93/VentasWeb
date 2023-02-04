//menu 
$(document).ready(function() {
    $(".ui.toggle.button").click(function() {
        $(".mobile.only.grid .ui.vertical.menu").toggle(100);
    });
});
//fin

$(document)
    .ready(function() {

        // show dropdown on hover
        $('.main.menu  .ui.dropdown').dropdown({
            on: 'hover'
        });
    });



/* Cuando el usuario hace clic en el botón,
alternar entre ocultar y mostrar el contenido desplegable */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    // fin

// validaciones

// validacion para editar
function validarEdit(url) {


    swal({
            title: "¿Realmente deseas editar el Registro?",
            text: "Se cargara la informacion del Registro selecionado...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                location.href = url;



            } else {
                swal("!No se realizo ninguna Acción!");
            }
        });



}
//fin

// validaciones  para eliminar
function validarDel(url) {

    swal({
            title: "¿Seguro que deseas eliminar el Registro?",
            text: "No podrás deshacer este paso...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                swal("!Registro Eliminado!", {
                    icon: "success",
                });

                location.href = url;


            } else {
                swal("!No se Realizo Ningun Cambio!");
            }
        });


}
//fin

// validar
function validar(url) {
    if (confirm("Desea e el usuario")) {
        location.href = url;
    }
}
//fin  

//Cancelar Mesa
function validarAnularMesa() {

    var mesa = $('#txtmesa').val();

    if (isEmpty(mesa)) {

        swal({
            title: "Oops!",
            text: "Ingrese La mesa que desea cancelar ",
            icon: "warning",
            button: "ok",
        })

        .then((willDelete) => {
            if (willDelete) {
                $('#txtmesa').focus();

            }
        });

    } else {



        swal({
                title: "¿Realmente deseas cancelar la Mesa?",
                text: "Se Borrara toda la informacion de la mesa No." + " " + mesa,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {


                    cancelar_mesa();


                } else {
                    swal("!No se realizo ninguna Acción!");
                }
            });
    }


}
//fin

//Cancelar Venta
function validarCancelarVenta() {



    swal({
            title: "¿Realmente deseas cancelar la Factura?",
            text: "Se Borrara toda la informacion...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                CancelarVenta();


            } else {
                swal("!No se realizo ninguna Acción!");
            }
        });



}
//fin


// anulacion de ventas
function anular_vent(url) {

    swal({
            title: "¿Seguro que deseas Anular la Factura?",
            text: "No podrás deshacer este paso...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                swal("!Registro Eliminado!", {
                    icon: "success",
                });

                // location.href=url;
                // var nofactur = $('#nfct').html();
                var nofactur = $(this).attr('f');
                var action = 'infoFactura';

                $.ajax({
                    url: 'modelo/ajax.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, nofactur: nofactur },
                    success: function(response) {


                        if (response != 'error') {

                            swal({
                                title: "Factura Anulada",
                                text: "Registro Anulado Exitosamente!",
                                icon: "success",
                                button: "ok",
                            })

                            .then((willDelete) => {
                                if (willDelete) {

                                    var info = JSON.parse(response);
                                    // console.log(info);
                                    viwfacturas();



                                }
                            });


                        } else {

                            swal({
                                title: "Oops!",
                                text: "Ha ocurrido un error " + " " + response,
                                icon: "warning",
                                button: "ok",
                            })

                            .then((willDelete) => {
                                if (willDelete) {
                                    console.log('no data');

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

function anular_comp(url) {


    swal({
            title: "¿Seguro que deseas Anular la Factura Compra?",
            text: "No podrás deshacer este paso...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {


                swal("!Registro Eliminado!", {
                    icon: "success",
                });




                var nofactur = $(this).attr('f');
                var action = 'anulFactura';

                $.ajax({
                    url: 'modelo/ingresofacturas.php',
                    type: 'POST',
                    async: true,
                    data: { action: action, nofactur: nofactur },
                    success: function(response) {


                        if (response != 'error') {
                            var info = JSON.parse(response);
                            swal({
                                title: "Factura Numero: " + info.nofactura + " Anulada",
                                text: "Valor de la Factura: " + info.totalfactura,
                                icon: "success",
                                button: "ok",
                            })

                            .then((willDelete) => {
                                if (willDelete) {


                                    var url = '?opcion=list_compras';
                                    location.href = url;



                                }
                            });


                        } else {

                            swal({
                                title: "Oops!",
                                text: "Ha ocurrido un error " + " " + response,
                                icon: "warning",
                                button: "ok",
                            })

                            .then((willDelete) => {
                                if (willDelete) {
                                    console.log('no data');

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


//facturas
function generarPDF(cliente, factura) {

    var ancho = 1000;
    var alto = 800;
    // Calculara posicion x,y para centar la ventana
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    $url = 'factura/generaFactura.php?cl=' + cliente + '&f=' + factura;
    window.open($url, "factura", "left" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + ",scrolbar=si,location=no,resizable=si,menubar=no");

}
//fin

// factura compras


//conversion  moneda
const formatterPeso = new Intl.NumberFormat('es-CO', {
    style: 'currency',
    currency: 'COP',
    minimumFractionDigits: 0
})



function valideKey(evt) {

    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;

    if (code == 8) { // backspace.
        return true;
    } else if (code >= 48 && code <= 57) { // is a number.
        return true;
    } else { // other keys.

        return false;
    }


}





function lettersOnly(evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 65 || charCode > 90) &&
        (charCode < 97 || charCode > 122)) {
        //  alert("Enter letters only.");
        return false;
    }
    return true;
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}


function isKeyExists(obj, key) {
    if (obj[key] == undefined) {
        return false;
    } else {
        return true;
    }
}
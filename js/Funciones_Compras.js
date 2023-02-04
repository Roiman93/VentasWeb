 // buscar compra por numero 
 function Buscar() {

     var no = $('#txt_nofact').val();
     var action = 'BuscarCompra';

     $.ajax({
         url: 'modelo/ingresofacturas.php',
         type: 'POST',
         async: true,
         data: { action: action, nofactura: no },
         success: function(response) {


             if (response != 'error') {

                 //console.log(response);
                 var info = JSON.parse(response);
                 console.log(info);
                 $('#detalle_compras').html(info.detalle);

             } else {

                 swal({
                     title: "Oops!",
                     text: "No se Encontro Registro" + " ",
                     icon: "warning",
                     button: "ok",
                 })

                 .then((willDelete) => {
                     if (willDelete) {

                         $('#detalle_compras').html('');

                     }
                 });

             }

         },
         error: function(error) {}
     });
 }
 //fin


 // buscar compra por fechas
 function Buscar_Fecha() {

     var no = $('#txt_nofact').val();
     var de = $('#fecha_de').val();
     var a = $('#fecha_a').val();
     var action = 'Buscarcompraf';

     $.ajax({
         url: 'modelo/ingresofacturas.php',
         type: 'POST',
         async: true,
         data: { action: action, nofactura: no, fecha_de: de, fecha_a: a },
         success: function(response) {


             if (response != 'error') {

                 //console.log(response);
                 var info = JSON.parse(response);
                 console.log(info);
                 $('#detalle_compras').html(info.detalle);

             } else {
                 $('#detalle_compras').html('');
                 //console.log('no data');
             }

         },
         error: function(error) {}
     });



 }
 //fin



 // validar inpresion de factura
 function impr(url) {

     swal({
             title: "¿Seguro que deseas Imprimir la Factura?",
             text: "...",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         })
         .then((willDelete) => {
             if (willDelete) {
                 var codCliente = $(this).attr('cl');
                 var noFactura = $(this).attr('fac');
                 generarPDF(codCliente, noFactura);

             } else {
                 swal("!No se Realizo Ningun Cambio!");
             }
         });

 }
 //fin


 //  function anular_comp(url){

 //     if (confirm("Realmente desea Anular la Factura")){


 //           var no =  $('#txt_nofact').val();
 //           var nofactur = $('#nfct').html();
 //           var action = 'anulFactura';

 //            $.ajax({
 //                  url: 'modelo/ingresofacturas.php',
 //                  type: 'POST',
 //                  async: true,
 //                  data: { action: action, nofactur: nofactur,no:no },
 //                  success: function (response) {


 //                  if(response != 'error')
 //                  {

 //                   console.log(response);
 //                   var info = JSON.parse(response);
 //                   //console.log(info);
 //                   $('#detalle_compras').html(info.detalle);
 //                   viwcompras();



 //                  }else{
 //                    console.log('no data');
 //                  }

 //                },
 //                error: function (error) {
 //                }
 //             });

 //      }

 //    }
 //    //fin


 //validar buscar 
 var elem = document.getElementById("txt_nofact");
 elem.onkeyup = function(e) {

         if (e.keyCode == 13) {

             Buscar();

         }
     }
     //fin

 // validar inpresion de factura compra
 function impr(url) {

     swal({
             title: "¿Seguro que deseas Imprimir la Factura de Compra?",
             text: "...",
             icon: "warning",
             buttons: true,
             dangerMode: true,
         })
         .then((willDelete) => {
             if (willDelete) {
                 var CodProvedor = $(this).attr('cl');
                 var noFactura = $(this).attr('fac');
                 GenerarPDFCompras(CodProvedor, noFactura);

             } else {
                 swal("!No se Realizo Ningun Cambio!");
             }
         });

 }
 //fin


 //facturas
 function GenerarPDFCompras(provedor, factura) {

     var ancho = 1000;
     var alto = 800;
     // Calculara posicion x,y para centar la ventana
     var x = parseInt((window.screen.width / 2) - (ancho / 2));
     var y = parseInt((window.screen.height / 2) - (alto / 2));

     $url = 'factura/GeneraFactura_Compra.php?cl=' + provedor + '&f=' + factura;
     window.open($url, "factura", "left" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + ",scrolbar=si,location=no,resizable=si,menubar=no");

 }
 //fin
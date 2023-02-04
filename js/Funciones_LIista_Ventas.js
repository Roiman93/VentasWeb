// buscar factura por numero 
function Buscar(){
    
 
   
       var no = $('#txt_nofact').val();
       var action = 'BuscarFactura';
 
           $.ajax({
           url: 'modelo/ajax.php',
           type: 'POST',
           async: true,
           data: { action: action,nofactura:no },
           success: function (response) {
           
             
           if(response != 'error')
           {
              
            //console.log(response);
            var info = JSON.parse(response);
            //console.log(info);
            $('#detalle_factura').html(info.detalle);
            Iconos();
 
           }else{
             console.log('no data');
           }
           
         },
           error: function (error) {
         }
      });
 
    
 
  }
 //fin
 // buscar factura por fechas
 $('#btn_buscar_fecha').click(function(e){
    e.preventDefault();
 
     
       var no =  $('#txt_nofact').val();
       var de = $('#fecha_de').val();
       var a = $('#fecha_a').val();
       var action = 'BuscarFactura_fecha';
       
        
         if(($('#fecha_de').val() =='' || $('#fecha_a').val()=='') )
         {
 
            
           swal({
             title: "Oops!",
             text: "Selecione un  rango de Fechas",
             icon: "warning",
             button: "ok",
             })
 
             .then((willDelete) => {
             if (willDelete) {
               $('#fecha_de').focus();
                 
             } 
             });
         
 
 
         }else{

               $.ajax({
               url: 'modelo/ajax.php',
               type: 'POST',
               async: true,
               data: { action:action, nofactura:no, fecha_de:de, fecha_a:a },
               success: function (response) {
               
                 
               if(response != '')
               {
 
               var info = JSON.parse(response);
               $('#detalle_factura').html(info.detalle);
 
               }else{
 
                 console.log('no data');
               }
               
             },
               error: function (error) {
             }
           });
         }
    
 
  });
 //fin


 

  // validar inpresion de factura
  function impr(url){
       
    swal({
      title: "¿Seguro que deseas Imprimir la Factura?",
      text: "...",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        var codCliente =$(this).attr('cl');
        var noFactura = $(this).attr('fac');
        generarPDF(codCliente,noFactura);
        
      } else {
        swal("!No se Realizo Ningun Cambio!");
      }
    });

  }
 //fin

//mostrar facturas
function viwfacturas(e){

  var no = $('#txt_nofact').val();
        var action = 'BuscarFactura';
  
            $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action,nofactura:no },
            success: function (response) {
            
              
            if(response != 'error')
            {
               
             //console.log(response);
             var info = JSON.parse(response);
             //console.log(info);
             $('#detalle_factura').html(info.detalle);
  
            }else{
              console.log('no data');
            }
            
          },
            error: function (error) {
          }
       });
  
   }


//validar buscar 
var elem = document.getElementById("txt_nofact");
elem.onkeyup = function(e){
    if(e.keyCode == 13){
       
      Buscar();

    }
}
//fin

// Mostar mensajes en los iconos
function Iconos(){

  $('.ui.icon')
  .popup({
      inline: true
  });

}
//fin
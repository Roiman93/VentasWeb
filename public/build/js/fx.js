const formatterPeso = new Intl.NumberFormat('es-CO', {
       style: 'currency',
       currency: 'COP',
       minimumFractionDigits: 0
     })


     $(document)
    .ready(function() {

      // show dropdown on hover
      $('.main.menu  .ui.dropdown').dropdown({
        on: 'hover'
      });
    })
  ;

  //

  /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
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




function anular_vent(url){

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
      var nofactur =$(this).attr('f');
       var action = 'infoFactura';

        $.ajax({
              url: 'modelo/ajax.php',
              type: 'POST',
              async: true,
              data: { action: action, nofactur: nofactur },
              success: function (response) {
              
                
              if(response != 'error')
              {

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
              

              }else{

                swal({
                  title: "Oops!",
                  text: "Ha ocurrido un error "+" " + response,
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
            error: function (error) {
            }
         });
      

    } else {
      swal("!No se Realizo Ningun Cambio!");
    }
  });
 
 

}


 	// validaciones  para eliminar
   function validarDel(url){

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

        location.href=url;
        

      } else {
        swal("!No se Realizo Ningun Cambio!");
      }
    });


  }
  //fin

   // validacion para editar
   function validarEdit(url){
     
          
    swal({
      title: "¿Realmente deseas editar el Registro?",
      text: "Se cargara la informacion del Registro selecionado...",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {


        location.href=url;
        

      } else {
        swal("!No se realizo ninguna Acción!");
      }
    });
    

  
}




// function validarDel(url){
//         if(confirm("Realmente desea eliminar ?")){
//           location.href=url;
//         }
//       }
//      //fin
    //  // validar el editar
    //    function validarEdit(url){
    //     if(confirm("Realmente desea editar ?")){
    //       location.href=url;
    //     }
    //   }
    //  // fin

     // validar
       function validar(url){
        if(confirm("Desea e el usuario")){
          location.href=url;
        }
      }
     //fin

//menu 
 $(document).ready(function() {
  $(".ui.toggle.button").click(function() {
    $(".mobile.only.grid .ui.vertical.menu").toggle(100);
  });
});
//fin


  //crear clientes ventas
  $('#btn_new_cliente').click(function(e) {
  e.preventDefault();
  var cc = $('#c_cliente').val();
  var nombre1 = $('#nom_cliente').val();
  var nombre2 = $('#nom2_cliente').val();
  var apellido1 = $('#ap_cliente').val();
  var apellido2 = $('#ap2_cliente').val();
  var action = 'addCliente';
                       
  if(($('#c_cliente').val()== '' || $('#nom_cliente').val()== '' || $('#ap_cliente')=='' ||  $('#ap2_cliente').val()== '')){

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

  }else{



      $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, cedula: cc, nombre1: nombre1, nombre2:nombre2, apellido1:apellido1, apellido2:apellido2 },


        success: function (response) {
        // console.log(response);
          if(response==''){

                swal({
                  title: "Guardado",
                  text: "Registro Almacenado Exitosamente!",
                  icon: "success",
                  button: "ok",
                  })

                  .then((willDelete) => {
                  if (willDelete) {

                  //ocultar boton
                  $('#btn_new_cliente').slideUp();
                  // bloque campos
                  $('#idcliente').prop( "disabled", true );
                  $('#nom_cliente').prop( "disabled", true );
                  $('#nom2_cliente').prop( "disabled", true );
                  $('#ap_cliente').prop( "disabled", true );
                  $('#ap2_cliente').prop( "disabled", true );
                  $('#txt_cod_producto').focus();
                

                      
                  } 
                  });

          }else{

            swal({
              title: "Oops!",
              text: "Ha ocurrido un "+" " + response,
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
          error: function (error) {
        }
      });
    }
});
// fin 



// buscar clientes por cedula
function BuscarCliente() {
  // e.preventDefault();

 // var cl = $(this).val();
  var cc = $('#c_cliente').val();
  var action = 'searchCliente';
  $.ajax({
    url: 'modelo/ajax.php',
    type: 'POST',
    async: true,
    data: { action: action, cliente: cc },

    success: function (response) {
     // console.log(response);
       
      if(response == 0){
         

        swal({
          title: "Cedula No Registrada",
          text: "Desea Registrar el Nuevo Cliente",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          
            $('#nom_cliente').prop( "disabled", false );
            $('#nom2_cliente').prop( "disabled", false );
            $('#ap_cliente').prop( "disabled", false );
            $('#ap2_cliente').prop( "disabled", false );
            $('#idcliente').val('');
            $('#nom_cliente').val('');
            $('#nom2_cliente').val('');
            $('#ap_cliente').val('');
            $('#ap2_cliente').val('');
            $('#nom_cliente').focus();

            // MOSTRAR BOTON AGREGAR
            $('#btn_new_cliente').slideDown();
            
          } else {
            // swal("!No se Realizo Ninguna Accion!");
            $('#c_cliente').focus();
          }
        });
      

      }else{
        var data = $.parseJSON(response);
        $('#idcliente').val(data.id_cliente);
        $('#nom_cliente').val(data.nombre_1);
        $('#nom2_cliente').val(data.nombre_2);
        $('#ap_cliente').val(data.apellido_1);
        $('#ap2_cliente').val(data.apellido_2);
        
        //ocultar boton
        $('#btn_new_cliente').slideUp();
        // bloque campos
        $('#idcliente').prop( "disabled", true );
        $('#nom_cliente').prop( "disabled", true );
        $('#nom2_cliente').prop( "disabled", true );
        $('#ap_cliente').prop( "disabled", true );
        $('#ap2_cliente').prop( "disabled", true );
        $('#txt_cod_producto').focus();
        
        
        
      }
    },
      error: function (error) {
    }
  });

}
// fin 

//validar enter
var elem = document.getElementById("c_cliente");
elem.onkeyup = function(e){
    if(e.keyCode == 13){
       
       BuscarCliente();

    }
}

//buscar productos
  $('#txt_cod_producto').keyup(function(e) {
  e.preventDefault();

  var pt = $(this).val();
  var action = 'infoProducto';


 if (pt!='') 
 {
  $.ajax({
    url: 'modelo/ajax.php',
    type: 'POST',
    async: true,
    data: { action: action, producto: pt },
    success: function (response) {
         // console.log(response);
           
          if(response != 'error'){

      
            var info =JSON.parse(response);
            $('#txt_descripcion').html(info.nombre);
            $('#txt_existencia').html(info.stock);
            $('#txt_cant_producto').val('1');            
            $('#txt_precio').html(info.precio_venta);
            $('#txt_precio_total').html(formatterPeso.format(info.precio_venta));
            //$('#txt_precio_total').html(info.precio_venta);
           

                 if ($('#txt_existencia').html()>0) {

                    // activar cantidad
                    $('#txt_cant_producto').removeAttr('disabled');
                    
                    $('#txt_cant_producto').focus();
                    $('#add_product_venta').slideDown();
 
                   }else{

                      // Bloquear cantidad
                      $('#txt_cant_producto').prop( "disabled", true );
                      // ocultar agregar
                      $('#add_product_venta').slideUp();
                      $('#txt_cod_producto').focus();

                   }
           
            
            
          }else{
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant_producto').html('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');
            // Bloquear cantidad
            $('#txt_cant_producto').prop( "disabled", true );
            // ocultar agregar
            $('#add_product_venta').slideUp();
            $('#txt_cod_producto').focus();
           
          }
        },
          error: function (error) {
        }
     });
  }

});
// fin 



// validar cantidad antes de agregar
  $('#txt_cant_producto').keyup(function(e){
  e.preventDefault();

   var precio_total = $(this).val() * $('#txt_precio').html();
   var existencia = parseInt($('#txt_existencia').html());
   var pt = precio_total;
   $('#txt_precio_total').html(formatterPeso.format(pt));
   //$('#txt_precio_total').html(pt);

  // oculta el boton agregar si la cantidad es menor que 1
    if(  ($(this).val() < 1 || isNaN($(this).val())) || ( $(this).val() > existencia) )
    {

      $('#add_product_venta').slideUp();

    }else{
       $('#add_product_venta').slideDown();
    }

  });


//agregar producto al detalle
 $('#add_product_venta').click(function(e){
   e.preventDefault();

   if($('#txt_cant_producto').val() > 0)
    {

      

      var codproducto = $('#txt_cod_producto').val();
      var cantidad = $('#txt_cant_producto').val();
      var id = $('#txt_id').val();
      var action = 'addProductoDetalle';

          $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: { action: action, producto:codproducto, cantidad:cantidad, token:id },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log('agrego los datos')
           var info = JSON.parse(response);
           // console.log(info);
           $('#detalle_venta').html(info.detalle);
           $('#detalle_totales').html(info.totales);

            $('#txt_cod_producto').val('');
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant_producto').html('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');

            // Bloquear cantidad
            $('#txt_cant_producto').prop( "disabled", true );
            
            // ocultar agregar
            $('#add_product_venta').slideUp();

            $('#txt_cod_producto').focus();
            viewProcesar();

          }else{
            console.log('no data');
          }
          viewProcesar();
        },
          error: function (error) {
        }
     });
    
   }

 });
//fin

 // cancelar venta
 $('#btn_anular_venta').click(function(e){
  e.preventDefault();
   
   var rows = $('#detalle_venta tr').length;
   var id = $('#txt_id').val();
   if (rows > 0 )
   { 
    var action ='anularVenta';
    
    $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: {action: action,token:id},
          success: function (response) 
          {
            console.log(response);
            if (response != 'error')
            {
              swal({
                title: "Factura Cancelada",
                text: "Se Borraran la información.",
                icon: "success",
                button: "ok",
                })
    
                .then((willDelete) => {
                if (willDelete) {

                  location.reload();
                  $('#c_cliente').focus();
               
    
                    
                } 
                });
               
            }

          },
          error: function (error){
          }
     });

    

   }

 });
 // fin

 // cancelar cuadre caja
 $('#btn_cancelar').click(function(e){
  e.preventDefault();
   
  
   
    location.reload();
    
    

   

 });
 // fin

 

 // procesar venta 
 $('#btn_facturar_venta').click(function(e){
  e.preventDefault();
   
   var rows = $('#detalle_venta tr').length;
   var id = $('#txt_id').val();
   if (rows > 0 )
   { 
    var action ='procesarVenta';
    var codcliente = $('#idcliente').val();
    var usuario    = $('#txt_usuario').val();
    $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: {action: action,codcliente:codcliente,token:id,usuario:usuario},
          success: function (response) 
          {
            //console.log(response);
             if (response != 'error')
             { 
               
              swal({
                title: "Facturado",
                text: "Factura Guardada con Exito.",
                icon: "success",
                button: "ok",
                })
    
                .then((willDelete) => {
                if (willDelete) {

                  var info = JSON.parse(response);
                  location.reload();
                  generarPDF(info.codcliente,info.nofactura);
                  
  
                } 
                });
              


             }else {

              swal({
                title: "Oops!",
                text: "Ha ocurrido un error "+" " + response,
                icon: "warning",
                button: "ok",
                })
    
                .then((willDelete) => {
                if (willDelete) {
                  
                  console.log('no hay datos');
                    
                } 
                });
              

               
             }

          },
          error: function (error){
          }
     });

    

   }

 });


  // eliminar producto detalle temporal venta
  function del_producto_detalle(correlativo){
   
    var action = 'delProductoDetalle';
    var id_detalle = correlativo;
    var id = $('#txt_id').val();

    $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: {action: action, id_detalle:id_detalle,token:id},
          success: function (response) 
          {
            if (response != 'error')
            {
               //console.log('agrego los datos')
               var info = JSON.parse(response);
               // console.log(info);
               $('#detalle_venta').html(info.detalle);
               $('#detalle_totales').html(info.totales);

                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').html('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                // Bloquear cantidad
                $('#txt_cant_producto').prop( "disabled", true );
                // ocultar agregar
                $('#add_product_venta').slideUp();

            }else{
                  $('#detalle_venta').html('');
                  $('#detalle_totales').html('');
            }
            viewProcesar(); 
          },
          error: function (error){
          }
     });
  }

  // mostar/ ocultar boton procesar
  function viewProcesar(){
      if ($('#detalle_venta tr').length > 0)
      {
        $('#btn_facturar_venta').show();
      }else{
        $('#btn_facturar_venta').hide();
      }
   }

 // mostrar detalle tabla temporal
  function serchForDetalle(id){
  var action = 'serchForDetalle';
  var user = $('#txt_id').val();

    $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: { action: action, user:user },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log('agrego los datos')
           var info = JSON.parse(response);
           // console.log(info);
           $('#detalle_venta').html(info.detalle);
           $('#detalle_totales').html(info.totales);


          }else{
            console.log('no data');
          }
          viewProcesar();
        },
        error: function (error) {
        }
     });
 }

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


//buscar cuadre
$('#btn_buscar_cadre').click(function(e){
   e.preventDefault();

    const formatterPeso = new Intl.NumberFormat('es-CO', {
       style: 'currency',
       currency: 'COP',
       minimumFractionDigits: 0
     })

     // var no =  $('#txt_nofact').val();
      var fecha = $('#start').val();
     
      var action = 'cuadrefecha';

          $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: { action:action, fecha:fecha},
          success: function (response) {
          
            
          if(response != 0)
          {
             
           //console.log(response);


          var data = $.parseJSON(response);
          var tlt = parseInt(data.total);
          // oculta el boton guardar
              if(  (tlt < 1 || isNaN(tlt))  )
              {

                $('#guardar_cuadre').slideUp();

              }else{
                 $('#guardar_cuadre').slideDown();
              } 

          $('#lbl_total').html(formatterPeso.format(data.total));
          $('#tlt').val(data.total);
          

          }else{
            console.log('no data');

           
          }
          
        },
          error: function (error) {
        }
     });

   

 });
//fin

//facturas
function generarPDF(cliente,factura){

  var ancho = 1000;
  var alto = 800;
  // Calculara posicion x,y para centar la ventana
  var x = parseInt((window.screen.width/2) - (ancho/2));
  var y = parseInt((window.screen.height/2) - (alto/2));

  $url= 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
  window.open($url,"factura","left"+x+",top="+y+",height="+alto+",width="+ancho+",scrolbar=si,location=no,resizable=si,menubar=no");

}

// //ver facturas

// $('view_facturas').click(function(e){
// e.preventDefault();
// var codCliente =$(this).attr('cl');
// var noFactura = $(this).attr('fac');
// generarPDF(codCliente,noFactura);


// });

 serchForDetalle();

 



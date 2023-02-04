const formatterPeso = new Intl.NumberFormat('es-CO', {
       style: 'currency',
       currency: 'COP',
       minimumFractionDigits: 0
     })

//menu despliegable
 $(document).ready(function(){
      // show dropdown on hover
      $('.main.menu  .ui.dropdown').dropdown({
        on: 'hover'
      });
    });
//fin    

//menu responsive 
 $(document).ready(function() {
  $(".ui.toggle.button").click(function() {
    $(".mobile.only.grid .ui.vertical.menu").toggle(100);
  });
});
//fin

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
          console.log(response);
           
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



 //agregar producto al detalle MESAS
 $('#add_product_venta').click(function(e){
   e.preventDefault();
    
   if($('#txt_cant_producto').val() > 0 )
    { 

   

      var mesa = $('#txtmesa').val();
      var codproducto = $('#txt_cod_producto').val();
      var cantidad = $('#txt_cant_producto').val();
      var id = $('#txt_id').val();

      var action = 'addProductoMesa';
      

          $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: { action:action, producto:codproducto,mesa:mesa,cantidad:cantidad,token:id },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log(response);
           var info = JSON.parse(response);
           console.log(info);
            $('#detalle_mesas').html(info.detalle);
            $('#detelle_totales_mesa').html(info.totales);
             
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
          
        },
          error: function (error) {
        }
     });

   }

 });
//fin

//buscar por mesas
 $('#txtmesa').keyup(function(e){
   e.preventDefault();

   if($('#txtmesa').val() > 0)
    { 
      var mesa = $('#txtmesa').val();
      var id = $('#txt_id').val();

      var action = 'bucarMesa';
      

          $.ajax({
          url: 'modelo/ajax.php',
          type: 'POST',
          async: true,
          data: { action:action,mesa:mesa,token:id },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log(response);
           var info = JSON.parse(response);
           console.log(info);
            $('#detalle_mesas').html(info.detalle);
            $('#detelle_totales_mesa').html(info.totales);


            // Bloquear cantidad
            $('#txt_cant_producto').prop( "disabled", true );
            
            // ocultar agregar
            $('#add_product_venta').slideUp();

           $('#txt_cod_producto').focus();
             viewProcesar();

          }else{
             $('#detalle_mesas').html('');
               $('#detelle_totales_mesa').html('');
               $('#btn_facturar_venta').hide();
               //$('#txt_cod_producto').focus();

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
                 viewProcesar();

          }
          
        },
          error: function (error) {
        }
     });

   }

 });
//fin









 

// procesar venta 
 $('#btn_facturar_venta').click(function(e){
  e.preventDefault();
   
   var rows = $('#detalle_mesas tr').length;
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
                 // console.log(info);
                  location.reload();
                  $('#c_cliente').focus();
    
                    
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


 // mostar/ ocultar boton procesar
  function viewProcesar(){
    if ($('#detalle_mesas tr').length > 0)
    {
      
      $('#btn_facturar_venta').show();
      
    }else{
      
      $('#btn_facturar_venta').hide();
    }
  }


//////////////////////////////////////////////////INGRESO FACTURAS COMPRA ////////////////////////////////////

// buscar provedor por nit
$('#nit_provedor').keyup(function(e) {
  e.preventDefault();

  var cl = $(this).val();
  var action = 'searchProvedor';
  $.ajax({
    url: 'modelo/ajax.php',
    type: 'POST',
    async: true,
    data: { action: action, provedor: cl },

    success: function (response) {
      console.log(response);
       
      if(response == 0){

        $('#nombre').prop( "disabled", false );
        $('#direccion').prop( "disabled", false );
        $('#telefono').prop( "disabled", false );
        
        $('#nombre').val('');
        $('#direccion').val('');
        $('#telefono').val('');
       
        $('#nit_provedor').focus();

        // MOSTRAR BOTON AGREGAR
        $('#btn_new_cliente').slideDown();

      }else{
        var data = $.parseJSON(response);
          $('#nombre').val(data.nombre);
          $('#direccion').val(data.direccion);
          $('#telefono').val(data.telefono);
          $('#id_provedor').val(data.id_provedor);
          //ocultar boton
          $('#btn_new_provedor').slideUp();
          // bloque campos
          $('#nombre').prop( "disabled", true );
          $('#direccion').prop( "disabled", true );
          $('#telefono').prop( "disabled", true );
          $('#txt_cod').focus();
        
        
        
      }
    },
      error: function (error) {
    }
  });

});
// fin 

//buscar productos para factura compra
  $('#txt_cod').keyup(function(e) {
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
          console.log(response);
           
          if(response != 'error'){

      
       
            var info =JSON.parse(response);
            $('#txt_descripcion').html(info.nombre);
             $('#txt_existencia').html(info.existencia);
            $('#txt_cant').val('1');
            
            $('#txt_precio').html(info.precio_compra);

            
            $('#txt_precio_total').html(formatterPeso.format(info.precio_compra));
            //$('#txt_precio_total').html(info.precio_venta);
           
            // activar cantidad
            $('#txt_cant').removeAttr('disabled');
           
            $('#txt_cant').focus();
            //mostrar agregar
            $('#add_product_venta').slideDown();
          }else{
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant').html('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');
            // Bloquear cantidad
            $('#txt_cant').prop( "disabled", true );
            // ocultar agregar
            $('#add_product_fact').slideUp();
            $('#txt_cod').focus();
           
          }
        },
          error: function (error) {
        }
     });
  }

});
// fin 





//agregar producto al detalle compra faturas
 $('#add_product_fact').click(function(e){
   e.preventDefault();

   if($('#txt_cant').val() > 0 || isNaN($('#txt_cant').val()) )
    { 
      
      var codproducto = $('#txt_cod').val();
      var cantidad = $('#txt_cant').val();
      var id = $('#txt_id').val();

      var action = 'addProductoFact';
      

          $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: { action:action, producto:codproducto,cantidad:cantidad,token:id },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           var info = JSON.parse(response);
           console.log(info);
           $('#detalle_fact').html(info.detalle);
           $('#detalle_tlt_fact').html(info.totales);
           

            $('#txt_cod').val('');
            $('#txt_descripcion').html('-');
            $('#txt_existencia').html('-');
            $('#txt_cant').val('0');
            $('#txt_precio').html('0.00');
            $('#txt_precio_total').html('0.00');
             // Bloquear cantidad
            $('#txt_cant').prop( "disabled", true );
             // ocultar agregar
            $('#add_product_venta').slideUp();
            $('#txt_cod').focus();
             viewProcesarbtm();
          
           
            
            // ocultar agregar
            $('#add_product_venta').slideUp();

            
             viewProcesar();

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
 // eliminar producto detalle facturas compra
  function del_producto_detalle_facturas(correlativo){
   
    var action = 'delDetalle';
    var id_detalle = correlativo;
    var id = $('#txt_id').val();
    

    $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: {action: action, id_detalle:id_detalle,token:id},
          success: function (response) 
          {
            if (response != 'error')
            {
           console.log(response);
           var info = JSON.parse(response);
           console.log(info);
           $('#detalle_fact').html(info.detalle);
           $('#detalle_tlt_fact').html(info.totales);
           
                $('#txt_cod').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                // Bloquear cantidad
                $('#txt_cant').prop( "disabled", true );
                // ocultar agregar
                $('#add_product_venta').slideUp();
                $('#txt_cod').focus();
                viewProcesarbtm();
                

            }else{
              
               $('#detalle_fact').html('');
               $('#detalle_tlt_fact').html('');
               $('#btn_facturar_venta').hide();
               $('#txt_cod').focus();

               $('#txt_cod').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');
                
                // Bloquear cantidad
                $('#txt_cant').prop( "disabled", true );
                // ocultar agregar
                $('#add_product_venta').slideUp();
                
              

                 
            }
            
          },
          error: function (error){
            
          }
     });
  }
  //fin


// validar cantidad antes de agregar compra
  $('#txt_cant').keyup(function(e){
  e.preventDefault();

   var precio_total = $(this).val() * $('#txt_precio').html();
   var existencia = parseInt($('#txt_existencia').html());
   var pt = precio_total;
   $('#txt_precio_total').html(formatterPeso.format(pt));
   //$('#txt_precio_total').html(pt);

  // oculta el boton agregar si la cantidad es menor que 1
    if(  ($('#txt_cant').val() < 1 || isNaN($('#txt_cant').val())) )
    {

      $('#add_product_venta').slideUp();


    }else{
       $('#add_product_venta').slideDown();
    }

  });
//fin


// mostar/ ocultar boton procesar
  function viewProcesarbtm(){
    if ($('#detalle_fact tr').length > 0)
    {
      
      $('#btn_facturar_compra').show();
      
    }else{
      
      $('#btn_facturar_compra').hide();
    }
  }
  //fin

  // procesar compra
 $('#btn_facturar_compra').click(function(e){
  e.preventDefault();
   
   var rows = $('#detalle_fact tr').length;
   var id = $('#txt_id').val();
   if (rows > 0 )
   { 
    var action ='procesarCompra';
    var codprovedor = $('#id_provedor').val();
    var usuario    = $('#txt_usuario').val();
    $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: {action: action,provedor:codprovedor,token:id,usuario:usuario},
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
                  //console.log(info);
 
                  location.reload();
                  $('#nit_provedor').focus();
    
                    
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


 // buscar compra por numero 
 $('#btn_buscar_comp').click(function(e){
   e.preventDefault();

  
      var no = $('#txt_nofact').val();
      var action = 'BuscarCompra';

          $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: { action: action,nofactura:no },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log(response);
           var info = JSON.parse(response);
           console.log(info);
           $('#detalle_compras').html(info.detalle);

          }else{
            $('#detalle_compras').html('');
            //console.log('no data');
          }
          
        },
          error: function (error) {
        }
     });
 });
//fin


// buscar compra por fechas
$('#btn_buscar_compra_fecha').click(function(e){
   e.preventDefault();

    
      var no =  $('#txt_nofact').val();
      var de = $('#fecha_de').val();
      var a = $('#fecha_a').val();
      var action = 'Buscarcompraf';

          $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: { action:action, nofactura:no, fecha_de:de,fecha_a:a },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log(response);
           var info = JSON.parse(response);
           console.log(info);
           $('#detalle_compras').html(info.detalle);

          }else{
            $('#detalle_compras').html('');
            //console.log('no data');
          }
          
        },
          error: function (error) {
        }
     });

   

 });
//fin

//mostrar facturas
 function viwcompras(e){
   e.preventDefault();
       var no = $('#txt_nofact').val();
      var action = 'BuscarFactura';

            var no = $('#txt_nofact').val();
      var action = 'BuscarCompra';

          $.ajax({
          url: 'modelo/ingresofacturas.php',
          type: 'POST',
          async: true,
          data: { action: action,nofactura:no },
          success: function (response) {
          
            
          if(response != 'error')
          {
             
           //console.log(response);
           var info = JSON.parse(response);
           //console.log(info);
           $('#detalle_compras').html(info.detalle);

          }else{
            $('#detalle_compras').html('');
            //console.log('no data');
          }
          
        },
          error: function (error) {
        }
     });

 }


 
//Registro de clientes 
function Guardar() {
    
    var codigo = $('#codigo').val();
    var nombre = $('#nombre').val();
    var tipo = $('#tipo').val();
    var precio_compra = $('#precio_c').val();
    var precio_venta = $('#precio_v').val();
    var action = 'AddProducto';
         
                       
    if(($('#codigo').val()== '' || $('#nombre').val()== '' || $('#tipo')=='' ||  $('#precio_v').val()== '')){
       
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
            data: { action: action, codigo: codigo, nombre: nombre, precio_compra: precio_compra, precio_venta: precio_venta, tipo: tipo },
    
    
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
                      
                          cancelar();    
                      // //ocultar boton
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
  }
  // fin 

  //modificar productos
function Modificar() {
    var id = $('#id_product').val();
    var codigo = $('#codigo').val();
    var nombre = $('#nombre').val();
    var tipo = $('#tipo').val();
    var precio_compra = $('#precio_c').val();
    var precio_venta = $('#precio_v').val();
    var action = 'UpdateProducto';
                         
    if( ($('#codigo').val()== '' || $('#nombre').val()== '' || $('#tipo')=='' ||  $('#precio_v').val()== '') ){
  
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
          data: { action: action, codigo: codigo, nombre: nombre, tipo:tipo, precio_compra:precio_compra, precio_venta:precio_venta, id:id },
  
  
          success: function (response) {
          // console.log(response);
            if(response==''){
  
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
  }
  // fin 

function cancelar(){

    var url='?opcion=productos';
    location.href=url;
}

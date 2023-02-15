

//Registro de Usuario
function Guardar() {
    
    var cc = $('#cedula').val();
    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var correo = $('#correo').val();
    var telefono = $('#telefono').val();
    var id_tipo = $('#id_tipo').val();
    var pass = $('#pass').val();
    var action = 'AddUsuario';
                         
    if( (cc == '' || nombre == '' || apellido =='' ||  correo == ''|| 
        telefono == ''  || id_tipo ==''|| pass =='' ) ){
  
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
          data: { action: action, cedula:cc, nombre:nombre, apellido:apellido,  correo:correo, telefono:telefono, tipo:id_tipo, contraseña:pass },
  
  
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


//Registro de Usuario
function Modificar() {

  var id = $('#id_usuario').val();
  var cc = $('#cedula').val();
  var nombre = $('#nombre').val();
  var apellido = $('#apellido').val();
  var correo = $('#correo').val();
  var telefono = $('#telefono').val();
  var id_tipo = $('#id_tipo').val();
  var pass = $('#pass').val();
  var action = 'UpdateUsuario';
                     
  if( (cc == '' || nombre == '' || apellido =='' ||  correo == ''|| 
      telefono == ''  || id_tipo ==''|| pass =='' ) ){

    swal({
      title: "Oops!",
      text: "Llene todos los Campos Requeridos",
      icon: "warning",
      button: "ok",
      })

      .then((willDelete) => {
      if (willDelete) {
       $('#cedula').focus(); 
          
      } 
      });

  }else{



      $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action,id:id, cedula:cc, nombre:nombre, apellido:apellido,  correo:correo, telefono:telefono, tipo:id_tipo, contraseña:pass },


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

    var url='?opcion=usuarios';
    location.href=url;
    
}
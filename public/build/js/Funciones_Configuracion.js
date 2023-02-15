


// Guardar configuracion
function Guardar(){

    var nit = $('#nit').val();
    var digito = $('#digito').val();
    var nombre = $('#nombre').val();
    var direccion = $('#direccion').val();
    var telefono = $('#telefono').val();
    var email = $('#email').val();
    var iva = $('#iva').val();
    var action = 'AddConfiguracion';

  

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, nit:nit, dg:digito, nombre:nombre, direccion:direccion, email:email, iva:iva, telefono:telefono },


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
                  
                     // cancelar();    
                 
                

                      
                  } 
                  });

          }else{

            swal({
              title: "Oops!",
              text: "Ha ocurrido un error:"+" " + response,
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

// Modificar Configuracion
function Modificar(){

    var id = $('#id').val();
    var nit = $('#nit').val();
    var digito = $('#digito').val();
    var nombre = $('#nombre').val();
    var direccion = $('#direccion').val();
    var telefono = $('#telefono').val();
    var email = $('#email').val();
    var iva = $('#iva').val();
    var action = 'UpdateConfiguracion';

  

    $.ajax({
        url: 'modelo/ajax.php',
        type: 'POST',
        async: true,
        data: { action: action, id:id, nit:nit, dg:digito, nombre:nombre, direccion:direccion, email:email, iva:iva, telefono:telefono },


        success: function (response) {
        // console.log(response);
          if(response==''){

                swal({
                  title: "Guardado",
                  text: "Registro Actualizado Exitosamente!",
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
              text: "Ha ocurrido un error:"+" " + response,
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


// Cancelar
function cancelar(){

    var url='?opcion=vista_config';
    location.href=url;
    
}


function Guardar(){

    var prefijo = $('#prefijo').val();
    var inicio = $('#n_inicio').val();
    var final = $('#n_final').val();
    var nresolucion = $('#resolucion').val();
    var date = $('#fecha').val();
    var tipo = $('#id_tipo').val();
    var action = 'AddResolucion';
                         
    if(($('#prefijo').val()== '' || $('#n_inicio').val()== '' || $('#n_final')=='' ||  $('#resolucion').val()== '')){
  
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
          data: { action: action, prefijo: prefijo, n_inicial: inicio, n_final: final, n_resolucion: nresolucion, fecha:date, tipo:tipo },
  
  
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
                    
                        Cancelar();    
                  
  
                        
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


function Modificar(){

    var id = $('#id').val();
    var prefijo = $('#prefijo').val();
    var inicio = $('#n_inicio').val();
    var final = $('#n_final').val();
    var nresolucion = $('#resolucion').val();
    var date = $('#fecha').val();
    var tipo = $('#id_tipo').val();
    var action = 'UpdateResolucion';
                         
    if(($('#prefijo').val()== '' || $('#n_inicio').val()== '' || $('#n_final')=='' ||  $('#resolucion').val()== '')){
  
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
          data: { action: action,id:id, prefijo: prefijo, n_inicial: inicio, n_final: final, n_resolucion: nresolucion, fecha:date, tipo:tipo },
  
  
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
                    
                        Cancelar();    
                  
  
                        
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


function Cancelar(){

    var url='?opcion=Resolucion';
    location.href=url;
    
  }  
  
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
//fin

  // validaciones  para activar Resolucion
    function ValidarAct(url){

      swal({
        title: "¿Seguro que deseas Activar esta Resolucion?",
        text: "Verifique todo antes de continuar...",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var fac =$(this).attr('fac');
          var action='ActResolucion';

          $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, factura: fac },
    
    
            success: function (response) {
            // console.log(response);
              if(response==''){

    
                    swal({
                      title: "Activado",
                      text: "!Resolucion Activada!",
                      icon: "success",
                      button: "ok",
                      })
    
                      .then((willDelete) => {
                      if (willDelete) {
                      
                          Cancelar();    
                    
    
                          
                      } 
                      });
    
              }else{
    
                swal({
                  title: "Oops!",
                  text: "Ha ocurrido un Eror: "+" " + response,
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


  
        } else {
          swal("!No se Realizo Ningun Cambio!");
        }
      });
  
  
    }
    //fin


     // validaciones  para desactivar Resolucion
     function ValidarDesact(url){

      swal({
        title: "¿Seguro que deseas Desactivar esta Resolucion?",
        text: "Verifique todo antes de continuar...",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var fac =$(this).attr('fac');
          var action='DesactResolucion';

          $.ajax({
            url: 'modelo/ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, factura: fac },
    
    
            success: function (response) {
            // console.log(response);
              if(response==''){

    
                    swal({
                      title: "Desactivada",
                      text: "!Resolucion Desactivada!",
                      icon: "success",
                      button: "ok",
                      })
    
                      .then((willDelete) => {
                      if (willDelete) {
                      
                          Cancelar();    
                    
    
                          
                      } 
                      });
    
              }else{
    
                swal({
                  title: "Oops!",
                  text: "Ha ocurrido un Eror: "+" " + response,
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


  
        } else {
          swal("!No se Realizo Ningun Cambio!");
        }
      });
  
  
    }
    //fin



 // validaciones  para eliminar Resolucion
 function ValidarRemove(url){

          swal({
            title: "¿Seguro que deseas Eliminar esta Resolucion?",
            text: "No podrás deshacer este paso...",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              var fac =$(this).attr('fac');
              var action='RemoveResolucion';
    
              $.ajax({
                url: 'modelo/ajax.php',
                type: 'POST',
                async: true,
                data: { action: action, factura: fac },
        
        
                success: function (response) {
                // console.log(response);
                  if(response==''){
    
        
                        swal({
                          title: "Registro Eliminado",
                          text: "!Exitoso!",
                          icon: "success",
                          button: "ok",
                          })
        
                          .then((willDelete) => {
                          if (willDelete) {
                          
                              Cancelar();    
                        
        
                              
                          } 
                          });
        
                  }else{
        
                    swal({
                      title: "Oops!",
                      text: "Ha ocurrido un Error: "+" " + response,
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
    
    
      
            } else {
              swal("!No se Realizo Ningun Cambio!");
            }
          });
      
      
  }
 //fin
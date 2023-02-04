//buscar cuadre
function BuscarCuadre(){
   
 
     const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
 
      // var no =  $('#txt_nofact').val();
       var id = $('#txt_id').val();
       var fecha = $('#start').val();
      
       var action = 'CuadreFecha';

       if (fecha == ''){

        swal({
          title: "Oops!",
          text: "Selecione una Fecha",
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
           data: { action:action, fecha:fecha, usuario:id},
           success: function (response) {
           
             
           if(response == '')
           {
              
            console.log('no data');
           
           
 
           }else{
             

             var data = $.parseJSON(response);
             // console.log(data);
              var tlt = parseInt(data.total);
              var subtotal = tlt ;
              var iva = 19;
              var tl_sniva;
   
             //  var impuesto 	= round(subtotal * (iva / 100), 2);
             //  var tl_sniva 	= round(subtotal - impuesto,2 );
             //  var total 		= round(tl_sniva + impuesto,2);
   
              // oculta el boton guardar
                  if(  (tlt < 1 || isNaN(tlt))  )
                  {
    
                   $('#btn_Cuadre_Caja').hide();
    
                  }else{
                   $('#btn_Cuadre_Caja').show();
                  } 
    
              $('#lbl_total').html(formatterPeso.format(data.total));
              $('#tlt').val(data.total);
 
            
           }
           
         },
           error: function (error) {
         }
      });
    }
    
 
  }
 //fin

 function Generar_Cuadre(url){

    swal({
      title: "¿Seguro que deseas Generar el Cuadre de caja?",
      text: "no podras generar otro cuadre de caja para este dia",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
  
        
        swal("!Registro Eliminado!", {
          icon: "success",
        });
  
     
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
   
   
  
  }//fin


// cancelar
 function cancelar(){

    var url='?opcion=caja';
    location.href=url;
}
//fin


//validar buscar enter 
var elem = document.getElementById("btn_buscar_cadre");
elem.onkeyup = function(e){
    if(e.keyCode == 13){
       
       BuscarCuadre();

    }
}
//fin

function cuadre(){
  var fecha = $('#start').val();
  var usuario =$('#txt_id').val();

  if ((fecha== '' || usuario=='')){
   alert('fecha y usuario vacios ');
  }else {
    generar_Cuadre_Caja_PDF(fecha,usuario);
  }
}

function generar_Cuadre_Caja_PDF(fecha,usuario){

  var ancho = 1000;
  var alto = 800;
  // Calculara posicion x,y para centar la ventana
  var x = parseInt((window.screen.width/2) - (ancho/2));
  var y = parseInt((window.screen.height/2) - (alto/2));

  $url= 'factura/generaCuadreCaja.php?fecha='+fecha+'&u='+usuario;
  window.open($url,"Cuadre de Caja","left"+x+",top="+y+",height="+alto+",width="+ancho+",scrolbar=si,location=no,resizable=si,menubar=no");

}
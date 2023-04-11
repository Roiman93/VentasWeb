
/**
 * Función que se ejecuta cuando la ventana y sus elementos han cargado.
 * Se encarga de asignar comportamientos y eventos a los elementos del DOM.
*/
window.addEventListener("load", function() {

    var x = window.matchMedia("(max-width: 768px)")
    myFunction(x) // Llamar a la función de escucha en tiempo de ejecución
    x.addListener(myFunction) // Adjunte la función de escucha en los cambios de estado
    $('.ui.button').popup();
    $('.message .close').on('click', function() {$(this).closest('.message').transition('fade');});

});

/**
 * Muestra u oculta el menú lateral al hacer clic en el botón correspondiente.
 *
 * La función utiliza la biblioteca jQuery y la función .sidebar() para mostrar u ocultar el menú lateral.
 * 
 * @return {void}
 */
function hide_o_show() {
    $('.ui.sidebar').sidebar('toggle');

}

/**
 * La función myFunction(x) es utilizada para cambiar la apariencia del menú de navegación
 * en función del tamaño de la pantalla.
 * 
 * @param {Object} x - Un objeto de consulta de medios que se utiliza para verificar
 * si la pantalla es de un tamaño específico o no.
 * 
 * Si la pantalla es más pequeña que 768px, entonces la función oculta el menú de navegación
 * normal y muestra el menú de navegación para dispositivos móviles. Además, también oculta
 * el logotipo en el encabezado.
 * 
 * Si la pantalla es más grande o igual a 768px, entonces la función muestra el menú de navegación
 * normal y oculta el menú de navegación para dispositivos móviles. Además, también muestra
 * el logotipo en el encabezado.
 */
function myFunction(x) {
    if (x.matches) { // Si la consulta de medios coincide
        // document.body.style.backgroundColor = "yellow";
        $('#menu_tablet').hide();
        $('#menu_mobil').show();
        $('#div_h').hide();

    } else {

        $('#menu_tablet').show();
        $('#div_h').show();
        $('#menu_mobil').hide();
        // document.body.style.backgroundColor = "pink";
    }

}

/* validaciones  del lado del cliente */

/**
 * Función que valida un formulario y devuelve true si todos los campos requeridos están completos
 * @param {HTMLFormElement} form - El formulario a validar
 * @returns {boolean} - True si el formulario es válido, false si no lo es
 * @throws {TypeError} - Si el parámetro form no es de tipo HTMLFormElement
 * 
 * Soporte para los siguientes tipos de campo:
 * - text
 * - password
 * - email
 * - number
 * - checkbox
 * - radio
 * - select-one
 * - select-multiple
 *
 * Si un campo tiene el atributo "required" y está vacío, se considera inválido.
 */
function validateForm(idFormulario) {

    // Obtenemos los campos del formulario
    var $campos = $('#' + idFormulario + ' input[type!="hidden"], #' + idFormulario + ' select');
  
    // Eliminamos mensajes y clases de error anteriores
    $('#' + idFormulario + ' .field').removeClass('error');
    $('#' + idFormulario + ' .ui.error.message').remove();
  
    var isValid = true; // Variable para indicar si el formulario es válido o no
  
    // Recorremos los campos y validamos su contenido
    $campos.each(function() {
      var $campo = $(this);
      var nombreCampo = $campo.prev('label').text().replace(':', ''); // Obtenemos el nombre del campo
      var value = $campo.val(); // Obtenemos el valor del campo
  
      switch ($campo.data('type')) {
        case "text":
            case "text":
                const namePattern = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+)*$/;
                if ((!value || !namePattern.test(value)) && ($campo.prop('required') && !$campo.val())) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido y solo se permite texto</div>');
                  isValid = false;
                } else if (!value || !namePattern.test(value)) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se permite texto</div>');
                  isValid = false;
                } else if ($campo.prop('required') && !$campo.val()) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es requerido</div>');
                  isValid = false;
                } else {
                  $campo.closest('.field').removeClass("error");
                }
            break;
              
  
        case "email":
            if ($campo.prop('required') && !$campo.val()) {
                $campo.closest('.field').addClass("error");
                $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
                isValid = false;
              } else {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value || !emailPattern.test(value)) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un correo electrónico válido</div>');
                  isValid = false;
                } else {
                  $campo.closest('.field').removeClass("error");
                }
              }
              
          break;
  
        case "number":
            if ($campo.prop('required') && !$campo.val()) {
                $campo.closest('.field').addClass("error");
                $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
                isValid = false;
              } else {
                const numberPattern = /^\d+$/;
                if (!value || !numberPattern.test(value)) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número válido</div>');
                  isValid = false;
                } else {
                  $campo.closest('.field').removeClass("error");
                }
              }
              
          break;
  
        case "tel":
            if ($campo.prop('required') && !$campo.val()) {
                $campo.closest('.field').addClass("error");
                $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
                isValid = false;
              } else {
                const phonePattern = /^\d{10}$/;
                if (!value || !phonePattern.test(value)) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número de teléfono válido</div>');
                  isValid = false;
                } else {
                  $campo.closest('.field').removeClass("error");
                }
              }
              
          break;

        case "date":
            if ($campo.prop('required') && !$campo.val()) {
                $campo.closest('.field').addClass("error");
                $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
                isValid = false;
              } else {
                const datePattern = /^\d{4}-\d{2}-\d{2}$/;
                if (!value || !datePattern.test(value)) {
                  $campo.closest('.field').addClass("error");
                  $campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese una fecha válida (formato: AAAA-MM-DD)</div>');
                  isValid = false;
                } else {
                  $campo.closest('.field').removeClass("error");
                }
              }
              
          break;

  
      }
    });

    $('.message .close').on('click', function() {
        $(this).closest('.message').transition('fade');
      });
  
    return isValid;
}
    
/**
Valida una tabla en HTML según su ID, verificando que existan filas, que todas las filas tengan la misma cantidad de celdas, y que no haya celdas vacías o sin valor.
@param {string} idTabla - El ID de la tabla a validar.
@returns {boolean} Retorna true si la tabla es válida, o false si no lo es.
*/
function validateTable(idTabla) {
    var tabla = document.getElementById(idTabla);
    if (!tabla) {
      console.error("La tabla con el id " + idTabla + " no existe.");
      return false;
    }
  
    var filas = tabla.rows;
  
    // Verificar que existan filas
    if (filas.length <= 1) {
      console.error("La tabla no tiene filas para validar.");
      return false;
    }
  
    // Verificar que todas las filas tengan la misma cantidad de celdas
    var numCeldas = filas[0].cells.length;
    for (var i = 1; i < filas.length; i++) {
      if (filas[i].cells.length !== numCeldas) {
        console.error("La fila " + (i+1) + " tiene una cantidad de celdas diferente a la primera fila.");
        return false;
      }
    }
  
    // Verificar que no haya celdas vacías o sin valor en las filas
    for (var i = 1; i < filas.length; i++) {
      for (var j = 0; j < numCeldas; j++) {
        var celda = filas[i].cells[j];
        var input = celda.querySelector("input, select, textarea");
        if (input && input.value === "") {
          celda.classList.add("error");
          celda.classList.remove("success");
          console.error("La celda (" + (i+1) + ", " + (j+1) + ") está vacía o no tiene un valor válido.");
          return false;
        } else if (input) {
          celda.classList.add("success");
          celda.classList.remove("error");
        }
      }
    }
  
    return true;
}

/**
Función que valida si el evento del teclado corresponde a una tecla numérica o a la tecla de retroceso.
@param {Event} evt - El evento del teclado.
@return {boolean} - Retorna true si la tecla presionada es numérica o de retroceso, y false en cualquier otro caso.
*/
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

/* 
 * Valida que solo se ingresen letras en un campo de texto.
 * @param {Event} evt - El evento de teclado que se activa cuando se presiona una tecla.
 * @returns {boolean} - Devuelve verdadero si solo se ingresaron letras y falso en caso contrario.
 */
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

/**
 * Función que valida si una cadena de texto está vacía.
 * @param {string} str - Cadena de texto a validar.
 * @returns {boolean} Retorna `true` si la cadena está vacía o es `null` o `undefined`, de lo contrario retorna `false`.
 */
function isEmpty(str) {
    return (!str || 0 === str.length);
}

/**
 * Verifica si una llave específica existe dentro de un objeto.
 * 
 * @param {Object} obj - El objeto en el que se buscará la llave.
 * @param {string} key - La llave que se buscará dentro del objeto.
 * @returns {boolean} - True si la llave existe en el objeto, false si no.
 */
function isKeyExists(obj, key) {
    if (obj[key] == undefined) {
        return false;
    } else {
        return true;
    }
}

/**
 * Limpia, activa o desactiva elementos de una página web según los parámetros especificados en un objeto.
 *
 * @param {Array} elementos - Un arreglo que contiene objetos con la información de los elementos a modificar.
 * @param {string} elementos.id - El id del elemento a modificar.
 * @param {string} [elementos.value] - El valor que se le asignará al elemento.
 * @param {boolean} [elementos.disabled] - Indica si el elemento estará desactivado o no.
 * @param {string} [elementos.action] - La acción que se le aplicará al elemento (por ejemplo, 'click').
 * @param {string} [elementos.visibility] - La visibilidad del elemento (por ejemplo, 'hidden').
 * @param {string} [elementos.tipo] - El tipo de elemento que se está modificando (por ejemplo, 'val' para un input de texto).
 * @param {boolean} [elementos.focus] - Indica si el elemento debe tener el foco o no.
 */
function clearProductInfo(elementos) {
    elementos.forEach(elemento => {
      let el = $("#" + elemento.id);
      if (elemento.tipo === "val") {
        if (elemento.value !== undefined) {
          el.val(elemento.value);
        }
      } else {
        if (elemento.value !== undefined) {
          el.html(elemento.value);
        }
      }
      if (elemento.disabled !== undefined) {
        el.prop("disabled", elemento.disabled);
      }
      if (elemento.action !== undefined) {
        el[elemento.action]();
      }
      if (elemento.visibility !== undefined) {
        el.css("visibility", elemento.visibility);
      }
      if (elemento.focus !== undefined) {
        el.focus();
      }
    });
}

/* generer informes con js */

/**
Abre una nueva ventana con la factura generada en formato PDF.
@param {string} cliente - El nombre del cliente.
@param {string} factura - El número de factura.
@returns {void}
*/
function generarPDF(cliente, factura) {

    var ancho = 1000;
    var alto = 800;
    // Calculara posicion x,y para centar la ventana
    var x = parseInt((window.screen.width / 2) - (ancho / 2));
    var y = parseInt((window.screen.height / 2) - (alto / 2));

    $url = 'factura/generaFactura.php?cl=' + cliente + '&f=' + factura;
    window.open($url, "factura", "left" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + ",scrolbar=si,location=no,resizable=si,menubar=no");

}



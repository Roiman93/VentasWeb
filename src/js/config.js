/**
 * Función que se ejecuta cuando la ventana y sus elementos han cargado.
 * Se encarga de asignar comportamientos y eventos a los elementos del DOM.
 */
window.addEventListener("load", function () {
	var x = window.matchMedia("(max-width: 768px)");
	myFunction(x); // Llamar a la función de escucha en tiempo de ejecución
	x.addListener(myFunction); // Adjunte la función de escucha en los cambios de estado
	// $(".ui.button").popup();
	$(".message .close").on("click", function () {
		$(this).closest(".message").transition("fade");
	});
});

/**
 * Muestra u oculta el menú lateral al hacer clic en el botón correspondiente.
 *
 * La función utiliza la biblioteca jQuery y la función .sidebar() para mostrar u ocultar el menú lateral.
 *
 * @return {void}
 */
function hide_o_show() {
	$(".ui.sidebar").sidebar("toggle");
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
	if (x.matches) {
		// Si la consulta de medios coincide
		// document.body.style.backgroundColor = "yellow";
		$("#menu_tablet").hide();
		$("#menu_mobil").show();
		$("#div_h").hide();
	} else {
		$("#menu_tablet").show();
		$("#div_h").show();
		$("#menu_mobil").hide();
		// document.body.style.backgroundColor = "pink";
	}
}

/* validaciones  del lado del cliente */

/**
 * Función que valida un formulario y devuelve true si todos los campos requeridos están completos
 * @param {HTMLFormElement} form - El formulario a validar
 * @returns {boolean} - True si el formulario es válido, false si no lo es
 * @returns {objet} - devuelve en objeto con los datos del formulario si es true
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
	//var $campos = $("#" + idFormulario + ' input[type!="hidden"], #' + idFormulario + " select");
	//var $campos = $("#" + idFormulario + " input, #" + idFormulario + " select");
	var $campos = $("#" + idFormulario + " input, #" + idFormulario + " select, #" + idFormulario + " textarea");

	// Eliminamos mensajes y clases de error anteriores
	$("#" + idFormulario + " .field").removeClass("error");
	$("#" + idFormulario + " .ui.visible.attached.message").remove();

	var messageShown = false;

	var isValid = true; // Variable para indicar si el formulario es válido o no
	var datos = {};

	// Recorremos los campos y validamos su contenido
	$campos.each(function () {
		// console.log($campo.data("type"));
		var $campo = $(this);
		var nombreCampo = $campo.prev("label").text().replace(":", ""); // Obtenemos el nombre del campo
		var value = $campo.val(); // Obtenemos el valor del campo

		switch ($campo.data("type")) {
			case "text":
				// const namePattern = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+)*$/;
				const namePattern = /^[\p{L}\s]+$/u;
				if ((!value || !namePattern.test(value)) && $campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido y solo se permite texto</div>');
					isValid = false;
				} else if ($campo.prop("required") && (!value || !namePattern.test(value))) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se permite texto</div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
				}
				break;

			case "textarea":
				const paramet = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+(\s[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]+)*$/;
				const textarea = $campo.find("textarea");
				const textValue = $campo.val().trim();
				// console.log(textValue);

				if ((!value || !paramet.test(textValue)) && $campo.prop("required") && !textValue) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido  2y solo se permite texto</div>');
					isValid = false;
				} else if ($campo.prop("required") && (!textValue || !paramet.test(textValue))) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se  2 permite texto</div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.prop("required") && !textValue ? null : textValue;
				}

				break;

			case "address":
				const direccionPattern = /^[a-zA-Z0-9\s.#-]+$/;
				if ((!value || !direccionPattern.test(value)) && $campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after(
						'<div class="ui visible attached message"><i class="close icon"></i><div class="header">El campo es requerido y solo se permiten letras, números y los siguientes caracteres especiales: . #-</div>'
					);
					isValid = false;
				} else if (!value || !direccionPattern.test(value)) {
					$campo.closest(".field").addClass("error");
					$campo.after(
						'<div class="ui visible attached message"><i class="close icon"></i><div class="header">Solo se permiten letras, números y los siguientes caracteres especiales: . #-</div>'
					);
					isValid = false;
				} else if ($campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es requerido</div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.val();
				}
				break;

			case "select":
				if ($campo.prop("required") && !$campo.val() && !$campo.prop("disabled")) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
				}
				break;

			case "checkbox":
				var radios = $("input[type='radio'][name='" + $campo.attr("name") + "']");

				// Verificamos que solo una opción esté seleccionada
				var isChecked = radios.filter(":checked").length === 1;

				if ($campo.prop("required") && !isChecked) {
					$campo.closest(".field").addClass("error");

					if (!messageShown) {
						$campo.last().parent().after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
						messageShown = true;
					}

					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					var selectedOption = radios.filter(":checked").val();
					datos[$campo.attr("name")] = $campo.prop("required") && !selectedOption ? null : selectedOption;
				}
				break;

			case "range":
				// console.log($campo.is(":checked"));
				if ($campo.prop("required") && $campo.val() == 0 && !$campo.prop("disabled")) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio </div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
				}
				break;

			case "radio":
				const $radios = $campo.closest(".field").find('input[type="radio"]');
				if ($campo.prop("required") && !$radios.is(":checked") && !$campo.prop("disabled")) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
					isValid = false;
				} else {
					$campo.closest(".field").removeClass("error");
					datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
				}
				break;

			case "email":
				if ($campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
					isValid = false;
				} else {
					const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
					if (!value || !emailPattern.test(value)) {
						$campo.closest(".field").addClass("error");
						$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un correo electrónico válido</div>');
						isValid = false;
					} else {
						$campo.closest(".field").removeClass("error");
						datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
					}
				}

				break;

			case "number":
				if ($campo.prop("required")) {
					// validar si el campo es requerido
					if (!$campo.val()) {
						// El campo requerido está vacío
						$campo.closest(".field").addClass("error");
						$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
						isValid = false;
					} else {
						// Validar si el valor es un número válido
						const numberPattern = /^\d+$/;
						if (!numberPattern.test(value)) {
							// El valor no es un número válido
							$campo.closest(".field").addClass("error");
							$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número válido</div>');
							isValid = false;
						} else {
							// El valor es un número válido
							$campo.closest(".field").removeClass("error");
							datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
						}
					}
				} else {
					// El campo no es requerido, no se realiza la validación
					$campo.closest(".field").removeClass("error");
				}

				break;

			case "tel":
				if ($campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
					isValid = false;
				} else {
					const phonePattern = /^\d{10}$/;
					if (!value || !phonePattern.test(value)) {
						$campo.closest(".field").addClass("error");
						$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese un número de teléfono válido</div>');
						isValid = false;
					} else {
						$campo.closest(".field").removeClass("error");
						datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
					}
				}

				break;

			case "date":
				if ($campo.prop("required") && !$campo.val()) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
					isValid = false;
				} else {
					const datePattern = /^\d{4}-\d{2}-\d{2}$/;
					if (!value || !datePattern.test(value)) {
						$campo.closest(".field").addClass("error");
						$campo.after(
							'<div class="ui visible attached message"><i class="close icon"></i><div class="header">Por favor ingrese una fecha válida (formato: AAAA-MM-DD)</div>'
						);
						isValid = false;
					} else {
						$campo.closest(".field").removeClass("error");
						datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
					}
				}

				break;

			case "time":
				$hora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test($campo.val());
				if ($campo.prop("required") && !$campo.val() && !$campo.prop("disabled")) {
					$campo.closest(".field").addClass("error");
					$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio </div>');
					isValid = false;
				} else {
					var parsedDate = Date.parse("01/01/1970 " + $campo.val()); // Intentamos parsear la hora
					if (isNaN(parsedDate)) {
						// Si el resultado es NaN, la hora no es válida
						$campo.closest(".field").addClass("error");
						$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">La hora seleccionada no es válida</div>');
						isValid = false;
					} else {
						$campo.closest(".field").removeClass("error");
						datos[$campo.attr("name")] = $campo.prop("required") && !$campo.val() ? null : $campo.val();
					}
				}
				break;
		}
	});

	$(".message .close").on("click", function () {
		$(this).closest(".message").transition("fade");
	});

	/* si el formularo pasa la validacion se envian los datos */
	if (isValid == true) {
		return datos;
	} else {
		return isValid;
	}
}

/**
 * Función captura los datos del formulario  o los pinta
 * @param {HTMLFormElement} form - El formulario a trabajar
 * @returns {objet} - devuelve en objeto con los datos del formulario si no se le envia un objeto
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
function obtain(idFormulario, obj) {
	/*  Obtenemos los campos del formulario */
	/* 	var $campos = $("#" + idFormulario + " input, #" + idFormulario + " select"); */
	var $campos = $("#" + idFormulario + " input, #" + idFormulario + " select, #" + idFormulario + " textarea");

	//console.log($campos);

	if (typeof obj !== "undefined" && obj !== null) {
		/* Recorremos los campos y validamos su contenido */
		$campos.each(function () {
			var $campo = $(this);
			const clave = $campo.attr("name").replace(/\[\]/g, "");
			// console.log($campo.attr("name"));

			if (obj.hasOwnProperty(clave)) {
				const valor = obj[clave];
				/* Resto del código que utiliza la variable valor */
				//console.log("la clave existe y tiene valor " + valor);

				switch ($campo.data("type")) {
					case "radio":
					case "email":
					case "number":
					case "tel":
					case "time":
					case "range":
					case "address":
					case "text":
						$campo.val(valor);

						break;
					case "textarea":
						// $campo.val(valor);
						$campo.val(valor).trim();

						break;

					case "select":
						console.log(valor);
						$campo.find(`option[value="${valor}"]`).prop("selected", true);

						break;

					case "checkbox":
						const $checkboxes = $("input[type='radio'][name='" + $campo.attr("name") + "']");

						/* console.log("nombre del campo: " + clave); */
						if (Array.isArray(obj[clave])) {
							/* Si es un array, recorrer los valores y marcar los checkboxes correspondientes */
							obj[clave].forEach(function (valor) {
								$checkboxes.filter("[value='" + valor + "']").prop("checked", true);
								/* console.log($campo.attr("name") + ": " + valor); */
							});
						} else {
							/* Si no es un array, simplemente marcar el checkbox correspondiente */
							$checkboxes.filter("[value='" + obj[clave] + "']").prop("checked", true);
							/* console.log($campo.attr("name") + ": " + obj[clave]); */
						}

						break;
				}
			} else {
				/* la clave no existe en el objeto */
				console.log(`La clave ${clave} no existe en el objeto`);
			}
		});
	} else {
		/*  console.log("obj no esta definida"); */
		var datos = [];
		/*  Recorremos los campos y validamos su contenido */
		$campos.each(function () {
			var $campo = $(this);
			var value = $campo.val(); // Obtenemos el valor del campo
			const clave = $campo.attr("name").replace(/\[\]/g, "");

			switch ($campo.data("type")) {
				case "text":
				case "address":
				case "range":
				case "radio":
				case "email":
				case "date":
				case "time":
				case "number":
				case "tel":
				case "select":
					datos[clave] = !$campo.val() ? null : $campo.val();
					break;

				case "checkbox":
					var $checkboxes = $("input[type='checkbox'][name='" + $campo.attr("name") + "']");

					// Verificamos que al menos uno esté seleccionado
					var isChecked = $checkboxes.is(":checked");

					if ($campo.prop("required") && !isChecked) {
						$campo.closest(".field").addClass("error");

						if (!messageShown) {
							$campo.after('<div class="ui visible attached message"><i class="close icon"></i><div class="header">Este campo es obligatorio</div>');
							messageShown = true;
						}

						isValid = false;
					} else {
						$campo.closest(".field").removeClass("error");
						var selectedOptions = [];
						$checkboxes.each(function () {
							if (this.checked) {
								selectedOptions.push($(this).val());
							}
						});

						datos[$campo.attr("name")] = selectedOptions;
					}
					break;
			}
		});

		return datos;
	}
}

function cleanForm(idFormulario) {
	var $campos = $("#" + idFormulario + " input, #" + idFormulario + " select");
	var limpiado = false;

	$campos.each(function () {
		var $campo = $(this);

		switch ($campo.data("type")) {
			case "radio":
			case "email":
			case "number":
			case "tel":
			case "time":
			case "range":
			case "address":
			case "text":
			case "select":
				if ($campo.prop("readonly") || $campo.prop("disabled")) {
					break;
				}

				if ($campo.prop("tagName") == "SELECT") {
					var firstOption = $campo.children().first();
					if (firstOption.val() != "") {
						firstOption.prop("selected", true);
						limpiado = true;
					} else {
						$campo.val("");
						limpiado = true;
					}
				} else {
					$campo.val("");
					limpiado = true;
				}
				break;

			case "checkbox":
				if ($campo.prop("checked")) {
					$campo.prop("checked", false);
					limpiado = true;
				}
				break;
		}

		if ($campo.prop("required") && $campo.closest(".field").hasClass("error")) {
			$campo.closest(".field").removeClass("error");
			$campo.siblings(".visible.message").remove();
		}
	});

	if (limpiado) {
		return true;
	}
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
			console.error("La fila " + (i + 1) + " tiene una cantidad de celdas diferente a la primera fila.");
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
				console.error("La celda (" + (i + 1) + ", " + (j + 1) + ") está vacía o no tiene un valor válido.");
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
	var code = evt.which ? evt.which : evt.keyCode;

	if (code == 8) {
		// backspace.
		return true;
	} else if (code >= 48 && code <= 57) {
		// is a number.
		return true;
	} else {
		// other keys.

		return false;
	}
}

/*
 * Valida que solo se ingresen letras en un campo de texto.
 * @param {Event} evt - El evento de teclado que se activa cuando se presiona una tecla.
 * @returns {boolean} - Devuelve verdadero si solo se ingresaron letras y falso en caso contrario.
 */
function lettersOnly(evt) {
	evt = evt ? evt : event;
	var charCode = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : evt.which ? evt.which : 0;
	if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
		//  alert("Enter letters only.");
		return false;
	}
	return true;
}

/*
 * Con este cambio, la función permitirá la entrada de letras y espacios en blanco, pero restringirá cualquier otro
 * carácter que no cumpla con esas condiciones. Si se desea permitir otros caracteres especiales, se pueden agregar sus
 * códigos de caracteres correspondientes a la lista de excepciones en el "if" statement.
 */
function letters_espace_Only(evt) {
	evt = evt ? evt : event;
	var charCode = evt.charCode ? evt.charCode : evt.keyCode ? evt.keyCode : evt.which ? evt.which : 0;
	if (charCode != 32 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
		//  alert("Enter letters and spaces only.");
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
	return !str || 0 === str.length;
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
	elementos.forEach((elemento) => {
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
	var x = parseInt(window.screen.width / 2 - ancho / 2);
	var y = parseInt(window.screen.height / 2 - alto / 2);

	$url = "factura/generaFactura.php?cl=" + cliente + "&f=" + factura;
	window.open($url, "factura", "left" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + ",scrolbar=si,location=no,resizable=si,menubar=no");
}

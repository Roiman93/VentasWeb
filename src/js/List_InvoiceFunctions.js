/**
 * Esta función se encarga de ejecutar ciertas acciones una vez que la página ha cargado completamente.
 */
window.addEventListener("load", function () {
	seach();
});

async function seach() {
	$filter = obtain("filter_billing");

	const datos = new FormData();
	for (let prop in $filter) {
		// console.log(prop + ": " + $filter[prop]);
		datos.append(prop, $filter[prop]);
	}

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/ventas/seach";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayResult(data);
	} catch (error) {}
}

/**
 * Elimina una factura  mediante una petición a la API.
 * @async
 * @param {number} id - El ID del cliente a eliminar.
 * @returns {void}
 */
async function deletebilling(id) {
	/*variabes*/
	const datos = new FormData();
	datos.append("id", id);
	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/ventas/delete";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();
		if (data.rsp !== true) {
			swal("Operacion Realizada", {
				icon: "success",
			});
			displayResult(data);
		} else {
			swal("Error", {
				icon: "warning",
			});
			displayResult(data);
		}
	} catch (error) {}
}

function status(id) {
	console.log(id);
	if (id !== 0) {
		swal({
			title: "¿Seguro que deseas eliminar y desactivar esta Factura?",
			text: "No podrás deshacer este paso...",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				deletebilling(id);
			} else {
				swal("!No se Realizo Ningun Cambio!");
			}
		});
	}
}

/**
 * Muestra los resultados de la búsqueda del producto.
 * Si hay un error en la búsqueda muestra una alerta y bloquea el ingreso de datos.
 * Si encuentra resultados, actualiza los campos correspondientes y desbloquea la entrada de cantidad.
 * Si no encuentra resultados, actualiza los campos a valores predeterminados, bloquea la entrada de cantidad y oculta el botón de agregar producto.
 * @param {Object} data - Objeto con los resultados de la búsqueda del producto.
 * @param {string} data.error - Mensaje de error en caso de que ocurra algún problema en la búsqueda.
 * @param {Object} data.resultado - Objeto con los datos del producto encontrado.
 * @param {string} data.resultado.id_producto - ID del producto encontrado.
 * @param {string} data.resultado.nombre - Nombre del producto encontrado.
 * @param {string} data.resultado.stock - Cantidad en stock del producto encontrado.
 * @param {string} data.resultado.precio_venta - Precio de venta del producto encontrado.
 * @function displayProductResult mostrar_resultado_producto
 * @returns {void}
 */
function displayResult(data) {
	if (data.error) {
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
		}).then(function () {
			$(".ui.button").popup();
		});
	} else {
		if (data.resultado) {
			$("#registros_billing").html(data.resultado);
			$(".ui.button").popup();
		} else {
			console.log("no han resultados");
			$("#txt_descripcion").html("-");
		}
	}
}

/**
* Función que se ejecuta al hacer clic en el botón "Agregar .
@param {object} e - Evento del botón "Agregar".
*/
$("#search").click(function (e) {
	seach();
});

/**
* Función que se ejecuta al hacer clic en el botón "Recargar .
@param {object} e - Evento del botón "Agregar".
*/
$("#recharge").click(function (e) {
	location.reload(true);
});

/**
 * Función: seach
 * Descripción: Función que consulta la API de clientes cuando se presiona la tecla Enter en el
 * campo de entrada de código de producto.
 * @function
 * @param {Object} e - El evento generado al presionar la tecla
 * @returns {void}
 */
var txt_doc = document.getElementById("numero");
txt_doc.onkeyup = function (e) {
	if (e.keyCode == 13) {
		seach();
	}
};

/**
 * Función: seach
 * Descripción: Función que consulta la API de clientes cuando se presiona la tecla Enter en el
 * campo de entrada de código de producto.
 * @function
 * @param {Object} e - El evento generado al presionar la tecla
 * @returns {void}
 */
var txt_name = document.getElementById("cliente");
txt_name.onkeyup = function (e) {
	if (e.keyCode == 13) {
		seach();
	}
};

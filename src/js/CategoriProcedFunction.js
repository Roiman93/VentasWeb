/* inicializamos el calendario cuando termine de cargar todo el html */
/**
 * Esta función se encarga de ejecutar ciertas acciones una vez que la página ha cargado completamente.
 */
window.addEventListener("load", function () {
	seach();
});

async function seach() {
	$filter = obtain("filter_cat_proced");

	const datos = new FormData();
	for (let prop in $filter) {
		// console.log(prop + ": " + $filter[prop]);
		datos.append(prop, $filter[prop]);
	}

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/sh_cat_proced";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayResult(data);
	} catch (error) {}
}

async function updateRecord(id) {
	const datos = new FormData();
	datos.append("id", id);
	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/get_cat_proced";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		$("#modal_edit").modal("show");
		// console.log(data.resultado);
		obtain("modal_edit", data.resultado);
	} catch (error) {}
}

async function update() {
	result = validateForm("modal_edit");

	if (result != false) {
		const datos = new FormData();
		for (let prop in result) {
			// console.log(prop + ": " + result[prop]);
			datos.append(prop, result[prop]);
		}

		try {
			/* Petición hacia la api */
			const url = "http://ventasweb.local/api/cat_proced_up";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			data = await respuesta.json();

			if (datos.rsp !== true) {
				swal("Registro Actualizado", {
					icon: "success",
				});
				cleanForm("modal_edit");
				$("#modal_edit").modal("hide");
				displayResult(data);
			} else {
				swal("Error", {
					icon: "warning",
				});
				displayResult(data);
			}
		} catch (error) {}
	}
}

/* se almacena el registro en la bd */
async function add() {
	result = validateForm("modal_add");

	if (result != false) {
		const datos = new FormData();
		for (let prop in result) {
			//console.log(prop + ": " + result[prop]);
			datos.append(prop, result[prop]);
		}

		try {
			/* Petición hacia la api */
			const url = "http://ventasweb.local/api/cat_proced_ad";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			data = await respuesta.json();

			if (datos.rsp !== true) {
				swal("Registro Almacenado", {
					icon: "success",
				});
				cleanForm("modal_add");
				$("#modal_add").modal("hide");
				displayResult(data);
			} else {
				swal("Error", {
					icon: "warning",
				});
				displayResult(data);
			}
		} catch (error) {}
	}
}

/**
 * Elimina un cliente  mediante una petición a la API.
 * @async
 * @param {number} id - El ID del cliente a eliminar.
 * @returns {void}
 */
async function deleteCustomer(id) {
	/*variabes*/
	const datos = new FormData();
	datos.append("id", id);
	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/cat_proced_dl";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();
		displayResult(data);
	} catch (error) {}
}

async function deleteRecord(id) {
	swal({
		title: "¿Seguro que deseas eliminar el Registro?",
		text: "No podrás deshacer este paso...",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			deleteCustomer(id);
		} else {
			swal("!No se Realizo Ningun Cambio!");
		}
	});
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
			text: data.error + "",
			icon: "warning",
		}).then(function () {});
	} else {
		if (data.resultado) {
			$("#registros").html(data.resultado);
		} else {
			console.log("no han resultados");
			$("#registros").html("-");
		}
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
function displayResultfind(data) {
	if (data.error) {
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
		}).then(function () {});
	} else {
		if (data.resultado) {
			$("#modal_edit").modal("show");
			$("#registros").html(data.resultado);
		} else {
			console.log("no han resultados");
			$("#registros").html("-");
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
* Función que se ejecuta al hacer clic en el botón "Buscar .
@param {object} e - Evento del botón "Agregar".
*/
$("#add").click(function (e) {
	$("#modal_add").modal("show");
});
/**
* Función que se ejecuta al hacer clic en el botón "Buscar .
@param {object} e - Evento del botón "Agregar".
*/
$("#add_record").click(function (e) {
	add();
});
/**
* Función que se ejecuta al hacer clic en el botón "Buscar .
@param {object} e - Evento del botón "Agregar".
*/
$("#update").click(function (e) {
	update();
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
var txt_name = document.getElementById("nombre");
txt_name.onkeyup = function (e) {
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
var txt_last_name = document.getElementById("descripcion");
txt_last_name.onkeyup = function (e) {
	if (e.keyCode == 13) {
		seach();
	}
};

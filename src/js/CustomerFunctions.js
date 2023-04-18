/**
 * Esta función se encarga de ejecutar ciertas acciones una vez que la página ha cargado completamente.
 */
window.addEventListener("load", function () {
	seach();
});

async function seach() {
	$filter = obtain("filter_customer");

	const datos = new FormData();
	for (let prop in $filter) {
		// console.log(prop + ": " + $filter[prop]);
		datos.append(prop, $filter[prop]);
	}

	try {
		/* Petición hacia la api */
		const url = "http://localhost:8888/cliente/seach";
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
		const url = "http://localhost:8888/get_cliente";
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
			console.log(prop + ": " + result[prop]);
			datos.append(prop, result[prop]);
		}

		try {
			/* Petición hacia la api */
			const url = "http://localhost:8888/upd_cliente";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			data = await respuesta.json();
			$("#modal_edit").modal("hide");
			displayResult(data);
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
		const url = "http://localhost:8888/api/cliente_delete";
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
			text: data.error,
			icon: "warning",
		}).then(function () {});
	} else {
		if (data.resultado) {
			$("#registros_customer").html(data.resultado);
		} else {
			console.log("no han resultados");
			$("#txt_descripcion").html("-");
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
	console.log(data);
	if (data.error) {
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
		}).then(function () {});
	} else {
		if (data.resultado) {
			$("#modal_edit").modal("show");
			$("#registros_customer").html(data.resultado);
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

// if (validateForm("modal_add")) {
// }

/* llamamos al modal edit */
// $("#modal_edit").modal("show");
// $("#modal_add").modal("show");

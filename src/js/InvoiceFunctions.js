/**
 * Esta función se encarga de ejecutar ciertas acciones una vez que la página ha cargado completamente.
 */
window.addEventListener("load", function () {
	$("#c_cliente").focus();
	invoiceDetails();
});

/*  validaciones boton enter */

/**
 * Descripción: Función que escucha el evento keyup del elemento con id "c_cliente" para realizar
 * la consulta de clientes a la API cuando se presiona la tecla Enter.
 * @function
 * @param {Object} e - El evento generado al presionar la tecla
 * @returns {void}
 */
var elem = document.getElementById("c_cliente");
elem.onkeyup = function (e) {
	if (e.keyCode == 13) {
		consultApiClients();
	}
};

/**
 * Función: consultApiProducts
 * Descripción: Función que consulta la API de productos cuando se presiona la tecla Enter en el
 * campo de entrada de código de producto.
 * @function
 * @param {Object} e - El evento generado al presionar la tecla
 * @returns {void}
 */
var txt_cod = document.getElementById("txt_cod_producto");
txt_cod.onkeyup = function (e) {
	if (e.keyCode == 13) {
		consultApiProducts();
	}
};

/**
 * Función que se ejecuta cuando se presiona la tecla Enter en el elemento con el ID "txt_cant_producto"
 * @function
 * @param {Object} e - El evento generado al presionar la tecla
 * @returns {void}
 */
var txt_cod = document.getElementById("txt_cant_producto");
txt_cod.onkeyup = function (e) {
	if (e.keyCode == 13) {
		validarCant();
	}
};

/* crear clientes ventas */
$("#btn_new_cliente").click(function (e) {
	e.preventDefault();
	var cc = $("#c_cliente").val();
	var nombre1 = $("#nom_cliente").val();
	var nombre2 = $("#nom2_cliente").val();
	var apellido1 = $("#ap_cliente").val();
	var apellido2 = $("#ap2_cliente").val();
	var action = "addCliente";

	if (
		$("#c_cliente").val() == "" ||
		$("#nom_cliente").val() == "" ||
		$("#ap_cliente") == "" ||
		$("#ap2_cliente").val() == ""
	) {
		swal({
			title: "Oops!",
			text: "Llene todos los Campos Requeridos",
			icon: "warning",
			button: "ok",
		}).then((willDelete) => {
			if (willDelete) {
			}
		});
	} else {
		$.ajax({
			url: "modelo/ajax.php",
			type: "POST",
			async: true,
			data: {
				action: action,
				cedula: cc,
				nombre1: nombre1,
				nombre2: nombre2,
				apellido1: apellido1,
				apellido2: apellido2,
			},

			success: function (response) {
				// console.log(response);
				if (response == "") {
					swal({
						title: "Guardado",
						text: "Registro Almacenado Exitosamente!",
						icon: "success",
						button: "ok",
					}).then((willDelete) => {
						if (willDelete) {
							//ocultar boton
							$("#btn_new_cliente").slideUp();
							// bloque campos
							$("#idcliente").prop("disabled", true);
							$("#nom_cliente").prop("disabled", true);
							$("#nom2_cliente").prop("disabled", true);
							$("#ap_cliente").prop("disabled", true);
							$("#ap2_cliente").prop("disabled", true);
							$("#txt_cod_producto").focus();
						}
					});
				} else {
					swal({
						title: "Oops!",
						text: "Ha ocurrido un " + " " + response,
						icon: "warning",
						button: "ok",
					}).then((willDelete) => {
						if (willDelete) {
							// $('#fecha_de').focus();
						}
					});
				}
			},
			error: function (error) {},
		});
	}
});
// fin

/**
* Función que se ejecuta al hacer clic en el botón "Agregar producto.
* Valida la cantidad de productos y verifica si hay suficiente stock.
* Si la cantidad es válida, llama a la función "agregar_producto() para agregar el producto a la factura.
@param {object} e - Evento del botón "Agregar producto".
*/
$("#add_product").click(function (e) {
	var cantidad = $("#txt_cant_producto").val();
	if (validateStock(cantidad)) {
		addProductToListDetails();
	}
});

/**
 * Función que se activa al hacer clic en el botón de "Cancelar factura"
 * Se muestra un cuadro de diálogo con un mensaje de advertencia para confirmar la acción
 * Si el usuario confirma, se llama a la función "Cancel_billing()" para borrar toda la información de la factura
 * Si el usuario cancela, se muestra un mensaje informando que no se realizó ninguna acción
 * @param e evento de clic
 * @return void
 */
$("#btn_cancel").click(function (e) {
	swal({
		title: "¿Realmente deseas cancelar la Factura?",
		text: "Se Borrara toda la informacion...",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			cancelInvoice();
		} else {
			swal("!No se realizo ninguna Acción!");
		}
	});
});

/**
 * Función que se activa al hacer clic en el botón de "Guardar factura"
 * @param e evento de clic
 * @return void
 */
$("#btn_save").click(function (e) {
	saveInvoice();
});

/* validamos que la cantidad no supere la existencia */
/**
 * Función que valida si la cantidad ingresada de un producto no supera el stock disponible
 * @function validateStock validar stock
 * @returns {boolean} Retorna verdadero si la cantidad ingresada es menor o igual al stock disponible, de lo contrario retorna falso
 */
function validateStock(date) {
	let existencia = parseInt($("#txt_existencia").html());
	let cantidad = parseInt(date);

	if (isNaN(cantidad) || cantidad <= 0 || cantidad > existencia) {
		// Desactivar botón agregar
		clearProductInfo([{ id: "add_producto", visibility: "hidden", tipo: "val" }]);
		$("#txt_cant_producto").addClass("is-invalid");
		$("#txt_cant_producto").removeClass("is-valid");
		$("#txt_cant_producto").parent().addClass("error");
		$("#txt_cant_producto").parent().removeClass("success");

		swal({
			title: "Error",
			text: "La cantidad ingresada supera el stock disponible",
			icon: "warning",
		});

		return false;
	} else {
		// Activar botón agregar
		let elemnt_sub = [{ id: "add_producto", value: "", visibility: "visible", tipo: "val" }];

		clearProductInfo(elemnt_sub, "val");
		$("#add_producto").show();
		$("#txt_cant_producto").removeClass("is-invalid");
		$("#txt_cant_producto").addClass("is-valid");
		$("#txt_cant_producto").parent().removeClass("error");
		$("#txt_cant_producto").parent().addClass("success");

		return true;
	}
}

/**
 * Función que valida la cantidad ingresada del producto y calcula el precio total.
 * @function validarCant validar cantidad
 * @returns {void} Esta función no retorna ningún valor.
 */
function validarCant() {
	var cantidad = $("#txt_cant_producto").val();
	var precio = $("#txt_precio").html();
	var p_total = "";

	if (validateStock(cantidad)) {
		p_total = cantidad * precio;
		$("#txt_precio_total").html(p_total);
		$("#add_producto").focus();
	}
}

/**
 * Realiza una petición asíncrona a una API para consultar la información de un cliente
 * @async
 * @function consultApiClients consultarAPI_Clientes
 * @returns {Promise} - Promesa que devuelve un objeto con la información del cliente
 */
async function consultApiClients() {
	/*variabes*/
	var doc_client = $("#c_cliente").val();

	const datos = new FormData();
	datos.append("date", doc_client);

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/cliente";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayClientResult(data);
	} catch (error) {}
}

/**
 *  Función que muestra los resultados de la consulta a una API de productos.
 * Si la respuesta es undefined, muestra un mensaje de error.
 * Si la respuesta contiene un error, muestra un mensaje con el error.
 * Si la respuesta contiene un resultado nulo, muestra un mensaje preguntando si se desea registrar un nuevo cliente.
 * Si la respuesta contiene un resultado válido, llena los campos correspondientes con la información del cliente.
 * @param {Object} data - Objeto que contiene la respuesta de la consulta a la API de productos.
 * @function displayClientResult tmostrar reslutados cliente
 * @returns {void}
 */
function displayClientResult(data) {
	if (typeof data === "undefined") {
		// Data es undefined, no se recibió respuesta del servidor
		swal({
			title: "Error",
			text: "No se recibió respuesta del servidor",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$("#c_cliente").focus();
			}
		});
	} else if (data.error) {
		// Data contiene un error
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$("#c_cliente").focus();
			}
		});
	} else if (data.resultado === null) {
		// Data contiene un resultado nulo, no existe el registro
		swal({
			title: "Cedula No Registrada",
			text: "Desea Registrar el Nuevo Cliente",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((willDelete) => {
			if (willDelete) {
				$("#nom_cliente, #nom2_cliente, #ap_cliente, #ap2_cliente").prop("disabled", false);
				$("#txt_cod_producto").prop("disabled", true);
				$("#id_cliente, #nom_cliente, #nom2_cliente, #ap_cliente, #ap2_cliente").val("");
				$("#nom_cliente").focus();

				// MOSTRAR BOTON AGREGAR
				$("#btn_new_cliente, #btn_cancel_cliente").slideDown();
			} else {
				$("#c_cliente").focus();
			}
		});
	} else {
		// Data contiene un resultado válido, se encontró el registro
		$("#id_cliente").val(data.resultado.id);
		$("#nom_cliente").val(data.resultado.nombre);
		$("#nom2_cliente").val(data.resultado.s_nombre);
		$("#ap_cliente").val(data.resultado.apellido);
		$("#ap2_cliente").val(data.resultado.s_apellido);

		// OCULTAR BOTON
		$("#btn_new_cliente, #btn_cancel_cliente").slideUp();

		// HABILITAR BOTON CODIGO PRODUCTOS
		$("#txt_cod_producto").prop("disabled", false);

		// BLOQUE CAMPOS
		$("#c_cliente, #idcliente, #nom_cliente, #nom2_cliente, #ap_cliente, #ap2_cliente").prop("disabled", true);
		$("#txt_cod_producto").focus();
	}
}

/**
 * Realiza una consulta a una API para obtener información de un producto por su código.
 * Luego, muestra la información obtenida en la pantalla.
 *
 * @async
 * @function consultarAPi_productos consultar APi productos
 * @returns {void}
 */
async function consultApiProducts() {
	/*variabes*/
	var codigo = $("#txt_cod_producto").val();

	const datos = new FormData();
	datos.append("data", codigo);

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/get_stock_producto";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayProductResult(data);
	} catch (error) {}
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
function displayProductResult(data) {
	if (data.error) {
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
		}).then(function () {
			// Bloquear cantidad
			$("#txt_cant_producto").prop("disabled", true);

			// ocultar agregar
			$("#add_producto").slideUp();
			$("#txt_cod_producto").focus();
		});
	} else {
		if (data.resultado) {
			$("#id").html(data.resultado.id_producto);
			$("#txt_descripcion").html(data.resultado.nombre);
			$("#txt_existencia").html(data.resultado.stock);
			$("#txt_cant_producto").val("1");
			$("#txt_precio").html(data.resultado.precio_venta);
			$("#txt_precio_total").html(data.resultado.precio_venta);

			// desbloquear cantidad
			$("#txt_cant_producto").prop("disabled", false);
			$("#txt_cant_producto").focus();
		} else {
			console.log("mostrando resultados de los productos");

			$("#id_producto").html("");
			$("#txt_descripcion").html("-");
			$("#txt_existencia").html("-");
			$("#txt_cant_producto").html("0");
			$("#txt_precio").html("0.00");
			$("#txt_precio_total").html("0.00");

			// Bloquear cantidad
			$("#txt_cant_producto").prop("disabled", true);

			// ocultar agregar
			$("#add_producto").slideUp();
			$("#txt_cod_producto").focus();
		}
	}
}

/* agregar producto al detalle de la factura  */
/**
 * Agrega un producto a la lista de detalles de venta.
 * Captura los datos de cantidad, precio de venta, id del producto y el token de usuario.
 * Verifica si la cantidad es un valor numérico aceptado antes de realizar la petición a la API para agregar el detalle de venta.
 * Si la cantidad no es aceptada, se muestra una alerta de error.
 * @async
 * @function addProductToListDetails  agregar_producto
 * @throws {Error} si ocurre algún error durante la petición hacia la API.
 * @returns {void}
 */
async function addProductToListDetails() {
	/* captura de datos */
	var id_p = $("#id").html();
	var cantidad = $("#txt_cant_producto").val();
	var pventa = $("#txt_precio").html();
	var token = $("#txt_token").val();

	var valoresAceptados = /^[0-9]+$/;

	if (cantidad.match(valoresAceptados) && cantidad !== "") {
		// alert("Es numérico");

		const datos = new FormData();
		/* datos.append("id", null); */
		datos.append("id_producto", id_p);
		datos.append("cantidad", cantidad);
		datos.append("precio_venta", pventa);
		datos.append("mesa", null);
		datos.append("token_user", token);

		try {
			/* Petición hacia la api */
			const url = "http://ventasweb.local/api/get_add_detalle_producto";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			var data = await respuesta.json();
			displayProductDetails(data);
		} catch (error) {}
	} else {
		alert("No es numérico");
	}
}

/**
 * Elimina un producto mediante una petición a la API.
 * @async
 * @param {number} id - El ID del producto a eliminar.
 * @returns {void}
 */
async function deleteProductAPI(id) {
	/*variabes*/
	var token = $("#txt_token").val();
	const datos = new FormData();
	datos.append("id", id);
	datos.append("token_user", token);

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/delete_detalle_producto";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayProductDetails(data);
	} catch (error) {}
}

/**
 * Función asincrónica para obtener el detalle de una factura.
 * Utiliza FormData para enviar el token de usuario a la API a través del método POST.
 * Muestra el detalle del producto correspondiente a la factura recibida como respuesta.
 * @async
 * @function detalle_factura invoiceDetails
 * @returns {Promise} Una promesa que se resuelve cuando la función ha terminado de ejecutarse.
 */
async function invoiceDetails() {
	/*variabes*/
	var token = $("#txt_token").val();

	const datos = new FormData();
	datos.append("token_user", token);

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/detalle";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		data = await respuesta.json();

		displayProductDetails(data);
	} catch (error) {}
}

/**
 * Nombre de la función en inglés: displayProductDetails(data)
 * Descripción: Esta función muestra los detalles de un producto en la página web.
 * Parámetros: - data: objeto con la información del producto, que incluye un atributo "error" y un atributo "resultado".
 * @function displayProductDetails mostrar detalle productos
 * @Returns Esta función no tiene retorno.
 * Comentarios: Esta función utiliza la librería SweetAlert para mostrar mensajes de error o alerta.
 */
function displayProductDetails(data) {
	if (data.error) {
		swal({
			title: "Error",
			text: data.error,
			icon: "warning",
		}).then(function () {});
	} else {
		if (data.resultado) {
			/* mostramos los resultados */
			$("#detalle_venta").html(data.resultado);
			$("#txt_iva").html(data.resumen.iva);
			$("#txt_subtotal").html(data.resumen.sub_total);
			$("#txt_total").html(data.resumen.total);

			let elementos = [
				{ id: "add_producto", visibility: "hidden", tipo: "val" },
				{ id: "txt_cod_producto", value: "", focus: true, tipo: "val" },
				{ id: "txt_descripcion", value: "-", tipo: "html" },
				{ id: "txt_existencia", value: "-", tipo: "html" },
				{ id: "txt_cant_producto", value: "0", disabled: true, tipo: "html" },
				{ id: "txt_precio", value: "0.00", tipo: "html" },
				{ id: "txt_precio_total", value: "0.00", tipo: "html" },
			];

			// Limpiar valores usando val()
			clearProductInfo(elementos);
		} else {
			let elementos = [
				{ id: "detalle_venta", value: "", tipo: "html" },
				{ id: "txt_iva", value: "", tipo: "html" },
				{ id: "txt_subtotal", value: "-", tipo: "html" },
				{ id: "txt_total", value: "-", tipo: "html" },
			];

			let elemnt_sub = [
				{ id: "add_producto", visibility: "hidden", tipo: "val" },
				{ id: "txt_cod_producto", value: "", focus: true, tipo: "val" },
				{ id: "txt_descripcion", value: "-", tipo: "html" },
				{ id: "txt_existencia", value: "-", tipo: "html" },
				{ id: "txt_cant_producto", value: "0", disabled: true, tipo: "html" },
				{ id: "txt_precio", value: "0.00", tipo: "html" },
				{ id: "txt_precio_total", value: "0.00", tipo: "html" },
			];

			clearProductInfo(elemnt_sub);
			clearProductInfo(elementos);
		}
	}
}

/**
 * Función asincrónica para guardar un nuevo registro de factura.
 * Valida tanto el formulario de cliente como la tabla de clase estándar antes de continuar.
 * Utiliza FormData para enviar datos a la API a través del método POST.
 * Muestra un mensaje de éxito o error según la respuesta de la API.
 * @async
 * @function saveInvoice guardar factura
 * @returns {Promise} Una promesa que se resuelve cuando la función ha terminado de ejecutarse.
 */
async function saveInvoice() {
	if (validateForm("cliente_frm") && validateTable("stdclass-table")) {
		// hacer algo si ambas validaciones son verdaderas

		/*variabes*/
		var token = $("#txt_token").val();
		var pref = $("#txt_prej").val();
		var pref_num = $("#txt_prej_num").val();
		var id_client = $("#id_cliente").val();
		var user = $("#txt_id").val();
		var total = $("#txt_total").html();

		const datos = new FormData();
		datos.append("token_user", token);
		datos.append("prefijo", pref);
		datos.append("numero", pref_num);
		datos.append("id_cliente", id_client);
		datos.append("usuario", user);
		datos.append("total", total);

		try {
			/* Petición hacia la api */
			const url = "http://ventasweb.local/api/process";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			data = await respuesta.json();
			console.log(data);

			/*  validamos la respueta del servidor */
			if (data.error) {
				swal({
					title: "Error al crear factur",
					text: data.error,
					icon: "warning",
				}).then(function () {});
			} else {
				if (data.resultado) {
					/* mostramos los resultados */

					swal({
						title: "Factura generada",
						text: data.resultado,
						icon: "success",
						type: "success",
						confirmButtonText: "Aceptar",
						allowOutsideClick: true,
					}).then(function () {
						location.reload();
					});
				}
			}
		} catch (error) {}
	} else {
		// hacer algo si al menos una validación es falsa

		swal({
			title: "Error al crear factura",
			text: "Por favor, revise que los campos de la factura estén diligenciados correctamente. Asegúrese de completar todos los campos obligatorios y verificar que los datos ingresados sean correctos. Si necesita ayuda, consulte nuestra documentación en línea.",
			icon: "warning",
			buttons: {
				cancel: "Cerrar",
				help: {
					text: "Ayuda",
					value: "help",
				},
			},
		}).then(function (value) {
			if (value === "help") {
				window.open("https://ejemplo.com/ayuda", "_blank");
			}
		});
	}
}

/**
 * Función asincrónica que cancela una factura en el sistema.
 * @async
 * @function cancelInvoice cancelar factura
 * @returns {void}
 * @description
 * Esta función se encarga de cancelar una factura en el sistema, haciendo una petición a la API a través de un método POST. Para ello,
 * valida la tabla de la factura y recoge el token del usuario desde el campo "txt_token". Luego, crea un objeto FormData que incluye el
 * token del usuario y lo envía al servidor a través de la URL "http://ventasweb.local/api/cancel_process".
 * Si la petición al servidor es exitosa, la función muestra una ventana modal de éxito con un mensaje de "Factura cancelada". Si la petición
 * al servidor falla, la función muestra una ventana modal de error con el mensaje de error recibido desde el servidor.
 * Si la validación de la tabla falla, se limpian los campos de cliente, producto y resumen de factura.
 * @example
 * Cancel_billing();
 * @alias Cancelar_factura
 */
async function cancelInvoice() {
	if (validateTable("stdclass-table")) {
		/*variabes*/
		var token = $("#txt_token").val();

		const datos = new FormData();
		datos.append("token_user", token);

		try {
			/* Petición hacia la api */
			const url = "http://ventasweb.local/api/cancel_process";
			const respuesta = await fetch(url, {
				method: "POST",
				body: datos,
			});
			data = await respuesta.json();
			console.log(data);

			/*  validamos la respueta del servidor */
			if (data.error) {
				swal({
					title: "Error al cancelar la factura",
					text: data.error,
					icon: "warning",
				}).then(function () {});
			} else {
				if (data.resultado) {
					/* mostramos los resultados */

					swal({
						title: "Factura cancelada",
						text: data.resultado,
						icon: "success",
						type: "success",
						confirmButtonText: "Aceptar",
						allowOutsideClick: true,
					}).then(function () {
						let client = [
							{ id: "id_cliente", value: "", disabled: false, tipo: "val" },
							{ id: "c_cliente", value: "", disabled: false, focus: false, tipo: "val" },
							{ id: "nom_cliente", value: "", disabled: false, tipo: "val" },
							{ id: "nom2_cliente", value: "", disabled: false, tipo: "val" },
							{ id: "ap_cliente", value: "", disabled: false, tipo: "val" },
							{ id: "ap2_cliente", value: "", disabled: false, tipo: "val" },
						];

						let resumen_fact = [
							{ id: "detalle_venta", value: "", tipo: "html" },
							{ id: "txt_iva", value: "", tipo: "html" },
							{ id: "txt_subtotal", value: "", tipo: "html" },
							{ id: "txt_total", value: "", tipo: "html" },
						];

						let elemnt_product = [
							{ id: "add_producto", visibility: "hidden", tipo: "val" },
							{ id: "txt_cod_producto", value: "", disabled: true, tipo: "val" },
							{ id: "txt_descripcion", value: "-", tipo: "html" },
							{ id: "txt_existencia", value: "-", tipo: "html" },
							{ id: "txt_cant_producto", value: "", disabled: true, tipo: "html" },
							{ id: "txt_precio", value: "0.00", tipo: "html" },
							{ id: "txt_precio_total", value: "0.00", tipo: "html" },
						];

						clearProductInfo(client);
						clearProductInfo(elemnt_product);
						clearProductInfo(resumen_fact);
					});
				}
			}
		} catch (error) {}
	} else {
		/* solo se limpian los datos */
		let client = [
			{ id: "id_cliente", value: "", disabled: false, tipo: "val" },
			{ id: "c_cliente", value: "", disabled: false, focus: false, tipo: "val" },
			{ id: "nom_cliente", value: "", disabled: false, tipo: "val" },
			{ id: "nom2_cliente", value: "", disabled: false, tipo: "val" },
			{ id: "ap_cliente", value: "", disabled: false, tipo: "val" },
			{ id: "ap2_cliente", value: "", disabled: false, tipo: "val" },
		];

		let resumen_fact = [
			{ id: "detalle_venta", value: "", tipo: "html" },
			{ id: "txt_iva", value: "", tipo: "html" },
			{ id: "txt_subtotal", value: "", tipo: "html" },
			{ id: "txt_total", value: "", tipo: "html" },
		];

		let elemnt_product = [
			{ id: "add_producto", visibility: "hidden", tipo: "val" },
			{ id: "txt_cod_producto", value: "", disabled: true, tipo: "val" },
			{ id: "txt_descripcion", value: "-", tipo: "html" },
			{ id: "txt_existencia", value: "-", tipo: "html" },
			{ id: "txt_cant_producto", value: "", disabled: true, tipo: "html" },
			{ id: "txt_precio", value: "0.00", tipo: "html" },
			{ id: "txt_precio_total", value: "0.00", tipo: "html" },
		];

		clearProductInfo(client);
		clearProductInfo(elemnt_product);
		clearProductInfo(resumen_fact);
	}
}

/* eliminar registros  */
/**
 * Función para eliminar un registro de la base de datos y mostrar una alerta de confirmación.
 * @function deleteRecord eliminar registro
 * @param {number} id - El ID del registro que se va a eliminar.
 * */
function deleteRecord(id) {
	swal({
		title: "¿Seguro que deseas eliminar el Registro?",
		text: "No podrás deshacer este paso...",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((willDelete) => {
		if (willDelete) {
			if (deleteProductAPI(id)) {
				swal("!Registro Eliminado!", {
					icon: "success",
				});
			}
		} else {
			swal("!No se Realizo Ningun Cambio!");
		}
	});
}

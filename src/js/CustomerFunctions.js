/**
 * Esta función se encarga de ejecutar ciertas acciones una vez que la página ha cargado completamente.
 */
window.addEventListener("load", function () {});

/**
* Función que se ejecuta al hacer clic en el botón "Agregar .
@param {object} e - Evento del botón "Agregar".
*/
$("#search").click(function (e) {});

/**
* Función que se ejecuta al hacer clic en el botón "Buscar .
@param {object} e - Evento del botón "Agregar".
*/
$("#add").click(function (e) {
	$("#modal_add").modal("show");
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

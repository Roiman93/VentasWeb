<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_customer;
use Classes\Process;
use MVC\Router;
/* clientes */
class CustomerController
{
	public static function index(Router $router)
	{
		session_start();
		isAdmin();

		$frm_filter = Model_customer::filter();
		$frm_modal_edit = Model_customer::modal("edit");
		$frm_modal_add = Model_customer::modal();
		$result = Model_customer::seach();

		$router->render("pages/Customer", [
			"name" => $_SESSION["nombre"],
			"page" => "Clientes",
			"filter" => $frm_filter,
			"table" => $result,
			"modal_add" => $frm_modal_add,
			"modal_edit" => $frm_modal_edit,
			"script" => '<script type="text/javascript" src="build/js/CustomerFunctions.js"></script>',
		]);
	}

	/* se realiza una consulta mediante los fltros*/
	public static function seach_filter()
	{
		/* consulta el cliente dependiendo del filtro */
		$date = Model_customer::seach($_POST);

		/*   Validamos */
		if (!empty($date)) {
			$result = $date;
		} else {
			$result = true;
		}

		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}
	/* se busca el cliente por cedula */
	public static function get_cliente()
	{
		/* consulta el cliente con el numero de documento */

		/*   Validamos si contiene solo numeros */
		if (isset($_POST["date"]) && is_numeric($_POST["date"])) {
			$value = $_POST["date"];
		} else {
			// $_POST["date"] no contiene solo números
			echo json_encode([
				"error" => "Solo se permiten numeros en el campo cedula.",
			]);
			exit();
		}

		$resp_c = Model_customer::where([
			"documento" => $value,
		]);

		$resultado = Process::validar_ar($resp_c);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $resultado]);
		exit();
	}

	/* consulto los clientes por id */
	public static function find()
	{
		$id = $_POST["id"];

		// debuguear($id);
		$_result = Model_customer::find($id);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $_result]);
		exit();
	}
	/* se agrega un registro ala BD */
	public static function add_customer()
	{
		/* consulta el cliente con el numero de documento */

		/*   Validamos si contiene solo numeros */
		if (isset($_POST["date"]) && is_numeric($_POST["date"])) {
			$value = $_POST["date"];
		} else {
			// $_POST["date"] no contiene solo números
			echo json_encode([
				"error" => "Solo se permiten numeros en el campo cedula.",
			]);
			exit();
		}

		$resp_c = Model_customer::where([
			"documento" => $value,
		]);

		$resultado = Process::validar_ar($resp_c);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $resultado]);
		exit();
	}

	/* elimina un registro de la BD */
	public static function eliminar()
	{
		Model_customer::delete();
	}
}

<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_product;
use MVC\Router;

/* producto */
class ProductController
{
	public static function index(Router $router)
	{
		session_start();
		isAdmin();

		$frm_filter = Model_product::filter();
		$frm_modal_edit = Model_product::modal("edit");
		$frm_modal_add = Model_product::modal();
		// $result = Model_product::seach();

		$router->render("pages/product", [
			"name" => $_SESSION["nombre"],
			"page" => "Productos",
			"filter" => $frm_filter,
			"modal_add" => $frm_modal_add,
			"modal_edit" => $frm_modal_edit,
			"script" => '<script type="text/javascript" src="build/js/CustomerFunctions.js"></script>',
		]);
	}

	public static function guardar()
	{
		/*  Almacena la Cita y devuelve el ID */
		$cita = new Cita($_POST);
		$resultado = $cita->guardar();

		$id = $resultado["id"];

		// Almacena la Cita y el Servicio

		/*  Almacena los Servicios con el ID de la Cita */
		$idServicios = explode(",", $_POST["servicios"]);
		foreach ($idServicios as $idServicio) {
			$args = [
				"citaId" => $id,
				"servicioId" => $idServicio,
			];
			$citaServicio = new CitaServicio($args);
			$citaServicio->guardar();
		}

		echo json_encode(["resultado" => $resultado]);
	}

	/*    elimina un producto */
	public static function eliminar()
	{
		if ($_SERVER["REQUEST_METHOD"] === "POST") {
			$id = $_POST["id"];
			$model = Model_product::find($id);
			$model->eliminar();
			header("Location:" . $_SERVER["HTTP_REFERER"]);
		}
	}
}

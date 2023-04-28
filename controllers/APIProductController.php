<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_product;
use Model\Model_stock;
use Model\Model_billing_tmp;
use Classes\Html;
use Classes\Process;
/* producto */
class APIProductController
{
	public static function index()
	{
		$servicios = Servicio::all();
		echo json_encode($servicios);
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

<?php

namespace Controllers;

use MVC\Router;
use Classes\Html;
use Model\Model_citas;

class CitaController
{
	public static function index(Router $router)
	{
		session_start();

		isAuth();

		$frm_filter = Model_citas::filter();
		$frm_modal_edit = Model_citas::modal("edit");
		$frm_modal_add = Model_citas::modal();

		$router->render("config/proced", [
			"name" => $_SESSION["nombre"],
			"page" => "Citas",
			"filter" => $frm_filter,
			"modal_add" => $frm_modal_add,
			"modal_edit" => $frm_modal_edit,
			//"script" => "<script src='build/js/ProcedFunction.js'></script>",
		]);

		// $router->render("pages/citas", [
		// 	"nombre" => $_SESSION["nombre"],
		// 	"id" => $_SESSION["id"],
		// ]);
	}

	public static function seach()
	{
		$data = Model_citas::seach();
		$result = Html::createTabla($data, ["delete", "update"]);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}

	/* consulta por id */
	public static function find()
	{
		$id = $_POST["id"];
		$_result = Model_citas::find($id);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $_result]);
		exit();
	}

	public static function add_citas()
	{
		Model_citas::add();
	}

	public static function update_citas()
	{
		Model_citas::update();
	}

	public static function delete_citas()
	{
		Model_citas::delete();
	}
}

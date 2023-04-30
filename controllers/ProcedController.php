<?php

namespace Controllers;

header("Access-Control-Allow-Origin: *");
use MVC\Router;
use Model\Model_proced;
/* Categoria procedimientos */
class ProcedController
{
	public static function index(Router $router)
	{
		session_start();
		isAdmin();

		$frm_filter = Model_proced::filter();
		// $frm_modal_edit = Model_proced::modal("edit");
		// $frm_modal_add = Model_proced::modal();

		$router->render("config/proced", [
			"name" => $_SESSION["nombre"],
			"page" => "Procedimientos",
			"filter" => $frm_filter,
			// "modal_add" => $frm_modal_add,
			// "modal_edit" => $frm_modal_edit,
			"script" => "<script src='build/js/ProcedFunction.js'></script>",
		]);
	}

	public static function seach()
	{
		$result = Model_proced::seach();

		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}

	/* consulta por id */
	public static function find()
	{
		$id = $_POST["id"];
		$_result = Model_proced::find($id);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $_result]);
		exit();
	}

	public static function add_cat_proced()
	{
		Model_proced::add();
	}

	public static function update_cat_proced()
	{
		Model_proced::update();
	}

	public static function delete_cat_proced()
	{
		Model_proced::delete();
	}
}

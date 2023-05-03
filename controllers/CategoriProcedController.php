<?php

namespace Controllers;

header("Access-Control-Allow-Origin: *");
use MVC\Router;
use Classes\Html;
use Model\Model__cat_proced;
/* Categoria procedimientos */
class CategoriProcedController
{
	public static function index(Router $router)
	{
		session_start();
		isAdmin();

		$frm_filter = Model__cat_proced::filter();
		$frm_modal_edit = Model__cat_proced::modal("edit");
		$frm_modal_add = Model__cat_proced::modal();

		$router->render("pages/cat_proced", [
			"name" => $_SESSION["nombre"],
			"page" => "Categorias Procedimientos",
			"filter" => $frm_filter,
			"modal_add" => $frm_modal_add,
			"modal_edit" => $frm_modal_edit,
			"script" => "<script src='build/js/CategoriProcedFunction.js'></script>",
		]);
	}

	public static function all()
	{
		$result = Model__cat_proced::seach();
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}

	public static function seach()
	{
		$data = Model__cat_proced::seach();
		$result = Html::createTabla($data, ["delete", "update"]);

		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}

	/* consulta por id */
	public static function find()
	{
		$id = $_POST["id"];
		$_result = Model__cat_proced::find($id);
		header("Content-Type: application/json");
		echo json_encode(["resultado" => $_result]);
		exit();
	}

	public static function add_cat_proced()
	{
		Model__cat_proced::add();
	}

	public static function update_cat_proced()
	{
		Model__cat_proced::update();
	}

	public static function delete_cat_proced()
	{
		Model__cat_proced::delete();
	}
}

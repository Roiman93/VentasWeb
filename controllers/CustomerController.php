<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_customer;
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

		$router->render("pages/Customer", [
			"name" => $_SESSION["nombre"],
			"page" => "Clientes",
			"filter" => $frm_filter,
			"modal_add" => $frm_modal_add,
			"modal_edit" => $frm_modal_edit,
			"script" => '<script type="text/javascript" src="build/js/CustomerFunctions.js"></script>',
		]);
	}
}

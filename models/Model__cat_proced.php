<?php
/**
 * @format
 */

namespace Model;
use Classes\Html;
use Classes\Cache;

/* categoria procedimientos */
class Model__cat_proced extends ActiveRecord
{
	/* tabla de la Base de datos */
	protected static $tabla = "cat_proced";

	/* columnas de la tabla  de la BD*/
	protected static $columnasDB = [];

	/**
	 * Constructor de la clase Model_customer
	 *
	 * @param array $args Un arreglo asociativo de argumentos que se utilizan para inicializar las propiedades del objeto
	 *
	 * El constructor de la clase consulta los campos de la tabla y crea las propiedades públicas y el constructor
	 * para cada una de ellas. Si la propiedad se llama "id", se inicializa con el valor null, de lo contrario,
	 * se inicializa con el valor del argumento correspondiente. Si el argumento no está definido, se inicializa con
	 * una cadena vacía.
	 */
	public function __construct($args = [])
	{
		// Constructor consulta los campos de la tabla
		self::$columnasDB = self::colum();

		// Iterar sobre las columnas y crear las propiedades públicas y el constructor
		foreach (self::$columnasDB as $columna) {
			// Crear propiedad pública con el nombre de la columna
			// y asignarle un valor inicial de null
			$propiedad = strtolower($columna);
			$this->$propiedad = $propiedad === "id" ? null : $args[$propiedad] ?? "";
		}
	}

	private static $reglasValidacion = [
		"nombre" => ["required"],
		"descripcion" => ["required"],
	];

	public function validar()
	{
		foreach (self::$reglasValidacion as $propiedad => $reglas) {
			foreach ($reglas as $regla) {
				switch ($regla) {
					case "required":
						if (!$this->$propiedad) {
							self::$alertas["error"][] = "El campo {$propiedad} es obligatorio";
						}
						break;
					// Otras reglas de validación aquí
				}
			}
		}
		return self::$alertas;
	}

	public static function seach()
	{
		$fields = ["id", "nombre as Nombre", "descripcion as Descripcion"];

		$tables = ["cat_proced"];

		/* variables */
		$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "null";
		$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "null";

		$where_conditions = [
			!empty($nombre) && $nombre != "null" ? " nombre like '%{$nombre}%'" : "",
			!empty($descripcion) && $descripcion != "null" ? " descripcion like '%{$descripcion}%'" : "",
		];

		$where_conditions = array_filter($where_conditions);
		$where = count($where_conditions) > 0 ? "" . implode(" AND ", $where_conditions) : "";

		$data = (array) self::select($tables, "", $fields, "", $where);

		return $data;
	}

	public static function add()
	{
		$_cat_proced = new Model__cat_proced();
		$alertas = [];

		$_cat_proced->sincronizar($_POST);
		//debuguear($_cat_proced);

		$alertas = $_cat_proced->validar();

		if (empty($alertas)) {
			$rsp = $_cat_proced->guardar();

			if ($rsp == true) {
				/* eliminamos las variables */
				unset($_cat_proced);
				unset($_POST);
				$data = self::seach();
				$result = Html::createTabla($data, ["delete", "update"]);

				header("Content-Type: application/json");
				echo json_encode([
					"resultado" => $result,
					"rsp" => $rsp,
				]);
				exit();
			}
		} else {
			$msg = "";
			foreach ($alertas as $key => $mensajes) {
				foreach ($mensajes as $mensaje) {
					$msg .= $key . " ";
					$msg .= "<p>" . $mensaje . "</p> </div>";
				}
			}

			header("Content-Type: application/json");
			echo json_encode(["error" => $msg]);
			exit();
		}
	}

	public static function update()
	{
		// debuguear($_POST);
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$_cat_proced = Model__cat_proced::find($_POST["id"]);

			/*  variables  */
			$alertas = [];

			$_cat_proced->sincronizar($_POST);

			$alertas = $_cat_proced->validar();

			if (empty($alertas)) {
				// debuguear($_cat_proced);

				$rsp = $_cat_proced->guardar();

				if ($rsp == true) {
					/* eliminamos las variables */
					unset($_cat_proced);
					unset($_POST);
					$data = self::seach();
					$result = Html::createTabla($data, ["delete", "update"]);

					header("Content-Type: application/json");
					echo json_encode([
						"resultado" => $result,
						"rsp" => $rsp,
					]);
					exit();
				}
			} else {
				$mensajes = "";
				foreach ($alertas as $key => $mensajes) {
					foreach ($mensajes as $mensaje) {
						$mensajes .= "<div class='ui inverted red segment'" . $key . ">";
						$mensajes .= "<p>" . $mensaje . "</p> </div>";
					}
				}

				header("Content-Type: application/json");
				echo json_encode(["error" => $mensajes]);
				exit();
			}
		}
	}

	public static function delete()
	{
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];

			$_model = new Model__cat_proced();
			$rsp = $_model->eliminar("id", $id);

			if ($rsp == true) {
				/* eliminamos las variables */
				unset($_model);
				unset($_POST);
				$data = self::seach();
				$result = Html::createTabla($data, ["delete", "update"]);

				echo json_encode([
					"resultado" => $result,
					"rsp" => $rsp,
				]);
				exit();
			}
		}
	}

	/* crea los filtros en la vista  */
	public static function filter()
	{
		$filter = [
			"id" => "filter_cat_proced",
			"class" => "ui stackable form",
			"header" => "Filtros",
			"fields" => [
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Ingrese el nombre",
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Descripción",
					"id" => "descripcion",
					"name" => "descripcion",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "",
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Botones",
					"type" => "buttons",
					"buttons" => [
						[
							"class" => "ui primary button",
							"label" => "Buscar",
							"id" => "search",
							"name" => "search",
							"icon" => "search icon",
							"data-conten" => "buscar",
							"type" => "submit",
						],
						[
							"class" => "ui green   button",
							"label" => "Agregar",
							"id" => "add",
							"name" => "add",
							"icon" => "plus square outline icon",
							"type" => "button",
							"data-conten" => "Agregar",
							"onclick" => "add();",
						],
						[
							"class" => "ui red  button",
							"id" => "recharge",
							"name" => "recharge",
							"label" => "Recargar",
							"icon" => "cancel icon",
							"type" => "button",
							"onclick" => "cancel()",
							"data-conten" => "Recargar Pagina",
						],
					],
				],
			],
		];

		$cacheKey = "filter_cat_proced";
		$cachedData = Cache::get($cacheKey);

		if ($cachedData !== false && !empty($cachedData)) {
			/*  Los datos se encuentran en el cache */
			return $cachedData;
		}
		$result = Html::generateFilters_inline($filter);
		/* Guardar los datos en el cache */
		Cache::set($cacheKey, $result);

		return $result;
	}

	/* crea los modales para editar y agregar */
	public static function modal($prm = "")
	{
		$modal_edit = [
			"id" => "modal_edit",
			"class" => "ui longer modal",
			"header" => "Registro de Categotias Procedimientos",
			"fields" => [
				[
					"label" => "",
					"id" => "id",
					"name" => "id",
					"type" => "hidden",
					"data-type" => "number",
					"placeholder" => "",
					"required" => true,
				],
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Nombre de la categoria",
					"required" => true,
					"onkeypress" => "return letters_espace_Only(event);",
				],
				[
					"label" => "Descripción",
					"id" => "descripcion",
					"name" => "descripcion",
					"type" => "textarea",
					"data-type" => "textarea",
					"maxlength" => "100",
					"rows" => "4",
					"required" => true,
					"placeholder" => "Descripción de la categoria",
					"onkeypress" => "",
				],
				[
					"label" => "Botones",
					"type" => "buttons",
					"buttons" => [
						[
							"class" => "ui positive right floated labeled icon button",
							"id" => "update",
							"label" => "Guardar",
							"icon" => "checkmark icon",
						],
						[
							"class" => "ui black right floated  deny button",
							"id" => "cancel_edit",
							"onclick" => "cleanForm('modal_edit');
							$('#modal_edit').modal('hide'); ",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
					],
				],
			],
		];

		$modal_add = [
			"id" => "modal_add",
			"class" => "ui longer modal",
			"header" => "Registro de clientes",
			"fields" => [
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Primer Nombre",
					"required" => true,
					"onkeypress" => "return letters_espace_Only(event);",
				],
				[
					"label" => "Descripción",
					"id" => "descripcion",
					"name" => "descripcion",
					"type" => "textarea",
					"data-type" => "textarea",
					"maxlength" => "100",
					"rows" => "4",
					"required" => true,
					"placeholder" => "Descripción de la categoria",
					"onkeypress" => "",
				],
				[
					"label" => "Botones",
					"type" => "buttons",
					"buttons" => [
						[
							"class" => "ui positive right floated labeled icon button",
							"id" => "add_record",
							"label" => "Guardar",
							"icon" => "checkmark icon",
						],
						[
							"class" => "ui black right floated  deny button",
							"id" => "cancel_add",
							"onclick" => "cleanForm('modal_add');
							$('#modal_add').modal('hide'); ",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
					],
				],
			],
		];

		if (isset($prm) && $prm == "edit") {
			/* Verificar si la información se encuentra en el cache */
			$cacheKey = "modal_edit";
			$cachedData = Cache::get($cacheKey);

			// var_dump($cachedData);
			// exit();

			if ($cachedData !== false && !empty($cachedData)) {
				/*  Los datos se encuentran en el cache */

				// var_dump($cachedData);
				return $cachedData;
			}

			$result = Html::createModal($modal_edit);
			/* Guardar los datos en el cache */
			Cache::set($cacheKey, $result);
			return $result;
		} else {
			$cacheKey = "modal_add";
			$cachedData = Cache::get($cacheKey);

			if ($cachedData !== false && !empty($cachedData)) {
				/*  Los datos se encuentran en el cache */
				return $cachedData;
			}

			$result = Html::createModal($modal_add);
			/* Guardar los datos en el cache */
			Cache::set($cacheKey, $result);
			return $result;
		}
	}
}

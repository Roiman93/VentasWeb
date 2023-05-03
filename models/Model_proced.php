<?php
/**
 * @format
 */

namespace Model;
use Classes\Html;
use Classes\Process;
use Classes\Cache;
use Model\Model__cat_proced;

/* categoria procedimientos */
class Model_proced extends ActiveRecord
{
	/* tabla de la Base de datos */
	protected static $tabla = "proced";

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
		"id_categoria" => ["required"],
		"descripcion" => ["required"],
		"valor" => ["required"],
		"codigo" => ["required"],
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

	/* consulta todos los procedimientos*/
	public static function all()
	{
		$result = self::all();
		return $result;
	}

	public static function seach()
	{
		$fields = ["id", "nombre as Nombre", "id_categoria", "descripcion as Descripcion", "valor as Valor", "codigo as Codigo"];

		$tables = ["proced"];

		/* variables */
		$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "null";
		$id_cat = isset($_POST["id_categoria"]) ? $_POST["id_categoria"] : "null";
		$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "null";
		$valor = isset($_POST["valor"]) ? $_POST["valor"] : "null";
		$codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : "null";

		$where_conditions = [
			!empty($nombre) && $nombre != "null" ? " nombre like '%{$nombre}%'" : "",
			!empty($id_cat) && $id_cat != "null" && $id_cat != "all" ? "id_categoria = '$id_cat'" : "",
			!empty($descripcion) && $descripcion != "null" ? " descripcion like '%{$descripcion}%'" : "",
			!empty($valor) && $valor != "null" ? " valor like '%{$valor}%'" : "",
			!empty($codigo) && $codigo != "null" ? " codigo like '%{$codigo}%'" : "",
		];

		$where_conditions = array_filter($where_conditions);
		$where = count($where_conditions) > 0 ? "" . implode(" AND ", $where_conditions) : "";

		$data = (array) self::select($tables, "", $fields, "", $where);

		return $data;
	}

	public static function add()
	{
		$proced = new Model_proced();
		$alertas = [];

		$proced->sincronizar($_POST);
		//debuguear($proced);

		$alertas = $proced->validar();

		if (empty($alertas)) {
			$rsp = $proced->guardar();

			if ($rsp == true) {
				/* eliminamos las variables */
				unset($proced);
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
			$proced = Model_proced::find($_POST["id"]);

			/*  variables  */
			$alertas = [];

			$proced->sincronizar($_POST);

			$alertas = $proced->validar();

			if (empty($alertas)) {
				// debuguear($proced);

				$rsp = $proced->guardar();

				if ($rsp == true) {
					/* eliminamos las variables */
					unset($proced);
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

			$_model = new Model_proced();
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
			"id" => "filter_proced",
			"class" => "ui stackable form",
			"header" => "Filtros",
			"fields" => [
				[
					"label" => "Codigo",
					"id" => "flt_codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Ingrese el codigo",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Nombre",
					"id" => "flt_nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Ingrese el nombre",
					"onkeypress" => "return letters_espace_Only(event);",
				],
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "Categoria",
					"id" => "id_categoria",
					"name" => "id_categoria",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
					],
					"value" => "OT",
				],
				[
					"label" => "Descripción",
					"id" => "flt_descripcion",
					"name" => "descripcion",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "",
					"onkeypress" => "return letters_espace_Only(event);",
				],
				[
					"label" => "Valor",
					"id" => "flt_valor",
					"name" => "valor",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "",
					"onkeypress" => "return valideKey(event);",
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

		$cacheKey = "filter_proced";
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
			"id" => "modal_edit_proced",
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
					"label" => "Codigo ",
					"id" => "codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Codigo de la categoria",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
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
					"type" => "select",
					"data-type" => "select",
					"label" => "Categoria",
					"id" => "id_categoria_edit",
					"name" => "id_categoria",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
					],
					"value" => "OT",
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
					"label" => "Precio",
					"id" => "valor",
					"name" => "valor",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Ingrese el precio del procedimiento",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
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
							"onclick" => "cleanForm('modal_edit_proced');
							$('#modal_edit_proced').modal('hide'); ",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
					],
				],
			],
		];

		$modal_add = [
			"id" => "modal_add_proced",
			"class" => "ui longer modal",
			"header" => "Registro de clientes",
			"fields" => [
				[
					"label" => "Codigo ",
					"id" => "codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Codigo de la categoria",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
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
					"type" => "select",
					"data-type" => "select",
					"label" => "Categoria",
					"id" => "id_categoria_add",
					"name" => "id_categoria",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
					],
					"value" => "OT",
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
					"label" => "Precio",
					"id" => "valor",
					"name" => "valor",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Ingrese el precio del procedimiento",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
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
							"onclick" => "cleanForm('modal_add_proced');
							$('#modal_add_proced').modal('hide'); ",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
					],
				],
			],
		];

		if (isset($prm) && $prm == "edit") {
			/* Verificar si la información se encuentra en el cache */
			$cacheKey = "modal_edit_proced";
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
			$cacheKey = "modal_add_proced";
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

<?php
/**
 * @format
 */

namespace Model;
use Classes\Html;
use Classes\Cache;
use Classes\Process;

/* cliente */
class Model_customer extends ActiveRecord
{
	/* tabla de la Base de datos */
	protected static $tabla = "cliente";

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

	public function validar()
	{
		if (!$this->cedula) {
			self::$alertas["error"][] = "El numero de documento  es Obligatorio";
		}
		if (!$this->nombre_1) {
			self::$alertas["error"][] = "El Nombre  es Obligatorio";
		}
		if (!$this->nombre_2) {
			self::$alertas["error"][] = "El Nombre  es Obligatorio";
		}
		if (!$this->apellido_1) {
			self::$alertas["error"][] = "El Nombre  es Obligatorio";
		}
		if (!$this->apellido_2) {
			self::$alertas["error"][] = "El apellido  es Obligatorio";
		}
		if (!$this->fecha) {
			self::$alertas["error"][] = "la fecha es Obligatoria";
		}

		return self::$alertas;
	}

	/* consulta un cliente por el numero de documento */
	public static function get()
	{
		$result = Model_customer::all();
		return $result;
	}

	public static function seach()
	{
		$fields = [
			"id",
			"tipo_doc as Tipo_Documento",
			"documento as Documento",
			"CONCAT(nombre,' ', s_nombre)as Nombres",
			"CONCAT(apellido,' ', s_apellido)as Apellidos",
			"sexo as Sexo",
			"g_sanguineo as G_sanquineo",
			"edad as Edad",
			"est_civil as Estado_civil",
			"ocupacion as Ocupacion",
		];

		$tables = ["cliente"];

		/* variables */
		$tipo = isset($_POST["tipo_doc"]) ? $_POST["tipo_doc"] : "null";
		$documento = isset($_POST["documento"]) ? $_POST["documento"] : "null";
		$nombres = isset($_POST["nombres"]) ? $_POST["nombres"] : "null";
		$apellidos = isset($_POST["apellidos"]) ? $_POST["apellidos"] : "null";
		$g_sanguineo = isset($_POST["g_sanguineo"]) ? $_POST["g_sanguineo"] : "null";

		$where_conditions = [
			!empty($tipo) && $tipo != "null" ? "tipo_doc = '$tipo'" : "",
			!empty($documento) && $documento != "null" ? "documento like '%{$documento}%'" : "",
			!empty($nombres) && $nombres != "null" ? "CONCAT(nombre, ' ', s_nombre) like '%{$nombres}%'" : "",
			!empty($apellidos) && $apellidos != "null" ? "CONCAT(apellido, ' ', s_apellido) like '%{$apellidos}%'" : "",
			!empty($g_sanguineo) && $g_sanguineo != "null" ? "g_sanguineo = '$g_sanguineo'" : "",
		];

		$where_conditions = array_filter($where_conditions);
		$where = count($where_conditions) > 0 ? "" . implode(" AND ", $where_conditions) : "";

		$data = (array) Model_customer::select($tables, "", $fields, "", $where);

		$tabla = Html::createTabla($data, ["delete", "update"]);

		return $tabla;
	}

	public static function delete()
	{
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$id = $_POST["id"];

			$_model = new Model_customer();
			$result = $_model->eliminar("id", $id);

			if ($result == true) {
				$result = Model_customer::seach($_POST);
				header("Content-Type: application/json");
				echo json_encode(["resultado" => $result]);
				exit();
			}
		}
	}

	/* crea los filtros en la vista  */
	public static function filter()
	{
		$filter = [
			"id" => "filter_customer",
			"class" => "ui stackable form",
			"header" => "Filtros",
			"fields" => [
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "Tipo Documento",
					"id" => "tipo_doc",
					"name" => "tipo_doc",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"CC" => "Cedula",
						"TI" => "Tarejeta de identidad",
						"RI" => "Registro civil",
					],
					"value" => "OT",
				],
				[
					"label" => "Numero documento",
					"id" => "documento",
					"name" => "documento",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Numero de documento",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Nombres",
					"id" => "nombres",
					"name" => "nombres",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Primer Nombre",
					"onkeypress" => "return lettersOnly(event);",
				],

				[
					"label" => "Apellidos",
					"id" => "apellidos",
					"name" => "apellidos",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Apellido",
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "G sanguineo",
					"id" => "g_sanguineo",
					"name" => "g_sanguineo",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"O" => "O-",
						"O1" => "O+",
						"A" => "A-",
						"A1" => "A+",
						"B" => "B-",
						"B1" => "B+",
						"AB" => "AB-",
						"AB1" => "AB+",
					],
					"value" => "OT",
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

		$cacheKey = "filter_customer";
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
			"header" => "Registro de clientes",
			"fields" => [
				[
					"type" => "select",
					"label" => "Tipo Documento",
					"name" => "tipo_doc",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"CC" => "Cedula",
						"TI" => "Tarejeta de identidad",
						"RI" => "Registro civil",
					],
					"value" => "OT",
				],
				[
					"label" => "Numero documento",
					"id" => "documento",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Numero de documento",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Nombre",
					"id" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Primer Nombre",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Segundo Nombre",
					"id" => "s_nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Segundo Nombre",

					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Apellido",
					"id" => "apellido",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Apellido",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Segundo Apellido",
					"id" => "s_apellido",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Apellido",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Sexo",
					"id" => "sexo",
					"type" => "select",
					"name" => "sexo",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"M" => "Masculino",
						"F" => "Femenino",
						"O" => "No binario",
					],
					"value" => "OT",
				],
				[
					"label" => "Edad",
					"id" => "edad",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Primer Nombre",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Estado civil",
					"id" => "est_civil",
					"type" => "select",
					"name" => "est_civil",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"SO" => "Soltero(a)",
						"CA" => "Casado(a)",
						"UN" => "Conviviente civil",
						"SP" => "Separado(a) judicialmente",
						"DV" => "Divorciado(a)",
						"VD" => "Viudo(a)",
					],
					"value" => "OT",
				],
				[
					"label" => "Ocupaciòn",
					"id" => "ocupacion",
					"type" => "text",
					"data-type" => "text",
					"name" => "ocupacion",
					"placeholder" => "ocupacion",
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Direcciòn",
					"id" => "direccion",
					"type" => "text",
					"data-type" => "text",
					"name" => "direccion",
					"placeholder" => "direccion ",
					"required" => true,
				],
				[
					"label" => "Telefono",
					"id" => "telefono",
					"type" => "text",
					"data-type" => "number",
					"name" => "telefono",
					"placeholder" => "Telefono",
					"onkeypress" => "return valideKey(event);",
					"required" => true,
				],

				[
					"label" => "Botones",
					"type" => "buttons",
					"buttons" => [
						[
							"class" => "ui black deny button",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
						[
							"class" => "ui positive right labeled icon button",
							"label" => "Guardar",
							"icon" => "checkmark icon",
							"onclick" => "add();",
						],
					],
				],
			],
		];

		$modal = [
			"id" => "modal_add",
			"class" => "ui modal",
			"header" => "Registro de clientes",
			"fields" => [
				[
					"label" => "Hora",
					"id" => "hora",
					"name" => "hora",
					"type" => "time",
					"data-type" => "time",
					"required" => true,
				],
				[
					"label" => "fecha",
					"id" => "fecha",
					"name" => "fecha",
					"type" => "date",
					"data-type" => "date",
					"required" => true,
				],
				[
					"label" => "Rango",
					"id" => "range",
					"name" => "range",
					"type" => "range",
					"data-type" => "range",
					"required" => true,
				],
				[
					"type" => "checkbox",
					"data-type" => "checkbox",
					"id" => "ch_doc",
					"name" => "ch_doc",
					"label" => "Seleccione una de las opciones",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Seleccione--",
							"disabled" => true,
						],
						"si" => "si",
						"no" => "no",
						"nose" => "nose",
					],
					"value" => ["si", "no"],
				],
				[
					"type" => "select",
					"data-type" => "select",
					"id" => "tipo_doc",
					"name" => "tipo_doc",
					"label" => "Tipo Documento",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"CC" => "Cedula",
						"TI" => "Tarejeta de identidad",
						"RI" => "Registro civil",
					],
					"value" => "OT",
				],
				[
					"label" => "Numero documento",
					"id" => "documento",
					"name" => "documento",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Numero de documento",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Primer Nombre",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Segundo Nombre",
					"id" => "s_nombre",
					"name" => "s_nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Segundo Nombre",

					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Apellido",
					"id" => "apellido",
					"name" => "apellido",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Apellido",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Segundo Apellido",
					"id" => "s_apellido",
					"name" => "s_apellido",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Apellido",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Sexo",
					"id" => "sexo",
					"name" => "sexo",
					"type" => "select",
					"data-type" => "select",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"M" => "Masculino",
						"F" => "Femenino",
						"O" => "No binario",
					],
					"value" => "OT",
				],
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "G sanguineo",
					"id" => "g_sanguineo",
					"name" => "g_sanguineo",
					"required" => true,
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"O" => "O-",
						"O1" => "O+",
						"A" => "A-",
						"A1" => "A+",
						"B" => "B-",
						"B1" => "B+",
						"AB" => "AB-",
						"AB1" => "AB+",
					],
					"value" => "OT",
				],
				[
					"label" => "Edad",
					"id" => "edad",
					"name" => "edad",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Primer Nombre",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Estado civil",
					"id" => "est_civil",
					"name" => "est_civil",
					"type" => "select",
					"data-type" => "select",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"SO" => "Soltero(a)",
						"CA" => "Casado(a)",
						"UN" => "Conviviente civil",
						"SP" => "Separado(a) judicialmente",
						"DV" => "Divorciado(a)",
						"VD" => "Viudo(a)",
					],
					"value" => "OT",
				],
				[
					"label" => "Ocupaciòn",
					"id" => "ocupacion",
					"name" => "ocupacion",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "ocupacion",
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Direcciòn",
					"id" => "direccion",
					"name" => "direccion",
					"type" => "text",
					"data-type" => "address",
					"placeholder" => "direccion ",
					"required" => true,
				],
				[
					"label" => "Telefono",
					"id" => "telefono",
					"name" => "telefono",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Telefono",
					"onkeypress" => "return valideKey(event);",
					"required" => true,
				],

				[
					"label" => "Botones",
					"type" => "buttons",
					"buttons" => [
						[
							"class" => "ui black deny button",
							"label" => "Cancelar",
							"icon" => "cancel icon",
						],
						[
							"class" => "ui positive right labeled icon button",
							"label" => "Guardar",
							"icon" => "checkmark icon",
							"onclick" => "add();",
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

			$result = Html::createModal($modal);
			/* Guardar los datos en el cache */
			Cache::set($cacheKey, $result);
			return $result;
		}
	}
}

<?php
/**
 * @format
 */

namespace Model;
use Classes\Html;
use Classes\Cache;

/* producto */
class Model_product extends ActiveRecord
{
	// Base de datos
	protected static $tabla = "producto";
	private static $reglasValidacion = [
		"id_producto" => ["required"],
		"nombre" => ["required"],
		"codigo" => ["required"],
		"tipo" => ["required"],
		"precio_compra" => ["required"],
		"precio_venta" => ["required"],
	];

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

	/* crea los filtros en la vista  */
	public static function filter()
	{
		$filter = [
			"id" => "filter_product",
			"class" => "ui stackable form",
			"header" => "Filtros",
			"fields" => [
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "Tipo",
					"id" => "tipo",
					"name" => "tipo",
					"options" => [
						"OT" => [
							"label" => "--Selecione--",
							"disabled" => true,
						],
						"CC" => "Aseo",
						"TI" => "Comida",
						"RI" => "Belleza",
						"all" => "Todos",
					],
					"value" => "OT",
				],
				[
					"label" => "Codigo",
					"id" => "codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "codigo",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Nombre del producto",
					"onkeypress" => "return lettersOnly(event);",
				],

				[
					"label" => "Precio venta",
					"id" => "precio",
					"name" => "precio",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Apellido",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Precio Venta",
					"id" => "precio_venta",
					"name" => "precio_venta",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Apellido",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Precio Compra",
					"id" => "precio_compra",
					"name" => "precio_compra",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Apellido",
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

		$cacheKey = "filter_product";
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
			"header" => "Registro de productos",
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
					"placeholder" => "Nombre del producto",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Codigo",
					"id" => "codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "codigo del producto",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Tipo",
					"id" => "tipo",
					"name" => "tipo",
					"type" => "select",
					"data-type" => "select",
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
					"label" => "Precio venta",
					"id" => "precio",
					"name" => "precio",
					"type" => "text",
					"data-type" => "number",
					"required" => true,
					"placeholder" => "0",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Precio Compra",
					"id" => "precio_compra",
					"name" => "precio_compra",
					"type" => "text",
					"data-type" => "number",
					"required" => true,
					"placeholder" => "0",
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
			"header" => "Registro de productos",
			"fields" => [
				[
					"label" => "Nombre",
					"id" => "nombre",
					"name" => "nombre",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Nombre del producto",
					"required" => true,
					"onkeypress" => "return lettersOnly(event);",
				],
				[
					"label" => "Codigo",
					"id" => "codigo",
					"name" => "codigo",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "codigo del producto",
					"required" => true,
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Tipo",
					"id" => "tipo",
					"name" => "tipo",
					"type" => "select",
					"data-type" => "select",
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
					"label" => "Precio venta",
					"id" => "precio",
					"name" => "precio",
					"type" => "text",
					"data-type" => "number",
					"required" => true,
					"placeholder" => "0",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Precio Compra",
					"id" => "precio_compra",
					"name" => "precio_compra",
					"type" => "text",
					"data-type" => "number",
					"required" => true,
					"placeholder" => "0",
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
			$cacheKey = "modal_edit_product";
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
			$cacheKey = "modal_add_product";
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

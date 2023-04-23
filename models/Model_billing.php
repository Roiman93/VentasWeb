<?php
/**
 * @format
 */

namespace Model;
use Classes\Html;
use Classes\Cache;
use Classes\Process;
use Model\Model_stock;
use Model\Model_dt_billing;
use Model\Model_billing_tmp;
use Model\Model_prefixes;

/* facturacion */
class Model_billing extends ActiveRecord
{
	// Base de datos
	protected static $tabla = "fact";
	/* columnas de la tabla  de la BD*/
	protected static $columnasDB = [];

	/**
	 * Constructor de la clase Model_billing
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
		"prefijo" => ["required"],
		"numero" => ["required"],
		"id_cliente" => ["required"],
		"usuario" => ["required"],
		"total" => ["required"],
		"status" => ["required"],
		"fecha" => ["required"],
	];

	public function validar()
	{
		foreach (self::$reglasValidacion as $propiedad => $reglas) {
			foreach ($reglas as $regla) {
				switch ($regla) {
					case "required":
						if ($this->$propiedad = "") {
							self::$alertas["error"][] = "El campo {$propiedad} es obligatorio";
						}
						break;
					// Otras reglas de validación aquí
				}
			}
		}
		return self::$alertas;
	}

	/* consulta las factura con los filtros */
	public static function seach()
	{
		$fields = [
			"f.id",
			"CONCAT(f.prefijo,' ',f.numero) as Numero",
			"CONCAT(nombre,' ',s_nombre,' ',apellido,' ',s_apellido) as Nombre",
			"f.fecha",
			"f.status",
		];

		$tables = ["fact f", "cliente"];

		/* variables */
		$numero = isset($_POST["numero"]) ? $_POST["numero"] : "null";
		$cliente = isset($_POST["cliente"]) ? $_POST["cliente"] : "null";
		$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "null";
		$status = isset($_POST["est"]) ? $_POST["est"] : "null";

		$joins = ["f.id_cliente = cliente.id"];

		$where_conditions = [
			!empty($numero) && $numero != "null" ? " f.numero = '$numero'" : "",
			!empty($cliente) && $cliente != "null"
				? " CONCAT(nombre,' ',s_nombre,' ',apellido,' ',s_apellido) like '%{$cliente}%'"
				: "",
			!empty($fecha) && $fecha != "null" ? " CAST(f.`fecha` AS CHAR) LIKE '%{$fecha}%'" : "",
			$status != "null" && $status != "all" ? " f.status = '$status'" : "",
		];

		$where_conditions = array_filter($where_conditions);
		$where = count($where_conditions) > 0 ? "" . implode(" AND ", $where_conditions) : "";

		$data = (array) Model_billing_tmp::select($tables, $joins, $fields, "INNER JOIN", $where);

		$tabla = Html::createTabla($data, ["status", "disabled_status"]);

		return $tabla;
	}

	/* se consulta un producto  por codigo y su stock */
	public static function add_billing()
	{
		/*  variables para crear la factura */
		$token = trim($_POST["token_user"]);
		$pref = trim($_POST["prefijo"]);
		$nume = trim($_POST["numero"]);
		$id_cliente = trim($_POST["id_cliente"]);
		$user = trim($_POST["usuario"]);
		$total = trim($_POST["total"]);

		$dt_fact = [];
		$error = "";

		$dates_val = Process::validar_datos([
			"token" => $token,
			"texto" => $pref,
			"numero" => $nume,
			"numero" => $id_cliente,
			"numero" => $user,
			"moneda" => $total,
		]);

		if ($dates_val === true) {
			/*  Todos los valores son válidos */

			$valor = str_replace(".00", "", $total); /* quitar los puntos */
			$valor = str_replace(".", "", $valor); /*  redondear a dos decimales */
			$_POST["total"] = $valor;

			$_model = new Model_billing($_POST);
			$fact = $_model->guardar();

			/* retorna el id  del insert */
			$id = $fact["id"];

			if (isset($id)) {
				/*   echo "Los datos fueron insertados correctamente. El ID del último registro insertado es: " . $id; */
				$data = Model_billing_tmp::where([
					"token_user" => $token,
				]);

				if (!empty($data) && is_array($data)) {
					foreach ($data as $detalle) {
						$dt_fact[] = [
							"id_fact" => $id,
							"id_producto" => $detalle->id_producto,
							"cantidad" => $detalle->cantidad,
							"precio_venta" => $detalle->precio_venta,
						];
					}
				} else {
					echo json_encode(["error" => "No se encontraron datos."]);
					exit();
				}

				/*se guardan los detalles de la factura */
				$_md_dt_billing = new Model_dt_billing();
				$resul_dt = $_md_dt_billing->insert($dt_fact);

				if ($resul_dt["id"] && $resul_dt["id"] > 0) {
					/* Acciones en caso de éxito */

					/* consultamos  resolucion */
					$_prefj = new Model_prefixes();
					$resp_pr = Model_prefixes::where([
						"tipo_documento" => 1,
						"estado" => 2,
					]);

					if (!empty($resp_pr) && is_array($resp_pr)) {
						$upd = Process::validar_ar($resp_pr);
						/*  actualizamos numeracion */
						$upd->n_actual = $upd->n_actual + 1;
						$result_prefj = $upd->guardar();

						if ($result_prefj["resultado"] === true) {
							/* Actualización exitosa prefijo */

							$_tmp_billing = new Model_billing_tmp();
							$condiciones = ["token_user" => $token];
							$reslt_tmp_billing = $_tmp_billing->delete_batch($condiciones);
							if ($reslt_tmp_billing["resultado"] === true) {
								echo json_encode(["resultado" => "Numero:" . $pref . "" . $nume]);
								exit();
							}
						} else {
							echo json_encode(["error" => "Hubo un error al actualizar prefijo"]);
							exit();
						}
					} else {
						echo json_encode(["error" => "No se encontraron datos. en los prefijos"]);
						exit();
					}
				} else {
					/*  Acciones en caso de error */
					echo json_encode(["error" => "Error al insertar el detalle de la factura."]);
					exit();
				}
			} else {
				/*  Acciones en caso de error */
				echo json_encode(["error" => "Error al insertar los datos de la cabecera de la factura"]);
				exit();
			}
		} else {
			/*  Mostrar mensajes de error */
			foreach ($dates_val as $clave => $mensaje) {
				$error .= "El campo " . $clave . " mensaje: " . $mensaje;
			}
			echo json_encode([
				"error" => $error,
			]);
			exit();
		}
	}

	/* elimina el detalle_tmp_factura */
	public static function delete_billing()
	{
		$token = $_POST["token_user"];

		if (!empty($token)) {
			$_model = new Model_billing_tmp($_POST);
			$resultado = $_model->eliminar("token_user", $token);

			if ($resultado == true) {
				/* no se encontraron reseultados */
				echo $result = json_encode([
					"resultado" => "Operacion Realizada con exito",
				]);
				exit();
			} else {
				/*  Resultado en formato JSON */
				echo json_encode([
					"error" => "Error al eliminar el detalle de la factura",
				]);

				exit();
			}
		} else {
			/*  Resultado en formato JSON */
			echo json_encode([
				"error" => "El token esta vacio",
			]);
		}
	}

	/* se consulta un producto  por codigo y su stock */
	public static function get_stock_product()
	{
		if (Process::validar_datos(["numero" => $_POST["data"]])) {
			$resp_p = Model_stock::where([
				"codigo" => $_POST["data"],
			]);

			$resultado = Process::validar_ar($resp_p);

			header("Content-Type: application/json");
			echo json_encode(["resultado" => $resultado]);
			exit();
		} else {
			echo json_encode(["error" => "Solo se perminten numero"]);
			exit();
		}
	}

	/* consulta el detalle temporal de las facturas*/
	public static function get_detalle_product()
	{
		$token = $_POST["token_user"];

		$dates_val = Process::validar_datos([
			"token" => $token,
		]);

		/* validamos los datos*/
		if ($dates_val === true) {
			$tables = ["detalle_tmp_factura", "producto"];
			$joins = ["producto.id_producto = detalle_tmp_factura.id_producto"];
			$fields = [
				"detalle_tmp_factura.id as id ",
				"producto.codigo as codigo",
				"producto.nombre as producto ",
				"detalle_tmp_factura.cantidad as cantidad ",
				"detalle_tmp_factura.precio_venta as precio ",
				"detalle_tmp_factura.cantidad * detalle_tmp_factura.precio_venta as Total ",
			];
			$where = "detalle_tmp_factura.token_user = '" . $token . "'";

			$data = (array) Model_billing_tmp::select($tables, $joins, $fields, "INNER JOIN", $where);

			/* validamos los la respuesta*/
			if (!empty($data)) {
				/* calculo del resumen de la factura */
				$detalle_totales = Process::total_billing($data);
				$tabla = Html::createTabla($data, ["delete"]);
				header("Content-Type: application/json");

				/*  Resultado en formato JSON */
				echo $result = json_encode([
					"resultado" => $tabla,
					"resumen" => $detalle_totales,
				]);
				exit();
			} else {
				/* no se encontraron reseultados */
				echo $result = json_encode([
					"resultado" => null,
				]);
				exit();
			}
		} else {
			/*  Mostrar mensajes de error */
			$error = "";
			foreach ($dates_val as $clave => $mensaje) {
				$error .= "<div class='ui error message'> " . $mensaje . "</div>";
			}
			echo json_encode([
				"error" => $error,
			]);
			exit();
		}
	}

	/* almacena temporalmente los productos del detalle */
	public static function add_detalle_product()
	{
		$token = $_POST["token_user"];
		$model = new Model_billing_tmp($_POST);
		$resultado = $model->guardar();

		/* retorna el id  del insert */
		if (isset($resultado["id"])) {
			$tables = ["detalle_tmp_factura", "producto"];
			$joins = ["producto.id_producto = detalle_tmp_factura.id_producto"];
			$fields = [
				"detalle_tmp_factura.id as id ",
				"producto.codigo as codigo",
				"producto.nombre as producto ",
				"detalle_tmp_factura.cantidad as cantidad ",
				"detalle_tmp_factura.precio_venta as precio ",
				"detalle_tmp_factura.cantidad * detalle_tmp_factura.precio_venta as Total ",
			];
			$where = "detalle_tmp_factura.token_user = '" . $token . "'";

			$data = (array) Model_billing_tmp::select($tables, $joins, $fields, "INNER JOIN", $where);

			/* calculo del resumen de la factura */
			$detalle_totales = Process::total_billing($data);
			$tabla = Html::createTabla($data, ["delete"]);
			header("Content-Type: application/json");
			/*  Resultado en formato JSON */
			echo $result = json_encode([
				"resultado" => $tabla,
				"resumen" => $detalle_totales,
			]);
			exit();
		}
	}

	/* elimina un producto del detalle_tmp_factura */
	public static function delete_detalle_product()
	{
		$token = $_POST["token_user"];
		$value = $_POST["id"];
		$_model = new Model_billing_tmp($_POST);
		$resultado = $_model->eliminar("id", $value);

		if ($resultado == true) {
			$tables = ["detalle_tmp_factura", "producto"];
			$joins = ["producto.id_producto = detalle_tmp_factura.id_producto"];
			$fields = [
				"detalle_tmp_factura.id as id ",
				"producto.codigo as codigo",
				"producto.nombre as producto ",
				"detalle_tmp_factura.cantidad as cantidad ",
				"detalle_tmp_factura.precio_venta as precio ",
				"detalle_tmp_factura.cantidad * detalle_tmp_factura.precio_venta as Total ",
			];
			$where = "detalle_tmp_factura.token_user = '" . $token . "'";

			$data = (array) Model_billing_tmp::select($tables, $joins, $fields, "INNER JOIN", $where);

			if (!empty($data)) {
				/* calculo del resumen de la factura */
				$detalle_totales = Process::total_billing($data);
				$tabla = Html::createTabla($data, ["delete"]);
				header("Content-Type: application/json");

				/*  Resultado en formato JSON */
				echo $result = json_encode([
					"resultado" => $tabla,
					"resumen" => $detalle_totales,
				]);
				exit();
			} else {
				/* no se encontraron reseultados */
				echo $result = json_encode([
					"resultado" => null,
				]);
				exit();
			}
		} else {
			/*  Resultado en formato JSON */
			echo json_encode([
				"error" => "Error al eliminar el producto del detalle",
			]);

			exit();
		}
	}

	public static function delete()
	{
		if (isset($_POST["id"]) && !empty($_POST["id"])) {
			$_billing = Model_billing::find($_POST["id"]);

			$_billing->status = 0;
			$rsp = $_billing->guardar();

			if ($rsp == true) {
				$query = "UPDATE `dt_fact` SET `estatus`='0' WHERE  `id_fact`= '" . $_billing->id . "'";
				$dt_billing = Model_dt_billing::SQL($query);
				if ($dt_billing == true) {
					/* eliminamos las variables */
					unset($_billing);
					unset($dt_billing);
					unset($_POST);
					$result = self::seach();

					header("Content-Type: application/json");
					echo json_encode([
						"resultado" => $result,
						"rsp" => true,
					]);
					exit();
				}
			}
		} else {
			header("Content-Type: application/json");
			echo json_encode([
				"error" => "No se seleciono ningun registro",
				"rsp" => false,
			]);
			exit();
		}
	}

	/* crea los filtros en la vista  */
	public static function filter()
	{
		$filter = [
			"id" => "filter_billing",
			"class" => "ui stackable form",
			"header" => "Filtros",
			"fields" => [
				[
					"label" => "Numero Factura",
					"id" => "numero",
					"name" => "numero",
					"type" => "text",
					"data-type" => "number",
					"placeholder" => "Numero de factura",
					"onkeypress" => "return valideKey(event);",
				],
				[
					"label" => "Cliente",
					"id" => "cliente",
					"name" => "cliente",
					"type" => "text",
					"data-type" => "text",
					"placeholder" => "Nombre",
					"onkeypress" => "return lettersOnly(event);",
				],

				[
					"label" => "fecha",
					"id" => "fecha",
					"name" => "fecha",
					"type" => "date",
					"data-type" => "date",
				],
				[
					"type" => "select",
					"data-type" => "select",
					"label" => "Estado",
					"id" => "est",
					"name" => "est",
					"options" => [
						"1" => "Activa",
						"0" => "Inactiva",
						"all" => "Todos",
					],
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

		$cacheKey = "filter_billing";
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
}

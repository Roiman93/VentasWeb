<?php
/**
 * @format
 */

namespace Model;
/* facturacion temporal */
class Model_billing_tmp extends ActiveRecord
{
	// Base de datos
	protected static $tabla = "detalle_tmp_factura";

	/* columnas de la tabla  de la BD*/
	protected static $columnasDB = [];

	/**
	 * Constructor de la clase Model_billing_tmp
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

	/*  valida la informacion de los campos  */
	public function validar()
	{
		// if (!$this->id_producto) {
		//     self::$alertas["error"][] = "El id del producto es Obligatorio";
		// }
		if (!$this->cantidad) {
			self::$alertas["error"][] = "La cantidad debe ser mayor a 0 ";
		}
		if (!is_numeric($this->mesa)) {
			self::$alertas["error"][] = "El numero de la mesa es Obligatorio";
		}
		// if (!$this->token_user) {
		//     self::$alertas["error"][] = "El tiken es Obligatorio";
		// }

		return self::$alertas;
	}

	public function add_product()
	{
		// Verificar si la matriz de productos ya existe en la sesión
		if (!isset($_SESSION["productos"])) {
			$_SESSION["productos"] = [];
		}

		$producto = [
			"nombre" => $_POST[""],
			"precio" => 9.99,
		];

		array_push($_SESSION["productos"], $producto);

		// O usando la sintaxis de corchetes
		$_SESSION["productos"][] = $producto;
	}
}

<?php
/**
 * @format
 */

namespace Model;

/* existencia */
class Model_stock extends ActiveRecord
{
	/*  declaracias de variables */
	public $id_producto;
	public $codigo;
	public $nombre;
	public $precio_venta;
	public $entradas;
	public $salidas;
	public $stock;

	/* Base de datos */
	protected static $tabla = "stock";

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
		"id_producto" => ["required"],
		"codigo" => ["required"],
		"nombre" => ["required"],
		"precio_venta" => ["required"],
		"entradas" => ["required"],
		"salidas" => ["required"],
		"stock" => ["required"],
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
}

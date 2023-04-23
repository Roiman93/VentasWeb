<?php
/**
 * @format
 */

namespace Model;
class ActiveRecord
{
	/* Base DE DATOS */
	protected static $db;
	protected static $db_conf;
	protected static $tabla = "";
	protected static $columnasDB = [];

	/*  Alertas y Mensajes */
	protected static $alertas = [];
	/* tipo de datos */
	protected static $fieldTypes = [
		"name" => "string",
		"age" => "integer",
		"email" => "string",
	];

	/*  Definir la conexión a la BD - includes/database.php */
	public static function setDB($database)
	{
		self::$db = $database;
	}

	public static function setDB_config($database)
	{
		self::$db_conf = $database;
	}

	public static function setAlerta($tipo, $mensaje)
	{
		static::$alertas[$tipo][] = $mensaje;
	}

	/*  Validación */
	public static function getAlertas()
	{
		return static::$alertas;
	}
	/* validamis si la tabla existe en la sistem_confg */
	public static function tableExistsInDatabase($table)
	{
		try {
			$query =
				"SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'sistem_confg' AND table_name = '" .
				$table .
				"'";

			$result = self::$db_conf->query($query);

			if ($result === false) {
				return false; // la tabla no se encuentra en la base de datos
			} else {
				$row = $result->fetch_assoc();
				$count = $row["count"];
				return $count > 0; // devuelve true si la tabla existe, false si no existe
			}
			/* Si la consulta falla, se lanzará una excepción */
		} catch (Exception $e) {
			// Si la consulta falla, se muestra un mensaje de error utilizando SweetAlert2
			echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "' .
				$e->getMessage() .
				'"
                    });
                </script>';
			exit();
		}
	}
	/*  se verifica si existe algun error */
	public function validar()
	{
		static::$alertas = [];
		return static::$alertas;
	}
	/* captura los errores en una consulta  */
	public static function getResults($query)
	{
		try {
			$insert_id = "";
			if (self::tableExistsInDatabase(static::$tabla)) {
				/* echo "La tabla existe"; */
				$result = self::$db_conf->query($query);
				$insert_id = self::$db_conf->insert_id;
			} else {
				/*  echo "La tabla no existe"; */
				$result = self::$db->query($query);
				$insert_id = self::$db->insert_id;
			}

			/* Si la consulta falla, se lanzará una excepción */
		} catch (Exception $e) {
			echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "' .
				$e->getMessage() .
				'"
                    });
                </script>';
			exit();
		}

		/* Si la consulta se realiza correctamente, se retorna el resultado */
		return [
			"resultado" => $result,
			"insert_id" => $insert_id,
		];
	}

	/* compara 2 objeto y crea uno nuevo con las conincidencias */
	function innerObjeto($obj1, $obj2)
	{
		$resultados = [];
		foreach ($obj1 as $clave => $elemento) {
			foreach ($obj2 as $clave => $value) {
				if ($elemento->id_producto == $value->id_producto) {
					$resultado = [
						"id" => $elemento->id,
						"Producto" => $value->nombre,
						"Cantidad" => $elemento->cantidad,
						"Precio" => $elemento->precio_venta,
						"Total" => $elemento->precio_venta * $elemento->cantidad,
					];
					$resultados[] = (object) $resultado;
				}
			}
		}

		return $resultados;
	}

	function filtrarObjeto($objeto, $valor)
	{
		$resultado = [];
		foreach ($objeto as $clave => $elemento) {
			if ($elemento == $valor) {
				$resultado[$clave] = $elemento;
			}
		}
		return (object) $resultado;
	}
	/* elimina un objeto por el valor que reciba */
	function eliminarObjeto($objeto, $valor)
	{
		foreach ($objeto as $clave => $elemento) {
			if ($elemento != $valor) {
				unset($objeto->$clave);
			}
		}
		return $objeto;
	}

	/* valida el tipo de datos de los objetos */
	function validateObjectFields($object, $fieldTypes)
	{
		// Verifica que el objeto y los tipos de campo sean arrays
		if (!is_array($object) || !is_array($fieldTypes)) {
			throw new InvalidArgumentException("Se esperaba un objeto y un array de tipos de campo.");
		}

		foreach ($object as $key => $value) {
			// Verifica que el campo exista en el array de tipos de campo
			if (!array_key_exists($key, $fieldTypes)) {
				throw new InvalidArgumentException("El campo $key no está definido en el array de tipos de campo.");
			}

			// Verifica que el valor del campo coincida con el tipo de campo definido
			if (gettype($value) !== $fieldTypes[$key]) {
				throw new InvalidArgumentException("El campo $key debe ser de tipo " . $fieldTypes[$key]);
			}
		}

		// Si todos los campos son válidos, devuelve verdadero
		return true;
	}

	/* consulta SQL para crear un array */
	public static function consultSQL_AR($query)
	{
		$resultado = self::getResults($query);
		$array = [];

		if ($resultado["resultado"]->num_rows > 0) {
			/* Iterar los resultados */
			while ($registro = $resultado["resultado"]->fetch_assoc()) {
				$array[] = (object) $registro;
			}
		}
		/* retornar los resultados */
		return $array;
	}

	/* Consulta SQL para crear un objeto en Memoria */
	public static function consultarSQL($query)
	{
		// Validar que la consulta no esté vacía
		if (empty($query)) {
			return null;
		}

		$resultado = self::getResults($query);

		if ($resultado["resultado"] !== true) {
			/* Consulta SELECT */
			if ($resultado["resultado"]->num_rows > 0) {
				/* Iterar los resultados */
				$array = [];
				while ($registro = $resultado["resultado"]->fetch_assoc()) {
					$array[] = static::crearObjeto($registro);
				}

				return $array;
			} else {
				/* No se encontró ningún registro */
				return null;
			}
		} else {
			/* Consulta INSERT, UPDATE o DELETE */
			return $resultado["resultado"];
		}
	}

	public static function crearObjeto($registro)
	{
		$objeto = new static();
		foreach ($registro as $key => $value) {
			$objeto->$key = $value;
		}
		return $objeto;
	}

	// Identificar y unir los atributos de la BD
	public function atributos()
	{
		$atributos = [];
		foreach (static::$columnasDB as $columna) {
			if ($columna === "id") {
				continue;
			}
			// echo "Valor de $columna: " . $this->$columna . "\n";
			$atributos[$columna] = $this->$columna;
		}

		return $atributos;
	}

	// Sanitizar los datos antes de guardarlos en la BD
	public function sanitizarAtributos()
	{
		$atributos = $this->atributos();
		$sanitizado = [];
		foreach ($atributos as $key => $value) {
			$sanitizado[$key] = self::$db->escape_string($value);
		}

		return $sanitizado;
	}

	// Sincroniza BD con Objetos en memoria
	public function sincronizar($args = [])
	{
		foreach ($args as $key => $value) {
			if (property_exists($this, $key) && !is_null($value)) {
				$this->$key = trim($value);
			}
		}
	}

	// Todos los registros
	public static function all()
	{
		$query = "SELECT * FROM " . static::$tabla;
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	// Busca un registro por su id
	public static function find($id)
	{
		$query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

		$resultado = self::consultarSQL($query);
		return array_shift($resultado);
	}

	// Obtener Registros con cierta cantidad
	public static function get_limit($limite)
	{
		$query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
		$resultado = self::consultarSQL($query);
		return array_shift($resultado);
	}

	public static function where($conditions, $operator = "AND")
	{
		$query = "SELECT * FROM " . static::$tabla . " WHERE ";

		/*  recorremos las condiciones y las agregamos a la consulta */
		foreach ($conditions as $column => $value) {
			$query .= $column . " = '" . $value . "' " . $operator . " ";
		}

		/*  eliminamos el último operador lógico que se agregó */
		$query = rtrim($query, $operator . " ");

		$resultado = self::consultarSQL($query);

		/* validamos si la consulta esta vacia */
		if ($resultado == null) {
			return null;
		} else {
			return $resultado;
		}
	}

	/* consultas avanzadas con inner entre varias tablas */
	public static function select($tables, $joins, $fields, $join_type = "INNER JOIN", $where)
	{
		$query = "SELECT " . implode(", ", $fields) . " FROM " . $tables[0];
		if (!empty($joins)) {
			foreach ($joins as $key => $join) {
				$query .= " " . $join_type . " " . $tables[$key + 1] . " ON " . $join;
			}
		}

		if (!empty($where)) {
			$query .= " WHERE " . $where;
		}

		//debuguear($query);

		$resultado = self::consultSQL_AR($query);

		/* validamos si la consulta esta vacia */
		if ($resultado == null) {
			return null;
		} else {
			return (object) $resultado;
		}
	}

	/* consulta las comunas de una tabla en especifico  */
	public static function colum()
	{
		$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . static::$tabla . "'";
		$result = self::consultSQL_AR($query);
		if (!empty($result)) {
			$name = array_column($result, "COLUMN_NAME");
			return $name;
		} else {
			return null;
		}
	}

	// Consulta Plana de SQL (Utilizar cuando los métodos del modelo no son suficientes)
	public static function SQL($query)
	{
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	/* realiza la insercion de uno o varios registros  */
	public function insert($datos = [])
	{
		$campos = [];
		$valores = [];

		$primer_fila = reset($datos);
		$campos[] = "(" . implode(", ", array_keys($primer_fila)) . ")";

		// var_dump($campos);
		// // debuguear($datos);

		foreach ($datos as $fila) {
			$valores_fila = [];

			foreach ($fila as $valor) {
				$valores_fila[] = "'" . $valor . "'";
			}

			$valores[] = "(" . implode(", ", $valores_fila) . ")";
		}

		$query = "INSERT INTO " . static::$tabla . " ";
		$query .= "" . implode(", ", $campos) . " ";
		$query .= "VALUES ";
		$query .= implode(", ", $valores);

		/*   Resultado de la consulta */
		$resultado = self::getResults($query);
		$insert_id = $resultado["insert_id"];
		return [
			"resultado" => $resultado["resultado"],
			"id" => $resultado["insert_id"],
		];
	}

	/* crea un nuevo registro */
	public function crear()
	{
		// Sanitizar los datos
		$atributos = $this->sanitizarAtributos($_POST);

		// Insertar en la base de datos
		$query = " INSERT INTO " . static::$tabla . " ( ";
		$atributos_no_vacios = [];
		foreach ($atributos as $clave => $valor) {
			if (!empty($valor)) {
				$atributos_no_vacios[] = $clave;
			}
		}
		$query .= join(", ", $atributos_no_vacios);
		$query .= " ) VALUES (' ";
		$atributos_no_vacios_valores = [];
		foreach ($atributos_no_vacios as $clave) {
			$valor = $atributos[$clave];
			if (!empty($valor)) {
				$atributos_no_vacios_valores[] = $valor;
			}
		}
		$query .= join("', '", $atributos_no_vacios_valores);
		$query .= " ') ";

		/*   Resultado de la consulta */
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	// Actualizar el registro
	public function actualizar()
	{
		// Sanitizar los datos
		$atributos = $this->sanitizarAtributos();

		// Iterar para ir agregando cada campo de la BD
		$valores = [];
		foreach ($atributos as $key => $value) {
			$valores[] = "{$key}='{$value}'";
		}

		// Consulta SQL
		$query = "UPDATE " . static::$tabla . " SET ";
		$query .= join(", ", $valores);
		$query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
		$query .= " LIMIT 1 ";

		// debuguear($query);

		/*   Resultado de la consulta */
		$resultado = self::consultarSQL($query);
		return $resultado;
	}

	/* Eliminar un Registro por su ID */
	public function eliminar($id_table, $valor)
	{
		$query = "DELETE FROM " . static::$tabla . " WHERE " . $id_table . " = '" . $valor . "'";

		$resultado = self::consultarSQL($query);
		return $resultado;
	}
	/* elimina uno o varios registros */
	public function delete_batch($datos = [], $operator = "AND")
	{
		if (empty($datos)) {
			return false;
		}

		// Iterar para ir agregando cada campo de la BD
		$condiciones = [];
		foreach ($datos as $columna => $valor) {
			$condiciones[] = "{$columna} = '{$valor}'";
		}

		// Consulta SQL
		$query = "DELETE FROM " . static::$tabla . " WHERE ";
		$query .= join(" {$operator} ", $condiciones);

		// Ejecutar consulta y retornar resultado
		$resultado = self::getResults($query);
		return $resultado;
	}

	// Registros - CRUD
	public function guardar()
	{
		$resultado = "";

		if (!is_null($this->id)) {
			// actualizar

			$resultado = $this->actualizar();
		} else {
			// debuguear($_POST);
			// //   echo "</br>";
			//  exit();
			// Creando un nuevo registro
			$resultado = $this->crear();
		}
		return $resultado;
	}
}

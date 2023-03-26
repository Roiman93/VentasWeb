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
            if (self::tableExistsInDatabase(static::$tabla)) {
                /* echo "La tabla existe"; */
                $result = self::$db_conf->query($query);
            } else {
                /*  echo "La tabla no existe"; */
                $result = self::$db->query($query);
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
        return $result;
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
                        "Total" =>
                            $elemento->precio_venta * $elemento->cantidad,
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
            throw new InvalidArgumentException(
                "Se esperaba un objeto y un array de tipos de campo."
            );
        }

        foreach ($object as $key => $value) {
            // Verifica que el campo exista en el array de tipos de campo
            if (!array_key_exists($key, $fieldTypes)) {
                throw new InvalidArgumentException(
                    "El campo $key no está definido en el array de tipos de campo."
                );
            }

            // Verifica que el valor del campo coincida con el tipo de campo definido
            if (gettype($value) !== $fieldTypes[$key]) {
                throw new InvalidArgumentException(
                    "El campo $key debe ser de tipo " . $fieldTypes[$key]
                );
            }
        }

        // Si todos los campos son válidos, devuelve verdadero
        return true;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query)
    {
        $resultado = self::getResults($query);

        /* Iterar los resultados */
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        /*  liberar la memoria */
        $resultado->free();

        /* retornar los resultados */
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro)
    {
        $objeto = new static();

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
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
                $this->$key = $value;
            }
        }
    }

    // Todos los registros
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query, "");
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

    // Busca un registro por su id
    public static function where($column, $value, $operator = "")
    {
        $query = "";
        if (isset($operator) && $operator != "") {
            $query =
                "SELECT * FROM " .
                static::$tabla .
                " WHERE " .
                $column .
                " " .
                $operator .
                "'" .
                $value .
                "'";
        } else {
            $query =
                "SELECT * FROM " .
                static::$tabla .
                " WHERE ${column} = '${value}'";
        }

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Consulta Plana de SQL (Utilizar cuando los métodos del modelo no son suficientes)
    public static function SQL($query)
    {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /* consulta con multiples tablas */
    public static function select(
        $tables,
        $joins,
        $fields,
        $join_type = "INNER JOIN"
    ) {
        $query = "SELECT " . implode(", ", $fields) . " FROM " . $tables[0];

        foreach ($joins as $key => $join) {
            $query .=
                " " . $join_type . " " . $tables[$key + 1] . " ON " . $join;
        }

        $resultado = self::consultarSQL($query);
        return $resultado;

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // crea un nuevo registro
    public function crear()
    {
        $interfaz = "";

        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos($_POST);

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        // print_r("<br>" . $query . "</br>");

        /*   Resultado de la consulta */
        if (isset($this->interfaz) && $this->interfaz == "config") {
            $resultado = self::$db_conf->query($query);
            return [
                "resultado" => $resultado,
                "id" => self::$db_conf->insert_id,
            ];
        } else {
            $resultado = self::$db->query($query);
            return [
                "resultado" => $resultado,
                "id" => self::$db->insert_id,
            ];
        }
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

        // Actualizar BD
        if ($this->interfaz == "config") {
            $resultado = self::$db_conf->query($query);
            return $resultado;
        } else {
            $resultado = self::$db->query($query);
            return $resultado;
        }
    }

    // Eliminar un Registro por su ID
    public function eliminar()
    {
        $query =
            "DELETE FROM " .
            static::$tabla .
            " WHERE id = " .
            self::$db->escape_string($this->id) .
            " LIMIT 1";
        if ($this->interfaz == "config") {
            $resultado = self::$db_conf->query($query);
            return $resultado;
        } else {
            $resultado = self::$db->query($query);
            return $resultado;
        }
    }

    // Registros - CRUD
    public function guardar()
    {
        $resultado = "";

        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // debuguear($this->id);
            // exit();
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }
}

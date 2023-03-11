<?php
/**
 * @format
 */

namespace Model;
class ActiveRecord
{
    // Base DE DATOS
    protected static $db;
    protected static $db_conf;
    protected static $tabla = "";
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
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

    // Validación
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query, $interfaz)
    {
        // Consultar la base de datos
        if (isset($interfaz) && $interfaz == "config") {
            $resultado = self::$db_conf->query($query);
        } else {
            $resultado = self::$db->query($query);
        }

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
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

    public static function get($prm = [])
    {
        $interfaz = "";
        $query =
            "SELECT * FROM " .
            static::$tabla .
            " WHERE " .
            $prm["colum"] .
            " = " .
            $prm["data"];

        $resultado = self::consultarSQL($query, $interfaz);
        return array_shift($resultado);
    }

    // Busca un registro por su id
    public static function where($columna, $valor, $interfaz)
    {
        $query =
            "SELECT * FROM " .
            static::$tabla .
            " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query, $interfaz);
        return array_shift($resultado);
    }

    // Consulta Plana de SQL (Utilizar cuando los métodos del modelo no son suficientes)
    public static function SQL($query)
    {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        print_r("<br>" . $this->interfaz . "</br>");
        //Resultado de la consulta
        if ($this->interfaz == "config") {
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
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }
}

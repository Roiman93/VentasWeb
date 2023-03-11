<?php
/**
 * @format
 */

namespace Model;

/* cliente */
class Model_customer extends ActiveRecord
{
    // Base de datos
    protected static $tabla = "cliente";
    protected static $columnasDB = [
        "id_cliente",
        "cedula",
        "nombre_1",
        "nombre_2",
        "apellido_1",
        "apellido_2",
        "fecha",
    ];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id_cliente = $args["id_cliente"] ?? null;
        $this->cedula = $args["cedula"] ?? null;
        $this->nombre_1 = $args["nombre_1"] ?? "";
        $this->nombre_2 = $args["nombre_2"] ?? "";
        $this->apellido_1 = $args["apellido_1"] ?? "";
        $this->apellido_2 = $args["apellido_2"] ?? "";
        $this->fecha = $args["fecha"] ?? "";
    }

    public function validar()
    {
        if (!$this->cedula) {
            self::$alertas["error"][] =
                "El numero de documento  es Obligatorio";
        }
        if (!$this->nombre_1) {
            self::$alertas["error"][] = "El Nombre  es Obligatorio";
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
        if (!$this->apellido_1) {
            self::$alertas["error"][] = "El apellido  es Obligatorio";
        }
        if (!$this->fecha) {
            self::$alertas["error"][] = "la fecha es Obligatoria";
        }

        return self::$alertas;
    }
}

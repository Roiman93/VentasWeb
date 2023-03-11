<?php
/**
 * @format
 */

namespace Model;
/* facturacion */
class Model_billing extends ActiveRecord
{
    // Base de datos
    protected static $tabla = "cliente";
    protected static $columnasDB = [
        "nofactura",
        "prefijo",
        "numero",
        "codcliene",
        "fecha",
        " usuario",
        "totalfactura",
        "estatus",
    ];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->precio = $args["precio"] ?? "";
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas["error"][] = "El Nombre del Servicio es Obligatorio";
        }
        if (!$this->precio) {
            self::$alertas["error"][] = "El Precio del Servicio es Obligatorio";
        }
        if (!is_numeric($this->precio)) {
            self::$alertas["error"][] = "El precio no es válido";
        }

        return self::$alertas;
    }
}

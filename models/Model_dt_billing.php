<?php
/**
 * @format
 */

namespace Model;
/* facturacion */
class Model_dt_billing extends ActiveRecord
{
    // Base de datos
    protected static $tabla = "dt_fact";
    protected static $columnasDB = [
        "id",
        "id_fact",
        "id_producto",
        "cantidad",
        "precio_venta",
        "estatus"
    ];

    public $id;
    public $id_fact;
    public $id_producto;
    public $cantidad;
    public $precio_venta;
    public $estatus;

    public function __construct($args = [])
    {
        $this->id           = $args["id"] ?? null;
        $this->id_fact      = $args["id_fact"] ?? "";
        $this->id_producto  = $args["id_producto"] ?? "";
        $this->cantidad     = $args["cantidad"] ?? "";
        $this->precio_venta = $args["precio_venta"] ?? "";
        $this->estatus      = $args["estatus"] ?? "";
      
    }

    public function validar()
    {
        if (!$this->id_fact) {
            self::$alertas["error"][] = "El prefijo es Obligatorio ";
        }
        if (!$this->id_producto) {
            self::$alertas["error"][] = "El Precio del Servicio es Obligatorio";
        }
        if (!is_numeric($this->cantidad)) {
            self::$alertas["error"][] = "El precio no es válido";
        }

        return self::$alertas;
    }
}
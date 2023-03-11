<?php
/**
 * @format
 */

namespace Model;

/* producto */
class Model_product extends ActiveRecord
{
    // Base de datos
    protected static $tabla = "producto";
    protected static $columnasDB = [
        "id_producto",
        "nombre",
        "codigo",
        "tipo",
        "precio_compra",
        "precio_venta",
        "fecha",
    ];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id_producto = $args["id_producto"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->codigo = $args["codigo"] ?? "";
        $this->tipo = $args["tipo"] ?? "";
        $this->precio_compra = $args["precio_compra"] ?? "";
        $this->precio_venta = $args["precio_venta"] ?? "";
        $this->fecha = $args["fecha"] ?? "";
    }

    public function validar()
    {
        if (!$this->codigo) {
            self::$alertas["error"][] =
                "El codigo del producto es  Obligatorio";
        }
        if (!$this->nombre) {
            self::$alertas["error"][] = "El Nombre del producto es Obligatorio";
        }
        if (!$this->tipo) {
            self::$alertas["error"][] = "El tipo de producto es Obligatorio";
        }
        if (!$this->precio_compra) {
            self::$alertas["error"][] = "El precio de compra es Obligatorio";
        }
        if (!$this->precio_venta) {
            self::$alertas["error"][] = "El precio de venta es Obligatorio";
        }

        return self::$alertas;
    }
}

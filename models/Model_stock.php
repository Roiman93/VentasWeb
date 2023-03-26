<?php
/**
 * @format
 */

namespace Model;
/* existencia */
class Model_stock extends ActiveRecord
{
    /*  declaracias de variables */
    public $ar_detalle_product = [];
    public $id;
    public $nombre;
    public $precio;

    /* Base de datos */
    protected static $tabla = "inventario";
    protected static $columnasDB = [
        "id_producto",
        "codigo",
        "nombre",
        "precio_venta",
        "entradas",
        "salidas",
        "stock",
    ];

    public function __construct($args = [])
    {
        $this->id_producto = $args["id_producto"] ?? null;
        $this->codigo = $args["codigo"] ?? "";
        $this->nombre = $args["nombre"] ?? null;
        $this->precio_venta = $args["precio_venta"] ?? "";
        $this->entradas = $args["entradas"] ?? "";
        $this->salidas = $args["salidas"] ?? "";
        $this->stock = $args["stock"] ?? "";
    }

    public function producto_detalle($prm = [])
    {
        // debuguear($_POST);

        if (isset($_POST)) {
            $this->ar_detalle_product([
                [
                    "id" => $_POST["id"],
                    "codigo" => $_POST["codigo"],
                    "cantidad" => $_POST["cantidad"],
                    "token" => $_POST["token"],
                ],
            ]);

            // array_push($this->ar_detalle_product["id"] .= $_POST["id"]);
            // $this->ar_detalle_product["codigo"] .= $_POST["codigo"];
            // $this->ar_detalle_product["cantidad"] .= $_POST["cantidad"];
            // $this->ar_detalle_product["token"] .= $_POST["token"];
        }

        return $this->ar_detalle_product;
    }

    public function validar()
    {
        if (!$this->id_producto) {
            self::$alertas["error"][] = "El id del producto es Obligatorio";
        }
        if (!$this->codigo) {
            self::$alertas["error"][] = "El codigo del producto es Obligatorio";
        }
        if (!$this->nombre) {
            self::$alertas["error"][] = "El Nombre del producto es Obligatorio";
        }
        if (!$this->precio_venta) {
            self::$alertas["error"][] = "El precio de venta es Obligatorio";
        }
        if (!$this->entradas) {
            self::$alertas["error"][] = "El valor tiene que ser numerico";
        }
        if (!$this->salidas) {
            self::$alertas["error"][] = "El valor tiene que ser numerico";
        }
        if (!$this->stock) {
            self::$alertas["error"][] = "El valor tiene que ser numerico";
        }

        return self::$alertas;
    }
}

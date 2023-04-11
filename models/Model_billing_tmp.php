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
    protected static $columnasDB = [
        "id",
        "id_producto",
        "cantidad",
        "precio_venta",
        "mesa",
        "token_user",
        "Total"
    ];

    /* atributos */
    public $id;
    public $id_producto;
    public $cantidad;
    public $precio_venta;
    public $mesa;
    public $token_user;
    public $Total;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->id_producto = $args["id_producto"] ?? "";
        $this->cantidad = $args["cantidad"] ?? "";
        $this->precio_venta = $args["precio_venta"] ?? "";
        $this->mesa = $args["mesa"] ?? null;
        $this->token_user = $args["token_user"] ?? "";
        $this->Total = $args["Total"] ?? "";
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

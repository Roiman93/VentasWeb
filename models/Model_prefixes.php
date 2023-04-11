<?php
/**
 * @format
 */

namespace Model;

/* producto */
class Model_prefixes extends ActiveRecord
{
    // Base de datos
    protected static $tabla = "prefixes";
    protected static $columnasDB = [
        "id",
        "prefijo",
        "n_inicio",
        "n_final",
        "n_actual",
        "n_resolucion",
        "fecha_resolucion",
        "estado",
        "tipo_documento"
    ];

    public $id;
    public $prefijo;
    public $n_inicio;
    public $n_final;
    public $n_actual;
    public $n_resolucion;
    public $fecha_resolucion;
    public $estado;
    public $tipo_documento;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->prefijo = $args["prefijo"] ?? null;
        $this->n_inicio = $args["n_inicio"] ?? "";
        $this->n_final = $args["n_final"] ?? "";
        $this->n_resolucion = $args["n_resolucion"] ?? "";
        $this->fecha_resolucion = $args["fecha_resolucion"] ?? "";
        $this->estado = $args["estado"] ?? "";
        $this->tipo_documento = $args["tipo"] ?? "";
    }

    public function validar()
    {
        if (!$this->prefijo) {
            self::$alertas["error"][] =
                "El prefijo es  Obligatorio";
        }
        if (!$this->n_inicio) {
            self::$alertas["error"][] = "El numero inicial es Obligatorio";
        }
        if (!$this->n_final) {
            self::$alertas["error"][] = "El numero final  es Obligatorio";
        }
        if (!$this->n_resolucion) {
            self::$alertas["error"][] = "El numero de resolución es Obligatorio";
        }
        if (!$this->fecha_resolucion) {
            self::$alertas["error"][] = "La fecha de resolución es Obligatoria";
        }
        if (!$this->estado) {
            self::$alertas["error"][] = "Indique el estado";
        }
        if (!$this->fecha_resolucion) {
            self::$alertas["error"][] = "Indique un tipo de resolución";
        }

        return self::$alertas;
    }
}

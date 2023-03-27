<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_product;
use Model\Model_stock;
use Model\Model_billing_tmp;
use Classes\Html;
use Classes\Process;
/* producto */
class APIBillingConroller
{
    /* se consulta un producto  por codigo y su stock */
    public static function billing()
    {
        $token = $_POST["token_user"];
        $model = new Model_billing_tmp($_POST);
        $resultado = $model->guardar();

        /* retorna el id  del insert */
        $id = $resultado["id"];

        if (isset($resultado["id"])) {
            $datos = Model_billing_tmp::all();
            /* filtramos los datos */
            $datos_filt = $model->eliminarObjeto($datos, $token);
            /*  cosnsultamos todos los productos */
            $productos = Model_product::all();
            /* comparamos  los 2 objetos */
            $dt_detalles = $model->innerObjeto($datos_filt, $productos);
        }

        /* calculo del resumen de la factura */
        $detalle_totales = Process::total_billing($dt_detalles);

        /*  Validamos si el objeto está vacío */
        if (empty((array) $dt_detalles)) {
            $tabla = null;
        } else {
            $tabla = Html::crearTabla($dt_detalles, ["delete"]);
        }

        /*  Resultado en formato JSON */
        $result = json_encode([
            "resultado" => $tabla,
            "resumen" => $detalle_totales,
        ]);

        echo $result;
    }
}

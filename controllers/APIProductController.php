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
class APIProductController
{
    public static function index()
    {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        /*  Almacena la Cita y devuelve el ID */
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado["id"];

        // Almacena la Cita y el Servicio

        /*  Almacena los Servicios con el ID de la Cita */
        $idServicios = explode(",", $_POST["servicios"]);
        foreach ($idServicios as $idServicio) {
            $args = [
                "citaId" => $id,
                "servicioId" => $idServicio,
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        echo json_encode(["resultado" => $resultado]);
    }

    /* se consulta un producto  por codigo y su stock */
    public static function get_stock_product()
    {
        $model = new Model_stock($_POST);
        $resultado = $model->where("codigo", $_POST["data"]);

        echo json_encode(["resultado" => $resultado]);
    }

    /* almacena temporalmente los productos del detalle */
    public static function add_detalle_product()
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

    /*    elimina un producto */
    public static function eliminar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $model = Model_product::find($id);
            $model->eliminar();
            header("Location:" . $_SERVER["HTTP_REFERER"]);
        }
    }
}

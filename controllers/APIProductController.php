<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_product;
use Model\Model_stock;

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
        // Almacena la Cita y devuelve el ID
        // $cita = new Cita($_POST);
        // $resultado = $cita->guardar();

        $id = $resultado["id"];

        // Almacena la Cita y el Servicio

        // Almacena los Servicios con el ID de la Cita
        // $idServicios = explode(",", $_POST['servicios']);
        // foreach($idServicios as $idServicio) {
        //     $args = [
        //         'citaId' => $id,
        //         'servicioId' => $idServicio
        //     ];
        //     $citaServicio = new CitaServicio($args);
        //     $citaServicio->guardar();
        // }

        echo json_encode(["resultado" => $resultado]);
    }

    /* se consulta un producto  por codigo y su stock */
    public static function get_stock_product()
    {
        $model = new Model_stock($_POST);
        $resultado = $model->get([
            "colum" => "codigo",
            "data" => $_POST["data"],
        ]);

        echo json_encode(["resultado" => $resultado]);
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

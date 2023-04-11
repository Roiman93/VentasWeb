<?php
/**
 * @format
 */

namespace Controllers;

use Model\Model_billing;
use Model\Model_customer;
use Classes\Process;
header("Access-Control-Allow-Origin: *");
/*  clientes */
class APICustomerController
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

    /* se busca el cliente por cedula */
    public static function get_cliente()
    {
         /* consulta el cliente con el numero de documento */

        /*   Validamos si contiene solo numeros */
        if (isset($_POST["date"]) && is_numeric($_POST["date"])) {
            $value = $_POST["date"];
        } else {
            // $_POST["date"] no contiene solo números
            echo json_encode([
                "error" => "Solo se permiten numeros en el campo cedula.",
            ]);
            exit();
        }

        $resp_c = Model_customer::where([
            "cedula"=>$value
        ]);

        $resultado = Process::validar_ar($resp_c);
        header('Content-Type: application/json');
        echo json_encode(["resultado" => $resultado]);
        exit;

    }

    public static function eliminar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $cita = Cita::find($id);
            $cita->eliminar();
            header("Location:" . $_SERVER["HTTP_REFERER"]);
        }
    }
}

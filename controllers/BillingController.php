<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\AdminCita;
use Model\Model_prefixes;
use MVC\Router;
use Classes\Process;

class BillingController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();

        $fecha = $_GET["fecha"] ?? date("Y-m-d");
        $fechas = explode("-", $fecha);

        $resp_pr = Model_prefixes::where([
            "tipo_documento" => "1",
            "estado" => "2"
        ]);

        $resultado = Process::validar_ar($resp_pr);

        if (!checkdate($fechas[1], $fechas[2], $fechas[0])) {
            header("Location: /404");
        }

        // Consultar la base de datos
        // $consulta =
        //     "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        // $consulta .=
        //     " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        // $consulta .= " FROM citas  ";
        // $consulta .= " LEFT OUTER JOIN usuarios ";
        // $consulta .= " ON citas.usuarioId=usuarios.id  ";
        // $consulta .= " LEFT OUTER JOIN citasServicios ";
        // $consulta .= " ON citasServicios.citaId=citas.id ";
        // $consulta .= " LEFT OUTER JOIN servicios ";
        // $consulta .= " ON servicios.id=citasServicios.servicioId ";
        // $consulta .= " WHERE fecha =  '${fecha}' ";

        // $citas = AdminCita::SQL($consulta);

        $router->render("pages/Billing", [
            "name" => $_SESSION["nombre"],
            "page" => "Ventas",
            "prefj"=> $resultado,
            'script' => '<script type="text/javascript" src="build/js/InvoiceFunctions.js"></script>'
        ]);
    }
}

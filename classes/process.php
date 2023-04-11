<?php
/**
 * @format
 */

namespace Classes;

class Process
{
    /**
     * Función que calcula el total de una factura y su desglose de impuestos.
     *
     * @param array $objeto Array de objetos que contiene la información de los productos de la factura.
     * 
     * @return array Array que contiene el total de la factura y su desglose de impuestos.
     *
     * @throws Exception Si ocurre un error durante el cálculo del total de la factura.
     */
    public static function total_billing($objeto)
    {
        $resultado = [];
        $sub_total = 0;
        $total = 0;
        $total_factura = 0;

        foreach ($objeto as $key => $value) {
            $sub_total = round($value->Total, 2);
            $total = round($total + $sub_total, 2);
        }

        $impuesto = round($total * (19 / 100), 2);
        $tl_sniva = round($total - $impuesto, 2);
        $total_factura = round($tl_sniva + $impuesto, 2);

        /*  total a pagar  */
        $tlt = number_format($total_factura, 2, ".", ".");
        /* subtotal sin iva */
        $tl_s = number_format($tl_sniva, 2, ".", ".");
        /* iva */
        $inpto = number_format($impuesto, 2, ".", ".");

        $resultado["total"] = $tlt;
        $resultado["sub_total"] = $tl_s;
        $resultado["iva"] = $inpto;

        return $resultado;
    }

    /**
     * Valida si los datos recibidos son válidos según su tipo de dato.
     *
     * @param array $datos Un arreglo asociativo con los datos a validar.
     * @return array|bool Si hay errores de validación, devuelve un arreglo asociativo de errores.
     *                     Si no hay errores, devuelve true.
     */
    public static function validar_datos($datos) 
    {
        $errores = array();
    
        foreach ($datos as $clave => $valor) {
        switch ($clave) {
            case "numero":
            if (!preg_match('/^\d+$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es un número válido.";
            }
            break;

            case "moneda":
               
                if (empty($valor)) {
                    $errores[$clave] = "El valor está vacío.";
                } 
                break;
    
            case "token":
            if (!preg_match('/^[a-f0-9]{32}$/i', $valor)) {
                $errores[$clave] = "El token ingresado no es válido.";
            }
            break;
            case "texto":
            if (!preg_match('/^[a-zA-Z0-9]+$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es un texto válido.";
            }
            break;
    
            case "fecha":
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es una fecha válida.";
            }
            break;
    
            case "correo":
            if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                $errores[$clave] = "El valor ingresado no es un correo electrónico válido.";
            }
            break;
    
            case "url":
            if (!filter_var($valor, FILTER_VALIDATE_URL)) {
                $errores[$clave] = "El valor ingresado no es una URL válida.";
            }
            break;
    
            case "cedula":
            if (!preg_match('/^\d{9}$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es un número de cédula válido.";
            }
            break;
    
            case "telefono":
            if (!preg_match('/^\+?\d{7,14}$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es un número de teléfono válido.";
            }
            break;
    
            case "direccion":
            if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).+$/', $valor)) {
                $errores[$clave] = "El valor ingresado no es una dirección válida.";
            }
            break;
        }
    
        if (empty($valor)) {
            $errores[$clave] = "El valor ingresado no puede estar vacío.";
        }
        }
    
        if (count($errores) > 0) {
        return $errores;
        } else {
        return true;
        }
    }

 
    /**
     * Valida varios tipos de datos y si está vacío
     *
     * @param mixed $datos El dato a validar
     * @return mixed El dato validado
     */
    public static function validar_ar($datos = [])
    {
        if (!empty($datos)) {
            if (count($datos) == 1) {
                return $datos[0];
            } else {
                return $datos;
            }
        } else {
            return false;
        }
    }

    

    
    
}
<?php
/**
 * @format
 */

namespace Classes;

class Process
{
    /* se calcula el resumen de la factura  */
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
}
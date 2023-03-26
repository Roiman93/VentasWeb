<?php
/**
 * @format
 */

namespace Classes;

class Html
{
    public static function crearTabla($objeto, $accion = [])
    {
        $tabla = "";
        // Comprobamos si el objeto está vacío
        if (empty($objeto)) {
            return "No hay datos que mostrar";
        }

        $propiedades = get_object_vars($objeto[0]);
        $tabla .= "<table class='ui very compact small table'> ";
        $tabla .= "<thead class='sticky'><tr class=' ui inverted table' >";
        foreach ($propiedades as $propiedad => $valor) {
            $tabla .= "<th>$propiedad</th>";
        }

        // Agregamos las opciones de acciones (borrar y actualizar) si se especificaron en el parámetro $accion
        if (
            in_array("delete", $accion) ||
            in_array("update", $accion) ||
            in_array("status", $accion)
        ) {
            $tabla .= "<th>Acciones</th>";
        }

        $tabla .= "</tr></thead>";

        // Creamos el cuerpo de la tabla
        $tabla .= "<tbody>";
        foreach ($objeto as $fila) {
            $tabla .= "<tr>";
            foreach ($fila as $valor) {
                $tabla .= "<td>$valor</td>";
            }
            // Agregamos los botones de borrar y actualizar si se especificaron en el parámetro $accion
            if (in_array("delete", $accion)) {
                $id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
                $tabla .= "<td><button class='ui button negative icon' data-content='Cerrar 'Eliminar' data-position='top center'  onclick='delete($id, this)'><i class='trash small icon'></i></button></td>";
            }
            if (in_array("update", $accion)) {
                $id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
                $tabla .= "<td><button class='ui button negative icon' data-content='Cerrar 'Actualizar' data-position='top center' onclick='update($id, this)'><i class='edit small icon'></i></button></td>";
            }
            if (in_array("status", $accion)) {
                $id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
                $tabla .= "<td><button class='ui button negative icon' data-content='Cerrar 'Estado' data-position='top center'  onclick='status($id, this)'><i class='toggle on small icon'></i></button></td>";
            }

            $tabla .= "</tr>";
        }

        $tabla .= "</tbody></table>";
        return $tabla;
    }

    public static function crearForm($bjeto)
    {
        $form = "";
        $form .= '<form class="ui form">';
        foreach ($campos as $campo) {
            $form .= '<div class="field">';
            $form .= "<label>" . $campo["label"] . "</label>";
            if ($campo["type"] === "textarea") {
                $form .= '<textarea name="' . $campo["name"] . '"';
            } else {
                $form .=
                    '<input type="' .
                    $campo["type"] .
                    '" name="' .
                    $campo["name"] .
                    '"';
            }
            if (isset($campo["placeholder"])) {
                $form .= ' placeholder="' . $campo["placeholder"] . '"';
            }
            // Agregar cualquier atributo personalizado
            foreach ($campo as $atributo => $valor) {
                if (
                    !in_array($atributo, [
                        "type",
                        "label",
                        "name",
                        "placeholder",
                    ])
                ) {
                    $form .= " " . $atributo . '="' . $valor . '"';
                }
            }
            // Cerrar el elemento input o textarea
            if ($campo["type"] === "textarea") {
                $form .= ">" . $campo["valor"] . "</textarea>";
            } else {
                $form .= ">";
            }
            $form .= "</div>";
        }
        $form .= '<button class="ui button" type="submit">Enviar</button>';
        $form .= "</form>";
    }
}

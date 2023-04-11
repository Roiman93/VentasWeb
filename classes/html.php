<?php
/**
 * @format
 */

namespace Classes;

class Html
{
    /**
     * Crea una tabla HTML a partir de un arreglo de objetos
     * @param array $objeto Arreglo de objetos a mostrar en la tabla
     * @param array $accion Opciones de acciones para agregar en cada fila (opcional)
     *                      Valores posibles: 'delete', 'update', 'status'
     * @return string La tabla HTML generada
     */
    public static function createTabla($objeto, $accion = [])
    {
        $tabla = "";
        // Comprobamos si el objeto está vacío
        if (empty($objeto)) {
            return "No hay datos que mostrar";
        }

        $nombreObjeto = get_class($objeto[0]);
        $idTabla = strtolower($nombreObjeto) . "-table";

        $propiedades = get_object_vars($objeto[0]);
        $tabla .= "<table id='$idTabla' class='ui very compact small table'> ";
        // $tabla .= "<table class='ui very compact small table'> ";
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
            $tabla .= "<th class='right aligned'>Acciones</th>";
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
                $tabla .= "<td class='right aligned'><button class='ui button negative icon' data-content='Eliminar' data-position='top center'  onclick='deleteRecord($id, this)'><i class='trash small icon'></i></button></td>";
            }
            if (in_array("update", $accion)) {
                $id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
                $tabla .= "<td class='right aligned'><button class='ui button negative icon' data-content='Actualizar' data-position='top center' onclick='updateRecord($id, this)'><i class='edit small icon'></i></button></td>";
            }
            if (in_array("status", $accion)) {
                $id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
                $tabla .= "<td class='right aligned'><button class='ui button negative icon' data-content='Estado' data-position='top center'  onclick='status($id, this)'><i class='toggle on small icon'></i></button></td>";
            }

            $tabla .= "</tr>";
        }

        $tabla .= "</tbody></table>";
        return $tabla;
    }
    
    /**
     * Crea un formulario HTML a partir de un objeto y un array de campos.
     *
     * @param array $objeto Un array que contiene el objeto a partir del cual se construirá el formulario.
     * @param array $campos Un array que contiene los campos que se agregarán al formulario.
     * Cada campo es un array que puede contener las siguientes claves:
     * - "type": El tipo de campo, como "text", "password", "email", "textarea", etc.
     * - "name": El nombre del campo.
     * - "label": La etiqueta que se mostrará junto al campo.
     * - "placeholder": El texto de marcador de posición que se mostrará en el campo.
     * - Cualquier otro atributo que se desee agregar al campo HTML, como "required", "readonly", "minlength", etc.
     * @return string El formulario HTML resultante.
     */
    public static function createForm($bjeto)
    {
       
        $nombreObjeto = get_class($objeto[0]);
        $id = strtolower($nombreObjeto) . "-frm";
        $form = "";
        $form .= "<form id='$id' class='ui form'>";
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
                        "data-type"
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

   
    public static function creatForm($formInfo) {
        $formHtml ='';
        $id = $formInfo['id'] ?? 'default-form-id';
        $formClass = $formInfo['class'] ?? '';
        $fields = $formInfo['fields'] ?? [];
        $header = $formInfo['header'] ?? '';
    
        $formHtml .= '<div class="ui secondary segment">';
        $formHtml .= '<form id="' . $id . '" class="ui form ' . $formClass . '">';
        $formHtml .= '<h4 class="ui dividing header"><i class="address card icon"></i>'.$header.'</h4>';
        $formHtml .= '<div class="equal width  fields">';
    
        foreach ($fields as $field) {
            $type = $field['type'] ?? 'text';
            $name = $field['name'] ?? '';
            $label = $field['label'] ?? '';
            $placeholder = $field['placeholder'] ?? '';
            $options = $field['options'] ?? [];
            $data_type = $field['data_type'] ?? '';
            $value = $field['value'] ?? '';
    
            $formHtml .= '<div class="field">';
            $formHtml .= '<label>' . $label . '</label>';
    
            if ($type === 'textarea') {
                $formHtml .= '<textarea name="' . $name . '" placeholder="' . $placeholder . '">' . $value . '</textarea>';
            } elseif ($type === 'select') {
                $formHtml .= '<select name="' . $name . '">';
    
                foreach ($options as $optionValue => $optionLabel) {
                    $isSelected = $optionValue == $value ? 'selected' : '';
                    $formHtml .= '<option value="' . $optionValue . '" ' . $isSelected . '>' . $optionLabel . '</option>';
                }
    
                $formHtml .= '</select>';
            } else {
                $formHtml .= '<input type="' . $type . '" name="' . $name . '" placeholder="' . $placeholder . '" data-type="' . $data_type . '" value="' . $value . '">';
            }
    
            $formHtml .= '</div>';
        }
    
        $formHtml .= '</div>';
        $formHtml .= '<button class="ui button" type="submit">Enviar</button>';
        $formHtml .= '</form>';
        $formHtml .= '</div>';
    
        return $formHtml;
    }
    

   


}

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
			if ($propiedad != "status" && $propiedad != "id") {
				$tabla .= "<th>$propiedad</th>";
			}
		}

		// Agregamos las opciones de acciones (borrar y actualizar) si se especificaron en el parámetro $accion
		if (in_array("delete", $accion) || in_array("update", $accion) || in_array("status", $accion)) {
			$tabla .= "<th  class='center aligned'>Acciones</th>";
		}

		$tabla .= "</tr></thead>";

		// Creamos el cuerpo de la tabla
		$tabla .= "<tbody>";
		foreach ($objeto as $fila) {
			$tabla .= "<tr>";

			foreach ($fila as $key => $valor) {
				if ($key != "status" && $key != "id") {
					$tabla .= "<td>$valor</td>";
				}
			}

			/* Agregamos los botones de borrar y actualizar si se especificaron en el parámetro $accion */
			if (in_array("update", $accion)) {
				$id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
				$updateButton = "<button class='ui icon button' data-content='Actualizar' data-position='top center' onclick='updateRecord($id, this)'>
									<i class='edit blue icon'></i>
								</button>";
			} else {
				$updateButton = "";
			}

			if (in_array("status", $accion)) {
				$id = $fila->id;
				if (isset($fila->status) && $fila->status == 1) {
					$statusButton = "<button class='ui button' data-content='Activo' data-position='top center' onclick='status($id, this)'>
										<i class='toggle on olive icon'></i>
									</button>";
				} else {
					if (in_array("disabled_status", $accion)) {
						$statusButton = "<button class='ui button' data-content='Desactivado' data-position='top center'>
											<i class='toggle off  icon'></i>
										</button>";
					} else {
						$statusButton = "<button class='ui button' data-content='Desactivado' data-position='top center' onclick='status($id, this)'>
										<i class='toggle off  icon'></i>
									</button>";
					}
				}
			} else {
				$statusButton = "";
			}

			if (in_array("delete", $accion)) {
				$id = $fila->id; // Suponiendo que el ID de la fila se llama 'id'
				$deleteButton = "<button class='ui button' data-content='Eliminar' data-position='top center' onclick='deleteRecord($id, this)'>
									<i class='trash red icon'></i>
								</button>";
			} else {
				$deleteButton = "";
			}

			$tabla .= "<td class='right aligned'><div class='ui small basic icon buttons'>
             $updateButton
             $statusButton
             $deleteButton
			 </div> </td>";

			$tabla .= "</tr>";
		}

		$tabla .= "</tbody></table>";
		return $tabla;
	}

	/**
	 * Crea un formulario HTML a partir de un array de información.
	 *
	 * @param array $formInfo Información del formulario.
	 *    $formInfo = [
	 *        'id' => '', // ID del formulario.
	 *        'class' => '', // Clase del formulario.
	 *        'header' => '', // Encabezado del formulario.
	 *        'fields' => [
	 *            [
	 *                'type' => 'text', // Tipo de campo (text, select, etc.).
	 *                'id' => '', // ID del campo.
	 *                'name' => '', // Nombre del campo.
	 *                'label' => '', // Etiqueta del campo.
	 *                'placeholder' => '', // Texto de marcador de posición.
	 *                'data_type' => '', // Tipo de datos del campo.
	 *                'required' => false, // Indica si el campo es obligatorio.
	 *                'value' => '' // Valor del campo.
	 *            ],
	 *            [
	 *                'type' => 'select', // Tipo de campo (text, select, etc.).
	 *                'name' => '', // Nombre del campo.
	 *                'label' => '', // Etiqueta del campo.
	 *                'options' => [
	 *                    '' => '', // Valor de opción => Etiqueta de opción.
	 *                ],
	 *                'value' => '' // Valor del campo.
	 *            ],
	 *            // Pueden haber más campos.
	 *        ]
	 *    ]
	 *
	 * @return string HTML generado del formulario.
	 */
	public static function createForm_inline(array $formInfo)
	{
		$formHtml = "";
		$formHtml = '<div class="ui secondary segment">';
		$formHtml .= '<div class="ui form">';

		// Encabezado del formulario
		if (isset($formInfo["header"])) {
			$formHtml .= '<h4 class="ui dividing header">' . $formInfo["header"] . "</h4>";
		}

		$formHtml .= '<div class="equal width fields">';

		// Campos del formulario
		if (isset($formInfo["fields"])) {
			foreach ($formInfo["fields"] as $field) {
				switch ($field["type"]) {
					case "text":
						$formHtml .= '<div class="field">';
						$formHtml .= "<label>" . $field["label"] . "</label>";
						$formHtml .= '<input type="' . $field["type"] . '" id="' . $field["id"] . '" name="' . $field["name"] . '"';

						if (isset($field["placeholder"])) {
							$formHtml .= ' placeholder="' . $field["placeholder"] . '"';
						}

						if (isset($field["required"]) && $field["required"] === true) {
							$formHtml .= " required";
						}

						if (isset($field["onkeypress"])) {
							$formHtml .= ' onkeypress="' . $field["onkeypress"] . '"';
						}

						$formHtml .= ">";
						$formHtml .= "</div>";
						break;

					case "select":
						$formHtml .= '<div class="field">';
						$formHtml .= "<label>" . $field["label"] . "</label>";
						$formHtml .= '<select name="' . $field["name"] . '" id="' . $field["name"] . '">';

						foreach ($field["options"] as $optionValue => $optionLabel) {
							$isSelected = "";
							$isDisabled = "";

							if (isset($field["value"]) && $field["value"] == $optionValue) {
								$isSelected = "selected";
							}

							if (isset($optionLabel["disabled"]) && $optionLabel["disabled"] === true) {
								$isDisabled = "disabled";
							}

							$formHtml .=
								'<option value="' .
								$optionValue .
								'" ' .
								$isSelected .
								" " .
								($isDisabled ? "disabled" : "") .
								">" .
								($optionLabel ? (is_array($optionLabel) ? $optionLabel["label"] : $optionLabel) : "") .
								"</option>";
						}

						$formHtml .= "</select>";
						$formHtml .= "</div>";
						break;
				}
			}
		}

		$formHtml .= "</div>";

		// Botones del formulario
		if (isset($formInfo["buttons"])) {
			$formHtml .= '<div class="ui buttons">';

			foreach ($formInfo["buttons"] as $key => $button) {
				$formHtml .=
					'<button style="cursor: pointer;" data-content="' .
					(isset($button["data-conten"]) ? $button["data-conten"] : "") .
					'"  name="' .
					(isset($button["name"]) ? $button["name"] : "") .
					'" id="' .
					(isset($button["id"]) ? $button["id"] : "") .
					'" data-content="' .
					(isset($button["data-conten"]) ? $button["data-conten"] : "") .
					'"  data-position="' .
					(isset($button["data-position"]) ? $button["data-position"] : "top center") .
					'" class="' .
					(isset($button["class"]) ? $button["class"] : "") .
					'" href="' .
					(isset($button["href"]) ? $button["href"] : "") .
					'">' .
					(isset($button["icon"]) ? '<i class="' . $button["icon"] . '"></i>' : "") .
					"" .
					(isset($button["label"]) ? $button["label"] : "") .
					"</button>";
			}

			$formHtml .= "</div>";
		}

		$formHtml .= "</div>";
		$formHtml .= "</div>";

		return $formHtml;
	}

	/**
	 * Función que genera un formulario de filtros en línea con campos de texto y selects.
	 * @param array $filterFields Array que contiene los campos del formulario de filtros. Cada campo es un array que contiene los siguientes elementos:
	 * 'type': (string) Tipo del campo. Puede ser 'text' o 'select'.
	 * 'label': (string) Texto que se mostrará como etiqueta del campo.
	 * 'name': (string) Nombre del campo. Se usará como identificador del campo en el formulario.
	 * 'id': (string) Identificador único del campo. Si no se especifica, se usará el valor de 'name' como identificador.
	 * 'placeholder': (string) Texto de ejemplo que se mostrará en el campo.
	 * 'required': (bool) Indica si el campo es obligatorio o no. Si no se especifica, el campo no es obligatorio.
	 * 'onkeypress': (string) Evento que se activará cuando se presione una tecla en el campo.
	 * 'options': (array) Array que contiene las opciones que se mostrarán en el select. Cada opción es un array que contiene los siguientes elementos:
	 * 'label': (string) Texto que se mostrará como etiqueta de la opción.
	 * 'disabled': (bool) Indica si la opción está deshabilitada o no. Si no se especifica, la opción no está deshabilitada.
	 * 'value': (string) Valor por defecto del campo. Si no se especifica, el campo no tendrá valor por defecto.
	 * 'buttons': (array) Array que contiene los botones que se mostrarán debajo del campo. Cada botón es un array que contiene los siguientes elementos:
	 * 'class': (string) Clase que se aplicará al botón.
	 * 'href': (string) URL a la que llevará el botón cuando se haga clic en él.
	 * 'icon': (string) Clase del icono que se mostrará en el botón.
	 * 'label': (string) Texto que se mostrará como etiqueta del botón.
	 * @return string Código HTML que contiene el formulario de filtros generado.
	 */
	public static function generateFilters_inline($filterFields)
	{
		$btn = [];

		$output = '<div class="ui secondary segment">';
		$output .= '<div id="' . (isset($filterFields["id"]) ? $filterFields["id"] : "") . '" class="' . (isset($filterFields["class"]) ? $filterFields["class"] : "") . '">';
		$output .= '<h4 class="ui dividing header">' . (isset($filterFields["header"]) ? $filterFields["header"] : "") . "</h4>";
		// $output .= '<input type="hidden" id="idcliente" placeholder="id">';
		$output .= '<div class="equal width fields">';

		if (isset($filterFields["fields"])) {
			foreach ($filterFields["fields"] as $field) {
				if (is_array($field) && isset($field["buttons"])) {
					foreach ($field["buttons"] as $button) {
						$btn[] = $button;
					}
				} else {
					switch ($field["type"]) {
						case "text":
							$output .= '<div class= " ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$output .= "<label>" . $field["label"] . "</label>";
							$output .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" placeholder="' .
								(isset($field["placeholder"]) ? $field["placeholder"] : "") .
								'"';

							if (isset($field["required"]) && $field["required"] === true) {
								$output .= " required= true";
							}

							if (isset($field["onkeypress"])) {
								$output .= ' onkeypress="' . $field["onkeypress"] . '"';
							}

							$output .= ">";
							$output .= "</div>";
							break;

						case "date":
							$output .= '<div class= " ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$output .= "<label>" . $field["label"] . "</label>";
							$output .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" placeholder="' .
								(isset($field["placeholder"]) ? $field["placeholder"] : "") .
								'"';

							if (isset($field["required"]) && $field["required"] === true) {
								$output .= " required= true";
							}

							if (isset($field["onkeypress"])) {
								$output .= ' onkeypress="' . $field["onkeypress"] . '"';
							}

							$output .= ">";
							$output .= "</div>";
							break;

						case "select":
							$output .= '<div class="' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$output .= "<label>" . $field["label"] . "</label>";
							$output .=
								'<select name="' . $field["name"] . '" id="' . $field["name"] . '"   data-type="' . (isset($field["data-type"]) ? $field["data-type"] : "") . '">';

							foreach ($field["options"] as $optionValue => $optionLabel) {
								$isSelected = "";
								$isDisabled = "";

								if (isset($field["value"]) && $field["value"] == $optionValue) {
									$isSelected = "selected";
								}

								if (isset($optionLabel["disabled"]) && $optionLabel["disabled"] === true) {
									$isDisabled = "disabled";
								}

								$output .=
									'<option value="' .
									$optionValue .
									'" ' .
									$isSelected .
									" " .
									($isDisabled ? "disabled" : "") .
									">" .
									($optionLabel ? (is_array($optionLabel) ? $optionLabel["label"] : $optionLabel) : "") .
									"</option>";
							}

							$output .= "</select>";
							$output .= "</div>";
							break;
					}
				}
			}
		}

		$output .= "</div>";

		/*  Botones */
		$output .= '<div class="ui small stackable buttons">';

		foreach ($btn as $key => $button) {
			$output .=
				'<button  data-content="' .
				(isset($button["data-conten"]) ? $button["data-conten"] : "") .
				'"  name="' .
				(isset($button["name"]) ? $button["name"] : "") .
				'" id="' .
				(isset($button["id"]) ? $button["id"] : "") .
				'" data-content="' .
				(isset($button["data-conten"]) ? $button["data-conten"] : "") .
				'"  data-position="' .
				(isset($button["data-position"]) ? $button["data-position"] : "top center") .
				'" class="' .
				(isset($button["class"]) ? $button["class"] : "") .
				'" href="' .
				(isset($button["href"]) ? $button["href"] : "") .
				'">' .
				(isset($button["icon"]) ? '<i class="' . $button["icon"] . '"></i>' : "") .
				"" .
				(isset($button["label"]) ? $button["label"] : "") .
				"</button>";
		}

		$output .= "</div>";

		$output .= "</div></div>";
		return $output;
	}

	/**
	 * Crea un modal con un formulario HTML dinámico y botones personalizados.
	 *
	 * @param array $form Un arreglo que contiene la información del formulario y los botones.
	 *                    El arreglo debe tener las siguientes claves (opcional a menos que se indique lo contrario):
	 *                    - "id": ID del modal.
	 *                    - "class": Clase CSS del modal.
	 *                    - "header": Título del formulario (como una cabecera).
	 *                    - "fields": Un arreglo de campos de formulario con la siguiente estructura:
	 *                      - "type": Tipo del campo de formulario (actualmente solo admite "text" y "select").
	 *                      - "name": Nombre del campo de formulario.
	 *                      - "label": Etiqueta del campo de formulario.
	 *                      - "value": Valor del campo de formulario (para campos "select" solamente).
	 *                      - "data-type": Tipo de datos asociado con el campo de formulario (opcional).
	 *                      - "id": ID del campo de formulario (opcional).
	 *                      - "placeholder": Texto de marcador de posición del campo de formulario (opcional).
	 *                      - "required": Booleano que indica si el campo de formulario es obligatorio o no (opcional).
	 *                      - "onkeypress": JavaScript que se ejecuta cuando se presiona una tecla en el campo de formulario (opcional).
	 *                      - "options": Arreglo de opciones para el campo de formulario "select". Cada elemento del arreglo debe tener la siguiente estructura:
	 *                        - "label": Etiqueta de la opción.
	 *                        - "disabled": Booleano que indica si la opción está desactivada o no (opcional).
	 *                        - Opcionalmente, en lugar de un arreglo con una clave "label", se puede proporcionar directamente el texto de la etiqueta.
	 *                      - "buttons": Un arreglo de botones personalizados con la siguiente estructura:
	 *                        - "label": Etiqueta del botón.
	 *                        - "class": Clase CSS del botón (opcional).
	 *                        - "icon": Clase CSS de un ícono para el botón (opcional).
	 *                        - "data-content": Contenido de información adicional para el botón (opcional).
	 *                        - "data-position": Posición del contenido de información adicional (opcional, por defecto "top center").
	 *                        - "onclick": JavaScript que se ejecuta cuando se hace clic en el botón (opcional).
	 *                        - "href": URL a la que se dirige el botón (opcional).
	 *
	 * @return string Una cadena de texto que representa el formulario HTML con el modal y los botones personalizados.
	 */
	public static function createModal($form)
	{
		$btn = [];
		$formHtml = "";
		$formHtml .= '<div id="' . (isset($form["id"]) ? $form["id"] : "") . '" class="' . (isset($form["class"]) ? $form["class"] : "ui modal") . '">';
		$formHtml .= '<h4 class="ui dividing header">' . (isset($form["header"]) ? $form["header"] : "") . "</h4>";
		$formHtml .= '<div class=" scrolling  content">';
		$formHtml .= '<div class="ui form">';

		$fieldCounter = 0;
		$formHtml .= '<div class="equal width fields">';
		if (isset($form["fields"])) {
			foreach ($form["fields"] as $field) {
				$fieldCounter++;

				if ($fieldCounter % 4 == 0) {
					$formHtml .= '</div><div class="equal width fields">';
				}

				if (is_array($field) && isset($field["buttons"])) {
					foreach ($field["buttons"] as $button) {
						$btn[] = $button;
					}
				} else {
					switch ($field["type"]) {
						case "text":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" placeholder="' .
								(isset($field["placeholder"]) ? $field["placeholder"] : "") .
								'" onkeypress= "' .
								(isset($field["onkeypress"]) ? $field["onkeypress"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							$formHtml .= "</div>";
							break;

						case "textarea":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<textarea type="' .
								(isset($field["type"]) ? $field["type"] : "") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" maxlength="' .
								(isset($field["maxlength"]) ? $field["maxlength"] : "") .
								'" rows= "' .
								(isset($field["rows"]) ? $field["rows"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								"></textarea>";

							$formHtml .= "</div>";
							break;

						case "hidden":
							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "date") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" value="' .
								(isset($field["value"]) ? $field["value"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							break;

						case "number":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';

							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "date") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" value="' .
								(isset($field["value"]) ? $field["value"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							$formHtml .= "</div>";
							break;

						case "date":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';

							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "date") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" value="' .
								(isset($field["value"]) ? $field["value"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							$formHtml .= "</div>";
							break;

						case "time":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';

							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "time") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'"   data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" value="' .
								(isset($field["value"]) ? $field["value"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							$formHtml .= "</div>";
							break;

						case "range":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';

							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";

							$formHtml .= '<div  class="' . (isset($field["class"]) ? $field["class"] : "ui range") . '">';

							$formHtml .=
								'<input type="' .
								(isset($field["type"]) ? $field["type"] : "range") .
								'" data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'" min="' .
								(isset($field["min"]) ? $field["min"] : "0") .
								'" max="' .
								(isset($field["max"]) ? $field["max"] : "100") .
								'" step"' .
								(isset($field["step"]) ? $field["step"] : "1") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							$formHtml .= "</div>";
							$formHtml .= "</div>";
							break;

						case "checkbox":
							$formHtml .= '<div class="' . (isset($field["required"]) && $field["required"] === true ? "required " : "") . ' field">';
							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<div  data-type= "' .
								(isset($field["data-type"]) ? $field["data-type"] : "checkbox") .
								' class="' .
								(isset($field["class"]) ? $field["class"] : "ui checkbox") .
								'">';
							foreach ($field["options"] as $optionValue => $optionLabel) {
								$isSelected = "";
								$isDisabled = "";
								if (isset($field["value"]) && is_array($field["value"]) && in_array($optionValue, $field["value"])) {
									$isSelected = 'checked="checked"';
								}
								if (isset($optionLabel["disabled"]) && $optionLabel["disabled"] === true) {
									$isDisabled = "disabled";
								}
								$optionLabel = isset($optionLabel["label"]) ? $optionLabel["label"] : $optionLabel;
								$formHtml .= '<div class="field">';
								$formHtml .= '<div class="ui checkbox">';

								$formHtml .=
									'<input type="radio" name="' .
									(isset($field["id"]) ? $field["id"] : "") .
									'" data-type="' .
									(isset($field["data-type"]) ? $field["data-type"] : "radio") .
									'" value="' .
									$optionValue .
									'" id="' .
									$optionValue .
									'" ' .
									(isset($field["required"]) && $field["required"] === true ? "required" : "") .
									$isSelected .
									$isDisabled .
									">";

								$formHtml .= '<label for="' . $optionValue . '">' . $optionLabel . "</label>";
								$formHtml .= "</div>";
								$formHtml .= "</div>";
							}
							$formHtml .= "</div>";
							$formHtml .= "</div>";
							break;

						case "select":
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' field">';
							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .=
								'<select name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'" data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" type="' .
								(isset($field["type"]) ? $field["type"] : "") .
								'" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";

							foreach ($field["options"] as $optionValue => $optionLabel) {
								$isSelected = "";
								$isDisabled = "";

								if (isset($field["value"]) && $field["value"] == $optionValue) {
									$isSelected = "selected";
								}

								if (isset($optionLabel["disabled"]) && $optionLabel["disabled"] === true) {
									$isDisabled = "disabled";
								}

								$formHtml .=
									'<option value="' .
									$optionValue .
									'" ' .
									$isSelected .
									" " .
									($isDisabled ? "disabled" : "") .
									">" .
									($optionLabel ? (is_array($optionLabel) ? $optionLabel["label"] : $optionLabel) : "") .
									"</option>";
							}

							$formHtml .= "</select>";
							$formHtml .= "</div>";
							break;

						case "select_seach":
							$formHtml .= '<div class="field">';
							$formHtml .= "<label>" . (isset($field["label"]) ? $field["label"] : "") . "</label>";
							$formHtml .= '<div class=" ' . (isset($field["required"]) && $field["required"] === true ? "required" : "") . ' ui fluid search selection dropdown">';

							$formHtml .=
								'<input  name="' .
								(isset($field["name"]) ? $field["name"] : "") .
								'" data-type="' .
								(isset($field["data-type"]) ? $field["data-type"] : "") .
								'" type= "hidden" id="' .
								(isset($field["id"]) ? $field["id"] : "") .
								'" ' .
								(isset($field["required"]) && $field["required"] === true ? "required='true'" : "") .
								">";
							$formHtml .= "<i class='dropdown icon'></i>";
							$formHtml .= "<div class='menu'>";

							foreach ($field["options"] as $optionValue => $optionLabel) {
								$isSelected = "";
								$isDisabled = "";

								if (isset($field["value"]) && $field["value"] == $optionValue) {
									$isSelected = "selected";
								}

								if (isset($optionLabel["disabled"]) && $optionLabel["disabled"] === true) {
									$isDisabled = "disabled";
								}

								$formHtml .=
									'<div class="item" data-value="' .
									$optionValue .
									'" ' .
									$isSelected .
									" " .
									($isDisabled ? "disabled" : "") .
									">" .
									($optionLabel ? (is_array($optionLabel) ? $optionLabel["label"] : $optionLabel) : "") .
									"</div>";
							}

							$formHtml .= "</div>";
							$formHtml .= "</div>";
							$formHtml .= "</div>";
							break;
					}
				}
			}
		}

		$formHtml .= "</div>";
		$formHtml .= "</div>";

		$formHtml .= "</div>";

		/*   Botones del modal */
		$formHtml .= '<div class="ui">';

		foreach ($btn as $key => $button) {
			$formHtml .=
				'<button style="" data-content="' .
				(isset($button["data-content"]) ? $button["data-content"] : "") .
				'"  name="' .
				(isset($button["name"]) ? $button["name"] : "") .
				'" id="' .
				(isset($button["id"]) ? $button["id"] : "") .
				'"  data-position="' .
				(isset($button["data-position"]) ? $button["data-position"] : "top center") .
				'"      class="' .
				(isset($button["class"]) ? $button["class"] : "") .
				'"  onclick="' .
				(isset($button["onclick"]) ? $button["onclick"] : "") .
				'"  href="' .
				(isset($button["href"]) ? $button["href"] : "") .
				'">' .
				(isset($button["icon"]) ? '<i class="' . $button["icon"] . '"></i>' : "") .
				"" .
				(isset($button["label"]) ? $button["label"] : "") .
				"</button>";
		}

		$formHtml .= "</div>";
		$formHtml .= "</div>";

		return $formHtml;
	}
}

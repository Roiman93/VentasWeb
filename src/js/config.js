/** @format */
/* Esta funciòn recorre un formulario y valida los datos */
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll("input, select, textarea");

    const validationMessages = {
        text: "Debe ingresar un valor de texto válido.",
        email: "Debe ingresar un correo electrónico válido.",
        number: "Debe ingresar un número válido.",
        integer: "Debe ingresar un número entero válido.",
        decimal: "Debe ingresar un número decimal válido.",
        url: "Debe ingresar una URL válida.",
        date: "Debe ingresar una fecha válida.",
        time: "Debe ingresar una hora válida.",
        month: "Debe ingresar un mes válido.",
        week: "Debe ingresar una semana válida.",
        checkbox: "Debe seleccionar esta casilla.",
        radio: "Debe seleccionar una opción.",
        dropdown: "Debe seleccionar una opción.",
    };

    let isValid = true;

    inputs.forEach((input) => {
        const type = input.type;
        const value = input.value;

        if (type === "submit") {
            return;
        }

        let isValidInput = true;

        switch (type) {
            case "text":
            case "password":
            case "textarea":
                isValidInput = /^[A-Za-záéíóúñüÁÉÍÓÚÑÜ\s]+$/.test(value);
                break;
            case "email":
                isValidInput = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                break;
            case "number":
                isValidInput = !isNaN(parseFloat(value));
                break;
            case "integer":
                isValidInput = /^\d+$/.test(value);
                break;
            case "decimal":
                isValidInput = /^[-+]?\d*\.?\d+$/.test(value);
                break;
            case "url":
                isValidInput = /^(ftp|http|https):\/\/[^ "]+$/.test(value);
                break;
            case "date":
                isValidInput = !isNaN(Date.parse(value));
                break;
            case "time":
                isValidInput = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(value);
                break;
            case "month":
                isValidInput = /^([0-9]{4})-([0-9]{2})$/.test(value);
                break;
            case "week":
                isValidInput = /^([0-9]{4})-W([0-9]{2})$/.test(value);
                break;
            case "checkbox":
                isValidInput = input.checked;
                break;
            case "radio":
                const radioName = input.name;
                const radioButtons = form.querySelectorAll(
                    `input[name='${radioName}']`
                );
                isValidInput = Array.from(radioButtons).some(
                    (radioButton) => radioButton.checked
                );
                break;
            case "dropdown":
                isValidInput = input.value !== "";
                break;
            default:
                isValidInput = true;
                break;
        }

        if (!isValidInput) {
            isValid = false;
            const inputField = input.closest(".field");
            const errorField = inputField.querySelector(".error.message");
            errorField.innerText = validationMessages[type];
        }
    });

    return isValid;
}

// JS con jQuery y Semantic UI
$(".ui.form").submit(function (event) {
    var form = $(this);
    var inputs = form.find("input");

    // Recorrer cada input
    inputs.each(function () {
        var input = $(this);
        var type = input.attr("type");
        var name = input.attr("name");
        var value = input.val();

        // Validar según el tipo de dato
        switch (type) {
            case "text":
                if (!/^[A-Za-z\s]+$/.test(value)) {
                    input.closest(".field").addClass("error");
                    input
                        .next(".prompt")
                        .text("Por favor ingrese un nombre válido");
                    event.preventDefault();
                }
                break;
            case "email":
                if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)) {
                    input.closest(".field").addClass("error");
                    input
                        .next(".prompt")
                        .text("Por favor ingrese un correo electrónico válido");
                    event.preventDefault();
                }
                break;
            case "tel":
                if (!/^\d{10}$/.test(value)) {
                    input.closest(".field").addClass("error");
                    input
                        .next(".prompt")
                        .text("Por favor ingrese un número de teléfono válido");
                    event.preventDefault();
                }
                break;
            case "number":
                if (!/^\d+$/.test(value)) {
                    input.closest(".field").addClass("error");
                    input
                        .next(".prompt")
                        .text("Por favor ingrese un número entero válido");
                    event.preventDefault();
                }
                break;
            case "date":
                if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) {
                    input.closest(".field").addClass("error");
                    input
                        .next(".prompt")
                        .text("Por favor ingrese una fecha válida");
                    event.preventDefault();
                }
                break;
            // Agregar más casos según los tipos de dato que se necesiten validar
            default:
                break;
        }
    });
});

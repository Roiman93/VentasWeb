/* inicializamos el calendario cuando termine de cargar todo el html */
document.addEventListener("DOMContentLoaded", function () {
	calendario();
});

/* consulta y muestra la agenda con las citas */
async function calendario() {
	const $filter = obtain("filter_billing");

	const datos = new FormData();
	datos.append("name", "1");

	try {
		/* Petición hacia la api */
		const url = "http://ventasweb.local/api/get_calendar";
		const respuesta = await fetch(url, {
			method: "POST",
			body: datos,
		});
		const data = await respuesta.json();
		console.log(data);

		// Obtén la lista de resultados
		const resultados = data.resultado;

		// Crea un array para guardar los eventos
		const eventos = [];

		// Itera por cada resultado y crea un evento
		resultados.forEach((resultado) => {
			const evento = {
				id: resultado.id,
				title: resultado.Paciente,
				start: resultado.fecha,
				description: resultado.observacion,
			};

			eventos.push(evento);
		});

		const calendarEl = document.getElementById("calendar");

		const calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: "prev,next today",
				center: "title",
				right: "dayGridMonth,timeGridWeek,timeGridDay",
			},
			locale: "es",
			contentHeight: "auto",
			navLinks: true,
			selectable: false,
			selectMirror: true,
			select: function (arg) {
				var title = prompt("Event Title:");
				if (title) {
					calendar.addEvent({
						title: title,
						start: arg.start,
						end: arg.end,
						allDay: arg.allDay,
					});
				}
				calendar.unselect();
			},
			eventDidMount: function (info) {
				const eventElement = info.el;
				const popupContent = `
				  <div class="ui card">
					<div class="content">
					  <div class="header">${info.event.title}</div>
					  <div class="meta">${info.event.start.toLocaleString()}</div>
					  <div class="description">${info.event.extendedProps.description}</div>
					</div>
				  </div>`;
				$(eventElement).popup({
					html: popupContent, // indicamos que el contenido es HTML
					variation: "wide",
					position: "top center",
					on: "click",
				});
				$(eventElement).popup("show");
			},

			editable: true,
			dayMaxEvents: true,
			events: eventos,
		});

		calendar.render();
	} catch (error) {
		console.log("nada");
	}
}

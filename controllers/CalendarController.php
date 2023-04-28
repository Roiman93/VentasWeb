<?php

namespace Controllers;

header("Access-Control-Allow-Origin: *");
use MVC\Router;
use Model\Model_calendar;
class CalendarController
{
	public static function index(Router $router)
	{
		// $events = [
		// 	[
		// 		"title" => "Evento 1",
		// 		"start" => "2023-04-28T10:00:00",
		// 		"end" => "2023-04-28T12:00:00",
		// 		"backgroundColor" => "#FF5733",
		// 		"borderColor" => "#FF5733",
		// 	],
		// 	[
		// 		"title" => "Evento 2",
		// 		"start" => "2023-04-29T14:00:00",
		// 		"end" => "2023-04-29T16:00:00",
		// 		"backgroundColor" => "#9B59B6",
		// 		"borderColor" => "#9B59B6",
		// 	],
		// ];

		session_start();
		isAdmin();

		// $fullCalendar = WidgetsFullCalendarWidget::widget([
		// 	"options" => [
		// 		"id" => "fullCalendar",
		// 	],
		// 	"clientOptions" => [
		// 		"defaultView" => "month",
		// 		"header" => [
		// 			"left" => "prev,next today",
		// 			"center" => "title",
		// 			"right" => "month,agendaWeek,agendaDay",
		// 		],
		// 		"editable" => true,
		// 		"eventLimit" => true,
		// 		"events" => $events,
		// 	],
		// ]);

		$router->render("pages/calendar", [
			"script" => "<script src='build/js/index.global.js'></script>",
			"script_es" => '<script type="text/javascript" src="build/js/es.global.js"></script>',
			"script_2" => '<script type="text/javascript" src="build/js/Calendar.js"></script>',
		]);
	}

	public static function seach()
	{
		$result = Model_calendar::seach();

		header("Content-Type: application/json");
		echo json_encode(["resultado" => $result]);
		exit();
	}
}

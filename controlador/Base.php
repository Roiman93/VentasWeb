<?php 
abstract class date{

	
	function fechaLarga(){
		$ds = "";
		 switch(date("N")){
		 	case 1 : $ds = "Lunes";break;
		 	case 2 : $ds = "Martes";break;
		 	case 3 : $ds = "Miercoles";break;
		 	case 4 : $ds = "Jueves";break;
		 	case 5 : $ds = "Viernes";break;
		 	case 6 : $ds = "Sabado";break;
		 	case 7 : $ds = "Domingo";break;
		 }

		 $mes = "";

		 switch (date("n")){
		 	case 1 : $mes = "Enero"; break;
		 	case 2 : $mes = "Febrero"; break;
		 	case 3 : $mes = "Marzo"; break;
		 	case 4 : $mes = "Abril"; break;
		 	case 5 : $mes = "Mayo"; break;
		 	case 6 : $mes = "Junio"; break;
		 	case 7 : $mes = "Julio"; break;
		 	case 8 : $mes = "Agosto"; break;
		 	case 9 : $mes = "Septiembre"; break;
		 	case 10 : $mes = "Octubre"; break;
		 	case 11 : $mes = "Noviembre"; break;
		 	case 12 : $mes = "Diciembre"; break;
		 }
		 $x =  $ds." ".date("j")." de ".$mes." del ".date("Y");
		 
		 return $x;
	}



	function logAcceso(){
		$mod = new Conexion();
		$mod->logAcceso();
	}	


	function redireccionar($url){
		header('location:?opcion='.$url);
	}

	function hidden(){
		$modelo = $_POST['Modelo']; //Contenido
		$opcion = $_POST['opcion']; //addContenido
		$mod = new $modelo();	
		$mod->$opcion();
	}

}

?>
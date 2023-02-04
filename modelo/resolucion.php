
<?php
class Resolucion extends Conexion {

	// eliminar

	function eliminar(){

		$id = $_GET['edit'];
		$sql = "DELETE FROM configuracion WHERE id_config = $id";
		$this->consultasDBX($sql);
		
		$_SESSION['error'] = "Configuracion Eliminada";

	}


   // consultas 
   
   function Get_Resolucion(){
	$sql =  "SELECT * FROM prefijos";
	$x = $this->consultasDB($sql);
	return $x;
   }

   function Get_id(){

    $id = $_GET['edit'];
	$sql =  "SELECT * FROM prefijos where id = $id";
	$x = $this->consultasDB($sql);
	return $x;
    
   }

   function Activar_Resolucion(){
	   
    $goto='?opcion=Resolucion';
    $id = $_GET['edit'];
	$sql =  "SELECT * FROM prefijos where id = $id";
	$this->consultasDBX($sql);
	$this->redireccionGoto($goto);

   }

}


?>
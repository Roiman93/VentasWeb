<?php
class Configuracion extends Conexion {



  function guardar(){
        $dat=$this->contar_filas();
		$goto = $_POST['goto'];
		$nit = $_POST['nit'];
		$nombre = $_POST['nombre'];
		$dir = $_POST['direccion'];
		$tel = $_POST['telefono'];
		$email = $_POST['email'];
		$iv = $_POST['iva'];
		


     if(empty($nit) || empty($nombre) || empty($tel) ||empty($dir) ||empty($iv)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";
            	
            } else{

                       if ($dat[0]->numero >= 1) {
                       	 
                       	 $this->redireccionGoto($goto);
				         $_SESSION['msn'] = "No se puede guardar mas de 1 configuracion";

                         }

                         if ($dat[0]->numero == 0 ) {
                         	$sql = "INSERT INTO configuracion (nit, nombre, direccion , telefono, email, iva) VALUES ('$nit','$nombre','$dir','$tel','$email','$iv')";
					         $this->consultasDBX($sql);
					          $this->redireccionGoto($goto);
			                  $_SESSION['msn'] = "Configuracion Almacenada correctamente";
                         }

                         if ($dat[0]->numero <> 0) {
                         	 $this->redireccionGoto($goto);
				         $_SESSION['msn'] = "No se puede guardar mas de 1 configuracion";
                         }

                       

                 }


  }


	function mod_config(){
		
		$goto = $_POST['goto'];
		$nit = $_POST['nit'];
		$nombre = $_POST['nombre'];
		$dir = $_POST['direccion'];
		$tel = $_POST['telefono'];
		$email = $_POST['email'];
		$iv = $_POST['iva'];
		$id_conf=$_POST['id'];
        

         if(empty($nit) || empty($nombre) || empty($tel) ||empty($dir) ||empty($iv)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";
            	
            } else{
           
            $sql1 =  "UPDATE configuracion SET  nit='$nit', nombre = '$nombre', direccion = '$dir',telefono='$tel',email ='$email', iva='$iv' WHERE id_config = $id_conf";
         
          $this->consultasDBX($sql1);
          
		  $this->redireccionGoto($goto);
		  $_SESSION['msn'] = "Actualizacion completa";


          }


	}

	// eliminar

	function eliminar(){

		$id = $_GET['edit'];
		$sql = "DELETE FROM configuracion WHERE id_config = $id";
		$this->consultasDBX($sql);
		
		$_SESSION['error'] = "Configuracion Eliminada";

	}


   // consultas 

   function Get_Prefijo(){
	$sql =  "SELECT n_actual,prefijo FROM prefijos where estado = '1' and tipo_documento='1'";
	$x = $this->consultasDB($sql);
	return $x;
    }

	function get_config(){
		$sql = "SELECT * FROM configuracion";
		$x = $this->consultasDB($sql);
		return $x;
	}

    
    function getConfig(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM configuracion c WHERE c.id_config = $id";
		$x = $this->consultasDB($sql);
		return $x;
	}


	function contar_filas(){

		$sql = "SELECT COUNT(*) AS 'numero' FROM configuracion";
		$y = $this->consultasDB($sql);
        
        
        return $y;

	}


	function ventas_dia(){

		 setlocale(LC_ALL,"es_ES");
     $x =  date("Y")."-".date("n")."-".date("j");


		$sql = "SELECT IFNULL(SUM(f.totalfactura),0) as total FROM factura f WHERE f.fecha = '$x' and f.estatus= '1'";
		$x = $this->consultasDB($sql);
		return $x;
		
	}


	function num_productos(){
		$sql = "SELECT COUNT(*) AS 'numero' FROM producto ";
		$x = $this->consultasDB($sql);
		return $x;
		
	}


	function num_provedor(){
		$sql = "SELECT COUNT(*) AS 'numero' FROM provedor ";
		$x = $this->consultasDB($sql);
		return $x;
		
	}







}



?>

<?php 

header('Access-Control-Allow-Origin:*');

 class Clientes extends Conexion {

	// gestion de datos guardar,editar,eliminar

      function registro_client(){

		$goto = $_POST['goto'];
		$cc = $_POST['cedula'];
		$nom = $_POST['nombre'];
		$sn = $_POST['seg_nombre'];
		$ap = $_POST['apellido'];
		$sp = $_POST['seg_apellido'];
		

		 if( empty($cc) || empty($nom) || empty($ap) ||empty($sp) ){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";

            }else{
            
		 $sql = "INSERT INTO cliente (cedula,nombre_1,nombre_2,apellido_1,apellido_2)  VALUES ('$cc','$nom','$sn','$ap','$sp')";
		$this->consultasDBX($sql);
		$this->redireccionGoto($goto);
		$_SESSION['msn'] = "Datos Guardados";

         }

	}


	function modregistro_client(){
		
		$goto = $_POST['goto'];
		$cc = $_POST['cedula'];
		$nom = $_POST['nombre'];
		$sn = $_POST['seg_nombre'];
		$ap = $_POST['apellido'];
		$sp = $_POST['seg_apellido'];
		$id=$_POST['id_client'];
        
       


         if( empty($cc) || empty($nom) || empty($ap) ||empty($sp) ){
                   
                $this->redireccionGoto($goto);
			 $_SESSION['msn'] = "llene todos los campos.....";

            }else{

				$sql1 =  "UPDATE cliente SET  cedula='$cc', nombre_1 = '$nom', nombre_2 = '$sn',apellido_1='$ap', apellido_2='$sp' WHERE id_cliente  = $id";

				$this->consultasDBX($sql1);
				$this->redireccionGoto($goto);
				$_SESSION['msn'] = "Datos Actualizados";
            }  

        }







       function dle(){
		$goto = $_POST['goto'];
        	$id = $_GET['edit'];
        	$sql2 = "DELETE FROM cliente WHERE id_cliente = $id";
		$this->consultasDBX($sql2);
		$this->redireccionGoto($goto);
		$_SESSION['error'] = "Datos Eliminados";
	}

	   // Consultas mysql 

	   function getClient_Id(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM cliente c WHERE c.id_cliente = $id";
		$x = $this->consultasDB($sql);
		return $x;
	  }

	  function get_Clientes(){
		$sql = "SELECT * FROM cliente";
		$x = $this->consultasDB($sql);
		return $x;
	  }





 }?>
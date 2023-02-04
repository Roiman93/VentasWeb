<?php
 
 class Provedor extends Conexion{

  

  function registro_prov(){
		$goto = $_POST['goto'];
		$nt = $_POST['nit'];
		$nom = $_POST['nombre'];
		$dir = $_POST['direccion'];
		$tel = $_POST['telefono'];
		

		 if(empty($nt) || empty($nom) || empty($dir) ||empty($tel)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";

            }else{

		 $sql = "INSERT INTO provedor (nit,nombre,direccion,telefono) VALUES ('$nt','$nom','$dir','$tel')";
		$this->consultasDBX($sql);
		
		$this->redireccionGoto($goto);
		$_SESSION['msn'] = "Datos Guardados";

         }

  }


	function modregistro_prov(){
		
		$goto = $_POST['goto'];
		$nt = $_POST['nit'];
		$nom = $_POST['nombre'];
		$dir = $_POST['direccion'];
		$tel = $_POST['telefono'];
		$id=$_POST['id_prov'];
        
       


         if(empty($nt) || empty($nom) || empty($dir) ||empty($tel)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";

            }else{

				$sql = "INSERT INTO provedor (nit,nombre,direccion,telefono) VALUES ('$nt','$nom','$dir','$tel')";

				$sql1 =  "UPDATE provedor SET  nit='$nt', nombre = '$nom', direccion = '$dir',telefono='$tel' WHERE id_provedor  = $id";

				$this->consultasDBX($sql1);
				$this->redireccionGoto($goto);
				$_SESSION['msn'] = "Datos Actualizados";
            }  

    }


    function eliminar(){

		$id = $_GET['edit'];
		$sql2 = "DELETE FROM provedor WHERE id_provedor = $id";
		$this->consultasDBX($sql2);
		//$this->redireccionGoto($goto);
		$_SESSION['error'] = "Datos Eliminados";

	}



	   // Consultas mysql 

	   function getProve_Id(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM provedor p WHERE p.id_provedor = $id";
		$x = $this->consultasDB($sql);
		return $x;
	  }

	  function get_Provedor(){
		$sql = "SELECT * FROM provedor";
		$x = $this->consultasDB($sql);
		return $x;
	  }
             

 }?>
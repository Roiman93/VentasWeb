<?php 

class Caja extends Conexion {




function registro_cuadre(){

		$goto  = $_POST['goto'];
		$valor = $_POST['txt_total'];
		$idusu = $_POST['txt_id'];
		
		

		 if(empty($valor)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "Realize el cuadre";

            }else{
            
			$sql = "INSERT INTO caja (valor,id_usuario)  VALUES ('$valor','$idusu')";
			$this->consultasDBX($sql);
			$this->redireccionGoto($goto);
			$_SESSION['msn'] = "Datos Guardados";

         }

	}


	function modregistro_client(){
		
		$goto = $_POST['goto'];
		$valor = $_POST['total'];
		$idusu= $_SESSION['ih_id'];
		$id=$_POST['id_caja'];
        
       


          if( empty($valor)){
                   
              $this->redireccionGoto($goto);
				$_SESSION['msn'] = "Selecione el cuadre";

            }else{

				$sql1 =  "UPDATE caja SET  valor='$valor', id_usuario = '$idusu' WHERE id_caja  = $id";

				$this->consultasDBX($sql1);
				$this->redireccionGoto($goto);
				$_SESSION['msn'] = "Datos Actualizados";
            }  

        }







       function dle(){
		$goto = $_POST['goto'];
        	$id = $_GET['edit'];
        	$sql2 = "DELETE FROM caja WHERE id_caja = $id";
		$this->consultasDBX($sql2);
		$_SESSION['error'] = "Datos Eliminados";
		$this->redireccionGoto($goto);
		
	}

	   // Consultas mysql 

	   function getClient_Id(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM caja c WHERE c.id_caja = $id";
		$x = $this->consultasDB($sql);
		return $x;
	  }

	  function get_Caja(){
		$sql = "SELECT u.nombre as usuario,c.fecha,c.valor,c.id_caja FROM caja c INNER JOIN usuario u  WHERE c.id_usuario = u.id_usuario ";
		$x = $this->consultasDB($sql);
		return $x;
	  }









}


 ?>
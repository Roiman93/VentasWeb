<?php 
header('Access-Control-Allow-Origin:*');
class Producto extends Conexion {


// gestion de datos guardar,editar,eliminar

      function registro_product(){

		$goto = $_POST['goto'];
		$cod = $_POST['codigo'];
		$nom = $_POST['nombre'];
		$pc = $_POST['precio_c'];
		$pv = $_POST['precio_v'];
		$tp = $_POST['tipo'];
		

		 if( empty($cod) || empty($nom) || empty($pv) ||empty($tp) ){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";

            }else{
            
		 $sql = "INSERT INTO producto (codigo,nombre,precio_compra,precio_venta,tipo)  VALUES ('$cod','$nom','$pc','$pv','$tp')";
		$this->consultasDBX($sql);
		$this->redireccionGoto($goto);
		$_SESSION['msn'] = "Datos Guardados";

         }

	}


	function modregistro_product(){
		
		$goto = $_POST['goto'];
		$cod = $_POST['codigo'];
		$nom = $_POST['nombre'];
		$pc = $_POST['precio_c'];
		$pv = $_POST['precio_v'];
		$tp = $_POST['tipo'];
		$id=$_POST['id_product'];
        
       


          if( empty($cod) || empty($nom) || empty($pv) ||empty($tp) ){
                   
                $this->redireccionGoto($goto);
			 $_SESSION['msn'] = "llene todos los campos.....";

            }else{

				$sql1 =  "UPDATE producto SET  codigo='$cod', nombre = '$nom', precio_compra = '$pc', precio_venta='$pv', tipo ='$tp' WHERE id_producto  = $id";

				$this->consultasDBX($sql1);
				$this->redireccionGoto($goto);
				$_SESSION['msn'] = "Datos Actualizados";
            }  

        }







       function eliminar(){
		$goto = $_POST['goto'];
        $id = $_GET['edit'];
        $sql2 = "DELETE FROM producto WHERE id_producto = $id";
		$this->consultasDBX($sql2);
		$this->redireccionGoto($goto);
		$_SESSION['error'] = "Datos Eliminados";
	    }

	   // Consultas mysql 

	   function getProduct_Id(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM producto p WHERE p.id_producto = $id";
		$x = $this->consultasDB($sql);
		return $x;
	  }

	  function get_Product(){
		$sql = "SELECT * FROM producto";
		$x = $this->consultasDB($sql);
		return $x;
	  }





}?>
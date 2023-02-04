<?php
   header('Access-Control-Allow-Origin:*');
    

   $host = 'localhost';
   $user = 'root';
   $password = '';
   $db = 'ventas_ms';

   $conexion = @mysqli_connect($host,$user,$password,$db);

   if(!$conexion){
	   echo"error en la conexion";
   }

    

    class Conexion {

            function conexDB(){
			//return new mysqli('localhost','o143366_admin','93101102309Admin.','o143366_sist');
			return new mysqli('localhost','root','','ventas_ms');
		}

		function consultasDB($sql){
			$dato = array();
			$cn = $this->conexDB();
			$raw = $cn->query($sql);
			while($x = $raw->fetch_object()){
				$dato[] = $x;
			}
			return $dato;
		}

		function consultasDBX($sql){
			$dato = array();
			$cn = $this->conexDB();
			$raw = $cn->query($sql);
		}

		function redireccionGoto($x){
			header("location:".$x);
		}

		function logAcceso(){

			$user = $_POST['usuario'];
			$pass = $_POST['pass'];

			$sql = "SELECT * FROM usuario where email LIKE '$user' and password LIKE md5('$pass')";
			$cn = $this->conexDB();
			$raw = $cn->query($sql);
			if($raw->num_rows > 0){
				$dato = $raw->fetch_object();
				$_SESSION['ih_id'] = $dato->id_usuario;
				$_SESSION['ih_email'] = $dato->email;
				$_SESSION['ih_nombre'] = $dato->nombre;
				$_SESSION['ih_tipo'] = $dato->id_tipo;
				$this->redireccionGoto('?opcion=inicio');
				

			}else{
				//conteo de errores...
				$_SESSION['conte'] = $_SESSION['conte']+1;
			    $_SESSION['msn'] = "Error con los datos de acceso";
				$this->redireccionGoto('?opcion=login');
			}
		
		}       

 


	}

	
 ?>
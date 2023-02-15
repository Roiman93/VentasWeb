<?php 

class Usuario extends Conexion{



	// manejo de datos 

	function registro(){
		$goto = $_POST['goto'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$identificacion = $_POST['identificacion'];
		$email = $_POST['email'];
		$idt = $_POST['id_tipo'];
		
		

		$pass = $this->setPassword();
		$passDB = md5($pass);

		$sql = "INSERT INTO usuario (nombre,apellido, identificacion, email, id_tipo, password) VALUES ('$nombre','$apellidos','$identificacion','$email','$idt','$passDB')";
		$this->consultasDBX($sql);
		$this->sendEmail($name, $email, $pass);
		$this->redireccionGoto($goto);
	}




	function guardar(){
		$goto = $_POST['goto'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$identificacion = $_POST['identificacion'];
		$email = $_POST['email'];
		$idt = $_POST['id_tipo'];
		$pas=$_POST['pass'];
		$passDB = md5($pas);

            if(empty($identificacion) || empty($pas) || empty($nombre) ||empty($idt)){
                   
                $this->redireccionGoto($goto);
				$_SESSION['msn'] = "llene todos los campos...";

            }else{

                 $sql = "INSERT INTO usuario (nombre,apellido, identificacion, email, id_tipo, password) VALUES ('$nombre','$apellidos','$identificacion','$email','$idt','$passDB')";
		         $this->consultasDBX($sql);
		          $this->redireccionGoto($goto);
                  $_SESSION['msn'] = "Datos Guardado";

                 }

           
	}



	function modregistro(){
		
		$goto = $_POST['goto'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$identificacion = $_POST['identificacion'];
		$email = $_POST['email'];
		$idt = $_POST['id_tipo'];
		$id=$_POST['id_usuario'];
        $pas=$_POST['pass'];
       

          if(empty($pas)){

          	$sql1 =  "UPDATE usuario SET  nombre='$nombre', apellido = '$apellidos', email = '$email',identificacion='$identificacion' WHERE id_usuario = $id";
         
          $this->consultasDBX($sql1);
          $this->sendModEmail($name,$email);
		  $this->redireccionGoto($goto);
		  $_SESSION['msn'] = "Actualizacion de datos Basicos";

          }else {
            $passDB = md5($pas);
            $sql1 =  "UPDATE usuario SET  nombre='$nombre', apellido = '$apellidos', email = '$email',identificacion='$identificacion',password ='$passDB' WHERE id_usuario = $id";
         
          $this->consultasDBX($sql1);
          $this->sendEmail($name, $email, $pas);
		  $this->redireccionGoto($goto);
		  $_SESSION['msn'] = "Actualizacion completa de usuario";





          }





          


	}




	function setPassword(){
		
		$valor = explode(" ","A B C D E F G H I J K L M O P Q R S T U V X W Y Z 0 1 2 3 4 5 6 7 8 9"); 
		$pass = "";
		for($x = 0; $x < 4; $x++){
			$v  = rand(0, 30);
			$pass .= $valor[(int)$v];
		}
		return $pass;
	}

	function sendModEmail($nombre, $email){
		$asunto = "Registro de usuario APRENDIZ";
		$cuerpo = '<!DOCTYPE html>';
		$cuerpo .='<html xmlns="http://www.w3.org/1999/xhtml">';
		$cuerpo .='<head><title>APRENDIZ - Monteria</title></head>';
		$cuerpo .='<body>';
		$cuerpo .=	'<table width="550" border="0" cellpadding="0" cellspacing="0">';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td><img src="https://www.aprendiz.com.co/img/log/logo_email.jpg" width="550" height="78" /></td>';
		$cuerpo .=      '</tr>';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td>';
		$cuerpo .=				'Sr(a) .<b>'.$nombre.'</b> <br/>  Se ha actualizado la informacion correctamente en nuestro portal.<br> Ha recibido los datos de acceso para poder realizar el ingreso al Sistema.<br/><br/>';
		$cuerpo .=				'<b>Datos de Acceso </b><br/>';
		$cuerpo .=				'Email : '.$email.'<br/><br/>';		
		$cuerpo .=			'</td>';
		$cuerpo .=		'<tr/>';
		$cuerpo .= 		'<tr>';
		$cuerpo .= 			'<td> <br/><br/>Mensaje Automatico Enviado desde el portal Web www.aprendiz.com.co <br/>http://www.aprendiz.com.co <br/><br/>';
		$cuerpo .= 				'Develop by ING.Royman Rodriguez <hr/>';
		$cuerpo .= 				'Calle 34 # 5 - 34      Barrio La Ceiba<br/>';
		//$cuerpo .= 				'Telefonos : (094) 839 51 21      Cel : 311 307 76 74<br/>';
		$cuerpo .= 				'E-mail : yenis_romero@aprendiz.com.co<br/>';
		$cuerpo .= 				'Monteria - Cordoba';
		$cuerpo .= 			'</td>';
		$cuerpo .= 		'</tr>';
		$cuerpo .=	'</table>';
		$cuerpo .=	'<hr/>';
		$cuerpo .='</html>';
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		//dirección del remitente
		$headers .= "From: Registro Aprendiz<yenis_romero@aprendiz.com.co>\r\n";
		$headers .= "Reply-To: yenis_romero@aprendiz.com.co\r\n";
		//$headers .= "Cc: \r\n";
		//direcciones que recibirán copia oculta
		$headers .= "Bcc: roiman93lopez@gmail.com\r\n";


		if(mail($email,$asunto,$cuerpo,$headers)){
			$_SESSION['msn'] = "Hemos enviado a su  email ".$email.", en correo con la informacion actualizada...<br/> Si el msn no se visualiza en su bandeja de entrada, favor revisar su correo no deseado.";
		}else{
			$_SESSION['msn'] = "Problemas al enviar los datos....";
		}
	}

	function sendEmail($nombre, $email,$pass){
		$asunto = "Registro de usuario APRENDIZ";
		$cuerpo = '<!DOCTYPE html>';
		$cuerpo .='<html xmlns="http://www.w3.org/1999/xhtml">';
		$cuerpo .='<head><title>APRENDIZ - Monteria</title></head>';
		$cuerpo .='<body>';
		$cuerpo .=	'<table width="550" border="0" cellpadding="0" cellspacing="0">';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td><img src="https://www.aprendiz.com.co/img/log/logo_email.jpg" width="550" height="78" /></td>';
		$cuerpo .=      '</tr>';
		$cuerpo .=		'<tr>';
		$cuerpo .=			'<td>';
		$cuerpo .=				'Sr(a) .<b>'.$nombre.'</b> <br/> Usted se ha registrado correctamente en nuestro portal.<br> Ha recibido los datos de acceso para poder realizar el ingreso al Sistema.<br/><br/>';
		$cuerpo .=				'<b>Datos de Acceso </b><br/>';
		$cuerpo .=				'Email : '.$email.'<br/><br/>';		
		$cuerpo .=				'Password : '.$pass.'<br/><br/>';
		$cuerpo .=			'</td>';
		$cuerpo .=		'<tr/>';
		$cuerpo .= 		'<tr>';
		$cuerpo .= 			'<td> <br/><br/>Mensaje Automatico Enviado desde el portal Web www.aprendiz.com.co  .Res:#'.md5($pass).' <br/>http://www.aprendiz.com.co <br/><br/>';
		$cuerpo .= 				'Develop by ING.Royman Rodriguez <hr/>';
		$cuerpo .= 				'Calle 34 # 5 - 34      Barrio La Ceiba<br/>';
		//$cuerpo .= 				'Telefonos : (094) 839 51 21      Cel : 311 307 76 74<br/>';
		$cuerpo .= 				'E-mail : yenis_romero@aprendiz.com.co<br/>';
		$cuerpo .= 				'Monteria - Cordoba';
		$cuerpo .= 			'</td>';
		$cuerpo .= 		'</tr>';
		$cuerpo .=	'</table>';
		$cuerpo .=	'<hr/>';
		$cuerpo .='</html>';
		
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		//dirección del remitente
		$headers .= "From: Registro Aprendiz<yenis_romero@aprendiz.com.co>\r\n";
		$headers .= "Reply-To: yenis_romero@aprendiz.com.co\r\n";
		//$headers .= "Cc: \r\n";
		//direcciones que recibirán copia oculta
		$headers .= "Bcc: roiman93lopez@gmail.com\r\n";


		if(mail($email,$asunto,$cuerpo,$headers)){
			$_SESSION['msn'] = "Hemos enviado una nueva contraseña a email ".$email.", con los datos de acceso...<br/> Si el msn no se visualiza en su bandeja de entrada, favor revisar su correo no deseado.";
		}else{
			$_SESSION['msn'] = "Problemas al enviar los datos....";
		}
	}

	function eliminar(){

		$id = $_GET['edit'];
		$sql = "DELETE FROM usuario WHERE id_usuario = $id";
		$this->consultasDBX($sql);
		$this->redireccionGoto($goto);
		$_SESSION['error'] = "Usuario Eliminado";

	}

	function getUsuarioId(){
		$id = $_GET['edit'];
		$sql = "SELECT * FROM usuario u WHERE u.id_usuario = $id";
		$x = $this->consultasDB($sql);
		return $x;
	}

	function usu_tipo(){
      
        $sql = "SELECT * FROM usuario u INNER JOIN usuario_tipo t    WHERE u.id_tipo = t.usuario_tipo ";
		$x = $this->consultasDB($sql);
		return $x;

	}





	function tipous(){
		$sql = "SELECT * FROM usuario_tipo";
		$x = $this->consultasDB($sql);
		return $x;
	}

	function allusuario(){
		$sql = "SELECT * FROM usuario";
		$x = $this->consultasDB($sql);
		return $x;
	}

	
	



}	
	
?>
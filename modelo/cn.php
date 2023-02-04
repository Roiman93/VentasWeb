<?php 

   $host = 'localhost';
   $user = 'root';
   $password = '';
   $db = 'ventas_ms';

   $conexion = @mysqli_connect($host,$user,$password,$db);

   if(!$conexion){
	   echo"error en la conexion";
   }
  

 ?>
<?php 

class Facturas extends Conexion{


   // Consultas mysql 

      

      function get_Facturas(){
        $sql = "SELECT f.nofactura,f.fecha,f.totalfactura,f.estatus, u.nombre, u.apellido, c.nombre_1, c.nombre_2, c.apellido_1,c.apellido_2  from factura f INNER JOIN usuario u ON u.id_usuario = f.usuario 
       INNER JOIN cliente c ON c.id_cliente = f.codcliente
       WHERE f.estatus != 10; ";
        $sql_resgistro = $this->consultasDB($sql);
       

        return $sql_resgistro;
      }


      function anular(){
         $nofactura = $_GET['ed'];
        $sql = "CALL anular_factura($nofactura)";
        $this->consultasDBX($sql);
        $this->redireccionGoto($goto);
        $_SESSION['error'] = "factura anulada";
      }



       function buscar_Fact(){

        $no = $_POST['nofactura'];

          

            if (empty($no)) 
            {
                $sql = "SELECT f.nofactura,f.fecha,f.totalfactura,f.estatus, u.nombre, u.apellido, c.nombre_1, c.nombre_2, c.apellido_1,c.apellido_2  from factura f INNER JOIN usuario u ON u.id_usuario = f.usuario 
                INNER JOIN cliente c ON c.id_cliente = f.codcliente
               WHERE f.estatus != 10; ";
               $sql_resgistro = $this->consultasDB($sql); 
               return $sql_resgistro;
               $_SESSION['error'] = "buscar todo";
               
            }else{

               $sql = "SELECT f.nofactura,f.fecha,f.totalfactura,f.estatus, u.nombre, u.apellido, c.nombre_1, c.nombre_2, c.apellido_1,c.apellido_2  from factura f INNER JOIN usuario u ON u.id_usuario = f.usuario 
             INNER JOIN cliente c ON c.id_cliente = f.codcliente
             WHERE f.nofactura = $no ";
             $sql_resgistro = $this->consultasDB($sql);
              return $sql_resgistro;
               $_SESSION['error'] = "una factura";

            }


             
      }










}
?>
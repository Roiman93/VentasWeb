<?php

	include '../modelo/conexion.php';
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['fecha']) || empty($_REQUEST['u']))
	{
		echo "No es posible generar la factura.";
	}else{
		$fecha = $_REQUEST['fecha'];
		$usuario = $_REQUEST['u'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,"SELECT * from configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
			//print_r($configuracion);
		}
        
		$sql="SELECT f.nofactura,f.prefijo,f.numero, DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fecha,DATE_FORMAT(f.fecha, '%H:%i:%s') AS hora,
		f.codcliente,f.estatus,v.nombre AS vendedor,f.totalfactura,cl.cedula,cl.nombre_1,cl.nombre_2,cl.apellido_1,cl.apellido_2
		FROM factura f INNER JOIN usuario v ON f.usuario = v.id_usuario
		INNER JOIN cliente cl ON f.codcliente = cl.id_cliente
		WHERE f.usuario = '$usuario' AND f.estatus != '2' AND 
		Date(f.fecha) = '$fecha' AND Time(f.fecha) <='24:59:54.000'";

		$query = mysqli_query($conexion,$sql);
       
	   $result = mysqli_num_rows($query);


			ob_start();
		    include(dirname('__FILE__').'/caja.php');
		    $html = ob_get_clean();

			// instancia y usa la clase dompdf
			$dompdf = new Dompdf();

			 $dompdf->loadHtml($html);
			 // (Optional) Configurar el tamaño y la orientación del papel
			$dompdf->setPaper('letter', 'portrait');
			// Renderiza el HTML como PDF
			$dompdf->render();
			// Envíe el PDF generado al navegador
			$dompdf->stream('Cuadre_Caja_General'.$fecha.'.pdf',array('Attachment'=>0));
			exit;
		
	}

?>
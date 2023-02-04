<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	// session_start();
	// if(empty($_SESSION['active']))
	// {
	// 	//header('location: ../');
	// }

	include '../modelo/conexion.php';
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,"SELECT * from configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
			//print_r($configuracion);
		}


		$query = mysqli_query($conexion,"SELECT
			f.nofactura,
			DATE_FORMAT(f.fecha, '%d/%m/%Y') AS fecha,
			DATE_FORMAT(f.fecha, '%H:%i:%s') AS hora,
			f.codcliente,
			f.estatus,
			f.prefijo,
			f.numero,
			v.nombre AS vendedor,
			cl.cedula,
			cl.nombre_1,
			cl.nombre_2,
			cl.apellido_1,
			cl.apellido_2
		FROM
			factura f
		INNER JOIN usuario v ON
			f.usuario = v.id_usuario
		INNER JOIN cliente cl ON
			f.codcliente = cl.id_cliente
		WHERE
			f.nofactura = ' $noFactura' AND f.codcliente = '$codCliente' AND f.estatus != 10");
       



		$result = mysqli_num_rows($query);
        //print_r($result);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['nofactura'];

			if($factura['estatus'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conexion," SELECT
				p.nombre,
				p.codigo,
				dt.cantidad,
				dt.precio_venta,
				(dt.cantidad * dt.precio_venta) AS precio_total
			FROM
				factura f
			INNER JOIN detallefactura dt ON
				f.nofactura = dt.nofactura
			INNER JOIN producto p ON
				dt.codproducto = p.id_producto
			WHERE
				f.nofactura = '$no_factura' ");


			$result_detalle = mysqli_num_rows($query_productos);
			//print_r($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instancia y usa la clase dompdf
			$dompdf = new Dompdf();

			 $dompdf->loadHtml($html);
			 // (Optional) Configurar el tamaño y la orientación del papel
			$dompdf->setPaper(array(0,0,595.28,420.94), 'portrait');
			// Renderiza el HTML como PDF
			$dompdf->render();
			// Envíe el PDF generado al navegador
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>
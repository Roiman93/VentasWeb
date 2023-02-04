<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$tl_sniva   = 0;
	$total 		= 0;
// print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura Compra</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/logo.png">
				</div>
			</td>
			<td class="info_empresa">
				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
				 ?>
				<div>
					<span class="h2"><?php echo strtoupper($configuracion['nombre']); ?></span>
					<p>Razon Social: <?php echo $configuracion['nombre']; ?></p>
					<p>Dirección: <?php echo $configuracion['direccion']; ?></p>
					<p>Nit: <?php echo $configuracion['nit']; ?></p>
					<p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
					<p>Email: <?php echo $configuracion['email']; ?></p>
				</div>
				<?php
					}
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura de Compra</span>
					<p>No. Factura: <strong><?php echo $factura['numero']; ?></strong></p>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Datos del Proveedor</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Nit:</label><p><?php echo $factura['nit']."-".$factura['dg']; ?></p></td>
							<td><label>Razon Social:</label> <p><?php echo $factura['nombre']; ?></p></td>
							
						</tr>
						<tr>
							
							<td><label>Direccion:</label> <p><?php echo $factura['direccion']; ?></p></td>
							<td><label>Telefono:</label> <p><?php echo $factura['telefono']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<span class="h3">Detalle</span>

	<table id="factura_detalle">
			<thead>
				<tr>
				    <th width="50px">Codigo</th>
					<th class="textleft">Descripción</th>
					<th class="textcenter" width="50px">Cant.</th>
					<th class="textcenter" width="125px">Precio Unitario.</th>
					<th class="textcenter" width="125px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
			 ?>
				<tr>
					<td class="textcenter"><?php echo $row['codigo']; ?></td>
					<td><?php echo $row['nombre']; ?></td>
					<td class="textcenter"><?php echo $row['cantidad']; ?></td>
					<td class="textcenter"><?php echo ' $'.number_format($row['precio_compra']); ?></td>
					<td class="textcenter"><?php echo ' $'.number_format($row['precio_total']); ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

				$impuesto 	= round($subtotal * ($iva / 100), 2);
				$tl_sniva 	= round($subtotal - $impuesto,2 );
				$total 		= round($tl_sniva + $impuesto,2);
			?>
			</tbody>
			<tfoot id="detalle_totales" style="float:right; width:500px; padding: 5px;">
			
				<tr>
					<td colspan="4"  class="textright"><span>SUBTOTAL: </span></td>
					<td  class="textcenter"><span><?php echo ' $'.number_format($tl_sniva); ?></span></td>
				</tr>
				<tr>
					<td colspan="4" class="textright"><span>IVA (<?php echo $iva; ?> %):  </span></td>
					<td class="textcenter"><span><?php echo ' $'.number_format($impuesto); ?></span></td>
				</tr>
				<tr>
					<td colspan="4" class="textright"><span>TOTAL: </span></td>
					<td class="textcenter"><span><?php echo ' $'.number_format($total); ?></span></td>
				</tr>
		   </tfoot>
	</table>
	<div>
		<p class="nota">Verifique la informacion ingresada, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡!</h4>
	</div>

</div>

</body>
</html>